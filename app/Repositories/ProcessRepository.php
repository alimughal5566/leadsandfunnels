<?php
/**
 * Created by PhpStorm.
 * User: Jazib Javed
 * Date: 06/11/2019
 * Time: 5:41 PM
 */

/**
 * Code Migrated from Zend to Laravel  ==>  ProcessRepository --> Source: Default_Model_Login
 */

namespace App\Repositories;
use App\Services\DataRegistry;
use App\Services\gm_process\MyLeadsEvents;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessRepository
{
    const TYPE_DEFAULT = 1;
    const TYPE_MOVEMENT = 2;
    const TYPE_FAIRWAY = 3;
    const TYPE_INSURANCE = 4;
    const TYPE_BALLER = 5;
    const TYPE_REALESTATE = 6;
    const TYPE_STEARNS = 7;
    private $db;
    private $files;

    private $globallogosrc;
    private $globallogo_color;
    private $logoname;
    private $logo_color;
    private $favicon;
    private $check;
    private $dot;
    private $ring;
    private $vertical;

    private $leadpops_client_folders = array();

    public function __construct(\App\Services\DbService $service){
        $this->db = $service;
        $this->files = [];
    }

    public function getClientByID($client_id){
        $s = "select * from clients where client_id = " . $client_id . " limit 1 ";
        return $this->db->fetchRow($s);
    }

    public function getClientFunnels(){
        $q = "select * from add_client_funnels where has_run = 'n' limit 1";
        return $this->db->fetchRow($q);
    }

    public function getClientWebsiteFunnels($client_id, $type = ProcessRepository::TYPE_DEFAULT){
        switch ($type){
            case ProcessRepository::TYPE_MOVEMENT:
                $add_mortgage_website_funnels_mvp = "add_mortgage_website_funnels_mvp_movement";
                break;
            case ProcessRepository::TYPE_FAIRWAY:
                $add_mortgage_website_funnels_mvp = "add_mortgage_website_funnels_mvp_fairway";
                break;
            case ProcessRepository::TYPE_INSURANCE:
                $add_mortgage_website_funnels_mvp = "add_insurance_website_funnels_mvp";
                break;
            case ProcessRepository::TYPE_BALLER:
                $add_mortgage_website_funnels_mvp = "add_mortgage_website_funnels_mvp_baller";
                break;
            case ProcessRepository::TYPE_REALESTATE:
                $add_mortgage_website_funnels_mvp = "add_realestate_website_funnels_mvp";
                break;
            case ProcessRepository::TYPE_STEARNS:
                $add_mortgage_website_funnels_mvp = "add_mortgage_website_funnels_mvp_stearns";
                break;
            default:
                $add_mortgage_website_funnels_mvp = "add_mortgage_website_funnels_mvp";
                break;
        }
        $q = "select * from $add_mortgage_website_funnels_mvp where client_id =  " . $client_id . " and has_run = 'n' and has_been_cloned = 'n' ";
        return $this->db->fetchAll($q);
    }

    // Code taken from function addNonEnterpriseVerticalSubverticalVersionToExistingClient
    public function addFunnel($funnel, $sub_level_domain, $top_level_domain, $type = "") {
        $xpvertical_id = $funnel["vertical_id"];
        $subvertical_id = $funnel["subvertical_id"];
        $version_id = $funnel["version_id"];
        $client_id = $funnel["client_id"];
        $logo="";
        $mobilelogo="";
        $origvertical_id="";
        $origsubvertical_id="";
        $leadpoptype = 1;
        $origversion_id="";
        $origleadpop_type_id="";
        $origleadpop_template_id="";
        $origleadpop_id="";
        $origleadpop_version_id="";
        $origleadpop_version_seq="";

        $section = substr($client_id,0,1);

        switch ($type){
            case ProcessRepository::TYPE_FAIRWAY:
                $trial_launch_defaults = "trial_launch_defaults_fairway";
                break;
            case ProcessRepository::TYPE_BALLER:
                $trial_launch_defaults = "trial_launch_defaults_ballers";
                break;
            default:
                $trial_launch_defaults = "trial_launch_defaults";
                break;
        }


        if ($xpvertical_id == "1") {
            $vertical = "insurance";
        }
        else if ($xpvertical_id == "3") {
            $vertical = "mortgage";
        }
        else if ($xpvertical_id == "5") {
            $vertical = "realestate";
        }
        // TODO: SAL ⇒ Setting in later map through SQL
        // $this->setVertical($vertical);

        $s = "select * from clients where client_id = " . $client_id;
        $client = $this->db->fetchRow($s);
        $client['company_name'] = ucfirst(strtolower($client ['company_name']));
        $enteredEmail = $client["contact_email"]; // use this to look up in IFS

        $generatecolors = false;
        if ($logo == "" && $mobilelogo == "") { // inother words use defaults for logo and mobile logo
            $useUploadedLogo = false;
            $default_background_changed = "n";
        }
        else if ($logo != "" && $mobilelogo != "" && $origleadpop_type_id != "" && $origleadpop_template_id != "" && $origleadpop_id != "" && $origleadpop_version_id !="" && $origleadpop_version_seq !="") {
            $default_background_changed = "y";
            $generatecolors = false;  // in other workds use existing logo and mobile logo and copy them to new funnel as if no upload was done
            $useUploadedLogo = true;
        }
        else if ($logo != "" && $mobilelogo == "" && $origleadpop_type_id == "" && $origleadpop_template_id == "" && $origleadpop_id == "" && $origleadpop_version_id =="" && $origleadpop_version_seq =="") {
            $default_background_changed = "y";
            $generatecolors = true;  // in other words act as if a new logo was uploaded & generate mobile logo
            $useUploadedLogo = true;
        }

        if ($generatecolors == false && $useUploadedLogo == false) { // not uploaded logo or have previous funnel to use -- THIS is the case always executes

            $s = "select * from ".$trial_launch_defaults." where leadpop_vertical_id = " . $xpvertical_id . " and leadpop_vertical_sub_id = " . $subvertical_id . " and leadpop_version_id = " . $version_id . " limit 1 ";
            $trialDefaults = $this->db->fetchAll($s);

            $s = "select * from default_swatches where active = 'y' order by id ";
            $finalTrialColors = $this->db->fetchAll($s);
            $background_css = "linear-gradient(to bottom, rgba(108, 124, 156, 0.99) 0%, rgba(108, 124, 156, 0.99) 100%)";

            /**
             * TODO: SAL
             */
//            $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classiclogos/' . $trialDefaults[0]["logo_name_mobile"] . '  /var/www/vhosts/itclixmobile.com/css/'.str_replace(" ","",$trialDefaults[0]["subvertical_name"]).$trialDefaults[0]["leadpop_version_id"] . '/themes/images/' . $client_id . 'grouplogo.png';
//            exec($cmd);

            $s = "select * from leadpops_verticals where id = " . $trialDefaults[0]["leadpop_vertical_id"];
            $vertres = $this->db->fetchRow ( $s );
            $verticalName = $vertres ['lead_pop_vertical'];

            $s = "select * from leadpops_verticals_sub where leadpop_vertical_id  = " . $trialDefaults[0]["leadpop_vertical_id"];
            $s .= " and id = " . $trialDefaults[0]["leadpop_vertical_sub_id"];
            $subvertres = $this->db->fetchRow ( $s );
            $subverticalName = $subvertres ['lead_pop_vertical_sub'];

            /**
             * TODO: SAL
             */
            //this used for thank you content
            $logosrc = $this->getRackspaceUrl ('image_path','default-assets').'/images/' . strtolower(str_replace(" ","",$verticalName)) . '/' . strtolower(str_replace(" ","",$subverticalName)). '_logos/' .$trialDefaults[0]["logo_name"];
            //this used for logo section
            $logo = $trialDefaults[0]["logo_name"];
            $this->insertDefaultClientUploadLogo($logo,$trialDefaults[0],$client_id);
            $imgsrc = $this->insertClientDefaultImage($trialDefaults[0],$client_id);
            $this->setClientDefaultFaviconColor($trialDefaults[0]);

        }
        else if ($generatecolors == false && $useUploadedLogo == true) { // get colors from leadpops_background_swatches

            $y = "select * from ".$trial_launch_defaults." where leadpop_vertical_id = ".$xpvertical_id." and leadpop_vertical_sub_id = " . $subvertical_id . " and leadpop_version_id = " . $version_id . " limit 1 ";
            $trialDefaults = $this->db->fetchAll($y);

            if(env('APP_ENV') === config('app.env_local')) {
                $leadpop_background_swatches = 'leadpop_background_swatches';
            }else{
                $leadpop_background_swatches = getPartition($client_id, "leadpop_background_swatches");
            }

            $s = "select * from ".$leadpop_background_swatches;
            $s .= " where  client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $origleadpop_version_id;
            $s .= " and leadpop_version_seq = " . $origleadpop_version_seq;
            $finalTrialColors = $this->db->fetchAll($s);

            for($t = 0; $t < count($finalTrialColors); $t++) {
                $s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
                $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
                $s .= "swatch,is_primary,active) values (null,";
                $s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
                $s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
                $s .= $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
                $s .= $trialDefaults[0]["leadpop_id"] . ",";
                $s .= $trialDefaults[0]["leadpop_version_id"] . ",";
                $s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
                $s .= "'" . $finalTrialColors[$t]["swatch"] . "','".$finalTrialColors[$t]["is_primary"]."',";
                $s .= "'y')";
                $this->db->query($s);
            }

            $s = "select background_color from leadpop_background_color ";
            $s .= " where  client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $origleadpop_version_id;
            $s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
            $background_css = $this->db->fetchOne($s);

            $s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
            $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
            $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
            $s .= "background_color,active,default_changed) values (null,";
            $s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
            $s .= $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
            $s .= $trialDefaults[0]["leadpop_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_version_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
            $s .= "'" . addslashes($background_css) . "','y','".$default_background_changed."')";
            $this->db->query($s);

            $s = "select logo_color  from leadpop_logos ";
            $s .= " where  client_id = " . $client_id;
            $s .= " and leadpop_vertical_id = " . $origvertical_id;
            $s .= " and leadpop_vertical_sub_id  = " . $origsubvertical_id;
            $s .= " and leadpop_type_id  = " . $origleadpop_type_id;
            $s .= " and leadpop_template_id = " . $origleadpop_template_id;
            $s .= " and  leadpop_id = " . $origleadpop_id;
            $s .= " and leadpop_version_id = " . $origleadpop_version_id;
            $s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
            $colors = $this->db->fetchAll($s);


            // copy logo to new logo name
            /*
            $logopath = '/var/www/vhosts/myleads.leadpops.com/images/clients/'.$section.'/'.$client_id.'/logos/';
            $origlogo = $logopath . $logo;
            $newlogoname = strtolower($client_id."_".$trialDefaults[0]["leadpop_id"]."_".$trialDefaults[0]["leadpop_type_id"]."_".$trialDefaults[0]["leadpop_vertical_id"]."_".$trialDefaults[0]["leadpop_vertical_sub_id"]."_".$trialDefaults[0]["leadpop_template_id"]."_".$trialDefaults[0]["leadpop_version_id"]."_".$trialDefaults[0]["leadpop_version_seq"]."_".$logo);
            $newlogo = $logopath . $newlogoname;
            $cmd = '/bin/cp  ' .$origlogo . '   ' . $newlogo;
            exec($cmd);
            */

            // copy mobile logo to new name
            $s = "select include_path from mobile_paths where leadpop_id = " . $origleadpop_id . " limit 1 ";
            $origDestinationDirectory = $this->db->fetchOne($s);
            $origCopyDestinationDirectoryFile   = "/var/www/vhosts/itclixmobile.com" .$origDestinationDirectory . $mobilelogo;

            $s = "select include_path from mobile_paths where leadpop_id = " . $trialDefaults[0]["leadpop_id"] . " limit 1 ";
            $DestinationDirectory = $this->db->fetchOne($s);
            $newmobilelogo = $client_id . "grouplogo.png";
            $CopyDestinationDirectoryFile = "/var/www/vhosts/itclixmobile.com" . $DestinationDirectory . $newmobilelogo;
            $cmd = '/bin/cp  ' . $origCopyDestinationDirectoryFile . '   ' . $CopyDestinationDirectoryFile;
            exec($cmd);

            $oldfilename = strtolower($client_id."_".$origleadpop_id."_".$origleadpop_type_id."_".$origvertical_id."_".$origsubvertical_id."_".$origleadpop_template_id."_".$origleadpop_version_id."_".$origleadpop_version_seq);
            $newfilename = $client_id."_".$trialDefaults[0]["leadpop_id"]."_1_".$trialDefaults[0]["leadpop_vertical_id"]."_".$trialDefaults[0]["leadpop_vertical_sub_id"]."_".$trialDefaults[0]['leadpop_template_id']."_".$trialDefaults[0]["leadpop_version_id"]."_".$trialDefaults[0]["leadpop_version_seq"];

            $origfavicon_dst_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$oldfilename.'_favicon-circle.png';
            $newfavicon_dst_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newfilename.'_favicon-circle.png';

            $cmd = '/bin/cp  ' . $origfavicon_dst_src . '   ' . $newfavicon_dst_src;
            exec($cmd);

            $origcolored_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$oldfilename.'_dot_img.png';
            $newcolored_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newfilename.'_dot_img.png';

            $cmd = '/bin/cp  ' . $origcolored_dot_src . '   ' . $newcolored_dot_src;
            exec($cmd);

            $origmvp_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$oldfilename.'_ring.png';
            $newmvp_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newfilename.'_ring.png';

            $cmd = '/bin/cp  ' . $origmvp_dot_src . '   ' . $newmvp_dot_src;
            exec($cmd);

            $newmvp_check_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newfilename.'_mvp-check.png';
            $origmvp_check_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$oldfilename.'_mvp-check.png';

            $cmd = '/bin/cp  ' . $origmvp_check_src . '   ' . $newmvp_check_src;
            exec($cmd);

            $logosrc = newinsertClientUploadLogo($newlogoname,$trialDefaults[0],$client_id);
            $imgsrc = insertClientNotDefaultImage($trialDefaults[0],$client_id,$origleadpop_id,$origleadpop_type_id,$origvertical_id,$origsubvertical_id,$origleadpop_template_id,$origleadpop_version_id,$origleadpop_version_seq);

            $globallogosrc = $logosrc;
            $globalfavicon_dst = $newfavicon_dst_src;
            $globallogo_color = $colors[0]["logo_color"];
            $globalcolored_dot = $newcolored_dot_src;
            $globalmvp_dot = $newmvp_dot_src;
            $globalmvp_check = $newmvp_check_src;

            // set mobile logo varibale

        }
        else if ($generatecolors == true && $useUploadedLogo == true) { //

            $s = "select * from ".$trial_launch_defaults." where leadpop_vertical_id = " . $xpvertical_id . " and leadpop_vertical_sub_id = " . $subvertical_id . " and leadpop_version_id = " . $version_id . " limit 1 ";
            $trialDefaults = $this->db->fetchAll($s);
//	      id leadpop_vertical_id	leadpop_vertical_sub_id	leadpop_type_id	leadpop_template_id	leadpop_id	leadpop_version_id	leadpop_version_seq
//       /var/www/vhosts/myleads.leadpops.com/images/clients/7/702/logos/ 702_22_1_3_8_11_11_1_et2bn1cudzrrji5smkay.png
//       /var/www/vhosts/itclixmobile.com/css/refinance11/themes/images/    702grouplogo.png
// pass in logo name only
            $logopath = '/var/www/vhosts/myleads.leadpops.com/images/clients/'.$section.'/'.$client_id.'/logos/';
            $origlogo = $logopath . $logo;
            $newlogoname = strtolower($client_id."_".$trialDefaults[0]["leadpop_id"]."_".$trialDefaults[0]["leadpop_type_id"]."_".$trialDefaults[0]["leadpop_vertical_id"]."_".$trialDefaults[0]["leadpop_vertical_sub_id"]."_".$trialDefaults[0]["leadpop_template_id"]."_".$trialDefaults[0]["leadpop_version_id"]."_".$trialDefaults[0]["leadpop_version_seq"]."_".$logo);

            $newlogo = $logopath . $newlogoname;

            $cmd = '/bin/cp  ' .$origlogo . '   ' . $newlogo;
            exec($cmd);

            $oclient = new Client();

            $gis       = getimagesize($newlogo);
            $ow = $gis[0];
            $oh = $gis[1];
            $type = $gis[2];
            //die($type.' type');
            switch($type)
            {
                case "1":
                    $im = imagecreatefromgif($newlogo);
                    $image = $oclient->loadGif($newlogo);
                    $logo_color = $image->extract();
                    break;
                case "2":
                    $im = imagecreatefromjpeg($newlogo);
                    $image = $oclient->loadJpeg($newlogo);
                    $logo_color = $image->extract();
                    break;
                case "3":
                    $im = imagecreatefrompng($newlogo);
                    $image = $oclient->loadPng($newlogo);
                    $logo_color = $image->extract();
                    break;
                default:  $im = imagecreatefromjpeg($newlogo);
            }

            if(is_array($logo_color)){
                $logo_color = $logo_color[0];
            }

            $imagetype = image_type_to_mime_type($type);
            if($imagetype != 'image/jpeg' && $imagetype != 'image/png' &&  $imagetype != 'image/gif' ) {
                return 'bad' ;
            }

            $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
            $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
            $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
            $s .= "logo_src,use_me,numpics,logo_color,ini_logo_color) values (null,";
            $s .= $client_id.",".$trialDefaults[0]["leadpop_id"].",".$trialDefaults[0]["leadpop_type_id"].",".$trialDefaults[0]["leadpop_vertical_id"].",".$trialDefaults[0]["leadpop_vertical_sub_id"].",";
            $s .= $trialDefaults[0]["leadpop_template_id"].",".$trialDefaults[0]["leadpop_version_id"].",".$trialDefaults[0]["leadpop_version_seq"].",";
            $s .= "'n','".$newlogoname."','y',1, '".$logo_color."','".$logo_color."') ";
            $this->db->query($s);

            $logosrc = getHttpAdminServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'. $newlogoname;

            $image_location = "/var/www/vhosts/itclix.com/images/dot-img.png";
            $favicon_location = "/var/www/vhosts/itclix.com/images/favicon-circle.png";
            $mvp_dot_location = "/var/www/vhosts/itclix.com/images/ring.png";
            $mvp_check_location = "/var/www/vhosts/itclix.com/images/mvp-check.png";

            $favicon_dst_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. $section . '/' . $client_id.'/logos/'.$newlogoname.'_favicon-circle.png';
            $colored_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. $section . '/' . $client_id.'/logos/'.$newlogoname.'_dot_img.png';
            $mvp_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. $section . '/' . $client_id.'/logos/'.$newlogoname.'_ring.png';
            $mvp_check_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. $section . '/' . $client_id.'/logos/'.$newlogoname.'_mvp-check.png';

            if (isset($logo_color) && $logo_color != "" ) {
                $new_clr = hex2rgb($logo_color);
            }

            $im = imagecreatefrompng($image_location);
            $myRed =  $new_clr[0];
            $myGreen =  $new_clr[1];
            $myBlue =  $new_clr[2];

            colorizeBasedOnAplhaChannnel( $image_location, $myRed, $myGreen, $myBlue, $colored_dot_src);
            colorizeBasedOnAplhaChannnel( $favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src);
            colorizeBasedOnAplhaChannnel( $mvp_dot_location, $myRed, $myGreen, $myBlue, $mvp_dot_src);
            colorizeBasedOnAplhaChannnel( $mvp_check_location, $myRed, $myGreen, $myBlue, $mvp_check_src);

            $colored_dot = getHttpAdminServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newlogoname.'_dot_img.png';
            $favicon_dst = getHttpAdminServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newlogoname.'_favicon-circle.png';
            $mvp_dot = getHttpServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newlogoname.'_ring.png';
            $mvp_check = getHttpServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newlogoname.'_mvp-check.png';

            $swatches =   "213-230-229#23-177-163#159-182-183#65-88-96#110-158-159#132-212-204" ;

            $result = explode("#",$swatches);
            $new_color = hex2rgb($logo_color);
            $index = 0;
            array_unshift($result, implode('-', $new_color));

            // SET BACKGROUND COLOR
            $background_from_logo = '/*###>*/background-color: rgba('.$new_color[0].', '.$new_color[1].', '.$new_color[2].', 1);/*@@@*/
			background-image: linear-gradient(to right bottom,rgba('.$new_color[0].', '.$new_color[1].', '.$new_color[2].', 1) 0%,rgba('.$new_color[0].', '.$new_color[1].', '.$new_color[2].', 1) 100%); /* W3C */';

            $s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
            $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
            $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
            $s .= "background_color,active,default_changed) values (null,";
            $s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_template_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_version_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
            $s .= "'" . addslashes($background_from_logo) . "','y','y')";
            $this->db->query($s);

            foreach($result as $key => $value) {

                list($red,$green,$blue) = explode("-",$value);

                if($key<1){
                    $str0 = "linear-gradient(to bottom, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",1.0) 100%)";
                }else{
                    $str0 = "linear-gradient(to bottom, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",.7) 100%)";
                }

                $str1 = "linear-gradient(to top, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",.7) 100%)";
                $str2 = "linear-gradient(to bottom right, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",.7) 100%)";
                $str3 = "linear-gradient(to bottom, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",1.0) 100%)";

                $swatches = array($str0,$str1,$str2,$str3);
                for($i=0;  $i<4; $i++) {
                    $index++;
                    $is_primary = 'n';
                    if($index==1){
                        $is_primary = 'y';
                    }

                    $s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
                    $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                    $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
                    $s .= "swatch,is_primary,active) values (null,";
                    $s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
                    $s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
                    $s .= $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_template_id"] . ",";
                    $s .= $trialDefaults[0]["leadpop_id"] . ",";
                    $s .= $trialDefaults[0]["leadpop_version_id"] . ",";
                    $s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
                    $s .= "'" . addslashes($swatches[$i]) . "',";
                    $s .= "'".$is_primary."','y')";
                    $this->db->query($s);

                }
            }

            $s = "select background_color from leadpop_background_color ";
            $s .= " where  client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $trialDefaults[0]["leadpop_version_id"];
            $s .= " and leadpop_version_seq = " . $trialDefaults[0]["leadpop_version_seq"] . " limit 1 ";
            $background_css = $this->db->fetchOne($s);

            $s = "select * from ".getPartition($client_id, "leadpop_background_swatches");
            $s .= " where  client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $trialDefaults[0]["leadpop_version_id"];
            $s .= " and leadpop_version_seq = " . $trialDefaults[0]["leadpop_version_seq"] . " limit 1 ";
            $finalTrialColors = $this->db->fetchAll($s);

            $logo = $newlogoname; // set $logo to be used down stream
            /* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
            /* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
            /* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
            $s = "select include_path from mobile_paths where leadpop_id = " . $trialDefaults[0]["leadpop_id"] . " limit 1 ";
            $DestinationDirectory = $this->db->fetchOne($s);
            $CopyDestinationDirectoryFile = "/var/www/vhosts/itclixmobile.com" . $DestinationDirectory;
            $DestinationDirectory = "/var/www/vhosts/myleads.leadpops.com/data/mobileimages/";
            $Quality = 90;
            // set mobile logo varibale
            $mobilelogo = $client_id . "grouplogo.png";

            $resize = true;
            if ($ow <= 320  &&  $oh <= 70) { // best fit for logo image is no larger than this
                $resize = false;
            }

            $DestImageName = $DestinationDirectory . $mobilelogo; // Image with destination directory
            $CopyDestinationDirectoryFile = $CopyDestinationDirectoryFile . $mobilelogo;

            resizeImage($ow,$oh,$DestImageName,$im,$Quality,$type,$resize,$newlogo);
            $cmd = '/bin/cp  ' . $DestImageName . '  ' . $CopyDestinationDirectoryFile;
            exec($cmd);

            /* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
            /* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
            /* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */

            $logosrc = newinsertClientUploadLogo($newlogoname,$trialDefaults[0],$client_id);
            $imgsrc = insertClientDefaultImage($trialDefaults[0],$client_id);

            $globallogosrc = $logosrc;
            $globalfavicon_dst = $favicon_dst;
            $globalmvp_dot = $mvp_dot;
            $globalmvp_check = $mvp_check;
            $globallogo_color = $logo_color;
            $globalcolored_dot = $colored_dot;

        }

        $dt = date("Y-m-d H:i:s");

        // craete this array so as not to have to chg code
        $freeTrialBuilderAnswers = array("emailaddress" => $client["contact_email"],"phonenumber" => $client["phone_number"]);

        $this->insertDefaultAutoResponders ($client_id, $trialDefaults[0], $client["contact_email"], $client["phone_number"]) ;

        if(!@$trialDefaults[0]["funnel_questions"] || $trialDefaults[0]["funnel_questions"] == null){
            $trialDefaults[0]["funnel_questions"] = "{}";
        }
        if(!@$trialDefaults[0]["conditional_logic"] || $trialDefaults[0]["conditional_logic"] == null){
            $trialDefaults[0]["conditional_logic"] = "{}";
        }
        if(!@$trialDefaults[0]["funnel_hidden_field"] || $trialDefaults[0]["funnel_hidden_field"] == null){
            $trialDefaults[0]["funnel_hidden_field"] = "{}";
        }


        $s = "select id,lead_pop_vertical from leadpops_verticals where id = " . $xpvertical_id;
        $_vertical = $this->db->fetchRow($s);
        /*
         * Add default vertical name in leadpops_folders table
         * */
        $folder_id  = $this->addFolder('Website Funnels',$client_id);

            $lead_line = '<span style="font-family: ' . $trialDefaults[0]["main_message_font"] . '; font-size: ' . $trialDefaults[0]["main_message_font_size"] . '; color: ' . ($this->getGloballogoColor() == "" ? $trialDefaults[0]["mainmessage_color"] : $this->getGloballogoColor()) . '">' . $trialDefaults[0]["main_message"] . '</span>';
            $second_line = '<span style="font-family: ' . $trialDefaults[0]["description_font"] . '; font-size: ' . $trialDefaults[0]["description_font_size"] . '; color: ' . $trialDefaults[0]["description_color"] . '">' . $trialDefaults[0]["description"] . '</span>';

        if($trialDefaults[0]["conditional_logic"]==null || $trialDefaults[0]["conditional_logic"]=="null"){
            $trialDefaults[0]["conditional_logic"] = "{}";
        }
        /**
         * Funnel Variables is not exist in trial_launch_defaults table, we need create the Associative Array and update.
         */
        $website_funnel_name = "";
        if(strpos($sub_level_domain, "find-a-home-site") !== false){
            $website_funnel_name = "Website - Home Search";
        }
        else if(strpos($sub_level_domain, "vip-home-search-site") !== false){
            $website_funnel_name = "Website - VIP Home";
        }
        else if(strpos($sub_level_domain, "home-valuation-address-site") !== false){
            $website_funnel_name = "Website - Home Values";
        }
        else if(strpos($sub_level_domain, "203k-rates-site") !== false){
            $website_funnel_name = "Website - 203K";
        }
        else if(strpos($sub_level_domain, "arm-site") !== false){
            $website_funnel_name = "Website - ARM";
        }
        else if(strpos($sub_level_domain, "rates-15yr-site") !== false){
            $website_funnel_name = "Website - 15yr Fixed";
        }
        else if(strpos($sub_level_domain, "rates-30yr-site") !== false){
            $website_funnel_name = "Website - 30yr Fixed";
        }
        /*else if(strpos($sub_level_domain, "rates-site") !== false){
            $website_funnel_name = "Website - Today’s Rates";
        }*/
        else if(strpos($sub_level_domain, "sidebar-site") !== false){
            $website_funnel_name = "Website - Sidebar";
        }
        else if(strpos($sub_level_domain, "verify-eligibility-site") !== false){
            $website_funnel_name = "Website - Eligibility";
        }
        else if(strpos($sub_level_domain, "pre-approval-letter-site") !== false){
            $website_funnel_name = "Website - Pre-Approval";
        }
        else if(strpos($sub_level_domain, "purchase-site") !== false){
            $website_funnel_name = "Website - Purchase";
        }
        else if(strpos($sub_level_domain, "refi-analysis-site") !== false){
            $website_funnel_name = "Website - Refi Analysis";
        }
        else if(strpos($sub_level_domain, "refinance-site") !== false){
            $website_funnel_name = "Website - Refinance";
        }
        else if(strpos($sub_level_domain, "fha-rates-site") !== false){
            $website_funnel_name = "Website - FHA Loans";
        }
        else if(strpos($sub_level_domain, "harp-loans-site") !== false){
            $website_funnel_name = "Website - HARP";
        }
        else if(strpos($sub_level_domain, "jumbo-rates-site") !== false){
            $website_funnel_name = "Website - Jumbo Loans";
        }
        else if(strpos($sub_level_domain, "reverse-mortgage-site") !== false){
            $website_funnel_name = "Website - Reverse";
        }
        else if(strpos($sub_level_domain, "usda-rates-site") !== false){
            $website_funnel_name = "Website - USDA Loans";
        }
        else if(strpos($sub_level_domain, "va-rates-site") !== false){
            $website_funnel_name = "Website - VA Loans";
        }
        else if(strpos($sub_level_domain, "rates-site") !== false){
            $website_funnel_name = "Website - Today’s Rates";
        }
        else if(strpos($sub_level_domain, "credit-repair") !== false){
            $website_funnel_name = "Website - Credit Repair";
        }
        else if(strpos($sub_level_domain, "-home-site-") !== false){
            $website_funnel_name = "Website - Home Insurance";
        }
        else {
            $website_funnel_name = $trialDefaults[0]["funnel_name"];
        }

        $s = "insert into clients_leadpops (client_id,question_sequence,funnel_questions,funnel_hidden_field,conditional_logic,lead_line,second_line_more,funnel_name,leadpop_id,
         leadpop_version_id,leadpop_active,access_code,leadpop_version_seq,funnel_market,static_thankyou_active,static_thankyou_slug,date_added,leadpop_folder_id) values (";
        $s .=  $client_id .",'" . addslashes($trialDefaults[0]["question_sequence"]) . "',
			'" . addslashes($trialDefaults[0]["funnel_questions"]) . "','" . addslashes($trialDefaults[0]["funnel_hidden_field"]) . "','" . $trialDefaults[0]["conditional_logic"] . "','" . addslashes($lead_line) . "','" . addslashes($second_line) . "','" . $website_funnel_name . "'," . $trialDefaults[0]["leadpop_id"] . ",
			" . $trialDefaults[0]["leadpop_version_id"] . ",'1',''," . $trialDefaults[0]["leadpop_version_seq"] . ",'w','y','thank-you.html',
			'".$dt."',".$folder_id.")";
        $this->db->query ( $s );


        $client_leadpop_id  = $this->db->lastInsertId();

        $this->createCloneFunnelRow($client_id,$client_leadpop_id);
        /*
         *Add default tag in leadpops_tags table
         *
         * */
        $this->assign_tag_to_funnel($client_leadpop_id,$trialDefaults[0],$client_id);

        $s = "insert into clients_funnels_domains (id,client_id,subdomain_name,funnel_name,top_level_domain,leadpop_vertical_id,";
        $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
        $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq ) values (null,";
        $s .= $client_id. ",'" . $sub_level_domain . "','" . $website_funnel_name . "','" . $top_level_domain . "',";
        $s .= $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . "," . $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
        $s .= $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ")";
        $this->db->query($s);


        //insert emma

        $s = "  select * from  client_emma_group  ";
        $s .= " where leadpop_vertical_id = " . $trialDefaults[0]["leadpop_vertical_id"];
        $s .= " and leadpop_subvertical_id = " .  $trialDefaults[0]["leadpop_vertical_sub_id"];
        $s .= " and client_id = " .$client_id . "";
        $emmaExists =  $this->db->fetchRow($s);
        if ($emmaExists) {
            $s = "insert into client_emma_group  (id,client_id,domain_name,member_account_id,member_group_id,";
            $s .= "group_name,total_contacts,leadpop_vertical_id,leadpop_subvertical_id,active) values (null,";
            $s .= $client_id .",'" .$sub_level_domain . "." . $top_level_domain."',".$emmaExists["member_account_id"].",".$emmaExists["member_group_id"].",'";
            $s .= $emmaExists["group_name"]."',0,".$trialDefaults[0]["leadpop_vertical_id"].",".$trialDefaults[0]["leadpop_vertical_sub_id"].",'y')";

            $this->db->query($s);
        }else{
            $emma_account_type = "mortgage";
            if($xpvertical_id == 5){
                $emma_account_type = "realestate";
            }
            //Taking basic information for emma from one of existing entry
            $sql = "SELECT id, emma_default_group, account_name, master_account_ids FROM client_emma_cron WHERE ";
            $sql .= " client_id= ".$client_id." and leadpop_vertical_id = ".$trialDefaults[0]["leadpop_vertical_id"]."
                        and leadpop_subvertical_id = ".$trialDefaults[0]["leadpop_vertical_sub_id"]."";
            $ex_emma_cron = $this->db->fetchRow( $sql );

                if($ex_emma_cron) {
                    $EmmaAccountName = $ex_emma_cron['account_name'];
                    $master_account_ids = $ex_emma_cron['master_account_ids'];
                    $emma_default_group = $ex_emma_cron['emma_default_group'];

                    //Check the entry in client_emma_account table
                    $emma_account = "SELECT * FROM client_emma_account WHERE client_id= " . $client_id . "";
                    $emma_account_res = $this->db->fetchRow($emma_account);
                    if (empty($emma_account_res)) {
                        /* emma insert */
                        $s = "insert into client_emma_cron (id,client_id,emma_default_group,account_type,domain_name,account_name,master_account_ids,has_run,
                        leadpop_vertical_id,leadpop_subvertical_id) values (null,";
                        $s .= $client_id . ",'" . $emma_default_group . "','" . $emma_account_type . "',
                        '" . strtolower($sub_level_domain . "." . $top_level_domain) . "','" . $EmmaAccountName . "','";
                        $s .= $master_account_ids . "','y'," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ")";
                        $this->db->query($s);
                    } else {
                        /*if already existing the entry then insert entry in the client_emma_group table*/
                        $s = "insert into client_emma_group  (id,client_id,domain_name,member_account_id,member_group_id,";
                        $s .= "group_name,total_contacts,leadpop_vertical_id,leadpop_subvertical_id,active) values (null,";
                        $s .= $client_id . ",'" . $sub_level_domain . "." . $top_level_domain . "'," . $emmaExists["member_account_id"] . "," . $emmaExists["member_group_id"] . ",'";
                        $s .= $emmaExists["group_name"] . "',0," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",'y')";

                        $this->db->query($s);
                    }
                }

        }



        // insert into force ssl
        $s = "insert into force_ssl (id,url) values (null,'".$sub_level_domain.".".$top_level_domain."')";
        $this->db->query($s);

        $googleDomain = $sub_level_domain . "." . $top_level_domain;
        $this->insertPurchasedGoogle ($client_id, $googleDomain );

        if ($generatecolors == false && $useUploadedLogo == true) { // get mobile from old funnel
            // set 	client_or_domain_logo_image to 'c'  to use upploaded logo
            /* mobile domain and logo */
            $s = "select * from bottom_links  where client_id = " . $client_id ;
            $s .= " and leadpop_version_id = " . $origleadpop_version_id;
            $s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
            $oldbototm = $this->db->fetchAll($s);

            $s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
            $s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
            $s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
            $s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
            $s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
            $s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
            $s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
            $s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
            $s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
            $s .= ") values (null,";
            $s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
            $s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
            $s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
            $s .= "'".$oldbototm[0]["compliance_text"]."','".$oldbototm[0]["compliance_is_linked"]."','".$oldbototm[0]["compliance_link"]."','".$oldbototm[0]["compliance_active"]."',";
            $s .= "'".$oldbototm[0]["license_number_active"]."','".$oldbototm[0]["license_number_is_linked"]."','".$oldbototm[0]["license_number_text"]."','".$oldbototm[0]["license_number_link"]."'";
            $s .= ") ";
            $this->db->query($s);
        }
        else {
            if ((@$vertical == "mortgage" || @$vertical == "realestate")) {
                $license_number_text = "";
                $s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
                $s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                $s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
                $s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
                $s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
                $s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
                $s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
                $s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
                $s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
                $s .= ") values (null,";
                $s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
                $s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
                $s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
                $s .= "'NMLS Consumer Look Up','y','http://www.nmlsconsumeraccess.org','y',";
                $s .= "'y','n','".$license_number_text."',''";
                $s .= ") ";

                $this->db->query ( $s );
            }
            else if (@$vertical == "insurance") {
                $license_number_text = "";
                $s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
                $s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                $s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
                $s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
                $s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
                $s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
                $s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
                $s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
                $s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
                $s .= ") values (null,";
                $s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
                $s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
                $s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
                $s .= "'NMLS Consumer Look Up','y','http://www.nmlsconsumeraccess.org','y',";
                $s .= "'y','n','".$license_number_text."',''";
                $s .= ") ";
                $this->db->query ( $s );
            }
            else {
                $s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
                $s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                $s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
                $s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
                $s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
                $s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
                $s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
                $s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
                $s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
                $s .= ") values (null,";
                $s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
                $s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
                $s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
                $s .= "'','','','',";
                $s .= "'','','',''";
                $s .= ") ";
                $this->db->query ( $s );
            }
        }

        $s = "insert into contact_options (id,client_id,leadpop_id,";
        $s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
        $s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
        $s .= "companyname,phonenumber,email,companyname_active,";
        $s .= "phonenumber_active,email_active) values (null,";
        $s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
        $s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
        // $s .= "'" . addslashes ( $client ['company_name'] ) . "','" . $client ['phone_number'] . "','";
        $s .= "'" . addslashes ( $client ['company_name'] ) . "','Call Today! " . $client ['phone_number'] . "','";
        $s .= $client ['contact_email'] . "','n','y','n')";
        $this->db->query ( $s );

        $autotext = $this->getAutoResponderText ( $trialDefaults[0]["leadpop_vertical_id"], $trialDefaults[0]["leadpop_vertical_sub_id"] , $trialDefaults[0]["leadpop_id"]);
        if ($autotext == "not found") {
            $thehtml =  "";
            $thesubject = "";
        }
        else {
            $thehtml =  $autotext[0]["html"];
            $thesubject = $autotext[0]["subject_line"];
        }

        $s = "insert into autoresponder_options (id,client_id,leadpop_id,";
        $s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
        $s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
        $s .= "html,thetext,html_active,text_active,subject_line ) values (null,";
        $s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
        $s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
        $s .= "'" . addslashes ( $thehtml ) . "','','y','n','".addslashes($thesubject)."')";
        $this->db->query($s);

        if($client['is_fairway'] == 1 || $client['is_mm'] == 1){
            $title_tag =  $trialDefaults[0]["display_name"] . " | " . addslashes ( ucwords($client ['company_name']) );
        }
        else{
            $title_tag =  " FREE " . $trialDefaults[0]["display_name"] . " | " . addslashes ( ucwords($client ['company_name']) );
        }
        //FREE Home Purchase Qualifier | Sentinel Mortgage Company

        $s = "insert into seo_options (id,client_id,leadpop_id,";
        $s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
        $s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
        $s .= "titletag,description,metatags,titletag_active,";
        $s .= "description_active,metatags_active) values (null,";
        $s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
        $s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
        $s .= "'" . addslashes ( $title_tag ) . "','','','y','n','n') ";
        $this->db->query ( $s );

        $s = "select * from leadpops_verticals where id = " . $trialDefaults[0]["leadpop_vertical_id"];
        $vertres = $this->db->fetchRow ( $s );
        $verticalName = $vertres ['lead_pop_vertical'];
        $this->setVertical($verticalName);

        $submissionText = $this->getSubmissionText($trialDefaults[0]["leadpop_id"],$trialDefaults[0]["leadpop_vertical_id"],$trialDefaults[0]["leadpop_vertical_sub_id"]);
        $submissionText = str_replace("##clientlogo##",$logosrc,$submissionText);
        if($freeTrialBuilderAnswers['phonenumber']) {
            $submissionText = str_replace("##clientphonenumber##", $freeTrialBuilderAnswers['phonenumber'], $submissionText);
        }
        $s = "insert into submission_options (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,thankyou,information,";
        $s .= "thirdparty,thankyou_active,information_active,thirdparty_active) values (null,";
        $s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
        $s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
        $s .= "'" . addslashes ( $submissionText ) . "','','','y','n','n')";
        $this->db->query ( $s );

        if ($generatecolors != false && $useUploadedLogo != false) { // not uploaded logo or have previous funnel to use

            for($t = 0; $t < count($finalTrialColors); $t++) {
                $s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
                $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
                $s .= "swatch,is_primary,active) values (null,";
                $s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
                $s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
                $s .= $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
                $s .= $trialDefaults[0]["leadpop_id"] . ",";
                $s .= $trialDefaults[0]["leadpop_version_id"] . ",";
                $s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
                $s .= "'" . $finalTrialColors[$t]["swatch"] . "',";
                if ($t == 0 ) {
                    $s .= "'y',";
                }
                else {
                    $s .= "'n',";
                }
                $s .= "'y')";
                $this->db->query($s);
            }

            $s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
            $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
            $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
            $s .= "background_color,active,default_changed) values (null,";
            $s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
            $s .= $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
            $s .= $trialDefaults[0]["leadpop_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_version_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
            $s .= "'" . addslashes($background_css) . "','y','".$default_background_changed."')";
            $this->db->query($s);
        }
        else{
            //Jaz Notes: Quick Fix missing entry in leadpop_background_color - If we above criteria fails then put a default row
            $background_css = '/*###>*/background-color: rgba(171, 179, 182, 1);/*@@@*/\t\t\t\tbackground-image: linear-gradient(to right bottom,rgba(171, 179, 182, 1) 0%,rgba(171, 179, 182, 1) 100%); /* W3C */';
            $s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
            $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
            $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
            $s .= "background_color,active,default_changed) values (null,";
            $s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
            $s .= $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
            $s .= $trialDefaults[0]["leadpop_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_version_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
            $s .= "'" . addslashes($background_css) . "','y','".$default_background_changed."')";
            $this->db->query($s);
        }

        $this->addPlaceholder($trialDefaults[0],$logosrc,$imgsrc,$client);
        //print("addNonEnterpriseVerticalSubverticalVersionToExistingClient - added " . $client_id);
        echo "<span style='color:#fff; font-size:16px'>=> ".$googleDomain ." => Created </span><br />";
    }


    /* NOT IN USE */
    public function addFunnelFairway($funnel,$sub_level_domain, $top_level_domain) {
        $xpvertical_id = $funnel["vertical_id"];
        $subvertical_id = $funnel["subvertical_id"];
        $version_id = $funnel["version_id"];
        $client_id = $funnel["client_id"];
        $logo="";
        $mobilelogo="";
        $origvertical_id="";
        $origsubvertical_id="";
        $leadpoptype = 1;
        $origversion_id="";
        $origleadpop_type_id="";
        $origleadpop_template_id="";
        $origleadpop_id="";
        $origleadpop_version_id="";
        $origleadpop_version_seq="";
//        require_once '/var/www/vhosts/launch.leadpops.com/external/Image.php';
//        require_once '/var/www/vhosts/launch.leadpops.com/external/Client.php';
//
//        global $globallogosrc;
//        global $globalfavicon_dst;
//        global $globallogo_color;
//        global $globalcolored_dot;
//        global $globalmvp_dot;
//        global $globalmvp_check;

//        $tbigvertical_id = $pvertical_id;
        /*      fish       */
        $section = substr($client_id,0,1);

        if ($xpvertical_id == "1") {
            $vertical = "insurance";
        }
        else if ($xpvertical_id == "3") {
            $vertical = "mortgage";
        }
        else if ($xpvertical_id == "5") {
            $vertical = "realestate";
        }
        // TODO: SAL ⇒ Setting in later map through SQL
//        $this->setVertical($vertical);

//die($xpvertical_id);

        $s = "select * from clients where client_id = " . $client_id;
        $client = $this->db->fetchRow($s);
        $client['company_name'] = ucfirst(strtolower($client ['company_name']));
        $enteredEmail = $client["contact_email"]; // use this to look up in IFS

//       /var/www/vhosts/myleads.leadpops.com/images/clients/7/702/logos/702_22_1_3_8_11_11_1_et2bn1cudzrrji5smkay.png
//       /var/www/vhosts/itclixmobile.com/css/refinance11/themes/images/702grouplogo.png
        $generatecolors = false;
        if ($logo == "" && $mobilelogo == "") { // inother words use defaults for logo and mobile logo
            $useUploadedLogo = false;
            $default_background_changed = "n";
        }
        else if ($logo != "" && $mobilelogo != "" && $origleadpop_type_id != "" && $origleadpop_template_id != "" && $origleadpop_id != "" && $origleadpop_version_id !="" && $origleadpop_version_seq !="") {
            $default_background_changed = "y";
            $generatecolors = false;  // in other workds use existing logo and mobile logo and copy them to new funnel as if no upload was done
            $useUploadedLogo = true;
        }
        else if ($logo != "" && $mobilelogo == "" && $origleadpop_type_id == "" && $origleadpop_template_id == "" && $origleadpop_id == "" && $origleadpop_version_id =="" && $origleadpop_version_seq =="") {
            $default_background_changed = "y";
            $generatecolors = true;  // in other words act as if a new logo was uploaded & generate mobile logo
            $useUploadedLogo = true;
        }

        if ($generatecolors == false && $useUploadedLogo == false) { // not uploaded logo or have previous funnel to use

            $s = "select * from trial_launch_defaults_fairway where leadpop_vertical_id = " . $xpvertical_id . " and leadpop_vertical_sub_id = " . $subvertical_id . " and leadpop_version_id = " . $version_id . " limit 1 ";

            $trialDefaults = $this->db->fetchAll($s);

            $s = "select * from default_swatches where active = 'y' order by id ";
            $finalTrialColors = $this->db->fetchAll($s);
            $background_css = "linear-gradient(to bottom, rgba(108, 124, 156, 0.99) 0%, rgba(108, 124, 156, 0.99) 100%)";

            /**
             * TODO: SAL
             */
//            $cmd = '/bin/cp  /var/www/vhosts/launch.leadpops.com/trial/classiclogos/' . $trialDefaults[0]["logo_name_mobile"] . '  /var/www/vhosts/itclixmobile.com/css/'.str_replace(" ","",$trialDefaults[0]["subvertical_name"]).$trialDefaults[0]["leadpop_version_id"] . '/themes/images/' . $client_id . 'grouplogo.png';
//            exec($cmd);

            $s = "select * from leadpops_verticals where id = " . $trialDefaults[0]["leadpop_vertical_id"];
            $vertres = $this->db->fetchRow ( $s );
            $verticalName = $vertres ['lead_pop_vertical'];

            $s = "select * from leadpops_verticals_sub where leadpop_vertical_id  = " . $trialDefaults[0]["leadpop_vertical_id"];
            $s .= " and id = " . $trialDefaults[0]["leadpop_vertical_sub_id"];
            $subvertres = $this->db->fetchRow ( $s );
            $subverticalName = $subvertres ['lead_pop_vertical_sub'];

            /**
             * TODO: SAL
             */
            $logosrc = $this->getRackspaceUrl ('image_path','default-assets', 1).'/images/' . strtolower(str_replace(" ","",$verticalName)) . '/' . strtolower(str_replace(" ","",$subverticalName)). '_logos/' .$trialDefaults[0]["logo_name"];
            $this->insertDefaultClientUploadLogo($logosrc,$trialDefaults[0],$client_id);
            $imgsrc = $this->insertClientDefaultImage($trialDefaults[0],$client_id);
            $this->setClientDefaultFaviconColor($trialDefaults[0]);

        }
        else if ($generatecolors == false && $useUploadedLogo == true) { // get colors from leadpops_background_swatches

            $y = "select * from trial_launch_defaults_fairway where leadpop_vertical_id = ".$xpvertical_id." and leadpop_vertical_sub_id = " . $subvertical_id . " and leadpop_version_id = " . $version_id . " limit 1 ";
            $trialDefaults = $this->db->fetchAll($y);

            $s = "select * from ".getPartition($client_id, "leadpop_background_swatches");
            $s .= " where  client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $origleadpop_version_id;
            $s .= " and leadpop_version_seq = " . $origleadpop_version_seq;
            $finalTrialColors = $this->db->fetchAll($s);

            for($t = 0; $t < count($finalTrialColors); $t++) {
                $s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
                $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
                $s .= "swatch,is_primary,active) values (null,";
                $s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
                $s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
                $s .= $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
                $s .= $trialDefaults[0]["leadpop_id"] . ",";
                $s .= $trialDefaults[0]["leadpop_version_id"] . ",";
                $s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
                $s .= "'" . $finalTrialColors[$t]["swatch"] . "','".$finalTrialColors[$t]["is_primary"]."',";
                $s .= "'y')";
                $this->db->query($s);
            }

            $s = "select background_color from leadpop_background_color ";
            $s .= " where  client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $origleadpop_version_id;
            $s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
            $background_css = $this->db->fetchOne($s);

            $s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
            $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
            $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
            $s .= "background_color,active,default_changed) values (null,";
            $s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
            $s .= $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
            $s .= $trialDefaults[0]["leadpop_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_version_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
            $s .= "'" . addslashes($background_css) . "','y','".$default_background_changed."')";
            $this->db->query($s);

            $s = "select logo_color  from leadpop_logos ";
            $s .= " where  client_id = " . $client_id;
            $s .= " and leadpop_vertical_id = " . $origvertical_id;
            $s .= " and leadpop_vertical_sub_id  = " . $origsubvertical_id;
            $s .= " and leadpop_type_id  = " . $origleadpop_type_id;
            $s .= " and leadpop_template_id = " . $origleadpop_template_id;
            $s .= " and  leadpop_id = " . $origleadpop_id;
            $s .= " and leadpop_version_id = " . $origleadpop_version_id;
            $s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
            $colors = $this->db->fetchAll($s);


            // copy logo to new logo name
            $logopath = '/var/www/vhosts/myleads.leadpops.com/images/clients/'.$section.'/'.$client_id.'/logos/';
            $origlogo = $logopath . $logo;
            $newlogoname = strtolower($client_id."_".$trialDefaults[0]["leadpop_id"]."_".$trialDefaults[0]["leadpop_type_id"]."_".$trialDefaults[0]["leadpop_vertical_id"]."_".$trialDefaults[0]["leadpop_vertical_sub_id"]."_".$trialDefaults[0]["leadpop_template_id"]."_".$trialDefaults[0]["leadpop_version_id"]."_".$trialDefaults[0]["leadpop_version_seq"]."_".$logo);
            $newlogo = $logopath . $newlogoname;
            $cmd = '/bin/cp  ' .$origlogo . '   ' . $newlogo;
            exec($cmd);

            // copy mobile logo to new name
            $s = "select include_path from mobile_paths where leadpop_id = " . $origleadpop_id . " limit 1 ";
            $origDestinationDirectory = $this->db->fetchOne($s);
            $origCopyDestinationDirectoryFile   = "/var/www/vhosts/itclixmobile.com" .$origDestinationDirectory . $mobilelogo;

            $s = "select include_path from mobile_paths where leadpop_id = " . $trialDefaults[0]["leadpop_id"] . " limit 1 ";
            $DestinationDirectory = $this->db->fetchOne($s);
            $newmobilelogo = $client_id . "grouplogo.png";
            $CopyDestinationDirectoryFile = "/var/www/vhosts/itclixmobile.com" . $DestinationDirectory . $newmobilelogo;
            $cmd = '/bin/cp  ' . $origCopyDestinationDirectoryFile . '   ' . $CopyDestinationDirectoryFile;
            exec($cmd);

            $oldfilename = strtolower($client_id."_".$origleadpop_id."_".$origleadpop_type_id."_".$origvertical_id."_".$origsubvertical_id."_".$origleadpop_template_id."_".$origleadpop_version_id."_".$origleadpop_version_seq);
            $newfilename = $client_id."_".$trialDefaults[0]["leadpop_id"]."_1_".$trialDefaults[0]["leadpop_vertical_id"]."_".$trialDefaults[0]["leadpop_vertical_sub_id"]."_".$trialDefaults[0]['leadpop_template_id']."_".$trialDefaults[0]["leadpop_version_id"]."_".$trialDefaults[0]["leadpop_version_seq"];

            $origfavicon_dst_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$oldfilename.'_favicon-circle.png';
            $newfavicon_dst_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newfilename.'_favicon-circle.png';

            $cmd = '/bin/cp  ' . $origfavicon_dst_src . '   ' . $newfavicon_dst_src;
            exec($cmd);

            $origcolored_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$oldfilename.'_dot_img.png';
            $newcolored_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newfilename.'_dot_img.png';

            $cmd = '/bin/cp  ' . $origcolored_dot_src . '   ' . $newcolored_dot_src;
            exec($cmd);

            $origmvp_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$oldfilename.'_ring.png';
            $newmvp_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newfilename.'_ring.png';

            $cmd = '/bin/cp  ' . $origmvp_dot_src . '   ' . $newmvp_dot_src;
            exec($cmd);

            $newmvp_check_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newfilename.'_mvp-check.png';
            $origmvp_check_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$oldfilename.'_mvp-check.png';

            $cmd = '/bin/cp  ' . $origmvp_check_src . '   ' . $newmvp_check_src;
            exec($cmd);

            $logosrc = newinsertClientUploadLogo($newlogoname,$trialDefaults[0],$client_id);
            $imgsrc = insertClientNotDefaultImage($trialDefaults[0],$client_id,$origleadpop_id,$origleadpop_type_id,$origvertical_id,$origsubvertical_id,$origleadpop_template_id,$origleadpop_version_id,$origleadpop_version_seq);

            $globallogosrc = $logosrc;
            $globalfavicon_dst = $newfavicon_dst_src;
            $globallogo_color = $colors[0]["logo_color"];
            $globalcolored_dot = $newcolored_dot_src;
            $globalmvp_dot = $newmvp_dot_src;
            $globalmvp_check = $newmvp_check_src;

            // set mobile logo varibale

        }
        else if ($generatecolors == true && $useUploadedLogo == true) { //

            $s = "select * from trial_launch_defaults_fairway where leadpop_vertical_id = " . $xpvertical_id . " and leadpop_vertical_sub_id = " . $subvertical_id . " and leadpop_version_id = " . $version_id . " limit 1 ";
            $trialDefaults = $this->db->fetchAll($s);
//	      id leadpop_vertical_id	leadpop_vertical_sub_id	leadpop_type_id	leadpop_template_id	leadpop_id	leadpop_version_id	leadpop_version_seq
//       /var/www/vhosts/myleads.leadpops.com/images/clients/7/702/logos/ 702_22_1_3_8_11_11_1_et2bn1cudzrrji5smkay.png
//       /var/www/vhosts/itclixmobile.com/css/refinance11/themes/images/    702grouplogo.png
// pass in logo name only
            $logopath = '/var/www/vhosts/myleads.leadpops.com/images/clients/'.$section.'/'.$client_id.'/logos/';
            $origlogo = $logopath . $logo;
            $newlogoname = strtolower($client_id."_".$trialDefaults[0]["leadpop_id"]."_".$trialDefaults[0]["leadpop_type_id"]."_".$trialDefaults[0]["leadpop_vertical_id"]."_".$trialDefaults[0]["leadpop_vertical_sub_id"]."_".$trialDefaults[0]["leadpop_template_id"]."_".$trialDefaults[0]["leadpop_version_id"]."_".$trialDefaults[0]["leadpop_version_seq"]."_".$logo);

            $newlogo = $logopath . $newlogoname;

            $cmd = '/bin/cp  ' .$origlogo . '   ' . $newlogo;
            exec($cmd);

            $oclient = new Client();

            $gis       = getimagesize($newlogo);
            $ow = $gis[0];
            $oh = $gis[1];
            $type = $gis[2];
            //die($type.' type');
            switch($type)
            {
                case "1":
                    $im = imagecreatefromgif($newlogo);
                    $image = $oclient->loadGif($newlogo);
                    $logo_color = $image->extract();
                    break;
                case "2":
                    $im = imagecreatefromjpeg($newlogo);
                    $image = $oclient->loadJpeg($newlogo);
                    $logo_color = $image->extract();
                    break;
                case "3":
                    $im = imagecreatefrompng($newlogo);
                    $image = $oclient->loadPng($newlogo);
                    $logo_color = $image->extract();
                    break;
                default:  $im = imagecreatefromjpeg($newlogo);
            }

            if(is_array($logo_color)){
                $logo_color = $logo_color[0];
            }

            $imagetype = image_type_to_mime_type($type);
            if($imagetype != 'image/jpeg' && $imagetype != 'image/png' &&  $imagetype != 'image/gif' ) {
                return 'bad' ;
            }

            $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
            $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
            $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
            $s .= "logo_src,use_me,numpics,logo_color,ini_logo_color) values (null,";
            $s .= $client_id.",".$trialDefaults[0]["leadpop_id"].",".$trialDefaults[0]["leadpop_type_id"].",".$trialDefaults[0]["leadpop_vertical_id"].",".$trialDefaults[0]["leadpop_vertical_sub_id"].",";
            $s .= $trialDefaults[0]["leadpop_template_id"].",".$trialDefaults[0]["leadpop_version_id"].",".$trialDefaults[0]["leadpop_version_seq"].",";
            $s .= "'n','".$newlogoname."','y',1, '".$logo_color."','".$logo_color."') ";
            $this->db->query($s);

            $logosrc = getHttpAdminServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'. $newlogoname;

            $image_location = "/var/www/vhosts/itclix.com/images/dot-img.png";
            $favicon_location = "/var/www/vhosts/itclix.com/images/favicon-circle.png";
            $mvp_dot_location = "/var/www/vhosts/itclix.com/images/ring.png";
            $mvp_check_location = "/var/www/vhosts/itclix.com/images/mvp-check.png";

            $favicon_dst_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. $section . '/' . $client_id.'/logos/'.$newlogoname.'_favicon-circle.png';
            $colored_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. $section . '/' . $client_id.'/logos/'.$newlogoname.'_dot_img.png';
            $mvp_dot_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. $section . '/' . $client_id.'/logos/'.$newlogoname.'_ring.png';
            $mvp_check_src = '/var/www/vhosts/myleads.leadpops.com/images/clients/'. $section . '/' . $client_id.'/logos/'.$newlogoname.'_mvp-check.png';

            if (isset($logo_color) && $logo_color != "" ) {
                $new_clr = hex2rgb($logo_color);
            }

            $im = imagecreatefrompng($image_location);
            $myRed =  $new_clr[0];
            $myGreen =  $new_clr[1];
            $myBlue =  $new_clr[2];

            colorizeBasedOnAplhaChannnel( $image_location, $myRed, $myGreen, $myBlue, $colored_dot_src);
            colorizeBasedOnAplhaChannnel( $favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src);
            colorizeBasedOnAplhaChannnel( $mvp_dot_location, $myRed, $myGreen, $myBlue, $mvp_dot_src);
            colorizeBasedOnAplhaChannnel( $mvp_check_location, $myRed, $myGreen, $myBlue, $mvp_check_src);

            $colored_dot = getHttpAdminServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newlogoname.'_dot_img.png';
            $favicon_dst = getHttpAdminServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newlogoname.'_favicon-circle.png';
            $mvp_dot = getHttpServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newlogoname.'_ring.png';
            $mvp_check = getHttpServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$newlogoname.'_mvp-check.png';

            $swatches =   "213-230-229#23-177-163#159-182-183#65-88-96#110-158-159#132-212-204" ;

            $result = explode("#",$swatches);
            $new_color = hex2rgb($logo_color);
            $index = 0;
            array_unshift($result, implode('-', $new_color));

            // SET BACKGROUND COLOR
            $background_from_logo = '/*###>*/background-color: rgba('.$new_color[0].', '.$new_color[1].', '.$new_color[2].', 1);/*@@@*/
			background-image: linear-gradient(to right bottom,rgba('.$new_color[0].', '.$new_color[1].', '.$new_color[2].', 1) 0%,rgba('.$new_color[0].', '.$new_color[1].', '.$new_color[2].', 1) 100%); /* W3C */';

            $s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
            $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
            $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
            $s .= "background_color,active,default_changed) values (null,";
            $s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_template_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_version_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
            $s .= "'" . addslashes($background_from_logo) . "','y','y')";
            $this->db->query($s);

            foreach($result as $key => $value) {

                list($red,$green,$blue) = explode("-",$value);

                if($key<1){
                    $str0 = "linear-gradient(to bottom, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",1.0) 100%)";
                }else{
                    $str0 = "linear-gradient(to bottom, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",.7) 100%)";
                }

                $str1 = "linear-gradient(to top, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",.7) 100%)";
                $str2 = "linear-gradient(to bottom right, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",.7) 100%)";
                $str3 = "linear-gradient(to bottom, rgba(".$red.",".$green.",".$blue.",1.0) 0%,rgba(".$red.",".$green.",".$blue.",1.0) 100%)";

                $swatches = array($str0,$str1,$str2,$str3);
                for($i=0;  $i<4; $i++) {
                    $index++;
                    $is_primary = 'n';
                    if($index==1){
                        $is_primary = 'y';
                    }

                    $s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
                    $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                    $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
                    $s .= "swatch,is_primary,active) values (null,";
                    $s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
                    $s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
                    $s .= $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_template_id"] . ",";
                    $s .= $trialDefaults[0]["leadpop_id"] . ",";
                    $s .= $trialDefaults[0]["leadpop_version_id"] . ",";
                    $s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
                    $s .= "'" . addslashes($swatches[$i]) . "',";
                    $s .= "'".$is_primary."','y')";
                    $this->db->query($s);

                }
            }

            $s = "select background_color from leadpop_background_color ";
            $s .= " where  client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $trialDefaults[0]["leadpop_version_id"];
            $s .= " and leadpop_version_seq = " . $trialDefaults[0]["leadpop_version_seq"] . " limit 1 ";
            $background_css = $this->db->fetchOne($s);

            $s = "select * from ".getPartition($client_id, "leadpop_background_swatches");
            $s .= " where  client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $trialDefaults[0]["leadpop_version_id"];
            $s .= " and leadpop_version_seq = " . $trialDefaults[0]["leadpop_version_seq"] . " limit 1 ";
            $finalTrialColors = $this->db->fetchAll($s);

            $logo = $newlogoname; // set $logo to be used down stream
            /* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
            /* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
            /* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
            $s = "select include_path from mobile_paths where leadpop_id = " . $trialDefaults[0]["leadpop_id"] . " limit 1 ";
            $DestinationDirectory = $this->db->fetchOne($s);
            $CopyDestinationDirectoryFile = "/var/www/vhosts/itclixmobile.com" . $DestinationDirectory;
            $DestinationDirectory = "/var/www/vhosts/myleads.leadpops.com/data/mobileimages/";
            $Quality = 90;
            // set mobile logo varibale
            $mobilelogo = $client_id . "grouplogo.png";

            $resize = true;
            if ($ow <= 320  &&  $oh <= 70) { // best fit for logo image is no larger than this
                $resize = false;
            }

            $DestImageName = $DestinationDirectory . $mobilelogo; // Image with destination directory
            $CopyDestinationDirectoryFile = $CopyDestinationDirectoryFile . $mobilelogo;

            resizeImage($ow,$oh,$DestImageName,$im,$Quality,$type,$resize,$newlogo);
            $cmd = '/bin/cp  ' . $DestImageName . '  ' . $CopyDestinationDirectoryFile;
            exec($cmd);

            /* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
            /* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */
            /* now generate the mobile logo mobile logo mobile logo mobile logo mobile logo mobile logo */

            $logosrc = newinsertClientUploadLogo($newlogoname,$trialDefaults[0],$client_id);
            $imgsrc = insertClientDefaultImage($trialDefaults[0],$client_id);

            $globallogosrc = $logosrc;
            $globalfavicon_dst = $favicon_dst;
            $globalmvp_dot = $mvp_dot;
            $globalmvp_check = $mvp_check;
            $globallogo_color = $logo_color;
            $globalcolored_dot = $colored_dot;

        }

        $dt = date("Y-m-d H:i:s");

        // craete this array so as not to have to chg code
        $freeTrialBuilderAnswers = array("emailaddress" => $client["contact_email"],"phonenumber" => $client["phone_number"]);

        $this->insertDefaultAutoResponders ($client_id, $trialDefaults[0], $client["contact_email"], $client["phone_number"]) ;

        if(!@$trialDefaults[0]["funnel_questions"] || $trialDefaults[0]["funnel_questions"] == null){
            $trialDefaults[0]["funnel_questions"] = "{}";
        }
        if(!@$trialDefaults[0]["conditional_logic"] || $trialDefaults[0]["conditional_logic"] == null){
            $trialDefaults[0]["conditional_logic"] = "{}";
        }
        if(!@$trialDefaults[0]["funnel_hidden_field"] || $trialDefaults[0]["funnel_hidden_field"] == null){
            $trialDefaults[0]["funnel_hidden_field"] = "{}";
        }

        $s = "select id,lead_pop_vertical from leadpops_verticals where id = " . $xpvertical_id;
        $_vertical = $this->db->fetchRow($s);
        /*
         * Add default vertical name in leadpops_folders table
         * */
        $folder_id  = $this->assign_folder_to_funnel($_vertical["lead_pop_vertical"].' Funnels',$client_id);

        $s = "insert into clients_leadpops (client_id,question_sequence,funnel_questions,funnel_hidden_field,funnel_variables,conditional_logic,lead_line,second_line_more,funnel_name,leadpop_id,
         leadpop_version_id,leadpop_active,access_code,leadpop_version_seq,static_thankyou_active,static_thankyou_slug,date_added,leadpop_folder_id) values (";
        $s .=  $client_id .",'" . $trialDefaults[0]["funnel_variables"] . "','" . addslashes($trialDefaults[0]["funnel_questions"]) . "','" . addslashes($trialDefaults[0]["funnel_hidden_field"]) . "',
			'" . $trialDefaults[0]["conditional_logic"] . "'," . $trialDefaults[0]["conditional_logic"] . "','" . addslashes($trialDefaults[0]["lead_line"]) . "','" . addslashes($trialDefaults[0]["second_line_more"]) . "','" . $trialDefaults[0]["funnel_name"] . "'," . $trialDefaults[0]["leadpop_id"] . ",
			" . $trialDefaults[0]["leadpop_version_id"] . ",'1',''," . $trialDefaults[0]["leadpop_version_seq"] . ",'y','thank-you.html',
			'".$dt."',".$folder_id.")";
        $this->db->query ( $s );


        $client_leadpop_id  = $this->db->lastInsertId();
        /*
         *Add default tag in leadpops_tags table
         *
         * */
        $this->assign_tag_to_funnel($client_leadpop_id,$trialDefaults[0],$client_id);

        // TODO: SAL ⇒ USELESS TABLE
        /*$s = "insert into clients_leadpops_content (client_id,leadpop_id,leadpop_version_id,leadpop_active,access_code,
              leadpop_version_seq,";
        $s .= "section1,section2,section3,section4,section5,section6,section7,section8,section9,section10,template) values (";
        $s .=  $this->client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_version_id"] . ",'1',''," . $trialDefaults[0]["leadpop_version_seq"] . ",";
        $s .= "'<h4>section one</h4>','<h4>section two</h4>','<h4>section three</h4>','<h4>section four</h4>',";
        $s .= "'<h4>section five</h4>','<h4>section six</h4>','<h4>section seven</h4>','<h4>section eight</h4>','<h4>section nine</h4>',";
        $s .= "'<h4>section ten</h4>',1)";
        $this->dbquery($s);*/

        // TODO: SAL ⇒ USELESS TABLE
        /*$s = "select * from leadpops_template_info where leadpop_vertical_id = " . $trialDefaults[0]["leadpop_vertical_id"];
        $s .= " and leadpop_vertical_sub_id = " . $trialDefaults[0]["leadpop_vertical_sub_id"] . " and leadpop_version_id = " . $trialDefaults[0]["leadpop_version_id"];
        $template_info = $this->db->fetchRow($s);*/

        // TODO: SAL ⇒ USELESS TABLE
//        checkIfNeedMultipleStepInsert ( $trialDefaults[0]["leadpop_version_id"], $client_id );

        $s = "insert into clients_funnels_domains (id,client_id,subdomain_name,funnel_name,top_level_domain,leadpop_vertical_id,";
        $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
        $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq ) values (null,";
        $s .= $client_id. ",'" . $sub_level_domain . "','" . $trialDefaults[0]["funnel_name"] . "','" . $top_level_domain . "',";
        $s .= $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . "," . $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
        $s .= $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ")";
        $this->db->query($s);


        // insert into force ssl
        $s = "insert into force_ssl (id,url) values (null,'".$sub_level_domain.".".$top_level_domain."')";
        $this->db->query($s);

        $googleDomain = $sub_level_domain . "." . $top_level_domain;
        $this->insertPurchasedGoogle ($client_id, $googleDomain );


        if ($generatecolors == false && $useUploadedLogo == true) { // get mobile from old funnel
            // set 	client_or_domain_logo_image to 'c'  to use upploaded logo
            /* mobile domain and logo */
            $s = "select * from bottom_links  where client_id = " . $client_id ;
            $s .= " and leadpop_version_id = " . $origleadpop_version_id;
            $s .= " and leadpop_version_seq = " . $origleadpop_version_seq . " limit 1 ";
            $oldbototm = $this->db->fetchAll($s);

            $s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
            $s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
            $s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
            $s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
            $s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
            $s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
            $s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
            $s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
            $s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
            $s .= ") values (null,";
            $s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
            $s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
            $s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
            $s .= "'".$oldbototm[0]["compliance_text"]."','".$oldbototm[0]["compliance_is_linked"]."','".$oldbototm[0]["compliance_link"]."','".$oldbototm[0]["compliance_active"]."',";
            $s .= "'".$oldbototm[0]["license_number_active"]."','".$oldbototm[0]["license_number_is_linked"]."','".$oldbototm[0]["license_number_text"]."','".$oldbototm[0]["license_number_link"]."'";
            $s .= ") ";
            $this->db->query($s);
        }
        else {
            if ((@$vertical == "mortgage" || @$vertical == "realestate")) {
                $license_number_text = "";
                $s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
                $s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                $s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
                $s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
                $s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
                $s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
                $s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
                $s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
                $s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
                $s .= ") values (null,";
                $s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
                $s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
                $s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
                $s .= "'NMLS Consumer Look Up','y','http://www.nmlsconsumeraccess.org','y',";
                $s .= "'y','n','".$license_number_text."',''";
                $s .= ") ";

                $this->db->query ( $s );
            }
            else if (@$vertical == "insurance") {
                $license_number_text = "";
                $s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
                $s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                $s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
                $s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
                $s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
                $s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
                $s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
                $s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
                $s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
                $s .= ") values (null,";
                $s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
                $s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
                $s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
                $s .= "'NMLS Consumer Look Up','y','http://www.nmlsconsumeraccess.org','y',";
                $s .= "'y','n','".$license_number_text."',''";
                $s .= ") ";
                $this->db->query ( $s );
            }
            else {
                $s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
                $s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                $s .= "leadpop_version_seq,privacy,terms,disclosures,licensing,about,contact,";
                $s .= "privacy_active,terms_active,disclosures_active,licensing_active,about_active,contact_active,";
                $s .= "privacy_type,terms_type,disclosures_type,licensing_type,about_type,contact_type,privacy_url,";
                $s .= "terms_url,disclosures_url,licensing_url,about_url,contact_url,privacy_text,";
                $s .= "terms_text,disclosures_text,licensing_text,about_text,contact_text,";
                $s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
                $s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
                $s .= ") values (null,";
                $s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
                $s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"];
                $s .= ",'','','','','','','n','n','n','n','n','n','m','m','m','m','m','m','','','','','','','','','','','','',";
                $s .= "'','','','',";
                $s .= "'','','',''";
                $s .= ") ";
                $this->db->query ( $s );
            }
        }


        $s = "insert into contact_options (id,client_id,leadpop_id,";
        $s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
        $s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
        $s .= "companyname,phonenumber,email,companyname_active,";
        $s .= "phonenumber_active,email_active) values (null,";
        $s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
        $s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
        // $s .= "'" . addslashes ( $client ['company_name'] ) . "','" . $client ['phone_number'] . "','";
        $s .= "'" . addslashes ( $client ['company_name'] ) . "','Call Today! " . $client ['phone_number'] . "','";
        $s .= $client ['contact_email'] . "','n','y','n')";
        $this->db->query ( $s );

        $autotext = $this->getAutoResponderText ( $trialDefaults[0]["leadpop_vertical_id"], $trialDefaults[0]["leadpop_vertical_sub_id"] , $trialDefaults[0]["leadpop_id"]);
        if ($autotext == "not found") {
            $thehtml =  "";
            $thesubject = "";
        }
        else {
            $thehtml =  $autotext[0]["html"];
            $thesubject = $autotext[0]["subject_line"];
        }

        $s = "insert into autoresponder_options (id,client_id,leadpop_id,";
        $s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
        $s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
        $s .= "html,thetext,html_active,text_active,subject_line ) values (null,";
        $s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
        $s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
        $s .= "'" . addslashes ( $thehtml ) . "','','y','n','".addslashes($thesubject)."')";
        $this->db->query($s);


        $title_tag =  " FREE " . $trialDefaults[0]["display_name"] . " | " . addslashes ( ucwords($client ['company_name']) );
        //FREE Home Purchase Qualifier | Sentinel Mortgage Company

        $s = "insert into seo_options (id,client_id,leadpop_id,";
        $s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
        $s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
        $s .= "titletag,description,metatags,titletag_active,";
        $s .= "description_active,metatags_active) values (null,";
        $s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
        $s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
        $s .= "'" . addslashes ( $title_tag ) . "','','','y','n','n') ";
        $this->db->query ( $s );

        $s = "select * from leadpops_verticals where id = " . $trialDefaults[0]["leadpop_vertical_id"];
        $vertres = $this->db->fetchRow ( $s );
        $verticalName = $vertres ['lead_pop_vertical'];
        $this->setVertical($verticalName);

        // TODO: SAL ⇒ USELESS TABLE
        /*if (isset ($trialDefaults[0]["leadpop_vertical_sub_id"] ) && $trialDefaults[0]["leadpop_vertical_sub_id"] != "") {
            $s = "select * from leadpops_verticals_sub where leadpop_vertical_id  = " . $trialDefaults[0]["leadpop_vertical_id"];
            $s .= " and id = " . $trialDefaults[0]["leadpop_vertical_sub_id"];
            $subvertres = $this->db->fetchRow ( $s );
            $subverticalName = $subvertres ['lead_pop_vertical_sub'];
        } else {
            $subverticalName = "";
        }*/

        $submissionText = $this->getSubmissionText($trialDefaults[0]["leadpop_id"],$trialDefaults[0]["leadpop_vertical_id"],$trialDefaults[0]["leadpop_vertical_sub_id"],ProcessRepository::TYPE_FAIRWAY);
        $submissionText = str_replace("##clientlogo##",$logosrc,$submissionText);
        $submissionText = str_replace("##clientphonenumber##",$freeTrialBuilderAnswers['phonenumber'],$submissionText);

        $s = "insert into submission_options (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,thankyou,information,";
        $s .= "thirdparty,thankyou_active,information_active,thirdparty_active) values (null,";
        $s .= $client_id . "," . $trialDefaults[0]["leadpop_id"] . "," . $trialDefaults[0]["leadpop_type_id"] . "," . $trialDefaults[0]["leadpop_vertical_id"] . "," . $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
        $s .= $trialDefaults[0]['leadpop_template_id'] . "," . $trialDefaults[0]["leadpop_version_id"] . "," . $trialDefaults[0]["leadpop_version_seq"] . ",";
        $s .= "'" . addslashes ( $submissionText ) . "','','','y','n','n')";
        $this->db->query ( $s );

        if ($generatecolors != false && $useUploadedLogo != false) { // not uploaded logo or have previous funnel to use

            for($t = 0; $t < count($finalTrialColors); $t++) {
                $s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
                $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
                $s .= "swatch,is_primary,active) values (null,";
                $s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
                $s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
                $s .= $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
                $s .= $trialDefaults[0]["leadpop_id"] . ",";
                $s .= $trialDefaults[0]["leadpop_version_id"] . ",";
                $s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
                $s .= "'" . $finalTrialColors[$t]["swatch"] . "',";
                if ($t == 0 ) {
                    $s .= "'y',";
                }
                else {
                    $s .= "'n',";
                }
                $s .= "'y')";
                $this->db->query($s);
            }

            $s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
            $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
            $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
            $s .= "background_color,active,default_changed) values (null,";
            $s .= $client_id . "," . $trialDefaults[0]["leadpop_vertical_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_vertical_sub_id"] . ",";
            $s .= $leadpoptype . "," . $trialDefaults[0]['leadpop_template_id'] . ",";
            $s .= $trialDefaults[0]["leadpop_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_version_id"] . ",";
            $s .= $trialDefaults[0]["leadpop_version_seq"] . ",";
            $s .= "'" . addslashes($background_css) . "','y','".$default_background_changed."')";
            $this->db->query($s);
        }
        $this->addPlaceholder($trialDefaults[0],$logosrc,$imgsrc,$client);
        print("addNonEnterpriseVerticalSubverticalVersionToExistingClient - added " . $client_id);
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
        $http = $this->db->fetchOne ( $s );
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
        $this->db->query ( $s );
        $lastId = $this->db->lastInsertId ();

        $s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
        $s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $client_id . "," . $lastId . ",";
        $s .= $trialDefaults["leadpop_id"] . "," . $trialDefaults["leadpop_type_id"] . "," . $trialDefaults["leadpop_vertical_id"] . "," . $trialDefaults["leadpop_vertical_sub_id"] . "," . $trialDefaults["leadpop_template_id"] . "," . $trialDefaults["leadpop_version_id"];
        $s .= "," . $trialDefaults["leadpop_version_seq"] . ",'" . $phone . "','none','y')";
        $this->db->query ( $s );

    }


    function insertDefaultAutoResponders ($client_id, $trialDefaults, $emailaddress, $phonenumber) {
        global $xzdb;

        // insert primary client
        $s = "insert into lp_auto_recipients (client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
        $s .= "leadpop_version_seq,email_address,is_primary) values (" . $client_id . ",";
        $s .= $trialDefaults["leadpop_id"] . "," . $trialDefaults["leadpop_type_id"] . "," . $trialDefaults["leadpop_vertical_id"] . "," . $trialDefaults["leadpop_vertical_sub_id"] . "," . $trialDefaults["leadpop_template_id"] . "," . $trialDefaults["leadpop_version_id"];
        $s .= "," . $trialDefaults["leadpop_version_seq"] . ",'" . $emailaddress . "','y')";
        $this->db->query ( $s );
        $lastId = $this->db->lastInsertId ();

        $s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
        $s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $client_id . "," . $lastId . ",";
        $s .= $trialDefaults["leadpop_id"] . "," . $trialDefaults["leadpop_type_id"] . "," . $trialDefaults["leadpop_vertical_id"] . "," . $trialDefaults["leadpop_vertical_sub_id"] . "," . $trialDefaults["leadpop_template_id"] . "," . $trialDefaults["leadpop_version_id"];
        $s .= "," . $trialDefaults["leadpop_version_seq"] . ",'" . $phonenumber . "','none','y')";
        $this->db->query ( $s );

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
        $this->db->query($s);

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

        $res = $this->db->fetchAll($s);
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
            $this->db->query($s);

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
            $this->db->query($s);

        }

        $img = getHttpServer () . '/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/pics/' .$imagename ;
        return $img;
    }


    function insertClientDefaultImage($trialDefaults, $client_id) {
        $use_default = 'n';
        $use_me = 'y' ;

        $imagename = $trialDefaults['image_name'];

        $s = "insert into leadpop_images (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
        $s .= "image_src,use_me,numpics) values (null,";
        $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
        $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
        $s .= "'".$use_default."','".$imagename."','".$use_me."',1) ";
        $this->db->query($s);

        $img = $this->getRackspaceUrl ('image_path') . config('rackspace.rs_featured_image_dir') .$imagename ;
        return $img;
    }


    function insertDefaultClientUploadLogo($logosrc,$trialDefaults,$client_id) {
        $numpics = 0;
        $usedefault = 'y';


        $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
        $s .= "logo_src,use_me,numpics) values (null,";
        $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
        $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
        $s .= "'".$usedefault."','".$logosrc."','n',".$numpics.") ";
        $this->db->query($s);

        $s = "insert into current_logo (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,logo_src) values (null,";
        $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
        $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
        $s .= "'" . $logosrc . "' ) ";
        $this->db->query($s);

        $this->setGloballogosrc($logosrc);
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
        $this->db->query($s);

        $s = "insert into current_logo (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,logo_src) values (null,";
        $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
        $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
        $s .= "'" . $logoname . "' ) ";
        $this->db->query($s);

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
        $this->db->query($s);

        $s = "insert into current_logo (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,logo_src) values (null,";
        $s .= $client_id.",".$trialDefaults["leadpop_id"].",1,".$trialDefaults["leadpop_vertical_id"].",".$trialDefaults["leadpop_vertical_sub_id"].",";
        $s .= $trialDefaults['leadpop_template_id'].",".$trialDefaults["leadpop_version_id"].",".$trialDefaults["leadpop_version_seq"].",";
        $s .= "'" . $logoname . "' ) ";
        $this->db->query($s);

        $logosrc = getHttpServer () . '/images/clients/' . substr($client_id,0,1) . '/' . $client_id . '/logos/' .$logoname ;
        return $logosrc;
    }

    function getAutoResponderText ( $vertical_id, $subvertical_id, $leadpop_id ) {
        $s = "select html,subject_line from autoresponder_defaults where  ";
        $s .= " leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_vertical_id = " .  $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id . " limit 1 ";
        $res = $this->db->fetchAll($s);
        if ($res) {
            return $res;
        }
        else {
            return "not found";
        }
    }

    function getSubmissionText($leadpop_id,$vertical_id,$subvertical_id,$niners="888888",$type = ProcessRepository::TYPE_DEFAULT) {
        switch ($type){
            case ProcessRepository::TYPE_FAIRWAY:
                $thankyou_defaults = "thankyou_defaults_fairway";
                break;
            default:
                $thankyou_defaults = "thankyou_defaults";
                break;
        }

        if ($niners == "999999") {
            $s = "select html from $thankyou_defaults where  ";
            $s .= " leadpop_id = 999999 limit 1";
            $res = $this->db->fetchAll($s);
        }
        else {
            $s = "select html from $thankyou_defaults where  ";
            $s .= " leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_vertical_id = " .  $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id . " limit 1 ";
            $res = $this->db->fetchAll($s);
        }
        return $res[0]["html"];
    }

    function insertPurchasedGoogle($client_id, $googleDomain) {
        // package id does not now affect google analytics so put 2 for all
        $dt = date ( 'Y-m-d H:i:s' );
        $s = "insert into purchased_google_analytics (client_id,purchased,google_key,";
        $s .= "thedate,domain,active,package_id) values (" . $client_id . ",'y','','" . $dt . "','" . $googleDomain . "',";
        $s .= "'n',2)";
        $this->db->query ( $s );
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
        $res = $this->db->fetchAll ( $s );
        if ($res) {
            $s = "insert into leadpop_multiple_step (id,";
            $s .= "client_id,leadpop_description_id,leadpop_id,";
            $s .= "leadpop_template_id,stepone,steptwo,stepthree,";
            $s .= "stepfour,stepfive) values (null,";
            $s .= $client_id . "," . $res [0] ['leadpop_description_id'] . ",";
            $s .= $res [0] ['leadpop_id'] . "," . $res [0] ['leadpop_template_id'] . ",'";
            $s .= $res [0] ['stepone'] . "','" . $res [0] ['steptwo'] . "','" . $res [0] ['stepthree'];
            $s .= "','" . $res [0] ['stepfour'] . "','" . $res [0] ['stepfive'] . "')";
            $this->db->query ( $s );
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
        $http = $this->db->fetchOne($s);
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

    function getRackspaceUrl($key, $cdn_type="default-assets"){
        if($cdn_type=="default-assets"){
            $s =  "select $key from current_container_image_path where cdn_type = '".$cdn_type."' limit 1 ";
        }else{
            $s =  "select $key from current_container_image_path where cdn_type = '".$cdn_type."' and signup_active = 1 limit 1 ";
        }
        $url = $this->db->fetchRow($s);
        return $url[$key];
    }

    function addPlaceholder($trialDefaults,$logosrc,$imgsrc,$client){
        $keepJson = array("front_image", "logo_src", "my_company_name", "my_company_phone", "my_company_email", "font_family", "font_family_desc", "logo_color", "colored_dot", "favicon_dst", "companyname_label", "mvp_dot", "mvp_check", "metatag_option", "titletag_option", "description_option");
        $jsonArr = array();

        $s = "SELECT * FROM current_container_image_path WHERE cdn_type = 'default-assets'";
        $defaultCdn = $this->db->fetchRow($s);
        $cdn = $defaultCdn['image_path'] . config('rackspace.rs_featured_image_dir');

        $s = "select * from leadpops_template_info where leadpop_vertical_id = " . $trialDefaults["leadpop_vertical_id"];
        $s .= " and leadpop_vertical_sub_id = " . $trialDefaults["leadpop_vertical_sub_id"] . "
        and leadpop_version_id = " . $trialDefaults["leadpop_version_id"];
        $template_info =  $this->db->fetchAll($s);

            $lead_line = '<span style="font-family: ' . $trialDefaults["main_message_font"] . '; font-size: ' . $trialDefaults["main_message_font_size"] . '; color: ' . ($this->getGloballogoColor() == "" ? $trialDefaults["mainmessage_color"] : $this->getGloballogoColor()) . '">' . $trialDefaults["main_message"] . '</span>';
            $second_line = '<span style="font-family: ' . $trialDefaults["description_font"] . '; font-size: ' . $trialDefaults["description_font_size"] . '; color: ' . $trialDefaults["description_color"] . '">' . $trialDefaults["description"] . '</span>';

        #$jsonArr['my_company_name'] = "";
        #$jsonArr['my_company_phone'] = "";
        #$jsonArr['my_company_email'] = "";
        #$jsonArr['companyname_label'] = "";
        if($client['is_fairway'] == 1 || $client['is_mm'] == 1){
            $title_tag =  $trialDefaults["display_name"] . " | " . addslashes ( ucwords($client ['company_name']) );
        }
        else{
            $title_tag =  " FREE " . $trialDefaults["display_name"] . " | " . addslashes ( ucwords($client ['company_name']) );
        }

        $jsonArr['front_image'] = $cdn . $trialDefaults["image_name"];
        $jsonArr['logo_src'] = str_replace(" ", "", $logosrc);
        $jsonArr['logo_color'] = $this->getLogoColor();
        $jsonArr['colored_dot'] = $this->getDot();
        $jsonArr['favicon_dst'] = $this->getFavicon();
        $jsonArr['mvp_dot'] = $this->getRing();
        $jsonArr['mvp_check'] = $this->getCheck();
        $jsonArr['my_company_name'] = ucwords(strtolower($client['company_name']));
        $jsonArr['my_company_phone'] = "Call Today! " . str_replace(")-", ") ", $client['phone_number']);
        $jsonArr['my_company_email'] = $client['contact_email'];
        $jsonArr['font_family'] = $trialDefaults["main_message_font"];
        $jsonArr['font_family_desc'] = $trialDefaults["description_font"];
        $jsonArr['version_number'] = $trialDefaults["leadpop_version_id"];
        $jsonArr['the_vertical'] = ucfirst($trialDefaults["vertical_name"]);
        $jsonArr['subvertical_name'] = ucfirst($trialDefaults["subvertical_name"]);
        $jsonArr['titletag_option'] = $title_tag;
        $jsonArr['description_option'] = "";
        $jsonArr['metatag_option'] = "";

        //add in the current rackspace cdn
        $jsonArr["cdn"] = $this->getRackspaceUrl ('image_path','clients-assets');
        $json = json_encode($jsonArr);

//        $marketing_seo = "";
//        if ($this->getVertical() == "mortgage") {
//            $marketing_seo_options = $this->marketing_seo();
//            $marketing_seo = $marketing_seo_options[array_rand($marketing_seo_options, 1)];
//        }

        $s = "UPDATE clients_leadpops SET ";
        $s .= "funnel_variables = '" . addslashes($json) . "', lead_line =  '" . addslashes($lead_line) . "', ";
        $s .= "second_line_more = '" . addslashes($second_line) . "' ";
        $s .= " where client_id = " . $client["client_id"];
        $s .= " and leadpop_version_id = " . $trialDefaults["leadpop_version_id"];
        $s .= " and leadpop_version_seq = " . $trialDefaults["leadpop_version_seq"];
        $this->db->query($s);

    }

    /*
     * Re-wrting logic (Jaz)
     * */
    function addPlaceholder__old($trialDefaults,$logosrc,$imgsrc,$client){
        $keepJson = array("vertical_name", "subvertical_name", "version_number", "the_vertical", "front_image", "logo_src", "css_path", "image_path", "my_company_name", "my_company_phone", "my_company_email", "font_family", "font_family_desc", "logo_color", "colored_dot", "favicon_dst", "companyname_label", "mvp_dot", "mvp_check", "metatag_option", "titletag_option", "description_option");
        $jsonArr = array();

        $s = "select * from leadpops_template_info where leadpop_vertical_id = " . $trialDefaults["leadpop_vertical_id"];
        $s .= " and leadpop_vertical_sub_id = " . $trialDefaults["leadpop_vertical_sub_id"] . "
        and leadpop_version_id = " . $trialDefaults["leadpop_version_id"];
        $template_info =  $this->db->fetchAll($s);

        $s1 = "SELECT * FROM leadpops_templates_placeholders_info WHERE leadpop_template_id = ".$trialDefaults['leadpop_template_id']." order by step";
        $placeholders =  $this->db->fetchAll($s1);

        if($placeholders) {
            $s2 = "SELECT * FROM leadpops_templates_placeholders_values_info WHERE leadpop_template_id = " . $trialDefaults['leadpop_template_id'] . " AND step = 1";
            $values =  $this->db->fetchAll($s2);

            $jsonKeys = array_splice($placeholders, 8, 80);
            $jsonValues = array_splice($values, 8, 80);


            $lead_line = '<span style="font-family: ' . $trialDefaults["main_message_font"] . '; font-size: ' . $trialDefaults["main_message_font_size"] . '; color: ' . ($this->getGloballogoColor() == "" ? $trialDefaults["mainmessage_color"] : $this->getGloballogoColor()) . '">' . $trialDefaults["main_message"] . '</span>';
            $second_line = '<span style="font-family: ' . $trialDefaults["description_font"] . '; font-size: ' . $trialDefaults["description_font_size"] . '; color: ' . $trialDefaults["description_color"] . '">' . $trialDefaults["description"] . '</span>';


            foreach ($jsonKeys as $k => $v) {

                if (in_array($v, $keepJson)) {
                    $jsonArr[$v] = $jsonValues[$k];
                    $jsonArr['logo_src'] = str_replace(" ", "", $logosrc);
                    $jsonArr['front_image'] = str_replace(" ", "", $imgsrc);
                    $jsonArr['css_path'] = $template_info ['csspath'];
                    $jsonArr['image_path'] = $template_info ['imagepath'];
                }
            }


            $jsonArr['colored_dot'] = $this->getDot();
            $jsonArr['favicon_dst'] = $this->getFavicon();
            $jsonArr['mvp_dot'] = $this->getRing();
            $jsonArr['mvp_check'] = $this->getCheck();
            $jsonArr['logo_color'] = $this->getLogoColor();
            $jsonArr['my_company_name'] = ucwords(strtolower($client['company_name']));
            $jsonArr['my_company_phone'] = "Call Today! " . str_replace(")-", ") ", $client['phone_number']);
            $jsonArr['my_company_email'] = $client['contact_email'];
            $jsonArr['font_family'] = $trialDefaults["main_message_font"];
            $jsonArr['font_family_desc'] = $trialDefaults["description_font"];
            $jsonArr['version_number'] = $trialDefaults["leadpop_version_id"];
            $jsonArr['the_vertical'] = ucfirst($trialDefaults["vertical_name"]);
            $jsonArr['subvertical_name'] = ucfirst($trialDefaults["subvertical_name"]);
            $jsonArr['titletag_option'] = " FREE " . $trialDefaults["display_name"] . " | " . addslashes ( ucwords($client ['company_name']) );

            //add in the current rackspace cdn
            $jsonArr["cdn"] = $this->getRackspaceUrl ('image_path','clients-assets');
            $json = json_encode($jsonArr);

            $marketing_seo = "";
            if ($this->getVertical() == "mortgage") {
                $marketing_seo_options = $this->marketing_seo();
                $marketing_seo = $marketing_seo_options[array_rand($marketing_seo_options, 1)];
            }

            $s = "UPDATE clients_leadpops SET ";
            $s .= "funnel_variables = '" . addslashes($json) . "', lead_line =  '" . addslashes($lead_line) . "', ";
            $s .= "second_line_more = '" . addslashes($second_line) . "' ";
            $s .= " where client_id = " . $client["client_id"];
            $s .= " and leadpop_version_id = " . $trialDefaults["leadpop_version_id"];
            $s .= " and leadpop_version_seq = " . $trialDefaults["leadpop_version_seq"];
            $this->db->query($s);
        }
    }


    function setClientDefaultFaviconColor($trialDefaults) {
        $filename = "default-".$trialDefaults["leadpop_vertical_id"]. "-".$trialDefaults["leadpop_vertical_sub_id"] . "-". $trialDefaults["leadpop_version_id"];
        $this->setFavicon($this->getRackspaceUrl ('image_path')."images/".$filename.'-favicon-circle.png');
        $this->setDot($this->getRackspaceUrl ('image_path').'images/'.$filename.'-dot_img.png');
        $this->setRing($this->getRackspaceUrl ('image_path').'images/'.$filename.'-ring.png');
        $this->setCheck($this->getRackspaceUrl ('image_path').'images/'.$filename.'-mvp-check.png');
    }

    /**
     * @return mixed
     */
    public function getGloballogosrc()
    {
        return $this->globallogosrc;
    }

    /**
     * @param mixed $globallogosrc
     */
    public function setGloballogosrc($globallogosrc): void
    {
        $this->globallogosrc = $globallogosrc;
    }

    /**
     * @return mixed
     */
    public function getGloballogoColor()
    {
        return $this->globallogo_color;
    }

    /**
     * @param mixed $globallogo_color
     */
    public function setGloballogoColor($globallogo_color): void
    {
        $this->globallogo_color = $globallogo_color;
    }

    /**
     * @return mixed
     */
    public function getLogoname()
    {
        return $this->logoname;
    }

    /**
     * @param mixed $logoname
     */
    public function setLogoname($logoname): void
    {
        $this->logoname = $logoname;
    }

    /**
     * @return mixed
     */
    public function getLogoColor()
    {
        return $this->logo_color;
    }

    /**
     * @param mixed $logo_color
     */
    public function setLogoColor($logo_color): void
    {
        $this->logo_color = $logo_color;
    }

    /**
     * @return mixed
     */
    public function getFavicon()
    {
        return $this->favicon;
    }

    /**
     * @param mixed $favicon
     */
    public function setFavicon($favicon): void
    {
        $this->favicon = $favicon;
    }

    /**
     * @return mixed
     */
    public function getCheck()
    {
        return $this->check;
    }

    /**
     * @param mixed $check
     */
    public function setCheck($check): void
    {
        $this->check = $check;
    }

    /**
     * @return mixed
     */
    public function getDot()
    {
        return $this->dot;
    }

    /**
     * @param mixed $dot
     */
    public function setDot($dot): void
    {
        $this->dot = $dot;
    }

    /**
     * @return mixed
     */
    public function getRing()
    {
        return $this->ring;
    }

    /**
     * @param mixed $ring
     */
    public function setRing($ring): void
    {
        $this->ring = $ring;
    }

    /**
     * @return mixed
     */
    public function getVertical()
    {
        return $this->vertical;
    }

    /**
     * @param mixed $vertical
     */
    public function setVertical($vertical): void
    {
        $this->vertical = $vertical;
    }

    public function cloneFunnelProcess($pclientRow,$pweb,$skipclone,$client_id,$type = ProcessRepository::TYPE_DEFAULT){

        $file_list = [];
        $skipclone = explode('|',$skipclone);
        $multiplefunnels = array();

        // SQL moved out of loop for N+1 fix
        $clients_leadpops = $this->_get_clients_leadpops($client_id);
        $client_tags = $this->_get_clients_leadpops_tags($client_id);
        $leadpops_verticals_sub = $this->_get_leadpops_verticals_sub('display_label');
        $clients_emma_groups = $this->_get_clients_emma_group($client_id);
        $clients_lp_auto_recipients = $this->_get_clients_data_by('lp_auto_recipients', $client_id, true);
        $clients_bottom_links = $this->_get_clients_data_by('bottom_links', $client_id);
        $clients_contact_options = $this->_get_clients_data_by('contact_options', $client_id);
        $clients_autoresponder_options = $this->_get_clients_data_by('autoresponder_options', $client_id);
        $clients_seo_options = $this->_get_clients_data_by('seo_options', $client_id);
        $clients_leadpop_logos = $this->_get_clients_data_by('leadpop_logos', $client_id, true);
        $clients_leadpop_images = $this->_get_clients_data_by('leadpop_images', $client_id, true);
        $clients_submission_options = $this->_get_clients_data_by('submission_options', $client_id);
        $clients_leadpop_background_swatches = $this->_get_clients_data_by(getPartition($client_id, "leadpop_background_swatches"), $client_id, true);
        $clients_leadpop_background_color = $this->_get_clients_data_by('leadpop_background_color', $client_id, true);

        $clients_data = $this->db->fetchAll("select * from clients where client_id = " . $client_id);

        $insert_tags = array();

        foreach ($pweb as $res ) {

            $key  = $res['leadpop_vertical_id'].'~'.$res['leadpop_vertical_sub_id'] .'~'.$res['leadpop_type_id'].'~'.$res['leadpop_template_id'].'~'.$res['leadpop_id'].'~'.$res['leadpop_version_id'];

            if (!in_array($key,$skipclone)) {

                list($sub_level,$top_level,$top_most) = explode(".",$res['current_client_funnel_url']);
                if ($res['leadpop_type_id'] == '1') { // subdomain
                    $oldDomain = $res['current_client_funnel_url'];
                    $maxseq = $res['leadpop_version_seq'];
                    if (array_key_exists($key,$multiplefunnels)) {
                        $multiplefunnels[$key] = ++$multiplefunnels[$key];
                        $maxseq = $multiplefunnels[$key];
                    }else {
                        $maxseq += 1; // increase sequence by one
                    }
                }

                /** Jaz Notes: 03/03/2020 ==> (New Addition)
                 *
                 *      Everytime if someone executes website funnel launcher scripts it was creating same funnel url with but with different verison sequence
                 *      Which is an issue so it should create a new funnel URL if website funnel launcher script executed multiple time.
                 *      Logic to create funnel url is taken from website funnel launcher code
                 */
                $s = "SELECT COUNT(*) as num_subdomains FROM clients_funnels_domains WHERE client_id = ".$res['client_id'] . " AND leadpop_type_id=" . config('leadpops.leadpopSubDomainTypeId');
                $s .= " AND subdomain_name = '".$res['new_subdomain_name']."' AND top_level_domain = '".$res['new_top_level_domain']."'";

                $subdomainInfo = $this->db->fetchRow($s);
                if($subdomainInfo['num_subdomains'] >= 1){

                    $subdomain_name = "";
                    $subdomain_name = str_replace('-'.$res['client_id'], '', $res['new_subdomain_name']);
                    $s = "SELECT COUNT(*) as num_subdomains FROM clients_funnels_domains WHERE client_id = ".$res['client_id'] . " AND leadpop_type_id=" . config('leadpops.leadpopSubDomainTypeId');
                    $s .= " AND subdomain_name LIKE '%".$subdomain_name."%'";
                    $subdomainInfo = $this->db->fetchRow($s);

                    $inc_number = $subdomainInfo['num_subdomains']+1;
                    $sdomain_arr = explode("-", $res['new_subdomain_name']);
                    $cname = $sdomain_arr[0];

                    $display_name = $leadpops_verticals_sub[$res["leadpop_vertical_id"]][$res["leadpop_vertical_sub_id"]];
                    $display_name = strtolower( $display_name );
                    $display_name = str_replace( " ", "-", $display_name );
                    $display_name = str_replace( "hybrid", "rates", $display_name );
                    $display_name = str_replace( "vip-home-search", "find-a-home", $display_name );

                    if ( $res["subdomain_name"] == "mmortgagelauncher-rates-15yr-site" ) {
                        $suburl = $cname . "-" . $display_name . "-15yr-site-".$inc_number."-". $res['client_id'];
                    } else if ( $res["subdomain_name"] == "mmortgagelauncher-rates-30yr-site" ) {
                        $suburl = $cname . "-" . $display_name . "-30yr-site-". $inc_number ."-". $res['client_id'];
                    } else if ( $res["subdomain_name"] == "mmortgagelauncher-arm-site" ) {
                        $suburl = $cname . "-arm-site-". $inc_number ."-". $res['client_id'];
                    } else if ( $res["subdomain_name"] == "mmortgagelauncher-pre-approval-letter-site" ) {
                        $suburl = $cname . "-pre-approval-letter-site-". $inc_number ."-". $res['client_id'];
                    } else if ( $res["subdomain_name"] == "mmortgagelauncher-refi-analysis-site" ) {
                        $suburl = $cname . "-refi-analysis-site-". $inc_number ."-". $res['client_id'];
                    } else if ( $res["subdomain_name"] == "mmortgagelauncher-sidebar-site" ) {
                        $suburl = $cname . "-sidebar-site-". $inc_number ."-". $res['client_id'];
                    } else if ( $res["subdomain_name"] == "mmortgagelauncher-verify-eligibility-site" ) {
                        $suburl = $cname . "-verify-eligibility-site-". $inc_number ."-". $res['client_id'];
                    } else if ( $res["subdomain_name"] == "mmortgagelauncher-request-consultation-site" ) {
                        $suburl = $cname . "-request-consultation-site-". $inc_number ."-". $res['client_id'];
                    } else {
                        $suburl = $cname . "-" . $display_name . "-site-". $inc_number ."-". $res['client_id'];
                    }

                    $res['new_subdomain_name'] = $suburl;
                }

                $add_mortgage_website_funnels_mvp = "add_mortgage_website_funnels_mvp";
                $trial_launch_defaults = "trial_launch_defaults";
                switch ($type){
                    case ProcessRepository::TYPE_MOVEMENT:
                        $add_mortgage_website_funnels_mvp = "add_mortgage_website_funnels_mvp_movement";
                        break;
                    case ProcessRepository::TYPE_FAIRWAY:
                        $add_mortgage_website_funnels_mvp = "add_mortgage_website_funnels_mvp_fairway";
                        $trial_launch_defaults = "trial_launch_defaults_fairway";

                        break;
                    case ProcessRepository::TYPE_INSURANCE:
                        $add_mortgage_website_funnels_mvp = "add_insurance_website_funnels_mvp";
                        break;
                    case ProcessRepository::TYPE_BALLER:
                        $add_mortgage_website_funnels_mvp = "add_mortgage_website_funnels_mvp_baller";
                        $trial_launch_defaults = "trial_launch_defaults_ballers";
                        break;
                    case ProcessRepository::TYPE_REALESTATE:
                        $add_mortgage_website_funnels_mvp = "add_realestate_website_funnels_mvp";
                        break;
                    case ProcessRepository::TYPE_STEARNS:
                        $add_mortgage_website_funnels_mvp = "add_mortgage_website_funnels_mvp_stearns";
                        break;
                    default:
                        $add_mortgage_website_funnels_mvp = "add_mortgage_website_funnels_mvp";
                        break;
                }
                $s = "update $add_mortgage_website_funnels_mvp set leadpop_version_seq = " . $maxseq;
                $s .= " where client_id = " . $res['client_id'];
                $s .= " and leadpop_vertical_id = " . $res["leadpop_vertical_id"];
                $s .= " and leadpop_vertical_sub_id = " . $res["leadpop_vertical_sub_id"] ;
                $s .= " and leadpop_type_id = " . $res["leadpop_type_id"] ;
                $s .= " and leadpop_id = " . $res["leadpop_id"] ;
                $s .= " and leadpop_version_id = " . $res["leadpop_version_id"] ;
                $s .= " and new_subdomain_name = '".$res["new_subdomain_name"]."'"  ;
                //$this->db->query($s);
                MyLeadsEvents::getInstance()->gearmanQuery($s);

                $multiplefunnels[$key] = $maxseq;

                $now = new \DateTime();

                /** Jaz Notes: 03/04/2020
                 *  For Launching Website funnels we always need to get data from intial/stock funnesl so always take minimum version_seq instead of taking last version_seq
                 *
                 *  Notes: 11/05/2021 = This SQL moved out of loop to remove N+1
                 */

                /* ****
                $s = "select * from clients_leadpops ";
                $s .= " where  client_id = " .  $res['client_id'];
                $s .= " and leadpop_id = " . $res["leadpop_id"];
                $s .= " and leadpop_version_id = " . $res["leadpop_version_id"];
                $s .= " ORDER BY leadpop_version_seq ASC ";
                $s .= " limit 1";

                $old = $this->db->fetchRow($s);
                **** */

                if(!array_key_exists($client_id."-".$res['leadpop_version_id']."-".$res['leadpop_version_seq'], $clients_leadpops)){
                    /** funnel not exist */
                    Log::debug("clonefunnelprocess_mvp_fix => fetch clients_leadpops: ", [$s]);
                    continue;
                }
                $old = $clients_leadpops[$client_id."-".$res['leadpop_version_id']."-".$res['leadpop_version_seq']];

                if(!@$old["funnel_questions"] || $old["funnel_questions"] == null){
                    $old["funnel_questions"] = "{}";
                }
                if(!@$old["conditional_logic"] || $old["conditional_logic"] == null){
                    $old["conditional_logic"] = "{}";
                }
                if(!@$old["funnel_hidden_field"] || $old["funnel_hidden_field"] == null){
                    $old["funnel_hidden_field"] = "{}";
                }
                $initial_seq = $old["leadpop_version_seq"];

                $website_funnel_name = "";

                /*
                 * Note: This will add the incremented number with funnel name.
                 * */
                $inc_number_name = '';
                $matches = [];
                $matched = preg_match('/-(\d+)-\d+$/',$res['new_subdomain_name'], $matches);
                if($matched){
                    $inc_number_name =  ' ('.$matches[1].')';
                }

                if(strpos($res['new_subdomain_name'], "find-a-home-site") !== false){
                    $website_funnel_name = "Website - Home Search".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "vip-home-search-site") !== false){
                    $website_funnel_name = "Website - VIP Home".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "home-valuation-address-site") !== false){
                    $website_funnel_name = "Website - Home Values".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "203k-rates-site") !== false){
                    $website_funnel_name = "Website - 203K".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "arm-site") !== false){
                    $website_funnel_name = "Website - ARM".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "rates-15yr-site") !== false){
                    $website_funnel_name = "Website - 15yr Fixed".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "rates-30yr-site") !== false){
                    $website_funnel_name = "Website - 30yr Fixed".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "sidebar-site") !== false){
                    $website_funnel_name = "Website - Sidebar".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "verify-eligibility-site") !== false){
                    $website_funnel_name = "Website - Eligibility".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "pre-approval-letter-site") !== false){
                    $website_funnel_name = "Website - Pre-Approval".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "purchase-site") !== false){
                    $website_funnel_name = "Website - Purchase".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "refi-analysis-site") !== false){
                    $website_funnel_name = "Website - Refi Analysis".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "refinance-site") !== false){
                    $website_funnel_name = "Website - Refinance".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "fha-rates-site") !== false){
                    $website_funnel_name = "Website - FHA Loans".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "harp-loans-site") !== false){
                    $website_funnel_name = "Website - HARP".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "jumbo-rates-site") !== false){
                    $website_funnel_name = "Website - Jumbo Loans".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "reverse-mortgage-site") !== false){
                    $website_funnel_name = "Website - Reverse".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "usda-rates-site") !== false){
                    $website_funnel_name = "Website - USDA Loans".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "va-rates-site") !== false){
                    $website_funnel_name = "Website - VA Loans".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "credit-repair") !== false){
                    $website_funnel_name = "Website - Credit Repair".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "-home-site-") !== false){
                    $website_funnel_name = "Website - Home Insurance".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "rates-site") !== false){
                    $website_funnel_name = "Website - Today’s Rates".$inc_number_name;
                }
                else if(strpos($res['new_subdomain_name'], "request-consultation-site") !== false){
                    $website_funnel_name = "Website - Request Consultation".$inc_number_name;
                }
                else {
                    $website_funnel_name = $res['new_subdomain_name'];
                }

                $funnel_name_exist = $this->checkExistFunnelName($client_id,$website_funnel_name);
                if($funnel_name_exist){
                   $website_funnel_name = $website_funnel_name.' '.$maxseq;
                }
                //$old["funnel_name"]  ==> replaced with ==> $website_funnel_name

                $leadpops_funnel_variables = json_decode($old["funnel_variables"],1);

                //lead Line
                $old_lead_line = $old["lead_line"];
                $old_lead_line = str_replace(';;',';',$old_lead_line);
                $old_lead_line = str_replace(': #',':#',$old_lead_line);
                $first = strpos($old_lead_line,'color:#');
                $first += 6;
                $sec = strpos($old_lead_line,'>',$first);
                $sec -= 1;
                $main_clr = substr($old_lead_line,$first,($sec-$first));
                $lead_line = '<span style="font-family:'.$res['main_message_font'].' font-size: '.$res['main_message_font_size'].'; color: '.$main_clr.';">'.$res['main_message'].'</span>';

                //Second Lead Line
                $old_second_line_more = $old["second_line_more"];
                $old_second_line_more = str_replace(';;',';',$old_second_line_more);
                $old_second_line_more = str_replace(': #',':#',$old_second_line_more);
                $first = strpos($old_second_line_more,'color:#');
                $first += 6;
                $sec = strpos($old_second_line_more,'>',$first);
                $sec -= 1;
                $desc_clr = substr($old_second_line_more,$first,($sec-$first));
                $second_line_more = "<span style='font-family:".$res["description_font"]." font-size: ".$res["description_font_size"]."; color: ".$desc_clr."' >".$res["description"]."</span>";
                $folder_id  = $this->addFolder('Website Funnels',$client_id);
                $s = "insert into clients_leadpops (client_id,question_sequence,funnel_questions,funnel_hidden_field,funnel_variables,conditional_logic,lead_line,second_line_more,funnel_name,leadpop_id,leadpop_version_id,leadpop_active,access_code,leadpop_version_seq,funnel_market,static_thankyou_active,static_thankyou_slug,date_added,leadpop_folder_id) values (";
                $s .=  $client_id .",'" . $old["question_sequence"] . "','" . addslashes($old["funnel_questions"]) . "','" . addslashes($old["funnel_hidden_field"]) . "',
                '" . addslashes($old["funnel_variables"]) . "','" . $old["conditional_logic"] . "','" . addslashes($lead_line) . "','" . addslashes($second_line_more) . "','" . $website_funnel_name . "'," . $old["leadpop_id"] . ",
                " . $old["leadpop_version_id"] . ",'1',''," . $maxseq . ",'w','y','thank-you.html',
                '".$now->format("Y-m-d H:i:s")."',".$folder_id.")";
                $this->db->query ( $s );

                $client_leadpop_id = $this->db->lastInsertId();

                $this->createCloneFunnelRow($client_id,$client_leadpop_id);

                $ex_clients_leadpops = $clients_leadpops[$client_id."-".$res["leadpop_version_id"]."-".$initial_seq];
                $ex_client_leadpop_id = $ex_clients_leadpops['id'];
                array_push($insert_tags, [
                   'client_id' => $client_id,
                   'client_leadpop_id' => $client_tags[$ex_client_leadpop_id]['client_leadpop_id'],
                   'leadpop_tag_id' => $client_tags[$ex_client_leadpop_id]['leadpop_tag_id'],
                   'leadpop_id' => $client_tags[$ex_client_leadpop_id]['leadpop_id'],
                   'client_tag_name' => $client_tags[$ex_client_leadpop_id]['client_tag_name'],
                   'is_default' => $client_tags[$ex_client_leadpop_id]['is_default']
                ]);

                $website_tag['tag'] = '';
                $website_tag['leadpop_id'] = $ex_clients_leadpops['leadpop_id'];

                $this->assign_tag_to_funnel($client_leadpop_id,$website_tag,$client_id);

                // lp_auto_recepients
                if(array_key_exists($res['client_id'], $clients_lp_auto_recipients))
                    $old = $clients_lp_auto_recipients[$res['client_id']][$res["leadpop_version_id"]][$initial_seq];
                else
                    $old = array();

                for($i=0; $i<count($old); $i++) {
                    $s = "insert into lp_auto_recipients (client_id,leadpop_id,leadpop_type_id,";
                    $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                    $s .= "leadpop_version_seq,email_address,is_primary) values (" . $res['client_id'] . ",";
                    $s .= $res["leadpop_id"] . "," . $res['leadpop_type_id'] . "," . $res["leadpop_vertical_id"] . "," . $res["leadpop_vertical_sub_id"] . "," . $res["leadpop_template_id"] . "," . $res["leadpop_version_id"];
                    $s .= "," . $maxseq . ",'" . $old[$i]["email_address"] . "','".$old[$i]["is_primary"]."')";
                    $this->db->query($s);

                    $lastId = $this->db->lastInsertId();


                    $s = "select * from lp_auto_text_recipients ";
                    $s .= " where client_id = " . $res['client_id'];
                    $s .= " and lp_auto_recipients_id = " . $old[$i]["id"];

                    $oldtext = $this->db->fetchAll($s);

                    for($j=0; $j<count($oldtext); $j++) {
                        $s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
                        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                        $s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $res['client_id'] . "," . $lastId . ",";
                        $s .= $res["leadpop_id"] . "," . $res['leadpop_type_id'] . "," . $res["leadpop_vertical_id"] . "," . $res["leadpop_vertical_sub_id"] . "," . $res["leadpop_template_id"] . "," . $res["leadpop_version_id"];
                        $s .= "," . $maxseq . ",'" . $oldtext[$j]["phone_number"] . "','".$oldtext[$j]["carrier"]."','".$oldtext[$j]["is_primary"]."')";
                        MyLeadsEvents::getInstance()->gearmanQuery($s);
                    }

                }

                if ($res['leadpop_type_id'] == '1') { // subdomain
                    $subdomain =  	$res['new_subdomain_name'];

                    $topdomain = $res['new_top_level_domain'];

                    $s = "insert into clients_funnels_domains (id,client_id,subdomain_name,top_level_domain,leadpop_vertical_id,";
                    $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                    $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq ) values (null,";
                    $s .= $res['client_id'] . ",'" . $subdomain . "','" . $topdomain . "',";
                    $s .= $res["leadpop_vertical_id"] . "," . $res["leadpop_vertical_sub_id"] . "," . $res['leadpop_type_id'] . "," . $res['leadpop_template_id'] . ",";
                    $s .= $res["leadpop_id"] . "," . $res["leadpop_version_id"] . "," . $maxseq . ")";
                    //$this->db->query($s);
                    MyLeadsEvents::getInstance()->gearmanQuery($s);

                    // insert into force ssl
                    $s = "insert into force_ssl (id,url) values (null,'".$subdomain.".".$topdomain."')";
                    //$this->db->query($s);
                    MyLeadsEvents::getInstance()->gearmanQuery($s);
                    // insert into force ssl

                    if(array_key_exists($client_id, $clients_emma_groups)){
                        $emmaExists = $clients_emma_groups[$client_id][$res["leadpop_vertical_id"]][$res["leadpop_vertical_sub_id"]][$oldDomain];
                    } else {
                        $emmaExists = array();
                    }

                    if($res["leadpop_vertical_id"] == 3 || $res["leadpop_vertical_id"] == 5) {
                       // if emma already created then insert the new entry in emma group table
                        if (!empty($emmaExists)) {
                            $s = "insert into client_emma_group  (id,client_id,domain_name,member_account_id,member_group_id,";
                            $s .= "group_name,total_contacts,leadpop_vertical_id,leadpop_subvertical_id,active) values (null,";
                            $s .= $res['client_id'] .",'" .$subdomain . "." . $topdomain."',".$emmaExists[0]["member_account_id"].",".$emmaExists[0]["member_group_id"].",'";
                            $s .= $emmaExists[0]["group_name"]."',0,".$emmaExists[0]["leadpop_vertical_id"].",".$emmaExists[0]["leadpop_subvertical_id"].",'y')";
                            MyLeadsEvents::getInstance()->gearmanQuery($s);
                        } else {
                            // if emma NOT created then insert the new entry in emma cron table
                            $emma_account_type = "mortgage";
                            if($res["leadpop_vertical_id"] == 5){
                                $emma_account_type = "realestate";
                            }
                            // taking basic information for emma from one of existing entry
                            $sql = "SELECT id, emma_default_group, account_name, master_account_ids FROM client_emma_cron WHERE ";
                            $sql .= " client_id= ".$res['client_id']." and leadpop_vertical_id = ".$res["leadpop_vertical_id"]." and leadpop_subvertical_id = ".$res["leadpop_vertical_sub_id"]."";
                            $ex_emma_cron = $this->db->fetchRow( $sql );
                            // if new funnel already has its basic information into emma cron table
                            if($ex_emma_cron) {
                                $EmmaAccountName = $ex_emma_cron['account_name'];
                                $master_account_ids = $ex_emma_cron['master_account_ids'];
                                $emma_default_group = $ex_emma_cron['emma_default_group'];

                                // Check if emma accout not created for the client then insert funnel into emma cron table
                                /* emma insert */
                                $s = "insert into client_emma_cron (id,client_id,emma_default_group,account_type,domain_name,account_name,master_account_ids,has_run, leadpop_vertical_id,leadpop_subvertical_id) values (null,";
                                $s .= $res['client_id'] . ",'" . $emma_default_group . "','" . $emma_account_type . "','" . strtolower($subdomain . "." . $topdomain) . "','" . $EmmaAccountName . "','";
                                $s .= $master_account_ids . "','y'," . $res["leadpop_vertical_id"] . "," . $res["leadpop_vertical_sub_id"] . ")";
                                MyLeadsEvents::getInstance()->gearmanQuery($s);
                            }

                        }
                    }
                    /* 4/8/2016  add emma check and possible insert for new domain */


                    $googledomain = $subdomain . "." . $topdomain;

                    $dt = date ( 'Y-m-d H:i:s' );
                    $s = "insert into purchased_google_analytics (client_id,purchased,google_key,";
                    $s .= "thedate,domain,active,package_id) values (" . $res['client_id'] . ",'y','','" . $dt . "','" . $googledomain . "',";
                    $s .= "'n',2)";
                    MyLeadsEvents::getInstance()->gearmanQuery($s);

                    $old = $clients_bottom_links[$res['client_id']][$res["leadpop_version_id"]][$initial_seq];
                    $s = "insert into  bottom_links (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
                    $s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
                    $s .= "privacy,terms,disclosures,licensing,";
                    $s .= "about,contact,privacy_active,terms_active,";
                    $s .= "disclosures_active,licensing_active,about_active,";
                    $s .= "contact_active,privacy_type,terms_type,";
                    $s .= "disclosures_type,licensing_type,about_type,";
                    $s .= "contact_type,privacy_url,terms_url,disclosures_url,";
                    $s .= "licensing_url,about_url,contact_url,privacy_text,";
                    $s .= "terms_text,disclosures_text,licensing_text,";
                    $s .= "about_text,contact_text,";
                    $s .= "compliance_text,compliance_is_linked,compliance_link,compliance_active,";
                    $s .= "license_number_active,license_number_is_linked,license_number_text,license_number_link";
                    $s .= ") values (null,";
                    $s .= $res['client_id'] . "," . $res["leadpop_id"] . "," . $res['leadpop_type_id'] . "," . $res["leadpop_vertical_id"] . "," . $res["leadpop_vertical_sub_id"] . ",";
                    $s .= $res['leadpop_template_id'] . "," . $res["leadpop_version_id"] . "," . $maxseq;
                    $s .= ",'".$old["privacy"]."','".$old["terms"]."','".$old["disclosures"]."',";
                    $s .= "'".$old["licensing"]."','".$old["about"]."','".$old["contact"]."',";
                    $s .= "'".$old["privacy_active"]."','".$old["terms_active"]."','".$old["disclosures_active"]."',";
                    $s .= "'".$old["licensing_active"]."','".$old["about_active"]."','".$old["contact_active"]."',";
                    $s .= "'".$old["privacy_type"]."','".$old["terms_type"]."','".$old["disclosures_type"]."',";
                    $s .= "'".$old["licensing_type"]."','".$old["about_type"]."','".$old["contact_type"]."',";
                    $s .= "'".$old["privacy_url"]."','".$old["terms_url"]."','".$old["disclosures_url"]."',";
                    $s .= "'".$old["licensing_url"]."','".$old["about_url"]."','".$old["contact_url"]."',";
                    $s .= "'".$old["privacy_text"]."','".$old["terms_text"]."','".$old["disclosures_text"]."',";
                    $s .= "'".$old["licensing_text"]."','".$old["about_text"]."','".$old["contact_text"]."',";
                    $s .= "'".$old["compliance_text"]."','".$old["compliance_is_linked"]."','".$old["compliance_link"]."',";
                    $s .= "'".$old["compliance_active"]."','".$old["license_number_active"]."','".$old["license_number_is_linked"]."',";
                    $s .= "'".$old["license_number_text"]."','".$old["license_number_link"]."'";
                    $s .= ") ";
                    MyLeadsEvents::getInstance()->gearmanQuery($s);

                    $old = $clients_contact_options[$res['client_id']][$res["leadpop_version_id"]][$initial_seq];
                    $s = "insert into contact_options (id,client_id,leadpop_id,";
                    $s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
                    $s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
                    $s .= "companyname,phonenumber,email,";
                    $s .= "companyname_active,";
                    $s .= "phonenumber_active,email_active) values (null,";
                    $s .= $res['client_id'] . "," . $res["leadpop_id"] . "," . $res['leadpop_type_id'] . "," . $res["leadpop_vertical_id"] . "," . $res["leadpop_vertical_sub_id"] . ",";
                    $s .= $res['leadpop_template_id'] . "," . $res["leadpop_version_id"] . "," . $maxseq . ",";
                    $s .= "'" . addslashes ($old["companyname"]) . "','".addslashes ($old["phonenumber"])."','";
                    $s .= $old["email"] . "','".$old["companyname_active"]."',";
                    $s .= "'".$old["phonenumber_active"]."','".$old["email_active"]."')";
                    MyLeadsEvents::getInstance()->gearmanQuery($s);

                    $old = $clients_autoresponder_options[$res['client_id']][$res["leadpop_version_id"]][$initial_seq];
                    $s = "insert into autoresponder_options (id,client_id,leadpop_id,";
                    $s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
                    $s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
                    $s .= "html,thetext,html_active,text_active ) values (null,";
                    $s .= $res['client_id'] . "," . $res["leadpop_id"] . "," . $res['leadpop_type_id'] . "," . $res["leadpop_vertical_id"] . "," . $res["leadpop_vertical_sub_id"] . ",";
                    $s .= $res['leadpop_template_id'] . "," . $res["leadpop_version_id"] . "," . $maxseq . ",";
                    $s .= "'" . addslashes($old["html"]) . "','".addslashes($old["thetext"])."','".$old["html_active"]."','".$old["text_active"]."')";
                    MyLeadsEvents::getInstance()->gearmanQuery($s);

                    $old = $clients_seo_options[$res['client_id']][$res["leadpop_version_id"]][$initial_seq];
                    $s = "insert into seo_options (id,client_id,leadpop_id,";
                    $s .= "leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,";
                    $s .= "leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
                    $s .= "titletag,description,metatags,";
                    $s .= "titletag_active,description_active,metatags_active) values (null,";
                    $s .= $res['client_id'] . "," . $res["leadpop_id"] . "," . $res['leadpop_type_id'] . "," . $res["leadpop_vertical_id"] . "," . $res["leadpop_vertical_sub_id"] . ",";
                    $s .= $res['leadpop_template_id'] . "," . $res["leadpop_version_id"] . "," . $maxseq . ",";
                    $s .= "'" . addslashes ( $old["titletag"] ) . "','".addslashes ( $old["description"] )."','".addslashes ( $old["metatags"] )."',";
                    $s .= "'".$old["titletag_active"]."','".$old["description_active"]."','".$old["metatags_active"]."') ";
                    MyLeadsEvents::getInstance()->gearmanQuery($s);


                    if(array_key_exists($res['client_id'], $clients_leadpop_logos))
                        $old = $clients_leadpop_logos[$res['client_id']][$res["leadpop_version_id"]][$initial_seq];
                    else
                        $old = array();

                    for($h=0; $h<count($old); $h++) {
                        if($old[$h]["use_default"] == "y") {
                            $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
                            $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
                            $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
                            $s .= "logo_src,use_me,numpics,logo_color,ini_logo_color,default_colored) values (null,";
                            $s .= $res['client_id'].",".$res["leadpop_id"].",".$res['leadpop_type_id'].",".$res["leadpop_vertical_id"].",".$res["leadpop_vertical_sub_id"].",";
                            $s .= $res['leadpop_template_id'].",".$res["leadpop_version_id"].",".$maxseq.",";
                            $s .= "'".$old[$h]["use_default"]."','".$old[$h]["logo_src"]."','".$old[$h]["use_me"]."','".$old[$h]["numpics"]."','".$old[$h]["logo_color"]."','".$old[$h]["ini_logo_color"]."','".$old[$h]["default_colored"]."') ";
                            MyLeadsEvents::getInstance()->gearmanQuery($s);
                        }
                        else {
                            $logopieces = explode("_",$old[$h]["logo_src"]);
                            $imagename = end($logopieces);
                            $logopath = strtolower($client_id."_".$res["leadpop_id"]."_".$res['leadpop_type_id']."_".$res["leadpop_vertical_id"]."_".$res["leadpop_vertical_sub_id"]."_".$res['leadpop_template_id']."_".$res["leadpop_version_id"]."_".$maxseq."_".$imagename);
                            $logo_url = $this->getRackspaceUrl ('image_path','clients-assets').substr($res['client_id'],0,1) . '/' . $res['client_id'] . '/logos/' . $old[$h]["logo_src"];
                            $leadpops_funnel_variables["logo_src"] = $logo_url;

                            $file_list[] = array(
                                'server_file' => $logo_url,
                                'container' => 'clients',
                                'rackspace_path' => 'images1/'.substr($res['client_id'],0,1) . '/' . $res['client_id'] . '/logos/' . $logopath
                            );

                            // change $old[$h]["logo_src"] to $logopath
                            $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
                            $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
                            $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
                            $s .= "logo_src,use_me,numpics,logo_color,ini_logo_color,default_colored) values (null,";
                            $s .= $res['client_id'].",".$res["leadpop_id"].",".$res['leadpop_type_id'].",".$res["leadpop_vertical_id"].",".$res["leadpop_vertical_sub_id"].",";
                            $s .= $res['leadpop_template_id'].",".$res["leadpop_version_id"].",".$maxseq.",";
                            $s .= "'".$old[$h]["use_default"]."','".$logopath."','".$old[$h]["use_me"]."','".$old[$h]["numpics"]."','".$old[$h]["logo_color"]."','".$old[$h]["ini_logo_color"]."','".$old[$h]["default_colored"]."') ";
                            MyLeadsEvents::getInstance()->gearmanQuery($s);

                            /**
                             * Update funnel Variables, to update the LOGO URL.
                             */
                            $s = "UPDATE clients_leadpops set funnel_variables = '".addslashes(json_encode($leadpops_funnel_variables))."' where id = ".$client_leadpop_id;
                            MyLeadsEvents::getInstance()->gearmanQuery($s);
                        }
                    }


                    if(array_key_exists($res['client_id'], $clients_leadpop_images))
                        $old = $clients_leadpop_images[$res['client_id']][$res["leadpop_version_id"]][$initial_seq];
                    else
                        $old = array();

                    // get trial info from version_seq = 1 because if funnel is cloned manny times the higher version_seq not exist in trial tables
                    $s = "select * from ".$trial_launch_defaults;
                    $s .= " where leadpop_vertical_sub_id = " . $res["leadpop_vertical_sub_id"];
                    $s .= " and leadpop_template_id = " . $res["leadpop_template_id"];
                    $s .= " and leadpop_version_id  = " . $res["leadpop_version_id"];
                    $s .= " ORDER BY leadpop_version_seq ASC";
                    $trialDefaults = $this->db->fetchRow($s);

                    /*
                     * For Stearns Template we have 2 extra columns for featured image => default_feature_image + custom_feature_image
                     * */
                    for($h=0; $h<count($old); $h++) { // will only find one row from above query
                        if($type == ProcessRepository::TYPE_STEARNS && array_key_exists("default_feature_image", $res)){
                            // STEARNS TEMPLATE
                            if($old[$h]["use_default"] == "y" && $res["default_feature_image"] == "y" ) {
                                $s = "insert into leadpop_images (id,client_id,leadpop_id,leadpop_type_id,";
                                $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
                                $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
                                $s .= "image_src,use_me,numpics) values (null,";
                                $s .= $res['client_id'].",".$res["leadpop_id"].",".$res['leadpop_type_id'].",".$res["leadpop_vertical_id"].",".$res["leadpop_vertical_sub_id"].",";
                                $s .= $res['leadpop_template_id'].",".$res["leadpop_version_id"].",".$maxseq.",";
                                $s .= "'".$old[$h]["use_default"]."','".$old[$h]["image_src"]."','".$old[$h]["use_me"]."',".$old[$h]["numpics"].") ";
                                MyLeadsEvents::getInstance()->gearmanQuery($s);
                            }
                            else {

                                if($res["default_feature_image"] == "y") {
                                    $imagepieces = explode("_",$old[$h]["image_src"]);

                                    $imagename = end($imagepieces);
                                    $new_image_name = strtolower($client_id."_".$res["leadpop_id"]."_".$res['leadpop_type_id']."_".$res["leadpop_vertical_id"]."_".$res["leadpop_vertical_sub_id"]."_".$res['leadpop_template_id']."_".$res["leadpop_version_id"]."_".$maxseq."_".$imagename);
                                    $use_me = $old[ $h ]["use_me"];
                                    $use_default = $old[$h]["use_default"];
                                    $defaultimagename = $trialDefaults['image_name'];
                                    if(trim($old[$h]["image_src"]) == $defaultimagename) {
                                        $imagesrc =  $this->getRackspaceUrl ('image_path', 'default-assets') . config('rackspace.rs_featured_image_dir').$defaultimagename;
                                    }else{
                                        $imagesrc = $this->getRackspaceUrl ('image_path','clients-assets').substr($res['client_id'],0,1) . '/' . $res['client_id'] . '/pics/' . $old[$h]["image_src"];
                                    }

                                    $file_list[] = array(
                                        'server_file' => $imagesrc,
                                        'container' => 'clients',
                                        'rackspace_path' => 'images1/'.substr($res['client_id'],0,1) . '/' . $res['client_id'] . '/pics/' . $new_image_name
                                    );
                                }
                                else if($res["default_feature_image"] == "n" && $res["custom_feature_image"] != ""){
                                    $imagename = $res["custom_feature_image"];
                                    $new_image_name = strtolower($client_id."_".$res["leadpop_id"]."_".$res['leadpop_type_id']."_".$res["leadpop_vertical_id"]."_".$res["leadpop_vertical_sub_id"]."_".$res['leadpop_template_id']."_".$res["leadpop_version_id"]."_".$maxseq."_".$imagename);
                                    $use_me = "y";
                                    $use_default = 'n';
                                    $file_list[] = array(
                                        'server_file' => $this->getRackspaceUrl ('image_path', 'default-assets') . config('rackspace.rs_featured_image_dir').$imagename,
                                        'container' => 'clients',
                                        'rackspace_path' => 'images1/'.substr($res['client_id'],0,1) . '/' . $res['client_id'] . '/pics/' . $new_image_name
                                    );
                                }
                                else {
                                    $imagename = "";
                                    $new_image_name = "";
                                    $use_me = "n";
                                    $use_default = 'y';
                                }

                                $s = "insert into leadpop_images (id,client_id,leadpop_id,leadpop_type_id,";
                                $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
                                $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
                                $s .= "image_src,use_me,numpics) values (null,";
                                $s .= $res['client_id'].",".$res["leadpop_id"].",".$res['leadpop_type_id'].",".$res["leadpop_vertical_id"].",".$res["leadpop_vertical_sub_id"].",";
                                $s .= $res['leadpop_template_id'].",".$res["leadpop_version_id"].",".$maxseq.",";
                                $s .= "'".$use_default."','". $new_image_name ."','".$use_me."',".$old[$h]["numpics"].") ";
                                MyLeadsEvents::getInstance()->gearmanQuery($s);
                                if($new_image_name) {
                                    $image_url = $this->getRackspaceUrl('image_path', 'clients-assets') .substr($res['client_id'],0,1) . '/' . $res['client_id'] . '/pics/' . $new_image_name;
                                    $leadpops_funnel_variables["front_image"] = $image_url;


                                    /**
                                     * Update funnel Variables, to update the LOGO URL.
                                     */
                                    $s = "UPDATE clients_leadpops set funnel_variables = '" . addslashes(json_encode($leadpops_funnel_variables)) . "' where id = " . $client_leadpop_id;
                                    MyLeadsEvents::getInstance()->gearmanQuery($s);
                                }
                            }
                        }
                        else{

                            // ALL OTHER TEMPLATES
                            if($old[$h]["use_default"] == "y") {
                                $s = "insert into leadpop_images (id,client_id,leadpop_id,leadpop_type_id,";
                                $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
                                $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
                                $s .= "image_src,use_me,numpics) values (null,";
                                $s .= $res['client_id'].",".$res["leadpop_id"].",".$res['leadpop_type_id'].",".$res["leadpop_vertical_id"].",".$res["leadpop_vertical_sub_id"].",";
                                $s .= $res['leadpop_template_id'].",".$res["leadpop_version_id"].",".$maxseq.",";
                                $s .= "'".$old[$h]["use_default"]."','".$old[$h]["image_src"]."','".$old[$h]["use_me"]."',".$old[$h]["numpics"].") ";
                                MyLeadsEvents::getInstance()->gearmanQuery($s);
                            }
                            else {
                                $defaultimagename = $trialDefaults['image_name'];
                                $imagepieces = explode("_",$old[$h]["image_src"]);
                                $imagename = end($imagepieces);
                                $imagepath = strtolower($client_id."_".$res["leadpop_id"]."_".$res['leadpop_type_id']."_".$res["leadpop_vertical_id"]."_".$res["leadpop_vertical_sub_id"]."_".$res['leadpop_template_id']."_".$res["leadpop_version_id"]."_".$maxseq."_".$imagename);
                                if(trim($old[$h]["image_src"]) == $defaultimagename) {
                                    $imagesrc =  $this->getRackspaceUrl ('image_path', 'default-assets') . config('rackspace.rs_featured_image_dir').$defaultimagename;
                                }else{
                                    $imagesrc = $this->getRackspaceUrl ('image_path','clients-assets').substr($res['client_id'],0,1) . '/' . $res['client_id'] . '/pics/' . $old[$h]["image_src"];
                                }
                                $file_list[] = array(
                                    'server_file' => $imagesrc,
                                    'container' => 'clients',
                                    'rackspace_path' => 'images1/'.substr($res['client_id'],0,1) . '/' . $res['client_id'] . '/pics/' . $imagepath
                                );

                                $s = "insert into leadpop_images (id,client_id,leadpop_id,leadpop_type_id,";
                                $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
                                $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
                                $s .= "image_src,use_me,numpics) values (null,";
                                $s .= $res['client_id'].",".$res["leadpop_id"].",".$res['leadpop_type_id'].",".$res["leadpop_vertical_id"].",".$res["leadpop_vertical_sub_id"].",";
                                $s .= $res['leadpop_template_id'].",".$res["leadpop_version_id"].",".$maxseq.",";
                                $s .= "'".$old[$h]["use_default"]."','". $imagepath ."','".$old[$h]["use_me"]."',".$old[$h]["numpics"].") ";
                                MyLeadsEvents::getInstance()->gearmanQuery($s);

                                if($imagepath) {
                                    $image_url = $this->getRackspaceUrl('image_path', 'clients-assets') .substr($res['client_id'],0,1) . '/' . $res['client_id'] . '/pics/' . $imagepath;
                                    $leadpops_funnel_variables["front_image"] = $image_url;


                                    /**
                                     * Update funnel Variables, to update the LOGO URL.
                                     */
                                    $s = "UPDATE clients_leadpops set funnel_variables = '" . addslashes(json_encode($leadpops_funnel_variables)) . "' where id = " . $client_leadpop_id;
                                    MyLeadsEvents::getInstance()->gearmanQuery($s);
                                }
                            }

                        }
                    }

                    $old = $clients_submission_options[$res['client_id']][$res["leadpop_version_id"]][$initial_seq];

                    $s = "insert into submission_options (id,client_id,leadpop_id,leadpop_type_id,";
                    $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
                    $s .= "leadpop_version_id,leadpop_version_seq,";
                    $s .= "thankyou,information,";
                    $s .= "thirdparty,thankyou_active,";
                    $s .= "information_active,thirdparty_active) values (null,";
                    $s .= $res['client_id'] . "," . $res["leadpop_id"] . "," . $res['leadpop_type_id'] . "," . $res["leadpop_vertical_id"] . "," . $res["leadpop_vertical_sub_id"] . ",";
                    $s .= $res['leadpop_template_id'] . "," . $res["leadpop_version_id"] . "," . $maxseq . ",";
                    $s .= "'" . addslashes ( $old["thankyou"] ) . "','".addslashes ( $old["information"] ) ."',";
                    $s .= "'".addslashes ( $old["thirdparty"] ) ."','".$old["thankyou_active"]."',";
                    $s .= "'".$old["information_active"]."','".$old["thirdparty_active"]."')";

                    MyLeadsEvents::getInstance()->gearmanQuery($s);

                    /*
                    $s = "select * from leadpops_verticals where id = " . $res["leadpop_vertical_id"];
                    $vertres = $this->db->fetchRow ( $s );
                    $verticalName = $vertres ['lead_pop_vertical'];

                    $s = "select * from leadpops_verticals_sub where leadpop_vertical_id  = " . $res["leadpop_vertical_id"];
                    $s .= " and id = " . $res["leadpop_vertical_sub_id"];
                    $subvertres = $this->db->fetchRow ( $s );
                    $subverticalName = $subvertres ['lead_pop_vertical_sub'];
                    */

                    $old = $clients_leadpop_background_swatches[$res['client_id']][$res["leadpop_version_id"]][$initial_seq];

                    for($k=0; $k < count($old); $k++) {
                        $s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
                        $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                        $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
                        $s .= "swatch,is_primary,active) values (null,";
                        $s .= $res['client_id'] . "," . $res["leadpop_vertical_id"] . ",";
                        $s .= $res["leadpop_vertical_sub_id"] . ",";
                        $s .= $res['leadpop_type_id'] . "," . $res['leadpop_template_id'] . ",";
                        $s .= $res["leadpop_id"] . ",";
                        $s .= $res["leadpop_version_id"] . ",";
                        $s .= $maxseq . ",";
                        $s .= "'" . addslashes($old[$k]["swatch"]) . "',";
                        $s .= "'" . $old[$k]["is_primary"] . "',";
                        $s .= "'" . $old[$k]["active"] . "' )";
                        MyLeadsEvents::getInstance()->gearmanQuery($s);
                    }

                    if(array_key_exists($res['client_id'], $clients_leadpop_background_color))
                        $old = $clients_leadpop_background_color[$res['client_id']][$res["leadpop_version_id"]][$initial_seq];
                    else
                        $old = array();

                    for($k=0; $k < count($old); $k++) {
                        if($res['leadpop_vertical_id'] == 3 && @$clients_data[0]['is_fairway'] == 1){
                            $s = "insert into  leadpop_background_color";
                            $s .=  " (id, client_id, leadpop_vertical_id,";
                            $s .=  "leadpop_vertical_sub_id, leadpop_type_id, leadpop_template_id,";
                            $s .=  "leadpop_id, leadpop_version_id, leadpop_version_seq,";
                            $s .=  "background_color, active, default_changed,";
                            $s .=  "bgimage_url, active_backgroundimage, background_overlay,";
                            $s .=  "active_overlay, bgimage_properties, bgimage_style, ";
                            $s .=  "background_type, background_custom_color, background_overlay_opacity)";
                            $s .=   "values (null, ". $res['client_id'] . ", " . $res["leadpop_vertical_id"] . ", ";
                            $s .= 	$res["leadpop_vertical_sub_id"] . ", ". $res['leadpop_type_id'] . ", " . $res['leadpop_template_id'] . ", ";
                            $s .= 	$res["leadpop_id"] . ", ". $res["leadpop_version_id"] . ", ". $maxseq . ", ";
                            $s .=  "'" . addslashes($old[$k]["background_color"]) . "', '".$old[$k]["active"]."', '".$old[$k]["default_changed"]."', ";
                            $s .=  "'" . $old[$k]["bgimage_url"] . "', '".$old[$k]["active_backgroundimage"]."', '".$old[$k]["background_overlay"]."', ";
                            $s .=  "'" . $old[$k]["active_overlay"] . "', '".$old[$k]["bgimage_properties"]."', '". addslashes($old[$k]["bgimage_style"])."', ";
                            $s .=  $old[$k]["background_type"] . ", '".$old[$k]["background_custom_color"]."', ".$old[$k]["background_overlay_opacity"].")";
                            MyLeadsEvents::getInstance()->gearmanQuery($s);
                        }else{
                            $s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
                            $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                            $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
                            $s .= "background_color,active,default_changed) values (null,";
                            $s .= $res['client_id'] . "," . $res["leadpop_vertical_id"] . ",";
                            $s .= $res["leadpop_vertical_sub_id"] . ",";
                            $s .= $res['leadpop_type_id'] . "," . $res['leadpop_template_id'] . ",";
                            $s .= $res["leadpop_id"] . ",";
                            $s .= $res["leadpop_version_id"] . ",";
                            $s .= $maxseq . ",";
                            $s .= "'" . addslashes($old[$k]["background_color"]) . "','".$old[$k]["active"]."','".$old[$k]["default_changed"]."')";
                            MyLeadsEvents::getInstance()->gearmanQuery($s);
                        }
                    }

                    echo "<span style='color:#fff; font-size:16px'>=> ".$googledomain ." => Created </span><br />";
                }
            }

            // Insert leadpops_client_tags
            if(!empty($insert_tags)){
                $inserts = collect($insert_tags);
                $chunks = $inserts->chunk(1000);
                foreach ($chunks as $c=>$chunk){
                    DB::table('leadpops_client_tags')->insert($chunk->toArray());
                }
            }
        }

        /**
         * Upload files to rackspace through GM Process
         */
        if(@$file_list){
            MyLeadsEvents::getInstance()->executeRackspaceCDNClient($file_list);
        }
    }


    //get all tag list
    function Gettag($t,$client_id){
        $res = \DB::select("SELECT
            *
        FROM
            leadpops_tags
        WHERE
            tag_name = '".$t."'
            AND client_id  = '".$client_id."'");
        return $res;
    }

    //get all folder list
    function Getfolder($folder_name,$client_id){
        ## $sql = \DB::select("SELECT * FROM leadpops_client_folders WHERE folder_name = '".$folder_name."' AND client_id  = '".$client_id."'");
        ## return $sql;

        $info = array();
        if(array_key_exists($client_id, $this->leadpops_client_folders)){
            $info[0] = $this->leadpops_client_folders[$client_id][$folder_name];
        }
        else{
            $folders = \DB::select("SELECT * FROM leadpops_client_folders WHERE client_id  = '".$client_id."'");
            if($folders){
                foreach($folders as $folder){
                    $this->leadpops_client_folders[$client_id][$folder->folder_name] = $folder;
                }
                $info[0] = $this->leadpops_client_folders[$client_id][$folder_name];
            }
        }
        return $info;
    }

    //get tag mapping list against client_id , client_leadpop_id and tag_id
    function Checktagmaping($client_leadpop_id,$tag_id,$client_id){
        $sql = \DB::select("SELECT
            *
        FROM
            leadpops_client_tags
        WHERE
            client_leadpop_id = '".$client_leadpop_id."'
            AND  leadpop_tag_id  = '".$tag_id."'
            AND client_id  = '".$client_id."'");
        //Pause Logic to verify SQL
        return $sql;
    }

    //add vertical name for folder in leadpops_client_folders table if exist otherwise get the folder id against vertical name
    function assign_folder_to_funnel($folder_name,$client_id){
        $s = $this->Getfolder($folder_name,$client_id);
        if(empty($s)) {
            if(strtolower($folder_name) == 'website funnels'){
                $website = 1;
            }else{
                $website = 0;
            }
            $folder = array(
                'client_id' => $client_id,
                'folder_name' => $folder_name,
                'is_default' => 1,
                'is_website' => $website
            );
            $id = $this->db->insert('leadpops_client_folders', $folder);
            return $id;
        }else{
            $rec = objectToArray($s[0]);
            return $rec['id'];
        }
    }

    //add sub vertical name or group name for tag in leadpops_tags table f exist otherwise get the tag id against sub vertical name or group name
    function assign_tag_to_funnel($client_leadpop_id,$trialDefaults,$client_id){
        $tag_name = $trialDefaults["tag"].',Website';
        $all_tag = explode(',',$tag_name);
        if($all_tag) {
            foreach ($all_tag as $v) {
                if ($v) {
                    $rs = $this->Gettag($v, $client_id);
                    if (empty($rs)) {
                        $tag = array(
                            'client_id' => $client_id,
                            'tag_name' => $v,
                            'is_default' => 1
                        );
                        $tag_id = $this->db->insert('leadpops_tags', $tag);
                    } else {
                        $rec = objectToArray($rs[0]);
                        $tag_id = $rec['id'];
                    }
                    $chk_tag = $this->Checktagmaping($client_leadpop_id, $tag_id, $client_id);
                    if (empty($chk_tag)) {
                        $data = array(
                            'client_id' => $client_id,
                            'client_leadpop_id' => $client_leadpop_id,
                            'leadpop_tag_id' => $tag_id,
                            'leadpop_id' => $trialDefaults["leadpop_id"],
                            'client_tag_name' => $v,
                            'active' => 1
                        );
                        $this->db->insert('leadpops_client_tags', $data);
                    }
                }
            }
        }
    }

    function addFolder($folder_name,$client_id){
        $s = $this->getFolder($folder_name,$client_id);
        if(empty($s)) {
            $s = "insert into leadpops_client_folders (";
            $s .= "client_id,folder_name,is_default)";
            $s .= "values (";
            $s .= $client_id . ",'".ucfirst($folder_name)."',1)";
            $this->db->query($s);
            return $this->db->lastInsertId();
        }else{
            $rec = objectToArray($s[0]);
            return $rec['id'];
        }
    }

    function checkExistFunnelName($client_id,$funnel_name){

        $s = "SELECT * FROM clients_leadpops WHERE client_id=".$client_id." AND funnel_name = '".$funnel_name."'";
          return $this->db->fetchRow( $s );
    }

    /**
     * @param $clientId
     * @param $clientLeadpopsId
     * add the new row in clients_leadpops_attributes table for clone feature
     * default is_clone = 0
     */
    function createCloneFunnelRow($clientId,$clientLeadpopsId){
        $s = "insert into clients_leadpops_attributes (client_id,clients_leadpop_id,is_clone) values (".$clientId.",".$clientLeadpopsId.",0)";
        //$this->db->query($s);
        MyLeadsEvents::getInstance()->gearmanQuery($s);
    }

    private function _get_clients_leadpops($client_id){
        $s = "SELECT id, question_sequence, funnel_questions, funnel_hidden_field, funnel_variables, conditional_logic, lead_line, second_line_more, leadpop_id, leadpop_version_id, leadpop_version_seq ";
        $s .= " FROM clients_leadpops WHERE client_id = " .  $client_id . " AND leadpop_active = 1";
        $s .= " ORDER BY leadpop_version_id, leadpop_version_seq ASC ";
        $clients_leadpops_res = $this->db->fetchAll($s);
        $clients_leadpops = array();
        foreach($clients_leadpops_res as $z=>$info){
            $clients_leadpops[$client_id."-".$info['leadpop_version_id']."-".$info['leadpop_version_seq']] = $info;
        }
        return $clients_leadpops;
    }

    private function _get_clients_leadpops_tags($client_id){
        // Client Tags
        $tagSQL = "SELECT client_id, client_leadpop_id, leadpop_tag_id, leadpop_id, client_tag_name, is_default";
        $tagSQL .= " FROM leadpops_client_tags WHERE client_id = ".$client_id;
        $tagRes = $this->db->fetchAll( $tagSQL );
        $client_tags = array();
        foreach($tagRes as $z=>$info){
            $client_tags[$info['client_leadpop_id']] = $info;
        }

        return $client_tags;
    }

    private function _get_leadpops_verticals_sub($key='', $id='', $leadpop_vertical_id=''){
        $sql = "SELECT id, leadpop_vertical_id, display_label FROM leadpops_verticals_sub";
        $res = $this->db->fetchAll( $sql );
        $data = array();
        foreach($res as $info){
            if($key != ''){
                $data[$info['leadpop_vertical_id']][$info['id']] = $info[$key];
            } else {
                $data[$info['leadpop_vertical_id']][$info['id']] = $info;
            }
        }

        if($id != ''){
            return $data[$leadpop_vertical_id][$id];
        } else {
            return $data;
        }
    }

    private function _get_clients_emma_group($client_id){
        $sql = "  SELECT * FROM client_emma_group ";
        $sql .= " WHERE client_id = " . $client_id;
        $res = $this->db->fetchAll( $sql );

        $data = array();
        if($res){
            foreach($res as $info){
                $data[$info['client_id']][$info['leadpop_vertical_id']][$info['leadpop_subvertical_id']][$info['domain_name']][] = $info;
            }
        }

        return $data;
    }

    private function _get_clients_data_by($table, $client_id, $is_multi=false){
        $sql = "SELECT * FROM ".$table;
        $sql .= " WHERE client_id = " .  $client_id;
        $res = $this->db->fetchAll( $sql );

        $data = array();
        if($res) {
            foreach ($res as $info) {
                if($is_multi){
                    $data[$info['client_id']][$info['leadpop_version_id']][$info['leadpop_version_seq']][] = $info;
                } else {
                    $data[$info['client_id']][$info['leadpop_version_id']][$info['leadpop_version_seq']] = $info;
                }
            }
        }

        return $data;
    }
}
