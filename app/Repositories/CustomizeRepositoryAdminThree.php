<?php
/**
 * Created by PhpStorm.
 * User: Jazib
 * Date: 13/11/2019
 * Time: 4:35 AM
 */

/**
 * Code Migrated from Zend to Laravel  ==>  CustomizeRepository --> Source: Default_Model_Customize (Customize.php)
 */

namespace App\Repositories;


use App\Helpers\Query;
use Log;
use Session;
use Exception;
use Carbon\Carbon;
use App\Models\Clients;
use App\Models\Leadpops;
use App\Services\Client;
use App\Services\DbService;
use Illuminate\Http\Request;
use App\Services\DataRegistry;
use App\Constants\FunnelVariables;
use App\Helpers\Utils;
use App\Models\AutoResponderOption;
use App\Repositories\LpAdminRepository;
use App\Services\gm_process\MyLeadsEvents;
use LP_Helper;

class CustomizeRepositoryAdminThree
{
    private $db;
    protected static $leadpopDomainTypeId = 0;

    private $MAX_W = 190;
    private $MAX_H = 90;
    private $PAD = 10;

    public function __construct(DbService $service)
    {
        self::$leadpopDomainTypeId = config('leadpops.leadpopDomainTypeId');
        $this->db = $service;
    }

    public function getHttpServer()
    {
        $s = "select http from httpclientserver limit 1 ";
        $http = $this->db->fetchOne($s);
        return $http;
    }

    private function _getCdnLink()
    {
        $registry = DataRegistry::getInstance();
        $client_base_url = $registry->leadpops->clientInfo['rackspace_image_base'];
        if (substr("testers", -1) === "/") $client_base_url = substr($client_base_url, 0, -1);
        return $client_base_url;
    }


    public function updateTotalExpert($client_id, $status)
    {
        $newstatus = ($status == "active" ? 1 : 0);

        $s = "update totalexpert ";
        $s .= " set active = " . $newstatus;
        $s .= " where client_id = " . $client_id;
        $this->db->query($s);
        return true;
    }

    public function deleteTotalExpert($client_id)
    {
        $s = "delete from totalexpert ";
        $s .= " where client_id = " . $client_id;
        $this->db->query($s);
        return true;
    }

    public function deleteHomebot($client_id)
    {
        $s = "delete from homebot ";
        $s .= " where client_id = " . $client_id;
        $this->db->query($s);
        return true;
    }

    function setClientTrainingSetting($client_id)
    {
        $complete = $_POST["complete"];
        $itemid = $_POST["itemid"];
        $vertical = $_POST["vertical"];
        $vertical_data = $this->getDataByVerticalTraning($client_id, $vertical);
        $vertical_data[$itemid] = $complete;
        $this->storeClientTrainingSetting($client_id, $vertical, json_encode($vertical_data));
        return true;
        //debug($vertical_data);
        return json_encode($vertical_data);
        return json_encode(array("complete" => $complete, "itemid" => $itemid, "vertical" => $vertical, "client_id" => $client_id));
    }

    function storeClientTrainingSetting($client_id, $vertical, $params)
    {
        $query = "select params from client_training_setting where client_id=" . $client_id . " and vertical_id=" . $vertical . " limit 1";
        $clientset = $this->db->fetchRow($query);
        $table_data = array(
            'client_id' => $client_id,
            'vertical_id' => $vertical,
            'params' => $params
        );
        if (!$clientset) {
            $this->db->insert('client_training_setting', $table_data);
        } else {
            $this->db->update('client_training_setting', $table_data, 'client_id = ' . $client_id . ' and vertical_id=' . $vertical);
        }
        return true;
    }

    function getDataByVerticalTraning($client_id, $vertical)
    {
        $query = "select params from client_training_setting where client_id=" . $client_id . " and vertical_id=" . $vertical . " limit 1";
        $jsondata = $this->db->fetchRow($query);
        //$data = json_decode('[{"12":0,"13":"1","14":0,"15":0,"16":0,"17":0}]');
        if (empty($jsondata)) {
            $query = "select id from helper_vertical_items where vertical_id=" . $vertical;
            $data1 = $this->db->fetchAll($query);
            if (!empty($data1)) {
                $key = array();
                foreach ($data1 as $d) {
                    if (!isset($key[$d["id"]])) $key[$d["id"]] = 0;
                }
                $data = $key;
            }
        } else {
            $data = json_decode($jsondata["params"], true);
        }
        return $data;
    }

    function updateAutoresponderFlag()
    {
        $vertical_id = $_POST['vertical_id'];
        $subvertical_id = $_POST['subvertical_id'];
        $leadpop_id = $_POST['leadpop_id'];
        $version_seq = $_POST['version_seq'];
        $client_id = $_POST['client_id'];
        $thelink = $_POST['thelink'];
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select * from autoresponder_options ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $autoresponder = $this->db->fetchRow($s);

        if ($thelink == 'html_active') {
            if ($autoresponder['html_active'] == 'y') {
                $changeto = 'n';
            } else {
                $changeto = 'y';
            }
        }


        if ($thelink == 'text_active') {
            if ($autoresponder['text_active'] == 'y') {
                $changeto = 'n';
            } else {
                $changeto = 'y';
            }
        }
        /*if($active_value!=""){
		    $active = $active_value;
		}else{
		}*/
        if ($autoresponder['active'] == 'y') {
            $active = 'n';
        } else {
            $active = 'y';
        }


        $s = "update autoresponder_options set  html_active = 'n' , text_active = 'n'  ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);
        //var_dump($thelink." ".$changeto." ".$active);

        $s = "update autoresponder_options  set " . $thelink . " = '" . $changeto . "' , active = '" . $active . "' ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        if ($this->db->query($s)) {
            //print($s);
            return $thelink . "~" . $changeto . "~" . $active;
        }
    }

    function getLogoProminentColor($logopath)
    {
        $logo_color = "";
        $client = new Client();
        if (env('APP_ENV') !== config('app.env_production')) {
            \Log::channel('myleads')->info($logopath);
        }
        $gis = getimagesize($logopath);
        $ow = $gis[0];
        $oh = $gis[1];
        $type = $gis[2];
        switch ($type) {
            case "1":
                $im = imagecreatefromgif($logopath);
                $image = $client->loadGif($logopath);
                $logo_color = $image->extract();
                break;
            case "2":
                $im = imagecreatefromjpeg($logopath);
                $image = $client->loadJpeg($logopath);
                $logo_color = $image->extract();
                break;
            case "3":
                $im = imagecreatefrompng($logopath);
                $image = $client->loadPng($logopath);
                $logo_color = $image->extract();
                break;
            default:
                $im = imagecreatefromjpeg($logopath);
        }
        return $logo_color;
    }

    function updateSubmission($client_id, $funnel_data, $the_link)
    {
        $vertical_id = $funnel_data["funnel"]["leadpop_vertical_id"];
        $subvertical_id = $funnel_data["funnel"]["leadpop_vertical_sub_id"];
        $leadpop_id = $funnel_data["funnel"]["leadpop_id"];
        $version_seq = $funnel_data["funnel"]["leadpop_version_seq"];
        $client_id = $client_id;
        $thelink = $the_link;
        /*var_dump($vertical_id);
			var_dump($subvertical_id);
			var_dump($leadpop_id);
			var_dump($version_seq);
			var_dump($client_id);
			var_dump($thelink);*/
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select * from submission_options ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $submission = $this->db->fetchRow($s);

        if ($thelink == 'thankyou_active') {
            if ($submission['thankyou_active'] == 'y') {
                $changeto = 'n';
            } else {
                $changeto = 'y';
            }
        }

        if ($thelink == 'information_active') {
            if ($submission['information_active'] == 'y') {
                $changeto = 'n';
            } else {
                $changeto = 'y';
            }
        }

        if ($thelink == 'thirdparty_active') {
            if ($submission['thirdparty_active'] == 'y') {
                $changeto = 'n';
            } else {
                $changeto = 'y';
            }
        }

        $s = "update submission_options  set  thirdparty_active = 'n' , information_active = 'n', thankyou_active = 'n' ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);

        $s = "update submission_options  set " . $thelink . " = '" . $changeto . "' ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);
        /*var_dump($s);
			exit;*/
        return $thelink . "~" . $changeto;
    }

    /**
     * @since 2.1.0 - CR-Funnel-Builder: Removed leadpops_templates_placeholders_values -> placeholder_sixtynine
     *
     * @param $client_id
     * @param $post
     * @param array $funnel_data
     */
    public function updateBackgroundColors($client_id, $post, $funnel_data = array())
    {
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
            if ($post['background_type'] != "") {
                $background_type = $post['background_type'];
            } else {
                $background_type = '1';
            }

        } else {
            // get keys from registry
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
            $verticalName = strtolower($registry->leadpops->customVertical);
            $subverticalName = strtolower($registry->leadpops->customSubvertical);

        }

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        // get swatches for current page in case need to add for
        if (env('APP_ENV') === config('app.env_local')) {
            $leadpop_background_swatches = 'leadpop_background_swatches';
        } else {
            $leadpop_background_swatches = getPartition($client_id, "leadpop_background_swatches");
        }
        $s = "select swatch,is_primary from " . $leadpop_background_swatches;
        $s .= " where client_id = " . $client_id;
//        $s .= " and leadpop_vertical_id = " . $vertical_id;
//        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//        $s .= " and leadpop_type_id = " . $leadpop_type_id;
//        $s .= " and leadpop_template_id = " . $leadpop_template_id;
//        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $s .= " order by id ";
        $currentSwatches = $this->db->fetchAll($s);

        $background = urldecode($post["background"]); // background=/*###>*/background-color: #8795a9;/*@@@*/ background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIHZpZXdCb3g9IjAgMCAxIDEiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjxsaW5lYXJHcmFkaWVudCBpZD0idnNnZyIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiIHgxPSIwJSIgeTE9IjAlIiB4Mj0iMCUiIHkyPSIxMDAlIj48c3RvcCBzdG9wLWNvbG9yPSIjODc5NWE5IiBzdG9wLW9wYWNpdHk9IjEiIG9mZnNldD0iMCIvPjxzdG9wIHN0b3AtY29sb3I9IiM4Nzk1YTkiIHN0b3Atb3BhY2l0eT0iMSIgb2Zmc2V0PSIxIi8+PC9saW5lYXJHcmFkaWVudD48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMSIgaGVpZ2h0PSIxIiBmaWxsPSJ1cmwoI3ZzZ2cpIiAvPjwvc3ZnPg==); /* IE9, iOS 3.2+ */ background-image: -webkit-gradient(linear, 0% 0%, 0% 100%,color-stop(0, rgb(135, 149, 169)),color-stop(1, rgb(135, 149, 169))); /*Old Webkit*/ background-image: -webkit-linear-gradient(top,rgb(135, 149, 169) 0%,rgb(135, 149, 169) 100%); /* Android 2.3 */ background-image: -ms-linear-gradient(top,rgb(135, 149, 169) 0%,rgb(135, 149, 169) 100%); /* IE10+ */ background-image: linear-gradient(to bottom,rgb(135, 149, 169) 0%,rgb(135, 149, 169) 100%); /* W3C */ /* IE8- CSS hack */ @media \0screen\,screen\9 { .gradient { filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ff8795a9",endColorstr="#ff8795a9",GradientType=0); } }
        $gradient = urldecode($post["gradient"]); //border-radius: 5px; border: 2px solid rgb(0, 0, 0); display: block; z-index: 5000; width: 744px; height: 390px; position: absolute; left: 16px; top: 136px; background-image: linear-gradient(to bottom, rgb(135, 149, 169) 0%, rgb(135, 149, 169) 100%);
        $fontcolor = $post["fontcolor"];
        $range = $post["range"]; //domain,all,vertical,subvertical
        $swatch_arr = explode("-", $post["swatchnumber"]);
        $swatchnumber = end($swatch_arr);  // like "swatchnumber-22"
        // post variables
        if ($range == "thedomain") {
            if (env('APP_ENV') === config('app.env_local')) {
                $leadpop_background_swatches = 'leadpop_background_swatches';
            } else {
                $leadpop_background_swatches = getPartition($client_id, "leadpop_background_swatches");
            }
            $s = "delete from " . $leadpop_background_swatches;
            $s .= " where client_id = " . $client_id;
//            $s .= " and leadpop_vertical_id = " . $vertical_id;
//            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//            $s .= " and leadpop_type_id = " . $leadpop_type_id;
//            $s .= " and leadpop_template_id = " . $leadpop_template_id;
//            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            $this->db->query($s);


            $s = " select * from leadpop_background_color where client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            //$s .= " and active_backgroundimage = 'y'";
            $_count = $this->db->fetchAll($s);

            if ($_count) {
                // Update background color for first swatch.
                $s = "update leadpop_background_color set background_color = '" . addslashes($background) . "',active_backgroundimage='n',background_type='1' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query($s);
            } else {
                $s = "delete from leadpop_background_color ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query($s);


                // update the font-color
                $s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
                $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,background_type,";
                $s .= "background_color,active_backgroundimage,active,default_changed) values (null,";
                $s .= $client_id . "," . $vertical_id . ",";
                $s .= $subvertical_id . ",";
                $s .= $leadpop_type_id . "," . $leadpop_template_id . ",";
                $s .= $leadpop_id . ",";
                $s .= $leadpop_version_id . ",";
                $s .= $version_seq . ",";
                $s .= $background_type . ",";
                $s .= "'" . addslashes($background) . "','n','y','y')";
                $this->db->query($s);
            }

            // update the font-color
            $sixnine = $this->getLeadLine($client_id, $leadpop_id, $version_seq, FunnelVariables::LEAD_LINE);
            if ($sixnine != "") {
                $sixnine = str_replace(';;', ';', $sixnine);
                $sixnine = str_replace(': #', ':#', $sixnine);
                $first = strpos($sixnine, 'color:#');
                $first += 6;
                $sec = strpos($sixnine, '>', $first);
                $sec -= 1;
                $toreplace = substr($sixnine, $first, ($sec - $first));
                $sixnine = str_replace($toreplace, $fontcolor, $sixnine);

                $this->updateLeadLine(FunnelVariables::LEAD_LINE, $sixnine, $client_id, $leadpop_id, $version_seq);
            }

            $logo_color = $fontcolor;


            $s = "select count(*) as cnt from leadpop_logos where  client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id  = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            $s .= " and use_default = 'y' ";

            $usingDefaultLogo = $this->db->fetchOne($s); // one == using default logo, zero equals uploaded a  logo

            if ($usingDefaultLogo == 1) {
                $filename1 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-favicon-circle.png";
                $filename2 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-dot-img.png";
                $filename3 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-ring.png";
                $filename4 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-mvp-check.png";

                // For Production
                $favicon_location = rackspace_stock_assets() . "images/" . $filename1;
                $image_location = rackspace_stock_assets() . "images/" . $filename2;
                $mvp_dot_location = rackspace_stock_assets() . "images/" . $filename3;
                $mvp_check_location = rackspace_stock_assets() . "images/" . $filename4;

                $filename1 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-" . $version_seq . "-favicon-circle.png";
                $filename2 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-" . $version_seq . "-dot-img.png";
                $filename3 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-" . $version_seq . "-ring.png";
                $filename4 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-" . $version_seq . "-mvp-check.png";

                $favicon_dst_src = rackspace_stock_assets() . "images/default/" . $filename1;
                $colored_dot_src = rackspace_stock_assets() . "images/default/" . $filename2;
                $mvp_dot_src = rackspace_stock_assets() . "images/default/" . $filename3;
                $mvp_check_src = rackspace_stock_assets() . "images/default/" . $filename4;

                if (isset($logo_color) && $logo_color != "") {
                    $new_clr = $this->hex2rgb($logo_color);
                }
                $im = imagecreatefrompng($image_location);
                $myRed = $new_clr[0];
                $myGreen = $new_clr[1];
                $myBlue = $new_clr[2];

                $this->colorizeBasedOnAplhaChannnel($image_location, $myRed, $myGreen, $myBlue, $colored_dot_src);
                $this->colorizeBasedOnAplhaChannnel($favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src);
                $this->colorizeBasedOnAplhaChannnel($mvp_dot_location, $myRed, $myGreen, $myBlue, $mvp_dot_src);
                $this->colorizeBasedOnAplhaChannnel($mvp_check_location, $myRed, $myGreen, $myBlue, $mvp_check_src);

                $favicon_dst = $this->getHttpServer() . '/images/' . $filename1;
                $colored_dot = $this->getHttpServer() . 'images/' . $filename2;
                $mvp_dot = $this->getHttpServer() . 'images/' . $filename3;
                $mvp_check = $this->getHttpServer() . 'images/' . $filename4;

                $design_variables = array();
                $design_variables[FunnelVariables::LOGO_COLOR] = $logo_color;
                $design_variables[FunnelVariables::COLORED_DOT] = $colored_dot;
                $design_variables[FunnelVariables::MVP_DOT] = $mvp_dot;
                $design_variables[FunnelVariables::MVP_CHECK] = $mvp_check;
                $design_variables[FunnelVariables::FAVICON_DST] = $favicon_dst;
                $this->updateFunnelVariables($design_variables, $client_id, $leadpop_id, $version_seq);

                $s = "update leadpop_logos set default_colored = 'y' , logo_color = '" . $logo_color . "' where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id  = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $s .= " and use_default = 'y' ";
                $this->db->query($s);

            } else {
                if ($currentSwatches) {
                    for ($j = 0; $j < count($currentSwatches); $j++) {
                        $s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
                        $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                        $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
                        $s .= "swatch,is_primary,active) values (null,";
                        $s .= $client_id . "," . $vertical_id . ",";
                        $s .= $subvertical_id . ",";
                        $s .= $leadpop_type_id . "," . $leadpop_template_id . ",";
                        $s .= $leadpop_id . ",";
                        $s .= $leadpop_version_id . ",";
                        $s .= $version_seq . ",";
                        $s .= "'" . addslashes($currentSwatches[$j]["swatch"]) . "',";
                        if ($j == $swatchnumber) {
                            $s .= "'y','y')";
                        } else {
                            $s .= "'n','y')";
                        }
                        $this->db->query($s);
                    }
                }
                $filename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq);

                $favicon_location = rackspace_stock_assets() . "images/favicon-circle.png";
                $image_location = rackspace_stock_assets() . "images/dot-img.png";
                $mvp_dot_location = rackspace_stock_assets() . "images/ring.png";
                $mvp_check_location = rackspace_stock_assets() . "images/mvp-check.png";


                $favicon_dst_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_favicon-circle.png';
                $colored_dot_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_dot_img.png';
                $mvp_dot_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_ring.png';
                $mvp_check_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_mvp-check.png';

                if (isset($logo_color) && $logo_color != "") {
                    $new_clr = $this->hex2rgb($logo_color);
                }
                $myRed = $new_clr[0];
                $myGreen = $new_clr[1];
                $myBlue = $new_clr[2];

                $this->colorizeBasedOnAplhaChannnel($image_location, $myRed, $myGreen, $myBlue, $colored_dot_src);
                $this->colorizeBasedOnAplhaChannnel($favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src);
                $this->colorizeBasedOnAplhaChannnel($mvp_dot_location, $myRed, $myGreen, $myBlue, $mvp_dot_src);
                $this->colorizeBasedOnAplhaChannnel($mvp_check_location, $myRed, $myGreen, $myBlue, $mvp_check_src);

                $colored_dot = getCdnLink() . '/logos/' . $filename . '_dot_img.png';
                $favicon_dst = getCdnLink() . '/logos/' . $filename . '_favicon-circle.png';
                $mvp_dot = getCdnLink() . '/logos/' . $filename . '_ring.png';
                $mvp_check = getCdnLink() . '/logos/' . $filename . '_mvp-check.png';

                $design_variables = array();
                $design_variables[FunnelVariables::LOGO_COLOR] = $logo_color;
                $design_variables[FunnelVariables::COLORED_DOT] = $colored_dot;
                $design_variables[FunnelVariables::MVP_DOT] = $mvp_dot;
                $design_variables[FunnelVariables::MVP_CHECK] = $mvp_check;
                $design_variables[FunnelVariables::FAVICON_DST] = $favicon_dst;
                $this->updateFunnelVariables($design_variables, $client_id, $leadpop_id, $version_seq);

                $s = "update leadpop_logos set logo_color = '" . $logo_color . "' where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id  = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $s .= " and use_me = 'y' ";
                $this->db->query($s);

            }
        }

    }


    /**
     * @deprecated
     */
    public function updateBackgroundCustomColors($client_id, $post, $funnel_data = array())
    {
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
            if ($post['background_type'] != "") {
                $background_type = $post['background_type'];
            } else {
                $background_type = '1';
            }

        } else {
            // get keys from registry
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
            $verticalName = strtolower($registry->leadpops->customVertical);
            $subverticalName = strtolower($registry->leadpops->customSubvertical);

        }
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        list($r, $g, $b) = $this->hex2rgb($post["fontcolor"]);
        $background = "/*###>*/background-color: rgba($r, $g, $b, 1);/*@@@*/background-image: linear-gradient(to right bottom,rgba($r, $g, $b, 1) 0%,rgba($r, $g, $b, 1) 100%); /* W3C */";

        $fontcolor = $post["fontcolor"];
        $range = $post["range"]; //domain,all,vertical,subvertical

        // post variables
        if ($range == "thedomain") {

            $s = "delete from leadpop_background_color ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;

            $this->db->query($s);

            // update the font-color
            $s = "select id from leadpops_templates_placeholders ";
            $s .= " where leadpop_template_id = " . $leadpop_template_id;
            $s .= " and client_id = " . $client_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            $leadpops_templates_placeholders = $this->db->fetchAll($s);

            for ($xx = 0; $xx < count($leadpops_templates_placeholders); $xx++) {
                $s = "select placeholder_sixtynine from leadpops_templates_placeholders_values ";
                $s .= "where leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'] . " limit 1";
                $place = $this->db->fetchAll($s);
                if ($place) {
                    $sixnine = $place[0]["placeholder_sixtynine"];
                    $sixnine = str_replace(';;', ';', $sixnine);
                    $sixnine = str_replace(': #', ':#', $sixnine);
                    $first = strpos($sixnine, 'color:#');
                    $first += 6;
                    $sec = strpos($sixnine, '>', $first);
                    $sec -= 1;
                    $toreplace = substr($sixnine, $first, ($sec - $first));
                    $sixnine = str_replace($toreplace, $fontcolor, $sixnine);

                    $s = "update leadpops_templates_placeholders_values ";
                    $s .= " set placeholder_sixtynine= '" . addslashes($sixnine) . "'  ";
                    $s .= " where  leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
                    $this->db->query($s);
                }
            }
            // update the font-color

            $s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
            $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
            $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,background_type,";
            $s .= "background_color,active,default_changed,background_custom_color) values (null,";
            $s .= $client_id . "," . $vertical_id . ",";
            $s .= $subvertical_id . ",";
            $s .= $leadpop_type_id . "," . $leadpop_template_id . ",";
            $s .= $leadpop_id . ",";
            $s .= $leadpop_version_id . ",";
            $s .= $version_seq . ",";
            $s .= $background_type . ",";
            $s .= "'" . addslashes($background) . "','y','y','$fontcolor')";
            $this->db->query($s);

            $logo_color = $fontcolor;

            {
                $filename1 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-favicon-circle.png";
                $filename2 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-dot-img.png";
                $filename3 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-ring.png";
                $filename4 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-mvp-check.png";

                // For Production
                $favicon_location = rackspace_stock_assets() . "images/" . $filename1;
                $image_location = rackspace_stock_assets() . "images/" . $filename2;
                $mvp_dot_location = rackspace_stock_assets() . "images/" . $filename3;
                $mvp_check_location = rackspace_stock_assets() . "images/" . $filename4;

                // $favicon_location = rackspace_stock_assets()."images/".$filename1;
                // $image_location = rackspace_stock_assets()."images/".$filename2;

                $filename1 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-" . $version_seq . "-favicon-circle.png";
                $filename2 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-" . $version_seq . "-dot-img.png";
                $filename3 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-" . $version_seq . "-ring.png";
                $filename4 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-" . $version_seq . "-mvp-check.png";

                $favicon_dst_src = rackspace_stock_assets() . "images/default/" . $filename1;
                $colored_dot_src = rackspace_stock_assets() . "images/default/" . $filename2;
                $mvp_dot_src = rackspace_stock_assets() . "images/default/" . $filename3;
                $mvp_check_src = rackspace_stock_assets() . "images/default/" . $filename4;

                // $favicon_dst_src = rackspace_stock_assets()."images/default/".$filename1;
                // $colored_dot_src = rackspace_stock_assets()."images/default/".$filename2;

                if (isset($logo_color) && $logo_color != "") {
                    $new_clr = $this->hex2rgb($logo_color);
                }
                $im = imagecreatefrompng($image_location);
                $myRed = $new_clr[0];
                $myGreen = $new_clr[1];
                $myBlue = $new_clr[2];

                $this->colorizeBasedOnAplhaChannnel($image_location, $myRed, $myGreen, $myBlue, $colored_dot_src);
                $this->colorizeBasedOnAplhaChannnel($favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src);
                $this->colorizeBasedOnAplhaChannnel($mvp_dot_location, $myRed, $myGreen, $myBlue, $mvp_dot_src);
                $this->colorizeBasedOnAplhaChannnel($mvp_check_location, $myRed, $myGreen, $myBlue, $mvp_check_src);

                $favicon_dst = $this->getHttpServer() . '/images/' . $filename1;
                $colored_dot = $this->getHttpServer() . 'images/' . $filename2;
                $mvp_dot = $this->getHttpServer() . 'images/' . $filename3;
                $mvp_check = $this->getHttpServer() . 'images/' . $filename4;

                for ($i = 0; $i < count($leadpops_templates_placeholders); $i++) {
                    $s = " update leadpops_templates_placeholders_values  set  placeholder_eightyone = '" . $logo_color . "' , placeholder_eightytwo = '" . $colored_dot . "',placeholder_seventynine = '" . $mvp_dot . "' ,placeholder_eighty = '" . $mvp_check . "', placeholder_eightythree = '" . $favicon_dst . "'  where client_leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
                    $this->db->query($s);
                }

                $s = "update leadpop_logos set default_colored = 'y' , logo_color = '" . $logo_color . "' where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id  = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $s .= " and use_default = 'y' ";
                $this->db->query($s);

            }

        }

    }

    public function insertWhiteColor($client_id, $funnel_data = array())
    {
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $str0 = "linear-gradient(to bottom, rgba(255,255,255,1.0) 0%,rgba(255,255,255,1.0) 100%)";

        $s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
        $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
        $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
        $s .= "swatch,is_primary,active) values (null,";
        $s .= $client_id . "," . $vertical_id . ",";
        $s .= $subvertical_id . ",";
        $s .= $leadpop_type_id . "," . $leadpop_template_id . ",";
        $s .= $leadpop_id . ",";
        $s .= $leadpop_version_id . ",";
        $s .= $version_seq . ",";
        $s .= "'" . addslashes($str0) . "',";
        $s .= "'n','y')";
        $this->db->query($s);

        // after inserting the white swatch set the first one to primary
        if (env('APP_ENV') === config('app.env_local')) {
            $leadpop_background_swatches = 'leadpop_background_swatches';
        } else {
            $leadpop_background_swatches = getPartition($client_id, "leadpop_background_swatches");
        }
        $s = "select id from " . $leadpop_background_swatches;
        $s .= " where  client_id 	= " . $client_id;
//        $s .= " and leadpop_vertical_id = " . $vertical_id;
//        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//        $s .= " and leadpop_type_id = " . $leadpop_type_id;
//        $s .= " and leadpop_template_id = " . $leadpop_template_id;
//        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_version_id  	= " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $s .= " order by id limit 1 ";
        $swRow = $this->db->fetchRow($s);
        $s = "update leadpop_background_swatches set is_primary = 'y' where id = " . $swRow["id"];
        $this->db->query($s);

    }

    public function insertSwatchColor($client_id, $post, $funnel_data = array())
    {
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }


        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        if ($post["first"] = 1) {
            $str0 = "linear-gradient(to bottom, rgba(" . $post["red"] . "," . $post["green"] . "," . $post["blue"] . ",1.0) 0%,rgba(" . $post["red"] . "," . $post["green"] . "," . $post["blue"] . ",1.0) 100%)";
        } else {
            $str0 = "linear-gradient(to bottom, rgba(" . $post["red"] . "," . $post["green"] . "," . $post["blue"] . ",1.0) 0%,rgba(" . $post["red"] . "," . $post["green"] . "," . $post["blue"] . ",.7) 100%)";
        }


        $str1 = "linear-gradient(to top, rgba(" . $post["red"] . "," . $post["green"] . "," . $post["blue"] . ",1.0) 0%,rgba(" . $post["red"] . "," . $post["green"] . "," . $post["blue"] . ",.7) 100%)";
        $str2 = "linear-gradient(to bottom right, rgba(" . $post["red"] . "," . $post["green"] . "," . $post["blue"] . ",1.0) 0%,rgba(" . $post["red"] . "," . $post["green"] . "," . $post["blue"] . ",.7) 100%)";
        $str3 = "linear-gradient(to bottom, rgba(" . $post["red"] . "," . $post["green"] . "," . $post["blue"] . ",1.0) 0%,rgba(" . $post["red"] . "," . $post["green"] . "," . $post["blue"] . ",1.0) 100%)";
        $swatches = array($str0, $str1, $str2, $str3);
        for ($i = 0; $i < 4; $i++) {
            $s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
            $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
            $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
            $s .= "swatch,is_primary,active) values (null,";
            $s .= $client_id . "," . $vertical_id . ",";
            $s .= $subvertical_id . ",";
            $s .= $leadpop_type_id . "," . $leadpop_template_id . ",";
            $s .= $leadpop_id . ",";
            $s .= $leadpop_version_id . ",";
            $s .= $version_seq . ",";
            $s .= "'" . addslashes($swatches[$i]) . "',";
            $s .= "'n','y')";
//					die($s);
            $this->db->query($s);
        }
    }

    public function getInitialSwatches($client_id, $funnel_data = array())
    {
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }

        $logoDefaultOrClient = "";
        $needToGenerateSwatches = "";

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select * from leadpop_logos where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $logos = $this->db->fetchAll($s);

        for ($i = 0; $i < count($logos); $i++) {
            if ($logos[$i]['use_default'] == 'y') {
                $logoDefaultOrClient = "default"; // using default logo
                break;
            }
            if ($logos[$i]['use_me'] == 'y') { // uploaded a logo
                $logoDefaultOrClient = "client";
                break;
            }
        }
        if ($logoDefaultOrClient == 'client') {
            if (env('APP_ENV') === config('app.env_local')) {
                $leadpop_background_swatches = 'leadpop_background_swatches';
            } else {
                $leadpop_background_swatches = getPartition($client_id, "leadpop_background_swatches");
            }
            $s = "select * from " . $leadpop_background_swatches;
            $s .= " where  client_id 	= " . $client_id;
//            $s .= " and leadpop_vertical_id = " . $vertical_id;
//            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//            $s .= " and leadpop_type_id = " . $leadpop_type_id;
//            $s .= " and leadpop_template_id = " . $leadpop_template_id;
//            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_version_id  	= " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            $s .= " order by is_primary desc "; // first one will be primary
            if (@$_COOKIE['swtaches'] == 1) {
                die($s);
            }
            $sw = $this->db->fetchAll($s);

            $s = "select background_color from leadpop_background_color ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;

            $background_color = $this->getSelectedBgColor($this->db->fetchOne($s));

            // exceptional case: if entry is missing in database then set default
            #if($background_color === false){
            #    $background_color = $this->getSelectedBgColor(\LP_Helper::getInstance()->default_background_color()['background_color']);
            #}
        }
        if ($logoDefaultOrClient == "default") { // no rows in leadpop_background_swatches & using default logo
            $s = "select * from default_swatches where active = 'y' order by id desc";
            $sw = $this->db->fetchAll($s);
            //$background_color = "/*###>*/background-color: rgba(176, 42, 50, 1);/*@@@*/
            //background-image: linear-gradient(to bottom, rgba(171,179,182,1.0) 0%,rgba(171,179,182,1.0) 100%); /* W3C */";
            //$background_color = $this->getSelectedBgColor($background_color);

            $s = "select background_color from leadpop_background_color ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;

            $background_color = $this->getSelectedBgColor($this->db->fetchOne($s));
        }

        // exceptional case: if entry is missing in database then set default
        if ($background_color === false || $background_color === "" || empty($background_color)) {
            $background_color = $this->getSelectedBgColor(\LP_Helper::getInstance()->default_background_color()['background_color']);
        }

        $retsw = array($background_color);
        if ($sw) {
            for ($i = 0; $i < count($sw); $i++) {
                $retsw[] = $sw[$i]["swatch"];
            }
        }
        if (@$_COOKIE['json_swtaches'] == 1) {
            echo json_encode($retsw);
        }
        return json_encode($retsw);
    }

    // MN
    public function determineLogoUseAndNeedCreateSwatches($client_id, $funnel_data = array())
    {
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }


        $logoDefaultOrClient = "";
        $needToGenerateSwatches = "";

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select * from leadpop_logos where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $logos = $this->db->fetchAll($s); // logo_src
        $logoname = "";
        if ($logos) {
            for ($i = 0; $i < count($logos); $i++) {
                if ($logos[$i]['use_default'] == 'y') {
                    $logoDefaultOrClient = "default";
                    $logoname = $logos[$i]['logo_src'];
                    break;
                }
                if ($logos[$i]['use_me'] == 'y') {
                    $logoDefaultOrClient = "client";
                    $logoname = $logos[$i]['logo_src'];
                    break;
                }
            }
        }

        /* is there a row in the current_logo table? inserted upon trial signup ... need to cover for older clients */

        $s = "select count(*) as cnt  from current_logo  ";
        $s .= " where  client_id 	= " . $client_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_version_id  	= " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq . " limit 1 ";
        $exists = $this->db->fetchOne($s);
        // if no row then insert and also need to generate if NOT default
        if ($exists == 0) {
// insert into current_logo (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,leadpop_version_seq,logo_src) values (null,587,22,1,3,8,11,11,,'587_22_1_3_8_11_11_1_templatemockupinnerpage.jpg' )
            $s = "insert into current_logo (id,client_id,leadpop_id,leadpop_type_id,";
            $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
            $s .= "leadpop_version_id,leadpop_version_seq,logo_src) values (null,";
            $s .= $client_id . "," . $leadpop_id . "," . $leadpop_type_id . "," . $vertical_id . "," . $subvertical_id . ",";
            $s .= $leadpop_template_id . "," . $leadpop_version_id . "," . $version_seq . ",";
            $s .= "'" . $logoname . "' ) ";
            $this->db->query($s);
        }
        /* is there a rows in the current_logo table? inserted upon trial signup ... need to cover for older clients */
        if ($logoDefaultOrClient == "default") {
            $needToGenerateSwatches = "no";
        } else if ($logoDefaultOrClient == "client") {
            $s = "select count(*) as cnt  from current_logo  ";
            $s .= " where  client_id 	= " . $client_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_version_id  	= " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq . "  ";
            $s .= " and logo_src = '" . $logoname . "'  limit 1 ";
            $samelogo = $this->db->fetchOne($s);
            // if logo name in current_logo != logo name in leadpops_logo then need to regenerate color swatches
            if ($samelogo != 0) {
                $needToGenerateSwatches = "no";
            } else { // need to update the table with new logo_src value
                $needToGenerateSwatches = "yes";
                $s = " update current_logo  set logo_src = '" . $logoname . "' ";
                $s .= " where  client_id 	= " . $client_id;
                $s .= " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_version_id  	= " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq . " limit 1 ";
                $this->db->query($s);

                // need to delete old background swatches
                if (env('APP_ENV') === config('app.env_local')) {
                    $leadpop_background_swatches = 'leadpop_background_swatches';
                } else {
                    $leadpop_background_swatches = getPartition($client_id, "leadpop_background_swatches");
                }
                $s = "delete  from " . $leadpop_background_swatches;
                $s .= " where  client_id 	= " . $client_id;
//                $s .= " and leadpop_vertical_id = " . $vertical_id;
//                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//                $s .= " and leadpop_type_id = " . $leadpop_type_id;
//                $s .= " and leadpop_template_id = " . $leadpop_template_id;
//                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_version_id  	= " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query($s);
            }
        }
        return $logoDefaultOrClient . "~" . $needToGenerateSwatches;
    }

    public function getLeadpopStatus($client_id)
    {

        $registry = DataRegistry::getInstance();
        $leadpop_id = $registry->leadpops->customLeadpopid;
        $version_seq = $registry->leadpops->customLeadpopVersionseq;

        $s = "select * from leadpops where id = " . $leadpop_id;
        $leadpop = $this->db->fetchRow($s);
        $leadpop_version_id = $leadpop['leadpop_version_id'];

        $s = "select leadpop_active from clients_leadpops where ";
        $s .= " client_id =  " . $client_id;
        //$s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_version_id =  " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $lpactive = $this->db->fetchOne($s);
        return $lpactive;
    }

    /**
     * [getLeadpopStatusV2 current leadpop active or not]
     * @param  array $args [funnel data]
     * @return [type]       [bool]
     */
    public function getLeadpopStatusV2($args = array())
    {
        if (empty($args)) return;
        $s = "select leadpop_active from clients_leadpops where ";
        $s .= " client_id =  " . $args["client_id"];
        //$s .= " and leadpop_id = " . $args["leadpop_id"];
        $s .= " and leadpop_version_id =  " . $args["leadpop_version_id"];
        $s .= " and leadpop_version_seq = " . $args["leadpop_version_seq"];
        //echo $s;
        $lpactive = $this->db->fetchOne($s);
        return $lpactive;
    }

    public function uploadImage($afiles, $client_id, $funnel_data = array())
    {
        if (!isset($afiles['logo']['name']) || $afiles['logo']['name'] == "") return false;
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select leadpop_template_id from leadpops where id = " . $leadpop_id;
        $leadpop_template_id = $this->db->fetchOne($s);

        $afiles['logo']['name'] = preg_replace('/[^\.a-zA-Z0-9]/', '', $afiles['logo']['name']);
        $imagename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq . "_" . $afiles['logo']['name']);
        $section = substr($client_id, 0, 1);
        $imagepath = $section . '/' . $client_id . '/pics/' . $imagename;
        list($src_w, $src_h, $type) = getimagesize($afiles['logo']["tmp_name"]);

        $cdn = move_uploaded_file_to_rackspace($afiles['logo']['tmp_name'], $imagepath);
        $imagepath = $cdn['rs_cdn'];


        $gis = getimagesize($imagepath);

        $ow = $gis[0];
        $oh = $gis[1];
        $type = $gis[2];
        switch ($type) {
            case "1":
                $im = imagecreatefromgif($imagepath);
                break;
            case "2":
                $im = imagecreatefromjpeg($imagepath);
                break;
            case "3":
                $im = imagecreatefrompng($imagepath);
                break;
            default:
                $im = imagecreatefromjpeg($imagepath);
        }
        $imagetype = image_type_to_mime_type($type);

        if ($imagetype != 'image/jpeg' && $imagetype != 'image/png' && $imagetype != 'image/gif') {
            return 'bad';
        }
        $s = "select image_src from leadpop_images  ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $oldimage = $this->db->fetchRow($s);
        if ($oldimage) {
            $s = "update leadpop_images  set numpics = 1,image_src = '" . $imagename . "', use_me = 'y' , use_default = 'n' ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            $this->db->fetchRow($s);
        } else {
            // if image is missing then add
            $s = "INSERT into leadpop_images (numpics, image_src, use_me, use_default, client_id, leadpop_id, leadpop_type_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_template_id, leadpop_version_id, leadpop_version_seq) ";
            $s .= " VALUES (1, '" . $imagename . "', 'y', 'n', " . $client_id . ", " . $leadpop_id . ", " . $leadpop_type_id . ", " . $vertical_id . ", " . $subvertical_id . ", " . $leadpop_template_id . ", " . $leadpop_version_id . ", " . $version_seq . ")";
            $this->db->query($s);
        }

        $imagesrc = getCdnLink() . '/pics/' . $imagename;
        $this->updateFunnelVar(FunnelVariables::FRONT_IMAGE, $imagesrc, $client_id, $leadpop_id, $version_seq);

        return 'ok';
    }


    /**
     * @since 2.1.0 - CR-Funnel-Builder: Replaced move_uploaded_file => move_uploaded_file_to_rackspace
     *
     *
     * @param $afiles
     * @param $client_id
     * @param array $funnel_data
     * @param string $swatches
     * @return string
     */
    public function uploadLogo($afiles, $client_id, $funnel_data = array(), $swatches = '')
    {
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select leadpop_template_id from leadpops where id = " . $leadpop_id;
        $leadpop_template_id = $this->db->fetchOne($s);


        $s = "select numpics,use_default from leadpop_logos ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;

        $respics = $this->db->fetchRow($s);
        if ($respics) {
            $numpics = $respics['numpics'] + 1;
            $usedefault = $respics['use_default'];
        } else {
            $numpics = 1;
            $usedefault = "y";
        }

        $afiles['logo']['name'] = preg_replace('/[^\.a-zA-Z0-9]/', '', $afiles['logo']['name']);
        $logoname = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq . "_" . $afiles['logo']['name']);
        $section = substr($client_id, 0, 1);
        $logopath = $section . '/' . $client_id . '/logos/' . $logoname;

        list($src_w, $src_h, $type) = getimagesize($afiles['logo']["tmp_name"]);


        /**
         * Logo Dimensions
         */
        /*$W = 500;
          $H = 120;

          if($src_w > $W){
              $_w = $W;
              $_h = ($_w * $src_h)/$src_w;
              if($_h>$H){
                  $_h = $H;
                  $_w = ($_h * $src_w)/$src_h;
              }
          }else if($src_h > $H){
              $_h = $H;
              $_w = ($_h * $src_w)/$src_h;
              if($_w>$W) {
                  $_w = $W;
                  $_h = ($_w * $src_h)/$src_w;
              }
          }
          $dimension = "width:".intval($_w)."~"."height:".intval($_h);*/

        $cdn = move_uploaded_file_to_rackspace($afiles['logo']['tmp_name'], $logopath);
        $logopath = $cdn['rs_cdn'];

        //MN
        /*$client = new Client();

          $gis       = getimagesize($logopath);
          $ow = $gis[0];
          $oh = $gis[1];
          $type = $gis[2];
         //die($type.' type');
          switch($type)
          {
                case "1":
                	$im = imagecreatefromgif($logopath);
                	$image = $client->loadGif($logopath);
          			$logo_color = $image->extract();
                break;
                case "2":
                	$im = imagecreatefromjpeg($logopath);
                	$image = $client->loadJpeg($logopath);
                	$logo_color = $image->extract();
                	break;
                case "3":
                	$im = imagecreatefrompng($logopath);
                	$image = $client->loadPng($logopath);
          			$logo_color = $image->extract();
                	break;
                default:  $im = imagecreatefromjpeg($logopath);
            }*/
        $logo_color = $this->getLogoProminentColor($logopath);
        if (is_array($logo_color)) {
            $logo_color = $logo_color[0];
        }

        if ($logo_color == "#272827") {
            $logo_color = "#A8000D";
        }


        $imagetype = image_type_to_mime_type($type);
        // var_dump($imagetype);
        // exit;
        if ($imagetype != 'image/jpeg' && $imagetype != 'image/png' && $imagetype != 'image/gif') {
            return 'bad';
        }

        #$logoname = $cdn['client_cdn'];
        $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
        $s .= "logo_src,use_me,numpics,logo_color,ini_logo_color, swatches, last_update) values (null,";
        $s .= $client_id . "," . $leadpop_id . "," . $leadpop_type_id . "," . $vertical_id . "," . $subvertical_id . ",";
        $s .= $leadpop_template_id . "," . $leadpop_version_id . "," . $version_seq . ",";
        $s .= "'" . $usedefault . "','" . $logoname . "','n'," . $numpics . ", '" . $logo_color . "','" . $logo_color . "', '" . $swatches . "', " . time() . ") ";
        $this->db->query($s);


        $s = "update leadpop_logos  set numpics = " . $numpics;
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);

        $s = "UPDATE clients_leadpops SET  last_edit = '" . date("Y-m-d H:i:s") . "'";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_version_id  = " . $leadpop_version_id;
        $s .= " AND leadpop_version_seq  = " . $version_seq;
        $this->db->query($s);

        return 'ok';
    }


    public function uploadcombinelogos($post, $afiles, $funnel_data = array())
    {
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }

        $client_id = $post['client_id'];
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select leadpop_template_id from leadpops where id = " . $leadpop_id;
        $leadpop_template_id = $this->db->fetchOne($s);

        // Combine and resize
        $pre_image_style = explode("~", $post['pre-image-style']);
        $post_image_style = explode("~", $post['post-image-style']);

        $src1_img_w = round(str_replace('px', '', $pre_image_style[0]));
        $src1_img_h = round(str_replace('px', '', $pre_image_style[1]));
        $src2_img_w = round(str_replace('px', '', $post_image_style[0]));
        $src2_img_h = round(str_replace('px', '', $post_image_style[1]));

        $src1_image = $this->_createImage($afiles['pre-image']);
        $src1_image = $this->resize_image($src1_image, $src1_img_w, $src1_img_h);
        $src1_img_w = imagesx($src1_image);
        $src1_img_h = imagesy($src1_image);

        $src2_image = $this->_createImage($afiles['post-image']);
        $src2_image = $this->resize_image($src2_image, $src2_img_w, $src2_img_h);
        $src2_img_w = imagesx($src2_image);
        $src2_img_h = imagesy($src2_image);

        $HIGHT = $src1_img_h;
        $Y1 = $Y2 = 0;
        if ($src2_img_h > $src1_img_h) {
            $HIGHT = $src2_img_h;
            $Y1 = ($src2_img_h - $src1_img_h) / 2;
        } else {
            $Y2 = ($src1_img_h - $src2_img_h) / 2;
        }


        $divider = imagecreatetruecolor(2, $HIGHT);
        $color = imagecolorallocate($divider, 211, 211, 211);
        imagefill($divider, 0, 0, $color);

        $IMG_W = $src1_img_w + $src2_img_w + $this->PAD * 2 + 2;
        $IMG_H = $HIGHT;

        $wrapper_img = imagecreatetruecolor($IMG_W, $IMG_H);
        $color = imagecolorallocatealpha($wrapper_img, 0, 0, 0, 127); //fill transparent back
        imagefill($wrapper_img, 0, 0, $color);

        imagecopymerge($wrapper_img, $src1_image, 0, $Y1, 0, 0, $src1_img_w, $src1_img_h, 100);
        imagecopymerge($wrapper_img, $divider, $this->PAD + $src1_img_w, $this->PAD, 0, $this->PAD, 2, $HIGHT, 100);
        imagecopymerge($wrapper_img, $src2_image, $this->PAD * 2 + $src1_img_w + 2, $Y2, 0, 0, $src2_img_w, $src2_img_h, 100);

        imagesavealpha($wrapper_img, true);

        $s = "select numpics,use_default from leadpop_logos ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;

        $respics = $this->db->fetchRow($s);
        $numpics = $respics['numpics'] + 1;
        $usedefault = $respics['use_default'];


        $afiles['pre-image']['name'] = preg_replace('/[^\.a-zA-Z0-9]/', '', $afiles['pre-image']['name']);
        $rand = $this->generateRandomString(4);
        $logoname = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq . "_" . $rand . $afiles['pre-image']['name']);
        $section = substr($client_id, 0, 1);

        $logopath = $section . '/' . $client_id . '/logos/' . $logoname;
        $logopath = dir_to_str($logopath, true);

        imagepng($wrapper_img, $logopath);

        $logo_color = $this->getLogoProminentColor($logopath);

        move_file_to_rackspace($logopath);       //Save file to tmp direcotry on local and on selection create swatches and then update leadpop_logos
        if (is_array($logo_color)) {
            $logo_color = $logo_color[0];
        }

        if ($logo_color == "#272827") {
            $logo_color = "#A8000D";
        }

        // $imagetype = image_type_to_mime_type($type);
        $imagetype = 'image/png';
        // var_dump($imagetype);
        // exit;
        if ($imagetype != 'image/jpeg' && $imagetype != 'image/png' && $imagetype != 'image/gif') {
            return 'bad';
        }

        $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
        $s .= "logo_src,use_me,numpics,logo_color,ini_logo_color,last_update) values (null,";
        $s .= $client_id . "," . $leadpop_id . "," . $leadpop_type_id . "," . $vertical_id . "," . $subvertical_id . ",";
        $s .= $leadpop_template_id . "," . $leadpop_version_id . "," . $version_seq . ",";
        $s .= "'" . $usedefault . "','" . $logoname . "','n'," . $numpics . ", '" . $logo_color . "','" . $logo_color . "', " . time() . ") ";
        $this->db->query($s);

        $s = "update leadpop_logos  set numpics = " . $numpics;
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);
        return 'ok';
    }

    public function generateRandomString($length = 10)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    public function _createImage($file)
    {
        switch ($file['type']) {
            case 'image/jpeg':
                $image_create_func = 'imagecreatefromjpeg';
                $image_save_func = 'imagejpeg';
                $new_image_ext = 'jpg';
                break;

            case 'image/png':
                $image_create_func = 'imagecreatefrompng';
                $image_save_func = 'imagepng';
                $new_image_ext = 'png';
                break;

            case 'image/gif':
                $image_create_func = 'imagecreatefromgif';
                $image_save_func = 'imagegif';
                $new_image_ext = 'gif';
                break;

            default:
                throw new Exception('Unknown image type.');
        }

        return $image_create_func($file['tmp_name']);
    }

    private function resizeImge($img)
    {

        $W = imagesx($img);
        $H = imagesy($img);

        $w = 0;
        $h = $this->MAX_H;

        // w:h::W:H
        // w = h x W / H
        // if($H > $IMAGE_SIZE[1]){
        //     $_height = $IMAGE_SIZE[1];
        // }

        $w = ($h * $W) / $H;
        // echo "$W | $H";
        // echo "<br>";
        // echo "$w | $h";
        // exit;

        $tmp = imagecreatetruecolor($W, $H);
        imagecopyresampled($tmp, $img, 0, 0, 0, 0, $w, $h, $W, $H);

        return $tmp;
    }

    public function resize_image($file, $w, $h, $crop = FALSE)
    {
        $width = imagesx($file);
        $height = imagesy($file);
        // list($width, $height) = getimagesize($file);
        //$r = $width / $height;
        // if ($crop) {
        //     if ($width > $height) {
        //         $width = ceil($width-($width*abs($r-$w/$h)));
        //     } else {
        //         $height = ceil($height-($height*abs($r-$w/$h)));
        //     }
        //     $newwidth = $w;
        //     $newheight = $h;
        // } else {
        //     if ($w/$h > $r) {
        //         $newwidth = $h*$r;
        //         $newheight = $h;
        //     } else {
        //         $newheight = $w/$r;
        //         $newwidth = $w;
        //     }
        // }
        //$file = imagecreatefrompng($file);
        $dst = imagecreatetruecolor($w, $h);
        $color = imagecolorallocate($dst, 255, 255, 255);
        imagefill($dst, 0, 0, $color);
        imagecopyresampled($dst, $file, 0, 0, 0, 0, $w, $h, $width, $height);

        return $dst;
    }

    /**
     * @deprecated
     */
    public function updateglobalbackground($client_id, $post)
    {

        extract($post, EXTR_OVERWRITE, "form_");
        $lplist = explode(",", $lpkey_background);
        $file = file_get_contents($image_url);

        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];
            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);

            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            if (env('APP_ENV') === config('app.env_local')) {
                $leadpop_background_swatches = 'leadpop_background_swatches';
            } else {
                $leadpop_background_swatches = getPartition($client_id, "leadpop_background_swatches");
            }
            $s = "select swatch,is_primary from " . $leadpop_background_swatches;
            $s .= " where client_id = " . $client_id;
//            $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
//            $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
//            $s .= " and leadpop_type_id = " . $leadpop_type_id;
//            $s .= " and leadpop_template_id = " . $leadpop_template_id;
//            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $s .= " order by id ";
            $currentSwatches = $this->db->fetchAll($s);

            if (env('APP_ENV') === config('app.env_local')) {
                $leadpop_background_swatches = 'leadpop_background_swatches';
            } else {
                $leadpop_background_swatches = getPartition($client_id, "leadpop_background_swatches");
            }
            $s = "delete from " . $leadpop_background_swatches;
            $s .= " where client_id = " . $client_id;
//            $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
//            $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
//            $s .= " and leadpop_type_id = " . $leadpop_type_id;
//            $s .= " and leadpop_template_id = " . $leadpop_template_id;
//            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;

            $this->db->query($s);

            $s = "delete from leadpop_background_color ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;

            $this->db->query($s);

            $s = "select id from leadpops_templates_placeholders ";
            $s .= " where leadpop_template_id = " . $leadpop_template_id;
            $s .= " and client_id = " . $client_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $leadpops_templates_placeholders = $this->db->fetchAll($s);


            for ($xx = 0; $xx < count($leadpops_templates_placeholders); $xx++) {
                $s = "select placeholder_sixtynine from leadpops_templates_placeholders_values ";
                $s .= "where leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'] . " limit 1";
                $place = $this->db->fetchAll($s);
                if ($place) {
                    $sixnine = $place[0]["placeholder_sixtynine"];
                    $sixnine = str_replace(';;', ';', $sixnine);
                    $sixnine = str_replace(': #', ':#', $sixnine);
                    $first = strpos($sixnine, 'color:#');
                    $first += 6;
                    $sec = strpos($sixnine, '>', $first);
                    $sec -= 1;
                    $toreplace = substr($sixnine, $first, ($sec - $first));
                    $sixnine = str_replace($toreplace, $fontcolor, $sixnine);

                    $s = "update leadpops_templates_placeholders_values ";
                    $s .= " set placeholder_sixtynine= '" . addslashes($sixnine) . "'  ";
                    $s .= " where  leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
                    $this->db->query($s);
                }
            }
            $s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
            $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
            $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
            $s .= "background_color,active,default_changed) values (null,";
            $s .= $client_id . "," . $leadpop_vertical_id . ",";
            $s .= $leadpop_vertical_sub_id . ",";
            $s .= $leadpop_type_id . "," . $leadpop_template_id . ",";
            $s .= $leadpop_id . ",";
            $s .= $leadpop_version_id . ",";
            $s .= $leadpop_version_seq . ",";
            $s .= "'" . addslashes($background) . "','y','y')";
            $this->db->query($s);
            $logo_color = $fontcolor;

            $s = "select count(*) as cnt from leadpop_logos where  client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id  = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $s .= " and use_default = 'y' ";


            $usingDefaultLogo = $this->db->fetchOne($s); // one == using default logo, zero equals uploaded a  logo
            if ($usingDefaultLogo == 1) {
                $filename1 = "default-" . $leadpop_vertical_id . "-" . $leadpop_vertical_sub_id . "-" . $leadpop_version_id . "-favicon-circle.png";
                $filename2 = "default-" . $leadpop_vertical_id . "-" . $leadpop_vertical_sub_id . "-" . $leadpop_version_id . "-dot-img.png";
                $filename3 = "default-" . $leadpop_vertical_id . "-" . $leadpop_vertical_sub_id . "-" . $leadpop_version_id . "-ring.png";
                $filename4 = "default-" . $leadpop_vertical_id . "-" . $leadpop_vertical_sub_id . "-" . $leadpop_version_id . "-mvp-check.png";

                // For Production
                $favicon_location = rackspace_stock_assets() . "images/" . $filename1;
                $image_location = rackspace_stock_assets() . "images/" . $filename2;
                $mvp_dot_location = rackspace_stock_assets() . "images/" . $filename3;
                $mvp_check_location = rackspace_stock_assets() . "images/" . $filename4;

                // $favicon_location = rackspace_stock_assets()."images/".$filename1;
                // $image_location = rackspace_stock_assets()."images/".$filename2;

                $filename1 = "default-" . $leadpop_vertical_id . "-" . $leadpop_vertical_sub_id . "-" . $leadpop_version_id . "-" . $leadpop_version_seq . "-favicon-circle.png";
                $filename2 = "default-" . $leadpop_vertical_id . "-" . $leadpop_vertical_sub_id . "-" . $leadpop_version_id . "-" . $leadpop_version_seq . "-dot-img.png";
                $filename3 = "default-" . $leadpop_vertical_id . "-" . $leadpop_vertical_sub_id . "-" . $leadpop_version_id . "-" . $leadpop_version_seq . "-ring.png";
                $filename4 = "default-" . $leadpop_vertical_id . "-" . $leadpop_vertical_sub_id . "-" . $leadpop_version_id . "-" . $leadpop_version_seq . "-mvp-check.png";

                $favicon_dst_src = rackspace_stock_assets() . "images/default/" . $filename1;
                $colored_dot_src = rackspace_stock_assets() . "images/default/" . $filename2;
                $mvp_dot_src = rackspace_stock_assets() . "images/default/" . $filename3;
                $mvp_check_src = rackspace_stock_assets() . "images/default/" . $filename4;

                // $favicon_dst_src = rackspace_stock_assets()."images/default/".$filename1;
                // $colored_dot_src = rackspace_stock_assets()."images/default/".$filename2;

                if (isset($logo_color) && $logo_color != "") {
                    $new_clr = $this->hex2rgb($logo_color);
                }
                $im = imagecreatefrompng($image_location);
                $myRed = $new_clr[0];
                $myGreen = $new_clr[1];
                $myBlue = $new_clr[2];

                $this->colorizeBasedOnAplhaChannnel($image_location, $myRed, $myGreen, $myBlue, $colored_dot_src);
                $this->colorizeBasedOnAplhaChannnel($favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src);
                $this->colorizeBasedOnAplhaChannnel($mvp_dot_location, $myRed, $myGreen, $myBlue, $mvp_dot_src);
                $this->colorizeBasedOnAplhaChannnel($mvp_check_location, $myRed, $myGreen, $myBlue, $mvp_check_src);

                $favicon_dst = $this->getHttpServer() . '/images/' . $filename1;
                $colored_dot = $this->getHttpServer() . '/images/' . $filename2;
                $mvp_dot = $this->getHttpServer() . '/images/' . $filename3;
                $mvp_check = $this->getHttpServer() . '/images/' . $filename4;

                for ($i = 0; $i < count($leadpops_templates_placeholders); $i++) {
                    $s = " update leadpops_templates_placeholders_values  set  placeholder_eightyone = '" . $logo_color . "' , placeholder_eightytwo = '" . $colored_dot . "',placeholder_seventynine = '" . $mvp_dot . "' ,placeholder_eighty = '" . $mvp_check . "', placeholder_eightythree = '" . $favicon_dst . "'  where client_leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
                    $this->db->query($s);
                }

                $s = "update leadpop_logos set default_colored = 'y' , logo_color = '" . $logo_color . "' where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id  = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                $s .= " and use_default = 'y' ";
                $this->db->query($s);

            } else {

                for ($j = 0; $j < count($currentSwatches); $j++) {
                    $s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
                    $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                    $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
                    $s .= "swatch,is_primary,active) values (null,";
                    $s .= $client_id . "," . $leadpop_vertical_id . ",";
                    $s .= $leadpop_vertical_sub_id . ",";
                    $s .= $leadpop_type_id . "," . $leadpop_template_id . ",";
                    $s .= $leadpop_id . ",";
                    $s .= $leadpop_version_id . ",";
                    $s .= $leadpop_version_seq . ",";
                    $s .= "'" . addslashes($currentSwatches[$j]["swatch"]) . "',";
                    if ($j == $swatchnumber) {
                        $s .= "'y','y')";
                    } else {
                        $s .= "'n','y')";
                    }
                    $this->db->query($s);
                }
                $filename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $leadpop_vertical_id . "_" . $leadpop_vertical_sub_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $leadpop_version_seq);

                // For Production
                // $image_location = rackspace_stock_assets()."images/dot-img.png";
                // $favicon_location = rackspace_stock_assets()."images/favicon-circle.png";

                $favicon_location = rackspace_stock_assets() . "images/favicon-circle.png";
                $image_location = rackspace_stock_assets() . "images/dot-img.png";
                $mvp_dot_location = rackspace_stock_assets() . "images/ring.png";
                $mvp_check_location = rackspace_stock_assets() . "images/mvp-check.png";


                $favicon_dst_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_favicon-circle.png';
                $colored_dot_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_dot_img.png';
                $mvp_dot_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_ring.png';
                $mvp_check_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_mvp-check.png';

                if (isset($logo_color) && $logo_color != "") {
                    $new_clr = $this->hex2rgb($logo_color);
                }
                $im = imagecreatefrompng($image_location);
                $myRed = $new_clr[0];
                $myGreen = $new_clr[1];
                $myBlue = $new_clr[2];

                $this->colorizeBasedOnAplhaChannnel($image_location, $myRed, $myGreen, $myBlue, $colored_dot_src);
                $this->colorizeBasedOnAplhaChannnel($favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src);
                $this->colorizeBasedOnAplhaChannnel($mvp_dot_location, $myRed, $myGreen, $myBlue, $mvp_dot_src);
                $this->colorizeBasedOnAplhaChannnel($mvp_check_location, $myRed, $myGreen, $myBlue, $mvp_check_src);

                $colored_dot = getCdnLink() . '/logos/' . $filename . '_dot_img.png';
                $favicon_dst = getCdnLink() . '/logos/' . $filename . '_favicon-circle.png';
                $mvp_dot = getCdnLink() . '/logos/' . $filename . '_ring.png';
                $mvp_check = getCdnLink() . '/logos/' . $filename . '_mvp-check.png';

                for ($i = 0; $i < count($leadpops_templates_placeholders); $i++) {
                    $s = " update leadpops_templates_placeholders_values  set  placeholder_eightyone = '" . $logo_color . "' , placeholder_eightytwo = '" . $colored_dot . "',placeholder_seventynine = '" . $mvp_dot . "' ,placeholder_eighty = '" . $mvp_check . "', placeholder_eightythree = '" . $favicon_dst . "'  where client_leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
                    $this->db->query($s);
                }
                $s = "update leadpop_logos set default_colored = 'n', logo_color = '" . $logo_color . "' where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id  = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                $s .= " and use_me = 'y' ";
                $this->db->query($s);

            }

        }

    }


    public function updatebackgroundimage($client_id, $post, $afiles, $funnel_data = array())
    {
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;

        }
        if ($post['background_type'] != "") {
            $background_type = $post['background_type'];
        } else {
            $background_type = '1';
        }

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);


        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select leadpop_template_id from leadpops where id = " . $leadpop_id;
        $leadpop_template_id = $this->db->fetchOne($s);

        $section = substr($client_id, 0, 1);

        if ($afiles['background_name']['name'] == '') {
            $img_exp = explode("/", $post['image-url']);
            $img_name = end($img_exp);
            $imagename = rtrim($img_name, '/');
            //$imagename = substr($img_name,0,-1);
            //$imagename = substr(end(explode("/",$post['image-url'])),0,-1);
        } else {
            $path_parts = pathinfo($afiles["background_name"]["name"]);
            $file_name = $afiles['background_name']['name'];
            $extension = $path_parts['extension'];
            $newfile_name = preg_replace('/[^A-Za-z0-9]/', "", $file_name);
            $newfile_name = $newfile_name . "." . $extension;
            $imagename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq . "_" . $newfile_name);

        }

        /* @since 2.1.0 - Links changed to Rackspace CDN : */
        $dir_path = $section . '/' . $client_id . '/pics/';
        $imagepath = $section . '/' . $client_id . '/pics/' . $imagename;

        ## $imageurl = $this->getHttpAdminServer() . '/images/clients/' . $section . '/' . $client_id . '/pics/' . $imagename;
        $imageurl = getCdnLink() . '/pics/' . $imagename;

        $post['gradient'] = "url(" . $imageurl . ")";
        $background_overlay = $post['background-overlay'];
        $bgimageprop = $post['background_size'] . "~" . $post['background-position'] . "~" . $post['background-repeat'] . "~" . $post['overlay_color_opacity'];

        $bgimage_style = "style='background-image: " . $post['gradient'] . ";";
        $bgimage_style .= " background-size: " . $post['background_size'] . ";";
        $bgimage_style .= " background-position: " . $post['background-position'] . ";";
        $bgimage_style .= " background-repeat: " . $post['background-repeat'] . "';";
        $background_overlay_opacity = $post['overlay_color_opacity'];

        $s = "update leadpop_background_color set bgimage_url = '" . $imageurl . "', background_overlay = '" . $background_overlay . "', bgimage_style = '" . addslashes($bgimage_style) . "', bgimage_properties = '" . addslashes($bgimageprop) . "',background_type = '" . $background_type . "',background_overlay_opacity='$background_overlay_opacity',active_backgroundimage='y'";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;

        $this->db->query($s);

        if ($afiles['background_name']['tmp_name'] != '') {
            try {
                $cdn = move_uploaded_file_to_rackspace($afiles['background_name']['tmp_name'], $imagepath);
                $cdn_link = $cdn['rs_cdn'];
                return "ok";
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return "ok";
    }

    public function manage_single_file($input_name, $folder_to_move, $mime_allowed = [], $return_json = true)
    {
        /*$resultado = array();
        $count_mime_allowed = count($mime_allowed);
        if (is_uploaded_file($_FILES[$input_name]['tmp_name'])) {
            $new_name_file = bin2hex(random_bytes(64)) . '.' . pathinfo($_FILES[$input_name]['name'], PATHINFO_EXTENSION);
            $this->upload_info = array(
                'name' => $new_name_file,
                'size' => $_FILES[$input_name]['size'],
                'mime' => finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES[$input_name]['tmp_name']),
                'extension' => pathinfo($_FILES[$input_name]['name'], PATHINFO_EXTENSION),
                'check_mime' => true,
                'folder_to_move' => $folder_to_move,
                'error_code' => $_FILES[$input_name]['error'],
            );
            if ($count_mime_allowed > 0 && !in_array($this->upload_info['mime'], $mime_allowed, true)) {
                $this->upload_info['check_mime'] = false;
            }
            if ($this->upload_info['error_code'] === 0 && $this->upload_info['check_mime'] === true) {
                move_uploaded_file($_FILES[$input_name]['tmp_name'], $folder_to_move . $this->upload_info['name']);
            }
        }
        $resultado['upload_info'] = $this->upload_info;
        if ($return_json) {
            echo json_encode($resultado);
        }
        if (!$return_json) {
            return $resultado;
        }*/
    }

    public function saveglobalnotification($client_id, $adata)
    {
        extract($_POST, EXTR_OVERWRITE, "form_");
        $lplist = explode(",", $lpkey_notification);

        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];
            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);

            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];

            if ($adata['isnewrowid'] == 'n') {
                $s = " select * from lp_auto_recipients ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                $s .= " and email_address = '" . $adata['oldemail'] . "' ";
                $s .= " and is_primary = '" . $adata['is_primary'] . "' ";
                $recip_data = $this->db->fetchRow($s);

                if ($recip_data) {

                    $s = "update lp_auto_recipients set email_address = '" . $adata['newemail'] . "' ";
                    $s .= " where client_id = " . $client_id;
                    $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                    $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                    $s .= " and leadpop_type_id = " . $leadpop_type_id;
                    $s .= " and leadpop_template_id = " . $leadpop_template_id;
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_version_id = " . $leadpop_version_id;
                    $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                    $s .= " and email_address = '" . $adata['oldemail'] . "' ";
                    $s .= " and is_primary = '" . $adata['is_primary'] . "' ";
                    $this->db->query($s);

                    if ($adata['newtextcell'] == 'y') {
                        $s = "update lp_auto_text_recipients set phone_number = '" . $adata['notification_number'] . "', ";
                        $s .= " carrier = '" . $adata['carrier'] . "' where lp_auto_recipients_id = " . $recip_data['id'];
                        $s .= " and is_primary = '" . $adata['is_primary'] . "' ";
                        $this->db->query($s);
                    }

                }
            } else if ($adata['isnewrowid'] == 'y') {
                //list($verticalName,$subverticalName,$leadpop_id,$leadpop_version_seq,$client_id) = explode("~",$adata['newkeys']);

                $s = "select * from leadpops where id = " . $leadpop_id;
                $lp = $this->db->fetchRow($s);


                $s = "select count(*) as cnt  from lp_auto_recipients where ";
                $s .= " client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $lp['leadpop_type_id'];
                $s .= " and leadpop_vertical_id = " . $lp['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $lp['leadpop_vertical_sub_id'];
                $s .= " and leadpop_template_id = " . $lp['leadpop_template_id'];
                $s .= " and leadpop_version_id = " . $lp['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                $s .= " and email_address = '" . $adata['newemail'] . "' ";
                //die($s);
                $cnt = $this->db->fetchOne($s);
                if ($cnt == 0) {
                    $s = "insert into lp_auto_recipients (client_id,leadpop_id,leadpop_type_id,";
                    $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                    $s .= "leadpop_version_seq,email_address,is_primary) values (" . $client_id . ",";
                    $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . "," . $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                    $s .= "," . $leadpop_version_seq . ",'" . $adata['newemail'] . "','n')";
                    $this->db->query($s);

                    $lastId = $this->db->lastInsertId();

                    if ($adata['newtextcell'] == 'y') {
                        $s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
                        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                        $s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $client_id . "," . $lastId . ",";
                        $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . ",";
                        $s .= $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                        $s .= "," . $leadpop_version_seq . ",'" . $adata['notification_number'] . "','" . $adata['carrier'] . "','n')";
                        $this->db->query($s);
                    }

                }
            }
        }
    }

    public function getCurrentLogoIds($client_id, $funnel_data = array())
    {
        $logosrc = array();
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select * from leadpop_logos where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $logos = $this->db->fetchAll($s);

        if ($logos) {
            for ($i = 0; $i < count($logos); $i++) {
                if ($logos[$i]['use_default'] == 'y') {
                    $logosrc['id'] = $this->getDefaultLogoId($vertical_id, $subvertical_id, $leadpop_version_id);
                    $logosrc['use'] = 'default';
                    break;
                }
                if ($logos[$i]['use_me'] == 'y') {
                    $logosrc['id'] = $logos[$i]['id'];
                    $logosrc['use'] = 'client';
                    break;
                }
            }
        }
        return $logosrc;


    }

    public function checkActiveBackgroundImage($client_id, $funnel_data = array())
    {
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }


        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select active_backgroundimage, bgimage_url from leadpop_background_color where client_id = " . $client_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $bgimage = $this->db->fetchRow($s);
        if ($bgimage['active_backgroundimage'] == 'y' && $bgimage['bgimage_url'] != '') {
            return "y";
        } else {
            return "n";
        }
    }

    private function getDefaultLogoId($vertical_id, $subvertical_id, $leadpop_version_id)
    {
        $s = "select id from stock_leadpop_logos ";
        $s .= " where leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id . " limit 1 ";
        $id = $this->db->fetchOne($s);
        return $id;
    }

    public function getStockLogoSources($client_id, $funnel_data = array())
    {
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
            $verticalName = strtolower($funnel_data["lead_pop_vertical"]);
            $subverticalName = strtolower($funnel_data["lead_pop_vertical_sub"]);
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $verticalName = strtolower($registry->leadpops->customVertical);
            $subverticalName = strtolower($registry->leadpops->customSubvertical);

        }


        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_version_id = $lpres['leadpop_version_id'];

        $s = "select id,logo_src, default_logo_swatches from stock_leadpop_logos  where  leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $logos = $this->db->fetchRow($s);


        //new change stocklogopath
        if ($subverticalName == "") {
            ## $stocklogopath = $this->getHttpServer() . '/images/' . strtolower(str_replace(" ", "", $verticalName)) . '/' . $logos['logo_src'];
            ## $logosrc = $this->getHttpAdminServer() . '/images/' . strtolower(str_replace(" ", "", $verticalName)) . '/' . $logos['logo_src'];
            $logosrc = $stocklogopath = rackspace_stock_assets() . 'images/' . strtolower(str_replace(" ", "", $verticalName)) . '/' . $logos['logo_src'];
        } else {
            ## $stocklogopath = $this->getHttpServer() . '/images/' . strtolower(str_replace(" ", "", $verticalName)) . '/' . strtolower(str_replace(" ", "", $subverticalName)) . '_logos/' . $logos['logo_src'];
            ## $logosrc = $this->getHttpAdminServer() . '/images/' . strtolower(str_replace(" ", "", $verticalName)) . '/' . strtolower(str_replace(" ", "", $subverticalName)) . '_logos/' . $logos['logo_src'];
            $logosrc = $stocklogopath = rackspace_stock_assets() . 'images/' . strtolower(str_replace(" ", "", $verticalName)) . '/' . strtolower(str_replace(" ", "", $subverticalName)) . '_logos/' . $logos['logo_src'];
        }
        return $logos['id'] . "~" . $logosrc . "~" . $stocklogopath . "~" . $logos['default_logo_swatches'];
    }


    public function GetDefaultLogoColor()
    {

        $registry = DataRegistry::getInstance();
        $vertical_id = $registry->leadpops->customVertical_id;
        $subvertical_id = $registry->leadpops->customSubvertical_id;
        $leadpop_id = $registry->leadpops->customLeadpopid;
        $verticalName = strtolower($registry->leadpops->customVertical);
        $subverticalName = strtolower($registry->leadpops->customSubvertical);
        //use vertical id for change its corresponding funnels default logos
//       ////   $leadpop_vertical_id = 5;
///////          $leadpop_vertical_id = 1;
        $leadpop_vertical_id = 3;
        $s = "select * from stock_leadpop_logos where leadpop_vertical_id =" . $leadpop_vertical_id;
        $stock_leadpop_logos = $this->db->fetchAll($s);

        for ($i = 0; $i < count($stock_leadpop_logos); $i++) {
            $logo_id = $stock_leadpop_logos[$i]["id"];
            // $leadpop_vertical_id = $stock_leadpop_logos[$i]["leadpop_vertical_id"];
            $leadpop_vertical_sub_id = $stock_leadpop_logos[$i]["leadpop_vertical_sub_id"];
            $leadpop_version_id = $stock_leadpop_logos[$i]["leadpop_version_id"];
            $s = "select lead_pop_vertical from leadpops_verticals where id = " . $leadpop_vertical_id;
            $verticalName = $this->db->fetchOne($s);

            $s = "select lead_pop_vertical_sub from leadpops_verticals_sub ";

            $s .= " where leadpop_vertical_id = " . $leadpop_vertical_id;
            $s .= " and id = " . $leadpop_vertical_sub_id;

            $subverticalresult = $this->db->fetchOne($s);

            $s = "select logo_src from stock_leadpop_logos  where  leadpop_vertical_id = " . $leadpop_vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;

            $logo = $this->db->fetchOne($s);
            $logosrc = $this->getHttpAdminServer() . '/images/' . strtolower(str_replace(" ", "", $verticalName)) . '/' . strtolower(str_replace(" ", "", $subverticalresult)) . '_logos/' . $logo;
            $logo_color = $this->getLogoProminentColor($logosrc);
            if (is_array($logo_color)) {
                $logo_color = $logo_color[0];
            }
            /*$client = new Client();
	 		  $gis = getimagesize($logosrc);
	          $ow = $gis[0];
	          $oh = $gis[1];
	          $type = $gis[2];
         		//die($type.' type');


	          switch($type)
	          {
                case "1":
                	$im = imagecreatefromgif($logosrc);
                	$image = $client->loadGif($logosrc);
          			$logo_color = $image->extract();
                break;
                case "2":
                	$im = imagecreatefromjpeg($logosrc);
                	$image = $client->loadJpeg($logosrc);
                	$logo_color = $image->extract();
                	break;
                case "3":
                	$im = imagecreatefrompng($logosrc);
                	$image = $client->loadPng($logosrc);
          			$logo_color = $image->extract();
                	break;
                default:  $im = imagecreatefromjpeg($logosrc);
	          }

	          if(is_array($logo_color)){
	          	$logo_color = $logo_color[0];
	          }*/
            $s = "update stock_leadpop_logos  set default_logo_color = '" . $logo_color . "'";
            $s .= " where leadpop_vertical_id = " . $leadpop_vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $this->db->query($s);
        }
        print("done");
        exit;
    }

    public function getBackgroundImageOptions($client_id, $funnel_data = array())
    {
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }


        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select * from leadpop_background_color where client_id = " . $client_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $bgimageoptions = $this->db->fetchAll($s);

        //Exceptional Case: if we don't have any row in leadpop_background_color then go for default colors
        if (empty($bgimageoptions)) {
            $bgimageoptions[0] = \LP_Helper::getInstance()->default_background_color();
        }
        return $bgimageoptions;
    }

    public function getLogoSources($client_id, $funnel_data = array())
    {
        $registry = DataRegistry::getInstance();
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
            $verticalName = strtolower($funnel_data["lead_pop_vertical"]);
            $subverticalName = strtolower($funnel_data["lead_pop_vertical_sub"]);
        } else {
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
            $verticalName = strtolower($registry->leadpops->customVertical);
            $subverticalName = strtolower($registry->leadpops->customSubvertical);
        }


        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select * from leadpop_logos where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $s .= " order by last_update asc ";
        $logos = $this->db->fetchAll($s);
        if ($registry->leadpops->clientInfo['is_fairway'] == 1) $trial_launch_defaults = "trial_launch_defaults_fairway";
        else if ($registry->leadpops->clientInfo['is_mm'] == 1) $trial_launch_defaults = "trial_launch_defaults_mm";
        else $trial_launch_defaults = "trial_launch_defaults";

        // get trial info from version_seq = 1 because if funnel is cloned manny times the higher version_seq not exist in trial tables
        $s = "select * from " . $trial_launch_defaults;
        $s .= " where leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $s .= " ORDER BY leadpop_version_seq ASC";
        $trialDefaults = $this->db->fetchRow($s);

        $logosrcs = array();
        if ($logos) {
            if ($trialDefaults) {
                for ($i = 0; $i < count($logos); $i++) {
                    $defaultlogoname = $trialDefaults['logo_name'];
                    $verticalName = strtolower(str_replace(" ", "", $verticalName));
                    $subverticalName = str_replace(' ', '', $subverticalName);

                    /*
                     * WRONG logo_src data cases fixes for DEFAULT / STOCK images
                     * We need just file's basename in logo_src But these if condition fixes the following cases
                     *      = logo_src starts from "default/images/" =>> This was due to issue zulfi left in migration script. so quick fix is to override logo_src in code
                     *      = logo_src starts from "http://itclix.com/images/" =>> Still lot of URLs are coming with itclix.com but instead of updating data modified value in logo_src
                     */
                    if (strpos($logos[$i]["logo_src"], "default/images/") !== false) {
                        $src = explode("/", $logos[$i]["logo_src"]);
                        $logos[$i]["logo_src"] = end($src);
                    } else if (strpos($logos[$i]["logo_src"], "itclix.com/images/") !== false || strpos($logos[$i]["logo_src"], "https://") !== false || strpos($logos[$i]["logo_src"], "http://") !== false) {
                        $src = explode("/", $logos[$i]["logo_src"]);
                        $logos[$i]["logo_src"] = end($src);
                    }


                    /* Just like in Current Production if funnel has stock-image entry in table lets skip it from user images */
                    if (trim($logos[$i]["logo_src"]) == $defaultlogoname) continue;

                    if ($logos[$i]['use_default'] == 'y' && trim($logos[$i]["logo_src"]) == $defaultlogoname) {
                        if ($subverticalName == "") {
                            $logo_src = rackspace_stock_assets() . 'images/' . $verticalName . '/' . $logos[$i]["logo_src"];
                        } else {
                            $logo_src = rackspace_stock_assets() . 'images/' . $verticalName . '/' . $subverticalName . '_logos/' . $logos[$i]["logo_src"];
                        }
                    } else if ($logos[$i]['use_default'] == 'n' && trim($logos[$i]["logo_src"]) == $defaultlogoname) {
                        if ($subverticalName == "") {
                            $logo_src = rackspace_stock_assets() . 'images/' . $verticalName . '/' . $logos[$i]["logo_src"];
                        } else {
                            $logo_src = rackspace_stock_assets() . '/images/' . $verticalName . '/' . $subverticalName . '_logos/' . $logos[$i]["logo_src"];
                        }
                    } else {
                        $logo_src = rackspace_client_baseurl() . '/logos/' . $logos[$i]['logo_src'];
                    }


                    $logosrcs['src'][] = $logo_src;
                    $logosrcs['id'][] = $logos[$i]['id'];
                    $logosrcs['swatches'][] = $logos[$i]['swatches'];
                }
            }
        }
        return $logosrcs;
    }

    private function getHttpAdminServer()
    {
        if (defined('LP_DEVELOPMENT_HTTP_ADMIN_SERVER')) {
            return LP_DEVELOPMENT_HTTP_ADMIN_SERVER;
        }
        $s = "select http from httpadminserver limit 1 ";
        $http = $this->db->fetchOne($s);
        return $http;
    }

    public function getImagePath($leadpop_id)
    {
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $s = "select include_path from leadpops_template_info where leadpop_template_id = " . $lpres['leadpop_template_id'];
//		  die($s);
        $path = $this->db->fetchOne($s);
        return $path;
    }

    public function activatelpimage($client_id)
    {
        $registry = DataRegistry::getInstance();
        $vertical_id = $registry->leadpops->customVertical_id;
        $subvertical_id = $registry->leadpops->customSubvertical_id;
        $leadpop_id = $registry->leadpops->customLeadpopid;
        $version_seq = $registry->leadpops->customLeadpopVersionseq;

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "update leadpop_images  set use_default = 'n',use_me = 'y' ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);

        $s = "select * from leadpop_images where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $images = $this->db->fetchRow($s);

        $imagesrc = $this->getHttpServer() . '/images/clients/' . substr($client_id, 0, 1) . '/' . $client_id . '/pics/' . $images['image_src'];

        $s = "select id from leadpops_templates_placeholders ";
        $s .= " where leadpop_template_id = " . $leadpop_template_id;
        $s .= " and client_id = " . $client_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $leadpops_templates_placeholders = $this->db->fetchAll($s);

        for ($i = 0; $i < count($leadpops_templates_placeholders); $i++) {
            $s = " update leadpops_templates_placeholders_values  set placeholder_sixtyone = '" . $imagesrc . "'  where client_leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
            $this->db->query($s);
        }
    }

    /**
     * @since 2.1.0 - CR-Funnel-Builder:
     * Moved leadpops_templates_placeholders_values -> placeholder_sixtyone   ==>   clients_leadpops -> funnel_variables::front_image
     *
     * @param $client_id int
     * @param $status array
     * @param $funnel_data array
     */
    public function activatelpimage2($client_id, $status, $funnel_data = array())
    {
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $registry = DataRegistry::getInstance();
        if ($registry->leadpops->clientInfo['is_fairway'] == 1) $trial_launch_defaults = "trial_launch_defaults_fairway";
        else if ($registry->leadpops->clientInfo['is_mm'] == 1) $trial_launch_defaults = "trial_launch_defaults_mm";
        else $trial_launch_defaults = "trial_launch_defaults";

        $s = "select * from " . $trial_launch_defaults;
        $s .= " where leadpop_vertical_sub_id = " . $subvertical_id;
        #$s .= " and leadpop_vertical_id = " . $vertical_id;
        #$s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $s .= " ORDER BY leadpop_version_seq ASC";
        $trialDefaults = $this->db->fetchRow($s);
        $defaultimagename = $trialDefaults['image_name'];


        $s = "select * from leadpop_images where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $images = $this->db->fetchRow($s);


        if ($status["imagestatus"] == "default" || $defaultimagename == $images['image_src']) {
            $s = "update leadpop_images  set use_default = 'y',use_me = 'n' ";
            $is_default_image = true;
        } elseif ($status["imagestatus"] == "mine") {
            $s = "update leadpop_images  set use_default = 'n',use_me = 'y' ";
            $is_default_image = false;
        }
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);

        if ($is_default_image) {
            $s = "SELECT * FROM current_container_image_path WHERE cdn_type = 'default-assets'";
            $defaultCdn = $this->db->fetchRow($s);
            $imagesrc = $defaultCdn['image_path'] . config('rackspace.rs_featured_image_dir') . $defaultimagename;
        } else {
            //$imagesrc = $this->getHttpServer() . '/images/clients/' . substr($client_id, 0, 1) . '/' . $client_id . '/pics/' . $images['image_src'];
            $imagesrc = getCdnLink() . '/pics/' . $images['image_src'];
        }

        $this->updateFunnelVar(FunnelVariables::FRONT_IMAGE, $imagesrc, $client_id, $leadpop_id, $version_seq);
    }

    function deleteFeaturedMediaImage($client_id, $funnel_data = array())
    {
        $vertical_id = $funnel_data["leadpop_vertical_id"];
        $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
        $leadpop_id = $funnel_data["leadpop_id"];
        $version_seq = $funnel_data["leadpop_version_seq"];

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "update leadpop_images  set use_default = 'n',use_me = 'n' , image_src =''  ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;

        $this->db->query($s);

        $s = "select id from leadpops_templates_placeholders ";
        $s .= " where leadpop_template_id = " . $leadpop_template_id;
        $s .= " and client_id = " . $client_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $leadpops_templates_placeholders = $this->db->fetchAll($s);

        for ($i = 0; $i < count($leadpops_templates_placeholders); $i++) {
            $s = " update leadpops_templates_placeholders_values  set placeholder_sixtyone = ''  where client_leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
            $this->db->query($s);
        }
        return;
    }

    /**
     * @since 2.1.0 - CR-Funnel-Builder:
     * Moved leadpops_templates_placeholders_values -> placeholder_sixtyone   ==>   clients_leadpops -> funnel_variables::front_image
     *
     * @param $client_id int
     * @param $funnel_data array
     * @return array
     */
    public function activateDefaultlpimage($client_id, $funnel_data = array())
    {
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $registry = DataRegistry::getInstance();
        if ($registry->leadpops->clientInfo['is_fairway'] == 1) $trial_launch_defaults = "trial_launch_defaults_fairway";
        else if ($registry->leadpops->clientInfo['is_mm'] == 1) $trial_launch_defaults = "trial_launch_defaults_mm";
        else $trial_launch_defaults = "trial_launch_defaults";

        $s = "select * from " . $trial_launch_defaults;
        $s .= " where leadpop_vertical_id = " . $vertical_id;
        #$s .= " and leadpop_id = " . $leadpop_id;
        #$s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $s .= " ORDER BY leadpop_version_seq ASC";

        $trialDefaults = $this->db->fetchRow($s);

        /**
         * Bug Case:
         *   If at the time of migration client has changed featured images then we don't have its entry in leadpop_images
         *   so migration script don't found any reference to default image and thats why we don't have any physical image on
         *   Rackspace. So changig logic here instead of upload we can directly use featured image from stock images.
         */
        ## $imagename = strtolower($client_id . "_" . $trialDefaults["leadpop_id"] . "_1_" . $trialDefaults["leadpop_vertical_id"] . "_" . $trialDefaults["leadpop_vertical_sub_id"] . "_" . $trialDefaults['leadpop_template_id'] . "_" . $trialDefaults["leadpop_version_id"] . "_" . $trialDefaults["leadpop_version_seq"] . "_" . $trialDefaults['image_name']);
        ## $imagesrc = getCdnLink() . '/pics/' . $imagename;

        $imagename = $trialDefaults['image_name'];
        $imagesrc = rackspace_stock_assets() . config('rackspace.rs_featured_image_dir') . $imagename;

        $s = "update leadpop_images  set use_default = 'y',use_me = 'n' , image_src = '" . $imagename . "' ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;

        $this->db->query($s);

        $this->updateFunnelVar(FunnelVariables::FRONT_IMAGE, $imagesrc, $client_id, $leadpop_id, $version_seq);
        return array('imgsrc' => $imagesrc);
    }

    /**
     * @since 2.1.0 - CR-Funnel-Builder:
     * Moved leadpops_templates_placeholders_values -> placeholder_sixtyone   ==>   clients_leadpops -> funnel_variables::front_image
     *
     * @param $client_id int
     * @param $funnel_data array
     */
    public function deactivatelpimage($client_id, $funnel_data = array())
    {
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "update leadpop_images  set use_default = 'n',use_me = 'n' ";

        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);

        $this->updateFunnelVar(FunnelVariables::FRONT_IMAGE, "", $client_id, $leadpop_id, $version_seq);
    }

    function searchForId($id, $array)
    {
        foreach ($array as $key => $lpdata) {
            if ($lpdata['id'] == $id) {
                return $lpdata;
            }
        }
        return null;
    }


    public function savegloballogo__old($data, $client_id)
    {
        extract($_POST, EXTR_OVERWRITE, "form_");

        $lplist = explode(",", $lpkey_logo);
        $file = file_get_contents($image_url);
        $cur_logo_exp = explode("/", $image_url);
        $cur_logo_name = end($cur_logo_exp);
        $global_logo_trim = rtrim($cur_logo_name);
        $replaced = $client_id . "_global_";

        $logo = str_replace($replaced, "", $global_logo_trim);
        $section = substr($client_id, 0, 1);

        $glogo_path = $section . '/' . $client_id . '/logos/' . $replaced . $logo;
        $logo_color = $this->getLogoProminentColor($image_url);
        if (is_array($logo_color)) {
            $logo_color = $logo_color[0];
        }
        $swatch_result = explode("#", $globalswatches);
        $new_color = $this->hex2rgb($logo_color);
        array_unshift($swatch_result, implode('-', $new_color));

        $image_location = rackspace_stock_assets() . "images/dot-img.png";
        $favicon_location = rackspace_stock_assets() . "images/favicon-circle.png";
        $mvp_dot_location = rackspace_stock_assets() . "images/ring.png";
        $mvp_check_location = rackspace_stock_assets() . "images/mvp-check.png";


        if (isset($logo_color) && $logo_color != "") {
            $new_clr = $this->hex2rgb($logo_color);
        }
        $im = imagecreatefrompng($image_location);
        $myRed = $new_clr[0];
        $myGreen = $new_clr[1];
        $myBlue = $new_clr[2];

        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];
            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);

            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            if ($useme_logo == 'y' && $usedefault_logo == 'n') {

                $logoname = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $leadpop_vertical_id . "_" . $leadpop_vertical_sub_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $leadpop_version_seq . "_" . $logo);
                //$section = substr($client_id,0,1);
                $newlogopath = $section . '/' . $client_id . '/logos/' . $logoname;
                //$glogo_path = $_SERVER['DOCUMENT_ROOT'].'/images/clients/'.$section . '/' . $client_id.'/logos/'.$replaced.$logo;


                $cmd = '/bin/cp   ' . $glogo_path;
                $cmd .= '            ' . $newlogopath;
                exec($cmd);

                $s = "select id, numpics, logo_src from leadpop_logos ";
                $s .= " where client_id = " . $client_id . " and use_me = 'y'";
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                //$tarr['leadpop_logos_call'][]=$s;
                //$tarr['results'][]=$swatch_result;

                $respics = $this->db->fetchRow($s);

                if (isset($respics) && $respics != '') {
                    $selectedlogo_id = $respics['id'];
                    $s = "delete from leadpop_logos where client_id = " . $client_id;
                    $s .= " and id =  " . $selectedlogo_id;
                    //$tarr['del_leadpop_logos_call'][]=$s;
                    $this->db->query($s);
                } else {
                    $s = "select count(logo_src) as cnt from leadpop_logos ";
                    $s .= " where client_id = " . $client_id;
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_type_id = " . $leadpop_type_id;
                    $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                    $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                    $s .= " and leadpop_template_id = " . $leadpop_template_id;
                    $s .= " and leadpop_version_id = " . $leadpop_version_id;
                    $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                    //$tarr['count_leadpop_logos_call'][]=$s;
                    $logocount = $this->db->fetchRow($s);


                    if ($logocount['cnt'] >= 3) {
                        $s = "select id, numpics, logo_src from leadpop_logos ";
                        $s .= " where client_id = " . $client_id;
                        $s .= " and leadpop_id = " . $leadpop_id;
                        $s .= " and leadpop_type_id = " . $leadpop_type_id;
                        $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                        $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                        $s .= " and leadpop_template_id = " . $leadpop_template_id;
                        $s .= " and leadpop_version_id = " . $leadpop_version_id;
                        $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                        //$tarr['sel1_leadpop_logos_call'][]=$s;
                        $respics = $this->db->fetchRow($s);
                        $selectedlogo_id = $respics['id'];
                        $s = "delete from leadpop_logos where client_id = " . $client_id;
                        $s .= " and id =  " . $selectedlogo_id;
                        //$tarr['del1_leadpop_logos_call'][]=$s;
                        $this->db->query($s);
                    }
                }

                $numpics = $respics['numpics'] + 1;
                // OUt
                $s = "update leadpop_logos  set use_default = 'n',use_me = 'n' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                //$tarr['update_leadpop_logos_call'][]=$s;
                $this->db->query($s);

                // IN
                $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
                $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
                $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
                $s .= "logo_src,use_me,numpics,logo_color,ini_logo_color,last_update) values (null,";
                $s .= $client_id . "," . $leadpop_id . "," . $leadpop_type_id . "," . $leadpop_vertical_id . "," . $leadpop_vertical_sub_id . ",";
                $s .= $leadpop_template_id . "," . $leadpop_version_id . "," . $leadpop_version_seq . ",";
                $s .= "'n','" . $logoname . "','y'," . $numpics . ", '" . $logo_color . "','" . $logo_color . "'," . time() . ") ";
                //$tarr['insert_leadpop_logos_call'][]=$s;
                $this->db->query($s);

                // Ingore
                $s = "update leadpop_logos set numpics = " . $numpics;
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                //$tarr['update1_leadpop_logos_call'][]=$s;
                $this->db->query($s);

                // IN
                $s = " update current_logo  set logo_src = '" . $logoname . "' ";
                $s .= " where  client_id 	= " . $client_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_version_id  	= " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq . " limit 1 ";
                //$tarr['update_curlogo1_leadpop_logos_call'][]=$s;
                $this->db->query($s);
                /*$replaced = $client_id . "_global_";
				$logo = str_replace($replaced,"",$logo);*/
                $section = substr($client_id, 0, 1);
                $logoname = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $leadpop_vertical_id . "_" . $leadpop_vertical_sub_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $leadpop_version_seq . "_" . $logo);
                $logosrc = getCdnLink() . '/logos/' . $logoname;
            } else if ($useme_logo == 'n' && $usedefault_logo == 'n') {
                $s = "select count(logo_src) as cnt from leadpop_logos ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                $logocount = $this->db->fetchOne($s);
                // Just need to upload logo to funnels
                if ($logocount < 3) {
                    $logo = str_replace($replaced, "", $logo);
                    $logoname = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $leadpop_vertical_id . "_" . $leadpop_vertical_sub_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $leadpop_version_seq . "_" . $logo);
                    $section = substr($client_id, 0, 1);
                    $newlogopath = $section . '/' . $client_id . '/logos/' . $logoname;

                    $cmd = '/bin/cp   ' . $logo_path;
                    $cmd .= '            ' . $newlogopath;
                    exec($cmd);

                    $s = "select numpics from leadpop_logos ";
                    $s .= " where client_id = " . $client_id;
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_type_id = " . $leadpop_type_id;
                    $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                    $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                    $s .= " and leadpop_template_id = " . $leadpop_template_id;
                    $s .= " and leadpop_version_id = " . $leadpop_version_id;
                    $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                    $respics = $this->db->fetchRow($s);

                    $numpics = $respics['numpics'] + 1;
                    $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
                    $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
                    $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
                    $s .= "logo_src,use_me,numpics,logo_color,ini_logo_color,last_update) values (null,";
                    $s .= $client_id . "," . $leadpop_id . "," . $leadpop_type_id . "," . $leadpop_vertical_id . "," . $leadpop_vertical_sub_id . ",";
                    $s .= $leadpop_template_id . "," . $leadpop_version_id . "," . $leadpop_version_seq . ",";
                    $s .= "'n','" . $logoname . "','n'," . $numpics . ", '" . $logo_color . "','" . $logo_color . "'," . time() . ") ";
                    $this->db->query($s);

                    $s = "update leadpop_logos set numpics = " . $numpics;
                    $s .= " where client_id = " . $client_id;
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_type_id = " . $leadpop_type_id;
                    $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                    $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                    $s .= " and leadpop_template_id = " . $leadpop_template_id;
                    $s .= " and leadpop_version_id = " . $leadpop_version_id;
                    $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                    $this->db->query($s);
                }
                return "ok";
            } else if ($useme_logo == 'n' && $usedefault_logo == 'y') {

                //default start
                // OUT
                $s = "select lead_pop_vertical from leadpops_verticals where id = " . $leadpop_vertical_id;
                $verticalnameres = $this->db->fetchRow($s);

                // IN
                $verticalName = $verticalnameres["lead_pop_vertical"];

                // OUT
                $s = "select lead_pop_vertical_sub from leadpops_verticals_sub where id = " . $leadpop_vertical_sub_id;
                $subverticalnameres = $this->db->fetchRow($s);

                // IN
                $subverticalName = $subverticalnameres["lead_pop_vertical_sub"];

                // OUT
                $verticalName = strtolower(str_replace(' ', '', $verticalName));
                $subverticalName = strtolower(str_replace(' ', '', $subverticalName));
                //default end

                // OUT
                $s = "select id,logo_src from stock_leadpop_logos  where  leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_version_id  = " . $leadpop_version_id;
                $logos = $this->db->fetchRow($s);
                // IN => $logos[short_key]
                $stocklogopath = $this->getHttpServer() . '/images/' . strtolower(str_replace(" ", "", $verticalName)) . '/' . $logos['logo_src'];
                $logosrc = $this->getHttpAdminServer() . '/images/' . strtolower(str_replace(" ", "", $verticalName)) . '/' . $logos['logo_src'];

                // OUT
                $s = "update leadpop_logos set use_default = 'y', use_me = 'n' , default_colored = 'n' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                $this->db->query($s);

                // OUT
                $defaultlogoname = $this->getDefaultLogoName($leadpop_vertical_id, $leadpop_vertical_sub_id, $leadpop_version_id);
                if ($subverticalName == "") {
                    $logosrc = $this->getHttpServer() . '/images/' . strtolower(str_replace(" ", "", $verticalName)) . '/' . $this->getDefaultLogoName($leadpop_vertical_id, $leadpop_vertical_sub_id, $leadpop_version_id);
                } else {
                    $logosrc = $this->getHttpServer() . '/images/' . strtolower(str_replace(" ", "", $verticalName)) . '/' . str_replace(' ', '', $subverticalName) . '_logos/' . $this->getDefaultLogoName($leadpop_vertical_id, $leadpop_vertical_sub_id, $leadpop_version_id);
                }

                // OUT
                $s = "select default_logo_color from stock_leadpop_logos  where  leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $logo_color = $this->db->fetchOne($s);

                // IN
                $s = "update current_logo set logo_src = '" . $defaultlogoname . "'";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id  	= " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                $this->db->query($s);
            }


            // OUT
            $s = "select id from leadpops_templates_placeholders ";
            $s .= " where leadpop_template_id = " . $leadpop_template_id;
            $s .= " and client_id = " . $client_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            //$tarr['placeholdercall'][]=$s;
            $leadpops_templates_placeholders = $this->db->fetchAll($s);

            // IN
            for ($xx = 0; $xx < count($leadpops_templates_placeholders); $xx++) {
                $s = "select placeholder_sixtynine from leadpops_templates_placeholders_values ";
                $s .= "where leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'] . " limit 1";
                $place = $this->db->fetchAll($s);
                if ($place) {
                    $sixnine = $place[0]["placeholder_sixtynine"];
                    $sixnine = str_replace(';;', ';', $sixnine);
                    $sixnine = str_replace(': #', ':#', $sixnine);
                    $first = strpos($sixnine, 'color:#');
                    $first += 6;
                    $sec = strpos($sixnine, '>', $first);
                    $sec -= 1;
                    $toreplace = substr($sixnine, $first, ($sec - $first));
                    $sixnine = str_replace($toreplace, $logo_color, $sixnine);

                    $s = "update leadpops_templates_placeholders_values  ";
                    $s .= " set placeholder_sixtynine= '" . addslashes($sixnine) . "'  ";
                    $s .= " where  leadpop_template_placeholder_id = " . $leadpops_templates_placeholders [$xx] ['id'];
                    $this->db->query($s);
                }
            }

            $filename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $leadpop_vertical_id . "_" . $leadpop_vertical_sub_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $leadpop_version_seq);

            // First Time
            $favicon_dst_src = $section . '/' . $client_id . '/logos/' . $filename . '_favicon-circle.png';
            $colored_dot_src = $section . '/' . $client_id . '/logos/' . $filename . '_dot_img.png';
            $mvp_dot_src = $section . '/' . $client_id . '/logos/' . $filename . '_ring.png';
            $mvp_check_src = $section . '/' . $client_id . '/logos/' . $filename . '_mvp-check.png';

            /*if (isset($logo_color) && $logo_color != "" ) {
				$new_clr = $this->hex2rgb($logo_color);
			}
			$im = imagecreatefrompng($image_location);
			$myRed =  $new_clr[0];
			$myGreen =  $new_clr[1];
			$myBlue =  $new_clr[2];*/

            $this->colorizeBasedOnAplhaChannnel($image_location, $myRed, $myGreen, $myBlue, $colored_dot_src);
            $this->colorizeBasedOnAplhaChannnel($favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src);
            $this->colorizeBasedOnAplhaChannnel($mvp_dot_location, $myRed, $myGreen, $myBlue, $mvp_dot_src);
            $this->colorizeBasedOnAplhaChannnel($mvp_check_location, $myRed, $myGreen, $myBlue, $mvp_check_src);

            // IN
            $colored_dot = getCdnLink() . '/logos/' . $filename . '_dot_img.png';
            $favicon_dst = getCdnLink() . '/logos/' . $filename . '_favicon-circle.png';
            $mvp_dot = getCdnLink() . '/logos/' . $filename . '_ring.png';
            $mvp_check = getCdnLink() . '/logos/' . $filename . '_mvp-check.png';

            // Combine Upper
            for ($i = 0; $i < count($leadpops_templates_placeholders); $i++) {
                $s = " update leadpops_templates_placeholders_values  set placeholder_sixtytwo = '" . $logosrc . "', placeholder_eightyone = '" . $logo_color . "' , placeholder_eightytwo = '" . $colored_dot . "' ,placeholder_seventynine = '" . $mvp_dot . "' ,placeholder_eighty = '" . $mvp_check . "', placeholder_eightythree = '" . $favicon_dst . "'  where client_leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
                //$tarr['placeholdeupdatevalue'][]=$s;
                //debug($s);
                $this->db->query($s);
            }

            // OUT
            if (env('APP_ENV') === config('app.env_local')) {
                $leadpop_background_swatches = 'leadpop_background_swatches';
            } else {
                $leadpop_background_swatches = getPartition($client_id, "leadpop_background_swatches");
            }
            $s = "delete from " . $leadpop_background_swatches;
            $s .= " where client_id = " . $client_id;
//            $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
//            $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
//            $s .= " and leadpop_type_id = " . $leadpop_type_id;
//            $s .= " and leadpop_template_id = " . $leadpop_template_id;
//            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $this->db->query($s);
            //$tarr['dswatcall'][]=$s;


            $swindex = 0;
            // OUT
            // SET BACKGROUND COLOR
            $background_from_logo = '/*###>*/background-color: rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1);/*@@@*/
			background-image: linear-gradient(to right bottom,rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1) 0%,rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1) 100%); /* W3C */';

            // OUT
            $s = "delete from leadpop_background_color ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $this->db->query($s);
            //$tarr['delcall'][]=$s;

            // IN - OUT
            $s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
            $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
            $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
            $s .= "background_color,active,default_changed) values (null,";
            $s .= $client_id . "," . $leadpop_vertical_id . ",";
            $s .= $leadpop_vertical_sub_id . ",";
            $s .= $leadpop_type_id . "," . $leadpop_template_id . ",";
            $s .= $leadpop_id . ",";
            $s .= $leadpop_version_id . ",";
            $s .= $leadpop_version_seq . ",";
            $s .= "'" . addslashes($background_from_logo) . "','y','y')";
            //debug($s);
            $this->db->query($s);
            //$tarr['insertcall'][]=$s;

            // OUT
            foreach ($swatch_result as $key => $value) {

                list($red, $green, $blue) = explode("-", $value);

                if ($key < 1) {
                    $str0 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",1.0) 100%)";
                } else {
                    $str0 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                }

                $str1 = "linear-gradient(to top, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                $str2 = "linear-gradient(to bottom right, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                $str3 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",1.0) 100%)";

                $globalswatches = array($str0, $str1, $str2, $str3);
                //debug($globalswatches);
                // IN - OUT
                for ($i = 0; $i < 4; $i++) {
                    $swindex++;
                    $is_primary = 'n';
                    if ($swindex == 1) {
                        $is_primary = 'y';
                    }
                    $s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
                    $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                    $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
                    $s .= "swatch,is_primary,active) values (null,";
                    $s .= $client_id . "," . $leadpop_vertical_id . ",";
                    $s .= $leadpop_vertical_sub_id . ",";
                    $s .= $leadpop_type_id . "," . $leadpop_template_id . ",";
                    $s .= $leadpop_id . ",";
                    $s .= $leadpop_version_id . ",";
                    $s .= $leadpop_version_seq . ",";
                    $s .= "'" . addslashes($globalswatches[$i]) . "',";
                    $s .= "'" . $is_primary . "','y')";
                    //$tarr['swatches'][]=$s;
                    $this->db->query($s);
                }

            }

        }
        //debug($tarr);

//        $s = "select * from global_settings where client_id = " . $client_id;
//        $client = $this->db->fetchRow($s);
//
//        if (!$client) {
//            $s = "insert into global_settings (id,client_id,logo,";
//            $s .= "logo_url,logo_path) values (null,";
//            $s .= $client_id . ",'" . $logo . "','" . $image_url . "','" . $glogo_path . "') ";
//            $this->db->query($s);
//        } else {
//            $s = "update global_settings set logo = '" . $logo . "',logo_url = '" . $image_url . "',logo_path = '" . $glogo_path . "'";
//            $s .= " where client_id = " . $client_id;
//            $this->db->query($s);
//        }

        return "ok";

    }


    /**
     * @since 2.1.0 - CR-Funnel-Builder:
     * Moved leadpops_templates_placeholders_values -> placeholder_sixtytwo   ==>   clients_leadpops -> funnel_variables::logo_src
     *
     */
    public function changelplogo($client_id, $adata, $funnel_data = array())
    {
        if (!empty($funnel_data)) {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $version_seq = $funnel_data["leadpop_version_seq"];
            $verticalName = strtolower($funnel_data["lead_pop_vertical"]);
        } else {

            $registry = DataRegistry::getInstance();

            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
            $verticalName = strtolower($registry->leadpops->customVertical);
        }

        /*debug($adata);
      	die();*/

        if (isset($adata["makesame"]) && $adata["makesame"] == "y" && $adata["logo_source"] == "client") {
            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);

            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            $leadpop_type_id = $lpres['leadpop_type_id'];

            $s = "select logo_src from leadpop_logos where id = " . $adata['logo_id'];
            $clientlogo = $this->db->fetchOne($s);
            $logosrc = $this->getHttpServer() . '/images/clients/' . substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $clientlogo;

            /* update the logo in question */
            $s = "update leadpop_logos  set use_default = 'n',use_me = 'n' ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            $this->db->query($s);

            $s = "update leadpop_logos  set use_me = 'y', swatches = '" . $adata['swatches'] . "' ";
            $s .= " where client_id = " . $client_id;
            $s .= " and id = " . $adata['logo_id'];
            $this->db->query($s);

            /* update the logo in question */
            $this->updateFunnelVar(FunnelVariables::LOGO_SRC, $logosrc, $client_id, $leadpop_id, $version_seq);

            $s = "update  leadpop_logos set use_default = 'n' , use_me = 'n', numpics = 1 ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq != " . $version_seq;
            $this->db->query($s);

            $s = "select * from leadpop_logos   ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq != " . $version_seq;
            $otherlogos = $this->db->fetchAll($s);

            if ($otherlogos) { // delete old images from table
                for ($i = 0; $i < count($otherlogos); $i++) {
                    if (stristr($otherlogos[$i]["logo_src"], "http") == false) {
                        $s = "delete from leadpop_logos where id = " . $otherlogos[$i]["id"];
                        $this->db->query($s);
                    }
                }
            }

            $s = "select * from leadpop_logos   ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq != " . $version_seq;
            $otherlogos = $this->db->fetchAll($s);


            if ($otherlogos) { // insert one row of new image for each version
                for ($i = 0; $i < count($otherlogos); $i++) {
                    $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,";
                    $s .= "leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,leadpop_version_seq,";
                    $s .= "use_default,logo_src,use_me,numpics,last_update, swatches) values (null," . $client_id . "," . $leadpop_id . "," . $leadpop_type_id . ",";
                    $s .= $vertical_id . "," . $subvertical_id . "," . $leadpop_template_id . "," . $leadpop_version_id . "," . $otherlogos[$i]["leadpop_version_seq"] . ",";
                    $s .= "'n','" . $clientlogo . "','y',1," . time() . ", '" . $otherlogos[$i]['swatches'] . "')";
                    $this->db->query($s);
                }
            }

            if ($otherlogos) { // copy for myleads and clients
                $filename = end(explode('_', $clientlogo));
                for ($i = 0; $i < count($otherlogos); $i++) {
                    $newlogo = $client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $otherlogos[$i]["leadpop_version_seq"] . "_" . $filename;
                    $cmd1 = '/bin/cp  /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $clientlogo . ' /var/www/vhosts/myleads.leadpops.com/images/clients/' . substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $newlogo;
                    # TEMP # exec($cmd1);
                    $cmd2 = '/bin/cp /var/www/vhosts/itclix.com/images/clients/' . substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $clientlogo . ' /var/www/vhosts/itclix.com/images/clients/' . substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $newlogo;
                    # TEMP # exec($cmd2);
                }
            }

        } else {

            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);

            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            $leadpop_type_id = $lpres['leadpop_type_id'];

            if ($adata['logo_source'] == 'client') {

                $s = "select logo_src from leadpop_logos where id = " . $adata['logo_id'];
                $clientlogo = $this->db->fetchOne($s);
                $logosrc = getCdnLink() . '/logos/' . $clientlogo;

                $s = "update leadpop_logos  set use_default = 'n',use_me = 'n' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query($s);

                $s = "update leadpop_logos  set use_me = 'y', swatches = '" . $adata['swatches'] . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and id = " . $adata['logo_id'];
                $this->db->query($s);

                $s = "update current_logo set logo_src = '" . $clientlogo . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id  	= " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query($s);

            } else if ($adata['logo_source'] == 'default') {
                $s = "update leadpop_logos set use_default = 'y', use_me = 'n' , default_colored = 'n', swatches = '" . $adata['swatches'] . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query($s);
            }

            $filename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq);

            if ($adata['logo_source'] == 'client' || $adata['logo_source'] == 'default') {
                $verticalName = strtolower(str_replace(' ', '', $verticalName));
                $subverticalName = ""; //strtolower(str_replace(' ', '', $subverticalName));

                $s = "select default_logo_color from stock_leadpop_logos  where  leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $logo_color = $this->db->fetchOne($s);

                if ($adata['logo_source'] == 'default') {
                    $defaultlogoname = $this->getDefaultLogoName($vertical_id, $subvertical_id, $leadpop_version_id);


                    if ($subverticalName == "") {
                        $logosrc = getCdnLink() . '/images/' . $verticalName . '/' . $this->getDefaultLogoName($vertical_id, $subvertical_id, $leadpop_version_id);
                    } else {
                        $subverticalName = str_replace(' ', '', $subverticalName);
                        $logosrc = getCdnLink() . '/images/' . $verticalName . '/' . $subverticalName . '_logos/' . $this->getDefaultLogoName($vertical_id, $subvertical_id, $leadpop_version_id);
                    }

                    $s = "update current_logo set logo_src = '" . $defaultlogoname . "'";
                    $s .= " where client_id = " . $client_id;
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_vertical_id = " . $vertical_id;
                    $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                    $s .= " and leadpop_type_id = " . $leadpop_type_id;
                    $s .= " and leadpop_template_id = " . $leadpop_template_id;
                    $s .= " and leadpop_version_id  	= " . $leadpop_version_id;
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);

                } else if ($adata['logo_source'] == 'client') { // new change ini_logo_color
                    $s = "select logo_src, ini_logo_color from leadpop_logos where id = " . $adata['logo_id'];
                    $clientlogo = $this->db->fetchRow($s);

                    $s = "select is_mm from clients where client_id = " . $client_id . "";
                    $is_mm = $this->db->fetchOne($s);

                    if ($is_mm == 1 && $clientlogo['ini_logo_color'] == "#272827") {
                        $clientlogo['ini_logo_color'] = "#A8000D";
                    }

                    //for FW specific Logo
                    $s = "select is_fairway from clients where client_id = " . $client_id . "";
                    $is_fairway = $this->db->fetchOne($s);

                    if ($is_fairway == 1 && $logo_color == "#94D60A") {
                        $logo_color = "#18563E";
                    }

                    $s = "update leadpop_logos set logo_color = '" . $clientlogo['ini_logo_color'] . "'";
                    $s .= " where client_id = " . $client_id;
                    $s .= " and id = " . $adata['logo_id'];
                    $this->db->query($s);

                    // changed from $this->getHttpServer() to $this->getHttpAdminServer 3/25/2016 robert
                    //$logosrc = $this->getHttpServer().'/images/clients/'. substr($client_id,0,1) . '/' . $client_id.'/logos/'.$clientlogo['logo_src'];
                    $logosrc = getCdnLink() . '/logos/' . $clientlogo['logo_src'];
                    $logo_color = $clientlogo['ini_logo_color'];
                }

                $sixnine = $this->getLeadLine($client_id, $leadpop_id, $version_seq, FunnelVariables::LEAD_LINE);
                if ($sixnine != "") {
                    $sixnine = str_replace(';;', ';', $sixnine);
                    $sixnine = str_replace(': #', ':#', $sixnine);
                    $first = strpos($sixnine, 'color:#');
                    $first += 6;
                    $sec = strpos($sixnine, '>', $first);
                    $sec -= 1;
                    $toreplace = substr($sixnine, $first, ($sec - $first));
                    $sixnine = str_replace($toreplace, $logo_color, $sixnine);

                    $this->updateLeadLine(FunnelVariables::LEAD_LINE, $sixnine, $client_id, $leadpop_id, $version_seq);
                }

                $image_location = rackspace_stock_assets() . "images/dot-img.png";
                $favicon_location = rackspace_stock_assets() . "images/favicon-circle.png";
                $mvp_dot_location = rackspace_stock_assets() . "images/ring.png";
                $mvp_check_location = rackspace_stock_assets() . "images/mvp-check.png";

                $favicon_dst_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_favicon-circle.png';
                $colored_dot_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_dot_img.png';
                $mvp_dot_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_ring.png';
                $mvp_check_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_mvp-check.png';

                if (isset($logo_color) && $logo_color != "") {
                    $new_clr = $this->hex2rgb($logo_color);
                }

                $im = imagecreatefrompng($image_location);
                $myRed = $new_clr[0];
                $myGreen = $new_clr[1];
                $myBlue = $new_clr[2];


                $this->colorizeBasedOnAplhaChannnel($image_location, $myRed, $myGreen, $myBlue, $colored_dot_src);
                $this->colorizeBasedOnAplhaChannnel($favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src);
                $this->colorizeBasedOnAplhaChannnel($mvp_dot_location, $myRed, $myGreen, $myBlue, $mvp_dot_src);
                $this->colorizeBasedOnAplhaChannnel($mvp_check_location, $myRed, $myGreen, $myBlue, $mvp_check_src);

            }
            $colored_dot = getCdnLink() . '/logos/' . $filename . '_dot_img.png';
            $favicon_dst = getCdnLink() . '/logos/' . $filename . '_favicon-circle.png';
            $mvp_dot = getCdnLink() . '/logos/' . $filename . '_ring.png';
            $mvp_check = getCdnLink() . '/logos/' . $filename . '_mvp-check.png';

            $design_variables = array();
            $design_variables[FunnelVariables::LOGO_SRC] = $logosrc;
            $design_variables[FunnelVariables::LOGO_COLOR] = $logo_color;
            $design_variables[FunnelVariables::COLORED_DOT] = $colored_dot;
            $design_variables[FunnelVariables::MVP_DOT] = $mvp_dot;
            $design_variables[FunnelVariables::MVP_CHECK] = $mvp_check;
            $design_variables[FunnelVariables::FAVICON_DST] = $favicon_dst;
            $this->updateFunnelVariables($design_variables, $client_id, $leadpop_id, $version_seq);
        }

        if (env('APP_ENV') === config('app.env_local')) {
            $leadpop_background_swatches = 'leadpop_background_swatches';
        } else {
            $leadpop_background_swatches = getPartition($client_id, "leadpop_background_swatches");
        }
        $s = "delete from " . $leadpop_background_swatches;
        $s .= " where client_id = " . $client_id;
//        $s .= " and leadpop_vertical_id = " . $vertical_id;
//        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//        $s .= " and leadpop_type_id = " . $leadpop_type_id;
//        $s .= " and leadpop_template_id = " . $leadpop_template_id;
//        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;

        $this->db->query($s);

        if ($adata['logo_source'] == 'client' || $adata['logo_source'] == 'default') {
            $_return = $this->determineLogoUseAndNeedCreateSwatches($client_id, $funnel_data);


            $swatches = $adata["swatches"];

            if ($swatches) {
                $result = explode("#", $swatches);
                $new_color = $this->hex2rgb($logo_color);
                $index = 0;
                array_unshift($result, implode('-', $new_color));

                // SET BACKGROUND COLOR
                $background_from_logo = '/*###>*/background-color: rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1);/*@@@*/
			background-image: linear-gradient(to right bottom,rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1) 0%,rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1) 100%); /* W3C */';

                $s = " select * from leadpop_background_color where client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $s .= " and active_backgroundimage = 'y'";
                $_count = $this->db->fetchAll($s);
                if ($_count) {
                    $active_backgroundimage = 'y';
                    $background_type = 3;
                } else {
                    $active_backgroundimage = 'n';
                    $background_type = 1;
                }
                $s = "update leadpop_background_color set background_color = '" . addslashes($background_from_logo) . "' ,
                        active_backgroundimage = '" . $active_backgroundimage . "',
                        background_type = $background_type, active = 'y' , default_changed = 'y'
                        WHERE client_id = $client_id
                        and leadpop_version_id  = $leadpop_version_id
                        and leadpop_version_seq = $version_seq";
                $this->db->query($s);

                foreach ($result as $key => $value) {

                    list($red, $green, $blue) = explode("-", $value);

                    if ($key < 1) {
                        $str0 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",1.0) 100%)";
                    } else {
                        $str0 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                    }

                    $str1 = "linear-gradient(to top, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                    $str2 = "linear-gradient(to bottom right, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                    $str3 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",1.0) 100%)";

                    $swatches = array($str0, $str1, $str2, $str3);
                    //debug($swatches);
                    for ($i = 0; $i < 4; $i++) {
                        $index++;
                        $is_primary = 'n';
                        if ($index == 1) {
                            $is_primary = 'y';
                        }
                        $s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
                        $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                        $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
                        $s .= "swatch,is_primary,active) values (null,";
                        $s .= $client_id . "," . $vertical_id . ",";
                        $s .= $subvertical_id . ",";
                        $s .= $leadpop_type_id . "," . $leadpop_template_id . ",";
                        $s .= $leadpop_id . ",";
                        $s .= $leadpop_version_id . ",";
                        $s .= $version_seq . ",";
                        $s .= "'" . addslashes($swatches[$i]) . "',";
                        $s .= "'" . $is_primary . "','y')";
                        $this->db->query($s);
                    }

                }
            }
        }

        return true;

    }

    private function getDefaultLogoName($vertical_id, $subvertical_id, $leadpop_version_id)
    {
        $s = "select logo_src from stock_leadpop_logos ";
        $s .= " where leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id . " limit 1 ";
        $src = $this->db->fetchOne($s);
        return $src;
    }

    public function changecolorschemes($client_id, $adata)
    {
        $registry = DataRegistry::getInstance();
        $vertical_id = $registry->leadpops->customVertical_id;
        $subvertical_id = $registry->leadpops->customSubvertical_id;
        $leadpop_id = $registry->leadpops->customLeadpopid;
        $version_seq = $registry->leadpops->customLeadpopVersionseq;
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select leadpop_template_id from leadpops where id = " . $leadpop_id;

        $leadpop_template_id = $this->db->fetchOne($s);

        $s = "select id from leadpops_templates_placeholders ";
        $s .= " where leadpop_template_id = " . $leadpop_template_id;
        $s .= " and client_id = " . $client_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $leadpops_templates_placeholders = $this->db->fetchAll($s);

        for ($i = 0; $i < count($leadpops_templates_placeholders); $i++) {
            $s = "update leadpops_templates_placeholders_values  set placeholder_sixtyfour = '" . $adata['currentcolor'] . "' ";
            $s .= "  where client_leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
            $this->db->query($s);
        }

    }

    public function hex2rgb($hex)
    {
        if (strpos($hex, 'rgba') !== false || strpos($hex, 'rgb') !== false) {
            preg_match_all('/\((.*?)\)/', $hex, $matches, PREG_SET_ORDER, 0);
            $colors = explode(",", $matches[0][1]);
            $r = trim($colors[0]);
            $g = trim($colors[1]);
            $b = trim($colors[2]);
        } else {
            $hex = str_replace("#", "", $hex);

            if (strlen($hex) == 3) {
                $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
                $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
                $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
            } else {
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
            }
        }
        $rgb = array($r, $g, $b);
        //return implode(",", $rgb); // returns the rgb values separated by commas
        return $rgb; // returns an array with the rgb values
    }

    function colorizeBasedOnAplhaChannelCopy($file, $target)
    {
        $targetName = dir_to_str($target, true);

        if (file_exists($targetName)) {
            unlink($targetName);
        }
        imagepng($file, $targetName);
        move_file_to_rackspace($targetName);
        //imagepng($img_handler, $target);
    }

    function colorizeBasedOnAplhaChannelImagesDestroy($img_handler_obj)
    {
        foreach ($img_handler_obj as $img_handler) {
            if ($img_handler) {
                imagedestroy($img_handler);
            }
        }
        return;
    }

    public function colorizeBasedOnAplhaChannnel($file, $targetR, $targetG, $targetB, $targetName, $return_ref = false)
    {
        $targetName = dir_to_str($targetName, true);

        if (file_exists($targetName)) {
            unlink($targetName);
        }

        $im_src = imagecreatefrompng($file);
        $width = imagesx($im_src);
        $height = imagesy($im_src);

        $im_dst = imagecreatefrompng($file);

        imagealphablending($im_dst, false);
        imagesavealpha($im_dst, true);
        imagealphablending($im_src, false);
        imagesavealpha($im_src, true);

        // Note this:
        // Let's reduce the number of colors in the image to ONE
        imagefilledrectangle($im_dst, 0, 0, $width, $height, 0xFFFFFF);

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {

                $alpha = (imagecolorat($im_src, $x, $y) >> 24 & 0xFF);
                $col = imagecolorallocatealpha($im_dst,
                    $targetR - (int)(1.0 / 255.0 * $alpha * (double)$targetR),
                    $targetG - (int)(1.0 / 255.0 * $alpha * (double)$targetG),
                    $targetB - (int)(1.0 / 255.0 * $alpha * (double)$targetB),
                    $alpha
                );
                if (false === $col) {
                    die('sorry, out of colors...');
                }
                imagesetpixel($im_dst, $x, $y, $col);
            }

        }
        imagepng($im_dst, $targetName);
        if ($return_ref == false) {
            move_file_to_rackspace($targetName);
        }
        /*var_dump($im_dst);
		print("dd".$file."dd");
		die($targetName);*/
        if ($return_ref == true) return $targetName;
        imagedestroy($im_dst);
    }

    /**
     * @since 2.1.0 - CR-Funnel-Builder:
     * Moved leadpops_templates_placeholders_values -> placeholder_seventythree   ==>   clients_leadpops -> funnel_variables::titletag_option
     * Moved leadpops_templates_placeholders_values -> placeholder_seventyfour   ==>   clients_leadpops -> funnel_variables::description_option
     * Moved leadpops_templates_placeholders_values -> placeholder_seventyfive   ==>   clients_leadpops -> funnel_variables::metatag_option
     *
     * @param $client_id int
     * @param $adata array
     * @param $funnel_data array
     */
    public function saveSeoOptions($client_id, $adata, $funnel_data = array())
    {

        if (is_array($funnel_data) && !(empty($funnel_data))) {
            $vertical_id = $funnel_data["funnel"]["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["funnel"]["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["funnel"]["leadpop_id"];
            $version_seq = $funnel_data["funnel"]["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "update seo_options set titletag = '" . addslashes($adata['titletag']) . "', ";
        $s .= "description = '" . addslashes($adata['description']) . "', metatags = '" . addslashes($adata['metatags']) . "' ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);

        $s = "select * from seo_options ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;

        $seoOptions = $this->db->fetchRow($s);

        $seo_variables = array();
        if ($seoOptions['titletag_active'] == 'y') $seo_variables[FunnelVariables::SEO_TITLE_TAG] = $adata['titletag'];
        else $seo_variables[FunnelVariables::SEO_TITLE_TAG] = "";

        if ($seoOptions['description_active'] == 'y') $seo_variables[FunnelVariables::SEO_DESCRIPTION] = $adata['description'];
        else $seo_variables[FunnelVariables::SEO_DESCRIPTION] = "";

        if ($seoOptions['metatags_active'] == 'y') $seo_variables[FunnelVariables::SEO_KEYWORD] = $adata['metatags'];
        else $seo_variables[FunnelVariables::SEO_KEYWORD] = "";

        $this->updateFunnelVariables($seo_variables, $client_id, $leadpop_id, $version_seq);
    }

    /**
     * @since 2.1.0 - CR-Funnel-Builder: Removed leadpops_templates_placeholders_values -> placeholder_seventyone
     *
     * @param $client_id int
     * @param $adata array
     * @param $funnel_data array
     */
    public function saveHtmlAutoOptions($client_id, $adata, $funnel_data = array())
    {
        // var_dump($adata); exit;
        if (is_array($funnel_data) && !empty($funnel_data)) { // v2 override for registery data
            $vertical_id = $funnel_data["funnel"]["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["funnel"]["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["funnel"]["leadpop_id"];
            $version_seq = $funnel_data["funnel"]["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;

        }
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "update autoresponder_options set html = '" . addslashes($adata['htmlautoeditor']) . "', ";
        $s .= "subject_line = '" . addslashes($adata['slineh']) . "' , ";
        $s .= "html_active = 'y',  ";
        $s .= "text_active = 'n'  ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);

        $s = "select * from autoresponder_options ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;

        $autoOptions = $this->db->fetchRow($s);

        $s = "select leadpop_template_id from leadpops where id = " . $leadpop_id;
        $leadpop_template_id = $this->db->fetchOne($s);
    }

    /**
     * @since 2.1.0 - CR-Funnel-Builder: Removed leadpops_templates_placeholders_values -> placeholder_seventytwo
     *
     * @param $client_id int
     * @param $adata array
     * @param $funnel_data array
     */
    public function saveTextAutoOptions($client_id, $adata, $funnel_data = array())
    {
        //      var_dump($adata); exit;
        if (is_array($funnel_data) && !empty($funnel_data)) {
            $vertical_id = $funnel_data["funnel"]["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["funnel"]["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["funnel"]["leadpop_id"];
            $version_seq = $funnel_data["funnel"]["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "update autoresponder_options set thetext = '" . addslashes($adata['textautoeditor']) . "', ";
        $s .= "subject_line = '" . addslashes($adata['slinet']) . "' , ";
        $s .= "text_active = 'y',  ";
        $s .= "html_active = 'n'   ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);

        $s = "select * from autoresponder_options ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;

        $autoOptions = $this->db->fetchRow($s);

        $s = "select leadpop_template_id from leadpops where id = " . $leadpop_id;
        $leadpop_template_id = $this->db->fetchOne($s);

    }

    /**
     * Concat company name in SEO tag title and save if any change in title after appending company name
     * Will be executed when update contact information from global setting OR funnel specific page
     * @param $companyName
     * @param $params
     * @param $funnel_variables
     */
    public function concatCompanyNameAndSaveSeoTagTitle($companyName, $wereClauseParams, &$funnel_variables)
    {
        $seoOptions = \DB::table("seo_options")
            ->select("titletag", "titletag_active")
            ->where($wereClauseParams)
            ->first();

        if ($seoOptions) {
            $titleTag = $seoOptions->titletag;
            if (!empty($titleTag)) {
                $titleTagArr = explode("|", $titleTag);
                $newTagTitle = trim($titleTagArr[0]) . " | " . $companyName;
            } else {
                $newTagTitle = $titleTag . " | " . $companyName;
            }

            //only updating when old titleTag and new title didn't same
            if ($newTagTitle !== $titleTag) {
                \DB::table("seo_options")
                    ->where($wereClauseParams)
                    ->update([
                            'titletag' => $newTagTitle]
                    );

                if ($seoOptions->titletag_active == 'y') {
                    $funnel_variables[FunnelVariables::SEO_TITLE_TAG] = $newTagTitle;
                } else {
                    $funnel_variables[FunnelVariables::SEO_TITLE_TAG] = "";
                }
            }
        }
    }

    public function saveTextandHtmlAutoOptions($data, $funnel_data = array())
    {
        //      var_dump($adata); exit;
        if (is_array($funnel_data) && !empty($funnel_data)) {
            $vertical_id = $funnel_data["funnel"]["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["funnel"]["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["funnel"]["leadpop_id"];
            $version_seq = $funnel_data["funnel"]["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "update autoresponder_options set html = '" . addslashes($data['htmlautoeditor']) . "', ";
        $s .= "thetext = '" . addslashes($data['textautoeditor']) . "' , ";
        $s .= "subject_line = '" . addslashes($data['sline']) . "' , ";
        $s .= "text_active = '" . addslashes($data['active_respondertext']) . "' , ";
        $s .= "html_active = '" . addslashes($data['active_responderhtml']) . "'  ";
        $s .= " where client_id = " . $data['client_id'];
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);
    }

    /**
     * @since 2.1.0 - CR-Funnel-Builder:
     * Moved leadpops_templates_placeholders_values -> placeholder_sixtysix   ==>   clients_leadpops -> funnel_variables::my_company_name
     * Moved leadpops_templates_placeholders_values -> placeholder_sixtyseven   ==>   clients_leadpops -> funnel_variables::my_company_phone
     * Moved leadpops_templates_placeholders_values -> placeholder_sixtyeight   ==>   clients_leadpops -> funnel_variables::my_company_email
     *
     * @param $client_id int
     * @param $adata array
     * @param $funnel_data array
     */
    public function saveContactOptions($client_id, $adata, $funnel_data = array())
    {
        //var_dump($adata); exit;
        if (is_array($funnel_data) && !empty($funnel_data)) {
            $vertical_id = $funnel_data["funnel"]["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["funnel"]["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["funnel"]["leadpop_id"];
            $version_seq = $funnel_data["funnel"]["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];
        //debug($s);


        $s = "select * from contact_options ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;

        $contactOptions = $this->db->fetchRow($s);

        $funnel_variables = array();
        if ($contactOptions) {

            $s = "update contact_options set companyname = '" . addslashes($adata['companyname']) . "', ";
            $s .= "phonenumber = '" . $adata['phonenumber'] . "', email = '" . $adata['email'] . "' ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            $this->db->query($s);

            if ($contactOptions['companyname_active'] == 'y') $funnel_variables[FunnelVariables::CONTACT_COMPANY] = $adata['companyname'];
            else $funnel_variables[FunnelVariables::CONTACT_COMPANY] = "";

            if ($contactOptions['phonenumber_active'] == 'y') $funnel_variables[FunnelVariables::CONTACT_PHONE] = $adata['phonenumber'];
            else $funnel_variables[FunnelVariables::CONTACT_PHONE] = "";

            if ($contactOptions['email_active'] == 'y') $funnel_variables[FunnelVariables::CONTACT_EMAIL] = $adata['email'];
            else $funnel_variables[FunnelVariables::CONTACT_EMAIL] = "";

        } else {
            $s = "insert into contact_options (client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,
                  leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,leadpop_version_seq
                  ,companyname,phonenumber,email,companyname_active,phonenumber_active,email_active) values($client_id,$leadpop_id,$leadpop_type_id,$vertical_id,
                  $subvertical_id,$leadpop_template_id,$leadpop_version_id,$version_seq,
                 '" . addslashes($adata['companyname']) . "', '" . $adata['phonenumber'] . "', '" . $adata['email'] . "'
                 , 'n', 'y' , 'n'
                 )";
            $this->db->query($s);
            $funnel_variables[FunnelVariables::CONTACT_COMPANY] = '';
            $funnel_variables[FunnelVariables::CONTACT_PHONE] = $adata['phonenumber'];
            $funnel_variables[FunnelVariables::CONTACT_EMAIL] = '';
        }


        if (!$contactOptions || $contactOptions["companyname"] != $adata['companyname']) {
            $this->concatCompanyNameAndSaveSeoTagTitle($adata['companyname'], [
                'client_id' => $client_id,
                'leadpop_id' => $leadpop_id,
                'leadpop_type_id' => $leadpop_type_id,
                'leadpop_vertical_id' => $vertical_id,
                'leadpop_vertical_sub_id' => $subvertical_id,
                'leadpop_template_id' => $leadpop_template_id,
                'leadpop_version_id' => $leadpop_version_id,
                'leadpop_version_seq' => $version_seq
            ], $funnel_variables);
        }

        $this->updateFunnelVariables($funnel_variables, $client_id, $leadpop_id, $version_seq);
    }

    public function globalsaveContactOptions($client_id, $adata)
    {

        extract($_POST, EXTR_OVERWRITE, "form_");

        if (!isset($adata['selected_funnels'])) {
            return false;
        }

        $lplist = explode(",", $adata['selected_funnels']);
        if (!count($lplist)) {
            echo 'please select global funnels ';
            exit;
        }

        //start add current Funnel key
        $currentHash = $_POST['current_hash'];
        $currentKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        if (!empty($currentKey)) {
            array_push($lplist, $currentKey);
        }
        //end add current Funnel key

        $lplist = array_unique($lplist);

        foreach ($lplist as $index => $lp) {

            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];

            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);
            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];

            $s = "update contact_options  set companyname_active = '" . $companyname_active . "',phonenumber_active = '" . $phonenumber_active . "',email_active = '" . $email_active . "' ";

            if ($adata['companyname']) {
                $s .= ", companyname = '" . addslashes($adata['companyname']) . "'";
            }
            if ($adata['phonenumber']) {
                $s .= ", phonenumber = '" . addslashes($adata['phonenumber']) . "'";
            }
            if ($adata['email']) {
                $s .= ", email = '" . $adata['email'] . "'";
            }

            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $this->db->query($s);


            $s = "select leadpop_template_id from leadpops where id = " . $leadpop_id;
            $leadpop_template_id = $this->db->fetchOne($s);

            $funnel_variables = array();
            if ($companyname_active == 'y') {
                if ("" != $adata['companyname'] && null != $adata['companyname']) {
                    $funnel_variables[FunnelVariables::CONTACT_COMPANY] = $adata['companyname'];
                }
            }


            if ($phonenumber_active == 'y') {
                if ("" != $adata['phonenumber'] && null != $adata['phonenumber']) {
                    $funnel_variables[FunnelVariables::CONTACT_PHONE] = $adata['phonenumber'];
                }
            }

            if ($email_active == 'y') {
                if ("" != $adata['email'] && null != $adata['email']) {
                    $funnel_variables[FunnelVariables::CONTACT_EMAIL] = $adata['email'];
                }
            }

            $this->concatCompanyNameAndSaveSeoTagTitle($adata['companyname'], [
                'client_id' => $client_id,
                'leadpop_id' => $leadpop_id,
                'leadpop_type_id' => $leadpop_type_id,
                'leadpop_vertical_id' => $leadpop_vertical_id,
                'leadpop_vertical_sub_id' => $leadpop_vertical_sub_id,
                'leadpop_template_id' => $leadpop_template_id,
                'leadpop_version_id' => $leadpop_version_id,
                'leadpop_version_seq' => $leadpop_version_seq
            ], $funnel_variables);

            $this->updateFunnelVariables($funnel_variables, $client_id, $leadpop_id, $leadpop_version_seq);
        }
//        $s = "select * from global_settings where client_id = " . $client_id;
//        $client = $this->db->fetchRow($s);

//        if (!$client) {
//            $s = "insert into global_settings (id,client_id,companyname,phonenumber,email,";
//            $s .= "companyname_active,phonenumber_active,email_active) values (null,";
//            $s .= $client_id . ",'" . $adata['companyname'] . "','" . $adata['phonenumber'] . "','" . $adata['email'] . "','" . $companyname_active . "','" . $phonenumber_active . "','" . $email_active . "') ";
//            $this->db->query($s);
//        } else {
//            $s = "update global_settings set companyname_active = '" . $companyname_active . "',phonenumber_active = '" . $phonenumber_active . "',email_active = '" . $email_active . "' ,";
//            $s .= " companyname = '" . addslashes($adata['companyname']) . "', phonenumber = '" . $adata['phonenumber'] . "', email = '" . $adata['email'] . "'";
//            $s .= " where client_id = " . $client_id;
//            $this->db->query($s);
//        }
        return true;
    }

    /**
     * Update Global module thank you page settings
     *
     * @param $client_id
     * @param $adata
     * @throws Exception
     */
    public function globalsavethankyouoptions($client_id, $adata)
    {
        extract($_POST, EXTR_OVERWRITE, "form_");
        $thirdpartyurl = str_replace(array('http://', 'https://'), '', $footereditor);
        $httpsflag = 'n';
        if (isset($https_flag) && $https_flag == 'https://') {
            $httpsflag = 'y';
            $thirdpartyurl = 'https://' . $thirdpartyurl;
        } else {
            $thirdpartyurl = 'http://' . $thirdpartyurl;
        }
        if (!isset($adata['selected_funnels'])) {
            echo 'please select global funnels ';
            exit;
        }

        $lplist = explode(",", $adata['selected_funnels']);
        if (!count($lplist)) {
            echo 'please select global funnels ';
            exit;
        }

        //start add current Funnel key
        $currentHash = $_POST['current_hash'];
        $currentKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        if (!empty($currentKey)) {
            array_push($lplist, $currentKey);
        }
        //end add current Funnel key

        $lplist = array_unique($lplist);


        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];
            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);
            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];


            $s = "update submission_options  set thankyou_active = '" . $thankyou_active . "', thirdparty_active = '" . $thirdparty_active . "'";

            if ($thirdpartyurl) {
                $s .= " ,https_flag  = '" . $httpsflag . "' ";
                $s .= " ,thirdparty  = '" . $thirdpartyurl . "' ";
            }
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            if (env('APP_ENV') !== config('app.env_production')) {
                Log::channel('myleads')->info('[Global Thank you] ' . $s);
            }
            $this->db->query($s);

            $s = "select count(*) as cnt from google_goals ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $cnt = $this->db->fetchOne($s);
            if ($cnt > 0) {
                $s = "update google_goals set url =  '" . addslashes(@$goalurl) . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                // die($s);
                $this->db->query($s);
            } else {
                $s = "insert into google_goals (id,client_id,leadpop_id,leadpop_type_id,";
                $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
                $s .= "leadpop_version_id,leadpop_version_seq,url) values (null," . $client_id . ",";
                $s .= $leadpop_id . "," . $leadpop_type_id . "," . $leadpop_vertical_id . "," . $leadpop_vertical_sub_id . ",";
                $s .= $leadpop_template_id . "," . $leadpop_version_id . "," . $leadpop_version_seq . ",'" . addslashes(@$goalurl) . "')";
                $this->db->query($s);
            }
        }


//        $s = "select * from global_settings where client_id = " . $client_id;
//        $client = $this->db->fetchRow($s);


//        if (!$client) {
//            \DB::table('global_settings')->insert([
//                'id' => null,
//                'client_id' => $client_id,
//                'thankyou_active' => $thankyou_active,
//                'thankyou_thirdparty_active' => $thirdparty_active,
//                'thankyou_https_flag' => $httpsflag,
//                'thankyou_thirdparty_url' => $footereditor
//            ]);
//        } else {
//
//            $s = "update global_settings set  thankyou_active = '" . $thankyou_active . "'
//                    , thankyou_thirdparty_active = '" . $thirdparty_active . "'
//                    , thankyou_thirdparty_url = '" . $footereditor . "'
//                    , thankyou_https_flag = '" . $httpsflag . "' ";
//            $s .= " where client_id = " . $client_id;
//            $this->db->query($s);
//
//        }
    }


    public function globalsavethankyouMessage($client_id, $adata)
    {
        //theselectiontype
        //tfootereditor
        extract($_POST, EXTR_OVERWRITE, "form_");
//        $lplist = explode(",", $footereditor);
        //if (isset($thirdparty_active) ) {
        //}
        //$thirdpartyurl=$thirdpartyurl;
        //debug($thirdpartyurl);



        if (!isset($adata['selected_funnels'])) {
            echo 'please select global funnels ';
            exit;
        }
        $lplist = explode(",", $adata['selected_funnels']);
        if (empty($lplist) || !count($lplist)) {
            echo 'please select global funnels ';
            exit;
        }

        //start add current Funnel key
        $currentHash = $_POST['current_hash'];
        $currentKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        if (!empty($currentKey)) {
            array_push($lplist, $currentKey);
        }
        $lplist = array_unique($lplist);
        //end add current Funnel key



        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $vertical_id = $leadpop_vertical_id = $lpconstt[0];
            $subvertical_id = $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $version_seq = $leadpop_version_seq = $lpconstt[3];


            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);
            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];


            //  \DB::enableQueryLog(); // Enable query log
            $update = [
                'thankyou' => stripslashes($adata['tfootereditor']),
                'thankyou_slug' => addslashes($adata['thankyou_slug']),
            ];

            if (array_key_exists("thankyou_logo", $adata)) {
                $update['thankyou_logo'] = $adata["thankyou_logo"];
            }

            //  dd($update);
            $query = \DB::table('submission_options')->where([
                'client_id' => $client_id,
                'leadpop_version_id' => $leadpop_version_id,
                'leadpop_version_seq' => $version_seq
            ])->update($update);


// Your Eloquent query executed by using get()

            //   dd(\DB::getQueryLog()); // Show results of log


            // dd($query->toSql(), $query->getBindings());

            /**
             * TODO:CLEAN-UP
             * @deprecated unnecessary code block
             * No any return statement
             * No insert/update statement
             *
            $s = "select * from submission_options ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;

            $submissionOptions = $this->db->fetchRow($s);

            //  print ($submissionOptions['thankyou_active']);


            if ($adata['theoption'] == 'thankyou' &&
                isset($submissionOptions['thankyou_active']) &&
                $submissionOptions['thankyou_active'] == 'y') {
                //    dd($submissionOptions);
                $s = "select leadpop_template_id from leadpops where id = " . $leadpop_id;
                $leadpop_template_id = $this->db->fetchOne($s);

                $s = "select subdomain_name,top_level_domain from clients_subdomains ";
                $s .= "where client_id = " . $client_id . " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $tempdomain = $this->db->fetchRow($s);
                if ($tempdomain) {
                    $domain = $tempdomain['subdomain_name'] . "." . $tempdomain['top_level_domain'];
                } else {
                    $s = "select domain_name from clients_domains ";
                    $s .= "where client_id = " . $client_id . " and leadpop_vertical_id = " . $vertical_id;
                    $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                    $s .= " and leadpop_template_id = " . $leadpop_template_id;
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_type_id = " . $leadpop_type_id;
                    $s .= " and leadpop_version_id = " . $leadpop_version_id;
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $tempdomain = $this->db->fetchOne($s);
                    $domain = $this->db->fetchOne($s);
                }

                $_http = "http://";
                if (@$submissionOptions['https_flag'] == 'y') {
                    $_http = "https://";
                }

                $cookieName = str_replace(".", "_", $domain);
                $v = "\n\n<script type='text/javascript'>\n ";

                $v .= " var to = ''; \n";
                $v .= " to = setTimeout(function() { window.location.replace('" . $_http . $domain . "')  },1000); \n";
                $v .= " </script>";

            } else if ($adata['theoption'] == 'information' && $submissionOptions['information_active'] == 'y') {
                $s = "select leadpop_template_id from leadpops where id = " . $leadpop_id;
                $leadpop_template_id = $this->db->fetchOne($s);

                $s = "select subdomain_name,top_level_domain from clients_subdomains ";
                $s .= "where client_id = " . $client_id . " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $tempdomain = $this->db->fetchRow($s);
                if ($tempdomain) {
                    $domain = $tempdomain['subdomain_name'] . "." . $tempdomain['top_level_domain'];
                } else {
                    $s = "select domain_name from clients_domains ";
                    $s .= "where client_id = " . $client_id . " and leadpop_vertical_id = " . $vertical_id;
                    $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                    $s .= " and leadpop_template_id = " . $leadpop_template_id;
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_type_id = " . $leadpop_type_id;
                    $s .= " and leadpop_version_id = " . $leadpop_version_id;
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $tempdomain = $this->db->fetchOne($s);
                    $domain = $this->db->fetchOne($s);
                }

            } else if ($adata['theoption'] == 'thirdparty' && $submissionOptions['thirdparty_active'] == 'y') {
                $s = "select leadpop_template_id from leadpops where id = " . $leadpop_id;
                $leadpop_template_id = $this->db->fetchOne($s);

                $s = "select subdomain_name,top_level_domain from clients_subdomains ";
                $s .= "where client_id = " . $client_id . " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $tempdomain = $this->db->fetchRow($s);
                if ($tempdomain) {
                    $domain = $tempdomain['subdomain_name'] . "." . $tempdomain['top_level_domain'];
                } else {
                    $s = "select domain_name from clients_domains ";
                    $s .= "where client_id = " . $client_id . " and leadpop_vertical_id = " . $vertical_id;
                    $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                    $s .= " and leadpop_template_id = " . $leadpop_template_id;
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_type_id = " . $leadpop_type_id;
                    $s .= " and leadpop_version_id = " . $leadpop_version_id;
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $tempdomain = $this->db->fetchOne($s);
                    $domain = $this->db->fetchOne($s);
                }

                if (!isset($thirdpartyurl) && $thirdpartyurl == "") {
                    $thirdpartyurl = str_replace(array('http://', 'https://'), '', $adata['footereditor']);
                    //$thirdpartyurl = str_replace('http://', '', $adata['footereditor']);
                    if (isset($adata['https_flag']) && $adata['https_flag'] == 'on') {
                        $thirdpartyurl = 'https://' . $thirdpartyurl;
                    } else {
                        $thirdpartyurl = 'http://' . $thirdpartyurl;
                    }
                }

                $v = "\n\n<script type='text/javascript'>\n ";
                $v .= " var to = ''; \n";
                $v .= " to = setTimeout(function() { window.location.replace('" . $thirdpartyurl . "')  },1000); \n";
                $v .= " </script>";
                $w = "<style>";
                $w .= "	@font-face {";
                $w .= "	  font-family: 'Open Sans';";
                $w .= "	  font-style: Bold;";
                $w .= "	  font-weight: 600;";
                $w .= "	  src: local('Open Sans'), local('Open Sans-Bold'), url(http://themes.googleusercontent.com/static/fonts/opensans/v6/DXI1ORHCpsQm3Vp6mXoaTaRDOzjiPcYnFooOUGCOsRk.woff) format('woff')";
                $w .= "	}	";
                $w .= "</style>";
                $w .= "<div align='center' style='margin-top: 50px'>";
                $w .= "<p align='center' style='font-family: Open Sans; font-size: 18px;'>";
                $w .= "Thanks for your request.<br /> Please wait a few seconds as we load your next destination...";
                $w .= "</p>";
                $w .= "<p align='center' style='text-align: center'>";
                $w .= "<img src='/images/blueass.gif' border='0'></img>";
                $w .= "</p>";
                $w .= "</div>";

            }
            */

        } //End foreach


//        $s = "select * from global_settings where client_id = " . $client_id;
//        $client = $this->db->fetchRow($s);
//
//
//        if (!$client) {
//
//            \DB::table('global_settings')->insert([
//                'id' => null,
//                'client_id' => $client_id,
//                'thankyou_message' => addslashes($adata['tfootereditor'])
//            ]);
//        } else {
//
//            \DB::table('global_settings')->where('client_id', $client_id)
//                ->update(['thankyou_message' => addslashes($adata['tfootereditor'])
//                ]);
//
//        }
    }

    /**
     * This function saves Updates all the rows for auto-responder
     *
     * @param $client_id
     * @param $request
     * @return bool
     * @throws Exception
     */
    public function saveglobalautoresponder($client_id, $request)
    {
        if (!isset($request->selected_funnels)) {
            return false;
        }

        $lplist = explode(",", $request->selected_funnels);
        if (!count($lplist)) {
            echo 'Please select Funnels for global action. ';
            exit;
        }

        //start add current Funnel key
        $currentHash = $_POST['current_hash'];
        $currentKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        if (!empty($currentKey)) {
            array_push($lplist, $currentKey);
        }
        //end add current Funnel key

        $lplist = array_unique($lplist);

        foreach ($lplist as $index => $lp) {

            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];

            $leadpopRecord = Leadpops::find($leadpop_id);

            // $requestresponder_active = $request->active;


            // $s = "update autoresponder_options set  html_active = '" . $request->active_responderhtml . "' , text_active = '" . $request->active_respondertext . "' , active = '" . $requestresponder_active . "' ";
            // if (isset($request->sline) && $request->sline != '') {
            //     $s .= ", subject_line = '" . addslashes(trim($request->sline)) . "'";
            // }
            // if ("" != $request->htmlautoeditor && null != $request->htmlautoeditor) {
            //     if ($request->active_responderhtml == 'y') {
            //         $s .= ", html = '" . addslashes($request->htmlautoeditor) . "' ";
            //     }
            // }

            // if ("" != $request->textautoeditor && null != $request->textautoeditor) {
            //     if ($request->active_respondertext == 'y') {
            //         $s .= ", thetext = '" . addslashes($request->textautoeditor) . "' ";
            //     }
            // }

            // $s .= " where client_id = " . $client_id;
            // $s .= " and leadpop_id = " . $leadpop_id;
            // $s .= " and leadpop_type_id = " . $leadpopRecord->leadpop_type_id;
            // $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
            // $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            // $s .= " and leadpop_template_id = " . $leadpopRecord->leadpop_template_id;
            // $s .= " and leadpop_version_id = " . $leadpopRecord->leadpop_version_id;
            // $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            // $this->db->query($s);


            $whereData = [
                'client_id'               => $client_id,
                'leadpop_id'              => $leadpop_id,
                'leadpop_type_id'         => $leadpopRecord->leadpop_type_id,
                'leadpop_vertical_id'     => $leadpop_vertical_id,
                'leadpop_vertical_sub_id' => $leadpop_vertical_sub_id,
                'leadpop_template_id'     => $leadpopRecord->leadpop_template_id,
                'leadpop_version_id'      => $leadpopRecord->leadpop_version_id,
                'leadpop_version_seq'     => $leadpop_version_seq
            ];


            $updateData = [
                'text_active'  => $request->active_respondertext ?? 'n',
                'active'       => $request->active ?? 'n',
                'html_active'  => $request->active_responderhtml ?? 'n',
                'date_updated' => Carbon::now()->toDateTimeString()
            ];

            if ("" != $request->htmlautoeditor && null != $request->htmlautoeditor) {
                if ($request->active_responderhtml == 'y') {
                   $updateData['html'] = $request->htmlautoeditor;
                }
            }

            if ("" != $request->textautoeditor && null != $request->textautoeditor) {
                if ($request->active_respondertext == 'y') {
                    $updateData['thetext'] = $request->textautoeditor;
                }
            }

            if (isset($request->sline) && $request->sline != '') {
                $updateData['subject_line'] = trim($request->sline);
            }

            AutoResponderOption::updateOrCreate($whereData, $updateData);
        }

//        $s = "select * from global_settings where client_id = " . $client_id;
//        $client = $this->db->fetchRow($s);
//
//        if (!$client) {
//
//            \DB::table('global_settings')->insert([
//                'id' => null,
//                'client_id' => $client_id,
//                'subline' => $request->sline,
//                'autoresponder_html' => $request->htmlautoeditor,
//                'autoresponder_html_active' => $request->active_responderhtml,
//                'autoresponder_text' => $request->textautoeditor,
//                'autoresponder_text_active' => $request->active_respondertext,
//
//            ]);
//        } else {
//
//            \DB::table('global_settings')->where('client_id', $client_id)->update([
//                'subline' => $request->sline,
//                'autoresponder_html' => $request->htmlautoeditor,
//                'autoresponder_html_active' => $request->active_responderhtml,
//                'autoresponder_text' => $request->textautoeditor,
//                'autoresponder_text_active' => $request->active_respondertext,
//
//            ]);
//
//        }

        return true;

    }





    public function saveglobalmaincontent($client_id, $mainContentData, $request)
    {


        if (!isset($request->selected_funnels)) {
            return false;
        }

        $lplist = explode(",", $request->selected_funnels);
        if (!count($lplist)) {
            echo 'please select global funnels ';
            exit;
        }

        //start add current Funnel key
        $currentHash = $_POST['current_hash'];
        $currentKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        if (!empty($currentKey)) {
            array_push($lplist, $currentKey);
        }
        $lplist = array_unique($lplist);
        //end add current Funnel key


        $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);

        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];

            /* $s = "select * from leadpops where id = " . $leadpop_id;
             $lpres = $this->db->fetchRow($s);*/

            $lpres = $lpListCollection->where('leadpop_id', $leadpop_id)->first();

            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];

            if ("" != $mainContentData->mainheadingval && null != $mainContentData->mainheadingval) {
                $span = '<span style="font-family: ' . $mainContentData->thefont . '; font-size:' . $mainContentData->thefontsize . '; color: ' . $mainContentData->savestyle . ';line-height:' . $mainContentData->lineheight . ';">' . $mainContentData->mainheadingval . '</span>';

                if ($mainContentData->contenttype == 'mainmessage') {
                    $this->updateLeadLine(FunnelVariables::LEAD_LINE, $span, $client_id, $leadpop_id, $leadpop_version_seq);
                    $this->updateFunnelVar(FunnelVariables::FONT_FAMILY, $mainContentData->thefont, $client_id, $leadpop_id, $leadpop_version_seq);
                } else {
                    $this->updateLeadLine(FunnelVariables::SECOND_LINE, $span, $client_id, $leadpop_id, $leadpop_version_seq);
                    $this->updateFunnelVar(FunnelVariables::FONT_FAMILY_DESC, $mainContentData->thefont, $client_id, $leadpop_id, $leadpop_version_seq);
                }
            }
        }

        return true;
    }

    public function uploadglobalimage($afiles, $client_id)
    {

        $afiles['image']['name'] = preg_replace('/[^\.a-zA-Z0-9]/', '', $afiles['image']['name']);
        $imagename = strtolower($client_id . "_global_" . $afiles['image']['name']);
        $section = substr($client_id, 0, 1);
        $imagepath = $section . '/' . $client_id . '/pics/' . $imagename;
        $imageurl = getCdnLink() . '/pics/' . $imagename;
        list($src_w, $src_h, $type) = getimagesize($afiles['image']["tmp_name"]);
        move_uploaded_file($afiles['image']['tmp_name'], $imagepath);

//        $s = "select * from global_settings where client_id = " . $client_id;
//        $client = $this->db->fetchRow($s);


//        if (!$client) {
//            $s = "insert into global_settings (id,client_id,image,";
//            $s .= "image_url,image_path) values (null,";
//            $s .= $client_id . ",'" . addslashes($imagename) . "','" . addslashes($imageurl) . "','" . addslashes($imagepath) . "') ";
//            $this->db->query($s);
//        } else {
//            $s = "update global_settings set image = '" . $imagename . "',image_url = '" . $imageurl . "',image_path = '" . $imagepath . "'";
//            $s .= " where client_id = " . $client_id;
//            $this->db->query($s);
//        }
        return 'ok';
    }

    public function saveglobalimage($data, $client_id)
    {
        extract($_POST, EXTR_OVERWRITE, "form_");
        $lplist = explode(",", $lpkey_image);
        $file = file_get_contents($image_url);

        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];
            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);

            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];

            if ($use_me == 'y') {
                $replaced = $client_id . "_global_";
                $image = str_replace($replaced, "", $image);
                $imagename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $leadpop_vertical_id . "_" . $leadpop_vertical_sub_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $leadpop_version_seq . "_" . $image);
                $section = substr($client_id, 0, 1);
                $newimagepath = $section . '/' . $client_id . '/pics/' . $imagename;

                $cmd = '/bin/cp   ' . $image_path;
                $cmd .= '            ' . $newimagepath;
                exec($cmd);
                $s = "update leadpop_images  set numpics = 1,image_src = '" . $imagename . "', use_me = '" . $use_me . "' , use_default = '" . $use_default . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                $this->db->fetchRow($s);
                $imagesrc = $this->getHttpServer() . '/images/clients/' . $section . '/' . $client_id . '/pics/' . $imagename;
            }
            if ($use_default == "y") {
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
                $imagesrc = getCdnLink() . '/pics/' . $imagename;

                $s = "update leadpop_images  set use_default = '" . $use_default . "',use_me = '" . $use_me . "' , image_src = '" . $imagename . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                $this->db->query($s);
            }
            if ($use_default == 'n' && $use_me == 'n') {
                $s = "update leadpop_images  set use_default = '" . $use_default . "',use_me = '" . $use_me . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                $this->db->query($s);
            }

            $s = "select id from leadpops_templates_placeholders ";
            $s .= " where leadpop_template_id = " . $leadpop_template_id;
            $s .= " and client_id = " . $client_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $leadpops_templates_placeholders = $this->db->fetchAll($s);
            if ($use_default == 'n' && $use_me == 'n') {
                for ($i = 0; $i < count($leadpops_templates_placeholders); $i++) {
                    $s = " update leadpops_templates_placeholders_values  set placeholder_sixtyone = '' where client_leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
                    $this->db->query($s);
                }
            } else {
                for ($i = 0; $i < count($leadpops_templates_placeholders); $i++) {
                    $s = " update leadpops_templates_placeholders_values  set placeholder_sixtyone = '" . $imagesrc . "'  where client_leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
                    $this->db->query($s);
                }
            }
        }
        return "ok";

    }


    public function saveGoogleGoals($client_id, $adata)
    {
        $registry = DataRegistry::getInstance();
        $vertical_id = $registry->leadpops->customVertical_id;
        $subvertical_id = $registry->leadpops->customSubvertical_id;
        $leadpop_id = $registry->leadpops->customLeadpopid;
        $version_seq = $registry->leadpops->customLeadpopVersionseq;
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select count(*) as cnt from google_goals ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $cnt = $this->db->fetchOne($s);
        if ($cnt > 0) {
            $s = "update google_goals set url =  '" . addslashes($adata['footerdogs']) . "' ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
//            /  die($s);
            $this->db->query($s);
        } else {
            $s = "insert into google_goals (id,client_id,leadpop_id,leadpop_type_id,";
            $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
            $s .= "leadpop_version_id,leadpop_version_seq,url) values (null," . $client_id . ",";
            $s .= $leadpop_id . "," . $leadpop_type_id . "," . $vertical_id . "," . $subvertical_id . ",";
            $s .= $leadpop_template_id . "," . $leadpop_version_id . "," . $version_seq . ",'" . addslashes($adata['footerdogs']) . "')";
            $this->db->query($s);
        }
    }

    /**
     * TODO:CLEAN-UP
     * @duplicate function
     * @since 2.1.0 - CR-Funnel-Builder: Removed leadpops_templates_placeholders_values -> placeholder_sixtyfive
     *
     * @param $client_id int
     * @param $adata array
     * @param $funnel_data array
     *
    public function saveSubmissionOptions($client_id, $adata, $funnel_data = array())
    {
        //var_dump($adata); exit;
        if (is_array($funnel_data) && !empty($funnel_data)) {
            $vertical_id = $funnel_data["funnel"]["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["funnel"]["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["funnel"]["leadpop_id"];
            $version_seq = $funnel_data["funnel"]["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;
        }
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);


        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        if ($adata['theoption'] == "thirdparty") {
            $https_flag = 'n';
            $thirdpartyurl = str_replace(array('http://', 'https://'), '', $adata['footereditor']);
            //$thirdpartyurl = str_replace('http://', '', $adata['footereditor']);
            if (isset($adata['https_flag']) && ($adata['https_flag'] == 'on' || $adata['https_flag'] == "https://")) {
                $https_flag = 'y';
                $thirdpartyurl = 'https://' . $thirdpartyurl;
            } else {
                $thirdpartyurl = 'http://' . $thirdpartyurl;
            }
            $s = "update submission_options set https_flag = '$https_flag', " . $adata['theoption'] . " = '" . $thirdpartyurl . "' ";
            if (array_key_exists("thankyou_logo", $adata)) {
                $s .= ", thankyou_logo  = " . $adata["thankyou_logo"];
            }
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            $this->db->query($s);

        } else {
            $s = "update submission_options set " . $adata['theoption'] . " = '" . addslashes($adata['tfootereditor']) . "', ";
            $s .= " thankyou_slug  = '" . $adata['thankyou_slug'] . "' ";
            if (array_key_exists("thankyou_logo", $adata)) {
                $s .= ", thankyou_logo  = " . $adata["thankyou_logo"];
            }
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            $this->db->query($s);
        }


        $s = "select * from submission_options ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;

        $submissionOptions = $this->db->fetchRow($s);


        if ($adata['theoption'] == 'thankyou' && $submissionOptions['thankyou_active'] == 'y') {
            $s = "select leadpop_template_id from leadpops where id = " . $leadpop_id;
            $leadpop_template_id = $this->db->fetchOne($s);

            $s = "select subdomain_name,top_level_domain from clients_subdomains ";
            $s .= "where client_id = " . $client_id . " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            $tempdomain = $this->db->fetchRow($s);
            if ($tempdomain) {
                $domain = $tempdomain['subdomain_name'] . "." . $tempdomain['top_level_domain'];
            } else {
                $s = "select domain_name from clients_domains ";
                $s .= "where client_id = " . $client_id . " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $tempdomain = $this->db->fetchOne($s);
                $domain = $this->db->fetchOne($s);
            }

            $_http = "http://";
            if (@$submissionOptions['https_flag'] == 'y') {
                $_http = "https://";
            }

            $cookieName = str_replace(".", "_", $domain);
            $v = "\n\n<script type='text/javascript'>\n ";

            $v .= " var to = ''; \n";
            $v .= " to = setTimeout(function() { window.location.replace('" . $_http . $domain . "')  },1000); \n";
            $v .= " </script>";

        } else if ($adata['theoption'] == 'information' && $submissionOptions['information_active'] == 'y') {
            $s = "select leadpop_template_id from leadpops where id = " . $leadpop_id;
            $leadpop_template_id = $this->db->fetchOne($s);

            $s = "select subdomain_name,top_level_domain from clients_subdomains ";
            $s .= "where client_id = " . $client_id . " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            $tempdomain = $this->db->fetchRow($s);
            if ($tempdomain) {
                $domain = $tempdomain['subdomain_name'] . "." . $tempdomain['top_level_domain'];
            } else {
                $s = "select domain_name from clients_domains ";
                $s .= "where client_id = " . $client_id . " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $tempdomain = $this->db->fetchOne($s);
                $domain = $this->db->fetchOne($s);
            }

        } else if ($adata['theoption'] == 'thirdparty' && $submissionOptions['thirdparty_active'] == 'y') {
            $s = "select leadpop_template_id from leadpops where id = " . $leadpop_id;
            $leadpop_template_id = $this->db->fetchOne($s);

            $s = "select subdomain_name,top_level_domain from clients_subdomains ";
            $s .= "where client_id = " . $client_id . " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            $tempdomain = $this->db->fetchRow($s);
            if ($tempdomain) {
                $domain = $tempdomain['subdomain_name'] . "." . $tempdomain['top_level_domain'];
            } else {
                $s = "select domain_name from clients_domains ";
                $s .= "where client_id = " . $client_id . " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $tempdomain = $this->db->fetchOne($s);
                $domain = $this->db->fetchOne($s);
            }

            if (!isset($thirdpartyurl) && $thirdpartyurl == "") {
                $thirdpartyurl = str_replace(array('http://', 'https://'), '', $adata['footereditor']);
                //$thirdpartyurl = str_replace('http://', '', $adata['footereditor']);
                if (isset($adata['https_flag']) && $adata['https_flag'] == 'on') {
                    $thirdpartyurl = 'https://' . $thirdpartyurl;
                } else {
                    $thirdpartyurl = 'http://' . $thirdpartyurl;
                }
            }

            $v = "\n\n<script type='text/javascript'>\n ";
            $v .= " var to = ''; \n";
            $v .= " to = setTimeout(function() { window.location.replace('" . $thirdpartyurl . "')  },1000); \n";
            $v .= " </script>";
            $w = "<style>";
            $w .= "	@font-face {";
            $w .= "	  font-family: 'Open Sans';";
            $w .= "	  font-style: Bold;";
            $w .= "	  font-weight: 600;";
            $w .= "	  src: local('Open Sans'), local('Open Sans-Bold'), url(http://themes.googleusercontent.com/static/fonts/opensans/v6/DXI1ORHCpsQm3Vp6mXoaTaRDOzjiPcYnFooOUGCOsRk.woff) format('woff')";
            $w .= "	}	";
            $w .= "</style>";
            $w .= "<div align='center' style='margin-top: 50px'>";
            $w .= "<p align='center' style='font-family: Open Sans; font-size: 18px;'>";
            $w .= "Thanks for your request.<br /> Please wait a few seconds as we load your next destination...";
            $w .= "</p>";
            $w .= "<p align='center' style='text-align: center'>";
            $w .= "<img src='/images/blueass.gif' border='0'></img>";
            $w .= "</p>";
            $w .= "</div>";

        }


    }
    */

    public function saveBottomLinks($client_id, $adata, $funnel_data = array())
    {
        //var_dump($adata); exit;
        if (is_array($funnel_data) && !empty($funnel_data)) {
            $vertical_id = $funnel_data["funnel"]["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["funnel"]["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["funnel"]["leadpop_id"];
            $version_seq = $funnel_data["funnel"]["leadpop_version_seq"];
        } else {
            $registry = DataRegistry::getInstance();
            $vertical_id = $registry->leadpops->customVertical_id;
            $subvertical_id = $registry->leadpops->customSubvertical_id;
            $leadpop_id = $registry->leadpops->customLeadpopid;
            $version_seq = $registry->leadpops->customLeadpopVersionseq;

        }
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);

//  array(11) { ["client_id"]=> string(3) "667"
//["theselection"]=> string(1) "m" ["theselectiontype"]=> string(26) "footeroptionsprivacypolicy"
//["firstkey"]=> string(37) "Real Estate~VIP Home Finder~134~1~667"
//["clickedkey"]=> string(37) "Real Estate~VIP Home Finder~134~1~667"  ["treecookiediv"]=> string(18) "browserdivpopadmin"
//  ["footereditor"]=> string(97) "bbbbbbb"
//  ["linktype"]=> string(1) "m" ["theurltext"]=> string(4) "xxxx" ["theurl"]=> string(0) "" }

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
    }

    public function getSeoOptions($client_id, $vertical_id, $subvertical_id, $leadpop_id, $version_seq)
    {
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select * from seo_options ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        //die($s);
        $seoOptions = $this->db->fetchRow($s);
        /*var_dump($seoOptions);
            exit;*/
        return $seoOptions;

    }

    public function getContactOptions($client_id, $vertical_id, $subvertical_id, $leadpop_id, $version_seq)
    {
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select * from contact_options ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        // debug($s);

        $contactOptions = $this->db->fetchRow($s);
        return $contactOptions;

    }

    public function getAutoResponderOptions($client_id, $vertical_id, $subvertical_id, $leadpop_id, $version_seq)
    {
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select * from autoresponder_options ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $autoresponderOptions = $this->db->fetchRow($s);
        return $autoresponderOptions;
    }

    public function getGoogleGoalUrl($client_id, $vertical_id, $subvertical_id, $leadpop_id, $version_seq)
    {
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select url from google_goals ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $s .= " limit 1 ";
        $url = $this->db->fetchAll($s);
        if ($url) {
            $ret = $url[0]['url'];
        } else {
            $ret = 'nourl';
        }
        return $ret;

    }

    public function getSubmissionOptions($client_id, $vertical_id, $subvertical_id, $leadpop_id, $version_seq)
    {
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select * from submission_options ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        /*var_dump($s);
            exit;*/
        $submissionOptions = $this->db->fetchRow($s);
        return $submissionOptions;

    }

    public function getBottomLinks($client_id, $vertical_id, $subvertical_id, $leadpop_id, $version_seq)
    {

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
        return $bottomLinks;
    }

    public function getAdvancedFooteroptions($client_id, $vertical_id, $subvertical_id, $leadpop_id, $version_seq)
    {

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lpres = $this->db->fetchRow($s);
        $leadpop_template_id = $lpres['leadpop_template_id'];
        $leadpop_version_id = $lpres['leadpop_version_id'];
        $leadpop_type_id = $lpres['leadpop_type_id'];

        $s = "select first_name from clients ";
        $s .= " where client_id = " . $client_id;
        $first_name = $this->db->fetchOne($s);

        $s = "select ini_logo_color from leadpop_logos ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $s .= " and use_me = 'y'";
        $logocolor = $this->db->fetchOne($s);
        return array('first_name' => $first_name, 'logocolor' => $logocolor);
    }

    /**
     * @since 2.1.0 - CR-Funnel-Builder: Moved leadpops_templates_placeholders_values -> placeholder_seventy   ==>   clients_leadpops -> second_line_more
     *
     * @param $adata array
     * @param $client_id int
     * @param $leadpop_id int
     * @param $leadpop_version_seq int
     */
    public function updateHomePageDescription($adata, $client_id, $leadpop_id, $leadpop_version_seq)
    {
        ## TODO-COMPOSITE-INDEXING
        $span = '<span style="font-family: ' . $adata['thefont'] . '; font-size:' . $adata['thefontsize'] . '; color: ' . $adata['savestyle'] . ';line-height:' . $adata['lineheight'] . ';">' . $adata['mainheadingval'] . '</span>';
        $s = "UPDATE clients_leadpops SET second_line_more = '" . addslashes($span) . "' ";
        $s .=", last_edit = '" . date("Y-m-d H:i:s") . "'";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_id = " . $leadpop_id;
        $s .= " AND leadpop_version_seq = " . $leadpop_version_seq;
        $this->db->query($s);

    }

    /**
     * @since 2.1.0 - CR-Funnel-Builder: Moved Moved leadpops_templates_placeholders_values -> placeholder_sixtynine   ==>   clients_leadpops -> lead_line
     *
     * @param $adata array
     * @param $client_id int
     * @param $leadpop_id int
     * @param $leadpop_version_seq int
     */
    public function updateHomePageMessageMainMessage($adata, $client_id, $leadpop_id, $leadpop_version_seq)
    {
        $span = '<span style="font-family: ' . $adata['thefont'] . '; font-size:' . $adata['thefontsize'] . '; color: ' . $adata['savestyle'] . '; line-height:' . $adata['lineheight'] . ';">' . $adata['mainheadingval'] . '</span>';

        ## TODO-COMPOSITE-INDEXING
        $s = "UPDATE clients_leadpops SET lead_line = '" . addslashes($span) . "' ";
        $s .=", last_edit = '" . date("Y-m-d H:i:s") . "'";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_id = " . $leadpop_id;
        $s .= " AND leadpop_version_seq = " . $leadpop_version_seq;
        $this->db->query($s);
    }


    /**
     * @since 2.1.0 - CR-Funnel-Builder: Moved leadpops_templates_placeholders_values -> placeholder_seventy   ==>   clients_leadpops -> second_line_more
     *
     * @param $client_id
     * @param $leadpop_id
     * @param $leadpop_version_seq
     * @return array
     */
    public function resetHomePageDescriptionGlobal($client_id)
    {

        $lplist = explode(",", $_POST['selected_funnels']);

        //start add current Funnel key
        $currentHash = $_POST['current_hash'];
        $currentKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        if (!empty($currentKey)) {
            array_push($lplist, $currentKey);
        }
        $lplist = array_unique($lplist);
        //end add current Funnel key

        $client = Clients::where('client_id', $client_id)->first();

        $stockDefaultsTable = $this->getStockFunnelDefaultTable($client);
        $websiteDefaultsTable = $this->getWebsiteFunnelDefaultTable($client);

        $allStockFunnelDefaults = $this->db->fetchAll("select * from $stockDefaultsTable");
        $allWebsiteFunnelDefaults = $this->db->fetchAll("select * from $websiteDefaultsTable");

        $clientAllLeadpops = $this->db->fetchAll('select leadpop_id,leadpop_version_id,leadpop_version_seq,funnel_market from clients_leadpops where client_id = ' . $client_id);
        $allLeadpops = $this->db->fetchAll('select * from leadpops');

        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];


            $leadpop = Utils::findFirstInRowsByValues($allLeadpops, [
                'id' => $leadpop_id
            ]);

            $subdomain_leadpop_id = $leadpop_id;
            if($leadpop['leadpop_type_id'] == config('leadpops.leadpopDomainTypeId')) {
                $new_leadpop = Utils::findFirstInRowsByValues($allLeadpops, [
                    'leadpop_type_id' => config('leadpops.leadpopSubDomainTypeId'),
                    'leadpop_vertical_id' => $leadpop['leadpop_vertical_id'],
                    'leadpop_vertical_sub_id' => $leadpop['leadpop_vertical_sub_id'],
                    'leadpop_template_id' => $leadpop["leadpop_template_id"],
                    'leadpop_version_id' => $leadpop["leadpop_version_id"]
                ]);
                $subdomain_leadpop_id = $new_leadpop['id'];
            }

            $newdescr = Utils::findFirstInRowsByValues($allStockFunnelDefaults, [
                'leadpop_id' => $subdomain_leadpop_id,
                'leadpop_vertical_id' => $leadpop_vertical_id,
                'leadpop_vertical_sub_id' => $leadpop_vertical_sub_id,
                'leadpop_template_id' => $leadpop["leadpop_template_id"],
            ]);

            if(!$newdescr){
                continue;
            }

            $clientLeadpop = Utils::findFirstInRowsByValues($clientAllLeadpops, [
                'leadpop_id' => $leadpop_id,
                'leadpop_version_id' => $leadpop["leadpop_version_id"],
                'leadpop_version_seq' => $leadpop_version_seq
            ]);

            if(!$clientLeadpop){
                continue;
            }

            if($clientLeadpop['funnel_market'] == 'w'){
                $websiteDefaultData = Utils::findFirstInRowsByValues($allWebsiteFunnelDefaults, [
                    'leadpop_id' => $subdomain_leadpop_id,
                    'leadpop_vertical_id' => $leadpop_vertical_id,
                    'leadpop_vertical_sub_id' => $leadpop_vertical_sub_id,
                    'leadpop_template_id' => $leadpop["leadpop_template_id"],
                ]);

                $newdescr = $this->mapWebsiteFunnelDefaultsToStock($newdescr, $websiteDefaultData);
            }

            $span = '<span style="font-family: ' . $newdescr["description_font"] . '; font-size:' . $newdescr["description_font_size"] . '; color:' . $newdescr["description_color"] . '">' . $newdescr["description"] . '</span>';

            $s = "UPDATE clients_leadpops SET second_line_more = '" . addslashes($span) ."'"
                . ", last_edit = '" . date("Y-m-d H:i:s") . "'"
                . " WHERE client_id = " . $client_id
//              . " AND leadpop_id = " . $leadpop_id
                . " AND leadpop_version_id = " . $leadpop["leadpop_version_id"]
                . " AND leadpop_version_seq = " . $leadpop_version_seq;
            // dd($s);
            $this->db->query($s);
        }
        return [];
      //  return array("style" => array('font_family' => str_replace(';', '', $newdescr["description_font"]), 'font_size' => $newdescr["description_font_size"], 'color' => $newdescr['description_color'], 'main_message' => $newdescr["description"]));
    }

    public function getStockFunnelDefaultTable(Clients $client){
        if(!$client){
            return 'trial_launch_defaults';
        }

        if($client->is_mm){
            return 'trial_launch_defaults_mm';
        } else if($client->is_fairway || $client->is_fairway_branch){
            return 'trial_launch_defaults_fairway';
        } else {
            return 'trial_launch_defaults';
        }
    }

    public function getWebsiteFunnelDefaultTable(Clients $client){
        if(!$client){
            return 'add_mortgage_website_funnels';
        }

        if($client->is_mm){
            return 'add_mortgage_website_funnels_mvp_movement';
        } else if($client->is_fairway || $client->is_fairway_branch){
            return 'add_mortgage_website_funnels_mvp_fairway';
        } else {
            return 'add_mortgage_website_funnels';
        }
    }

    protected function mapWebsiteFunnelDefaultsToStock(array $stockDefaults, array $websiteDefaults){
        $valuesToMap = [
            'main_message',
            'main_message_font',
            'main_message_font_size',
            'mainmessage_color',
            'description_font',
            'description_font_size',
            'description_color',
            'description'
        ];
        $extractedWebsiteDefaults = array_intersect_key($websiteDefaults, array_flip($valuesToMap));

        return array_merge($stockDefaults, $extractedWebsiteDefaults);
    }


    /**
     * @since 2.1.0 - CR-Funnel-Builder: Moved Moved leadpops_templates_placeholders_values -> placeholder_sixtynine   ==>   clients_leadpops -> lead_line
     *
     * @param $adata
     * @param $client_id
     * @param $leadpop_id
     * @param $leadpop_version_seq
     * @return array
     */
    public function resetHomePageMessageMainMessageGlobal($client_id)
    {

        $lplist = explode(",", $_POST['selected_funnels']);

        //start add current Funnel key
        $currentHash = $_POST['current_hash'];
        $currentKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        if (!empty($currentKey)) {
            array_push($lplist, $currentKey);
        }
        //end add current Funnel key

        $lplist = array_unique($lplist);

        $client = Clients::where('client_id', $client_id)->first();

        $stockDefaultsTable = $this->getStockFunnelDefaultTable($client);
        $websiteDefaultsTable = $this->getWebsiteFunnelDefaultTable($client);

        $allStockFunnelDefaults = $this->db->fetchAll("select * from $stockDefaultsTable");
        $allWebsiteFunnelDefaults = $this->db->fetchAll("select * from $websiteDefaultsTable");

        $clientAllLeadpops = $this->db->fetchAll('select leadpop_id,leadpop_version_id,leadpop_version_seq,funnel_market from clients_leadpops where client_id = ' . $client_id);
        $allLeadpops = $this->db->fetchAll('select * from leadpops');


        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];

            $leadpop = Utils::findFirstInRowsByValues($allLeadpops, [
                'id' => $leadpop_id
            ]);

            $subdomain_leadpop_id = $leadpop_id;
            if($leadpop['leadpop_type_id'] == config('leadpops.leadpopDomainTypeId')) {
                $new_leadpop = Utils::findFirstInRowsByValues($allLeadpops, [
                    'leadpop_type_id' => config('leadpops.leadpopSubDomainTypeId'),
                    'leadpop_vertical_id' => $leadpop['leadpop_vertical_id'],
                    'leadpop_vertical_sub_id' => $leadpop['leadpop_vertical_sub_id'],
                    'leadpop_template_id' => $leadpop["leadpop_template_id"],
                    'leadpop_version_id' => $leadpop["leadpop_version_id"]
                ]);
                $subdomain_leadpop_id = $new_leadpop['id'];
            }

            $newmain = Utils::findFirstInRowsByValues($allStockFunnelDefaults, [
                'leadpop_id' => $subdomain_leadpop_id,
                'leadpop_vertical_id' => $leadpop_vertical_id,
                'leadpop_vertical_sub_id' => $leadpop_vertical_sub_id,
                'leadpop_template_id' => $leadpop["leadpop_template_id"],
            ]);

            if(!$newmain){
                continue;
            }

            $clientLeadpop = Utils::findFirstInRowsByValues($clientAllLeadpops, [
                'leadpop_id' => $leadpop_id,
                'leadpop_version_id' => $leadpop["leadpop_version_id"],
                'leadpop_version_seq' => $leadpop_version_seq
            ]);

            if(!$clientLeadpop){
                continue;
            }

            if($clientLeadpop['funnel_market'] == 'w'){
                $websiteDefaultData = Utils::findFirstInRowsByValues($allWebsiteFunnelDefaults, [
                    'leadpop_id' => $subdomain_leadpop_id,
                    'leadpop_vertical_id' => $leadpop_vertical_id,
                    'leadpop_vertical_sub_id' => $leadpop_vertical_sub_id,
                    'leadpop_template_id' => $leadpop["leadpop_template_id"],
                ]);

                $newmain = $this->mapWebsiteFunnelDefaultsToStock($newmain, $websiteDefaultData);
            }

            $span = '<span style="font-family: ' . $newmain["main_message_font"] . '; font-size:' . $newmain["main_message_font_size"] . '; color:' . $newmain['mainmessage_color'] . '">' . $newmain["main_message"] . '</span>';

            //to get last saved color
            $sql = "SELECT * FROM leadpop_logos WHERE client_id = " . $client_id
                . " AND leadpop_vertical_id 	= " . $leadpop["leadpop_vertical_id"]
                . " AND leadpop_vertical_sub_id = " . $leadpop["leadpop_vertical_sub_id"]
                . " AND  leadpop_id = " . $leadpop_id
                . " AND leadpop_template_id =	" . $leadpop["leadpop_template_id"]
                . " AND leadpop_version_id = " . $leadpop["leadpop_version_id"]
                . " AND leadpop_version_seq = " . $leadpop_version_seq;

            $rec = $this->db->fetchRow($sql);
            if (!empty($rec) and $rec['use_default'] == 'n') {


                $old_color = $rec['logo_color'];

                if($old_color && strtolower($old_color) !== "#ffffff" && $old_color !=="" ) {
                    $newmain['mainmessage_color'] = $old_color;

                    $span = preg_replace('/color:(.*?)\"/', "color:$old_color\"", $span);
                }
            }

            $s = "UPDATE clients_leadpops SET lead_line = '" . addslashes($span) ."'"
                . ", last_edit = '" . date("Y-m-d H:i:s") . "'"
                . " WHERE client_id = " . $client_id
//              . " AND leadpop_id = " . $leadpop_id
                . " AND leadpop_version_id = " . $leadpop["leadpop_version_id"]
                . " AND leadpop_version_seq = " . $leadpop_version_seq;
            //  dd($s, $span);
            $this->db->query($s);

        }

        return [];

       // return array("style" => array('font_family' => str_replace(';', '', $newmain["main_message_font"]), 'font_size' => $newmain["main_message_font_size"], 'color' => $newmain['mainmessage_color'], 'main_message' => $newmain["main_message"]));

    }

    /**
     * @since 2.1.0 - CR-Funnel-Builder: Moved Moved leadpops_templates_placeholders_values -> placeholder_sixtynine   ==>   clients_leadpops -> lead_line
     *
     * @param $client_id int
     * @param $leadpop_id int
     * @param $leadpop_version_seq int
     */
    // <span style="font-family: arial; font-size:16px; color: #ff6666 ">Douche Bags Galore</span>
    public function getHomePageMessageMainMessage($client_id, $leadpop_id, $leadpop_version_seq)
    {
        ## TODO-COMPOSITE-INDEXING
        $s = "SELECT lead_line FROM clients_leadpops ";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_id = " . $leadpop_id;
        $s .= " AND leadpop_version_seq = " . $leadpop_version_seq;
        $homePageMessageMainMessage = $this->db->fetchOne($s);
        return $homePageMessageMainMessage;
    }

    /**
     * @since 2.1.0 - CR-Funnel-Builder: Moved leadpops_templates_placeholders_values -> placeholder_seventy   ==>   clients_leadpops -> second_line_more
     *
     * @param $client_id int
     * @param $leadpop_id int
     * @param $leadpop_version_seq int
     */
    public function getHomePageDescriptionMessage($client_id, $leadpop_id, $leadpop_version_seq)
    {
## TODO-COMPOSITE-INDEXING
        $s = "SELECT second_line_more FROM clients_leadpops ";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_id = " . $leadpop_id;
        $s .= " AND leadpop_version_seq = " . $leadpop_version_seq;
        $homePageMessageMainMessage = $this->db->fetchOne($s);
        return $homePageMessageMainMessage;

    }

    private function getStateName($state_id)
    {
        $s = "SELECT state  FROM states where  id = " . $state_id;
        $state = $this->db->fetchOne($s);
        return $state;
    }

    private function getCardAmount($client_id, $invnumber)
    {
        $s = "select  sum(line_item_amount) as setup from invoice_line ";
        $s .= " where invoice_number = '" . $invnumber . "'  ";
        $s .= " and client_id = " . $client_id;
        $s .= " and line_item_type = 'LP' ";
        $setup = $this->db->fetchOne($s);
        return $setup;
    }

    public function getProductDescr($versionid)
    {
        $aversion = explode("-", $versionid);
        $version_id = $aversion[0];
        $s = "select version_name from product_versions where id  = " . $version_id;
        $r1 = $this->db->fetchRow($s);
        return $r1['version_name'];
    }

    public function getDescr($pvertical, $psubvertical, $pversion, $pleadpoptype)
    {
        $s = "select * from leadpops_verticals where id = " . $pvertical;

        $r1 = $this->db->fetchRow($s);
        $vertical = $r1['lead_pop_vertical'];
        unset($r1);
        $s = "select * from leadpops_verticals_sub where leadpop_vertical_id  = " . $pvertical;
        $s .= " and id = " . $psubvertical;

        $r1 = $this->db->fetchRow($s);
        $subvertical = $r1['lead_pop_vertical_sub'];
        unset($r1);

        $s = "select * from leadpops_descriptions where id  = " . $pversion;
        $r1 = $this->db->fetchRow($s);
        $version = $r1['leadpop_title'];
        $leadpopdescr = $version;
        unset($r1);
        $s = "select * from leadpops_types where id = " . $pleadpoptype;

        $r1 = $this->db->fetchRow($s);
        $leadpoptype = $r1['lead_pop_type'];
        return $version . "-" . $leadpoptype;
    }

    private function getOrderTotals($client_id, $invoicenumber)
    {
        $s = "select  sum(line_item_amount) as setup from invoice_line ";
        $s .= " where invoice_number = '" . $invoicenumber . "'  ";
        $s .= " and client_id = " . $client_id;
        $s .= " and (line_item_type = 'LP'  or line_item_type =  'PRODUCT'  or line_item_type =  'REGULARPRODUCT'  ) ";
        $setup = $this->db->fetchOne($s);

        $s = "select  sum(line_item_amount) as rate  from invoice_line ";
        $s .= " where invoice_number = '" . $invoicenumber . "'  ";
        $s .= " and client_id = " . $client_id;
        $s .= " and  (line_item_type != 'LP'  and line_item_type !=  'PRODUCT'  and  line_item_type !=  'REGULARPRODUCT'  )  ";
        $rate = $this->db->fetchOne($s);

        $s = "Order Total: " . ($setup + $rate) . " - Total Set-up: " . $setup . " - Total Monthly: " . $rate;
        return $s;
    }

    protected function _getDB()
    {
        $dbAdapters = DataRegistry::get('dbAdapters');
        return $dbAdapters['client'];
    }

    protected function _getSessionDb()
    {
        $dbAdapters = DataRegistry::get('dbAdapters');
        return $dbAdapters['leadpops_system'];
    }

    private function getSelectedBgColor($background_color)
    {
        $sindex = strpos($background_color, 'background-image: linear-gradient') + 18;
        $eindex = strpos($background_color, ' /* W3C */');
        $length = $eindex - $sindex;
        return substr($background_color, $sindex, $length);
    }

    function update_background_swatches($adata, $sql)
    {
        $type_arr = array();
        $_lp = $this->db->fetchAll($sql);

        foreach ($_lp as $_logo) {
            $_client_id = $_logo['client_id'];
            $_section = substr($_client_id, 0, 1);

            if (0 === strpos($_logo['logo_src'], 'http')) {
                // External Link
                $_logopath = $_SERVER['DOCUMENT_ROOT'] . "/temp/" . $adata['image'][$_logo['id']];
                $logosrc = $_logo['logo_src'];
            } else {
                $_logopath = $_section . '/' . $_client_id . '/logos/' . $_logo['logo_src'];
                $logosrc = $this->getHttpAdminServer() . '/images/clients/' . $_section . '/' . $_client_id . '/logos/' . $_logo['logo_src'];
            }
            $logo_color = $this->getLogoProminentColor($_logopath);
            if (is_array($logo_color)) {
                $logo_color = $logo_color[0];
            }
            //MN
            /*$client = new Client();
	        $gis   = getimagesize($_logopath);
	        $ow = $gis[0];
	        $oh = $gis[1];
	        $type = $gis[2];



	        switch($type)
	        {
	                case "1":
		                	$im = imagecreatefromgif($_logopath);
		                	$image = $client->loadGif($_logopath);
		          			$logo_color = $image->extract();
	                	break;
	                case "2":
		                	$im = imagecreatefromjpeg($_logopath);
		                	$image = $client->loadJpeg($_logopath);
		                	$logo_color = $image->extract();
	                	break;
	                case "3":
		                	$im = imagecreatefrompng($_logopath);
		                	$image = $client->loadPng($_logopath);
		          			$logo_color = $image->extract();
	                	break;
	                default:  $im = imagecreatefromjpeg($_logopath);
	        }


	        if(is_array($logo_color)){
	        	$logo_color = $logo_color[0];
	        }*/

            $imagetype = image_type_to_mime_type($type);
            $type_arr[$_logo["id"]] = $imagetype;

            if ($imagetype == 'image/jpeg' || $imagetype == 'image/png' || $imagetype == 'image/gif') {

                if (0 === strpos($_logo['logo_src'], 'http')) {
                    unlink($_logopath);
                }

                // Update logo_color
                $this->db->query("update `leadpop_logos` set `logo_color`= '$logo_color' WHERE id = " . $_logo['id']);

                // If not currently selected logo, then skip
                if ($_logo['use_me'] != 'y')
                    continue;


                $client_id = $_logo['client_id'];
                $leadpop_id = $_logo['leadpop_id'];
                $leadpop_type_id = $_logo['leadpop_type_id'];
                $vertical_id = $_logo['leadpop_vertical_id'];
                $subvertical_id = $_logo['leadpop_vertical_sub_id'];
                $leadpop_template_id = $_logo['leadpop_template_id'];
                $leadpop_version_id = $_logo['leadpop_version_id'];
                $version_seq = $_logo['leadpop_version_seq'];

                $s = "select id from leadpops_templates_placeholders ";
                $s .= " where leadpop_template_id = " . $leadpop_template_id;
                $s .= " and client_id = " . $client_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $leadpops_templates_placeholders = $this->db->fetchAll($s);

                $s = "select id from leadpops_templates_placeholders ";
                $s .= " where leadpop_template_id = " . $leadpop_template_id;
                $s .= " and client_id = " . $client_id;
                $leadpops_templates_placeholder = $this->db->fetchOne($s);

                if (!$leadpops_templates_placeholder)
                    continue;


                $s = "select placeholder_sixtynine from leadpops_templates_placeholders_values ";
                $s .= " where client_leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholder;
                $main_message = $this->db->fetchOne($s);

                $param = $main_message;

                if (strpos($main_message, 'color: background') != false) {
                    $font_color = substr($param, strpos($param, " color: "), 7);
                    $new_code = $font_color . $logo_color . ';';// new code
                    $param = str_replace($font_color, $new_code, $param);
                } else if (strpos($param, ' color: #') != false) {
                    $color_code = substr($param, strpos($param, " color: ") + 8, 7);
                    $new_code = $logo_color;// new code
                    $param = str_replace($color_code, $new_code, $param);
                } else if (strpos($param, ' color:#') != false) {
                    $color_code = substr($param, strpos($param, " color:") + 7, 7);
                    $new_code = $logo_color;// new code
                    $param = str_replace($color_code, $new_code, $param);
                } else if (strpos($param, ' color:"') != false) {
                    $color_code = substr($param, strpos($param, ' color:"') + 0, 0);
                    if ($color_code == '') {
                        $color_code = "color:";
                        $newcolor = "color:" . $logo_color;
                    }
                    $param = str_replace($color_code, $newcolor, $param);
                }


                for ($i = 0; $i < count($leadpops_templates_placeholders); $i++) {
                    $s = "update leadpops_templates_placeholders_values  set placeholder_sixtynine = '" . addslashes($param) . "' ";
                    $s .= " where client_leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
                    $this->db->query($s);
                }

                $filename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq);

                // For Production

                $image_location = rackspace_stock_assets() . "images/dot-img.png";
                $favicon_location = rackspace_stock_assets() . "images/favicon-circle.png";
                $mvp_dot_location = rackspace_stock_assets() . "images/ring.png";
                $mvp_check_location = rackspace_stock_assets() . "images/mvp-check.png";

                // $image_location = $this->getHttpServer()."/images/dot-img.png";
                // $favicon_location = $this->getHttpServer()."/images/favicon-circle.png";

                $favicon_dst_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_favicon-circle.png';
                $colored_dot_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_dot_img.png';
                $mvp_dot_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_ring.png';
                $mvp_check_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_mvp-check.png';

                if (isset($logo_color) && $logo_color != "") {
                    $new_clr = $this->hex2rgb($logo_color);
                }


                $im = imagecreatefrompng($image_location);
                $myRed = $new_clr[0];
                $myGreen = $new_clr[1];
                $myBlue = $new_clr[2];

                $this->colorizeBasedOnAplhaChannnel($image_location, $myRed, $myGreen, $myBlue, $colored_dot_src);
                $this->colorizeBasedOnAplhaChannnel($favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src);
                $this->colorizeBasedOnAplhaChannnel($mvp_dot_location, $myRed, $myGreen, $myBlue, $mvp_dot_src);
                $this->colorizeBasedOnAplhaChannnel($mvp_check_location, $myRed, $myGreen, $myBlue, $mvp_check_src);

                $colored_dot = getCdnLink() . '/logos/' . $filename . '_dot_img.png';
                $favicon_dst = getCdnLink() . '/logos/' . $filename . '_favicon-circle.png';
                $mvp_dot = getCdnLink() . '/logos/' . $filename . '_ring.png';
                $mvp_check = getCdnLink() . '/logos/' . $filename . '_mvp-check.png';

                for ($i = 0; $i < count($leadpops_templates_placeholders); $i++) {
                    $s = " update leadpops_templates_placeholders_values  set placeholder_sixtytwo = '" . $logosrc . "', placeholder_eightyone = '" . $logo_color . "' , placeholder_eightytwo = '" . $colored_dot . "',placeholder_seventynine = '" . $mvp_dot . "' ,placeholder_eighty = '" . $mvp_check . "', placeholder_eightythree = '" . $favicon_dst . "'  where client_leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
                    $this->db->query($s);
                }

                // DELETE SWATCHES
                if (env('APP_ENV') === config('app.env_local')) {
                    $leadpop_background_swatches = 'leadpop_background_swatches';
                } else {
                    $leadpop_background_swatches = getPartition($client_id, "leadpop_background_swatches");
                }
                $s = "delete from " . $leadpop_background_swatches;
                $s .= " where client_id = " . $client_id;
//                $s .= " and leadpop_vertical_id = " . $vertical_id;
//                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//                $s .= " and leadpop_type_id = " . $leadpop_type_id;
//                $s .= " and leadpop_template_id = " . $leadpop_template_id;
//                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query($s);

                $swatches = $adata['swatche'][$_logo['id']];

                $result = explode("#", $swatches);
                $new_color = $this->hex2rgb($logo_color);
                $index = 0;
                array_unshift($result, implode('-', $new_color));

                // SET BACKGROUND COLOR
                $background_from_logo = '/*###>*/background-color: rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1);/*@@@*/
				background-image: linear-gradient(to right bottom,rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1) 0%,rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1) 100%); /* W3C */';

                $s = "delete from leadpop_background_color ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_vertical_id = " . $vertical_id;
                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                $s .= " and leadpop_type_id = " . $leadpop_type_id;
                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query($s);

                // TO-DO = default_changed needs to confirm from Robert.
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
                $s .= "'" . addslashes($background_from_logo) . "','y','y')";
                $this->db->query($s);

                foreach ($result as $key => $value) {

                    list($red, $green, $blue) = explode("-", $value);

                    if ($key < 1) {
                        $str0 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",1.0) 100%)";
                    } else {
                        $str0 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                    }

                    $str1 = "linear-gradient(to top, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                    $str2 = "linear-gradient(to bottom right, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                    $str3 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",1.0) 100%)";

                    $swatches = array($str0, $str1, $str2, $str3);
                    for ($i = 0; $i < 4; $i++) {
                        $index++;
                        $is_primary = 'n';
                        if ($index == 1) {
                            $is_primary = 'y';
                        }
                        $s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
                        $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                        $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
                        $s .= "swatch,is_primary,active) values (null,";
                        $s .= $client_id . "," . $vertical_id . ",";
                        $s .= $subvertical_id . ",";
                        $s .= $leadpop_type_id . "," . $leadpop_template_id . ",";
                        $s .= $leadpop_id . ",";
                        $s .= $leadpop_version_id . ",";
                        $s .= $version_seq . ",";
                        $s .= "'" . addslashes($swatches[$i]) . "',";
                        $s .= "'" . $is_primary . "','y')";
                        $this->db->query($s);

                    }

                }
            }
        }
        // echo "<pre>".print_r($type_arr,1)."</pre>";
        // exit;

    }

    function update_background_swatches_default($sql)
    {

        $_lp = $this->db->fetchAll($sql);

        foreach ($_lp as $_logo) {

            $client_id = $_logo['client_id'];
            $leadpop_id = $_logo['leadpop_id'];
            $leadpop_type_id = $_logo['leadpop_type_id'];
            $vertical_id = $_logo['leadpop_vertical_id'];
            $subvertical_id = $_logo['leadpop_vertical_sub_id'];
            $leadpop_template_id = $_logo['leadpop_template_id'];
            $leadpop_version_id = $_logo['leadpop_version_id'];
            $version_seq = $_logo['leadpop_version_seq'];

            $_sql = "select st.id as id, v.`lead_pop_vertical`, vs.`lead_pop_vertical_sub`, st.`logo_src`, st.`default_logo_color`, st.default_logo_swatches from `stock_leadpop_logos` as st
			LEFT JOIN `leadpops_verticals` as v ON st.`leadpop_vertical_id` = v.id
			LEFT JOIN `leadpops_verticals_sub` as vs ON st.`leadpop_vertical_sub_id` = vs.id
			WHERE v.id = $vertical_id AND vs.id = $subvertical_id
			";

            $default_stock = $this->db->fetchRow($_sql);

            $logo_color = $default_stock['default_logo_color'];

            // Update logo_color
            $this->db->query("update `leadpop_logos` set `logo_color`= '$logo_color' WHERE id = " . $_logo['id']);


            $s = "select id from leadpops_templates_placeholders ";
            $s .= " where leadpop_template_id = " . $leadpop_template_id;
            $s .= " and client_id = " . $client_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            $leadpops_templates_placeholders = $this->db->fetchAll($s);

            $s = "select id from leadpops_templates_placeholders ";
            $s .= " where leadpop_template_id = " . $leadpop_template_id;
            $s .= " and client_id = " . $client_id;
            $leadpops_templates_placeholder = $this->db->fetchOne($s);

            if (!$leadpops_templates_placeholder)
                continue;

            $s = "select placeholder_sixtynine from leadpops_templates_placeholders_values ";
            $s .= " where client_leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholder;
            $main_message = $this->db->fetchOne($s);

            $param = $main_message;

            if (strpos($main_message, 'color: background') != false) {
                $font_color = substr($param, strpos($param, " color: "), 7);
                $new_code = $font_color . $logo_color . ';';// new code
                $param = str_replace($font_color, $new_code, $param);
            } else if (strpos($param, ' color: #') != false) {
                $color_code = substr($param, strpos($param, " color: ") + 8, 7);
                $new_code = $logo_color;// new code
                $param = str_replace($color_code, $new_code, $param);
            } else if (strpos($param, ' color:#') != false) {
                $color_code = substr($param, strpos($param, " color:") + 7, 7);
                $new_code = $logo_color;// new code
                $param = str_replace($color_code, $new_code, $param);
            } else if (strpos($param, ' color:"') != false) {
                $color_code = substr($param, strpos($param, ' color:"') + 0, 0);
                if ($color_code == '') {
                    $color_code = "color:";
                    $newcolor = "color:" . $logo_color;
                }
                $param = str_replace($color_code, $newcolor, $param);
            }


            for ($i = 0; $i < count($leadpops_templates_placeholders); $i++) {
                $s = "update leadpops_templates_placeholders_values  set placeholder_sixtynine = '" . addslashes($param) . "' ";
                $s .= " where client_leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
                $this->db->query($s);
            }

            $filename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq);

            // For Production
            $image_location = rackspace_stock_assets() . "images/dot-img.png";
            $favicon_location = rackspace_stock_assets() . "images/favicon-circle.png";

            // $image_location = $this->getHttpServer()."/images/dot-img.png";
            // $favicon_location = $this->getHttpServer()."/images/favicon-circle.png";

            $favicon_dst_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_favicon-circle.png';
            $colored_dot_src = substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . '_dot_img.png';

            if (isset($logo_color) && $logo_color != "") {
                $new_clr = $this->hex2rgb($logo_color);
            }

            $im = imagecreatefrompng($image_location);
            $myRed = $new_clr[0];
            $myGreen = $new_clr[1];
            $myBlue = $new_clr[2];

            $this->colorizeBasedOnAplhaChannnel($image_location, $myRed, $myGreen, $myBlue, $colored_dot_src);
            $this->colorizeBasedOnAplhaChannnel($favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src);

            $colored_dot = getCdnLink() . '/logos/' . $filename . '_dot_img.png';
            $favicon_dst = getCdnLink() . '/logos/' . $filename . '_favicon-circle.png';
            for ($i = 0; $i < count($leadpops_templates_placeholders); $i++) {
                $s = " update leadpops_templates_placeholders_values  set placeholder_eightyone = '" . $logo_color . "' , placeholder_eightytwo = '" . $colored_dot . "', placeholder_eightythree = '" . $favicon_dst . "'  where client_leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
                $this->db->query($s);
            }

            // DELETE SWATCHES
            if (env('APP_ENV') === config('app.env_local')) {
                $leadpop_background_swatches = 'leadpop_background_swatches';
            } else {
                $leadpop_background_swatches = getPartition($client_id, "leadpop_background_swatches");
            }
            $s = "delete from " . $leadpop_background_swatches;
            $s .= " where client_id = " . $client_id;
//            $s .= " and leadpop_vertical_id = " . $vertical_id;
//            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//            $s .= " and leadpop_type_id = " . $leadpop_type_id;
//            $s .= " and leadpop_template_id = " . $leadpop_template_id;
//            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            $this->db->query($s);


            $_return = $this->determineLogoUseAndNeedCreateSwatches($client_id);
            $swatches = $default_stock['default_logo_swatches'];
            $result = explode("#", $swatches);
            $new_color = $this->hex2rgb($logo_color);
            $index = 0;
            array_unshift($result, implode('-', $new_color));

            // SET BACKGROUND COLOR
            $background_from_logo = '/*###>*/background-color: rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1);/*@@@*/
			background-image: linear-gradient(to right bottom,rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1) 0%,rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1) 100%); /* W3C */';

            $s = "delete from leadpop_background_color ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            $this->db->query($s);

            // TO-DO = default_changed needs to confirm from Robert.
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
            $s .= "'" . addslashes($background_from_logo) . "','y','y')";
            $this->db->query($s);

            foreach ($result as $key => $value) {

                list($red, $green, $blue) = explode("-", $value);

                if ($key < 1) {
                    $str0 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",1.0) 100%)";
                } else {
                    $str0 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                }

                $str1 = "linear-gradient(to top, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                $str2 = "linear-gradient(to bottom right, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                $str3 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",1.0) 100%)";

                $swatches = array($str0, $str1, $str2, $str3);
                for ($i = 0; $i < 4; $i++) {
                    $index++;
                    $is_primary = 'n';
                    if ($index == 1) {
                        $is_primary = 'y';
                    }
                    $s = "insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,";
                    $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
                    $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
                    $s .= "swatch,is_primary,active) values (null,";
                    $s .= $client_id . "," . $vertical_id . ",";
                    $s .= $subvertical_id . ",";
                    $s .= $leadpop_type_id . "," . $leadpop_template_id . ",";
                    $s .= $leadpop_id . ",";
                    $s .= $leadpop_version_id . ",";
                    $s .= $version_seq . ",";
                    $s .= "'" . addslashes($swatches[$i]) . "',";
                    $s .= "'" . $is_primary . "','y')";
                    $this->db->query($s);

                }

            }


        }

    }

    // Update default swatches strings
    function update_default_swatches_string($data)
    {
        foreach ($data['swatch'] as $id => $swatch) {
            $this->db->query("update `stock_leadpop_logos` set `default_logo_swatches`= '$swatch' WHERE id = $id");
        }
    }

    public function getGlobalOptions($client_id)
    {
        $s = "select * from global_settings where client_id = " . $client_id;
        $global_settings = $this->db->fetchRow($s);
        return $global_settings;
    }

    private function getClientdomainslist($client_id)
    {

        $s = "select id, display_label from leadpops_verticals_sub";
        $_sub_verticals = $this->db->fetchAll($s);

        $sub_verticals = array();
        foreach ($_sub_verticals as $index => $sub) {
            $sub_verticals[$sub['id']] = $sub['display_label'];
        }

        $s = "select DISTINCT cs.* from clients_funnels_domains cs
		LEFT JOIN `clients_leadpops` cl ON cs.client_id = cl.client_id AND cs.leadpop_id = cl.leadpop_id
		LEFT JOIN `leadpops` lp ON lp.id = cl.leadpop_id where cs.client_id = " . $client_id . " AND cl.`leadpop_active` != 3";
        $domainslist = $this->db->fetchAll($s);


        foreach ($domainslist as $key => $item) {
            $clientdomainslist[$sub_verticals[$item['leadpop_vertical_sub_id']]][] = $item;
        }
        // echo "<pre>".print_r($domains,1)."</pre>";
        // exit;
        $total_keys = array();
        foreach ($clientdomainslist as $sub_display_label => $lp_items) {
            foreach ($lp_items as $index => $lp) {
                $domain_name = $lp['subdomain_name'] . "." . $lp['top_level_domain'];
                // vertical_id~subvertical_id~leadpop_id~version_seq
                $fkey = $lp['leadpop_vertical_id'] . "~" . $lp['leadpop_vertical_sub_id'] . "~" . $lp['leadpop_id'] . "~" . $lp['leadpop_version_seq'];
                array_push($total_keys, $fkey);
            }
        }
        $total_keys = implode(",", $total_keys);
        return $total_keys;
    }



    public function saveNewGlobalContactInfo()
    {
        extract($_POST, EXTR_OVERWRITE, "form_");
        $adata = array(
            "newclient_id" => "1726",
            "phonenumber" => "Call Today! 859-282-0220",
        );

        $client_id = $adata['newclient_id'];
        $lpkey_leadnotification = $this->getClientdomainslist($client_id);
        $lplist = explode(",", $lpkey_leadnotification);
        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];
            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);
            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];

            $s = "update contact_options set";
            $s .= " phonenumber = '" . $adata['phonenumber'] . "'";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;

            $this->db->query($s);

            $s = "select leadpop_template_id from leadpops where id = " . $leadpop_id;
            $leadpop_template_id = $this->db->fetchOne($s);

            $s = "select id from leadpops_templates_placeholders ";
            $s .= " where leadpop_template_id = " . $leadpop_template_id;
            $s .= " and client_id = " . $client_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;

            $leadpops_templates_placeholders = $this->db->fetchAll($s);

            for ($i = 0; $i < count($leadpops_templates_placeholders); $i++) {
                $s = "update leadpops_templates_placeholders_values  set ";
                $s .= "placeholder_sixtyseven = '' where client_leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
                $this->db->query($s);
            }
            for ($i = 0; $i < count($leadpops_templates_placeholders); $i++) {
                $s = "update leadpops_templates_placeholders_values  set placeholder_sixtyseven = '" . addslashes($adata['phonenumber']) . "'  ";
                $s .= "  where client_leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
                $this->db->query($s);
            }
        }
        die("ok");
    }

    public function udpateRecipientsForTextResonder()
    {
        $s = "SELECT * FROM `lp_auto_recipients` where client_id = 1919 and is_primary = 'y' order by leadpop_id desc";
        $lp_funnels = $this->db->fetchAll($s);

        foreach ($lp_funnels as $index => $lp) {

            $id = $lp["id"];
            $client_id = $lp["client_id"];
            $leadpop_id = $lp["leadpop_id"];
            $leadpop_type_id = $lp["leadpop_type_id"];
            $leadpop_vertical_id = $lp["leadpop_vertical_id"];
            $leadpop_vertical_sub_id = $lp["leadpop_vertical_sub_id"];
            $leadpop_template_id = $lp["leadpop_template_id"];
            $leadpop_version_id = $lp["leadpop_version_id"];
            $leadpop_version_seq = $lp["leadpop_version_seq"];
            $email_address = $lp["email_address"];
            $is_primary = $lp["is_primary"];

            $s = "update lp_auto_text_recipients set";
            $s .= " lp_auto_recipients_id = " . $id;
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $s .= " and is_primary = '" . $is_primary . "'";
            $this->db->query($s);
        }
        die("ok");
    }

    public function databaseQueryForSubmisionOptions()
    {

        $adata = array(
            "newclient_id" => "2092",
        );

        $client_id = $adata['newclient_id'];
        $lpkey_funnels = $this->getClientdomainslist($client_id);
        $lplist = explode(",", $lpkey_funnels);
        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];
            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);
            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];

            // $s = "select thankyou from submission_options ";
            // $s .= " where client_id = " . $client_id;
            // $s .= " and leadpop_id = " . $leadpop_id;
            // $s .= " and leadpop_type_id = " . $leadpop_type_id;
            // $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
            // $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            // $s .= " and leadpop_template_id = " . $leadpop_template_id;
            // $s .= " and leadpop_version_id = " . $leadpop_version_id;
            // $s .= " and leadpop_version_seq = " . $leadpop_version_seq;

            // $thankyoumessage = $this->db->fetchOne($s);

            //$newthankyoumessage = str_replace('<strong>(480)-241-4663</strong>','<strong>(480) 648-9794</strong>',$thankyoumessage);
            $thankyoumessage = "<style>	@font-face {	  font-family: 'Open Sans';	  font-style: Bold;	  font-weight: 600;	  src: local('Open Sans'), local('Open Sans-Bold'), url(http://themes.googleusercontent.com/static/fonts/opensans/v6/DXI1ORHCpsQm3Vp6mXoaTaRDOzjiPcYnFooOUGCOsRk.woff) format('woff')	}	</style><div align='center' style='margin-top: 50px'><p align='center' style='font-family: Open Sans; font-size: 18px;'>Thanks for your request.<br /> Please wait a few seconds as we load your next destination...</p><p align='center' style='text-align: center'><img src='/images/blueass.gif' border='0'></img></p></div>

			<script type='text/javascript'>
				var to = '';
				to = setTimeout(function() { window.location.replace('https://thehomemortgagepro.com/thank-you.htm')  },1000);
			</script>";

            // $s = "update submission_options set thankyou = '".addslashes($newthankyoumessage)."'  ";
            // $s .= " where client_id = " . $client_id;
            // $s .= " and leadpop_id = " . $leadpop_id;
            // $s .= " and leadpop_type_id = " . $leadpop_type_id;
            // $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
            // $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            // $s .= " and leadpop_template_id = " . $leadpop_template_id;
            // $s .= " and leadpop_version_id = " . $leadpop_version_id;
            // $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            // $this->db->query($s);


            $s = "select leadpop_template_id from leadpops where id = " . $leadpop_id;
            $leadpop_template_id = $this->db->fetchOne($s);

            $s = "select id from leadpops_templates_placeholders ";
            $s .= " where leadpop_template_id = " . $leadpop_template_id;
            $s .= " and client_id = " . $client_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;

            $leadpops_templates_placeholders = $this->db->fetchAll($s);
            // for($i=0; $i<count($leadpops_templates_placeholders); $i++) {
            //     $s = "update leadpops_templates_placeholders_values  set ";
            //     $s .= "placeholder_forty = '' where client_leadpop_id = " . $leadpop_id;
            //     $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
            //     $this->db->query($s);
            // }
            for ($i = 0; $i < count($leadpops_templates_placeholders); $i++) {
                $s = "update leadpops_templates_placeholders_values  set placeholder_sixtyfive = '" . addslashes($thankyoumessage) . "'  ";
                $s .= "  where client_leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_template_placeholder_id = " . $leadpops_templates_placeholders[$i]['id'];
                $this->db->query($s);
            }
        }
        die("ok");
    }

    /**
     * TODO:CLEAN-UP
     * @duplicate function
     * @deprecated didn't found usage in complete repo
     *
    public function insertTrackingPixelToDataBase()
    {


        $client_id = "2119";
        $lpkey_funnels = $this->getClientdomainslist($client_id);
        $lplist = explode(",", $lpkey_funnels);
        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];
            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);
            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];

            $trackingcode = '<!-- Facebook Pixel Code -->
			<script>
				!function(f,b,e,v,n,t,s)
				{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
					n.callMethod.apply(n,arguments):n.queue.push(arguments)};
					if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version="2.0";
					n.queue=[];t=b.createElement(e);t.async=!0;
					t.src=v;s=b.getElementsByTagName(e)[0];
					s.parentNode.insertBefore(t,s)}(window,document,"script",
					"https://connect.facebook.net/en_US/fbevents.js");
					fbq("init", "1767088106937582");
					fbq("track", "PageView");
				</script>
				<noscript><img height="1" width="1" style="display:none"
					src="https://www.facebook.com/tr?id=1767088106937582&ev=PageView&noscript=1"
					/></noscript>
					<!-- End Facebook Pixel Code -->';

            $s = "insert into client_tracking (id,client_id,leadpop_vertical_id,";
            $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
            $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,";
            $s .= "script_tag,active) values (null,";
            $s .= $client_id . "," . $leadpop_vertical_id . ",";
            $s .= $leadpop_vertical_sub_id . ",";
            $s .= $leadpop_type_id . "," . $leadpop_template_id . ",";
            $s .= $leadpop_id . ",";
            $s .= $leadpop_version_id . ",";
            $s .= $leadpop_version_seq . ",";
            $s .= "'" . addslashes($trackingcode) . "','1')";
            $this->db->query($s);
        }
        die("Query Successful");
    }
    */


    public function createClientKey($client_id, $api_key)
    {
        $s = "UPDATE clients SET api_token = '" . $api_key . "' WHERE client_id = " . $client_id;
        $this->db->query($s);
    }

    public function createClientAccessKey($client_id, $api_acc_key)
    {
        $s = "UPDATE clients SET lp_access_token = '" . $api_acc_key . "' WHERE client_id = " . $client_id;
        $this->db->query($s);
    }


    public function createLeadPopsAccessKey($client_id, $api_key)
    {
        $s = "UPDATE clients SET lp_access_token = '" . $api_key . "' WHERE client_id = " . $client_id;
        $this->db->query($s);
    }

    public function getClientSubscriptions($client_id)
    {
        $events = array("lead.funnel", "lead.subvertical", "lead.group");
        $subscriptions = array();
        foreach ($events as $event) {
            $s = "SELECT * FROM subscriptions where client_id = " . $client_id . " AND event = '" . $event . "'";
            $res = $this->db->fetchAll($s);
            if ($res) {
                foreach ($res as $row) {
                    # $row["group"] = str_replace("lead.", "", $event);
                    $row["group"] = ($event == "lead.funnel" ? "Single Funnel" : ($event == "lead.subvertical" ? "Funnels on Sub-Vertical Level" : "Funnels on Group Level"));
                    $row["identifierName"] = $this->getSubscriptionIdentifierName($row["leadpop_identifier"], $event);
                    $subscriptions[] = $row;
                }
            }
        }

        return $subscriptions;
    }

    public function getClientIntegrations($client_id)
    {
        $integrations = array();
        $s = "SELECT CONCAT(leadpop_id, '~', leadpop_vertical_id, '~', leadpop_vertical_sub_id, '~', leadpop_template_id, '~', leadpop_version_id, '~', leadpop_version_seq, '~', url) AS 'zkey' FROM client_integrations WHERE client_id = " . $client_id . " AND name = 'zapier'";
        $res = $this->db->fetchAll($s);
        if ($res) {
            foreach ($res as $row) {
                $integrations[] = $row['zkey'];
            }
        }
        return implode(",", $integrations);
    }

    private function getSubscriptionIdentifierName($identifierId, $type)
    {
        if ($type == "lead.funnel") {
            $sql = "SELECT clients_leadpops.id AS id, CONCAT(subdomains.subdomain_name,'.',subdomains.top_level_domain) AS name ";
            $sql .= "FROM clients_funnels_domains subdomains INNER JOIN clients_leadpops ON ( subdomains.client_id = clients_leadpops.client_id  AND subdomains.leadpop_id = clients_leadpops.leadpop_id  AND subdomains.leadpop_version_id = clients_leadpops.leadpop_version_id AND subdomains.leadpop_version_seq = clients_leadpops.leadpop_version_seq) ";
            $sql .= "WHERE clients_leadpops.id = " . $identifierId;
            $sql .= " AND subdomains.leadpop_type_id = " . config('leadpops.leadpopSubDomainTypeId');
            $sql .= " GROUP BY clients_leadpops.id";
        } else if ($type == "lead.subvertical") {
            $sql = "SELECT id, display_label AS `name` FROM leadpops_verticals_sub WHERE id = " . $identifierId;
        } else if ($type == "lead.group") {
            $sql = "SELECT id, group_name AS `name` FROM leadpops_vertical_groups WHERE id = " . $identifierId;
        }

        $res = $this->db->fetchRow($sql);
        if ($res) {
            return $res['name'];
        } else {
            return "";
        }

    }

    public function deleteSubscription($client_id, $subscription_id)
    {
        $s = "DELETE FROM subscriptions WHERE is_test = 0 AND client_id = " . $client_id . " AND id = " . $subscription_id;
        $this->db->query($s);
    }

    public function updateThankYouPageLogo($new_logo_url, $funnel_data)
    {
        $s = "select * from submission_options ";
        $s .= " where client_id = " . $funnel_data['client_id'];
        $s .= " and leadpop_version_id = " . $funnel_data['leadpop_version_id'];
        $s .= " and leadpop_version_seq = " . $funnel_data['leadpop_version_seq'];
        $submissionOptions = $this->db->fetchRow($s);
        if ($submissionOptions) {
            $thankyou = $submissionOptions['thankyou'];
            if ($submissionOptions['thankyou_logo'] == 1) {
                $thankyou = preg_replace('/<p(?=[^>]*id="defaultLogoContainer")(.*?)>(.*?)<\/p>/', '', $thankyou);
                $thankyou = preg_replace('/<img(?=[^>]*id="defaultLogo")(.*?)>/', '', $thankyou);

                $logo = '<p id="defaultLogoContainer" style="text-align: center;"><img alt="" id="defaultLogo" style="max-width: 350px; max-height: 120px;" src="' . $new_logo_url . '"></p>';
                $thankyou = $logo . $thankyou;
                $s = "UPDATE submission_options SET thankyou = '" . addslashes($thankyou) . "' WHERE id = " . $submissionOptions['id'];
                $this->db->query($s);
            }
        }

    }


    /**
     * @param $client_id
     * @param $leadpop_id
     * @param $leadpop_version_seq
     * @param string $key
     * @return mixed|string
     */
    public function getFunnelVariables($client_id, $leadpop_id, $leadpop_version_seq, $key = '')
    {
        ## TODO-COMPOSITE-INDEXING
        $s = "SELECT id, funnel_variables FROM clients_leadpops ";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_id = " . $leadpop_id;
        $s .= " AND leadpop_version_seq = " . $leadpop_version_seq;

        $res = $this->db->fetchRow($s);
        if ($res) {
            $funnel_variables = json_decode($res['funnel_variables'], 1);
            if ($key !== "") {
                return (array_key_exists($key, $funnel_variables) ? $funnel_variables[$key] : "");
            } else {
                return $funnel_variables;
            }
        } else {
            return "";
        }
    }

    /**
     * Update a single variable for funnel in funnel_variables column
     *
     * @param $key string       Key of variable to add/update
     * @param $value string     value of variable to add/update
     * @param $client_id int
     * @param $leadpop_id int
     * @param $leadpop_version_seq int
     */
    public function updateFunnelVar($key, $value, $client_id, $leadpop_id, $leadpop_version_seq)
    {
        $funnel_variables = $this->getFunnelVariables($client_id, $leadpop_id, $leadpop_version_seq);
        $funnel_variables[$key] = $value;
## TODO-COMPOSITE-INDEXING
        $s = "UPDATE clients_leadpops SET funnel_variables = '" . addslashes(json_encode($funnel_variables)) . "' ";
        $s .=", last_edit = '" . date("Y-m-d H:i:s") . "'";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_id = " . $leadpop_id;
        $s .= " AND leadpop_version_seq = " . $leadpop_version_seq;
        $this->db->query($s);
    }

    /**
     * Update a mutiple variable for funnel in funnel_variables column
     *
     * @param $variables array  Key/Value pair of variable to add/update
     * @param $client_id int
     * @param $leadpop_id int
     * @param $leadpop_version_seq int
     */
    public function updateFunnelVariables($variables, $client_id, $leadpop_id, $leadpop_version_seq)
    {
        $funnel_variables = $this->getFunnelVariables($client_id, $leadpop_id, $leadpop_version_seq);
        if($funnel_variables == "") $funnel_variables = array();

        if ($variables) {
            foreach ($variables as $key => $value) {
                $funnel_variables[$key] = $value;
            }
            ## TODO-COMPOSITE-INDEXING
            $s = "UPDATE clients_leadpops SET funnel_variables = '" . addslashes(json_encode($funnel_variables)) . "' ";
            $s .=", last_edit = '" . date("Y-m-d H:i:s") . "'";
            $s .= " WHERE client_id = " . $client_id;
            $s .= " AND leadpop_id = " . $leadpop_id;
            $s .= " AND leadpop_version_seq = " . $leadpop_version_seq;
            $this->db->query($s);
        }
    }

    /**
     * @param $client_id
     * @param $leadpop_id
     * @param $leadpop_version_seq
     * @param string $column
     * @return mixed|string
     */
    public function getLeadLine($client_id, $leadpop_id, $leadpop_version_seq, $column = 'lead_line')
    {
        ## TODO-COMPOSITE-INDEXING
        $s = "SELECT id, " . $column . " FROM clients_leadpops ";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_id = " . $leadpop_id;
        $s .= " AND leadpop_version_seq = " . $leadpop_version_seq;

        $res = $this->db->fetchRow($s);
        $variable = $res[$column];
        return $variable;
    }

    /**
     * Update a single variable for funnel in funnel_variables column
     *
     * @param $column string
     * @param $value string
     * @param $client_id int
     * @param $leadpop_id int
     * @param $leadpop_version_seq int
     */
    public function updateLeadLine($column, $value, $client_id, $leadpop_id, $leadpop_version_seq)
    {
        $currentFunnelKey = "";
        if(@isset($_POST['current_hash'])){
            $currentFunnelKey = @LP_Helper::getInstance()->getFunnelKeyStringFromHash(@$_POST['current_hash']);
        }

        ## TODO-COMPOSITE-INDEXING
        $s = "UPDATE clients_leadpops SET " . $column . " = '" . addslashes($value) . "' ";
        $s .=", last_edit = '" . date("Y-m-d H:i:s") . "'";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_id = " . $leadpop_id;
        $s .= " AND leadpop_version_seq = " . $leadpop_version_seq;
//        $this->db->query($s);
        Query::execute($s, $currentFunnelKey);
    }




































    //=======================================================================================================================================================
    //=========================================================deprecated in admin3.0-----===================================================================
    //=======================================================================================================================================================


    /**
     * @deprecated deprecated in admin3.0
     * Individual Ajax replaced with common save button
     */

    public function updatestatusglobaladvancefooter($client_id, $data)
    {


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
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];
            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);

            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];

            $s = "select * from bottom_links ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $bottomLinks = $this->db->fetchRow($s);


            if ($bottomLinks) {
                /*
                if($bottomLinks['advanced_footer_active'] == 'y') {
                    $changeto = 'n';
                }
                else {
                    $changeto = 'y';
                }
                */
                if ($data['status'] == "y") {
                    $changeto = 'y';
                } else {
                    $changeto = 'n';
                }

                $s = "update bottom_links  set advanced_footer_active = '" . $changeto . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                $this->db->query($s);
            } else {
                $query = "INSERT INTO `bottom_links`(`client_id`, `leadpop_id`,
                        `leadpop_type_id`, `leadpop_vertical_id`,
                        `leadpop_vertical_sub_id`, `leadpop_template_id`,
                         `leadpop_version_id`,`leadpop_version_seq`,`advanced_footer_active`)
                          VALUES ($client_id, $leadpop_id,
                          $leadpop_type_id, $leadpop_vertical_id, $leadpop_vertical_sub_id,
                          $leadpop_template_id, $leadpop_version_id,$leadpop_version_seq,'y');";
                $this->db->query($query);
            }


            $s = "SELECT clients_leadpops.id FROM clients_leadpops INNER JOIN leadpops ON leadpops.id = clients_leadpops.leadpop_id";
            $s .= " WHERE client_id = " . $client_id;
            $s .= " AND clients_leadpops.leadpop_id = " . $leadpop_id;
            $s .= " AND leadpops.leadpop_vertical_id = " . $leadpop_vertical_id;
            $s .= " AND leadpops.leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            $s .= " AND leadpop_template_id = " . $leadpop_template_id;
            $s .= " AND leadpops.leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $clientLeadpopInfo = $this->db->fetchRow($s);
            if ($clientLeadpopInfo) {
                $s = "UPDATE clients_leadpops SET date_updated = '" . date("Y-m-d H:i:s") . "'";
                $s .= ", last_edit = '" . date("Y-m-d H:i:s") . "'";
                $s .= " WHERE client_id = " . $client_id;
                $s .= " AND id = " . $clientLeadpopInfo['id'];
                $this->db->query($s);
            }
        }

        if ($data['status'] == "y") {
            $changeto = 'y';
        } else {
            $changeto = 'n';
        }


        $table_data = array(
            'client_id' => $client_id,
            'advanced_footer_active' => $changeto,
        );


//        if (isset($table_data))
//            $this->db->update('global_settings', $table_data, 'client_id = ' . $client_id);

    }


    /**
     * @deprecated deprecated in admin3.0
     * Function in LpAccountRepository::editRecipientGlobalAdminThree
     */
    public function saveNewGlobalRecipient()
    {
        extract($_POST, EXTR_OVERWRITE, "form_");
        $adata = array(
            "newclient_id" => "1344",
            "isnewrowid" => "y",
            "newemail" => "michael@mdcgroup.net",
            "newtextcell" => "y",
        );

        $client_id = $adata['newclient_id'];
        $lpkey_leadnotification = $this->getClientdomainslist($client_id);
        $lplist = explode(",", $lpkey_leadnotification);

        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];
            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);

            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];

            if ($adata['isnewrowid'] == 'n') {
                $s = "update lp_auto_recipients set email_address = '" . $adata['newemail'] . "' ";
                $s .= " where id =  " . $adata['editrowid'];
                $this->db->query($s);
                if ($adata['newtextcell'] == 'y') {
                    $s = "update lp_auto_text_recipients set phone_number = '" . $adata['cell_number'] . "', ";
                    $s .= " carrier = '" . $adata['carrier'] . "' where lp_auto_recipients_id = " . $adata['editrowid'];
                    $this->db->query($s);
                } else if ($adata['newtextcell'] == 'n') {
                    $s = "update lp_auto_text_recipients set phone_number = '', carrier = 'none'  ";
                    $s .= "  where lp_auto_recipients_id = " . $adata['editrowid'];
                    $this->db->query($s);
                }
            } else if ($adata['isnewrowid'] == 'y') {
                //list($verticalName,$subverticalName,$leadpop_id,$leadpop_version_seq,$client_id) = explode("~",$adata['newkeys']);

                $s = "select * from leadpops where id = " . $leadpop_id;
                $lp = $this->db->fetchRow($s);


                $s = "select count(*) as cnt  from lp_auto_recipients where ";
                $s .= " client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $lp['leadpop_type_id'];
                $s .= " and leadpop_vertical_id = " . $lp['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $lp['leadpop_vertical_sub_id'];
                $s .= " and leadpop_template_id = " . $lp['leadpop_template_id'];
                $s .= " and leadpop_version_id = " . $lp['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                $s .= " and email_address = '" . $adata['newemail'] . "' ";
                //die($s);
                $cnt = $this->db->fetchOne($s);
                if ($cnt == 0) {
                    $s = "insert into lp_auto_recipients (client_id,leadpop_id,leadpop_type_id,";
                    $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                    $s .= "leadpop_version_seq,email_address,is_primary) values (" . $client_id . ",";
                    $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . "," . $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                    $s .= "," . $leadpop_version_seq . ",'" . $adata['newemail'] . "','n')";
                    $this->db->query($s);

                    $lastId = $this->db->lastInsertId();

                    $s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
                    $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                    $s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $client_id . "," . $lastId . ",";
                    $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . ",";
                    $s .= $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                    $s .= "," . $leadpop_version_seq . ",'" . $adata['cell_number'] . "','" . $adata['carrier'] . "','n')";
                    $this->db->query($s);
                }
            }
        }
        die("ok");
    }

    /**
     * @deprecated deprecated in admin3.0
     * Individual Ajax replaced with common save button
     */

    public function updateglobaladvancefooter($client_id, $data)
    {
        //  $funnel_info = $data['funnels-info'];
//        $advancehtml = $data['fr-html'];
        $advancehtml = $data['advancehtml'];
        $hideofooter = $data['hideofooter'];
        $templateType = isset($data["templatetype"]) ? $data["templatetype"] : null;
        $isDefaultTplCtaMessage = (isset($_POST['defaultTplCtaMessage']) && $_POST['defaultTplCtaMessage'] == "y");

        $lplist = explode(",", $_POST['selected_funnels']);

        if (empty($_POST['selected_funnels']) || !count($lplist)) {
            Session::flash('error', '<strong>Error:</strong>Please select funnels for global action.');
            return redirect()->back();
        }

        $lplist = collect($lplist);
        $currentHash = $_POST['current_hash'];
        if($currentHash){
            $lplist->prepend(LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash));

        }

        $lplist = $lplist->unique()->values()->all();

        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];
            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);

            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];

            $s = "select * from bottom_links ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $bottomLinks = $this->db->fetchRow($s);


            if ($bottomLinks) {

                $s = "update bottom_links set advancehtml = '" . addslashes($advancehtml) . "', hide_primary_footer = '" . $hideofooter . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                $this->db->query($s);
                // print_r($s);
            } else {
                $query = "INSERT INTO `bottom_links`.`comments` (`client_id`, `leadpop_id`,
                        `leadpop_type_id`, `leadpop_vertical_id`,
                        `leadpop_vertical_sub_id`, `leadpop_template_id`,
                         `leadpop_version_id`,`leadpop_version_seq`,`advancehtml`,`hide_primary_footer`)
                          VALUES ($client_id, $leadpop_id,
                          $leadpop_type_id, $leadpop_vertical_id, $leadpop_vertical_sub_id,
                          $leadpop_template_id, $leadpop_version_id,$leadpop_version_seq,addslashes($advancehtml),$hideofooter);";
                $this->db->query($query);
                // print_r($query);

            }


            $s = "SELECT clients_leadpops.id, clients_leadpops.lead_line, clients_leadpops.second_line_more FROM clients_leadpops INNER JOIN leadpops ON leadpops.id = clients_leadpops.leadpop_id";
            $s .= " WHERE client_id = " . $client_id;
            $s .= " AND clients_leadpops.leadpop_id = " . $leadpop_id;
            $s .= " AND leadpops.leadpop_vertical_id = " . $leadpop_vertical_id;
            $s .= " AND leadpops.leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            $s .= " AND leadpop_template_id = " . $leadpop_template_id;
            $s .= " AND leadpops.leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $clientLeadpopInfo = $this->db->fetchRow($s);
            if ($clientLeadpopInfo) {
                $s = "UPDATE clients_leadpops SET date_updated = '" . date("Y-m-d H:i:s") . "'";

                //Updating font family & size for funnel main message and description
                if ($isDefaultTplCtaMessage && ($templateType == "property_template" || $templateType == "property_template2")) {
                    $reFontFamily = '/font-family:(.*?);/m';
                    $reFountSize = '/font-size:(.*?);/m';

                    $clientLeadpopInfo['lead_line'] = preg_replace($reFontFamily, "font-family:Raleway;", $clientLeadpopInfo['lead_line']);
                    $clientLeadpopInfo['lead_line'] = preg_replace($reFountSize, "font-size:36px;", $clientLeadpopInfo['lead_line']);

                    $clientLeadpopInfo['second_line_more'] = preg_replace($reFontFamily, "font-family:Open Sans;", $clientLeadpopInfo['second_line_more']);
                    $clientLeadpopInfo['second_line_more'] = preg_replace($reFountSize, "font-size:20px;", $clientLeadpopInfo['second_line_more']);

                    $s .= ",lead_line='" . addslashes($clientLeadpopInfo['lead_line']) . "' ";
                    $s .= ",second_line_more='" . addslashes($clientLeadpopInfo['second_line_more']) . "' ";
                }

                $s .= ", last_edit = '" . date("Y-m-d H:i:s") . "'";
                $s .= " WHERE client_id = " . $client_id;
                $s .= " AND id = " . $clientLeadpopInfo['id'];
                $this->db->query($s);
            }
        }
    }


}
