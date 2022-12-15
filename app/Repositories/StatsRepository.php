<?php
/**
 * Created by PhpStorm.
 * User: MZAC
 * Date: 23/11/2019
 * Time: 12:15 PM
 */

/**
 * Code Migrated from Zend to Laravel  ==>  StatsRepository --> Source: Default_Model_LpStats
 */

namespace App\Repositories;
use DateTime;
use DatePeriod;
use DateIntercal;
use Stats_Helper;

class StatsRepository
{
    private $db;
    private $dateFormat = 'Y-m-d';
    public function __construct(\App\Services\DbService $service){
        $this->db = $service;
    }

    public function getStats($param) {
        $s = "SELECT *, DATE(`date`) as 'date', ";
        $s .= "ROUND(((desktop_leads/desktop_visits) * 100),2) as 'desktop_conversion', ";
        $s .= "ROUND(((mobile_leads/mobile_visits) * 100),2) as 'mobile_conversion', ";
        $s .= "(mobile_visits + desktop_visits) as 'total_visits', ";
        $s .= "(mobile_leads + desktop_leads) as 'total_leads', ";
        $s .= "ROUND((((mobile_leads + desktop_leads)/(mobile_visits + desktop_visits)) * 100),2) as 'total_conversion' ";
        $s .= "FROM lead_stats ";
        $s .= " LEFT JOIN (
			        (SELECT domain_id, SUM(mobile_visits) AS 'mobile_visits_weekly', SUM(desktop_visits) AS 'desktop_visits_weekly', (SUM(mobile_visits) + SUM(desktop_visits)) AS 'total_visits_weekly'
			        FROM lead_stats WHERE WEEK(`date`) = WEEK(NOW())  GROUP BY WEEK(`date`), domain_id) ls_week
			    ) ON ls_week.domain_id = lead_stats.domain_id
				LEFT JOIN (
                   (SELECT domain_id, SUM(mobile_visits) AS 'mobile_visits_monthly', SUM(desktop_visits) AS 'desktop_visits_monthly', (SUM(mobile_visits) + SUM(desktop_visits)) AS 'total_visits_monthly'
                    FROM lead_stats WHERE MONTH(`date`) = MONTH(NOW()) GROUP BY MONTH(`date`), domain_id) ls_month
                ) ON ls_month.domain_id = lead_stats.domain_id ";
        $s .= "WHERE client_id = ".$param['client_id'];

        $whereColumns = array('leadpop_client_id', 'leadpop_id', 'leadpop_vertical_id', 'leadpop_vertical_sub_id', 'leadpop_version_id', 'leadpop_version_seq', 'domain_id');
        foreach($whereColumns as $col){
            if(array_key_exists($col, $param)){
                $s .= "	AND lead_stats.".$col." = ".$param[$col];
            }
        }

        /** @var $date DateTime */
        $date = new \DateTime();
        $current_date = $date->format('Y-m-d');
        $current_week = $date->format('W');
        $current_month = $date->format('m');
        #$last_30_days = $date->add(date_interval_create_from_date_string('-29 days'));
        $last_30_days = $date->add(date_interval_create_from_date_string('-30 days'));
        $last_7_days = $date->add(date_interval_create_from_date_string('-7 days'));

        if(array_key_exists("start_date", $param)){
            $start_date =  date('Y/m/d', strtotime('-1 day', strtotime($param["start_date"])));
            $sd_new_leads = new \DateTime($param["start_date"]);
            $start_date_new_leads = $sd_new_leads->format("Y-m-d");
        } else{
            $start_date = $start_date_new_leads = $last_30_days->format('Y-m-d');
        }

        if(array_key_exists("end_date", $param)){
            $end_date =  date('Y/m/d', strtotime('+1 day', strtotime($param["end_date"])));
            $ed_new_leads = new \DateTime($param["end_date"]);
            $end_date_new_leads = $ed_new_leads->format("Y-m-d");
        } else{
            $end_date = $end_date_new_leads = $current_date;
        }

        $s .= "	AND DATE(`date`) >= '$start_date' AND DATE(`date`) <= '$end_date' ";
        $s .= "	ORDER BY `date` ASC";
        if(@$_COOKIE['debug']=='sql-break'){
            lp_debug($s); exit;
        }
        $statsData = $this->db->fetchAll($s);

        $stats = $statSummary = $statData = $x_labels = array();
        $stats['datasrc'] = "data";
        if(@$_COOKIE['debug']=='sql-json'){
            $stats['debug_sql'] = $s;
        }

        $aggregationType = ['total','desktop','mobile'];
        $statsType = ['visits','leads','conversion', 'new_leads', 'current_week_visitor', 'current_month_visitor'];
        foreach($aggregationType as $type){
            foreach($statsType as $stat_type){
                $statSummary[$type][$stat_type] = 0;
            }
        }

        if($statsData) {
            $new_leads['total'] = $this->getNewLeads( $statsData[0], $start_date_new_leads, $end_date_new_leads);
            $new_leads['mobile'] = $this->getNewLeads( $statsData[0], $start_date_new_leads, $end_date_new_leads, "phone" );
            $new_leads['desktop'] = $new_leads['total'] - $new_leads['mobile'];

            foreach ( $statsData as $data ) {
                $details = array();

                $cols_remove = [
                    'mobile_visits',
                    'mobile_leads',
                    'desktop_visits',
                    'desktop_leads'
                ];
                foreach ( $cols_remove as $cols ) {
                    unset( $details[ $cols ] );
                }

                $details['desktop']['visits']         = $data['desktop_visits'];
                $details['desktop']['leads']          = $data['desktop_leads'];
                $details['desktop']['conversion']     = ($details['desktop']['leads'] > 0 && $details['desktop']['visits'] > 0) ? round( ( $details['desktop']['leads'] / $details['desktop']['visits'] ) * 100, 2 ):0;

                $details['mobile']['visits']         = $data['mobile_visits'];
                $details['mobile']['leads']          = $data['mobile_leads'];
                $details['mobile']['conversion']     = ($details['mobile']['leads'] > 0 && $details['mobile']['visits'] > 0) ? round( ( $details['mobile']['leads'] / $details['mobile']['visits'] ) * 100, 2 ):0;

                $details['total']['visits']         = $details['desktop']['visits'] + $details['mobile']['visits'];
                $details['total']['leads']          = $details['desktop']['leads'] + $details['mobile']['leads'];
                $details['total']['conversion']     = ( $details['total']['leads']  > 0 && $details['total']['visits'] > 0 ) ? round( ( $details['total']['leads'] / $details['total']['visits'] ) * 100, 2 ):0;

                //Calculations for Summary Node
                foreach ( $aggregationType as $type ) {
                    foreach ( $statsType as $stat_type ) {
                        if ( in_array( $stat_type, [ 'visits', 'leads' ] ) ) {
                            $statSummary[ $type ][ $stat_type ] = $statSummary[ $type ][ $stat_type ] + $details[ $type ][ $stat_type ];
                        }
                        else if( $stat_type == 'conversion'){
                            $statSummary[ $type ]['conversion'] = ($statSummary[ $type ][ 'leads' ])?round( ( $statSummary[ $type ][ 'leads' ] / $statSummary[ $type ][ 'visits' ]) * 100, 2 ):0;
                        }
                        else if ( $stat_type == 'current_week_visitor' && $current_week == date( "W", strtotime( $data['date'] ) ) ) {
                            $statSummary[ $type ]['current_week_visitor'] = intval($data[ $type.'_visits_weekly']);
                        }
                        else if ( $stat_type == 'current_month_visitor' && $current_month == date( "m", strtotime( $data['date'] ) ) ) {
                            $statSummary[ $type ]['current_month_visitor'] = intval($data[ $type.'_visits_monthly']);
                        }
                        else{
                            $statSummary[ $type ]['new_leads'] = $new_leads[$type];
                        }
                    }
                }

                $x_axis = date( $this->dateFormat, strtotime( $data['date'] ) );
                array_push( $x_labels, $x_axis );
                $statData[ $x_axis ] = $details;
            }
        }

        $all_stats = $this->fill_empty_dates_with_zero($statData, $start_date, $end_date);
        $x_labels = $all_stats['x_labels'];
        $statData = $all_stats['data'];

        if(count($x_labels) >= 365){ $x_display_unit = "year"; }
        else if(count($x_labels) > 180){ $x_display_unit = "quarter"; }
        else if(count($x_labels) > 121){ $x_display_unit = "month"; }
        else if(count($x_labels) > 61){ $x_display_unit = "week"; }
        else { $x_display_unit = "day"; }

        $stats['stats'] = $statSummary;
        $stats['metrics']['meta'] = array("client_id"=>$param['client_id'], "hash"=>$param['hash'], "map_label"=>"Date", "x_labels"=>$x_labels, 'x_display_unit'=>$x_display_unit);
        $stats['metrics']['data'] = $statData;

        if($statData){
            $google_info = $this->getGoogleKey($param['client_id'], $param['domain_name']);
            $stats['metrics']['meta']['google_tracking'] = $google_info;
            $stats['metrics']['meta']['google_domain'] = $param['domain_name'];
        }
        $query="Select title,url,thumbnail,wistia_id  from ".config('database.tables.support_videos')." WHERE vkey='stats-statistics'";
        $videodata=$this->db->fetchrow($query);
        if($videodata) $stats['video']=$videodata;
        return $stats;
    }



    public function getNewLeads($info, $start_date, $end_date, $type=''){
        $sql = "SELECT COUNT(id) as new_leads FROM `lead_content` lc WHERE
				lc.client_id = ".$info['client_id']."
				AND lc.leadpop_vertical_id = ".$info['leadpop_vertical_id']."
				AND lc.leadpop_version_id = ".$info['leadpop_version_id']."
				AND lc.leadpop_vertical_sub_id = ".$info['leadpop_vertical_sub_id']."
				AND lc.leadpop_version_seq = ".$info['leadpop_version_seq']."
				AND lc.leadpop_template_id = ".$info['leadpop_template_id']."
				AND lc.opened = '0'
				AND deleted = 0";

        if($type){
            $sql .= " AND JSON_Search(lead_answers, 'all', '" . $type . "') is not null";
//            for($i=1; $i<=50; $i++){
//                $cols[] = "a$i = '$type'";
//            }
//            $sql .= " AND (".implode(" OR ", $cols).")";
        }
        $sql .= " AND DATE(`date_completed`) >= '$start_date' AND DATE(`date_completed`) <= '$end_date' ";
        $res = $this->db->fetchAll($sql);
        return $res[0]['new_leads'];
    }

    private function fill_empty_dates_with_zero($statData, $start_date, $end_date) {
        $statSummary = array();
        $aggregationType = ['desktop','mobile','total'];
        $statsType = ['visits','leads','conversion'];
        foreach($aggregationType as $type){
            foreach($statsType as $stat_type){
                $statSummary[$type][$stat_type] = 0;
            }
        }

        $all_stats = array();
        $all_stats['x_labels'] = array();
        $all_stats['data'] = array();

        $start_date = new \DateTime( $start_date );
        $end_date   = new \DateTime( $end_date );
        $date_interval = new \DateInterval('P1D');
        $end_date->add($date_interval);

        $diff = $start_date->diff($end_date);
        $days = $diff->format('%a');
        $interval_days = 1;//ceil($days/30);

        $interval = $date_interval::createFromDateString( $interval_days.' day' );
        $period   = new \DatePeriod( $start_date, $interval, $end_date );
        $stat_implementation_date = date( $this->dateFormat, strtotime( "2017-10-31" ) );
        foreach ( $period as $dt ) {
            $date = $dt->format( $this->dateFormat );

            if($date > $stat_implementation_date){
                $all_stats['x_labels'][] = $date;
                if(!array_key_exists( $date, $statData)){
                    $all_stats['data'][ $date ] = $statSummary;
                } else {
                    $all_stats['data'][ $date ] = $statData[ $date ];
                }
            }
        }

        return $all_stats;
    }

    function getGoogleKey($client_id,$domain){
        $s = "select * from purchased_google_analytics  where client_id = " . $client_id;
        $s .= " and purchased = 'y' and domain = '".trim($domain)."' limit 1 ";
        $res = $this->db->fetchAll($s);
        if($res){
            //$ret = $res[0]['active'].'~'.$res[0]['google_key'];
            $ret = $res[0]['google_key'];
        }else{
            $ret = "";
        }
        return $ret;
    }


    function getIpAddressList($params){
        $s = "SELECT * FROM leadpops_blocked_ip WHERE client_id = " . $params['client_id'] . " AND domain_id = ".$params['domain_id'];
        $res = $this->db->fetchAll($s);
        if(!$res){
            $res = array();
        }
        return $res;
    }

    function addIpAddress($params){
        $sql = "INSERT INTO leadpops_blocked_ip (`client_id`,`client_leadpop_id`,`leadpop_id`,`leadpop_vertical_id`,`leadpop_vertical_sub_id`,`leadpop_template_id`,`leadpop_version_id`,`leadpop_version_seq`,`domain_id`,`ip_name`,`ip_address`) ";
        $sql .= "VALUES ( ".$params['client_id'].", ".$params['client_leadpop_id'].", ".$params['leadpop_id'].", ".$params['leadpop_vertical_id'].", ".$params['leadpop_vertical_sub_id'].", ".$params['leadpop_template_id'].", ".$params['leadpop_version_id'].", ".$params['leadpop_version_seq'].", ".$params['domain_id'].", '".$params['ip_name']."','".$params['ip_address']."')";
        $this->db->query($sql);
        $id = $this->db->lastInsertId();
        return $id;
    }

    function updateIpAddress($params, $id){
        $sql = "UPDATE leadpops_blocked_ip SET `ip_name` = '".$params['ip_name']."', `ip_address` = '".$params['ip_address']."' WHERE id = $id";
        $this->db->query($sql);
    }

    function deleteIpAddress($id, $client_id, $domain_id){
        $sql = "DELETE FROM leadpops_blocked_ip WHERE id = $id AND client_id = $client_id AND domain_id = $domain_id";
        $this->db->query($sql);
    }


    //Note:Google Analytics model function merge in stats repository.
    public function updateKey($adata) {

// Full texts 	client_id 	purchased 	google_key 	thedate 	domain 	active 	package_id
        $s = "select count(*) as cnt from  purchased_google_analytics where client_id = " . $adata['gaclient_id'] . " and ";
        $s .= " domain = '".$adata['gaorigdomain']."' limit 1 ";
        $cnt = $this->db->fetchOne($s);
        if ($cnt == 0 ){
            $dt = date("Y-m-d H:i:s");
            $s = "insert into purchased_google_analytics (client_id,purchased,google_key,thedate,domain,active,package_id) values
           (". $adata['gaclient_id']	.",'y','".addslashes($adata['gaurlkey'])."','".$dt."','";
            $s .= $adata['gaorigdomain']."','".$adata['gaactive']."','2')";
            $this->db->query($s);
        }
        else {
            $s = "update purchased_google_analytics set google_key = '".addslashes($adata['gaurlkey'])."', ";
            $s .= "active = '".$adata['gaactive']."' ";
            $s .= " where client_id = " . $adata['gaclient_id'];
            $s .= " and domain = '".$adata['gaorigdomain']."' ";
            $this->db->query($s);
        }
    }

    public function deleteKey($adata) {
            $s = "delete from purchased_google_analytics ";
            $s .= " where client_id = " . $adata['gaclient_id'];
            $s .= " and domain = '".$adata['gaorigdomain']."' ";
            $this->db->query($s);
    }

    function updateStatsProcess($client_id){
        $client_id_str=implode(",",$client_id);
        $ins_stat_query="INSERT INTO lead_stats (client_id,leadpop_id,leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,leadpop_version_seq,mobile_visits,desktop_visits,mobile_leads,desktop_leads)
		Select
		ls.client_id,ls.leadpop_id,ls.leadpop_vertical_id,ls.leadpop_vertical_sub_id,ls.leadpop_template_id,ls.leadpop_version_id,ls.leadpop_version_seq,sum(ls.mobile_total_visits) AS mobile_visit,sum(ls.desktop_total_visits) AS desktop_visit,sum(ls.mobile_total_leads) AS mobile_lead,sum(ls.desktop_total_leads) AS desktop_lead

			from lead_summary AS ls
			where ls.client_id IN (".$client_id_str.")

			group by ls.client_id,ls.leadpop_id,ls.leadpop_vertical_id,ls.leadpop_vertical_sub_id,ls.leadpop_template_id,ls.leadpop_version_id,leadpop_version_seq";
        $this->db->query($ins_stat_query);
        $id = $this->db->lastInsertId();
        $query="select id ,client_id,leadpop_id,leadpop_version_id,leadpop_version_seq
			from clients_leadpops
			where CONCAT(client_id,'~',leadpop_id,'~',leadpop_version_id,'~',leadpop_version_seq) IN ( select CONCAT(client_id,'~',leadpop_id,'~',leadpop_version_id,'~',leadpop_version_seq) from lead_stats where client_id IN (".$client_id_str.") AND  leadpop_client_id is null )";
        $ledpop_client_ids_data=$this->db->fetchAll($query);
        $ledpop_client_ids_update_query=[];
        foreach ($ledpop_client_ids_data as $d) {
            $ledpop_client_ids_update_query[]="UPDATE lead_stats SET leadpop_client_id=".$d["id"]." WHERE client_id=".$d["client_id"]. " AND leadpop_id = ".$d["leadpop_id"]." AND leadpop_version_id =".$d["leadpop_version_id"]." AND leadpop_version_seq = ".$d["leadpop_version_seq"];
        }

        $query="select clients_domain_id as domain_id ,client_id,leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,leadpop_id,leadpop_version_id,leadpop_version_seq
		from clients_funnels_domains
		where
		CONCAT(client_id,'~',leadpop_vertical_id,'~',leadpop_vertical_sub_id,'~',leadpop_template_id,'~',leadpop_id,'~',leadpop_version_id,'~',leadpop_version_seq)
		IN ( select CONCAT(client_id,'~',leadpop_vertical_id,'~',leadpop_vertical_sub_id,'~',leadpop_template_id,'~',leadpop_id,'~',leadpop_version_id,'~',leadpop_version_seq) from lead_stats where client_id IN (".$client_id_str.") AND  domain_id is null )";
        $ledpop_sdomain_ids_data=$this->db->fetchAll($query);
        $ledpop_sdomain_ids_update_query=[];
        foreach ($ledpop_sdomain_ids_data as $d) {
            $ledpop_sdomain_ids_update_query[]="UPDATE lead_stats SET domain_id=".$d["domain_id"]." WHERE client_id=".$d["client_id"]. " AND leadpop_vertical_id = ".$d["leadpop_vertical_id"]." AND leadpop_vertical_sub_id = ".$d["leadpop_vertical_sub_id"]." AND leadpop_template_id = ".$d["leadpop_template_id"]." AND leadpop_id = ".$d["leadpop_id"]." AND leadpop_version_id = ".$d["leadpop_version_id"]." AND leadpop_version_seq = ".$d["leadpop_version_seq"];
        }

        foreach ($ledpop_client_ids_update_query as $q) {
            $this->db->query($q);
        }
        foreach ($ledpop_domain_ids_update_query as $q) {
            $this->db->query($q);
        }
        foreach ($ledpop_sdomain_ids_update_query as $q) {
            $this->db->query($q);
        }
        debug("Update process has been completed.");
        exit;

    }


    public function getStatsRedis($param) {
        /** @var $date DateTime */
        $date = new \DateTime();
        $current_date = $date->format('Y-m-d');
        $current_week = $date->format('W');
        $current_month = $date->format('m');
        $last_30_days = $date->add(date_interval_create_from_date_string('-29 days'));
        $last_7_days = $date->add(date_interval_create_from_date_string('-6 days'));

        $pre_point_date = $post_point_date = "";

        /*
         * To Match new Graph design we need to Pick two extra days for graph
         * so we pick Start date by -1 Day go back
         * and ending date with +1 day forward
         */
        if(array_key_exists("start_date", $param)){
            $start_date =  date('Y/m/d', strtotime('-1 day', strtotime($param["start_date"])));
            $sd_new_leads = new \DateTime($param["start_date"]);
            $start_date_new_leads = $sd_new_leads->format("Y-m-d");

            $pre_point_date = date('Y-m-d', strtotime('-1 day', strtotime($param["start_date"])));
        } else{
            $start_date = $start_date_new_leads = $last_30_days->format('Y-m-d');
        }

        if(array_key_exists("end_date", $param)){
            $end_date =  date('Y/m/d', strtotime('+1 day', strtotime($param["end_date"])));
            $ed_new_leads = new \DateTime($param["end_date"]);
            $end_date_new_leads = $ed_new_leads->format("Y-m-d");

            $post_point_date = date('Y-m-d', strtotime('+1 day', strtotime($param["end_date"])));
        } else{
            $end_date = $end_date_new_leads = $current_date;
        }

        $funnelKeys = array();
        foreach(['client_id', 'leadpop_vertical_id', 'leadpop_vertical_sub_id', 'leadpop_template_id', 'leadpop_version_id', 'leadpop_version_seq'] as $key){
            $funnelKeys[$key] = $param[$key];
        }

        //$statsData = Stats_Helper::getInstance()->getStatsByDateRange(Stats_Helper::getInstance()->getRedisKey($param) , $start_date, $end_date);
        $statsData = Stats_Helper::getInstance()->getStatsByDateRange(Stats_Helper::getInstance()->getRedisKey($param) , $start_date, $end_date, $param);
        if($statsData){
            foreach($statsData as $i=>&$st){
                $st = array_merge($st, $funnelKeys);
            }
        }

        $stats = $statSummary = $statData = $x_labels = array();
        $stats['datasrc'] = "memory";
        $aggregationType = ['total','desktop','mobile'];
        $statsType = ['visits','leads','conversion', 'new_leads', 'current_week_visitor', 'current_month_visitor'];
        foreach($aggregationType as $type){
            foreach($statsType as $stat_type){
                $statSummary[$type][$stat_type] = 0;
            }
        }

        if($statsData) {
            $new_leads['total'] = $this->getNewLeads( $statsData[0], $start_date_new_leads, $end_date_new_leads);
            $new_leads['mobile'] = $this->getNewLeads( $statsData[0], $start_date_new_leads, $end_date_new_leads, "phone" );
            $new_leads['desktop'] = $new_leads['total'] - $new_leads['mobile'];

            foreach ( $statsData as $data ) {
                $details = array();

                $cols_remove = [
                    'mobile_visits',
                    'mobile_leads',
                    'desktop_visits',
                    'desktop_leads'
                ];
                foreach ( $cols_remove as $cols ) {
                    unset( $details[ $cols ] );
                }

                $details['desktop']['visits']         = $data['desktop_visits'];
                $details['desktop']['leads']          = $data['desktop_leads'];
                $details['desktop']['conversion']     = ($details['desktop']['leads'] > 0 && $details['desktop']['visits'] > 0) ? round( ( $details['desktop']['leads'] / $details['desktop']['visits'] ) * 100, 2 ):0;

                $details['mobile']['visits']         = $data['mobile_visits'];
                $details['mobile']['leads']          = $data['mobile_leads'];
                $details['mobile']['conversion']     = ($details['mobile']['leads'] > 0 && $details['mobile']['visits'] > 0) ? round( ( $details['mobile']['leads'] / $details['mobile']['visits'] ) * 100, 2 ):0;

                $details['total']['visits']         = $details['desktop']['visits'] + $details['mobile']['visits'];
                $details['total']['leads']          = $details['desktop']['leads'] + $details['mobile']['leads'];
                $details['total']['conversion']     = ( $details['total']['leads']  > 0 && $details['total']['visits'] > 0 ) ? round( ( $details['total']['leads'] / $details['total']['visits'] ) * 100, 2 ):0;



                //Calculations for Summary Node
                if( ($pre_point_date == "" || $pre_point_date != $data['date']) && ($post_point_date == "" || $post_point_date != $data['date'])) {
                    foreach ($aggregationType as $type) {
                        foreach ($statsType as $stat_type) {
                            if (in_array($stat_type, ['visits', 'leads'])) {
                                $statSummary[$type][$stat_type] = $statSummary[$type][$stat_type] + $details[$type][$stat_type];
                            }
                            else if ($stat_type == 'conversion') {
                                $statSummary[$type]['conversion'] = ($statSummary[$type]['leads']) ? round(($statSummary[$type]['leads'] / $statSummary[$type]['visits']) * 100, 2) : 0;
                            }

                            else if ($stat_type == 'current_week_visitor') {
                                # As we don't have weekly total visitor by devices so for now we always show total
                                # $statSummary[$type]['current_week_visitor'] = intval($data[$type . '_visits_weekly']);
                                $statSummary[$type]['current_week_visitor'] = intval($data["total_visits_weekly"]);
                            }

                            else if ($stat_type == 'current_month_visitor') {
                                # As we don't have weekly total visitor by devices so for now we always show total
                                # $statSummary[$type]['current_month_visitor'] = intval($data[$type . '_visits_monthly']);
                                $statSummary[$type]['current_month_visitor'] = intval($data["total_visits_monthly"]);
                            }
                            else {
                                $statSummary[$type]['new_leads'] = $new_leads[$type];
                            }
                        }
                    }
                }

                $x_axis = date( $this->dateFormat, strtotime( $data['date'] ) );
                array_push( $x_labels, $x_axis );
                $statData[ $x_axis ] = $details;
            }
        }

        $all_stats = $this->fill_empty_dates_with_zero($statData, $start_date, $end_date);
        $x_labels = $all_stats['x_labels'];
        $statData = $all_stats['data'];

        if(count($x_labels) >= 365){ $x_display_unit = "year"; }
        else if(count($x_labels) > 180){ $x_display_unit = "quarter"; }
        else if(count($x_labels) > 121){ $x_display_unit = "month"; }
        else if(count($x_labels) > 61){ $x_display_unit = "week"; }
        else { $x_display_unit = "day"; }

        $stats['stats'] = $statSummary;
        $stats['metrics']['meta'] = array("client_id"=>$param['client_id'], "hash"=>$param['hash'], "map_label"=>"Date", "x_labels"=>$x_labels, 'x_display_unit'=>$x_display_unit);
        $stats['metrics']['data'] = $statData;

        if($statData){
            $google_info = $this->getGoogleKey($param['client_id'], $param['domain_name']);
            $stats['metrics']['meta']['google_tracking'] = $google_info;
            $stats['metrics']['meta']['google_domain'] = $param['domain_name'];
        }
        $query="Select title,url,thumbnail,wistia_id  from ".config('database.tables.support_videos')." WHERE vkey='stats-statistics'";
        $videodata=$this->db->fetchrow($query);
        if($videodata) $stats['video']=$videodata;
        return $stats;
    }

    //get weekly leads for dashboard graph

    public function getWeeklyLeads($param) {
        $s = "SELECT DATE(`date`) as 'date', ";
        $s .= "(mobile_leads + desktop_leads) as 'total_leads' ";
        $s .= "FROM lead_stats ";
        $s .= "WHERE client_id = " . $param['client_id'];

        $whereColumns = array('leadpop_client_id', 'leadpop_id', 'leadpop_vertical_id', 'leadpop_vertical_sub_id', 'leadpop_version_id', 'leadpop_version_seq', 'domain_id');
        foreach ($whereColumns as $col) {
            if (array_key_exists($col, $param)) {
                $s .= "	AND lead_stats." . $col . " = " . $param[$col];
            }
        }


        if (array_key_exists("start_date", $param)) {
            $start_date = $param["start_date"];
        } else {
            $start_date = date('Y-m-d', strtotime('-8 days'));
        }

        if (array_key_exists("end_date", $param)) {
            $end_date = $param["end_date"];
        } else {
            $end_date = date('Y-m-d');;
        }

        $stats = $day = $leads = array();
        $stats['datasrc'] = "data";

        $dateRange = \Stats_Helper::getInstance()->getDateRange($start_date, $end_date);
        foreach ($dateRange as $val) {
            $q = "	AND DATE(`date`) = '$val' ORDER BY `date` ASC";
            $query = $s . $q;
            $statsData = $this->db->fetchRow($query);
            if ($statsData) {
                $day[] = \Stats_Helper::getInstance()->getDayByDate($val);
                $leads[] = ($statsData['total_leads'] > 0) ? $statsData['total_leads'] : 0;
            } else {
                $day[] = \Stats_Helper::getInstance()->getDayByDate($val);
                $leads[] = 0;
            }
        }
        $max = max($leads);
        $graphStep = config('lp.stats_graph_steps');
        $newArray = array_keys($graphStep);
        $maxStep = 5;
        $stepSize = 1;
        foreach ($newArray as $key => $step) {
            $greaterKey = $key + 1;
            if (isset($newArray[$greaterKey]) and $max > $newArray[$key] and $max <= $newArray[$greaterKey]) {
                $stepSize = $graphStep[$newArray[$greaterKey]];
                $maxStep = $newArray[$greaterKey];
                continue;
            } else if (isset($newArray[$greaterKey]) and $max > $newArray[$greaterKey]) {
                $stepSize = round($max / 5);
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


    public function getWeeklyLeadsByDomains($client_id, $start_date, $end_date, $domains) {
        $dateRange = \Stats_Helper::getInstance()->getDateRange($start_date, $end_date);

        $s = "SELECT domain_id, DATE(`date`) as 'date',";
        $s .= " (mobile_leads + desktop_leads) as 'total_leads'";
        $s .= " FROM lead_stats ";
        $s .= " WHERE client_id = " . $client_id;
        $s .= "	AND lead_stats.domain_id IN (".implode(",", array_filter($domains)).")";
        $s .= "	AND DATE(`date`) IN ('".implode("','", $dateRange)."')";
        $s .= "	ORDER BY domain_id, `date` ASC";
        $statsRows = $this->db->fetchAll($s);
        $statsCollection = collect($statsRows);

        $stats = array();

        foreach($domains as $domain_id){
            $day = $leads = array();
            foreach ($dateRange as $val) {
                $cinfo = $statsCollection->where('date', $val)->where('domain_id', $domain_id);
                if (count($cinfo) > 0) {
                    $statsData = $cinfo->toArray();
                    $statsData = end($statsData);
                    $day[] = \Stats_Helper::getInstance()->getDayByDate($val);
                    $domain_leads = ($statsData['total_leads'] > 0) ? $statsData['total_leads'] : 0;
                    $leads[] = $domain_leads;
                } else {
                    $day[] = \Stats_Helper::getInstance()->getDayByDate($val);
                    $leads[] = 0;
                }

                $max = max($leads);
                $graphStep = config('lp.stats_graph_steps');
                $newArray = array_keys($graphStep);
                $maxStep = 5;
                $stepSize = 1;
                foreach ($newArray as $key => $step) {
                    $greaterKey = $key + 1;
                    if (isset($newArray[$greaterKey]) and $max > $newArray[$key] and $max <= $newArray[$greaterKey]) {
                        $stepSize = $graphStep[$newArray[$greaterKey]];
                        $maxStep = $newArray[$greaterKey];
                        continue;
                    } else if (isset($newArray[$greaterKey]) and $max > $newArray[$greaterKey]) {
                        $stepSize = round($max / 5);
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

                $stats[$domain_id]['step_size'] = $stepSize;
                $stats[$domain_id]['max_step'] = $maxStep;
                $stats[$domain_id]['day'] = $day;
                $stats[$domain_id]['leads'] = $leads;
            }
        }

      //  dd($stats);
        return $stats;
    }


}

