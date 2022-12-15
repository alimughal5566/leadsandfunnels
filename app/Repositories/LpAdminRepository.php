<?php
/**
 * Created by PhpStorm.
 * User: Jazib Javed
 * Date: 05/11/2019
 * Time: 5:45 PM
 */

/**
 * Code Migrated from Zend to Laravel  ==>  LpAdminRepository --> Source: Default_Model_LpAdmin (LpAdmin.php)
 */

namespace App\Repositories;
use App\Constants\FunnelVariables;
use Illuminate\Support\Facades\Auth;
use App\Services\DataRegistry;
use App\Services\DbService;
use Illuminate\Support\Facades\DB;
use LP_Helper;

class LpAdminRepository
{
    use Response;
    private $db;
    public $_verical=array();
    public $_sub_verical=array();

    public function __construct(DbService $service){
        $this->db = $service;
    }

    function getVideoByKey($controller, $action){
        $key = $controller."-".$action;

        if($key=="index-index"){
            $client_type=str_replace(' ','-',strtolower(LP_Helper::getInstance()->getClientType()));
            $key=$controller."-".$client_type;
        }

        $session = LP_Helper::getInstance()->getSession();
        $vertical_id = @$session->clientInfo->client_type || 3;

     //   $query="Select title,url,thumbnail,wistia_id  from support_videos WHERE vkey='".$key."'";
        //@todo need to adjust it after vertical based videos.
        $query="Select title,url,thumbnail,wistia_id  from ".config('database.tables.support_videos')." WHERE vkey='".$key."' and vertical_id ='".$vertical_id."' ";
        return $this->db->fetchrow($query);
    }


    function getVideosByKeys($keys){
        $session = LP_Helper::getInstance()->getSession();
        $vertical_id = @$session->clientInfo->client_type || 3;

        $_supportVideos = \DB::table(config('database.tables.support_videos'))
            ->select('vkey', 'title','url','thumbnail','wistia_id')
            ->where("vertical_id", $vertical_id)
            ->whereIn("vkey", $keys)
            ->get();
        $supportVideos = [];

        foreach ($_supportVideos as $supportVideo) {
            $supportVideos[$supportVideo->vkey] = $supportVideo;
        }

        return $supportVideos;
    }

    public function CheckDashboardActive($client_id){
        $q = "SELECT * FROM clients WHERE client_id = '" . $client_id . "'";
        return $this->db->fetchrow($q);
    }

    function setCommonDataForGlobalChanges(){
        $s = "select * from leadpops_verticals";
        $leadpop_ver = $this->db->fetchall($s);
        foreach ($leadpop_ver as $lpverd) {
            $this->_vertical[$lpverd["id"]]=strtolower(str_replace(' ', '', $lpverd["lead_pop_vertical"]));
        }
        $s = "select * from leadpops_verticals_sub ";
        $leadpop_sub_ver = $this->db->fetchall($s);
        foreach ($leadpop_sub_ver as $lpsverd) {
            $this->_sub_verical[$lpsverd["id"]]=strtolower(str_replace(' ', '', $lpsverd["lead_pop_vertical_sub"]));
        }

    }

    public function getLeadPopTitle($leadpop_vertical_id, $leadpop_vertical_sub_id, $leadpop_version_id, $leadpop_version_seq) {
        $s = "SELECT leadpop_title FROM leadpops_descriptions WHERE leadpop_vertical_id = " . $leadpop_vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
        $s .= " and id = " . $leadpop_version_id;
        $leadpop_title = $this->db->fetchOne($s);
        $leadpop_title = $leadpop_title . "-" . $leadpop_version_seq;
        return $leadpop_title;
    }

    /* Code taken from Default_Model_Customize */
    public function getDomainDescription($funnel_info) {
        $leadpop_id = $funnel_info['leadpop_id'];
        $verticalName = strtolower($funnel_info['lead_pop_vertical']);
        $subverticalName = strtolower($funnel_info['lead_pop_vertical_sub']);
        $popdescr = $this->getLeadPopTitle($funnel_info['leadpop_vertical_id'], $funnel_info['leadpop_vertical_sub_id'], $funnel_info['leadpop_version_id'], $funnel_info['leadpop_version_seq']);

        $funnelData = \DB::table("clients_funnels_domains As cs")
            ->select("cs.clients_domain_id AS domain_id", "cs.domain_name","cs.subdomain_name", "cs.top_level_domain", "cs.leadpop_type_id", "cl.leadpop_active")
            ->join('leadpops AS lp', function ($join) {
                $join->on('lp.id', '=', DB::raw('cs.leadpop_id'));
            })
            ->join('clients_leadpops AS cl', function ($join) {
                $join->on('cl.leadpop_id', '=', DB::raw('cs.leadpop_id'))
                    ->where('cl.client_id', DB::raw('cs.client_id'))
                    ->where('cl.leadpop_version_id', DB::raw('cs.leadpop_version_id'))
                    ->where('cl.leadpop_version_seq', DB::raw('cs.leadpop_version_seq'));
            })
            ->where("cs.client_id", $funnel_info['client_id'])
            ->where("cs.leadpop_version_id", $funnel_info['leadpop_version_id'])
            ->where("cs.leadpop_version_seq", $funnel_info['leadpop_version_seq'])
            ->first();

        if($funnelData->leadpop_type_id == config('leadpops.leadpopDomainTypeId')) {
            $domain_name = $funnelData->domain_name;
            $topLevelDomainName = "notop";
            $domainType = ' Domain ';
        } else {
            $domainType = ' Sub-Domain ';
            $domain_name = $funnelData->subdomain_name;
            $topLevelDomainName = $funnelData->top_level_domain;
        }

        $status = $funnelData->leadpop_active == '1' ? " (active) " : " (inactive) ";

        $descr = $popdescr . " is a " . $domainType . " in category " . ucfirst($verticalName) . "/" . ucfirst($subverticalName) . " ".$status;
        return $descr . "~".$funnelData->leadpop_type_id."~".$topLevelDomainName."~".$domain_name."~" . $funnelData->domain_id;
    }

    /* Code taken from Default_Model_Customize */
    public function getWorkingLeadpopDescription($funnel_info) {
        $leadpop_id = $funnel_info['leadpop_id'];

        $funnelData = \DB::table("clients_funnels_domains As cs")
            ->select("cs.clients_domain_id AS domain_id", "cs.domain_name","cs.subdomain_name", "cs.top_level_domain", "cs.leadpop_type_id", "cl.leadpop_active")
            ->join('leadpops AS lp', function ($join) {
                $join->on('lp.id', '=', DB::raw('cs.leadpop_id'));
            })
            ->join('clients_leadpops AS cl', function ($join) {
                $join->on('cl.leadpop_id', '=', DB::raw('cs.leadpop_id'))
                    ->where('cl.client_id', DB::raw('cs.client_id'))
                    ->where('cl.leadpop_version_id', DB::raw('cs.leadpop_version_id'))
                    ->where('cl.leadpop_version_seq', DB::raw('cs.leadpop_version_seq'));
            })
            ->where("cs.client_id", $funnel_info['client_id'])
            ->where("cs.leadpop_version_id", $funnel_info['leadpop_version_id'])
            ->where("cs.leadpop_version_seq", $funnel_info['leadpop_version_seq'])
            ->first();

        if($funnelData->leadpop_type_id == config('leadpops.leadpopDomainTypeId')) {
            if($funnelData->leadpop_active == '1') {
                $ret = "<span style='color: #a2a1a1'>&nbsp;&nbsp;leadPop:</span> <a class='bluetexthead' href='http://" . $funnelData->domain_name . "' target='_blank'>" . $funnelData->domain_name . "</a>";
            }
            else {
                $ret = "<span style='color: #a2a1a1'>&nbsp;&nbsp;leadPop:</span> <a  class='bluetexthead' href='#'>" . $funnelData->domain_name . " (inactive)</a>";
            }
        }
        else {
            $domain_name = $funnelData->subdomain_name . "." . $funnelData->top_level_domain;
            if($funnelData->leadpop_active == '1') {
                $ret = "<span style='color: #a2a1a1'>&nbsp;&nbsp;leadPop:</span> <a  class='bluetexthead' href='http://" . $domain_name . "' target='_blank'>" . $domain_name . "</a>";
            }
            else {
                $ret = "<span style='color: #a2a1a1'>&nbsp;&nbsp;leadPop:</span> <a  class='bluetexthead' href='#'>" . $domain_name . " (inactive)</a>";
            }
        }
        return $ret;
    }

    /* Code taken from Default_Model_Customize */
    public function getLeadpopUrl($funnel_info) {
        $leadpop_id = $funnel_info['leadpop_id'];

        $funnelData = \DB::table("clients_funnels_domains As cs")
            ->select("cs.clients_domain_id AS domain_id", "cs.domain_name","cs.subdomain_name", "cs.top_level_domain", "cs.leadpop_type_id")
            ->join('leadpops AS lp', function ($join) {
                $join->on('lp.id', '=', DB::raw('cs.leadpop_id'));
            })
            ->where("cs.client_id", $funnel_info['client_id'])
            ->where("cs.leadpop_version_id", $funnel_info['leadpop_version_id'])
            ->where("cs.leadpop_version_seq", $funnel_info['leadpop_version_seq'])
            ->first();

        return ($funnelData->leadpop_type_id == config('leadpops.leadpopDomainTypeId') ? $funnelData->domain_name : $funnelData->subdomain_name.".".$funnelData->top_level_domain);
    }

    /* Code taken from Default_Model_Customize */
    public function getLeadpopStatus($funnel_info) {
        $registry = DataRegistry::getInstance();
        $leadpop_id = $funnel_info['leadpop_id'];
        $version_seq = $funnel_info['leadpop_version_seq'];
        $client_id = $funnel_info['client_id'];

        $s = "select * from leadpops where id = " . $leadpop_id;
        $leadpop = $this->db->fetchRow($s);
        $leadpop_version_id = $leadpop['leadpop_version_id'];

        $s = "select leadpop_active from clients_leadpops where ";
        $s .= " client_id =  " . $client_id;
        $s .= " and leadpop_version_id =  " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $lpactive = $this->db->fetchOne($s);
        return $lpactive;
    }

    /* Code taken from Default_Model_Leadpops */
    public function getPackagePermissions($client_id, $fields) {
        $s = "select " . $fields . " from  client_vertical_packages_permissions where client_id = " . $client_id . " limit 1 ";
        $perms = $this->db->fetchAll($s);
        if ( count($perms) > 0 && $perms[0]["clone"] == 'y') {
            return 'y';
        }
        else {
            return 'n';
        }
    }

    /* Code taken from Default_Model_Login */
    public function isfreetrial($cookie){

        $s = "select client_id from trial_final_data where session_id = '" . $cookie . "' limit 1 ";
        $check = $this->db->fetchRow($s);
        if (!$check) {
            return 0;
        } else {
            $s = "SELECT * FROM clients WHERE client_id = " . $check["client_id"] . " limit 1 ";
            $res = $this->db->fetchRow($s);

            Auth::loginUsingId($res['client_id']);
            // put row into table for cron to check if client directories created
            $registry = DataRegistry::getInstance();
            $registry->leadpops->sales_id = 1; // andrew
            $registry->leadpops->salesmansale = "y";
            $registry->leadpops->client_id = $check["client_id"];
            $registry->leadpops->clientInfo = $res;
            $registry->leadpops->tag_filter = array();
            $registry->leadpops->skip_survey = 0;
            $registry->leadpops->loggedIn = 1;
            $registry->leadpops->show_overlay = $res["overlay_flag"];
            $registry->leadpops->hasSale = "y";
            $registry->updateRegistry();

            return $check["client_id"];
        }
    }

    /* Code taken from Default_Model_Login */
    public function isloantekclient($cookie){
        $s = "select client_id from loantek_final_data where session_id = '" . $cookie . "' limit 1 ";
        $check = $this->db->fetchRow($s);
        if (!$check) {
            return 0;
        } else {
            $s = "select * from clients  ";
            $s .= " where  client_id = " . $check["client_id"] . " limit 1 ";
            $res = $this->db->fetchRow($s);
            // put row into table for cron to check if client directories created
            $registry = DataRegistry::getInstance();
            $registry->leadpops->sales_id = 1; // andrew
            $registry->leadpops->salesmansale = "y";
            $registry->leadpops->client_id = $check["client_id"];
            $registry->leadpops->clientInfo = $res;
            $registry->leadpops->loggedIn = 1;
            $registry->leadpops->show_overlay = $res["overlay_flag"];
            $registry->leadpops->hasSale = "y";
            $registry->updateRegistry();
            return $check["client_id"];
        }
    }

    /* Code taken from Default_Model_Login */
    public function deletetrialdata($cookie){
        $s = "delete from trial_final_data where session_id = '" . $cookie . "' limit 1 ";
        $this->db->query($s);
        $s = "delete from free_trial_builder where session_id = '" . $cookie . "' limit 1 ";
        $this->db->query($s);
        $s = "delete from client_default_swatches where session_id = '" . $cookie . "'  ";
        $this->db->query($s);
    }

    function deleteLogoGlobal(){
        $client_id = $_POST['client_id'];
        $logo_id  = $_POST['logo_id'];
        $s = "select $logo_id  from global_settings where client_id =  " . $client_id;
        $logo_file_url = $this->db->fetchOne($s);
        $lfe=explode("/", $logo_file_url);
        $logoname=end($lfe);
        $section = substr($client_id,0,1);
        $logopath = $_SERVER['DOCUMENT_ROOT'].'/images/clients/'.$section.'/'.$client_id.'/logos/'.$logoname;
        @unlink($logopath);
        $s = "update global_settings set $logo_id = ''";
        $s .= " where client_id = " . $client_id;
        $this->db->query($s);
        return true;
    }

    /**
     * @since 2.1.0 - CR-Funnel-Builder:
     * Moved leadpops_templates_placeholders_values -> placeholder_sixtyone   ==>   clients_leadpops -> funnel_variables::front_image
     *
     */
    function deleteLogo(){
        $client_id = $_POST['client_id'];
        $logo_id  = $_POST['logo_id'];
        $s = "select use_default, use_me, logo_src  from leadpop_logos where id =  " . $logo_id;
        $logo = $this->db->fetchRow($s);
        $logo_name = $logo['logo_src'];

        // SET DEFAULT BACKGROUND IF LOGO IS CURRENTLY IMPLEMENTED
        if(@$_POST['key']){

            @list($client_id,$vertical_id,$subvertical_id,$leadpop_id,$version_seq,$leadpop_template_id,$leadpop_version_id,$leadpop_type_id) = explode('~',$_POST['key']);

            $s = "select logo_src from current_logo  ";
            $s .= " where  client_id 	= " . $client_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_version_id  	= " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq . " limit 1 ";
            $exists = $this->db->fetchOne($s);

            if(@$exists==$logo_name && $logo['use_me'] == "y"){
                $background_from_logo = '###>*/background-color: rgba(171, 179, 182, 1);/*@@@*/ background-image: linear-gradient(to right bottom,rgba(171, 179, 182, 1) 0%,rgba(171, 179, 182, 1) 100%); /* W3C */';

                $s = "delete from leadpop_background_color ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id ;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query($s);

                $s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
                $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
                $s .= "background_color,active,default_changed) values (null,";
                $s .= $client_id . "," . $vertical_id . ",";
                $s .= $subvertical_id . ",";
                $s .= $leadpop_type_id . "," . $leadpop_template_id . ",";
                $s .= $leadpop_id . ",";
                $s .= $leadpop_version_id . ",";
                $s .= $version_seq . ",";
                $s .= "'" . addslashes($background_from_logo) . "','y','n')";
                $this->db->query($s);

                // Background swatches :: START
                // deleting old logo swatched + adding default logo swatches
                // if logo which we are deleting is current selected logo
                $q = "DELETE from leadpop_background_swatches " .
                    " WHERE client_id = " . $client_id .
                    " AND leadpop_version_id =" . $leadpop_version_id .
                    " AND leadpop_version_seq =" . $version_seq;
                $this->db->query($q);

                $inserts = [];
                $swatches = LP_Helper::getInstance()->getDefaultSwatches($client_id);
                foreach ($swatches as $idx => $sw) {
                    $inserts[] = [
                        "client_id" => $client_id,
                        "leadpop_id" => $leadpop_id,
                        "leadpop_type_id" => $leadpop_type_id,
                        "leadpop_vertical_id" => $vertical_id,
                        "leadpop_vertical_sub_id" => $subvertical_id,
                        "leadpop_template_id" => $leadpop_template_id,
                        "leadpop_version_id" => $leadpop_version_id,
                        "leadpop_version_seq" => $version_seq,
                        'swatch' => addslashes($sw['swatch']),
                        'is_primary' => $idx == 0 ? 'y' : 'n',
                        'active' => 'y'
                    ];
                }
                $inserts = collect($inserts);
                $chunks = $inserts->chunk(1000);
                foreach ($chunks as $c => $chunk) {
                    DB::table('leadpop_background_swatches')->insert($chunk->toArray());
                }
                // Background swatches :: END

                // main message default
                $s = "select * from trial_launch_defaults where leadpop_vertical_sub_id = '$subvertical_id'";
                $trialDefaults = $this->db->fetchAll($s);
                $main_message = $trialDefaults[0]["main_message"];
                $main_message_font = $trialDefaults[0]["main_message_font"];
                $main_message_font_size = $trialDefaults[0]["main_message_font_size"];
                $mainmessage_color = $trialDefaults[0]["mainmessage_color"];

                $span_message = '<span style="font-family: '.$main_message_font.'; font-size:'.$main_message_font_size.'; color:'.$mainmessage_color.'">'.$main_message.'</span>';

                $customizeRepo = new CustomizeRepository($this->db);
                $customizeRepo->updateLeadLine(FunnelVariables::LEAD_LINE, $span_message, $client_id, $leadpop_id, $version_seq);
                // update main description default

                /* *** ***
                for($i=0; $i<count($leadpops_templates_placeholders); $i++) {
                    $s = "update leadpops_templates_placeholders_values set placeholder_sixtynine = '".addslashes($span_message)."' ";
                    $s .= " where client_leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
                    $this->db->query($s);
                }
                *** *** */

                $description = $trialDefaults[0]["description"];
                $description_font = $trialDefaults[0]["description_font"];
                $description_font_size = $trialDefaults[0]["description_font_size"];
                $description_color = $trialDefaults[0]["description_color"];

                $span_desc = '<span style="font-family: '.$description_font.'; font-size:'.$description_font_size.'; color:'.$description_color.'">'. $description .'</span>';
                $customizeRepo->updateLeadLine(FunnelVariables::SECOND_LINE, $span_desc, $client_id, $leadpop_id, $version_seq);

                $logo_vars = array();
                $logo_vars[FunnelVariables::LOGO_SRC] = "";
                $logo_vars[FunnelVariables::LOGO_COLOR] = "";
                $customizeRepo->updateFunnelVariables($logo_vars, $client_id, $leadpop_id, $version_seq);

                /* *** ***
                for($i=0; $i<count($leadpops_templates_placeholders); $i++) {
                    $s = "update leadpops_templates_placeholders_values  set placeholder_seventy = '".addslashes($span_desc)."' ";
                    $s .= " where client_leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
                    $this->db->query($s);
                }

                for($i=0; $i<count($leadpops_templates_placeholders); $i++) {
                    $s = " update leadpops_templates_placeholders_values  set placeholder_sixtytwo = '' , placeholder_eightyone = '' where client_leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
                    $this->db->query($s);
                }
                // echo $s;
                // exit;

                *** *** */
            }
        }

        $s = "select use_me from leadpop_logos  ";
        $s .= " where  client_id 	= " . $client_id;
        $s .= " and id =  " . $logo_id . " limit 1 ";
        $leadpop_logo_delete = $this->db->fetchRow($s);

        if($leadpop_logo_delete['use_me'] == 'y'){
             $s = "update leadpop_logos  set use_default = 'y' ";
             $s .= " where client_id = " . $client_id;
             $s .= " and leadpop_vertical_id = " . $vertical_id;
             $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
             $s .= " and leadpop_type_id = " . $leadpop_type_id;
             $s .= " and leadpop_template_id = " . $leadpop_template_id;
             $s .= " and leadpop_id = " . $leadpop_id;
             $s .= " and leadpop_version_id = " . $leadpop_version_id;
             $s .= " and leadpop_version_seq = " . $version_seq;
             $this->db->query($s);

        }
        $s = "delete from leadpop_logos where client_id = " . $client_id;
        $s .= " and id =  " . $logo_id;
        $this->db->query($s);

        @unlink($_SERVER['DOCUMENT_ROOT'].'/images/clients/' . $client_id . '/logos/'.$logo_name);

        $s = "insert into cron_delete_client_logos (id,client_id,logo_name,hasrun,daterun) values (null,";
        $s .= $client_id . ",'".$logo_name."','n','')";
        if(!$this->db->query($s)) {
            return $this->errorResponse();
        }
        //print($s);
        return $this->successResponse();
    }

    function backgroundOptionsToggle() {

        $vertical_id = $_POST['vertical_id'];
        $subvertical_id = $_POST['subvertical_id'];
        $leadpop_id = $_POST['leadpop_id'];
        $version_seq =  $_POST['version_seq'];
        $client_id = $_POST['client_id'];
        $thelink = $_POST['thelink'];
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id  = $lpres['leadpop_type_id'];

        $s = "select * from leadpop_background_color ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $result = $this->db->fetchRow($s);

        if ($thelink == 'active_overlay') {
            if($result['active_overlay'] == 'y') {
                $active = 'n';
            }else {
                $active = 'y';
            }
        }

        if ($thelink == 'active_backgroundimage') {
            if($result['active_backgroundimage'] == 'y') {
                $active = 'n';
            }else {
                $active = 'y';
            }
        }
        if(isset($_POST['bkactive']) && ""!=$_POST['bkactive'] ) $active=$_POST['bkactive'];

        $s = "update leadpop_background_color  set ".$thelink." = '".$active."' ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);

        $s = "UPDATE clients_leadpops SET  last_edit = '" . date("Y-m-d H:i:s") . "'";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_version_id  = " . $leadpop_version_id;
        $s .= " AND leadpop_version_seq  = " . $version_seq;
        $this->db->query ($s);

        return $thelink."~".$active;
    }

    // OLD Logic with N+1 SQLs
    function getSupportIssueV1(){
        $query="select id,title from lp_supports where parent_id=0 AND is_active=1";
        $mainissue = $this->db->fetchAll($query);
        $main_data=array();
        $final_data=array();
        foreach ($mainissue as $mdata) {
            $main_data[$mdata['id']]=$mdata["title"];
        }
        foreach ($main_data as $parent_id => $title) {
            $final_data[$parent_id]['maintitle']=$title;
            $child_data=$this->getChildData($parent_id);
            if(!empty($child_data)){
                foreach ($child_data as $cdata) {
                    $final_data[$parent_id]['subissue'][$cdata['id']]=$cdata["title"];
                    $final_data[$parent_id]['subdetail'][$cdata['id']]=array("heading"=>$cdata["heading"],'body'=>$cdata["body"],'action'=>$cdata['action']);
                }
            }
        }
        return array('maindata'=>$main_data,'final_data'=>$final_data);
    }

    // Removed N+1 SQLs from this one
    function getSupportIssue(){
        $query="select id,parent_id,title,heading,body,action from lp_supports where is_active=1";
        $mainissue = $this->db->fetchAll($query);
        $main_data=array();
        $child_rows=array();
        $final_data=array();
        foreach ($mainissue as $mdata) {
            if($mdata["parent_id"] === 0){
                $main_data[$mdata['id']]=$mdata["title"];
            }
            else{
                $child_rows[$mdata['parent_id']][$mdata['id']] = $mdata;
            }
        }
        foreach ($main_data as $parent_id => $title) {
            $final_data[$parent_id]['maintitle']=$title;
            if(array_key_exists($parent_id, $child_rows)){
                $child_data=$child_rows[$parent_id];
                foreach ($child_data as $cdata) {
                    $final_data[$parent_id]['subissue'][$cdata['id']]=$cdata["title"];
                    $final_data[$parent_id]['subdetail'][$cdata['id']]=array("heading"=>$cdata["heading"],'body'=>$cdata["body"],'action'=>$cdata['action']);
                }
            }
        }
        return array('maindata'=>$main_data,'final_data'=>$final_data);
    }
    function getChildData($parent_id){
        $query="select * from lp_supports where is_active=1 AND parent_id=".$parent_id;
        $child_data = $this->db->fetchAll($query);
        return $child_data;
    }
    function getSupportVideoData(){
        $video_data=array();
        $video_grps=$this->getVideoGroups();
        $groups = [];
        foreach($video_grps as $item){
            $groups[$item['group_name']][] = $item;
        }
        return $groups;
    }
    function getVideoGroups(){
        $registry = DataRegistry::getInstance();
        $client_type = $registry->leadpops->clientInfo['client_type'];
        $query = "Select * from ".config('database.tables.support_videos')." where group_name!='' AND del != 1 and vertical_id = ".$client_type." order by vorder asc";
        return $this->db->fetchAll($query);
    }
}
