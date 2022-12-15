<?php
/**
 * Created by PhpStorm.
 * User: Jazib
 * Date: 13/11/2019
 * Time: 4:35 AM
 */

/**
 * Code Migrated from Zend to Laravel  ==>  LeadpopsRepository --> Source: Default_Model_Leadpops (Leadpops.php)
 */

namespace App\Repositories;
use App\Repositories\ExportRepository;


use App\Services\DbService;

class LeadpopsRepository
{
    private $db;
    private $sessionDb;
    private  $exp_mod_obj;

    public function __construct(DbService $service , ExportRepository $exp_mod_obj){
        $this->db = $service;
        $this->exp_mod_obj = $exp_mod_obj;
    }

    public function getMarketingHubChildData($action)
    {
        $return_arr = array('title' => "", "data" => "");
        $query = "select parent_id from leadpop_marketing_hub where parent_id!=0 AND status=1  AND action='" . $action . "' group by action ";
        $parent_id = $this->db->fetchOne($query);
        if (is_numeric($parent_id) && $parent_id) {
            $query = "select title from leadpop_marketing_hub where parent_id=0 AND status=1  AND id=" . $parent_id;
            $parent_title = $this->db->fetchOne($query);
            $return_arr["title"] = $parent_title;
            $query = "select * from leadpop_marketing_hub where parent_id!=0 AND status=1  AND parent_id=" . $parent_id;
            $data = $this->db->fetchAll($query);
            $return_arr["data"] = $data;
        }
        return $return_arr;
    }



    /* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
                    CODE BELOW TO THIS SEPERATION NEEDS TO VERIFY
     ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */

    public function getMarketingHubData()
    {
        $query = "select * from leadpop_marketing_hub where parent_id=0 AND status=1 order by title ASC";
        $data = $this->db->fetchAll($query);
        return $data;
    }

    public function getGuid($client_id, $page_id)
    {
        $s = "select guid from   poppage_groupsites_copies where page_id = " . $page_id . " and client_id = " . $client_id . " limit 1 ";
        $aguid = $this->db->fetchAll($s);
        $guid = "";
        if ($aguid) {
            $guid = $aguid[0]["guid"];
        }
        return $guid;
    }

    /**
     * TODO:CLEAN-UP
     * @deprecated 2.1.0
     * @deprecated No longer used by internal code and not recommended use_old_admin table are not part of further builds (2019-10-08).
     *
    public function onlyEnterprise($client_id)
    {
        $s = "select * from use_old_admin where client_id= " . $client_id;
        $useold = $this->db->fetchAll($s);
        if ($useold) {
            return 'y';
        } else {
            $genericenterprise = 7; // vertical for generic enterprise
            $s = "select client_id  from clients_subdomains where leadpop_vertical_id != " . $genericenterprise;
            $s .= " and client_id = " . $client_id;
            $s .= " union distinct ";
            $s .= "select client_id from clients_domains where leadpop_vertical_id != " . $genericenterprise;
            $s .= " and client_id = " . $client_id;
            $res = $this->db->fetchAll($s);
            if (count($res) > 0) {
                return 'n';
            } else {
                return 'y';
            }
        }
    }
    */

    public function getPackagePermissions($client_id, $fields)
    {
        $s = "select " . $fields . " from  client_vertical_packages_permissions where client_id = " . $client_id . " limit 1 ";
        $perms = $this->db->fetchAll($s);
        if (count($perms) > 0 && $perms[0]["clone"] == 'y') {
            return 'y';
        } else {
            return 'n';
        }
    }

    public function getPageUrls($client_id, $page_id)
    {
        $s = "select * from  client_poppage_domains where page_id = " . $page_id . " and client_id = " . $client_id;
        $urls = $this->db->fetchAll($s);
        return $urls;
    }

    public function getImageSiteCss($page_id)
    {
        $s = "select css from fullimagesitecss where page_id = " . $page_id . " limit 1 ";
        $t = $this->db->fetchAll($s);
        return $t[0]["css"];
    }


    public function getTemplates()
    {
        $s = "select * from poppage_templates order by id ";
        $temps = $this->db->fetchAll($s);
        return $temps;

    }

    public function getPoppageDomains()
    {
        $s = "select * from  poppage_domains ";
        $domains = $this->db->fetchAll($s);
        return $domains;

    }

    public function getClientCategories($client_id)
    {
        $s = "select * from  client_categories where client_id = " . $client_id;
        $s .= " order by category_id ";
        $cats = $this->db->fetchAll($s);
        return $cats;
    }

    public function getCurrentPage($client_id, $page_id)
    {
        $s = "select * from poppages where id = " . $page_id;
        $s .= " and client_id = " . $client_id;
//			die($s);
        $page = $this->db->fetchRow($s);
        return $page;
    }

    /**
     * TODO:CLEAN-UP
     * We already have domain_name in funnel to show in link
     *
    public function getPreviewLink($client_id, $leadpop_id, $client_leadpop_version_seq)
    {
        $s = "select * from leadpops where id = " . $leadpop_id;
        $leadpop = $this->db->fetchRow($s);
        if ($leadpop['leadpop_type_id'] == '1') { // sub-domain
            $s = "select subdomain_name,top_level_domain from clients_subdomains ";
            $s .= "where client_id = " . $client_id . " and leadpop_vertical_id = " . $leadpop['leadpop_vertical_id'];
            $s .= " and leadpop_vertical_sub_id = " . $leadpop['leadpop_vertical_sub_id'];
            $s .= " and leadpop_template_id = " . $leadpop['leadpop_template_id'];
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_version_id = " . $leadpop['leadpop_version_id'];
            $s .= " and leadpop_version_seq = " . $client_leadpop_version_seq;
            $tempdomain = $this->db->fetchRow($s);
            $domain = $tempdomain['subdomain_name'] . "." . $tempdomain['top_level_domain'];
        } else if ($leadpop['leadpop_type_id'] == '2') { // domain
            $s = "select domain_name from clients_domains ";
            $s .= "where client_id = " . $client_id . " and leadpop_vertical_id = " . $leadpop['leadpop_vertical_id'];
            $s .= " and leadpop_vertical_sub_id = " . $leadpop['leadpop_vertical_sub_id'];
            $s .= " and leadpop_template_id = " . $leadpop['leadpop_template_id'];
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_version_id = " . $leadpop['leadpop_version_id'];
            $s .= " and leadpop_version_seq = " . $client_leadpop_version_seq;
            $domain = $this->db->fetchOne($s);
        }
        return $domain;

    }
     */

    public function getSeenWelcome($client_id)
    {
        $s = " select count(*) as cnt from show_welcome ";
        $s .= " where client_id = " . $client_id;
        $cnt = $this->db->fetchOne($s);
        if ($cnt == 0) {
            $s = "insert into show_welcome (client_id) values (" . $client_id . ") ";
            $this->db->query($s);
            return 'n';
        } else {
            return 'y';
        }
    }

    public function getPackageStates($client_id, $apackage)
    {
        $t = "";
        if ($apackage['package_id'] == '3' || $apackage['package_id'] == '4') {
            $s = "select state_code from client_leadpop_packages_states ";
            $s .= " where client_id = " . $client_id;
            $s .= " and package_id = " . $apackage['package_id'];
            $s .= " and leadpop_id = " . $apackage['leadpop_id'];
            $s .= " and leadpop_template_id = " . $apackage['leadpop_template_id'];
            $s .= " and leadpop_vertical_id = " . $apackage['leadpop_vertical_id'];
            $s .= " and leadpop_vertical_sub_id = " . $apackage['leadpop_vertical_sub_id'];
            $s .= " and leadpop_version_id = " . $apackage['leadpop_version_id'];
            $s .= " and leadpop_version_seq = " . $apackage['leadpop_version_seq'];
            $s .= " and leadpop_type_id = " . $apackage['leadpop_type_id'];
            $cstates = $this->db->fetchAll($s);

            $fcstates = array_values($cstates);

            $s = " select * from states order by state ";
            $states = $this->db->fetchAll($s);
            for ($i = 0; $i < count($states); $i++) {
                $selected = "";
                for ($j = 0; $j < count($fcstates); $j++) {
                    if ($states[$i]['state'] == $fcstates[$j]['state_code']) {
                        $selected = ' selected ';
                        break;
                    }
                }
                $t .= "<option " . $selected . " value='" . $states[$i]['state'] . "'>" . $states[$i]['state_name'] . "</option>\n";
            }
        }
        return $t;
    }

    public function getPackageData($client_id, $leadpop_id, $leadpop_version_seq)
    {
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lp = $this->db->fetchRow($s);

        $s = "select * from client_leadpop_packages where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_template_id = " . $lp['leadpop_template_id'];
        $s .= " and leadpop_vertical_id = " . $lp['leadpop_vertical_id'];
        $s .= " and leadpop_vertical_sub_id = " . $lp['leadpop_vertical_sub_id'];
        $s .= " and leadpop_version_id = " . $lp['leadpop_version_id'];
        $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
        $s .= " and leadpop_type_id = " . $lp['leadpop_type_id'];
        //die($s);
        $pk = $this->db->fetchRow($s);
        return $pk;
    }


    public function getPagingTotal($client_id, $leadpop_id, $leadpopversionseq, $numperpage)
    {
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lp = $this->db->fetchRow($s);

        $s = "select count(*) as cnt from ad_builder where client_id = " . $client_id;
        $s .= " and vertical_id = " . $lp['leadpop_vertical_id'];
        $s .= " and subvertical_id = " . $lp['leadpop_vertical_sub_id'];
        $s .= " and leadpop_type_id = " . $lp['leadpop_type_id'];
        $s .= " and leadpop_template_id = " . $lp['leadpop_template_id'];
        $s .= " and leadpop_version_id = " . $lp['leadpop_version_id'];
        $s .= " and leadpop_version_seq = " . $leadpopversionseq;

        $num = $this->db->fetchOne($s);
        return round($num / $numperpage);
    }

    public function getPagingLinks($client_id, $leadpop_id, $leadpopversionseq, $numperpage, $pagenum)
    {

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lp = $this->db->fetchRow($s);

        $s = "select count(*) as cnt from ad_builder where client_id = " . $client_id;
        $s .= " and vertical_id = " . $lp['leadpop_vertical_id'];
        $s .= " and subvertical_id = " . $lp['leadpop_vertical_sub_id'];
        $s .= " and leadpop_type_id = " . $lp['leadpop_type_id'];
        $s .= " and leadpop_template_id = " . $lp['leadpop_template_id'];
        $s .= " and leadpop_version_id = " . $lp['leadpop_version_id'];
        $s .= " and leadpop_version_seq = " . $leadpopversionseq;

        $num = $this->db->fetchOne($s);
        if ($num == 0) {
            $links = "";
        } else if ($num <= $numperpage) {
            $links = '<p class="bluecenter">Page: ' . $pagenum . ' of ' . $pagenum . '</p>';
        } else {
            $links = '<p class="bluecenter">Page: ' . $pagenum . ' of ' . round($num / $numperpage) . '</p>';
        }
        return $links;
    }

    public function getAdList($client_id, $leadpop_id, $leadpopversionseq, $numperpage, $pagenum)
    {
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lp = $this->db->fetchRow($s);

        if ($pagenum == 1) {
            $limit = " limit 0," . $numperpage;
        } else {
            $limit = " limit " . ((($pagenum - 1) * $numperpage)) . "," . $numperpage;
        }

        $s = "select * from ad_builder where client_id = " . $client_id;
        $s .= " and vertical_id = " . $lp['leadpop_vertical_id'];
        $s .= " and subvertical_id = " . $lp['leadpop_vertical_sub_id'];
        $s .= " and leadpop_type_id = " . $lp['leadpop_type_id'];
        $s .= " and leadpop_template_id = " . $lp['leadpop_template_id'];
        $s .= " and leadpop_version_id = " . $lp['leadpop_version_id'];
        $s .= " and leadpop_version_seq = " . $leadpopversionseq;
        $s .= " order by date_created desc ";
        $s .= $limit;
        $ads = $this->db->fetchAll($s);
        return $ads;
    }

    public function getLeadpopList($client_id)
    {
        $s = " select distinct a.leadpop_vertical_id ";
        $s .= " from leadpops a,clients_leadpops b ";
        $s .= " where b.client_id = " . $client_id;
        $s .= " and b.leadpop_id = a.id ";
        $s .= " and b.leadpop_active = 1 order by a.leadpop_vertical_id";

        $res = $this->db->fetchAll($s);
        return $res;
    }

//getCurrentIframePage($registry->leadpops->page_id,$this->client_id,$frameid);
    public function getCurrentIframePage($page_id, $client_id, $ckeditorid)
    {
        $s = " select a.*,b.* from iframes a,client_iframes b where a.iframe_id = b.iframe_id and b.page_id = " . $page_id;
        $s .= " and b.ckeditor_iframe_id = '" . $ckeditorid . "' ";
        $res = $this->db->fetchAll($s);
        return $res;
    }

    public function getIframeList()
    {
        $s = " select distinct vertical_name from iframes  order by vertical_name ";
        $res = $this->db->fetchAll($s);
        return $res;
    }

    public function getAdLeadpopList($client_id)
    {
        $s = " select distinct a.leadpop_vertical_id ";
        $s .= " from leadpops a,clients_leadpops b ";
        $s .= " where b.client_id = " . $client_id;
        $s .= " and b.leadpop_id = a.id ";

        $res = $this->db->fetchAll($s);

        return $res;
    }

    public function getTotalLeads($client_id)
    {

        $s = " select c.step,c.leadpop_id  from leadpops_leads a,clients_leadpops b,sessions c  ";
        $s .= "   where a.client_id = " . $client_id;
        $s .= " and a.unique_key = c.unique_key  ";
        //        $s .= " and a.deleted = 0 ";
        $s .= " and a.client_id = b.client_id ";
        $s .= " and a.leadpop_id = b.leadpop_id ";

        $res = $this->db->fetchAll($s);

        $completedPop = 0;

        for ($i = 0; $i < count($res); $i++) {
            $s = "select b.leadpop_steps ";
            $s .= " from leadpops a,leadpops_descriptions b ";
            $s .= " where a.id = " . $res[$i]['leadpop_id'];
            $s .= " and a.leadpop_version_id = b.id ";
            $numSteps = $this->db->fetchRow($s);
            if ($res[$i]['step'] >= $numSteps['leadpop_steps']) {
                $completedPop += 1;
            }

        }

        return $completedPop;

    }


    public function getFreshLeads($client_id)
    {
        $s = " select c.step,c.leadpop_id  from leadpops_leads a,clients_leadpops b,sessions c  ";
        $s .= " where a.client_id = " . $client_id;
        $s .= " and a.unique_key = c.unique_key  ";
        $s .= " and a.opened = 0  ";
        $s .= " and a.client_id = b.client_id ";
        $s .= " and a.leadpop_id = b.leadpop_id ";

        $res = $this->db->fetchAll($s);
        $completedPop = 0;

        for ($i = 0; $i < count($res); $i++) {
            $s = "select b.leadpop_steps ";
            $s .= " from leadpops a,leadpops_descriptions b ";
            $s .= " where a.id = " . $res[$i]['leadpop_id'];
            $s .= " and a.leadpop_version_id = b.id ";
            $numSteps = $this->db->fetchRow($s);
            if ($res[$i]['step'] >= $numSteps['leadpop_steps']) {
                $completedPop += 1;
            }
        }
        return $completedPop;
    }


    public function getTotalConversionRate($client_id)
    {
        $s = "select * from sessions where client_id = " . $client_id;
        $res = $this->db->fetchAll($s);
        $completedPop = 0;
        $totalAttempts = 0;
        for ($i = 0; $i < count($res); $i++) {
            $s = "select b.leadpop_steps ";
            $s .= " from leadpops a,leadpops_descriptions b ";
            $s .= " where a.id = " . $res[$i]['leadpop_id'];
            $s .= " and a.leadpop_version_id = b.id ";
//              print($s."<br>");
            $numSteps = $this->db->fetchRow($s);
            if ($res[$i]['step'] >= $numSteps['leadpop_steps'] && $res[$i]['step'] < 15) {
                $completedPop += 1;
            }
            $totalAttempts += 1;
        }
        if ($totalAttempts > 0) {
            $conversionRate = round(($completedPop / $totalAttempts) * 100) . '%';
        } else {
            $conversionRate = "N/A";
        }
        //print('c='.$completedPop.' <=> t='.$totalAttempts);
        //c=26 &lt;=&gt; t=190
        return $conversionRate;
    }

    public function getTotalVisitors($client_id)
    {
        $total = $this->getLastMonthDate();
        $s = "select count(distinct unique_key) as cnt from sessions  where client_id = " . $client_id;
        $total = $this->db->fetchRow($s);
        return $total['cnt'];
    }

    public function getVisitorsThisMonth($client_id)
    {
        $lastmonth = $this->getLastMonthDate();
        $s = "select count(distinct unique_key) as cnt from sessions  where client_id = " . $client_id;
        $s .= "  and initial_visit_time >=  " . $lastmonth;
        $month = $this->db->fetchRow($s);
        return $month['cnt'];
    }

    public function getVisitorsSinceSunday($client_id)
    {
        $sunday = $this->getPreviousSunday();
        $s = "select count(distinct unique_key) as cnt from sessions  where client_id = " . $client_id;
        $s .= "  and initial_visit_time >=  " . $sunday;
        $sinceSunday = $this->db->fetchRow($s);
        return $sinceSunday['cnt'];
    }

    private function getLastMonthDate()
    {
        return strtotime('last month');
    }

    private function getPreviousSunday()
    {
        $dow = date("w");
        if ($dow == 0) {
            $time = strtotime('midnight');
            return $time;
        } else {
            $t = strtotime("last sunday");
            return $t;
        }
    }

    //Comment: Myleads Model functions in here.


    function getMyLeadsData($export_all=false){


        $client_id = $_POST['client_id'];
        $leadpop_id  = $_POST['leadpop_id'];
        $leadpop_version_seq = $_POST['leadpop_version_seq'];
        $vertical_id = $_POST['vertical_id'];
        $vertical_sub_id = $_POST['vertical_sub_id'];
        $result_per_page = $_POST['result_per_page_val'];
        $myleadstart="";
        if(isset($_POST['myleadstart']))  $myleadstart = $_POST['myleadstart'];
        $myleadend="";
        if(isset($_POST['myleadend']))  $myleadend = $_POST['myleadend'];

        $s = "select leadpop_version_id from clients_leadpops where client_id = " . $client_id;
        $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
        $s .= " and leadpop_id = " . $leadpop_id;
        //print($s);
        $leadpop_version_id = $this->db->fetchOne($s);

        $letter="";
        if(isset($_POST['letter']))  $letter = $_POST['letter'];

        $date_sort="";
        if(isset($_POST['sortby']))  $date_sort = $_POST['sortby'];

        $search="";
        if(isset($_POST['search']))  $search = $_POST['search'];

        $page = (isset($_POST['page']) && $_POST['page'] != "" ? $_POST['page'] : 1);
        if($page == 1) {
            $limit = " limit 0,".$result_per_page;
        }else {
            $limit = " limit ".((($page-1)*$result_per_page)).",".$result_per_page;
        }

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $template_id = $lpres['leadpop_template_id'];

        $s = " SELECT *";
        if($export_all==true){
            $s = " SELECT id ";
        }

        $s .= ",firstname,lastname,email,DATE_FORMAT(date_completed, '%M %d, %Y') AS datecompleted ,opened,unique_key,phone";
        $s .= " from lead_content ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and deleted = 0 ";
        if(isset($letter) && $letter != "" &&  strtolower($letter) != "all") {
            $s .= " and (lower(substring(firstname,1,1)) = '".$letter."' OR lower(substring(lastname,1,1)) = '".$letter."')  ";
        }
        if(isset($search) && $search != "") {
            $s .= " and (lower(firstname) like '%".$search."%' OR lower(lastname) like '%".$search."%' )   ";
        }
        if("" != $myleadstart && "" != $myleadend  ){
            $s .= "	and DATE(`date_completed`) >= '$myleadstart' and DATE(`date_completed`) <= '$myleadend' ";
        }

        $s .= " order by date_completed ".$date_sort.",opened asc ";
        $query = $s; // for paging
        $data['total'] = ($this->db->fetchAll($query))?count($this->db->fetchAll($query)):0;
        $data['totalleads'] = format_number($data['total']);

        if($export_all==false) $s .=  $limit;
        $data['q'] = $s;
        $leaddata= $this->db->fetchAll($s);
        $l=0;
        $allkey=[];
        if($leaddata) {
            foreach ($leaddata as $lead) {

                if ($export_all == false) {
                    for ($i = 1; $i <= 50; $i++) {
                        $qindex = 'q' . $i;
                        if ($lead[$qindex] != "") {
                            $question = rtrim($lead[$qindex]);
                            $aindex = 'a' . $i;
                            $answer = $lead[$aindex];
                            $statecode = "";
                            $city = "";
                            if (stristr($question, 'zip')) {
                                $ss = "select state,city from zipcodes where zipcode = '" . trim($answer) . "' limit 1 ";
                                $resz = $this->db->fetchAll($ss);
                                if($resz) {
                                    $statecode = $resz[0]['state'];
                                    $city = $resz[0]['city'];
                                    $leaddata[$l]["address"] = $city . "-" . $statecode . "-" . $answer;
                                }
                                break;
                            }
                        }
                    }
                    if ("" == $city && "" == $statecode) $leaddata[$l]["address"] = "";

                } else if ($export_all == true) {
                    array_push($allkey, $lead["id"]);
                }
                $l++;
            }
        }
        $data['data']=$leaddata;
        $query2 = preg_replace("/SELECT(.*?)from/si","SELECT COUNT(id) as newleads from", $query);
        $query2 = preg_replace("/deleted = 0/si","deleted = 0 AND opened = 0", $query2);
        $newleads = $this->db->fetchOne($query2);
        $data['newleads'] = format_number($newleads);

        $data['allkey']=(!empty($allkey))?$allkey:0;
        return $data;
    }


    function getMyLeadsDataV1($export_all=false){
       /* if(env('TBL_LEAD_CONTENT_v2', 0) == 0){
            return $this->getMyLeadsDataV1($export_all);
        }*/

        $client_id = $_POST['client_id'];
        $leadpop_id  = $_POST['leadpop_id'];
        $leadpop_version_seq = $_POST['leadpop_version_seq'];
        $vertical_id = $_POST['vertical_id'];
        $vertical_sub_id = $_POST['vertical_sub_id'];
        $result_per_page = $_POST['result_per_page_val'];
        $myleadstart="";
        if(isset($_POST['myleadstart']))  $myleadstart = $_POST['myleadstart'];
        $myleadend="";
        if(isset($_POST['myleadend']))  $myleadend = $_POST['myleadend'];

        $s = "select leadpop_version_id from clients_leadpops where client_id = " . $client_id;
        $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
        $s .= " and leadpop_id = " . $leadpop_id;
        //print($s);
        $leadpop_version_id = $this->db->fetchOne($s);

        $letter="";
        if(isset($_POST['letter']))  $letter = $_POST['letter'];

        $date_sort="";
        if(isset($_POST['sortby']))  $date_sort = $_POST['sortby'];

        $search="";
        if(isset($_POST['search']))  $search = $_POST['search'];

        $page = (isset($_POST['page']) && $_POST['page'] != "" ? $_POST['page'] : 1);
        if($page == 1) {
            $limit = " limit 0,".$result_per_page;
        }else {
            $limit = " limit ".((($page-1)*$result_per_page)).",".$result_per_page;
        }

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $template_id = $lpres['leadpop_template_id'];

        $s = " SELECT *";
        if($export_all==true){
            $s = " SELECT id ";
        }

        $s .= ",firstname,lastname,email,DATE_FORMAT(date_completed, '%M %d, %Y') AS datecompleted ,opened,unique_key,phone";
        $s .= " from lead_content";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and deleted = 0 ";
        if(isset($letter) && $letter != "" &&  strtolower($letter) != "all") {
            $s .= " and (lower(substring(firstname,1,1)) = '".$letter."' OR lower(substring(lastname,1,1)) = '".$letter."')  ";
        }
        if(isset($search) && $search != "") {
            $s .= " and (lower(firstname) like '%".$search."%' OR lower(lastname) like '%".$search."%' )   ";
        }
        if("" != $myleadstart && "" != $myleadend  ){
            $s .= "	and DATE(`date_completed`) >= '$myleadstart' and DATE(`date_completed`) <= '$myleadend' ";
        }

        $s .= " order by date_completed ".$date_sort.",opened asc ";
        $query = $s; // for paging
        $data['total'] = ($this->db->fetchAll($query))?count($this->db->fetchAll($query)):0;
        $data['totalleads'] = format_number($data['total']);

        if($export_all==false) $s .=  $limit;
        $data['q'] = $s;
        $leaddata= $this->db->fetchAll($s);

        $l=0;
        $allkey=[];

        $data['data']=$leaddata;
        $query2 = preg_replace("/SELECT(.*?)from/si","SELECT COUNT(id) as newleads from", $query);
        $query2 = preg_replace("/deleted = 0/si","deleted = 0 AND opened = 0", $query2);
        $newleads = $this->db->fetchOne($query2);
        $data['newleads'] = format_number($newleads);

        $data['allkey']=(!empty($allkey))?$allkey:0;
        return $data;
    }
    function getAllFunnelKey(){
        return $this->getMyLeadsData(true);
    }

    /**
     * @param $delete_ids_str string   ~ seperated string
     * @param $client_id int
     * @return int
     */
    function deleteSelectesLeads($delete_ids_str, $client_id){
        ini_set('memory_limit', -1);
        $counter = 0;
        $ids = explode("~",$delete_ids_str);
        if($ids){
            foreach($ids as $id){
                $s = "select id from lead_content where id = '" . $id . "' and client_id = " . $client_id . " limit 1 ";
                $lc = $this->db->fetchRow($s);
                if ($lc) {
                    $s = "update lead_content set deleted = 1 where id = '" . $id . "' and client_id = " . $client_id;
                    $this->db->query($s);
                    $counter++;
                }
            }
        }
        return $counter;
    }

    //=======================================================//

    function updateLeadStatus(){
        $unique_key = $_POST['unique_key'];
        $s = " update leadpops_leads set opened = 1 where unique_key = '".$unique_key."' ";
        $this->db->query($s);
        return $s;
    }

    function getLeadDetail(){
    /*    if(env('TBL_LEAD_CONTENT_v2', 0) == 0){
            return $this->getLeadDetailV1();
        }*/

        $client_id = $_POST['client_id'];
        $unique_key  = $_POST['unique_key'];

        $s = "update lead_content set opened = '1'  ";
        $s .= " WHERE id  = '" . $unique_key."' ";
        $s .= " and client_id = " . $client_id ;
        $this->db->query($s);

        $s = "SELECT * from lead_content";
        $s .= " WHERE id  = '" . $unique_key."' ";
        $s .= " and client_id = " . $client_id ;
        $lead = $this->db->fetchRow($s);

        if($lead) {
            $u = "SELECT * from  lead_headings  ";
            $u .= " WHERE leadpop_id =  " . $lead['leadpop_id'];
            $u .= " order by display_sequence, display_order ";
            $z = $this->db->fetchAll($u);

            $data = View("partials.lead-preview-v2", compact('lead', 'z', 'unique_key', 'client_id'))
                ->render();
            return $data;
        }
    }



    function getLeadDetailV1(){
        $client_id = $_POST['client_id'];
        $unique_key  = $_POST['unique_key'];

        // $aunique_key = explode("-" , $unique_key);
        // $thetime = end($aunique_key);
        // $ipaddress = str_replace($thetime , "" , $aunique_key[0]);

        $s = "update lead_content set opened = '1'  ";
        $s .= " WHERE id  = '" . $unique_key."' ";
        $s .= " and client_id = " . $client_id ;
        $this->db->query($s);

        $s = "SELECT * from lead_content  ";
        $s .= " WHERE id  = '" . $unique_key."' ";
        $s .= " and client_id = " . $client_id ;
        $lead = $this->db->fetchRow($s);

        $u = "SELECT * from  lead_headings  ";
        $u .= " WHERE leadpop_id =  " . $lead['leadpop_id'];
        $u .= " order by display_sequence, display_order ";
        $z = $this->db->fetchAll($u);

        //we are using for lead preview in theme3. TODO:after live the theme3 may be we need to change the env app_theme logic
        if(getenv('APP_THEME') == 'theme_admin3'){

            $data =  View("partials.lead-preview",compact('lead' ,'z','unique_key','client_id'))
                ->render();
            return $data;
        }

        $unique_arr = explode("-", $lead["unique_key"]);
        $common_str = substr($unique_arr[1], 0, 10);
        $ipaddress = str_replace($common_str, "", $unique_arr[0]);

        $contact_arr = array();
        $contact_seq = array('First Name','Last Name','Email','Primary Email','Phone','Primary Phone');
        for($i=1; $i<= 50; $i++) {
            $qindex = 'q'.$i;
            if($lead[$qindex] != "") {
                $question = rtrim($lead[$qindex]);
                $aindex = 'a'.$i;
                $answer = $lead[$aindex];
                if (in_array($question, $contact_seq)) {
                    if(in_array($question, array('First Name','Last Name')))  $answer=ucfirst($answer);
                    $contact_arr[$question] = $answer;
                }

            }
        }


        $s = "";
        $heading = "";
        $primaryemail = "";
        $s .='<div class="modal-dialog">';
        $s .='<div class="modal-content">';
        $s .='<div class="modal-header">';
        if($heading == "") {
            $heading  =  (isset($z[0]['heading']))?$z[0]['heading']:$lead["firstname"]." ".$lead["lastname"];
            $s .='<h3 class="modal-title">'.$heading.'</h3>';
        }
        $s .='</div>';
        $s .='<div class="modal-body">';
        $s .='<div class="my-lead-action-box">';
        $s .='<div class="row">';
        $s .='<div class="col-sm-10">';
        $s .='<ul class="my-lead-action">';

        $s .='<li><a href="'.LP_BASE_URL.LP_PATH.'/export/exportsworddata?u='.$unique_key.'&client_id='.$client_id.'" ><i class="lp-icon-modal-strip doc-icon"></i>
                                            <span class="action-title">Export As Doc</span></a></li>';
        /*$s .='<li><a href="javascript:void(0);" onclick=exportPopLead("'.LP_BASE_URL.'/downloads/downloadwordleft.php","excelIframe","'.$unique_key.'"); ><i class="lp-icon-modal-strip doc-icon"></i>
                <span class="action-title">Export As Doc</span></a></li>';*/
        $s .='<li><a href="'.LP_BASE_URL.LP_PATH.'/export/exportsexcelddata?u='.$unique_key.'&client_id='.$client_id.'" ><i class="lp-icon-modal-strip excel-icon"></i>
                                            <span class="action-title">Export Excel</span></a></li>';
        $s .='<li><a href="'.LP_BASE_URL.LP_PATH.'/export/exportspdfdata?u='.$unique_key.'&client_id='.$client_id.'" ><i class="lp-icon-modal-strip pdf-icon"></i>
                                            <span class="action-title">Export As Pdf</span></a></li>';
        $s .='<li><a href="javascript:void(0);" id="printmailtopophref" data-uniquekey="'.$unique_key.'"><i class="lp-icon-modal-strip print-icon"></i>
                                            <span class="action-title">Print</span></a></li>';
        $s .='<li><a href="javascript:void(0);" id="mailtopophref" data-uniquekey="'.$unique_key.'"><i class="lp-icon-modal-strip email-icon"></i>
                                            <span class="action-title">Email</span></a></li>';
        /*$s .='<li><a href="javascript:void(0);" onclick=exportPopLead("'.LP_BASE_URL.'/downloads/downloadoutlook.php","excelIframe","'.$unique_key.'");><i class="lp-icon-modal-strip vcard-icon"></i>
                <span class="action-title">Vcard</span></a></li>';*/
        $s .='</ul>';
        $s .='</div>';
        $s .='<div class="col-sm-2 text-right">';
        $s .='<a id="leadpopdelete" data-uniquekey="'.$unique_key.'"  class="btn btn-default my-lead-del-btn popup-del-btn"><i class="fa fa-times danger" aria-hidden="true"></i> Delete</a>';
        $s .='</div>';
        $s .='</div>';
        $s .='</div>';
        $s .='<div class="lp-lead-modal-wrapper">';
        $s .='<div class="row">';
        $s .='<div class="col-sm-12">';
        $s .='<div class="lead-modal-des">';
        foreach ($contact_arr as $q => $a) {
            $s .='<div class="outer">';
            $s .='<div class="modal-left">';
            $s .='<h5>'.$q.':</h5>';
            $s .='</div>';
            $s .='<div class="modal-right">';
            $s .='<h5>'.$a.'</h5>';
            $s .='</div>';
            $s .='</div>';
        }
        $s .='</div>';
        $s .='</div>';
        $s .='</div>';
        $s .='<div class="row">';
        $s .='<div class="col-sm-12">';
        $s .='<div class="lead-modal-des-2">';

        for($i=1; $i<= 50; $i++) {
            $qindex = 'q'.$i;
            if($lead[$qindex] != "") {
                $question = rtrim($lead[$qindex]);
                $aindex = 'a'.$i;
                $answer = $lead[$aindex];
                if($answer==="computer"){
                    $answer="Desktop";
                }
                else if($answer==="phone" ){
                    $answer="Tablet/Smartphone";
                }

                if(stristr($question,'email')) {
                    $primaryemail = $answer;
                }
                $statecode = "";
                $city = "";
                if(stristr($question,'zip')) {
                    $ss = "select state,city from zipcodes where zipcode = '".trim($answer)."' limit 1 ";
                    $resz = $this->db->fetchAll($ss);
                    $statecode = $resz[0]['state'];
                    $city = $resz[0]['city'];
                }

                if (!in_array($question, $contact_seq)) {
                    $fans=($statecode == "")?$answer:$answer."-".$city."-".$statecode;
                    // if ($question == "Query String") $fans =  str_replace("~","&",$fans);
                    $s .='<div class="outer" '.($question == "Referrer" ? " style='display: none' ":'').'>';
                    $s .='<div class="modal-left">';
                    $s .='<h5>'.$question.':</h5>';
                    $s .='</div>';
                    $s .='<div class="modal-right">';
                    // $s .='<h5>'.$fans.'</h5>';
                    $s .='<h5'.($question == "Query String" ? " style='line-height: 1.2;max-width: 500px;word-wrap: break-word' ":'').'>'.$fans.'</h5>';
                    $s .='</div>';
                    $s .='</div>';
                }
            }
        }
        // $s .='<div class="outer"><div class="modal-left"><h5>IP Address:</h5></div><div class="modal-right"><h5>'.$ipaddress.'</h5></div></div>';
        $s .='</div>';
        $s .='</div>';
        $s .='</div>';
        $s .='</div>';
        $s .='<div class="lp-modal-footer">';
        $s .='<a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>';
        $s .='</div>';
        $s .='</div>';
        $s .='</div>';
        $s .='</div>';
        $s =  str_replace("::",":",$s);
        return $s;
    }

    private function get_longest_common_subsequence( $str1, $str2, $case_sensitive = false ) {
        // First check to see if one string is the same as the other.
        if ( $str1 === $str2 ) return $str1;
        if ( ! $case_sensitive && strtolower( $str1 ) === strtolower( $str2 ) ) return $str1;

        // We'll use '#' as our regex delimiter. Any character can be used as we'll quote the string anyway,
        $delimiter = '#';

        // We'll find the shortest string and use that to check substrings and create our regex.
        $l1 = strlen( $str1 );
        $l2 = strlen( $str2 );
        $str = $l1 <= $l2 ? $str1 : $str2;
        $str2 = $l1 <= $l2 ? $str2 : $str1;
        $l = min( $l1, $l2 );

        // Next check to see if one string is a substring of the other.
        if ( $case_sensitive ) {
            if ( strpos( $str2, $str ) !== false ) {
                return $str;
            }
        }
        else {
            if ( stripos( $str2, $str ) !== false ) {
                return $str;
            }
        }

        // Regex for each character will be of the format (?:a(?=b))?
        // We also need to capture the last character, but this prevents us from matching strings with a single character. (?:.|c)?
        $reg = $delimiter;
        for ( $i = 0; $i < $l; $i++ ) {
            $a = preg_quote( $str[ $i ], $delimiter );
            $b = $i + 1 < $l ? preg_quote( $str[ $i + 1 ], $delimiter ) : false;
            $reg .= sprintf( $b !== false ? '(?:%s(?=%s))?' : '(?:.|%s)?', $a, $b );
        }
        $reg .= $delimiter;
        if ( ! $case_sensitive ) {
            $reg .= 'i';
        }
        // Resulting example regex from a string 'abbc':
        // '#(?:a(?=b))?(?:b(?=b))?(?:b(?=c))?(?:.|c)?#i';

        // Perform our regex on the remaining string
        $str = $l1 <= $l2 ? $str2 : $str1;
        if ( preg_match_all( $reg, $str, $matches ) ) {
            // $matches is an array with a single array with all the matches.
            return array_reduce( $matches[0], function( $a, $b ) {
                $al = strlen( $a );
                $bl = strlen( $b );
                // Return the longest string, as long as it's not a single character.
                return $al >= $bl || $bl <= 1 ? $a : $b;
            }, '' );
        }

        // No match - Return an empty string.
        return '';
    }
    function getMyLeadPopEmail(){
        $report_path = $_SERVER['DOCUMENT_ROOT']."/files/";
        $sunique = $_POST['u'];
        $s = "";
        $filename = "";

        $s1 = "SELECT a.* from lead_content a  ";
        $s1 .= " WHERE a.unique_key  = '" . $sunique."' limit 1 ";
        $lead = $this->db->fetchRow($s1);

        $client_id = $lead["client_id"];

        $m = "select first_name,last_name from clients where client_id = " . $client_id;
        $fn = $this->db->fetchRow($m);
        $filename = preg_replace("[^a-zA-Z0-9]", "",$fn['first_name'].$fn['last_name']).date('m-d-Y-g-i-a').".doc";

        $u = "SELECT * from  lead_headings  ";
        $u .= " WHERE leadpop_id =  " . $lead['leadpop_id'];
        $u .= " order by display_sequence, display_order ";
        $z = $this->db->fetchAll($u);

        $heading  =  (isset($z[0]['heading']))?$z[0]['heading']:"Lead Information";
        if($heading) {
            $s .= "<p style='margin-bottom: 4px; margin-top: 4px;  text-align: center; font-family: arial, helvetica, sans-serif; font-size: 14px; font-weight: bold'>".$this->getleadname($client_id,$sunique)."</p>";
            $s .= "<table border='0' cellspacing='0'>";
            $s .= "<tr style='background: #f4f4f4'><td align='center' colspan='3'><b>".$heading."</b></td></tr>";
        }
        for($i=1; $i< 51; $i++) {
            $qindex = 'q'.$i;
            if($lead[$qindex] != "") {
                $question = $lead[$qindex];
                $aindex = 'a'.$i;
                $answer = $lead[$aindex];
                $s .= "<tr><td align='left' class='tdtextlead' width='36%'><b>".$question.":</b></td>";
                $s .= "<td align='left' colspan='2' class='tdtextlead' width='36%'>".$answer."</td></tr>";
            }
        }
        $s .= "</table>'";
        $s .= "<hr />";

        $report = $report_path . $filename;
        $rep = fopen($report, 'w+');
        fwrite($rep,$s);
        fclose($rep);
        $time = time() + (3*86400);
        $expire = date('m/d/Y g:i a',$time);
        $link = "Visit ".LP_BASE_URL."/files/" . $filename . " to view. Files will remain active until ". $expire;
        return $link;
    }
    function deleteMyLeadPop(){
        $sunique = $_POST['u'];
        $client_id = $_POST['client_id'];
        $s = "select * from lead_content where id = '".$sunique."' and client_id = " . $client_id." limit 1 ";
        $lc = $this->db->fetchRow($s);
        if ($lc) {
            $s = "update lead_content set deleted = 1 where id = '".$sunique."' and client_id = " . $client_id;
            $this->db->query($s);
        }else{
            $s = 'DB Records not found in lead_content table!';
        }
        return $s;
    }
    function formatPhone($phone) {

        if (empty($phone)) return "";
        if (strlen($phone) == 7)
            sscanf($phone, "%3s%4s", $prefix, $exchange);
        else if (strlen($phone) == 10)
            sscanf($phone, "%3s%3s%4s", $area, $prefix, $exchange);
        else if (strlen($phone) > 10)
            if(substr($phone,0,1)=='1') {
                sscanf($phone, "%1s%3s%3s%4s", $country, $area, $prefix, $exchange);
            }
            else{
                sscanf($phone, "%3s%3s%4s%s", $area, $prefix, $exchange, $extension);
            }
        else
            return "unknown phone format: $phone";

        $out = "";
        $out .= isset($country) ? $country.' ' : '';
        $out .= isset($area) ? '(' . $area . ') ' : '';
        $out .= $prefix . '-' . $exchange;
        $out .= isset($extension) ? ' x' . $extension : '';
        return $out;
    }
    function getleadname ($client_id,$unique_key)  {

        $s = " SELECT firstname,lastname,email,phone,date_completed    ";
        $s .= " from lead_content  " ;
        $s .= " WHERE client_id = " . $client_id;
        $s .= " and unique_key = '".$unique_key."' limit 1 ";

        $r = $this->db->fetchRow($s);
        $dtime = strtotime($r['date_completed']);
        $dt = date('d/m/Y g:i a');

        //$phone = ereg_replace("[^0-9]", "", $r['phone'] );
        $phone = preg_replace("[^0-9]", "", $r['phone'] );
        $phone = $this->formatPhone($phone);
        $s = ucfirst($r['firstname'])." ".ucfirst($r['lastname'])." | ". $phone . " | ". $r['email'] . " |  Completed " . $dt;
        return  ($s);
    }
}
