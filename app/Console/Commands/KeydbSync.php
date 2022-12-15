<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use UserStatus;

class KeydbSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keydb:sync {action : stats / leads / remove-key}';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Update Stats OR Leads in KeyDB from database records';

    /** @var  \Redis $redis */
    private $redis;

    /** @var  \App\Services\DbService $db */
    private $db;

    private $cmd_options;

	/**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct(){
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
	public function handle(){
		$time_start = microtime(true);

		try{
            $this->db = \App::make('App\Services\DbService');

            if(env('APP_ENV') != config('app.env_local')){
                $this->redis = new \Redis();
                $this->redis->connect(getenv('REDIS_HOST'), getenv('REDIS_PORT'));
            }

            switch ($this->argument('action')) {
                case 'stats':
                    $client_id = $this->ask("Client ID (Required)");
                    if($client_id == "" || $client_id == null){
                        $this->error("Client ID is required");
                        exit;
                    }

                    $leadpop_client_id = $this->ask("leadpop_client_id (Optional)");
                    $domain_id = $this->ask("domain_id (Optional)");

                    $this->syncStats($client_id, $leadpop_client_id, $domain_id);
                    break;
                case 'leads':
                    $client_id = $this->ask("Client ID (Required)");
                    if($client_id == "" || $client_id == null){
                        $this->error("Client ID is required");
                        exit;
                    }

                    $leadpop_id = $this->ask("leadpop_id (Optional)");
                    $leadpop_version_seq = $this->ask("leadpop_version_seq (Optional)");
                    $override = $this->ask("Overwrite existing data (y/n)");
                    if($override == "") $override = "n";
                    else if($override != "y") $override = "n";

                    $this->syncLeadsContent($client_id, $leadpop_id, $leadpop_version_seq, $override);
                    break;
                case 'remove-key':
                    $key = $this->ask("keydb Key (Required)");
                    if($key == "" || $key == null){
                        $this->error("Key is required");
                        exit;
                    }

                    if($this->redis->exists($key)){
                        $this->redis->del($key);
                        $this->comment($key." removed.");
                    }
                    else{
                        $this->error($key." not found.");
                        exit;
                    }
                    break;
                default:
                    break;
            }

            if(env('APP_ENV') != config('app.env_local')) {
                $this->redis->close();
            }
        }
        catch (\RedisException $redisEx){
		    $this->error($redisEx->getMessage());
            exit;
        }
        catch (\Exception $ex){
            $this->error($ex->getMessage());
            exit;
        }

		$time_end = microtime(true);
		$execution_time = ($time_end - $time_start)/60;
		$this->comment("Total Execution Time: ".$execution_time." Mins");
	}

    /**
     * This function will synchronize all the data on keyDB for client from database table lead_stats. so
     * if any of row is missing or not updated it will be sync with Data we have in our database
     *
     * @param $clientId Int
     */
	private function syncStats($client_id, $leadpop_client_id='', $domain_id=''){

        $sql = "select leadpop_client_id, domain_id from lead_stats where client_id = " . $client_id;
        if($leadpop_client_id != "") $sql .= " AND leadpop_client_id = ".$leadpop_client_id;
        if($domain_id != "") $sql .= " AND domain_id = ".$domain_id;
        $sql .= " GROUP BY domain_id ORDER BY domain_id ASC";
        $resultSet = $this->db->fetchAll($sql);
        if($resultSet){
            foreach ($resultSet as $row){
                $this->_updateStatistics($client_id, $row['leadpop_client_id'], $row['domain_id']);
            }
        }
    }

    /**
     * This function will synchronize all the data on keyDB lead_content to keydb
     * if any of row is missing or not updated it will be sync with Data we have in our database
     *
     * @param $clientId Int
     */
    private function syncLeadsContent($client_id, $leadpop_id='', $leadpop_version_seq='', $override='n'){
        $sql = "select id, leadpop_id, leadpop_version_seq from clients_leadpops where client_id = " . $client_id;
        if($leadpop_id != "") $sql .= " AND leadpop_id = ".$leadpop_id;
        if($leadpop_version_seq != "") $sql .= " AND leadpop_version_seq = ".$leadpop_version_seq;
        $sql .= " ORDER BY id ASC";
        $resultSet = $this->db->fetchAll($sql);
        if($resultSet){
            foreach ($resultSet as $row){
                $this->_updateLeadsContent($client_id, $row['leadpop_id'], $row['leadpop_version_seq'], $override);
            }
        }
    }


    private function _updateLeadsContent($client_id, $leadpop_id, $leadpop_version_seq, $override){
        $key = "lead-content-".$client_id."-".$leadpop_id."-".$leadpop_version_seq ;

        $this->info("Looking for key: ".$key);
        $lead_content_id = array();
        $keydb_data = array();

        if($override == 'n'){
            if(env('APP_ENV') != config('app.env_local') && $this->redis->exists($key)){
                // UPDATE Case
                $keydb_data = unserialize($this->redis->get($key));

                // If data is already on keydb then lets skip it so We need Primary Key here to check if row already exist or not.
                // for this we can walk through array to extract PK only out of complete string
                array_walk ($keydb_data, (function ($row, $index) use (&$lead_content_id) {
                    $data = explode("~", $row);
                    array_push($lead_content_id, $data[0]);
                }));
            }
        }

        $s  = " SELECT * FROM  lead_content ";
        $s .= " WHERE client_id = ".$client_id;
        $s .= " and leadpop_id = ".$leadpop_id;
        $s .= " and leadpop_version_seq = ".$leadpop_version_seq;
        $s .= " and deleted = 0";
        if(!empty($lead_content_id)){
            $s .= " and id NOT IN (".implode(",", $lead_content_id).")";
        }
        $s .= " order by date_completed ASC";
        $newdataRec = $this->db->fetchAll($s);

        if($newdataRec){
            $lead_no = 0;
            foreach($newdataRec as $rec2){
                // If id is not redis then add else skip it. -- Else case is very rare case
                if(!in_array($rec2["id"], $lead_content_id)) {
                    $lead_no++;
                    $inner = $rec2["id"] . "~" . $rec2["firstname"] . "~";
                    $inner .= $rec2["lastname"] . "~" . $rec2["email"] . "~";
                    $inner .= $rec2["date_completed"] . "~" . $rec2["opened"] . "~";
                    $address = "";

                    /*
                    for ($i = 1; $i <= 25; $i++) {
                        $qindex = 'q' . $i;
                        if ($rec2[$qindex] != "") {
                            $question = rtrim($rec2[$qindex]);
                            $aindex = 'a' . $i;
                            $answer = $rec2[$aindex];
                            $statecode = "";
                            $city = "";
                            if (stristr($question, 'zip')) {
                                if (!preg_match('/^[0-9]+$/', trim($answer))) {
                                    $ss = "select state,city from zipcodes where city = '" . trim($answer) . "' limit 1 ";
                                } else {
                                    $ss = "select state,city from zipcodes where zipcode = '" . trim($answer) . "' limit 1 ";
                                }

                                $row = $this->db->fetchRow($ss);
                                if ($row) {
                                    $statecode = $row['state'];
                                    $city = $row['city'];
                                    $address = $city . "-" . $statecode . "-" . $answer;
                                }
                                break;
                            }
                        }
                    }
                    */

                    $questions = json_decode($rec2['lead_questions'], 1);
                    $answers = json_decode($rec2['lead_answers'], 1);
                    foreach($questions as $i=>$question){
                        if ($question != "") {
                            $answer = $answers[$i];

                            if(is_array($question)){
                                $question = $question['question'];
                            }

                            $statecode = "";
                            $city = "";
                            if (stristr($question, 'zip')) {

                                if (!preg_match('/^[0-9]+$/', trim($answer))) {
                                    $ss = "select state,city from zipcodes where city = '" . trim($answer) . "' limit 1 ";
                                } else {
                                    $ss = "select state,city from zipcodes where zipcode = '" . trim($answer) . "' limit 1 ";
                                }

                                $row = $this->db->fetchRow($ss);
                                if ($row) {
                                    $statecode = $row['state'];
                                    $city = $row['city'];
                                    $address = $city . "-" . $statecode . "-" . $answer;
                                }
                                break;
                            }
                        }
                    }

                    $inner .= $rec2["unique_key"] . "~" . $rec2["phone"] . "~" . $address;
                    $keydb_data[] = $inner;
                }
            }

            if($keydb_data){
                if(env('APP_ENV') != config('app.env_local')) $this->redis->set($key, serialize($keydb_data));
                $this->comment("[".$key."] Leads: ".$lead_no);
            }
        }
        else{
            // ALL DATA ALREADY SYNC WITH KEYDB - Nothing to do on keyDb";
            $this->comment("No Content found in lead_content for key => ".$key);
        }
    }


    private function _updateStatistics($client_id, $leadpop_client_id, $domain_id){
        //Sync to Redis
        $client_funnel_key = $client_id . "-" . $leadpop_client_id . "-" . $domain_id ;
        $this->info("Looking for key: ".$client_funnel_key);
        $funnelkeys = array();
        $data = array();

        $s = " SELECT * FROM lead_stats WHERE client_id = " . $client_id;
        $s .= " AND leadpop_client_id = " . $leadpop_client_id;
        $s .= " AND domain_id = " . $domain_id;
        $s .= " ORDER BY date ";
        $dataRec = $this->db->fetchAll($s);
        if($dataRec){
            foreach($dataRec as $rec2) {
                if(empty($funnelkeys)) {
                    $funnelkeys = $rec2;
                }
                $inner = $rec2["mobile_visits"] ."-". $rec2["mobile_visits_weekly"]."-".$rec2["mobile_visits_monthly"]."-".$rec2["desktop_visits"]."-";
                $inner .= $rec2["desktop_visits_weekly"]."-".$rec2["desktop_visits_monthly"]."-".$rec2["mobile_leads"]."-";
                $inner .= $rec2["mobile_leads_weekly"]."-".$rec2["mobile_leads_monthly"]."-".$rec2["desktop_leads"]."-".$rec2["desktop_leads_weekly"]."-".$rec2["desktop_leads_monthly"];
                $data[substr($rec2["date"],0,10)] =  $inner;
            }
        }

        // Defaults Statistics
        $newleads = $this->getnew($funnelkeys);
        $totalleads = $this->gettotal($funnelkeys);
        $sunday = $this->sunday($funnelkeys);
        $month = $this->month($funnelkeys);
        $visitors = $this->visitors($funnelkeys);
        $conversion = $this->conversion($funnelkeys);
        $this->info("Updated: ".count($data));
        $this->info("");
        $data["defaults"] =  $newleads."-".$totalleads."-".$sunday."-".$month."-".$visitors."-".$conversion;

        //unset($funnelkeys);
        $this->redis->set($client_funnel_key, serialize($data));
    }

    private function getnew($funnelkeys) {
        $s = "select count(*)  as new_leads ";
        $s .= " from lead_content ";
        $s .= " where client_id = " . $funnelkeys["client_id"];
        $s .= " and leadpop_version_id = " . $funnelkeys["leadpop_version_id"];
        $s .= " and leadpop_version_seq = " . $funnelkeys["leadpop_version_seq"];
        $s .= " and opened = '0' AND deleted = 0 ";
        $dataRec = $this->db->fetchRow($s);
        $dataRec["new_leads"] = (is_null($dataRec["new_leads"]) ? 0 : $dataRec["new_leads"]);
        return $dataRec["new_leads"];
    }

    private function gettotal($funnelkeys) {
        $s = "SELECT client_id, leadpop_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_version_id,";
        $s .= " (SUM(mobile_leads) + SUM(desktop_leads)) AS 'total_leads' ";
        $s .= " FROM lead_stats WHERE client_id = " . $funnelkeys["client_id"];
        $s .= " and leadpop_vertical_id = " . $funnelkeys["leadpop_vertical_id"];
        $s .= " and leadpop_vertical_sub_id = " . $funnelkeys["leadpop_vertical_sub_id"];
        $s .= " and leadpop_version_id = " . $funnelkeys["leadpop_version_id"];
        $s .= " and leadpop_version_seq = " . $funnelkeys["leadpop_version_seq"];
        $s .= " and leadpop_template_id = " . $funnelkeys["leadpop_template_id"];
        $s .= "	GROUP BY client_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_template_id,";
        $s .= " leadpop_version_id, leadpop_version_seq ";
        $dataRec = $this->db->fetchRow($s);
        $dataRec["total_leads"] = (is_null($dataRec["total_leads"]) ? 0 : $dataRec["total_leads"]);
        return $dataRec["total_leads"];
    }

    private function sunday($funnelkeys) {
        $s = "select  client_id, leadpop_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_version_id, leadpop_version_seq, leadpop_template_id, ";
        $s .= " (SUM(mobile_visits) + SUM(desktop_visits)) AS 'weekly_visits' FROM lead_stats ";
        $s .= " WHERE WEEK(`date`) = WEEK(NOW()) AND client_id  = " . $funnelkeys["client_id"];
        $s .= " and leadpop_vertical_id = " . $funnelkeys["leadpop_vertical_id"];
        $s .= " and leadpop_vertical_sub_id = " . $funnelkeys["leadpop_vertical_sub_id"];
        $s .= " and leadpop_version_id = " . $funnelkeys["leadpop_version_id"];
        $s .= " and leadpop_version_seq = " . $funnelkeys["leadpop_version_seq"];
        $s .= " and leadpop_template_id = " . $funnelkeys["leadpop_template_id"];
        $s .= " GROUP BY WEEK(`date`), client_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_template_id, leadpop_version_id, leadpop_version_seq ";
        $dataRec = $this->db->fetchRow($s);
        if(isset($dataRec) && array_key_exists('weekly_visits', $dataRec)){
            $dataRec["weekly_visits"] = (is_null($dataRec["weekly_visits"]) ? 0 : $dataRec["weekly_visits"]);
            return $dataRec["weekly_visits"];
        }
        else{
            return 0;
        }
    }

    private function month($funnelkeys) {
        $s = "SELECT client_id, leadpop_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_version_id, leadpop_version_seq, leadpop_template_id, ";
        $s .= " (SUM(mobile_visits) + SUM(desktop_visits)) AS 'monthly_visits' FROM lead_stats ";
        $s .= " WHERE MONTH(`date`) = MONTH(NOW()) AND client_id  = " . $funnelkeys["client_id"];
        $s .= " and leadpop_vertical_id = " . $funnelkeys["leadpop_vertical_id"];
        $s .= " and leadpop_vertical_sub_id = " . $funnelkeys["leadpop_vertical_sub_id"];
        $s .= " and leadpop_version_id = " . $funnelkeys["leadpop_version_id"];
        $s .= " and leadpop_version_seq = " . $funnelkeys["leadpop_version_seq"];
        $s .= " and leadpop_template_id = " . $funnelkeys["leadpop_template_id"];
        $s .= " GROUP BY MONTH(`date`), client_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_template_id, leadpop_version_id, leadpop_version_seq ";
        $dataRec = $this->db->fetchRow($s);

        if(isset($dataRec) && array_key_exists('monthly_visits', $dataRec)){
            $dataRec["monthly_visits"] = (is_null($dataRec["monthly_visits"]) ? 0 : $dataRec["monthly_visits"]);
            return $dataRec["monthly_visits"];
        }
        else{
            return 0;
        }

    }

    private function visitors($funnelkeys) {
        $s = "SELECT client_id, leadpop_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_version_id, leadpop_version_seq, leadpop_template_id, (SUM(mobile_visits) + SUM(desktop_visits)) AS 'total_visits', (SUM(mobile_leads) + SUM(desktop_leads)) AS 'total_leads', ";
        $s .= " (SUM(mobile_visits) + SUM(desktop_visits)) AS 'total_visits'  FROM lead_stats ";
        $s .= " WHERE client_id  = " . $funnelkeys["client_id"];
        $s .= " and leadpop_vertical_id = " . $funnelkeys["leadpop_vertical_id"];
        $s .= " and leadpop_vertical_sub_id = " . $funnelkeys["leadpop_vertical_sub_id"];
        $s .= " and leadpop_version_id = " . $funnelkeys["leadpop_version_id"];
        $s .= " and leadpop_version_seq = " . $funnelkeys["leadpop_version_seq"];
        $s .= " and leadpop_template_id = " . $funnelkeys["leadpop_template_id"];
        $s .= " GROUP BY client_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_template_id,leadpop_version_id, leadpop_version_seq";
        $dataRec = $this->db->fetchRow($s);
        $dataRec["total_visits"] = (is_null($dataRec["total_visits"]) ? 0 : $dataRec["total_visits"]);
        return $dataRec["total_visits"];
    }

    private function conversion($funnelkeys) {
        $s = "SELECT client_id, leadpop_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_version_id,leadpop_version_seq, leadpop_template_id,";
        $s .= "  ROUND(((SUM(mobile_leads) + SUM(desktop_leads)) / (SUM(mobile_visits) + SUM(desktop_visits))) * 100,2) AS 'conversion_rate'    FROM lead_stats ";
        $s .= " WHERE client_id  = " . $funnelkeys["client_id"];
        $s .= " and leadpop_vertical_id = " . $funnelkeys["leadpop_vertical_id"];
        $s .= " and leadpop_vertical_sub_id = " . $funnelkeys["leadpop_vertical_sub_id"];
        $s .= " and leadpop_version_id = " . $funnelkeys["leadpop_version_id"];
        $s .= " and leadpop_version_seq = " . $funnelkeys["leadpop_version_seq"];
        $s .= " and leadpop_template_id = " . $funnelkeys["leadpop_template_id"];
        $s .= " GROUP BY client_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_template_id,leadpop_version_id, leadpop_version_seq";
        $dataRec = $this->db->fetchRow($s);
        $dataRec["conversion_rate"] = (is_null($dataRec["conversion_rate"]) ? 0 : $dataRec["conversion_rate"]);
        return $dataRec["conversion_rate"];
    }
}
