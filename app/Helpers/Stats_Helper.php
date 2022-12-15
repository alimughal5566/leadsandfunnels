<?php
use App\Services\DataRegistry;

/**
 * Created by PhpStorm.
 * User: Jazib Javed
 * Date: 25/02/2020
 * Time: 11:51 AM
 *
 * Class Created by Bob
 */
class Stats_Helper{
    private $stats;
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
            $instance = new Stats_Helper();
        }
        return $instance;
    }

    /**
     * Formats data to return redis stats key
     *
     * @param array $funnelInfo
     * @return string
     */
    public function getRedisKey($funnelInfo){
        return $funnelInfo['client_id']."-".$funnelInfo['client_leadpop_id']."-".$funnelInfo['domain_id'];
    }

    /**
     * This function provides the all statistics for funnel by redis key.
     *
     * @param string $redisKey - redisKey is the combination of client_id - leadpop_client_id - domain_id e.g. 3111-16135-251658
     * @return int|mixed
     */
    public function getAllStats($redisKey) {
        $this->stats = $this->redis->get($redisKey);
        if ($this->stats === false) {
            return 0;
        }
        else {
            $tmp = unserialize($this->stats);
            ksort($tmp);
            return $tmp;
        }
    }

    /**
     * This function provides the computed statistics for dashboard for each funnel by redis key.
     *
     * @param string $redisKey - redisKey is the combination of client_id - leadpop_client_id - domain_id e.g. 3111-16135-251658
     * @return array
     */
    public function getDefaults($redisKey) {
        $defaults = ['newLeads'=>0, 'totalLeads'=>0, 'sinceSunday'=>0, 'thisMonth'=>0, 'totalVisitors'=>0, 'conversionRate'=>0.0];
        $this->stats = $this->redis->get($redisKey);
        if ($this->stats === false) {
            return $defaults;
        }
        else {
            $tmp = unserialize($this->stats);
            $stats = explode("-", $tmp["defaults"]);

            $today = new DateTime();
            $week_start_date = clone $today;
            if($week_start_date->format("w") > 0)
                $week_start_date->sub(new DateInterval("P".($today->format("w"))."D"));
            $week_end_date = clone $today;
            if($week_end_date->format("w") < 6)
                $week_end_date->add(new DateInterval("P".(6-$today->format("w"))."D"));
            $visits = \Stats_Helper::getInstance()->calculateMontlyVisitsNumber($redisKey, $week_start_date->format("Y/m/d"),$week_end_date->format("Y/m/d"), $tmp);

            return ['newLeads'=>$stats[0], 'totalLeads'=>$stats[1], 'sinceSunday'=>$visits['visits'], 'thisMonth'=>$stats[3], 'totalVisitors'=>$stats[4], 'conversionRate'=>$stats[5]];
            //return ['newLeads'=>$stats[0], 'totalLeads'=>$stats[1], 'sinceSunday'=>$stats[2], 'thisMonth'=>$stats[3], 'totalVisitors'=>$stats[4], 'conversionRate'=>$stats[5]];
        }
    }

    /**
     * This function provides the all statistics for funnel for date range
     *
     * @param string $redisKey - redisKey is the combination of client_id - leadpop_client_id - domain_id e.g. 3111-16135-251658
     * @param string $startDate - Format is YYYY-MM-DD
     * @param string $endDate - Format is YYYY-MM-DD
     * @param array $param - POST Param
     * @return array
     */
    public function getStatsByDateRange($redisKey, $startDate, $endDate = "", $post=array()) {
        $keys = ['mobile_visits', 'mobile_visits_weekly', 'mobile_visits_monthly', 'desktop_visits', 'desktop_visits_weekly', 'desktop_visits_monthly', 'mobile_leads', 'mobile_leads_weekly', 'mobile_leads_monthly', 'desktop_leads', 'desktop_leads_weekly', 'desktop_leads_monthly'];

        if ($endDate == "") {
            $endDate = $startDate ;
        }
        $this->stats = $this->redis->get($redisKey);

        # For debugging hardcoded input
        /*
        $this->stats = serialize(["2021-01-25" => "0-0-0-1-1-1-0-0-0-0-0-0",  "2021-01-26" => "0-0-0-1-2-2-0-0-0-0-0-0",  "2021-03-08" => "0-0-0-1-1-1-0-0-0-0-0-0",  "2021-03-20" => "0-0-0-2-2-3-0-0-0-6-6-6",  "2021-04-01" => "0---64---0---9--",  "2021-04-02" => "0---63---0---10--",  "2021-04-03" => "0---54---0---9--",  "2021-04-04" => "0---31---0---5--",  "2021-04-05" => "0---14---0---2--",  "2021-04-06" => "0---43---0---6--",  "2021-04-07" => "0---63---0---10--",  "2021-04-08" => "0---26---0---4--",  "2021-04-09" => "0---18---0---3--",  "2021-04-10" => "0---72---0---10--",  "2021-04-11" => "0---27---0---5--",  "2021-04-12" => "0---48---0---7--",  "2021-04-13" => "0---36---0---6--",  "2021-04-14" => "0---48---0---7--",  "2021-04-15" => "0---39---0---7--",  "2021-04-16" => "0---26---0---4--",  "2021-04-17" => "0---44---0---7--",  "2021-04-18" => "0---42---0---6--",  "2021-04-19" => "0---63---0---10--",  "2021-04-20" => "0---58---0---10--",  "2021-04-21" => "0---29---0---4--",  "2021-04-22" => "0---43---0---7--",  "2021-04-23" => "0---19---0---4--",  "2021-04-24" => "0---69---0---9--",  "2021-04-25" => "0---19---0---3--",  "2021-04-26" => "0---13---0---2--",  "2021-04-27" => "0---20---0---3--",  "2021-04-28" => "0---55---0---8--",  "2021-04-29" => "0---16---0---2--",  "2021-04-30" => "0---67---0---10--",  "2021-05-01" => "0---10---0---2--",  "2021-05-02" => "0---49---0---8--",  "2021-05-03" => "0---56---0---9--",  "2021-05-04" => "0---20---0---3--",  "2021-05-05" => "0---20---0---3--",  "2021-05-06" => "0---47---0---7--",  "2021-05-07" => "0---40---0---6--",  "2021-05-08" => "0---26---0---4--",  "2021-05-09" => "0---25---0---4--",  "2021-05-10" => "0---42---0---7--",  "2021-05-11" => "0---38---0---6--",  "2021-05-12" => "0---28---0---5--",  "2021-05-13" => "0---33---0---4--",  "2021-05-14" => "0---23---0---3--",  "2021-05-15" => "0---15---0---3--",  "2021-05-16" => "0---54---0---7--",  "2021-05-17" => "0---35---0---6--",  "2021-05-18" => "0---29---0---5--",  "2021-05-19" => "0---20---0---3--",  "2021-05-20" => "0---52---0---10--",  "2021-05-21" => "0---27---0---4--",  "2021-05-22" => "0---40---0---6--",  "2021-05-23" => "0---14---0---2--",  "2021-05-24" => "0---44---0---6--",  "2021-05-25" => "0---74---0---10--",  "2021-05-26" => "0---40---0---7--",  "2021-05-27" => "0---68---0---9--",  "2021-05-28" => "0---42---0---6--",  "2021-05-29" => "0-0-0-18-2-2-0-0-0-2-0-0",  "2021-05-30" => "0-0-0-1-3-3-0-0-0-0-0-0",  "2021-05-31" => "0-0-0-1-1-4-0-0-0-0-0-0",  "defaults" => "344-352-2-1031-2265-15.54"]);
        $startDate = "2021/05/29";
        $endDate = "2021/06/02";
        */

        if ($this->stats === false) {
            return array();
        }
        else {
            $this->stats = unserialize($this->stats);
            ksort($this->stats);
            $range = $this->buildRange($startDate,$endDate);
            if(empty($range)) {
                return array();
            }
            else {
                $currentWeek = $this->calculateWeeklyVisitsNumber($redisKey, $post["start_date"], $post["end_date"], $this->stats);
                $currentMonth = $this->calculateMontlyVisitsNumber($redisKey, $post["start_date"], $post["end_date"], $this->stats);

                $splice = array_intersect_key($this->stats, array_flip($range));
                $statistics = array();
                $i = 0;
                foreach($splice as $date=>$stats_str){
                    $statRow = array();
                    $statRow = array_combine($keys, explode("-", $stats_str));
                    $statRow['date'] = $date;
                    if($statRow['desktop_visits'] > 0){
                        $statRow["desktop_conversion"] = round((($statRow['desktop_leads']/$statRow['desktop_visits']) * 100),2);
                    } else {
                        $statRow["desktop_conversion"] = 0;
                    }

                    if($statRow['mobile_visits'] > 0){
                        $statRow["mobile_conversion"] = round((($statRow['mobile_leads']/$statRow['mobile_visits']) * 100),2);
                    } else {
                        $statRow["mobile_conversion"] = 0;
                    }

                    $statRow["total_visits"] = $statRow['mobile_visits'] + $statRow['desktop_visits'];
                    $statRow["total_leads"] = $statRow['mobile_leads'] + $statRow['desktop_leads'];
                    if($statRow['total_visits'] > 0){
                        $statRow["total_conversion"] = round((($statRow['total_leads']/$statRow['total_visits']) * 100),2);
                    } else {
                        $statRow["total_conversion"] = 0;
                    }

                    //$statRow["total_visits_weekly"] = $this->getWeeklyVisits($redisKey, $date);
                    //$statRow["total_visits_monthly"] = $this->getMonthlyVisits($redisKey, $date);

                    //$default_stats = $this->getDefaults($redisKey);
                    //$statRow["total_visits_weekly"] = $default_stats['sinceSunday'];
                    //$statRow["total_visits_monthly"] = $default_stats['thisMonth'];

                    $statRow["total_visits_weekly"] = $currentWeek['visits'];
                    $statRow["total_visits_monthly"] = $currentMonth['visits'];

                    $statistics[$i] = $statRow;
                    $i++;
                }
                //return $splice;
                return $statistics;
            }
        }
    }

    /**
     * @deprecated
     * This function provides visit of week on given date
     *
     * @param string $redisKey - redisKey is the combination of client_id - leadpop_client_id - domain_id e.g. 3111-16135-251658
     * @param string $date - Format is YYYY-MM-DD
     * @return int
     */
    public function getWeeklyVisits($redisKey, $date) {
        $keys = ['mobile_visits', 'mobile_visits_weekly', 'mobile_visits_monthly', 'desktop_visits', 'desktop_visits_weekly', 'desktop_visits_monthly', 'mobile_leads', 'mobile_leads_weekly', 'mobile_leads_monthly', 'desktop_leads', 'desktop_leads_weekly', 'desktop_leads_monthly'];

        $sdate = new DateTime($date);
        $sdate->modify('monday this week');

        $edate = new DateTime($date);
        $edate->modify('sunday this week');

        $this->stats = $this->redis->get($redisKey);
        if ($this->stats === false) {
            return 0;
        }
        else {
            $this->stats = unserialize($this->stats);
            ksort($this->stats);
            $range = $this->buildRange($sdate->format("y-m-d"), $edate->format("y-m-d"));
            if(empty($range)) {
                return 0;
            }
            else {
                $splice = array_intersect_key($this->stats, array_flip($range));
                $visits = 0;
                foreach($splice as $date=>$stats_str){
                    $arr = explode("-", $stats_str);
                    $visits = $visits + $arr[0] + $arr[3];
                }
                //return $splice;
                return $visits;
            }
        }
    }


    /**
     * This function provides Current Week's Visits on User's Date Input
     *
     * @param string $redisKey - redisKey is the combination of client_id - leadpop_client_id - domain_id e.g. 3111-16135-251658
     * @param string $start_date User Input Start Date
     * @param string $end_date User Input End Date
     * @param string $stats_info array Statistics Data from KeyDB
     * @return array
     */
    public function calculateWeeklyVisitsNumber($redisKey, $start_date='', $end_date='', $stats_info=array()){
        $today = new DateTime();
        $week_start_date = clone $today;
        if($week_start_date->format("w") > 0)
            $week_start_date->sub(new DateInterval("P".($today->format("w"))."D"));
        $week_end_date = clone $today;
        if($week_end_date->format("w") < 6)
            $week_end_date->add(new DateInterval("P".(6-$today->format("w"))."D"));

        if($start_date != ""){
            $ui_startdate = new DateTime($start_date);
        } else {
            $ui_startdate = $week_start_date;
        }

        if($end_date != ""){
            $ui_enddate = new DateTime($end_date);
        } else {
            $ui_enddate = $today;
        }

        // Now we need to check user's dates. If they within current week then we need to prefer those, if start date is less then week's start date then prefer
        // week's start date ALSO if user's end date is less then week's end date then we prefer user's end date

        // Case: In User INPUT is week's end date is less than current date then return ZERO
        if ($ui_enddate->format("Y-m-d") < $week_start_date->format("Y-m-d")) {
            // User's ending date is older than current week's starting date
            return ['error'=>"Ending date is older than current week.", 'visits' => 0];
        }
        else if ($ui_startdate->format("Y-m-d") > $week_start_date->format("Y-m-d")) {
            $week_start_date = $ui_startdate;
        }

        if ($ui_enddate < $week_end_date) {
            $week_end_date = $ui_enddate;
        }

        //dd("16 - 22 ===> 18", $start_date, $end_date, $week_start_date, $week_end_date);

        $data_row = array();
        if($stats_info){
            $data_row = $stats_info;
        }
        else{
            $keydbinfo = $this->redis->get($redisKey);
            if ($keydbinfo === false) {
                // NO Info from keyDB
                return ['error'=>"No information found in keyDB", 'visits' => 0];
            }
            else{
                $data_row = unserialize($keydbinfo);
                ksort($data_row);
            }
        }

        if(!is_array($data_row) || (is_array($data_row) && empty($data_row)) ){
            return ['error'=>"No Data / Invalid Data", 'visits' => 0];
        }
        else{
            $this->stats = $data_row;
            $range = $this->buildRange($week_start_date->format("y-m-d"), $week_end_date->format("y-m-d"));
            if(empty($range)) {
                return ['error'=>"Empty date range", 'visits' => 0];
            }
            else {
                $splice = array_intersect_key($this->stats, array_flip($range));
                $visits = 0;
                $week_visits = array();
                foreach($splice as $date=>$stats_str){
                    /*
                     * 0 => mobile_visits
                     * 1 => mobile_visits_weekly
                     * 2 => mobile_visits_monthly
                     * 3 => desktop_visits
                     * 4 => desktop_visits_weekly
                     * 5 => desktop_visits_monthly
                     * 6 => mobile_leads
                     * 7 => mobile_leads_weekly
                     * 8 => mobile_leads_monthly
                     * 9 => desktop_leads
                     * 10 => desktop_leads_weekly
                     * 11 => desktop_leads_monthly
                     */
                    $arr = explode("-", $stats_str);
                    $visits = $visits + $arr[0] + $arr[3];
                    $week_visits[$date] = $arr[0] + $arr[3];
                }
                //return $splice;
                return ['visits' => $visits, 'trace'=>$week_visits];
            }
        }
    }


    /**
     * @deprecated
     * This function provides visit of week on given date
     *
     * @param string $redisKey - redisKey is the combination of client_id - leadpop_client_id - domain_id e.g. 3111-16135-251658
     * @param string $date - Format is YYYY-MM-DD
     * @return int
     */
    public function getMonthlyVisits($redisKey, $date) {
        $keys = ['mobile_visits', 'mobile_visits_weekly', 'mobile_visits_monthly', 'desktop_visits', 'desktop_visits_weekly', 'desktop_visits_monthly', 'mobile_leads', 'mobile_leads_weekly', 'mobile_leads_monthly', 'desktop_leads', 'desktop_leads_weekly', 'desktop_leads_monthly'];

        $sdate = new DateTime($date);
        $sdate->modify('first day of this month');

        $edate = new DateTime($date);
        $edate->modify('last day of this month');

        $this->stats = $this->redis->get($redisKey);
        if ($this->stats === false) {
            return 0;
        }
        else {
            $this->stats = unserialize($this->stats);
            ksort($this->stats);
            $range = $this->buildRange($sdate->format("y-m-d"), $edate->format("y-m-d"));
            if(empty($range)) {
                return 0;
            }
            else {
                $splice = array_intersect_key($this->stats, array_flip($range));
                $visits = 0;
                foreach($splice as $date=>$stats_str){
                    $arr = explode("-", $stats_str);
                    $visits = $visits + $arr[0] + $arr[3];
                }
                //return $splice;
                return $visits;
            }
        }
    }


    /**
     * This function provides Current Week's Visits on User's Date Input
     *
     * @param string $redisKey - redisKey is the combination of client_id - leadpop_client_id - domain_id e.g. 3111-16135-251658
     * @param string $start_date User Input Start Date
     * @param string $end_date User Input End Date
     * @param string $stats_info array Statistics Data from KeyDB
     * @return array
     */
    public function calculateMontlyVisitsNumber($redisKey, $start_date='', $end_date='', $stats_info=array()){
        $today = new DateTime();

        $month_start_date = clone $today;
        $month_start_date->modify('first day of this month');

        $month_end_date = clone $today;
        $month_end_date->modify('last day of this month');

        if($start_date != ""){
            $ui_startdate = new DateTime($start_date);
        } else {
            $ui_startdate = $month_start_date;
        }

        if($end_date != ""){
            $ui_enddate = new DateTime($end_date);
        } else {
            $ui_enddate = $today;
        }

        if ($ui_enddate->format("Y-m-d") < $month_start_date->format("Y-m-d")) {
            // User's ending date is older than current week's starting date
            return ['error'=>"Ending date is older than current month.", 'visits' => 0];
        }
        else if ($ui_startdate->format("Y-m-d") > $month_start_date->format("Y-m-d")) {
            $month_start_date = $ui_startdate;
        }

        if ($ui_enddate < $month_end_date) {
            $month_end_date = $ui_enddate;
        }

        //dd($start_date, $end_date, $month_start_date, $month_end_date);

        $data_row = array();
        if($stats_info){
            $data_row = $stats_info;
        }
        else{
            $keydbinfo = $this->redis->get($redisKey);
            if ($keydbinfo === false) {
                // NO Info from keyDB
                return ['error'=>"No information found in keyDB", 'visits' => 0];
            }
            else{
                $data_row = unserialize($keydbinfo);
                ksort($data_row);
            }
        }

        if(!is_array($data_row) || (is_array($data_row) && empty($data_row)) ){
            return ['error'=>"No Data / Invalid Data", 'visits' => 0];
        }
        else{
            $this->stats = $data_row;
            $range = $this->buildRange($month_start_date->format("y-m-d"), $month_end_date->format("y-m-d"));
            if(empty($range)) {
                return ['error'=>"Empty date range", 'visits' => 0];
            }
            else {
                $splice = array_intersect_key($this->stats, array_flip($range));
                $visits = 0;
                $month_visits = array();
                foreach($splice as $date=>$stats_str){
                    /*
                     * 0 => mobile_visits
                     * 1 => mobile_visits_weekly
                     * 2 => mobile_visits_monthly
                     * 3 => desktop_visits
                     * 4 => desktop_visits_weekly
                     * 5 => desktop_visits_monthly
                     * 6 => mobile_leads
                     * 7 => mobile_leads_weekly
                     * 8 => mobile_leads_monthly
                     * 9 => desktop_leads
                     * 10 => desktop_leads_weekly
                     * 11 => desktop_leads_monthly
                     */
                    $arr = explode("-", $stats_str);
                    $visits = $visits + $arr[0] + $arr[3];
                    $month_visits[$date] = $arr[0] + $arr[3];
                }
                //return $splice;
                return ['visits' => $visits, 'trace'=>$month_visits];
            }
        }
    }

    /**
     * @param $from - Format is YYYY-MM-DD
     * @param $to - Format is YYYY-MM-DD
     * @return array
     */
    private function buildRange($from, $to) {
        $begin = new DateTime($from);
        $end =  new DateTime($to);
        $diff =  $end->diff($begin,true)->format("%a");
        if($diff === 0) $diff = $diff - 1;

        $startDate = new DateTime($from);
        $range[] = $begin->format('Y-m-d');

        for($i=0; $i < $diff; $i++) {
            $startDate->modify('+1 day');
            $nextDay = $startDate->format('Y-m-d');
            $range[] = $nextDay;
        }
        if($diff > 0) $range[] = $end->format('Y-m-d');
        $saverange = $range;
        for($i=0; $i < count($range); $i++) {
            $check = array_key_exists ( $range[$i] , $this->stats ) ;
            if ( $check === false) {
                unset($saverange[$i]);
            }
        }
        return $saverange;
    }

    /**
     * @param $start_date
     * @param $end_date
     * @return array
     * @throws \Exception
     */
    function getDateRange($start_date,$end_date){
        $begin = new DateTime($start_date);
        $end =  new DateTime($end_date);
        $diff =  $end->diff($begin,true)->format("%a");
        $diff = $diff - 1;
        $startDate = new DateTime($start_date);
        for($i=0; $i < $diff; $i++) {
            $startDate->modify('+1 day');
            $nextDay = $startDate->format('Y-m-d');
            $range[] = $nextDay;
        }
        $range[] = $end_date;
        return $range;
    }

    /**
     * This function provides the weekly leads for funnel for date range
     *
     * @param string $redisKey - redisKey is the combination of client_id - leadpop_client_id - domain_id e.g. 3111-16135-251658
     * @param string $startDate - Format is YYYY-MM-DD
     * @param string $endDate - Format is YYYY-MM-DD
     * @return array
     */
    public function getWeeklyLeads($redisKey, $startDate, $endDate = "") {
        $keys = ['mobile_visits', 'mobile_visits_weekly', 'mobile_visits_monthly', 'desktop_visits', 'desktop_visits_weekly', 'desktop_visits_monthly', 'mobile_leads', 'mobile_leads_weekly', 'mobile_leads_monthly', 'desktop_leads', 'desktop_leads_weekly', 'desktop_leads_monthly'];

        if ($endDate == "") {
            $endDate = $startDate ;
        }
        $this->stats = $this->redis->get($redisKey);
        $stats = $day =  $leads = array();
        if ($this->stats) {
            $this->stats = unserialize($this->stats);
            ksort($this->stats);
        }
        else{
            $this->stats = array();
        }
        $range = $this->getDateRange($startDate,$endDate);
        foreach($range as $val){
                if ($this->stats and array_key_exists($val,$this->stats))
                {
                    $statRow = array_combine($keys, explode("-", $this->stats[$val]));
                    $day[] = $this->getDayByDate($val);
                    $leads[] = $statRow['mobile_leads'] + $statRow['desktop_leads'];
                }
                else
                {
                    $day[] = $this->getDayByDate($val);
                    $leads[] = 0;
                }
            }
        $max = max($leads);
        $graphStep = config('lp.stats_graph_steps');
        $newArray = array_keys($graphStep);
        $maxStep = 5;
        $stepSize = 1;
        foreach($newArray as $key => $step){
                $greaterKey = $key+1;
                if(isset($newArray[$greaterKey]) and $max > $newArray[$key] and $max <= $newArray[$greaterKey]){
                    $stepSize = $graphStep[$newArray[$greaterKey]];
                    $maxStep = $newArray[$greaterKey];
                    continue;
                }
                else if(isset($newArray[$greaterKey]) and $max > $newArray[$greaterKey]){
                    $stepSize = round($max/5);
                    $maxStep = $max;
                    continue;
                }
            }
        if($max == $maxStep) {
            $ikey = 1;
            while ($max == $maxStep) {
                $maxStep += $stepSize;
                ++$ikey;
            }
        }
        $stats['step_size'] = $stepSize;
        $stats['max_step'] = $maxStep;
        $stats['day'] = $day;
        $stats['leads'] = $leads;
        return $stats;
    }
    /**
     * @param date $date
     */
    function getDayByDate($date){
        return date('m/d/Y',strtotime($date));
    }
}
