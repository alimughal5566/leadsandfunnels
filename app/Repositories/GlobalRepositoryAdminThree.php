<?php
/**
 * Created by PhpStorm.
 * User: MZAC90
 * Date: 18/11/2019
 * Time: 10:22 PM
 */

/**
 * Code Migrated from Zend to Laravel  ==>  GlobalRepository --> Source: Default_Model_Global
 */

namespace App\Repositories;

use App\Constants\FunnelVariables;
use App\Helpers\Query;
use App\Helpers\Utils;
use App\Services\DataRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\gm_process\MyLeadsEvents;
use App\Helpers\GlobalHelper;
use LP_Helper;


class GlobalRepositoryAdminThree
{
    use Response;
    private $db;

    public function __construct(\App\Services\DbService $service)
    {
        $this->db = $service;
    }

    function getGlobalBackgroundImageOptions($client_id)
    {
        if (!is_numeric($client_id)) return false;
        $s = "SELECT active_backgroundimage, bgimage_url ,active_overlay , background_overlay  , bgimage_style, bgimage_properties ,background_overlay_opacity";
        //$s .= "FROM leadpop_background_color WHERE client_id = " . $client_id;
        $s .= " FROM global_settings WHERE client_id = " . $client_id;
        $s .= " AND active_backgroundimage='y' order by id desc limit 1 ";

        //echo $s;
        $global_bk_image = $this->db->fetchAll($s);

        return $global_bk_image;
    }

    function globalSaveSeo($client_id, $adata)
    {
        if (!is_numeric($client_id)) return false;

        $lplist = Utils::getLpKeys();

        $seo_title_active = ($adata["seo_title_active"] == "y") ? "y" : "n";
        $seo_description_active = ($adata["seo_description_active"] == "y") ? "y" : "n";
        $seo_keyword_active = ($adata["seo_keyword_active"] == "y") ? "y" : "n";


        $seo_title_tag = str_replace('"', "", $adata["titletag"]);
        $seo_description = str_replace('"', "", $adata["description"]);
        $seo_keywords = str_replace('"', "", $adata["metatags"]);

        $allLeadpops = $this->db->fetchAll('select * from leadpops');

        $clientLeadpopsTable = getPartition($client_id, 'clients_leadpops');
        $query = "SELECT funnel_variables,leadpop_id,leadpop_version_seq FROM $clientLeadpopsTable WHERE client_id = $client_id";
        $allClientLeadpops = $this->db->fetchAll($query);

        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];

            $lpres = Utils::findFirstInRowsByValues($allLeadpops, [
                'id' => $leadpop_id
            ]);

            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            $leadpop_type_id = $lpres['leadpop_type_id'];

            $seo_variables = [];

            $s = "update seo_options set titletag_active = '" . $seo_title_active . "', description_active = '" . $seo_description_active . "', metatags_active = '" . $seo_keyword_active . "' ";
            if ($adata['titletag']) {
                $s .= ", titletag = '" . addslashes($seo_title_tag) . "'";

                if ($seo_title_active == 'y') {
                    $seo_variables[FunnelVariables::SEO_TITLE_TAG] = $adata['titletag'];
                }
            }
            if ($adata['description']) {
                $s .= ", description = '" . addslashes($seo_description) . "'";

                if ($seo_description_active == 'y') {
                    $seo_variables[FunnelVariables::SEO_DESCRIPTION] = $adata['description'];
                }
            }
            if ($adata['metatags']) {
                $s .= ", metatags = '" . addslashes($seo_keywords) . "'";

                if ($seo_keyword_active == 'y') {
                    $seo_variables[FunnelVariables::SEO_KEYWORD] = $adata['metatags'];
                }
            }

            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;

            Query::execute($s, $lp);

            $clientLeadpop = Utils::findFirstInRowsByValues($allClientLeadpops, [
                'leadpop_id' => $leadpop_id,
                'leadpop_version_seq' => $leadpop_version_seq
            ]);

            if($clientLeadpop){
                $funnelVariables = json_decode($clientLeadpop['funnel_variables'], true);
                $funnelVariables = array_merge($funnelVariables, $seo_variables);

                $s = "UPDATE clients_leadpops SET funnel_variables = '" . addslashes(json_encode($funnelVariables)) . "' ";
                $s .= " WHERE client_id = " . $client_id;
                $s .= " AND leadpop_id = " . $leadpop_id;
                $s .= " AND leadpop_version_seq = " . $leadpop_version_seq;

                Query::execute($s, $lp);
            }
        }

        return true;
    }


    function uploadGlobalFeaturedImageAdminThree($afiles, $client_id, $funnel_data = array(), $hasFile)
    {
        $getCdnLink =  getCdnLink();

        if (env('GEARMAN_ENABLE') == "1") $gearmanQuery = true;
        else $gearmanQuery = false;

        // To ADD Source Funnel in Global QUE

        $currentFunnelKey = "";
        if(isset($_POST['current_hash'])){
            $currentFunnelKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);
        }

        $lplist = explode(",", $_POST['selected_funnels']);
        $scaling_properties = json_encode(['maxWidth'=>@$_POST['scaling_maxWidthPx'], 'scalePercentage'=>@$_POST['scaling_defaultWidthPercentage']]);

        // Logic to add REFERENCE/SOURCE to list if not added.
        $lplist = json_decode(json_encode($lplist), 1);
        array_unshift($lplist, $_POST['firstkey']);
        $lplist = array_unique($lplist);


        // Case: If user upload image then assign same to all selected funnels
        $gf_image_active_val = (isset($_POST["gf_image_active"]) && $_POST["gf_image_active"]) ? "y" : "n";
        $afiles['logo']['name'] = preg_replace('/[^\.a-zA-Z0-9]/', '', $afiles['logo']['name']);
        $uimagename = strtolower($client_id . "_global_" . $afiles['logo']['name']);
        $section = substr($client_id, 0, 1);
        $uimagepath = $_SERVER['DOCUMENT_ROOT'] . '/images/clients/' . $section . '/' . $client_id . '/pics/' . $uimagename;
        $uimageurl = $getCdnLink . '/pics/' . $uimagename;

        list($src_w, $src_h, $type) = getimagesize($afiles['logo']["tmp_name"]);
        $rsInfo = move_uploaded_file_to_rackspace($afiles['logo']['tmp_name'], $uimagepath);
        if (env('APP_ENV') == config('app.env_local')) $uimagepath = $rsInfo['rs_cdn'];
        else $uimagepath = $rsInfo['client_cdn'];

        $customize = new CustomizeRepository($this->db);

        $gis = getimagesize($uimagepath);
        $ow = $gis[0];
        $oh = $gis[1];
        $type = $gis[2];
        switch ($type) {
            case "1":
                $im = imagecreatefromgif($uimagepath);
                break;
            case "2":
                $im = imagecreatefromjpeg($uimagepath);
                break;
            case "3":
                $im = imagecreatefrompng($uimagepath);
                break;
            default:
                $im = imagecreatefromjpeg($uimagepath);
        }
        $imagetype = image_type_to_mime_type($type);

        if ($imagetype != 'image/jpeg' && $imagetype != 'image/png' && $imagetype != 'image/gif') {
            return $this->errorResponse();
        }

      //  dd($_POST);

        extract($_POST, EXTR_OVERWRITE, "form_");
        $featured_img_cp = [];
        $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);
        $getCdnLink = getCdnLink();
        $data = [];

        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];


            /*  $s = "select * from leadpops where id = " . $leadpop_id;
  $lpres = $this->db->fetchRow($s);*/

            $lpres = $lpListCollection->where('leadpop_id', $leadpop_id)->first();

            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];

            $replaced = $client_id . "_global_";
            $image = str_replace($replaced, "", $uimagename);
            $imagename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $leadpop_vertical_id . "_" . $leadpop_vertical_sub_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $leadpop_version_seq . "__global__" . $image);
            $section = substr($client_id, 0, 1);
            #$newimagepath = $_SERVER['DOCUMENT_ROOT'].'/images/clients/'.$section . '/' . $client_id.'/pics/'.$imagename;
            $newimagepath = $section . '/' . $client_id . '/pics/' . $imagename;
            $featured_img_cp[] = array("src" => $uimagepath, 'dest' => $newimagepath);

            ## $s = "update leadpop_images  set numpics = 1,image_src = '" . $imagename . "', use_me = '" . 'y' . "' , use_default = '" . 'n' . "' ";
            $s = "update leadpop_images  set numpics = 1,image_src = '" . $imagename . "' ,scaling_properties = '" . @$scaling_properties . "' ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            Query::execute($s, $currentFunnelKey);
         /*   if ($gearmanQuery) {
                MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
            } else {
                $this->db->query($s);
            }*/
            $imagesrc = $getCdnLink . '/pics/' . $imagename;

            if (@$use_default == "y") {
                $s = "select * from trial_launch_defaults where leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id  = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = 1";

                $trialDefaults = $this->db->fetchRow($s);

                $images = $this->db->fetchRow($s);
                $section = substr($client_id, 0, 1);
                $imagename = strtolower($client_id . "_" . $trialDefaults["leadpop_id"] . "_1_" . $trialDefaults["leadpop_vertical_id"] . "_" . $trialDefaults["leadpop_vertical_sub_id"] . "_" . $trialDefaults['leadpop_template_id'] . "_" . $trialDefaults["leadpop_version_id"] . "_" . $trialDefaults["leadpop_version_seq"] . "_" . $trialDefaults['image_name']);
                $imagesrc = $getCdnLink . '/pics/' . $imagename;

                $s = "update leadpop_images  set use_default = '" . $use_default . "',use_me = '" . $use_me
                    . "' , image_src = '" . $imagename
                    . "' ,scaling_properties = '" . @$scaling_properties . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                Query::execute($s, $currentFunnelKey);
                /*if ($gearmanQuery) {
                    MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
                } else {
                    $this->db->query($s);
                }*/
            }

            if (@$use_default == 'n' && @$use_me == 'n') {
                $s = "update leadpop_images  set use_default = '" . $use_default . "',use_me = '" . $use_me . "',scaling_properties = '" . @$scaling_properties .  "'"  ;
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                Query::execute($s, $currentFunnelKey);
               /* if ($gearmanQuery) {
                    MyLeadsEvents::getInstance()->runMyLeadsClient([$s]);
                } else {
                    $this->db->query($s);
                }*/
            }

            $customize->updateFunnelVar(FunnelVariables::FRONT_IMAGE, $imagesrc, $client_id, $leadpop_id, $leadpop_version_seq);
            $data["image_src"] = $imagesrc;
        }

        if (!empty($featured_img_cp)) {
            foreach ($featured_img_cp as $d) {
                //   $rs_info2 = rackspace_copy_file_as($d["src"], $d["dest"]);
                rackspace_copy_file_as_with_gearman($d["src"], $d["dest"]);
            }
        }

        return $this->successResponse($data);
    }

    public function saveBottomLinks($client_id, $adata)
    {

        if (!is_numeric($client_id)) return false;

        /*global privacy policy post data*/
        $privacy_policy_active = (isset($adata["privacy_policy_active"]) && $adata["privacy_policy_active"] == "y") ? "y" : "n";
        $terms_of_use_active = (isset($adata["terms_of_use_active"]) && $adata["terms_of_use_active"] == "y") ? "y" : "n";
        $disclosures_active = (isset($adata["disclosures_active"]) && $adata["disclosures_active"] == "y") ? "y" : "n";
        $licensing_information_active = (isset($adata["licensing_information_active"]) && $adata["licensing_information_active"] == "y") ? "y" : "n";
        $about_us_active = (isset($adata["about_us_active"]) && $adata["about_us_active"] == "y") ? "y" : "n";
        $contact_us_active = (isset($adata["contact_us_active"]) && $adata["contact_us_active"] == "y") ? "y" : "n";


        $linktype = $adata["linktype"];
        $theurltext = $adata["theurltext"];
        $theurl = $adata["theurl"];
        $footereditor = $adata["footereditor"];
        $theselectiontype = $adata["theselectiontype"];
        $theselection = $adata["theselection"];
        $thelink = $adata["thelink"];
        $f_ai_flag = $adata["gfot-ai-flg"]; // footer active inactive change flag
        $gfot_ai_val = $adata["gfot_ai_val"]; // footer active inactive orignal value

        extract($_POST, EXTR_OVERWRITE, "form_");

        if (!isset($adata['selected_funnels'])) {
            return false;
        }

        $lplist = explode(",", $adata['selected_funnels']);

        //start add current Funnel key
        $currentHash = $_POST['current_hash'];
        $currentKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        if (!empty($currentKey)) {
            array_push($lplist, $currentKey);
        }
        //end add current Funnel key



        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $vertical_id = $lpconstt[0];
            $subvertical_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $version_seq = $lpconstt[3];

            $active_inactive_data = array('vertical_id' => $vertical_id, 'subvertical_id' => $subvertical_id, 'leadpop_id' => $leadpop_id, 'version_seq' => $version_seq, 'client_id' => $client_id, 'thelink' => $thelink);
            if ($f_ai_flag == 1) {
                switch ($theselectiontype) {
                    case 'footeroptionsprivacypolicy':
                        if ($gfot_ai_val != $privacy_policy_active) {
                            $this->updateFooterActiveInactive($active_inactive_data, $privacy_policy_active);
                        }
                        break;
                    case 'termsofuse':
                        if ($gfot_ai_val != $terms_of_use_active) {
                            $this->updateFooterActiveInactive($active_inactive_data, $terms_of_use_active);
                        }
                        break;
                    case 'disclosures':
                        if ($gfot_ai_val != $disclosures_active) {
                            $this->updateFooterActiveInactive($active_inactive_data, $disclosures_active);
                        }
                        break;
                    case 'licensinginformation':
                        if ($gfot_ai_val != $licensing_information_active) {
                            $this->updateFooterActiveInactive($active_inactive_data, $licensing_information_active);
                        }
                        break;
                    case 'aboutus':
                        if ($gfot_ai_val != $about_us_active) {
                            $this->updateFooterActiveInactive($active_inactive_data, $about_us_active);
                        }
                        break;
                    case 'contactus':
                        if ($gfot_ai_val != $contact_us_active) {
                            $this->updateFooterActiveInactive($active_inactive_data, $contact_us_active);
                        }
                        break;
                }
            }
            $s = "select * from leadpops where id = " . $leadpop_id;

            $lpres = $this->db->fetchRow($s);

            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            $leadpop_type_id = $lpres['leadpop_type_id'];

            if ($adata['theselectiontype'] == 'footeroptionsprivacypolicy') {
                $s = "update bottom_links set privacy_type = '" . $adata['theselection'] . "', ";
                $s .= " privacy_url = '" . $adata['theurl'] . "', ";
                $s .= " privacy = '" . addslashes(htmlspecialchars($adata['footereditor'])) . "', ";
                $s .= " privacy_text = '" . addslashes($adata['theurltext']) . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;

            }
            if ($adata['theselectiontype'] == 'termsofuse') {
                $s = "update bottom_links set terms_type = '" . $adata['theselection'] . "', ";
                $s .= " terms_url = '" . $adata['theurl'] . "', ";
                $s .= " terms = '" . addslashes(htmlspecialchars($adata['footereditor'])) . "', ";
                $s .= " terms_text = '" . addslashes($adata['theurltext']) . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
            }
            if ($adata['theselectiontype'] == 'disclosures') {
                $s = "update bottom_links set disclosures_type = '" . $adata['theselection'] . "', ";
                $s .= " disclosures_url = '" . $adata['theurl'] . "', ";
                $s .= " disclosures = '" . addslashes(htmlspecialchars($adata['footereditor'])) . "', ";
                $s .= " disclosures_text = '" . addslashes($adata['theurltext']) . "' ";

                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;

            }
            if ($adata['theselectiontype'] == 'licensinginformation') {
                $s = "update bottom_links set licensing_type = '" . $adata['theselection'] . "', ";
                $s .= " licensing_url = '" . addslashes($adata['theurl']) . "', ";
                $s .= " licensing = '" . addslashes(htmlspecialchars($adata['footereditor'])) . "', ";
                $s .= " licensing_text = '" . addslashes($adata['theurltext']) . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
            }
            if ($adata['theselectiontype'] == 'aboutus') {
                $s = "update bottom_links set about_type = '" . $adata['theselection'] . "', ";
                $s .= " about_url = '" . $adata['theurl'] . "', ";
                $s .= " about = '" . addslashes(htmlspecialchars($adata['footereditor'])) . "', ";
                $s .= " about_text = '" . addslashes($adata['theurltext']) . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
            }
            if ($adata['theselectiontype'] == 'contactus') {
                $s = "update bottom_links set contact_type = '" . $adata['theselection'] . "', ";
                $s .= " contact_url = '" . $adata['theurl'] . "', ";
                $s .= " contact = '" . addslashes(htmlspecialchars($adata['footereditor'])) . "', ";
                $s .= " contact_text = '" . addslashes($adata['theurltext']) . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
            }
            $this->db->query($s);
            //   exit($s);
        }
        $s = "select * from global_settings where client_id = " . $client_id;
        $client = $this->db->fetchRow($s);
        switch ($theselectiontype) {
            case 'footeroptionsprivacypolicy':
                $table_data = array(
                    'client_id' => $client_id,
                    'privacy_policy_active' => $privacy_policy_active,
                    'privacy_type' => $linktype,
                    'privacy_text' => $theurltext,
                    'privacy_url' => $theurl,
                    'privacy' => $footereditor
                );
                break;
            case 'termsofuse':
                $table_data = array(
                    'client_id' => $client_id,
                    'terms_of_use_active' => $terms_of_use_active,
                    'terms_type' => $linktype,
                    'terms_text' => $theurltext,
                    'terms_url' => $theurl,
                    'terms' => $footereditor
                );
                break;
            case 'disclosures':
                $table_data = array(
                    'client_id' => $client_id,
                    'disclosures_active' => $disclosures_active,
                    'disclosures_type' => $linktype,
                    'disclosures_text' => $theurltext,
                    'disclosures_url' => $theurl,
                    'disclosures' => $footereditor
                );
                break;
            case 'licensinginformation':
                $table_data = array(
                    'client_id' => $client_id,
                    'licensing_information_active' => $licensing_information_active,
                    'licensing_type' => $linktype,
                    'licensing_text' => $theurltext,
                    'licensing_url' => $theurl,
                    'licensing' => $footereditor
                );
                break;
            case 'aboutus':
                $table_data = array(
                    'client_id' => $client_id,
                    'about_us_active' => $about_us_active,
                    'about_type' => $linktype,
                    'about_text' => $theurltext,
                    'about_url' => $theurl,
                    'about' => $footereditor
                );
                break;
            case 'contactus':
                $table_data = array(
                    'client_id' => $client_id,
                    'contact_us_active' => $contact_us_active,
                    'contact_type' => $linktype,
                    'contact_text' => $theurltext,
                    'contact_url' => $theurl,
                    'contact' => $footereditor
                );
                break;
        }

        return true;
    }




    function addScheme($url, $scheme = 'http://')
    {

        return parse_url($url, PHP_URL_SCHEME) === null ?
            $scheme . $url : $url;
    }

    function updateFooterActiveInactive($data, $change_to = null)
    {

        $vertical_id = $data['vertical_id'];
        $subvertical_id = $data['subvertical_id'];
        $leadpop_id = $data['leadpop_id'];
        $version_seq = $data['version_seq'];
        $client_id = $data['client_id'];
        $thelink = $data['thelink'];

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select * from bottom_links ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $bottomLinks = $this->db->fetchRow($s);

        if ($thelink == 'contact_active') {
            if ($bottomLinks['contact_active'] == 'y') {
                $changeto = 'n';
                $chglink = "";
            } else {
                $changeto = 'y';
                $chglink = '/popadmin/contactus';
            }
        }

        if ($thelink == 'about_active') {
            if ($bottomLinks['about_active'] == 'y') {
                $changeto = 'n';
                $chglink = "";
            } else {
                $changeto = 'y';
                $chglink = '/popadmin/aboutus';
            }
        }

        if ($thelink == 'licensing_active') {
            if ($bottomLinks['licensing_active'] == 'y') {
                $changeto = 'n';
                $chglink = "";
            } else {
                $changeto = 'y';
                $chglink = '/popadmin/licensinginformation';
            }
        }

        if ($thelink == 'disclosures_active') {
            if ($bottomLinks['disclosures_active'] == 'y') {
                $changeto = 'n';
                $chglink = "";
            } else {
                $changeto = 'y';
                $chglink = '/popadmin/disclosures';
            }
        }

        if ($thelink == 'privacy_active') {
            if ($bottomLinks['privacy_active'] == 'y') {
                $changeto = 'n';
                $chglink = "";
            } else {
                $changeto = 'y';
                $chglink = '/popadmin/footeroptionsprivacypolicy';
            }
        }

        if ($thelink == 'terms_active') {
            if ($bottomLinks['terms_active'] == 'y') {
                $changeto = 'n';
            } else {
                $changeto = 'y';
                $chglink = '/popadmin/termsofuse';
            }
        }

        if ($thelink == 'compliance_active') {
            if ($bottomLinks['compliance_active'] == 'y') {
                $changeto = 'n';
            } else {
                $changeto = 'y';
            }
            $chglink = "";
        }

        if ($thelink == 'license_number_active') {
            if ($bottomLinks['license_number_active'] == 'y') {
                $changeto = 'n';
            } else {
                $changeto = 'y';
            }
            $chglink = "";
        }
        if (null != $change_to) $changeto = $change_to;

        $s = "update bottom_links  set " . $thelink . " = '" . $changeto . "' ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        //debug($s);
        $this->db->query($s);
        return $changeto;
        return $thelink . "~" . $changeto . "~" . $chglink;
    }

    function getClientToken($client_id)
    {
        $s = "SELECT api_token FROM clients where client_id = " . $client_id;
        //die($s);
        $res = $this->db->fetchRow($s);
        $ret = $res['api_token'];
        return $ret;
    }

    function getLeadpopAccessToken($client_id)
    {
        $s = "SELECT lp_access_token FROM clients where client_id = " . $client_id;
        //die($s);
        $res = $this->db->fetchRow($s);
        $ret = $res['lp_access_token'];
        return $ret;
    }

    private function getHttpServer()
    {
        $s = "select http from httpclientserver limit 1 ";
        $http = $this->db->fetchOne($s);
        return $http;
    }

    private function getHttpAdminServer()
    {
        $s = "select http from httpadminserver limit 1 ";
        $http = $this->db->fetchOne($s);
        return $http;
    }

    function getGlobalPixels($client_id)
    {
        if (!is_numeric($client_id)) return false;

        $s = "SELECT group_identifier AS id, client_id, pixel_name, pixel_code, pixel_placement, pixel_type, pixel_other, pixel_action, GROUP_CONCAT(domain_id) as domains_ids ";
        $s .= " FROM leadpops_pixels WHERE client_id = " . $client_id . " AND group_identifier IS NOT NULL ";
        $s .= " GROUP BY group_identifier";
        //echo $s;

        $pixels = $this->db->fetchAll($s);
        return $pixels;
    }

    function getGlobalRecipients($client_id)
    {
        if (!is_numeric($client_id)) return false;
        $s = "SELECT recipients.group_identifier AS gid,recipients.*, text_recipients.phone_number, text_recipients.carrier, text_recipients.is_primary as auto_text_recipients_is_primary,GROUP_CONCAT(CONCAT(recipients.leadpop_vertical_id,'~',recipients.leadpop_vertical_sub_id,'~',recipients.leadpop_id,'~',recipients.leadpop_version_seq)) as fkeys";
        $s .= " FROM lp_auto_recipients recipients
				LEFT JOIN lp_auto_text_recipients text_recipients ON recipients.id = text_recipients.lp_auto_recipients_id";
        $s .= " WHERE recipients.client_id = " . $client_id . " AND recipients.group_identifier IS NOT NULL";
        $s .= " GROUP BY group_identifier ";
        //echo $s;
        /*$s .= " AND recipients.leadpop_id = " . $leadpop_id;
        $s .= " AND recipients.leadpop_type_id = " . $lp['leadpop_type_id'];
        $s .= " AND recipients.leadpop_vertical_id = " . $lp['leadpop_vertical_id'];
        $s .= " AND recipients.leadpop_vertical_sub_id = " . $lp['leadpop_vertical_sub_id'];
        $s .= " AND recipients.leadpop_template_id = " . $lp['leadpop_template_id'];
        $s .= " AND recipients.leadpop_version_id = " .  $lp['leadpop_version_id'];
        $s .= " AND recipients.leadpop_version_seq = " . $leadpop_version_seq ;*/
        $rec = $this->db->fetchAll($s);
        return $rec;


    }








    //=======================================================================================================================================================
    //=========================================================deprecated in admin3.0-----===================================================================
    //=======================================================================================================================================================




    /**
     * @deprecated deprecated in admin3.0
     * Individual Ajax replaced with common save button
     */
    function updateGlobalCompliance(Request $request)
    {

        $return_val = array("result" => false);
        if ($_POST['thelink']) {
            $sec_fot_url_active = (isset($_POST["sec_fot_url_active"]) && $_POST["sec_fot_url_active"] == "y") ? "y" : "n";
            $sec_fot_license_number_active = (isset($_POST["sec_fot_license_number_active"]) && $_POST["sec_fot_license_number_active"] == "y") ? "y" : "n";
            $compliance_text = $_POST['compliance_text'];
            $compliance_is_linked = $_POST['compliance_is_linked'];
            if (!$compliance_is_linked) {
                $compliance_is_linked = 'n';
            }
            $compliance_link = $_POST['compliance_link'];
            $license_number_text = $_POST['license_number_text'];
            $license_number_is_linked = $_POST['license_number_is_linked'];
            if (!$license_number_is_linked) {
                $license_number_is_linked = 'n';
            }
            $license_number_link = $_POST['license_number_link'];
            // Add missing http or https
            $compliance_link = $this->addScheme($compliance_link);
            $license_number_link = $this->addScheme($license_number_link);
            $f_ai_flag = $_POST["gfot_ai_flg"]; // footer active inactive change flag
            $gfot_ai_val = $_POST["gfot_ai_val"]; // footer active inactive orignal value
            $f_ai_flag1 = $_POST["gfot_ai_flg1"]; // footer active inactive change flag
            $gfot_ai_val1 = $_POST["gfot_ai_val1"]; // footer active inactive orignal value


            $client_id = $_POST['client_id'];
            $the_lnk_data = explode("~", $_POST['thelink']);
            if (is_array($the_lnk_data) && !empty($the_lnk_data)) {
                foreach ($the_lnk_data as $theselectiontype) {

                    $lplist = explode(",", $_POST['selected_funnels']);

                    //start add current Funnel key
                    $currentHash = $_POST['current_hash'];
                    $currentKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
                    if (!empty($currentKey)) {
                        array_push($lplist, $currentKey);
                    }
                    $lplist =  array_unique($lplist);
                    //end add current Funnel key




                    foreach ($lplist as $index => $lp) {
                        $lpconstt = explode("~", $lp);
                        $vertical_id = $lpconstt[0];
                        $subvertical_id = $lpconstt[1];
                        $leadpop_id = $lpconstt[2];
                        $version_seq = $lpconstt[3];
                        $active_inactive_data = array('vertical_id' => $vertical_id, 'subvertical_id' => $subvertical_id, 'leadpop_id' => $leadpop_id, 'version_seq' => $version_seq, 'client_id' => $client_id, 'thelink' => $theselectiontype);
                        switch ($theselectiontype) {
                            case 'compliance_active':
                                if ($f_ai_flag == 1) {
                                    if ($gfot_ai_val != $sec_fot_url_active) {
                                        $return_update = $this->updateFooterActiveInactive($active_inactive_data, $sec_fot_url_active);
                                    }
                                }
                                break;
                            case 'license_number_active':
                                if ($f_ai_flag1 == 1) {
                                    if ($gfot_ai_val1 != $sec_fot_license_number_active) {
                                        $return_update1 = $this->updateFooterActiveInactive($active_inactive_data, $sec_fot_license_number_active);
                                    }
                                }
                                break;
                        }

                        $s = "select * from leadpops where id = " . $leadpop_id;
                        $lpres = $this->db->fetchRow($s);
                        $leadpop_template_id = $lpres['leadpop_template_id'];
                        $leadpop_version_id = $lpres['leadpop_version_id'];
                        $leadpop_type_id = $lpres['leadpop_type_id'];

                        $s = "select * from bottom_links ";
                        $s .= " where client_id = " . $client_id;
                        $s .= " and leadpop_version_id = " . $leadpop_version_id;
                        $s .= " and leadpop_version_seq = " . $version_seq;
                        $bottomLinks = $this->db->fetchRow($s);


                        $s = "update bottom_links  set compliance_text = '" . $compliance_text . "' ";
                        $s .= " ,compliance_is_linked = '" . $compliance_is_linked . "' ";
                        $s .= " ,compliance_link = '" . $compliance_link . "' ";
                        $s .= " ,license_number_text = '" . $license_number_text . "' ";

                        $s .= " ,license_number_is_linked = '" . $license_number_is_linked . "' ";
                        $s .= " ,license_number_link = '" . $license_number_link . "' ";

                        $s .= " where client_id = " . $client_id;
                        $s .= " and leadpop_version_id = " . $leadpop_version_id;
                        $s .= " and leadpop_version_seq = " . $version_seq;
                        $this->db->query($s);
                    }

                    $s = "select * from global_settings where client_id = " . $client_id;
                    $client = $this->db->fetchRow($s);
                    switch ($theselectiontype) {
                        case 'compliance_active':
                            $table_data = array(
                                'client_id' => $client_id,
                                'sec_fot_url_active' => $sec_fot_url_active,
                                'compliance_is_linked' => $compliance_is_linked,
                                'compliance_text' => $compliance_text,
                                'compliance_link' => $compliance_link
                            );
                            break;
                        case 'license_number_active':
                            $table_data = array(
                                'client_id' => $client_id,
                                'sec_fot_license_number_active' => $sec_fot_license_number_active,
                                'license_number_is_linked' => $license_number_is_linked,
                                'license_number_text' => $license_number_text,
                                'license_number_link' => $license_number_link
                            );
                            break;
                    }
//                    if (!$client) {
//                        if (isset($table_data))
//                            $this->db->insert('global_settings', $table_data);
//                    } else {
//                        if (isset($table_data))
//                            $this->db->update('global_settings', $table_data, 'client_id = ' . $client_id);
//                    }
                }

                $return_val["result"] = true;
                if (isset($return_update)) $return_val["changeto"] = $return_update;
                if (isset($return_update1)) $return_val["changeto1"] = $return_update1;
                return $return_val;
            }
        } else {
            return $return_val;
        }
    }



    /**
     * @deprecated deprecated in admin3.0
     * Individual Ajax replaced with common save button
     */
    public function updatePrimaryFooterTogglesAdminThree($client_id, $adata)
    {

        if (!is_numeric($client_id)) return false;

        /*global privacy policy post data*/
        /* $privacy_policy_active = (isset($adata["privacy_policy_active"]) && $adata["privacy_policy_active"] == "y") ? "y" : "n";
         $terms_of_use_active = (isset($adata["terms_of_use_active"]) && $adata["terms_of_use_active"] == "y") ? "y" : "n";
         $disclosures_active = (isset($adata["disclosures_active"]) && $adata["disclosures_active"] == "y") ? "y" : "n";
         $licensing_information_active = (isset($adata["licensing_information_active"]) && $adata["licensing_information_active"] == "y") ? "y" : "n";
         $about_us_active = (isset($adata["about_us_active"]) && $adata["about_us_active"] == "y") ? "y" : "n";
         $contact_us_active = (isset($adata["contact_us_active"]) && $adata["contact_us_active"] == "y") ? "y" : "n";*/


        /*   $theselectiontype = $adata["theselectiontype"];
           $theselection = $adata["theselection"];*/
        $thelink = $adata["thelink"];
        $status = $adata["status"];


        extract($_POST, EXTR_OVERWRITE, "form_");

        $lplist = explode(",", $_POST['selected_funnels']);

        //start add current Funnel key
        $currentHash = $_POST['current_hash'];
        $currentKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        if (!empty($currentKey)) {
            array_push($lplist, $currentKey);
        }
        $lplist =  array_unique($lplist);
        //end add current Funnel key


        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $vertical_id = $lpconstt[0];
            $subvertical_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $version_seq = $lpconstt[3];

            $active_inactive_data = array('vertical_id' => $vertical_id, 'subvertical_id' => $subvertical_id, 'leadpop_id' => $leadpop_id, 'version_seq' => $version_seq, 'client_id' => $client_id, 'thelink' => $thelink);

            switch ($thelink) {
                case 'privacy_active':
                    $this->updateFooterActiveInactive($active_inactive_data, $adata["status"]);
                    break;
                case 'terms_active':
                    $this->updateFooterActiveInactive($active_inactive_data, $adata["status"]);
                    break;
                case 'disclosures_active':
                    $this->updateFooterActiveInactive($active_inactive_data, $adata["status"]);
                    break;
                case 'licensing_active':
                    $this->updateFooterActiveInactive($active_inactive_data, $adata["status"]);
                    break;
                case 'about_active':
                    $this->updateFooterActiveInactive($active_inactive_data, $adata["status"]);
                    break;
                case 'contact_active':
                    $this->updateFooterActiveInactive($active_inactive_data, $adata["status"]);
                    break;
            }


        }
        $s = "select * from global_settings where client_id = " . $client_id;
        $client = $this->db->fetchRow($s);
        switch ($thelink) {
            case 'privacy_active':
                $table_data = array(
                    'client_id' => $client_id,
                    'privacy_policy_active' => $status
                );
                break;
            case 'terms_active':
                $table_data = array(
                    'client_id' => $client_id,
                    'terms_of_use_active' => $status
                );
                break;
            case 'disclosures_active':
                $table_data = array(
                    'client_id' => $client_id,
                    'disclosures_active' => $status,
                );
                break;
            case 'licensing_active':
                $table_data = array(
                    'client_id' => $client_id,
                    'licensing_information_active' => $status,
                );
                break;
            case 'about_active':
                $table_data = array(
                    'client_id' => $client_id,
                    'about_us_active' => $status,
                );
                break;
            case 'contact_active':
                $table_data = array(
                    'client_id' => $client_id,
                    'contact_us_active' => $status,
                );
                break;
        }
//        if (!$client) {
//            if (isset($table_data))
//                $this->db->insert('global_settings', $table_data);
//        } else {
//            if (isset($table_data))
//                $this->db->update('global_settings', $table_data, 'client_id = ' . $client_id);
//        }

        return true;
    }



}

