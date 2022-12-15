<?php

namespace App\Http\Controllers;

use App\Constants\Layout_Partials;
use App\Constants\LP_Constants;
use App\Repositories\CustomizeRepository;
use App\Repositories\LeadpopsRepository;
use App\Repositories\LpAdminRepository;
use App\Repositories\ProcessRepository;
use App\Services\DataRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use LP_Helper;
use DateTime;
use Session;

class ProcessController extends BaseController {
    private $processRepository;
    public function __construct(ProcessRepository $processRepository){
        $this->processRepository = $processRepository;
    }

    function addfunnelprocess(Request $request){
        $funnel = $this->processRepository->getClientFunnels();
        $this->processRepository->addFunnel($funnel,$request->get("new_subdomain_name"),$request->get("new_top_level_domain"));
    }

    function addfunnelprocess_fairway(Request $request){
        $funnel = $this->processRepository->getClientFunnels();
        $this->processRepository->addFunnel($funnel,$request->get("new_subdomain_name"),$request->get("new_top_level_domain"), ProcessRepository::TYPE_FAIRWAY);
    }

    function addfunnelprocess_baller(Request $request){
        $funnel = $this->processRepository->getClientFunnels();
        $this->processRepository->addFunnel($funnel,$request->get("new_subdomain_name"),$request->get("new_top_level_domain"), ProcessRepository::TYPE_BALLER);
    }

    function clonefunnelprocess_mvp_fix(Request $request){
            Log::debug("clonefunnelprocess_mvp_fix",$_POST);
            if($request->get("client_id")){
            $client_id = $request->get("client_id");
            $tclientRow = $this->processRepository->getClientByID($client_id);
            $weburls = $this->processRepository->getClientWebsiteFunnels($client_id);

            $skipclone = "";
            if(isset($_POST['skipclone'])){
                $skipclone = $_POST['skipclone'];
            }
            $this->processRepository->cloneFunnelProcess($tclientRow,$weburls,$skipclone,$client_id);
        }
    }

    function add_website_funnel_script(Request $request){
        Log::debug("add_website_funnel_script",$_POST);
        if($request->get("client_id")){
            $client_id = $request->get("client_id");
            $tclientRow = $this->processRepository->getClientByID($client_id);

            $q = "select * from ".$_POST['table']." where id =  " . $_POST['id'];
            $db = \App::make('App\Services\DbService');;
            $weburls = $db->fetchAll($q);
            if($weburls){
                $weburls[0]['client_id'] = $_POST['client_id'];
                $weburls[0]['new_subdomain_name'] = $_POST['new_subdomain_name'];
                $weburls[0]['current_client_funnel_url'] = $_POST['current_client_funnel_url'];
                $weburls[0]['leadpop_version_seq'] = $_POST['leadpop_version_seq'];
                $skipclone = "";
                $this->processRepository->cloneFunnelProcess($tclientRow,$weburls,$skipclone,$client_id);
            }
        }
    }

    function clonefunnelprocess_insurance_mvp_fix(Request $request){
        Log::debug("clonefunnelprocess_insurance_mvp_fix",$_POST);
        if($request->get("client_id")){
            $client_id = $request->get("client_id");
            $tclientRow = $this->processRepository->getClientByID($client_id);
            $weburls = $this->processRepository->getClientWebsiteFunnels($client_id, ProcessRepository::TYPE_INSURANCE);

            $skipclone = "";
            if(isset($_POST['skipclone'])){
                $skipclone = $_POST['skipclone'];
            }
            $this->processRepository->cloneFunnelProcess($tclientRow,$weburls,$skipclone,$client_id, ProcessRepository::TYPE_INSURANCE);
        }
    }

    function clonefunnelprocess_mvp_movement_fix(Request $request){
        Log::debug("clonefunnelprocess_mvp_movement_fix",$_POST);
        if($request->get("client_id")){
            $client_id = $request->get("client_id");
            $tclientRow = $this->processRepository->getClientByID($client_id);
            $weburls = $this->processRepository->getClientWebsiteFunnels($client_id, ProcessRepository::TYPE_MOVEMENT);

            $skipclone = "";
            if(isset($_POST['skipclone'])){
                $skipclone = $_POST['skipclone'];
            }
            $this->processRepository->cloneFunnelProcess($tclientRow,$weburls,$skipclone,$client_id, ProcessRepository::TYPE_MOVEMENT);
        }
    }

    function clonefunnelprocess_mvp_fairway_fix(Request $request){
        Log::debug("clonefunnelprocess_mvp_fairway_fix",$_POST);
        if($request->get("client_id")){
            $client_id = $request->get("client_id");
            $tclientRow = $this->processRepository->getClientByID($client_id);
            $weburls = $this->processRepository->getClientWebsiteFunnels($client_id, ProcessRepository::TYPE_FAIRWAY);

            $skipclone = "";
            if(isset($_POST['skipclone'])){
                $skipclone = $_POST['skipclone'];
            }
            $this->processRepository->cloneFunnelProcess($tclientRow,$weburls,$skipclone,$client_id, ProcessRepository::TYPE_FAIRWAY);
        }
    }

    function clonefunnelprocess_mvp_baller_fix(Request $request){
        Log::debug("clonefunnelprocess_mvp_baller_fix",$_POST);
        if($request->get("client_id")){
            $client_id = $request->get("client_id");
            $tclientRow = $this->processRepository->getClientByID($client_id);
            $weburls = $this->processRepository->getClientWebsiteFunnels($client_id, ProcessRepository::TYPE_BALLER);

            $skipclone = "";
            if(isset($_POST['skipclone'])){
                $skipclone = $_POST['skipclone'];
            }
            $this->processRepository->cloneFunnelProcess($tclientRow,$weburls,$skipclone,$client_id, ProcessRepository::TYPE_BALLER);
        }
    }

    function clonefunnelprocess_realestate_mvp_fix(Request $request){
        Log::debug("clonefunnelprocess_realestate_mvp_fix",$_POST);
        if($request->get("client_id")){
            $client_id = $request->get("client_id");
            $tclientRow = $this->processRepository->getClientByID($client_id);
            $weburls = $this->processRepository->getClientWebsiteFunnels($client_id, ProcessRepository::TYPE_BALLER);

            $skipclone = "";
            if(isset($_POST['skipclone'])){
                $skipclone = $_POST['skipclone'];
            }
            $this->processRepository->cloneFunnelProcess($tclientRow,$weburls,$skipclone,$client_id, ProcessRepository::TYPE_REALESTATE);
        }
    }

    function clonefunnelprocess_stearns_mvp_fix(Request $request){
        Log::debug("clonefunnelprocess_stearns_mvp_fix",$_POST);
        if($request->get("client_id")){
            $client_id = $request->get("client_id");
            $tclientRow = $this->processRepository->getClientByID($client_id);
            $weburls = $this->processRepository->getClientWebsiteFunnels($client_id, ProcessRepository::TYPE_STEARNS);

            $skipclone = "";
            if(isset($_POST['skipclone'])){
                $skipclone = $_POST['skipclone'];
            }
            $this->processRepository->cloneFunnelProcess($tclientRow,$weburls,$skipclone,$client_id, ProcessRepository::TYPE_STEARNS);
        }
    }

    function findIt($string, $sub_strings){
        foreach($sub_strings as $substr){
            if(strpos($string, $substr) !== FALSE)
            {
                return TRUE; // at least one of the needle strings are substring of heystack, $string
            }
        }

        return FALSE; // no sub_strings is substring of $string.
    }

    function getHttpServer() {
        global $xzdb;
        $s = "select http from httpclientserver limit 1 ";
        $http = $xzdb->fetchOne ( $s );
        return $http;
    }

    function isValidEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function insertDefaultEnterpriseAutoResponders ($client_id,$trialDefaults,$email,$phone,$xzdb) {

        // insert primary client
        $s = "insert into lp_auto_recipients (client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
        $s .= "leadpop_version_seq,email_address,is_primary) values (" . $client_id . ",";
        $s .= $trialDefaults["leadpop_id"] . "," . $trialDefaults["leadpop_type_id"] . "," . $trialDefaults["leadpop_vertical_id"] . "," . $trialDefaults["leadpop_vertical_sub_id"] . "," . $trialDefaults["leadpop_template_id"] . "," . $trialDefaults["leadpop_version_id"];
        $s .= "," . $trialDefaults["leadpop_version_seq"] . ",'" . $email . "','y')";
        $xzdb->query ( $s );
        $lastId = $xzdb->lastInsertId ();

        $s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
        $s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $client_id . "," . $lastId . ",";
        $s .= $trialDefaults["leadpop_id"] . "," . $trialDefaults["leadpop_type_id"] . "," . $trialDefaults["leadpop_vertical_id"] . "," . $trialDefaults["leadpop_vertical_sub_id"] . "," . $trialDefaults["leadpop_template_id"] . "," . $trialDefaults["leadpop_version_id"];
        $s .= "," . $trialDefaults["leadpop_version_seq"] . ",'" . $phone . "','none','y')";
        $xzdb->query ( $s );

    }


    function insertDefaultAutoResponders ($client_id, $trialDefaults, $emailaddress, $phonenumber) {
        global $xzdb;

        // insert primary client
        $s = "insert into lp_auto_recipients (client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
        $s .= "leadpop_version_seq,email_address,is_primary) values (" . $client_id . ",";
        $s .= $trialDefaults["leadpop_id"] . "," . $trialDefaults["leadpop_type_id"] . "," . $trialDefaults["leadpop_vertical_id"] . "," . $trialDefaults["leadpop_vertical_sub_id"] . "," . $trialDefaults["leadpop_template_id"] . "," . $trialDefaults["leadpop_version_id"];
        $s .= "," . $trialDefaults["leadpop_version_seq"] . ",'" . $emailaddress . "','y')";
        $xzdb->query ( $s );
        $lastId = $xzdb->lastInsertId ();

        $s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
        $s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $client_id . "," . $lastId . ",";
        $s .= $trialDefaults["leadpop_id"] . "," . $trialDefaults["leadpop_type_id"] . "," . $trialDefaults["leadpop_vertical_id"] . "," . $trialDefaults["leadpop_vertical_sub_id"] . "," . $trialDefaults["leadpop_template_id"] . "," . $trialDefaults["leadpop_version_id"];
        $s .= "," . $trialDefaults["leadpop_version_seq"] . ",'" . $phonenumber . "','none','y')";
        $xzdb->query ( $s );

    }

    function insertClientDefaultEnterpriseImage($trialDefaults,$image_name,$client_id) {
        global $xzdb;
        global $ssh;
        $use_default = 'n';
        $use_me = 'y' ;

        $imagename = strtolower($client_id."_".$trialDefaults["leadpop_id"]."_1_".$trialDefaults["leadpop_vertical_id"]."_".$trialDefaults["leadpop_vertical_sub_id"]."_".$trialDefaults['leadpop_template_id']."_".$trialDefaults["leadpop_version_id"]."_".$trialDefaults["leadpop_version_seq"]."_".$image_name);
        $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classicimages/' . $image_name . '  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
        exec($cmd);
        //$ssh->exec($cmd);

        $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classicimages/' . $image_name . '  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
        //$ssh->exec($cmd);
        exec($cmd);

        $s = "insert into leadpop_images (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
        $s .= "image_src,use_me,numpics) values (null,";
        $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
        $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
        $s .= "'".$use_default."','".$imagename."','".$use_me."',1) ";
        //	print($s);
        $xzdb->query($s);

        $img = getHttpServer () . '/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
        return $img;
    }


    function insertClientNotDefaultImage($trialDefaults,$client_id,$origleadpop_id,$origleadpop_type_id,$origvertical_id,$origsubvertical_id,
                                         $origleadpop_template_id,$origleadpop_version_id,$origleadpop_version_seq) {
        global $xzdb;
        global $ssh;
        $use_default = 'n';
        $use_me = 'y' ;

        $s = "select image_src from  leadpop_images where client_id = " . $client_id ;
        $s .= " and leadpop_id = " . $origleadpop_id;
        $s .= " and leadpop_type_id = " . $origleadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $origvertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $origsubvertical_id;
        $s .=  " and leadpop_template_id = " . $origleadpop_template_id;
        $s .= " and leadpop_version_id = " . $origleadpop_version_id;
        $s .= " and leadpop_version_seq = " . $origleadpop_version_seq;
        $s .= " and use_default = 'n' and use_me = 'y' limit 1 ";

        $res = $xzdb->fetchAll($s);
        if ($res) { // using an uploaded image
            $image = end(explode("_",$res[0]['image_src']));
            $imagename = strtolower($client_id."_".$trialDefaults["leadpop_id"]."_1_".$trialDefaults["leadpop_vertical_id"]."_".$trialDefaults["leadpop_vertical_sub_id"]."_".$trialDefaults['leadpop_template_id']."_".$trialDefaults["leadpop_version_id"]."_".$trialDefaults["leadpop_version_seq"]."_".$image);
            $cmd = '/bin/cp  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' . $res[0]['image_src'] . '  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' . $imagename;
            exec($cmd);

            $cmd = '/bin/cp  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' . $res[0]['image_src'] . '  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' . $imagename;
            exec($cmd);

            $s = "insert into leadpop_images (id,client_id,leadpop_id,leadpop_type_id,";
            $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
            $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
            $s .= "image_src,use_me,numpics) values (null,";
            $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
            $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
            $s .= "'n','".$imagename."','y',1) ";
            $xzdb->query($s);

        }
        else {
            $imagename = strtolower($client_id."_".$trialDefaults["leadpop_id"]."_1_".$trialDefaults["leadpop_vertical_id"]."_".$trialDefaults["leadpop_vertical_sub_id"]."_".$trialDefaults['leadpop_template_id']."_".$trialDefaults["leadpop_version_id"]."_".$trialDefaults["leadpop_version_seq"]."_".$trialDefaults['image_name']);
            $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classicimages/' . $trialDefaults['image_name'] . '  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
            exec($cmd);

            $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classicimages/' . $trialDefaults['image_name'] . '  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
            exec($cmd);

            $s = "insert into leadpop_images (id,client_id,leadpop_id,leadpop_type_id,";
            $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
            $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
            $s .= "image_src,use_me,numpics) values (null,";
            $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
            $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
            $s .= "'y','".$imagename."','n',1) ";
            $xzdb->query($s);

        }

        $img = getHttpServer () . '/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
        return $img;
    }


    function insertClientDefaultImage($trialDefaults,$client_id) {
        global $xzdb;
        global $ssh;
        $use_default = 'n';
        $use_me = 'y' ;

        $imagename = strtolower($client_id."_".$trialDefaults["leadpop_id"]."_1_".$trialDefaults["leadpop_vertical_id"]."_".$trialDefaults["leadpop_vertical_sub_id"]."_".$trialDefaults['leadpop_template_id']."_".$trialDefaults["leadpop_version_id"]."_".$trialDefaults["leadpop_version_seq"]."_".$trialDefaults['image_name']);
        $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classicimages/' . $trialDefaults['image_name'] . '  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
        exec($cmd);
        //$ssh->exec($cmd);

        $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classicimages/' . $trialDefaults['image_name'] . '  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
        //$ssh->exec($cmd);
        exec($cmd);

        $s = "insert into leadpop_images (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
        $s .= "image_src,use_me,numpics) values (null,";
        $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
        $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
        $s .= "'".$use_default."','".$imagename."','".$use_me."',1) ";
        //	print($s);
        $xzdb->query($s);

        $img = getHttpServer () . '/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
        return $img;
    }

    function insertDefaultClientUploadLogo($logosrc,$trialDefaults,$client_id) {
        global $xzdb;
        $numpics = 0;
        $usedefault = 'y';

        global $globallogosrc;
        global $globalfavicon_dst;
        global $globallogo_color;
        global $globalcolored_dot;

        //$imagename = strtolower($client_id."_".$trialDefaults["leadpop_id"]."_1_".$trialDefaults["leadpop_vertical_id"]."_".$trialDefaults["leadpop_vertical_sub_id"]."_".$trialDefaults['leadpop_template_id']."_".$trialDefaults["leadpop_version_id"]."_".$trialDefaults["leadpop_version_seq"]."_".$trialDefaults['image_name']);
        //$cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classicimages/' . $trialDefaults['image_name'] . '  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
        //exec($cmd);

        $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
        $s .= "logo_src,use_me,numpics) values (null,";
        $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
        $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
        $s .= "'".$usedefault."','".$logosrc."','n',".$numpics.") ";
        $xzdb->query($s);

        $s = "insert into current_logo (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,logo_src) values (null,";
        $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
        $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
        $s .= "'" . $logosrc . "' ) ";
        $xzdb->query($s);

        $globallogosrc = $logosrc;
        $globalfavicon_dst = "";
        $globallogo_color = "";
        $globalcolored_dot = "";
    }

    function newinsertClientUploadLogo($logoname,$trialDefaults,$client_id) {
        global $xzdb;
        global $ssh;

        $numpics = 1;
        $usedefault = 'n';

        $cmd = '/bin/cp /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/logos/' .$logoname  . '  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/logos/' .$logoname ;
        //$ssh->exec($cmd);
        exec($cmd);

        $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
        $s .= "logo_src,use_me,numpics) values (null,";
        $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
        $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
        $s .= "'".$usedefault."','".$logoname."','y',".$numpics.") ";
        $xzdb->query($s);

        $s = "insert into current_logo (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,logo_src) values (null,";
        $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
        $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
        $s .= "'" . $logoname . "' ) ";
        $xzdb->query($s);

        $logosrc = getHttpServer () . '/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/logos/' .$logoname ;
        return $logosrc;
    }

    function insertClientUploadLogo($uploadedLogo,$trialDefaults,$client_id) {
        global $xzdb;
        global $ssh;
        $numpics = 1;
        $usedefault = 'n';

        $logoname = strtolower($client_id."_".$trialDefaults["leadpop_id"]."_1_".$trialDefaults["leadpop_vertical_id"]."_".$trialDefaults["leadpop_vertical_sub_id"]."_".$trialDefaults['leadpop_template_id']."_".$trialDefaults["leadpop_version_id"]."_".$trialDefaults["leadpop_version_seq"]."_".$uploadedLogo);
        $section = substr($client_id,0,1);
//	  $logopath = $_SERVER['DOCUMENT_ROOT'].'/images/clients/'.$section.'/'. $client_id .'/logos/'.$logoname;

        $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/images/temp/' . $uploadedLogo . '  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/logos/' .$logoname ;
        //$ssh->exec($cmd);
        exec($cmd);

        $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/images/temp/' . $uploadedLogo . '  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/logos/' .$logoname ;
        //$ssh->exec($cmd);
        exec($cmd);

        $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
        $s .= "logo_src,use_me,numpics) values (null,";
        $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
        $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
        $s .= "'".$usedefault."','".$logoname."','y',".$numpics.") ";
        $xzdb->query($s);

        $s = "insert into current_logo (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,logo_src) values (null,";
        $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
        $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
        $s .= "'" . $logoname . "' ) ";
        $xzdb->query($s);

        $logosrc = getHttpServer () . '/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/logos/' .$logoname ;
        return $logosrc;
    }

    function getAutoResponderText ( $vertical_id, $subvertical_id, $leadpop_id ) {
        global $xzdb;
        $s = "select html,subject_line from autoresponder_defaults where  ";
        $s .= " leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_vertical_id = " .  $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id . " limit 1 ";
        $res = $xzdb->fetchAll($s);
        if ($res) {
            return $res;
        }
        else {
            return "not found";
        }
    }

    function getSubmissionText($leadpop_id,$vertical_id,$subvertical_id,$niners="888888") {
        global $xzdb;
        if ($niners == "999999") {
            $s = "select html from thankyou_defaults where  ";
            $s .= " leadpop_id = 999999 limit 1";
            $res = $xzdb->fetchAll($s);
        }
        else {
            $s = "select html from thankyou_defaults where  ";
            $s .= " leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_vertical_id = " .  $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id . " limit 1 ";
            $res = $xzdb->fetchAll($s);
        }
        return $res[0]["html"];
    }

    function insertPurchasedGoogle($client_id, $googleDomain) {
        global $xzdb;
        // package id does not now affect google analytics so put 2 for all
        $dt = date ( 'Y-m-d H:i:s' );
        $s = "insert into purchased_google_analytics (client_id,purchased,google_key,";
        $s .= "thedate,domain,active,package_id) values (" . $client_id . ",'y','','" . $dt . "','" . $googleDomain . "',";
        $s .= "'n',2)";
        $xzdb->query ( $s );
    }

    function getRandomCharacter() {
        $chars = "abcdefghijkmnopqrstuvwxyz";
        srand ( ( double ) microtime () * 1000000 );
        $i = 0;
        $char = '';
        while ( $i <= 1 ) {
            $num = rand () % 33;
            $tmp = substr ( $chars, $num, 1 );
            $char = $char . $tmp;
            $i ++;
        }
        return $char;
    }

    function encrypt($string) {
        $key = "petebird";
        $string = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
        return $string;
    }

    function decrypt($string) {
        $key = "petebird";
        $string = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
        return $string;
    }

    function generateRandomString($length = 5) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }


    function checkIfNeedMultipleStepInsert($leadpop_description_id,$client_id) {
        global $xzdb;
        $s = "select * from leadpop_multiple where leadpop_description_id = " . $leadpop_description_id . " limit 1 ";
        $res = $xzdb->fetchAll ( $s );
        if ($res) {
            $s = "insert into leadpop_multiple_step (id,";
            $s .= "client_id,leadpop_description_id,leadpop_id,";
            $s .= "leadpop_template_id,stepone,steptwo,stepthree,";
            $s .= "stepfour,stepfive) values (null,";
            $s .= $client_id . "," . $res [0] ['leadpop_description_id'] . ",";
            $s .= $res [0] ['leadpop_id'] . "," . $res [0] ['leadpop_template_id'] . ",'";
            $s .= $res [0] ['stepone'] . "','" . $res [0] ['steptwo'] . "','" . $res [0] ['stepthree'];
            $s .= "','" . $res [0] ['stepfour'] . "','" . $res [0] ['stepfive'] . "')";
            $xzdb->query ( $s );
        }
    }

    function createClientInitialDirectories($client_id) {
        global $ssh;
        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id ;
        //$ssh->exec($cmd);
        @exec($cmd);
        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1). '/' . $client_id ;
        //$ssh->exec($cmd);
        @exec($cmd);

        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id  . '/logos' ;
        //$ssh->exec($cmd);
        @exec($cmd);
        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1). '/' . $client_id . '/logos' ;
        //$ssh->exec($cmd);
        @exec($cmd);

        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/itclix.com/images/clients/' . substr($client_id,0,1) . '/' . $client_id  . '/pics' ;
        //$ssh->exec($cmd);
        @exec($cmd);
        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id,0,1). '/' . $client_id . '/pics' ;
        //$ssh->exec($cmd);
        @exec($cmd);
    }

    function  createExtraCkfinderDirectories($client_id,$list)  {
        /* start directories */
        global $db;
        global $ssh;
        $dt = date('Y-m-d H:i:s');

        $s = "select * from clients_leadpops where client_id = " . $client_id . " and leadpop_id in " . $list . " " ;

        $imgs = array();
        if ($img = $db->query($s)) {
            while($row = $img->fetch_assoc()) {
                $imgs[] = $row;
            }
            //var_dump($imgs);
            for($j=0; $j<count($imgs); $j++) {
                $s = "select * from leadpops where id = " . $imgs[$j]['leadpop_id'];
                if ($arec = $db->query($s)) {
                    $arow = $arec->fetch_assoc();
                    $s = "select id,lead_pop_vertical from leadpops_verticals where id = " . $arow['leadpop_vertical_id'];
                    //print($s);
                    if ($brec = $db->query($s)) {
                        while($xrow = $brec->fetch_assoc()) {
                            $vertical_name = strtolower(str_replace(" ","",$xrow['lead_pop_vertical']));
                            //		print("vertical name " . $vertical_name);
                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name;
                            //$ssh->exec($cmd);
                            @exec($cmd);
                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/company_logos'  ;
                            //$ssh->exec($cmd);
                            @exec($cmd);

                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/general'  ;
                            //$ssh->exec($cmd);
                            @exec($cmd);

                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/general/call_to_action_buttons'  ;
                            //$ssh->exec($cmd);
                            @exec($cmd);

                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/general/homepage_graphics'  ;
                            //$ssh->exec($cmd);
                            @exec($cmd);

                            $s = "select lead_pop_vertical_sub from leadpops_verticals_sub where leadpop_vertical_id = " . $xrow['id'];
                            if ($zrec = $db->query($s)) {
                                while($hrow = $zrec->fetch_assoc()) {
                                    $subvertical_name = strtolower(str_replace(" ","",$hrow['lead_pop_vertical_sub']));
                                    //	print("subvertical name " . $subvertical_name);
                                    $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/' . $subvertical_name;
                                    //$ssh->exec($cmd);
                                    @exec($cmd);
                                    $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/' . $subvertical_name . '/call_to_action_buttons';
                                    //$ssh->exec($cmd);
                                    @exec($cmd);
                                    $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/' . $subvertical_name . '/homepage_graphics';
                                    //$ssh->exec($cmd);
                                    @exec($cmd);

                                }
                            }
                        }
                    }
                }
            }
        }

        $s = "select * from clients_leadpops where client_id = " . $client_id . " and leadpop_id in " . $list . " " ;
        $cimgs = array();
        if ($cimg = $db->query($s)) {
            while($zrow = $cimg->fetch_assoc()) {
                $cimgs[] = $zrow;
            }
            for($jj=0; $jj<count($cimgs); $jj++) {
                $s = "select * from leadpops where id = " . $cimgs[$jj]['leadpop_id'];
                if ($zarec = $db->query($s)) {
                    /* copy default logos */
                    $cmd = '/bin/cp -Rf /var/www/vhosts/myleads.leadpops.com/stockimages/default_logos/* /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/default_logos/';
                    //$ssh->exec($cmd);
                    @exec($cmd);

                    $cmd = '/bin/cp -Rf /var/www/vhosts/myleads.leadpops.com/stockimages/general/* /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/general/';
                    //$ssh->exec($cmd);
                    @exec($cmd);
                    /* copy default logos */
                    $zarow = $zarec->fetch_assoc();
                    $s = "select id,lead_pop_vertical from leadpops_verticals where id = " . $zarow['leadpop_vertical_id'];
                    if ($zbrec = $db->query($s)) {
                        while($zxrow = $zbrec->fetch_assoc()) {
                            $vertical_name = strtolower(str_replace(" ","",$zxrow['lead_pop_vertical']));
                            //	print("second vertical name " . $vertical_name);

                            $cmd = '/bin/cp -Rf /var/www/vhosts/myleads.leadpops.com/stockimages/'.$vertical_name.'/* /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' .$vertical_name . '/';
                            //$ssh->exec($cmd);
                            @exec($cmd);

                        }
                    }
                }
            }
        }

        /* end directories */

    }

    function  createCkfinderDirectories($client_id)  {
        /* start directories */
        global $db;
        global $ssh;
        $dt = date('Y-m-d H:i:s');

        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id ;
        //$ssh->exec($cmd);
        @exec($cmd);

        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . '_thumbs';
        //$ssh->exec($cmd);
        @exec($cmd);

        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . '_thumbs' . '/Images' ;
        //$ssh->exec($cmd);
        @exec($cmd);

        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'files' ;
        //$ssh->exec($cmd);
        @exec($cmd);

        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'flash' ;
        //$ssh->exec($cmd);
        @exec($cmd);

        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'images' ;
        //$ssh->exec($cmd);
        @exec($cmd);

        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'uploads' ;
        //$ssh->exec($cmd);
        @exec($cmd);

        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'images/default_logos' ;
        //$ssh->exec($cmd);
        @exec($cmd);

        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'images/general' ;
        //$ssh->exec($cmd);
        @exec($cmd);

        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'images/general/call_to_action_buttons' ;
        //$ssh->exec($cmd);
        @exec($cmd);

        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'images/general/homepage_graphics' ;
        //$ssh->exec($cmd);
        @exec($cmd);

        $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/' . 'images/background_images' ;
        //$ssh->exec($cmd);
        @exec($cmd);

        $s = "select * from clients_leadpops where client_id = " . $client_id;

        $imgs = array();
        if ($img = $db->query($s)) {
            while($row = $img->fetch_assoc()) {
                $imgs[] = $row;
            }
            //var_dump($imgs);
            for($j=0; $j<count($imgs); $j++) {
                $s = "select * from leadpops where id = " . $imgs[$j]['leadpop_id'];
                if ($arec = $db->query($s)) {
                    $arow = $arec->fetch_assoc();
                    $s = "select id,lead_pop_vertical from leadpops_verticals where id = " . $arow['leadpop_vertical_id'];
                    //print($s);
                    if ($brec = $db->query($s)) {
                        while($xrow = $brec->fetch_assoc()) {
                            $vertical_name = strtolower(str_replace(" ","",$xrow['lead_pop_vertical']));
                            //		print("vertical name " . $vertical_name);
                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name;
                            //$ssh->exec($cmd);
                            @exec($cmd);
                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/company_logos'  ;
                            //$ssh->exec($cmd);
                            @exec($cmd);

                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/general'  ;
                            //$ssh->exec($cmd);
                            @exec($cmd);

                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/general/call_to_action_buttons'  ;
                            //$ssh->exec($cmd);
                            @exec($cmd);

                            $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/general/homepage_graphics'  ;
                            //$ssh->exec($cmd);
                            @exec($cmd);

                            $s = "select lead_pop_vertical_sub from leadpops_verticals_sub where leadpop_vertical_id = " . $xrow['id'];
                            if ($zrec = $db->query($s)) {
                                while($hrow = $zrec->fetch_assoc()) {
                                    $subvertical_name = strtolower(str_replace(" ","",$hrow['lead_pop_vertical_sub']));
                                    //	print("subvertical name " . $subvertical_name);
                                    $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/' . $subvertical_name;
                                    //$ssh->exec($cmd);
                                    @exec($cmd);
                                    $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/' . $subvertical_name . '/call_to_action_buttons';
                                    //$ssh->exec($cmd);
                                    @exec($cmd);
                                    $cmd = '/bin/mkdir  -p -m 0777  /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' . $vertical_name . '/' . $subvertical_name . '/homepage_graphics';
                                    //$ssh->exec($cmd);
                                    @exec($cmd);

                                }
                            }
                        }
                    }
                }
            }
        }

        $s = "select * from clients_leadpops where client_id = " . $client_id;
        $cimgs = array();
        if ($cimg = $db->query($s)) {
            while($zrow = $cimg->fetch_assoc()) {
                $cimgs[] = $zrow;
            }
            for($jj=0; $jj<count($cimgs); $jj++) {
                $s = "select * from leadpops where id = " . $cimgs[$jj]['leadpop_id'];
                if ($zarec = $db->query($s)) {
                    /* copy default logos */
                    $cmd = '/bin/cp -Rf /var/www/vhosts/myleads.leadpops.com/stockimages/default_logos/* /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/default_logos/';
                    //$ssh->exec($cmd);
                    @exec($cmd);

                    $cmd = '/bin/cp -Rf /var/www/vhosts/myleads.leadpops.com/stockimages/general/* /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/general/';
                    //$ssh->exec($cmd);
                    @exec($cmd);
                    /* copy default logos */
                    $zarow = $zarec->fetch_assoc();
                    $s = "select id,lead_pop_vertical from leadpops_verticals where id = " . $zarow['leadpop_vertical_id'];
                    if ($zbrec = $db->query($s)) {
                        while($zxrow = $zbrec->fetch_assoc()) {
                            $vertical_name = strtolower(str_replace(" ","",$zxrow['lead_pop_vertical']));
                            //	print("second vertical name " . $vertical_name);

                            $cmd = '/bin/cp -Rf /var/www/vhosts/myleads.leadpops.com/stockimages/'.$vertical_name.'/* /var/www/vhosts/myleads.leadpops.com/ckfinder/userfiles/' . substr($client_id,0,1). '/' . $client_id  . '/images/' .$vertical_name . '/';
                            //$ssh->exec($cmd);
                            @exec($cmd);

                        }
                    }
                }
            }
        }

        /* end directories */

    }

    function  getMobileImageDimensions ($w,$h) {
        if ($w <= 320 && $h <= 71 ) {
            return $w . "~" . $h;
        }
        else { // must resize
            $ratio = ($w / $h);
            //die($ratio);
            // 1309/718
            do  {
                $w -= $ratio;
                $h -= 1;
            } while ($w > 320 || $h > 71);
            return $w . "~" . $h;
        }
    }

    function resizeImage($CurWidth,$CurHeight,$DestFolder,$SrcImage,$Quality,$ImageType,$resize,$TempSrc) {

        if($CurWidth <= 0 || $CurHeight <= 0)
        {
            return false;
        }

        if ($resize)  {
//			320 X 70

            $dimensions = explode("~", getMobileImageDimensions($CurWidth,$CurHeight));
            $NewWidth = $dimensions[0];
            $NewHeight = $dimensions[1];
            $NewCanves = imagecreatetruecolor($NewWidth, $NewHeight);
            switch ($ImageType)
            {
                case 'image/png':
                    // integer representation of the color black (rgb: 0,0,0)
                    $background = imagecolorallocate($NewCanves, 0, 0, 0);
                    // removing the black from the placeholder
                    imagecolortransparent($NewCanves, $background);

                    // turning off alpha blending (to ensure alpha channel information
                    // is preserved, rather than removed (blending with the rest of the
                    // image in the form of black))
                    imagealphablending($NewCanves, false);

                    // turning on alpha channel information saving (to ensure the full range
                    // of transparency is preserved)
                    imagesavealpha($NewCanves, true);

                    break;
                case "image/gif":
                    // integer representation of the color black (rgb: 0,0,0)
                    $background = imagecolorallocate($NewCanves, 0, 0, 0);
                    // removing the black from the placeholder
                    imagecolortransparent($NewCanves, $background);

                    break;
            }

            // Resize Image
            try {
                imagecopyresampled($NewCanves, $SrcImage,0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight);
            } catch (Exception $e) {
                die( ' imagecopyresampled : ' .  $e->getMessage());
            }
            try {
                imagepng($NewCanves,$DestFolder);
            } catch (Exception $e) {
                die( ' imagepng: ' .  $e->getMessage());
            }

        }
        else {
            $cmd = '/bin/cp  ' . $TempSrc . '  ' . $DestFolder;
            exec($cmd);
        }

    }


    function colorizeBasedOnAplhaChannnel( $file, $targetR, $targetG, $targetB, $targetName ) {

        if(file_exists($targetName)){
            unlink($targetName);
        }

        $im_src = imagecreatefrompng( $file );
        $width = imagesx($im_src);
        $height = imagesy($im_src);

        $im_dst = imagecreatefrompng( $file );

        imagealphablending( $im_dst, false );
        imagesavealpha( $im_dst, true );
        imagealphablending( $im_src, false );
        imagesavealpha( $im_src, true );
        imagefilledrectangle( $im_dst, 0, 0, $width, $height, '0xFFFFFF' );

        for( $x=0; $x<$width; $x++ ) {
            for( $y=0; $y<$height; $y++ ) {

                $alpha = ( imagecolorat( $im_src, $x, $y ) >> 24 & 0xFF );
                $col = imagecolorallocatealpha( $im_dst,
                    $targetR - (int) ( 1.0 / 255.0  * $alpha * (double) $targetR ),
                    $targetG - (int) ( 1.0 / 255.0  * $alpha * (double) $targetG ),
                    $targetB - (int) ( 1.0 / 255.0  * $alpha * (double) $targetB ),
                    $alpha
                );
                if ( false === $col ) {
                    die( 'sorry, out of colors...' );
                }
                imagesetpixel( $im_dst, $x, $y, $col );
            }

        }
        imagepng( $im_dst, $targetName);
        imagedestroy($im_dst);
    }


    function getHttpAdminServer() {
        global $xzdb;
        $s = "select http from httpadminserver limit 1 " ;
        $http = $xzdb->fetchOne($s);
        return $http;
    }

    function hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);

        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        $rgb = array($r, $g, $b);
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }
}
