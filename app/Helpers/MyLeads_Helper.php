<?php
use App\Services\DataRegistry;

/**
 * Created by PhpStorm.
 * User: Jazib Javed
 * Date: 04/05/2020
 * Time: 11:51 PM
 *
 * Class Created by Jaz
 */
class MyLeads_Helper{
    private $data;
    private $redis;
    public function __construct() {
        if(getenv('APP_ENV') != config('app.env_local')) {
            $this->redis = new Redis();
            $this->redis->connect(getenv('REDIS_HOST'), getenv('REDIS_PORT'));
        }
    }

    public static function getInstance(){
        static $instance = null;
        if ($instance === null) {
            $instance = new MyLeads_Helper();
        }
        return $instance;
    }

    /**
     * This function provides the lead_content data from key-db
     *
     * @param string $redisKey - redisKey is the combination of client_id - leadpop_client_id - domain_id e.g. 3111-16135-251658
     * @return array
     */
    public function getMyLeadsKeyDB($client_id, $leadpop_id, $leadpop_version_seq, $filters = array(), $export_all=false) {
        $default = array("search"=>"", "page"=>1, "letter"=>"all", "sortby"=>"desc", "result_per_page_val"=>10);
        $filters = array_merge( $default, $filters );

        $redisKey = "lead-content-".$client_id."-".$leadpop_id."-".$leadpop_version_seq;
        $lead_data = array("data-src"=>"keydb", "newleads"=>0, "allkey"=>array(), "total"=>0, "totalleads"=>0, "data"=>array());

        $allkey = array();
        $lead_content = array();

        if(getenv('APP_ENV') == config('app.env_local')) {
            $this->data = LP_Helper::getInstance()->getLeadsFromDB($redisKey);
        } else {
            $this->data = $this->redis->get($redisKey);
        }

        if ($this->data === false) {
            //$lead_content[] = ['id'=>0, 'firstname'=>"", 'lastname'=>"", 'email'=>"", 'date_completed'=>"", 'opened'=>1, 'unique_key'=>'', 'phone'=>'', 'address'=>''];
        }
        else {
            $tmp = unserialize($this->data);
            $newleadsCounter = 0;
            $totalCounter = 0;
            if($tmp){
                foreach($tmp as $row){
                    list($id, $firstname, $lastname, $email, $date_completed, $opened, $unique_key, $phone, $address) = explode("~", $row);

                    // if letter fillter is passed then look for matching result or skip row
                    if($filters["letter"] != "" && $filters["letter"] != "all"){
                        if(substr(strtolower($firstname), 0, 1) != strtolower($filters["letter"]) && substr(strtolower($lastname), 0, 1) != strtolower($filters["letter"])){
                            continue;
                        }
                    }

                    // if Search parameter is not blank then look for specific search term else continue to next record
                    if($filters["search"] != ""){
                        if (stripos($firstname, $filters["search"]) === false && stripos($lastname, $filters["search"]) === false ) {
                            continue;
                        }
                    }


                    //for Date filter
                    $datecompleted = new \DateTime($date_completed);
                    $date_start = new \DateTime($filters['myleadstart'] );
                    $date_end = new \DateTime($filters['myleadend'] );
                    if( $filters['myleadstart'] != "" && $datecompleted->format("Y-m-d") < $date_start->format("Y-m-d") ){
                        continue;
                    }
                    else if( $filters['myleadend'] != "" && $datecompleted->format("Y-m-d") > $date_end->format("Y-m-d") ){
                        continue;
                    }

                    # $filters['myleadstart'] <= $datecompleted->format("Y-m-d")


                    $totalCounter++;
                    //$lead_content[$id] = ['id'=>$id, 'firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'date_completed'=>$date_completed, 'datecompleted'=>$datecompleted->format("M d, Y"), 'opened'=>$opened, 'unique_key'=>$unique_key, 'phone'=>$phone, 'address'=>$address];
                    $row = ['id'=>$id, 'firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'date_completed'=>$date_completed, 'datecompleted'=>$datecompleted->format("M d, Y"), 'opened'=>$opened, 'unique_key'=>$unique_key, 'phone'=>$phone, 'address'=>$address];
                    $row = array_map('utf8_encode', $row);
                    $lead_content[$id] = $row;

                    if($opened == "0"){
                        $newleadsCounter++;
                    }

                    if($export_all){
                        array_push($allkey, $id);
                    }
                }

                if($filters["sortby"] == "asc"){
                    ksort($lead_content, SORT_NUMERIC);
                } else {
                    krsort($lead_content, SORT_NUMERIC);
                }
            }

            $lead_data['allkey'] = $allkey;
            $lead_data['newleads'] = format_number($newleadsCounter);
            $lead_data['total'] = $totalCounter;
            $lead_data['totalleads'] = format_number($lead_data['total']);
            $lead_data['data'] = $lead_content;
        }
        if($filters['page'] == 1) {
            $offset = 0;
        }else {
            $offset = (($filters['page']-1)*$filters["result_per_page_val"]);
        }
        $lead_data['offset'] = $offset;
        $lead_data['data'] = array_slice($lead_content, $offset, $filters["result_per_page_val"]);
        return $lead_data;
    }


    public function updateLeadContentKeyDb($client_id, $leadpop_id, $leadpop_version_seq, $content_id){
        $redisKey = "lead-content-".$client_id."-".$leadpop_id."-".$leadpop_version_seq;

        $this->data = $this->redis->get($redisKey);
        if ($this->data === false) {
           //Nothing here
        }
        else {
            $tmp = unserialize($this->data);
            foreach($tmp as $row){
                // row = id~firstname~lastname~email~date_completed~opened~unique_key~phone~address
                $cols = explode("~", $row);

                if($cols[0] == $content_id){
                    $cols[5] = 1;
                    $lead_content = str_replace($row, implode("~", $cols), $this->data);
                    $this->redis->set($redisKey, $lead_content);
                }
            }
        }
    }


    public function changeRedisKey($client_id, $leadpop_id, $leadpop_version_seq, $new_leadpop_id){
        $redisKey = "lead-content-".$client_id."-".$leadpop_id."-".$leadpop_version_seq;
        $lead_content = $this->redis->get($redisKey);

        // Register New Key
        $newRedisKey = "lead-content-".$client_id."-".$new_leadpop_id."-".$leadpop_version_seq;
        $this->redis->set($newRedisKey, $lead_content);

        // Delete Old Key
        $this->redis->del($redisKey);
    }

    /**
     * update lead in radis after delete/read lead
     * @param $funnelinfo
     * @param $counter
     */
    public function updateDashboardLead($funnelinfo,$counter){

        $redisKey = Stats_Helper::getInstance()->getRedisKey($funnelinfo);
        $this->data = $this->redis->get($redisKey);
        if ($this->data === false) {
            //Nothing here
        }
        else {
            $tmp = unserialize($this->data);
            if(isset($tmp["defaults"]) and !empty($tmp["defaults"])) {
                $stats = explode("-", $tmp["defaults"]);

                if(isset($stats[0])) {
                    $stats[0] = $counter;
                    $tmp['defaults'] = implode('-', $stats);
                    $data = serialize($tmp);
                    $this->redis->set($redisKey, $data);
                }
            }
        }
    }

    /**
     * update lead content after delete lead
     * @param $funnelinfo
     * @param $lead_content_id
     */
    public function updateDeleteLeadContent($funnelinfo,$lead_content_id){
        $redisKey = "lead-content-".$funnelinfo['client_id']."-".$funnelinfo['leadpop_id']."-".$funnelinfo['leadpop_version_seq'];
        $this->data = $this->redis->get($redisKey);
        if ($this->data === false) {
            //Nothing here
        }
        else {
            $tmp = unserialize($this->data);
            $searchword = $lead_content_id.'~';
            $matches = array_filter($tmp, function($var) use ($searchword) {
                return preg_match("/\b$searchword\b/i", $var);
            });
            if($matches) {
                $key = array_keys($matches);
                if ($key) {
                    unset($tmp[$key[0]]);
                    $lead_content = serialize($tmp);
                    $this->redis->set($redisKey, $lead_content);
                }
            }
        }
    }

    public function rewriteLeadContent($funnelinfo, $leads){
        $redisKey = "lead-content-".$funnelinfo['client_id']."-".$funnelinfo['leadpop_id']."-".$funnelinfo['leadpop_version_seq'];
        $this->data = $this->redis->get($redisKey);
        $this->redis->set($redisKey, serialize($leads));
    }
}
