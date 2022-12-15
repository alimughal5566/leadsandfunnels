<?php

namespace App\Http\Controllers;

use App\Constants\Layout_Partials;
use App\Constants\LP_Constants;
use App\Repositories\CustomizeRepository;
use App\Repositories\LeadpopsRepository;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LP_Helper;
use DateTime;
use Session;

class AjaxController extends BaseController {

    private $Default_Model_Customize;
    private $Default_Model_Leadpops;

    public function __construct(LpAdminRepository $lpAdmin, CustomizeRepository $customtizeRepo, LeadpopsRepository $leadpopsRepo){
        $this->middleware(function($request, $next) use ($lpAdmin, $customtizeRepo, $leadpopsRepo) {
            $this->Default_Model_Customize = $customtizeRepo;
            $this->Default_Model_Leadpops = $leadpopsRepo;
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(Session::get('leadpops'));
            $this->init($lpAdmin);
            if($request->ajax()) $this->check_ajax_session(); else $this->check_session();
            return $next($request);
        });
    }

    function updatebottomlinks(){
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


        $s = "select * from bottom_links ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $bottomLinks = $this->db->fetchRow($s);


        if($thelink == 'contact_active') {
            if($bottomLinks['contact_active'] == 'y') {
                $changeto = 'n';
                $chglink = "";
            }
            else {
                $changeto = 'y';
                $chglink = '/popadmin/contactus';
            }
        }

        if($thelink == 'about_active') {
            if($bottomLinks['about_active'] == 'y') {
                $changeto = 'n';
                $chglink = "";
            }
            else {
                $changeto = 'y';
                $chglink = '/popadmin/aboutus';
            }
        }

        if($thelink == 'licensing_active') {
            if($bottomLinks['licensing_active'] == 'y') {
                $changeto = 'n';
                $chglink = "";
            }
            else {
                $changeto = 'y';
                $chglink = '/popadmin/licensinginformation';
            }
        }

        if($thelink == 'disclosures_active') {
            if($bottomLinks['disclosures_active'] == 'y') {
                $changeto = 'n';
                $chglink = "";
            }
            else {
                $changeto = 'y';
                $chglink  = '/popadmin/disclosures';
            }
        }

        if($thelink == 'privacy_active') {
            if($bottomLinks['privacy_active'] == 'y') {
                $changeto = 'n';
                $chglink = "";
            }
            else {
                $changeto = 'y';
                $chglink = '/popadmin/footeroptionsprivacypolicy';
            }
        }

        if($thelink == 'terms_active') {
            if($bottomLinks['terms_active'] == 'y') {
                $changeto = 'n';
                $chglink = "";
            }
            else {
                $changeto = 'y';
                $chglink = '/popadmin/termsofuse';
            }
        }

        if($thelink == 'compliance_active') {
            if($bottomLinks['compliance_active'] == 'y') {
                $changeto = 'n';
            }
            else {
                $changeto = 'y';
            }
            $chglink="";
        }

        if($thelink == 'license_number_active') {
            if($bottomLinks['license_number_active'] == 'y') {
                $changeto = 'n';
            }
            else {
                $changeto = 'y';
            }
            $chglink="";
        }

        if($thelink == 'advanced_footer_active') {
            if($bottomLinks['advanced_footer_active'] == 'y') {
                $changeto = 'n';
            }
            else {
                $changeto = 'y';
            }
            $chglink="";
        }

        $s = "update bottom_links  set ".$thelink." = '".$changeto."' ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);


        $s = "SELECT clients_leadpops.id FROM clients_leadpops INNER JOIN leadpops ON leadpops.id = clients_leadpops.leadpop_id";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND clients_leadpops.leadpop_id = " . $leadpop_id;
        $s .= " AND leadpops.leadpop_vertical_id = " . $vertical_id;
        $s .= " AND leadpops.leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " AND leadpop_template_id = " . $leadpop_template_id;
        $s .= " AND leadpops.leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $clientLeadpopInfo = $this->db->fetchRow($s);
        if($clientLeadpopInfo){
            $now = new DateTime();
            $s = "UPDATE clients_leadpops SET date_updated = '" . $now->format("Y-m-d H:i:s") . "'";
            $s .= ", last_edit = '" . date("Y-m-d H:i:s") . "'";
            $s .= " WHERE client_id = " . $client_id;
            $s .= " AND id = " . $clientLeadpopInfo['id'];
            $this->db->query($s);
        }

        print($thelink."~".$changeto."~".$chglink);
    }

    function updatecompliance(){
        $vertical_id = $_POST['vertical_id'];
        $subvertical_id = $_POST['subvertical_id'];
        $leadpop_id = $_POST['leadpop_id'];
        $version_seq =  $_POST['version_seq'];
        $client_id = $_POST['client_id'];

        $compliance_text = $_POST['compliance_text'];
        $compliance_is_linked = $_POST['compliance_is_linked'];
        if(!$compliance_is_linked){
            $compliance_is_linked = 'n';
        }
        $compliance_link = $_POST['compliance_link'];
        $license_number_text = $_POST['license_number_text'];


        $license_number_is_linked = $_POST['license_number_is_linked'];
        if(!$license_number_is_linked){
            $license_number_is_linked = 'n';
        }
        $license_number_link = $_POST['license_number_link'];

// Add missing http or https
        $compliance_link = LP_Helper::getInstance()->addScheme($compliance_link);
        $license_number_link = LP_Helper::getInstance()->addScheme($license_number_link);

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id  = $lpres['leadpop_type_id'];

        $s = "select * from bottom_links ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $bottomLinks = $this->db->fetchRow($s);

        $s = "update bottom_links  set compliance_text = '".$compliance_text."' ";
        $s .= " ,compliance_is_linked = '".$compliance_is_linked."' ";
        $s .= " ,compliance_link = '".$compliance_link."' ";
        $s .= " ,license_number_text = '".$license_number_text."' ";

        $s .= " ,license_number_is_linked = '".$license_number_is_linked."' ";
        $s .= " ,license_number_link = '".$license_number_link."' ";

        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);

        $s = "SELECT clients_leadpops.id FROM clients_leadpops INNER JOIN leadpops ON leadpops.id = clients_leadpops.leadpop_id";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND clients_leadpops.leadpop_id = " . $leadpop_id;
        $s .= " AND leadpops.leadpop_vertical_id = " . $vertical_id;
        $s .= " AND leadpops.leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " AND leadpop_template_id = " . $leadpop_template_id;
        $s .= " AND leadpops.leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $clientLeadpopInfo = $this->db->fetchRow($s);
        if($clientLeadpopInfo){
            $now = new DateTime();
            $s = "UPDATE clients_leadpops SET date_updated = '" . $now->format("Y-m-d H:i:s") . "'";
            $s .= ", last_edit = '" . date("Y-m-d H:i:s") . "'";
            $s .= " WHERE client_id = " . $client_id;
            $s .= " AND id = " . $clientLeadpopInfo['id'];
            $this->db->query($s);
        }
    }

    function updateadvancefooter(){
        $vertical_id = $_POST['vertical_id'];
        $subvertical_id = $_POST['subvertical_id'];
        $leadpop_id = $_POST['leadpop_id'];
        $version_seq =  $_POST['version_seq'];
        $client_id = $_POST['client_id'];
        $advancehtml = $_POST['advancehtml'];
        $hideofooter = $_POST['hideofooter'];
        $templateType = isset($_POST['templatetype']) ? $_POST['templatetype'] : null;
        $isDefaultTplCtaMessage = (isset($_POST['defaultTplCtaMessage']) && $_POST['defaultTplCtaMessage'] == "y");

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id  = $lpres['leadpop_type_id'];

// if ($leadpop_template_id == 95) {
// 	echo $advancehtml;exit;
// }

        $s = "update bottom_links set advancehtml = '".addslashes($advancehtml)."', hide_primary_footer = '".$hideofooter."' ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);


        $s = "UPDATE clients_leadpops SET  last_edit = '" . date("Y-m-d H:i:s") . "'";

        //Updating font family & size for funnel main message and description
        if($isDefaultTplCtaMessage && ($templateType == "property_template" || $templateType == "property_template2")) {
            $clientLeadpops = \DB::table('clients_leadpops')
                ->select("lead_line", "second_line_more")
                ->where("client_id", $client_id)
                ->where("leadpop_version_id", $leadpop_version_id)
                ->where('leadpop_version_seq', $version_seq)
                ->first();

            $reFontFamily = '/font-family:(.*?);/m';
            $reFountSize = '/font-size:(.*?);/m';

            $clientLeadpops->lead_line = preg_replace($reFontFamily, "font-family:Raleway;", $clientLeadpops->lead_line);
            $clientLeadpops->lead_line = preg_replace($reFountSize, "font-size:36px;", $clientLeadpops->lead_line);

            $clientLeadpops->second_line_more = preg_replace($reFontFamily, "font-family:Open Sans;", $clientLeadpops->second_line_more);
            $clientLeadpops->second_line_more = preg_replace($reFountSize, "font-size:20px;", $clientLeadpops->second_line_more);

            $s .= ",lead_line='" . addslashes($clientLeadpops->lead_line)."' ";
            $s .= ",second_line_more='" . addslashes($clientLeadpops->second_line_more)."' ";
        }

        $s .= " WHERE client_id = " . $this->client_id;
        $s .= " AND leadpop_version_id  = " . $leadpop_version_id;
        $s .= " AND leadpop_version_seq  = " . $version_seq;
        $this->db->query ($s);
    }

    function updateseotags(){
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

        $s = "select * from seo_options ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $seo = $this->db->fetchRow($s);

        if($thelink == 'titletag_active') {
            if($seo['titletag_active'] == 'y') {
                $changeto = 'n';
            }
            else {
                $changeto = 'y';
            }
        }

        if($thelink == 'description_active') {
            if($seo['description_active'] == 'y') {
                $changeto = 'n';
            }
            else {
                $changeto = 'y';
            }
        }

        if($thelink == 'metatags_active') {
            if($seo['metatags_active'] == 'y') {
                $changeto = 'n';
            }
            else {
                $changeto = 'y';
            }
        }

        $s = "update seo_options  set ".$thelink." = '".addslashes($changeto)."' ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);

        $s = "SELECT clients_leadpops.id FROM clients_leadpops INNER JOIN leadpops ON leadpops.id = clients_leadpops.leadpop_id";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND clients_leadpops.leadpop_id = " . $leadpop_id;
        $s .= " AND leadpops.leadpop_vertical_id = " . $vertical_id;
        $s .= " AND leadpops.leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " AND leadpop_template_id = " . $leadpop_template_id;
        $s .= " AND leadpops.leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $clientLeadpopInfo = $this->db->fetchRow($s);
        if($clientLeadpopInfo){
            date_default_timezone_set('America/Los_Angeles');
            $now = new DateTime();

            $s = "UPDATE clients_leadpops SET date_updated = '" . $now->format("Y-m-d H:i:s") . "'";
            $s .= ", last_edit = '" . date("Y-m-d H:i:s") . "'";
            $s .= " WHERE client_id = " . $client_id;
            $s .= " AND id = " . $clientLeadpopInfo['id'];
            $this->db->query($s);

        }



        print($thelink."~".$changeto);
    }

    function updatecontact(){
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

        $s = "select * from contact_options ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $submission = $this->db->fetchRow($s);

        if($thelink == 'phonenumber_active') {
            if($submission['phonenumber_active'] == 'y') {
                $changeto = 'n';
            }
            else {
                $changeto = 'y';
            }
        }

        if($thelink == 'companyname_active') {
            if($submission['companyname_active'] == 'y') {
                $changeto = 'n';
            }
            else {
                $changeto = 'y';
            }
        }

        if($thelink == 'email_active') {
            if($submission['email_active'] == 'y') {
                $changeto = 'n';
            }
            else {
                $changeto = 'y';
            }
        }

        $s = "update contact_options  set ".$thelink." = '".$changeto."' ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);

        $s = "SELECT clients_leadpops.id FROM clients_leadpops INNER JOIN leadpops ON leadpops.id = clients_leadpops.leadpop_id";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND clients_leadpops.leadpop_id = " . $leadpop_id;
        $s .= " AND leadpops.leadpop_vertical_id = " . $vertical_id;
        $s .= " AND leadpops.leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " AND leadpop_template_id = " . $leadpop_template_id;
        $s .= " AND leadpops.leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $clientLeadpopInfo = $this->db->fetchRow($s);
        if($clientLeadpopInfo){
            date_default_timezone_set('America/Los_Angeles');
            $now = new DateTime();

            $s = "UPDATE clients_leadpops SET date_updated = '" . $now->format("Y-m-d H:i:s") . "'";
            $s .= " WHERE client_id = " . $client_id;
            $s .= " AND id = " . $clientLeadpopInfo['id'];
            $this->db->query($s);

            /* update clients_leadpops table's col last edit*/
            /* if LP_Helper::getInstance()->getFunnelData() not work then send id in parameter */
            update_clients_leadpops_last_eidt($clientLeadpopInfo['id']);

        }

        print($thelink."~".$changeto);
    }

    function checksubdomainavailable(){
        $subdomain = $_POST['subdomain'];
        $topdomain = $_POST['topdomain'];
        //if clone flag n and clone funnel counter greater than limit then it will work
        $cloneNum = getFunnelCloneNumber();
        if(!isset($_POST['module']) and LP_Helper::getInstance()->getCloneFlag() == 'n' and $cloneNum == config('lp.funnel_clone_limit')){
                echo 'disabledClone';
                die;
        }

        $s = "select count(*) as cnt from clients_funnels_domains as a
        where LOWER(a.subdomain_name) = '" . strtolower($subdomain) . "'
        and a.top_level_domain = '".$topdomain."'";

        //print($s);
        $cnt = $this->db->fetchOne( $s );
        if($cnt == 0) {
            print "ok";
        } else {
            print "taken";
        }


        //TODO: The logic is not working fine. I have commented the code. from @mzac90
//        $s = "SELECT * FROM clients_funnels_domains where LOWER(subdomain_name) = '" . strtolower($subdomain) . "' AND top_level_domain = '" . strtolower($topdomain) . "'";
//        $rows = $this->db->fetchAll($s);
//
//        if(count($rows) > 0){
//            $client_ids = array();
//            $leadpop_ids = array();
//            $leadpop_version_ids = array();
//            $leadpop_version_seq = array();
//            for ($r=0; $r < count($rows); $r++) {
//                array_push($client_ids, $rows[$r]['client_id']);
//                array_push($leadpop_ids, $rows[$r]['leadpop_id']);
//                array_push($leadpop_version_ids, $rows[$r]['leadpop_version_id']);
//                array_push($leadpop_version_seq, $rows[$r]['leadpop_version_seq']);
//            }
//
//            if(!empty($client_ids)){
//                $s = "SELECT count(*) as cnt from clients_leadpops WHERE client_id IN (".implode(array_unique($client_ids)).")
//                AND leadpop_id IN (".implode(array_unique($leadpop_ids)).")
//                AND leadpop_version_id IN (".implode(array_unique($leadpop_version_ids)).")
//                AND leadpop_version_seq IN (".implode(array_unique($leadpop_version_seq)).")
//                AND leadpop_active = 1";
//                $cnt = $this->db->fetchOne( $s );
//                if($cnt == 0) {
//                    print "ok";
//                } else {
//                    print "taken";
//                }
//            } else {
//                print "ok";
//            }
//        }
//        else{
//            print "ok";
//        }
    }

    function checkdomainavailable(){
        $thedomain = $_POST['thedomain'];
        $s = "select count(*) as cnt from clients_funnels_domains where domain_name = '".$thedomain."' AND leadpop_type_id=" . config('leadpops.leadpopDomainTypeId');
        $cnt = $this->db->fetchOne($s);
        if($cnt == 0) {
            print "ok";
        }
        else {
            print "taken";
        }
    }

    function downloadRackspaceImage(Request $request){
        $info = parse_url($request->get('image_link'));
        $file_name = str_replace("/~","/", env('RACKSPACE_TMP_DIR', '')."/".str_replace("/", "~", $info['path']));
        if(file_exists($file_name)){
            $local_file = $file_name;
            $exists = 1;
        }
        else{
            $is_default = 0;
            if($request->input('global') == 1){
                $global = $request->input('global');
            }else{
                $global = 0;
            }

            // FOR Local Development
            if (env('APP_ENV') == config('app.env_local')) {
                $info = parse_url($request->get('image_link'));

                $file_name = str_replace("/~","/", str_replace("/", "~", substr($info['path'], 1)));
                $local_file = env('RACKSPACE_TMP_DIR', '')."/".str_replace("/", "~", $file_name);
                $download_path = str_replace(env('APP_URL')."/", "", $request->get('image_link'));
                copy($download_path, $local_file);
                echo json_encode(['file'=>$local_file, "exists"=>0]);
                exit;
            }

            /** @var \App\Services\RackspaceUploader $rackspace */
            $rackspace = \App::make('App\Services\RackspaceUploader');
            $exists = 0;

            if(strpos($info['path'], "/default/images/") !== false || strpos($info['path'], "/default/stockimages/") !== false){
                $local_file = $rackspace->getFile(substr($info['path'], 1), rackspace_container_info('default-assets', 'current_container'),$global);
            }
            else{
                $local_file = $rackspace->getFile(substr($info['path'], 1), $this->registry->leadpops->clientInfo['rackspace_container'],$global);
            }
        }

        echo json_encode(['file'=>$local_file, "exists"=>$exists]);
    }

    function getdomainfromid(Request $request){
        $domain_id = $request->input('domain_id');
        $client_id = $request->input('client_id');

        $s = "select domain_name ";
        $s .= " from clients_funnels_domains";
        $s .= " where clients_domain_id = ".$domain_id;
        $s .= " and client_id = " . $client_id;
        $s .= " and leadpop_type_id = " . config('leadpops.leadpopDomainTypeId');
        $domains = $this->db->fetchRow($s);
        print $domains['domain_name'];
    }
    function updatetemplatecta(Request $request){
        $client_id =  $request->input('client_id');
        $logocolor =  $request->input('logocolor');
        if( $request->input('is_global') == 'false'){
            $vertical_id =  $request->input('vertical_id');
            $subvertical_id =  $request->input('subvertical_id');
            $leadpop_id =  $request->input('leadpop_id');
            $version_seq =   $request->input('version_seq');
            $thelink =  $request->input('thelink');
            $logocolor =  $request->input('logocolor');

            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            $leadpop_type_id  = $lpres['leadpop_type_id'];

            $sixnine = '<span style="font-family: Montserrat; font-size:36px; color:'.$logocolor.'">Check Out the Home for Sale Below & If You Love it, See if You Qualify!</span>';
            $seventy = '<span style="font-family: Open Sans; font-size:18px; color: #666666">Find out if you qualify for this home (or other homes in a similar price range) by getting pre-approved here for FREE. Enter your zip code to get started now!</span>';


            // update the font-color
            $s = "select id from leadpops_templates_placeholders ";
            $s .= " where leadpop_template_id = " . $lpres["leadpop_template_id"];
            $s .= " and client_id = " . $client_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            $leadpops_templates_placeholders = $this->db->fetchAll($s);


            for ($xx = 0; $xx < count($leadpops_templates_placeholders); $xx++) {
                $s = "update leadpops_templates_placeholders_values  ";
                $s .= " set placeholder_sixtynine= '" . addslashes($sixnine) . "', placeholder_seventy= '" . addslashes($seventy) . "' ";
                $s .= " where  leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
                $this->db->query($s);

            }
            print('y');
        }else{

            $funnel_info = $request->input('funnels-info');
            $advancehtml = $request->input('fr-html');
            $hideofooter = $request->input('hideofooter');
            $lplist = explode(",", $funnel_info);
            foreach ($lplist as $index => $lp) {
                $lpconstt = explode("~", $lp);
                $leadpop_vertical_id = $lpconstt[0];
                $leadpop_vertical_sub_id = $lpconstt[1];
                $leadpop_id = $lpconstt[2];
                $leadpop_version_seq = $lpconstt[3];
                $s = "select * from leadpops where id = " . $leadpop_id;
                $lpres = $this->db->fetchRow($s);

                $leadpop_template_id = $lpres['leadpop_template_id'];
                $leadpop_version_id = $lpres['leadpop_version_id'];
                $leadpop_type_id  = $lpres['leadpop_type_id'];

                $sixnine = '<span style="font-family: Montserrat; font-size:36px; color:'.$logocolor.'">Check Out the Home for Sale Below & If You Love it, See if You Qualify!</span>';
                $seventy = '<span style="font-family: Open Sans; font-size:18px; color: #666666">Find out if you qualify for this home (or other homes in a similar price range) by getting pre-approved here for FREE. Enter your zip code to get started now!</span>';


                // update the font-color
                $s = "select id from leadpops_templates_placeholders ";
                $s .= " where leadpop_template_id = " . $lpres["leadpop_template_id"];
                $s .= " and client_id = " . $client_id;
                $s .= " and leadpop_version_seq = " .$leadpop_vertical_id;
                $leadpops_templates_placeholders = $this->db->fetchAll($s);


                for ($xx = 0; $xx < count($leadpops_templates_placeholders); $xx++) {
                    $s = "update leadpops_templates_placeholders_values  ";
                    $s .= " set placeholder_sixtynine= '" . addslashes($sixnine) . "', placeholder_seventy= '" . addslashes($seventy) . "' ";
                    $s .= " where  leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
                    $this->db->query($s);
                }
            }
            print('y');
        }

    }

    public function getCurrentLogo(Request $request){
        try {
            LP_Helper::getInstance()->getCurrentHashData($request->input("current_hash"));
            if (LP_Helper::getInstance()->getCurrentHash()) {
                $hash_data = LP_Helper::getInstance()->getFunnelData();
                $funnelData = $hash_data['funnel'];
                $selected_logo_src = \View_Helper::getInstance()->getCurrentLogoImageSource(@$this->registry->leadpops->client_id, 0, $funnelData);

                if ($selected_logo_src == "") {
                    $stock = $this->Default_Model_Customize->getStockLogoSources(@$this->registry->leadpops->client_id, $funnelData);
                    $astock = explode("~", $stock);
                    $selected_logo_src = $astock[1];
                }

                return response()->json([
                    'status' => true,
                    'currentLogoSrc' => $selected_logo_src
                ]);
            }
            else{
                return response()->json([
                    'status' => false
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false
            ]);
        }

    }
}
