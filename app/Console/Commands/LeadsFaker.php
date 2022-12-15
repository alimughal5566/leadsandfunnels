<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use UserStatus;

class LeadsFaker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faker:leads';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Generate Fake Leads & Stats in database.';

    /** @var  \App\Services\DbService $db */
    private $db;

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

            $client_id = $this->ask("Client ID (Required)");
            if($client_id == "" || $client_id == null){
                $this->error("Client ID is required");
                exit;
            }

            $today = new \DateTime();
            $leads_since = $this->ask("Enter date since you want leads (Format: yyyy-mm-dd) if its blank then CURRENT DATE will be used");
            if($leads_since == "" || $leads_since == null){
                $input_date = new \DateTime();
            }
            else{
                $input_date = new \DateTime($leads_since);

                if($today->format("Y-m-d") < $input_date->format("Y-m-d")) {
                    $this->error("Future date is invalid");
                    exit;
                }
            }

            $lead_dates = array();
            $interval = $input_date->diff($today);
            for($i=0; $i<=$interval->format('%a'); $i++){
                $lead_dates[] = $input_date->format('Y-m-d');
                $input_date->modify('+1 day');
            }

            $funnel_url = $this->ask("Enter Funnel URL if you want to add stats against a particular funnel (optional)");

            if($funnel_url != ""){
                foreach($lead_dates as $date){
                    $num_of_leads = rand(2,10);
                    $this->_fill_funnel_leads($client_id, $funnel_url, $num_of_leads, $date);
                }
            }
            else{
                $funnels = DB::table("clients_funnels_domains")->select("*")->where('client_id', '=', $client_id)->get();
                if($funnels){
                    foreach($funnels as $i=>$funnel){
                        $funnel_url = $funnel->subdomain_name.".".$funnel->top_level_domain;

                        foreach($lead_dates as $date) {
                            $num_of_leads = rand(2,10);
                            $this->_fill_funnel_leads($client_id, $funnel_url, $num_of_leads, $date);
                        }
                    }
                }
            }

        }
        catch (\Exception $ex){
            $this->error($ex->getMessage());
            exit;
        }

		$time_end = microtime(true);
		$execution_time = ($time_end - $time_start)/60;
        \Log::channel('leads-faker')->info('');
		$this->comment("Total Execution Time: ".$execution_time." Mins");
	}


	private function _fill_funnel_leads($client_id, $funnel_url, $num_of_leads, $date){
	    $sql = "select * from clients_funnels_domains where client_id = ".$client_id." AND CONCAT(subdomain_name,'.',top_level_domain) = '" . $funnel_url . "' LIMIT 1";
        $resultSet = $this->db->fetchRow($sql);
        if($resultSet){
            $sql = "SELECT * FROM lead_content WHERE leadpop_version_id = ".$resultSet['leadpop_version_id']." AND leadpop_version_seq = ".$resultSet['leadpop_version_seq']." ORDER BY RAND() LIMIT ".$num_of_leads;
            # echo $sql."\n";
            $resultSet2 = $this->db->fetchAll($sql);
            if($resultSet2){
                foreach ($resultSet2 as $k=>$info){
                    $this->info("Generating >> [".$date."] Generating Leads ".$num_of_leads." for ".$funnel_url);

                    $this->_save_lead($info, $client_id, $resultSet['leadpop_version_seq'], $date);
                    $this->_update_stats($info, $client_id, $resultSet['leadpop_version_seq'], $date, $resultSet['clients_domain_id']);

                    $this->info("ADDED >> [".$date."] ".$num_of_leads." Leads ");
                }

                \Log::channel('leads-faker')->info('[' . $funnel_url . '] '.$date.' '.$num_of_leads.' Leads added.');
            }
            else{
                $this->error("[ No Content ] >> ". $sql);
            }
        }
        else{
            $this->error($funnel_url." not found in clients_funnels_domains....");
        }
    }

    private function _save_lead($lead, $client_id, $leadpop_version_seq, $date){
	    $firstname = array("Neomi","Merilyn","Errol","Margot","Natividad","Charity","Thersa","Jerry","Lady","Milagros","Elanor","Le","Lindsey","Annalee","Sherrie","Katrice","Hiedi","Yukiko","Wilma","Debbie","Tyisha","Almeta","Julia","Audrey","Wen","Elwanda","Coleman","Dick","Hank","Lorriane","Leeann","Na","Fredericka","Myles","Chantell","Nobuko","Willian","Marva","Susann","Kennith","Fransisca","Merry","Booker","Tamiko","Gigi","Renay","Trenton","Scotty","Amado","Layla");
	    $lastname = array("Val","Gustavo","Rudy","Marty","Buddy","Caleb","Joaquin","Grant","Morgan","Esteban","Jefferey","Damian","Shelton","Micah","Rodolfo","Gilbert","Stanley","Robt","Deangelo","Rey","Jasper","Roger","Javier","Salvatore","Ivan","Rusty","Darwin","Wm","Hayden","Aaron","Wiley","Houston","Marlin","Cornell","Carol","Jan","Allan","Gino","Irvin","Reed","Numbers","Teddy","Neal","Buster","Derek","Kenny","Hilario","Chi","Antonio","Roscoe");

        $first_name = $firstname[array_rand($firstname,1)];
        $last_name = $lastname[array_rand($lastname,1)];
        $email = str_replace(" ", "", strtolower($first_name."_".$last_name)."@test-leads.com");
        $phone = "(111) ".rand(111,999)."-".rand(3201,9999);

        unset($lead['id']);

        $lead['client_id'] = $client_id;
        $lead['leadpop_version_seq'] = $leadpop_version_seq;
        $lead['opened'] = 0;
        $lead['deleted'] = 0;

        $lead['email'] = $email;
        $lead['firstname'] = $first_name;
        $lead['lastname'] = $last_name;
        $lead['phone'] = $phone;
        $lead['unique_key'] = "111-".substr($lead['unique_key'], 4);
        $lead['date_completed'] = $date . " 00:00:00";

        $q1 = array_search("First Name", $lead,true);
        if(!$q1) $q1 = array_search("First Name ", $lead,true);
        $a1 = str_replace("q", "a", $q1);
        if($a1 != "") $lead[$a1] = $first_name;

        $q2 = array_search("Last Name", $lead,true);
        if(!$q2) $q2 = array_search("Last Name ", $lead,true);
        $a2 = str_replace("q", "a", $q2);
        if($a2 != "") $lead[$a2] = $last_name;

        $q3 = array_search("Primary Email", $lead,true);
        if(!$q3) $q3 = array_search("Primary Email ", $lead,true);
        $a3 = str_replace("q", "a", $q3);
        if($a3 != "") $lead[$a3] = $email;

        $q4 = array_search("Primary Phone", $lead,true);
        if(!$q4) $q4 = array_search("Primary Phone ", $lead,true);
        $a4 = str_replace("q", "a", $q4);
        if($a4 != "") $lead[$a4] = $phone;

        DB::table('lead_content')->insert($lead);

    }

    private function _update_stats($lead, $client_id, $leadpop_version_seq, $date, $domain_id){
        $sql = "select * from lead_stats where client_id = ".$client_id." AND leadpop_version_id = ".$lead['leadpop_version_id']."  AND leadpop_version_seq = ".$leadpop_version_seq." AND domain_id = ".$domain_id." AND DATE(`date`) = '".$date."' LIMIT 1";
        #echo $sql."\n";
        $resultSet = $this->db->fetchRow($sql);
        if($resultSet){
            // Update
            $info = array();
            $info['desktop_leads'] = $resultSet['desktop_leads'] + 1;
            $info['desktop_visits'] = $resultSet['desktop_visits'] + rand(4,9);

            #print_r($info);
            DB::table('lead_stats')->where('id', $resultSet['id'])->update($info);
        }
        else{
            // Insert
            $sql = "select leadpop_id, id as leadpop_client_id from clients_leadpops where client_id = ".$client_id." AND leadpop_version_id = ".$lead['leadpop_version_id']."  AND leadpop_version_seq = ".$leadpop_version_seq." LIMIT 1";
            #echo $sql."\n";
            $clients_leadpops = $this->db->fetchRow($sql);

            $info = array();
            $info["client_id"] = $client_id;

            $info["leadpop_vertical_id"] = $lead['leadpop_vertical_id'];
            $info["leadpop_vertical_sub_id"] = $lead['leadpop_vertical_sub_id'];
            $info["leadpop_template_id"] = $lead['leadpop_template_id'];
            $info["leadpop_version_id"] = $lead['leadpop_version_id'];
            $info["leadpop_version_seq"] = $leadpop_version_seq;
            $info["date"] = $date." 00:00:00";
            $info["desktop_visits"] = rand(4,9);
            $info["desktop_leads"] = 1;

            $info["mobile_leads"] = 0;
            $info["mobile_visits"] = 0;

            $info["leadpop_client_id"] = $clients_leadpops['leadpop_client_id'];
            $info["leadpop_id"] = $clients_leadpops['leadpop_id'];
            $info["domain_id"] = $domain_id;

            DB::table('lead_stats')->insert($info);
        }
    }

}
