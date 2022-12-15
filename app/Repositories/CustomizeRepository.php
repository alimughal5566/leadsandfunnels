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


use App\Helpers\GlobalHelper;
use App\Models\Leadpops;
use App\Models\SubmissionOption;
use Exception;
use Carbon\Carbon;
use App\Models\Clients;
use App\Services\Client;
use App\Services\DbService;
use App\Services\DataRegistry;
use App\Constants\FunnelVariables;
use App\Models\AutoResponderOption;
use App\Models\ClientsLeadpops;
use App\Models\LeadpopBackgroundColor;
use App\Repositories\LpAdminRepository;
use App\Services\gm_process\MyLeadsEvents;
use App\Helpers\Query;
use Illuminate\Database\Eloquent\Collection;
use LP_Helper;
use \DB;
class CustomizeRepository
{
    use Response;
    private $db;
    protected static $leadpopDomainTypeId = 0;

    private $MAX_W = 190;
    private $MAX_H = 90;
    private $PAD = 10;


    private $leadpop_vertical_id;
    private $leadpop_vertical_sub_id;
    private $leadpop_id;
    private $leadpop_type_id;
    private $leadpop_template_id;
    private $leadpop_version_id;
    private $leadpop_version_seq;
    private $clientId;


    private function setupLeadPopsCommonVariableFromFunnelData($funnel_data)
    {

        $this->leadpop_vertical_id = $funnel_data["leadpop_vertical_id"];
        $this->leadpop_vertical_sub_id = $funnel_data["leadpop_vertical_sub_id"];
        $this->leadpop_id = $funnel_data["leadpop_id"];
        $this->leadpop_type_id = $funnel_data['leadpop_type_id'];
        $this->leadpop_template_id = $funnel_data['leadpop_template_id'];
        $this->leadpop_version_id = $funnel_data['leadpop_version_id'];
        $this->leadpop_version_seq = $funnel_data["leadpop_version_seq"];
    }

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
        $leadpop_template_id = $funnel_data["funnel"]['leadpop_template_id'];
        $leadpop_version_id = $funnel_data["funnel"]['leadpop_version_id'];
        $leadpop_type_id = $funnel_data["funnel"]['leadpop_type_id'];
        $client_id = $client_id;
        $thelink = $the_link;

        $s = "select * from submission_options ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;

        $submissionOptions = $this->db->fetchRow($s);

        if (empty($submissionOptions) || !$submissionOptions) {
            $submissionOptionsthankyou_active = 'y';
            $submissionOptionsthirdparty_active = 'n';
            $submissionOptionsinformation_active = 'n';

        } else {
            $submissionOptionsthankyou_active = $submissionOptions['thankyou_active'];
            $submissionOptionsthirdparty_active = $submissionOptions['thirdparty_active'];
            $submissionOptionsinformation_active = $submissionOptions['information_active'];
        }

        if ($thelink == 'thankyou_active') {
            if ($submissionOptionsthankyou_active == 'y') {
                $changeto = 'n';
            } else {
                $changeto = 'y';
            }
        }

        if ($thelink == 'information_active') {
            if ($submissionOptionsinformation_active == 'y') {
                $changeto = 'n';
            } else {
                $changeto = 'y';
            }
        }

        if ($thelink == 'thirdparty_active') {
            if ($submissionOptionsthirdparty_active == 'y') {
                $changeto = 'n';
            } else {
                $changeto = 'y';
            }
        }

        $s = "update submission_options  set  thirdparty_active = 'n' , information_active = 'n', thankyou_active = 'n' ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;

        if (request()->has('submission_id')) {
            $s .= " and id = " . request()->get('submission_id');
        }
        $this->db->query($s);

        $s = "update submission_options  set " . $thelink . " = '" . $changeto . "' ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;

        if (request()->has('submission_id')) {
            $s .= " and id = " . request()->get('submission_id');
        }

        $this->db->query($s);
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
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_id = $funnel_data["leadpop_id"];
            $leadpop_type_id = $funnel_data['leadpop_type_id'];
            $leadpop_template_id = $funnel_data['leadpop_template_id'];
            $leadpop_version_id = $funnel_data['leadpop_version_id'];
            $leadpop_version_seq = $funnel_data["leadpop_version_seq"];

            $whereClause = [
                'client_id' => $client_id,
                'leadpop_version_id' => $leadpop_version_id,
                'leadpop_version_seq' => $leadpop_version_seq,
            ];
        $whereData = queryFormat($whereClause, ' and ');
        if ($post['background_type'] != "") {
            $background_type = $post['background_type'];
        } else {
            $background_type = '1';
        }
        // get swatches for current page in case need to add for
        $this->db->update('leadpop_background_swatches',array('is_primary' => 'n'),$whereData);
        $this->db->update('leadpop_background_swatches',array('is_primary' => 'y'),'id = '.$post["swatchnumber"]);

        $background = urldecode($post["background"]); // background=/*###>*/background-color: #8795a9;/*@@@*/ background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIHZpZXdCb3g9IjAgMCAxIDEiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjxsaW5lYXJHcmFkaWVudCBpZD0idnNnZyIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiIHgxPSIwJSIgeTE9IjAlIiB4Mj0iMCUiIHkyPSIxMDAlIj48c3RvcCBzdG9wLWNvbG9yPSIjODc5NWE5IiBzdG9wLW9wYWNpdHk9IjEiIG9mZnNldD0iMCIvPjxzdG9wIHN0b3AtY29sb3I9IiM4Nzk1YTkiIHN0b3Atb3BhY2l0eT0iMSIgb2Zmc2V0PSIxIi8+PC9saW5lYXJHcmFkaWVudD48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMSIgaGVpZ2h0PSIxIiBmaWxsPSJ1cmwoI3ZzZ2cpIiAvPjwvc3ZnPg==); /* IE9, iOS 3.2+ */ background-image: -webkit-gradient(linear, 0% 0%, 0% 100%,color-stop(0, rgb(135, 149, 169)),color-stop(1, rgb(135, 149, 169))); /*Old Webkit*/ background-image: -webkit-linear-gradient(top,rgb(135, 149, 169) 0%,rgb(135, 149, 169) 100%); /* Android 2.3 */ background-image: -ms-linear-gradient(top,rgb(135, 149, 169) 0%,rgb(135, 149, 169) 100%); /* IE10+ */ background-image: linear-gradient(to bottom,rgb(135, 149, 169) 0%,rgb(135, 149, 169) 100%); /* W3C */ /* IE8- CSS hack */ @media \0screen\,screen\9 { .gradient { filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ff8795a9",endColorstr="#ff8795a9",GradientType=0); } }
        $fontcolor = $post["fontcolor"];
        // post variables
            $s = " select * from leadpop_background_color where ".$whereData;
            $_count = $this->db->fetchAll($s);

            if ($_count) {
                // Update background color for first swatch.
                $s = "update leadpop_background_color set
                                    background_color = '" . addslashes($background) . "',active_backgroundimage='n',background_type='1' ";
                $s .= " where ".$whereData;
                $this->db->query($s);
            }
            else {
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
                $s .= $leadpop_version_seq . ",";
                $s .= $background_type . ",";
                $s .= "'" . addslashes($background) . "','n','y','y')";
                $this->db->query($s);
            }

            // update the font-color
            $sixnine = $this->getLeadLine($client_id, $leadpop_id, $leadpop_version_seq, FunnelVariables::LEAD_LINE);
            if ($sixnine != "") {
                $sixnine = $this->getReplacedColorHtml($sixnine, $fontcolor);
                $this->updateLeadLine(FunnelVariables::LEAD_LINE, $sixnine, $client_id, $leadpop_id, $leadpop_version_seq);
            }

            $logo_color = $fontcolor;

            $s = "select count(*) as cnt from leadpop_logos where ".$whereData." and use_default = 'y'";

            $usingDefaultLogo = $this->db->fetchOne($s); // one == using default logo, zero equals uploaded a  logo
            if ($usingDefaultLogo >= 1) {
//                $filename1 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-favicon-circle.png";
//                $filename2 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-dot-img.png";
//                $filename3 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-ring.png";
//                $filename4 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-mvp-check.png";

                $filename1 ="favicon-circle.png";
                $filename2 ="dot-img.png";
                $filename3 ="ring.png";
                $filename4 ="mvp-check.png";

                // For Production
                $favicon_location = rackspace_stock_assets() . "images/" . $filename1;
                $image_location = rackspace_stock_assets() . "images/" . $filename2;
                $mvp_dot_location = rackspace_stock_assets() . "images/" . $filename3;
                $mvp_check_location = rackspace_stock_assets() . "images/" . $filename4;

                $filename1 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-" . $leadpop_version_seq . "-favicon-circle.png";
                $filename2 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-" . $leadpop_version_seq . "-dot-img.png";
                $filename3 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-" . $leadpop_version_seq . "-ring.png";
                $filename4 = "default-" . $vertical_id . "-" . $subvertical_id . "-" . $leadpop_version_id . "-" . $leadpop_version_seq . "-mvp-check.png";

                $favicon_dst_src = rackspace_stock_assets() . "images/" . $filename1;
                $colored_dot_src = rackspace_stock_assets() . "images/" . $filename2;
                $mvp_dot_src = rackspace_stock_assets() . "images/" . $filename3;
                $mvp_check_src = rackspace_stock_assets() . "images/" . $filename4;

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


                $where = "use_default = 'y'";
                $where .= " order By id limit 1";
                $updateData = [
                    'default_colored' => 'y',
                    'logo_color' => ''.$logo_color.''
                ];

            }
            else {
                $filename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $leadpop_version_seq);

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

                $where = "use_me = 'y'";
                $updateData = [
                    'logo_color' => ''.$logo_color.''
                ];
            }
                $design_variables = array();
                $design_variables[FunnelVariables::LOGO_COLOR] = $logo_color;
                $design_variables[FunnelVariables::COLORED_DOT] = $colored_dot;
                $design_variables[FunnelVariables::MVP_DOT] = $mvp_dot;
                $design_variables[FunnelVariables::MVP_CHECK] = $mvp_check;
                $design_variables[FunnelVariables::FAVICON_DST] = $favicon_dst;
                $this->updateFunnelVariables($design_variables, $client_id, $leadpop_id, $leadpop_version_seq);

                $whereData = $whereData .' and ' .$where;
                $this->db->update('leadpop_logos',$updateData,$whereData);
                return 1;
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
                // $s = "delete  from " . $leadpop_background_swatches;
                // $s .= " where  client_id 	= " . $client_id;
                // $s .= " and leadpop_vertical_id = " . $vertical_id;
                // $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
                // $s .= " and leadpop_type_id = " . $leadpop_type_id;
                // $s .= " and leadpop_template_id = " . $leadpop_template_id;
                // $s .= " and leadpop_id = " . $leadpop_id;
                // $s .= " and leadpop_version_id  	= " . $leadpop_version_id;
                // $s .= " and leadpop_version_seq = " . $version_seq;
                // $this->db->query($s);
            }
        }
        /*
			$s = "select * from leadpop_background_swatches ";
			$s .= " where  client_id 	= " . $client_id;
			$s .= " and leadpop_vertical_id = " . $vertical_id;
			$s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
			$s .= " and leadpop_type_id = " . $leadpop_type_id;
			$s .= " and leadpop_template_id = " . $leadpop_template_id;
			$s .= " and leadpop_id = " . $leadpop_id;
			$s .= " and leadpop_version_id  	= " . $leadpop_version_id;
			$s .= " and leadpop_version_seq = " . $version_seq;
			$sw = $this->db->fetchAll($s);

			if($sw) {
				$needToGenerateSwatches = "no";
			}
			else {
				$needToGenerateSwatches = "yes";
			}
*/
        return $logoDefaultOrClient . "~" . $needToGenerateSwatches;
        // client~yes   this is the important one... need to generate swatches because client was not
        // if $needToGenerateSwatches == "no" & $logoDefaultOrClient = "default" then get the swatches from
        // launched from free trial

    }

    public function getDomainList($client_id, $leadpop_id, $leadpop_version_seq)
    {
        $s = "select leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_version_id ";
        $s .= " from leadpops where id = " . $leadpop_id;
        $akeys = $this->db->fetchRow($s);
        $line_item_keys = $akeys['leadpop_vertical_id'] . "-";
        $line_item_keys .= $akeys['leadpop_vertical_sub_id'] . "-";
        $line_item_keys .= $akeys['leadpop_version_id'] . "-";
        $line_item_keys .= self::$leadpopDomainTypeId . "-";
        $line_item_keys .= $leadpop_version_seq;

        $s = "select domain_name, clients_domain_id ";
        $s .= " from clients_funnels_domains";
        $s .= " where leadpop_vertical_id = '" . $akeys['leadpop_vertical_id'] . "' ";
        $s .= " AND leadpop_vertical_sub_id = '" . $akeys['leadpop_vertical_sub_id'] . "' ";
        $s .= " AND leadpop_version_id = '" . $akeys['leadpop_version_id'] . "' ";
        $s .= " AND leadpop_version_seq = '" . $leadpop_version_seq . "' ";
        $s .= " and client_id = " . $client_id;
        $s .= " and domain_name != 'temporary'";
        $s .= " and leadpop_type_id =" . config('leadpops.leadpopDomainTypeId');
        $s .= " and leadpop_id =  '" . $leadpop_id. "' ";

        $domains = $this->db->fetchAll($s);
        return $domains;
    }

    public function checkUnlimitedDomains($client_id, $leadpop_id, $leadpop_version_seq)
    {
        return true;
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
        $s .= " and leadpop_version_id =  " . $args["leadpop_version_id"];
        $s .= " and leadpop_version_seq = " . $args["leadpop_version_seq"];
        //echo $s;
        $lpactive = $this->db->fetchOne($s);
        return $lpactive;
    }

    public function uploadImage($afiles, $client_id, $funnel_data = array())
    {
      //  dd($POSTDATA);
        $scaling_properties = '';
        if(isset($_POST['scaling_defaultWidthPercentage'])){
            $scaling_properties = json_encode(['maxWidth'=>@$_POST['scaling_maxWidthPx'], 'scalePercentage'=>@$_POST['scaling_defaultWidthPercentage']]);
        }
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
            return $this->errorResponse();
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
            ## $s = "update leadpop_images  set numpics = 1,image_src = '" . $imagename . "', use_me = 'y' , use_default = 'n' ";
            $s = "update leadpop_images  set numpics = 1,image_src = '" . $imagename . "' ,scaling_properties = '" . $scaling_properties . "' ";
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
            $s = "INSERT into leadpop_images (numpics, image_src, use_me, use_default, client_id, leadpop_id, leadpop_type_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_template_id, leadpop_version_id, leadpop_version_seq, scaling_properties) ";
            $s .= " VALUES (1, '" . $imagename . "', 'y', 'n', " . $client_id . ", " . $leadpop_id . ", " . $leadpop_type_id . ", " . $vertical_id . ", " . $subvertical_id . ", " . $leadpop_template_id . ", " . $leadpop_version_id . ", " . $version_seq . ", " . $scaling_properties . ")";
            $this->db->query($s);
        }

        $imagesrc = getCdnLink() . '/pics/' . $imagename;

        $design_variables = [];
        $design_variables[FunnelVariables::FRONT_IMAGE] = $imagesrc;
        $this->updateFunnelVariables($design_variables, $client_id, $leadpop_id, $version_seq);


      //  $this->updateFunnelVar(FunnelVariables::FRONT_IMAGE, $imagesrc, $client_id, $leadpop_id, $version_seq);

        return $this->successResponse(["image_src" => $imagesrc]);
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
        $vertical_id = $funnel_data["leadpop_vertical_id"];
        $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
        $leadpop_id = $funnel_data["leadpop_id"];
        $leadpop_type_id = $funnel_data['leadpop_type_id'];
        $leadpop_template_id = $funnel_data['leadpop_template_id'];
        $leadpop_version_id = $funnel_data['leadpop_version_id'];
        $leadpop_version_seq = $funnel_data["leadpop_version_seq"];

        $s = "select numpics,use_default from leadpop_logos ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $leadpop_version_seq;

        $respics = $this->db->fetchRow($s);
        if ($respics) {
            $numpics = $respics['numpics'] + 1;
            $usedefault = $respics['use_default'];
        } else {
            $numpics = 1;
            $usedefault = "y";
        }

        $afiles['logo']['name'] = preg_replace('/[^\.a-zA-Z0-9]/', '', $afiles['logo']['name']);
        $logoname = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $leadpop_version_seq . "_" . $afiles['logo']['name']);
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
            return $this->errorResponse();
        }

        $response = [];
        #$logoname = $cdn['client_cdn'];
        $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
        $s .= "logo_src,use_me,numpics,logo_color,ini_logo_color, swatches, last_update) values (null,";
        $s .= $client_id . "," . $leadpop_id . "," . $leadpop_type_id . "," . $vertical_id . "," . $subvertical_id . ",";
        $s .= $leadpop_template_id . "," . $leadpop_version_id . "," . $leadpop_version_seq . ",";
        $s .= "'" . $usedefault . "','" . $logoname . "','n'," . $numpics . ", '" . $logo_color . "','" . $logo_color . "', '" . $swatches . "', " . time() . ") ";
        if($this->db->query($s)){
            $response = [
                "id" => $this->db->lastInsertId(),
                "image_src" => $cdn["client_cdn"],
                "swatches" => $swatches
            ];
        }

        $s = "UPDATE clients_leadpops SET  last_edit = '" . date("Y-m-d H:i:s") . "'";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_version_id  = " . $leadpop_version_id;
        $s .= " AND leadpop_version_seq  = " . $leadpop_version_seq;
        $this->db->query($s);

        return $this->successResponse($response);
    }

    public function uploadgloballogo($afiles, $client_id)
    {
        $afiles['globallogo']['name'] = preg_replace('/[^\.a-zA-Z0-9]/', '', $afiles['globallogo']['name']);
        $logoname = strtolower($client_id . "_global_" . $afiles['globallogo']['name']);

        $section = substr($client_id, 0, 1);
        $logopath = $section . '/' . $client_id . '/logos/' . $logoname;
        //**// $logourl = $this->getHttpAdminServer() . '/images/clients/' . $section . '/' . $client_id . '/logos/' . $logoname;
        $logourl = getCdnLink() . '/logos/' . $logoname;

        list($src_w, $src_h, $type) = getimagesize($afiles['globallogo']["tmp_name"]);

        //**// move_uploaded_file($afiles['globallogo']['tmp_name'], $logopath);
        $cdn = move_uploaded_file_to_rackspace($afiles['globallogo']['tmp_name'], $logopath);
        $logopath = $cdn['rs_cdn'];

        $logo_color = $this->getLogoProminentColor($logopath);
        if (is_array($logo_color)) {
            $logo_color = $logo_color[0];
        }

        $s = "select * from global_settings where client_id = " . $client_id;
        $client = $this->db->fetchRow($s);

        if ($_POST['logosavetype'] == 'uploadlogo') {
            $clien_logo = "logo1";
            $check = true;
            if ($client) {
                if ($client["logo1"] == "") {
                    $clien_logo = "logo1";
                    $check = false;
                }

                if ($client["logo2"] == "" && $check == true) {
                    $clien_logo = "logo2";
                    $check = false;
                }

                if ($client["logo3"] == "" && $check == true) {
                    $clien_logo = "logo3";
                }
            }

            if ($clien_logo != "") {
                if (!$client) {
                    $s = "insert into global_settings (id,client_id,$clien_logo";
                    $s .= ") values (null,";
                    $s .= $client_id . ",'" . $logourl . "') ";
                    $this->db->query($s);
                } else {
                    $s = "update global_settings set $clien_logo = '" . $logourl . "'";
                    $s .= " where client_id = " . $client_id;
                    $this->db->query($s);
                }
            }
        }

        return 'ok';
    }

    public function uploadcombinelogos($post, $afiles, $funnel_data = array())
    {
        $registry = DataRegistry::getInstance();
        $vertical_id = $funnel_data["leadpop_vertical_id"];
        $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
        $leadpop_id = $funnel_data["leadpop_id"];
        $leadpop_type_id = $funnel_data['leadpop_type_id'];
        $leadpop_template_id = $funnel_data['leadpop_template_id'];
        $leadpop_version_id = $funnel_data['leadpop_version_id'];
        $leadpop_version_seq = $funnel_data["leadpop_version_seq"];
        $container = $registry->leadpops->clientInfo['rackspace_container'];
        $client_id = $post['client_id'];
        $section = substr($client_id, 0, 1);
        $logopath = $section . '/' . $client_id . '/logos/';
        // Combine and resize
        $pre_image_style = explode("~", $post['pre-image-style']);
        $post_image_style = explode("~", $post['post-image-style']);
        $rand = $this->generateRandomString(4);

        $src1_img_w = round(str_replace('px', '', $pre_image_style[0]));
        $src1_img_h = round(str_replace('px', '', $pre_image_style[1]));
        $src2_img_w = round(str_replace('px', '', $post_image_style[0]));
        $src2_img_h = round(str_replace('px', '', $post_image_style[1]));
        $pre_image = env('RACKSPACE_TMP_DIR', '') ."/".$rand.$afiles['pre-image']['name'];
        $post_image = env('RACKSPACE_TMP_DIR', '') ."/".$rand.$afiles['post-image']['name'];
        file_put_contents($pre_image,file_get_contents($afiles['pre-image']['tmp_name']));
        file_put_contents($post_image,file_get_contents($afiles['post-image']['tmp_name']));

        $src1_image = $this->_createImage($pre_image);
        $src1_image = $this->resize_image($src1_image, $src1_img_w, $src1_img_h);
        $src1_img_w = imagesx($src1_image);
        $src1_img_h = imagesy($src1_image);

        $src2_image = $this->_createImage($post_image);
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
        $s .= " and leadpop_version_seq = " . $leadpop_version_seq;

        $respics = $this->db->fetchRow($s);
        if (empty($respics)) {
            $respics['numpics'] = 0;
            $respics['use_default'] = "y";
        }
        $numpics = $respics['numpics'] + 1;
        $usedefault = $respics['use_default'];

        $afiles['pre-image']['name'] = preg_replace('/[^\.a-zA-Z0-9]/', '', $afiles['pre-image']['name']);
        $logoname = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $leadpop_version_seq . "_" . $rand . $afiles['pre-image']['name']);
        $logopath = $logopath . $logoname;
        $logopath = dir_to_str($logopath, true);

        imagepng($wrapper_img, $logopath);

        $logo_color = $this->getLogoProminentColor($logopath);

        $cdn = move_file_to_rackspace($logopath);       //Save file to tmp direcotry on local and on selection create swatches and then update leadpop_logos
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
            return $this->errorResponse();
        }

        $response = [];
        $s = "insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $s .= "leadpop_version_id,leadpop_version_seq,use_default,";
        $s .= "logo_src,use_me,numpics,logo_color,ini_logo_color,last_update) values (null,";
        $s .= $client_id . "," . $leadpop_id . "," . $leadpop_type_id . "," . $vertical_id . "," . $subvertical_id . ",";
        $s .= $leadpop_template_id . "," . $leadpop_version_id . "," . $leadpop_version_seq . ",";
        $s .= "'" . $usedefault . "','" . $logoname . "','n'," . $numpics . ", '" . $logo_color . "','" . $logo_color . "', " . time() . ") ";
        if($this->db->query($s)){
            $response = [
                "id" => $this->db->lastInsertId(),
                "image_src" => $cdn["client_cdn"]
            ];
        }

        $s = "update leadpop_logos  set numpics = " . $numpics;
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
        $this->db->query($s);
        return $this->successResponse($response);
    }

    private function generateRandomString($length = 10)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    private function _createImage($file)
    {
        $ext = getimagesize($file);

        switch ($ext['mime']) {
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

        return $image_create_func($file);
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

    private function resize_image($file, $w, $h, $crop = FALSE)
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

    public function updateglobalbackgroundcolor($client_id, $post)
    {

        extract($post, EXTR_OVERWRITE, "form_");
        $lplist = explode(",", $lpkey_backgroundcolor);
        $lplist = array_unique($lplist);
        if ($post['background_type'] != "") {
            $background_type = $post['background_type'];
        } else {
            $background_type = '1';
        }


        $background = urldecode($post["background"]); // background=/*###>*/background-color: #8795a9;/*@@@*/ background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIHZpZXdCb3g9IjAgMCAxIDEiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjxsaW5lYXJHcmFkaWVudCBpZD0idnNnZyIgZ3JhZGllbnRVbml0cz0idXNlclNwYWNlT25Vc2UiIHgxPSIwJSIgeTE9IjAlIiB4Mj0iMCUiIHkyPSIxMDAlIj48c3RvcCBzdG9wLWNvbG9yPSIjODc5NWE5IiBzdG9wLW9wYWNpdHk9IjEiIG9mZnNldD0iMCIvPjxzdG9wIHN0b3AtY29sb3I9IiM4Nzk1YTkiIHN0b3Atb3BhY2l0eT0iMSIgb2Zmc2V0PSIxIi8+PC9saW5lYXJHcmFkaWVudD48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMSIgaGVpZ2h0PSIxIiBmaWxsPSJ1cmwoI3ZzZ2cpIiAvPjwvc3ZnPg==); /* IE9, iOS 3.2+ */ background-image: -webkit-gradient(linear, 0% 0%, 0% 100%,color-stop(0, rgb(135, 149, 169)),color-stop(1, rgb(135, 149, 169))); /*Old Webkit*/ background-image: -webkit-linear-gradient(top,rgb(135, 149, 169) 0%,rgb(135, 149, 169) 100%); /* Android 2.3 */ background-image: -ms-linear-gradient(top,rgb(135, 149, 169) 0%,rgb(135, 149, 169) 100%); /* IE10+ */ background-image: linear-gradient(to bottom,rgb(135, 149, 169) 0%,rgb(135, 149, 169) 100%); /* W3C */ /* IE8- CSS hack */ @media \0screen\,screen\9 { .gradient { filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#ff8795a9",endColorstr="#ff8795a9",GradientType=0); } }
        $gradient = urldecode($post["gradient"]); //border-radius: 5px; border: 2px solid rgb(0, 0, 0); display: block; z-index: 5000; width: 744px; height: 390px; position: absolute; left: 16px; top: 136px; background-image: linear-gradient(to bottom, rgb(135, 149, 169) 0%, rgb(135, 149, 169) 100%);
        $fontcolor = $post["fontcolor"];
        $fontcolor = trim(str_replace('background-color:', '', $fontcolor));
        $range = "thedomain"; //domain,all,vertical,subvertical
        $swatch_arr = explode("-", $post["swatchnumber"]);
        $swatchnumber = end($swatch_arr);  // like "swatchnumber-22"

        //$file = file_get_contents($image_url);
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
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $s .= " order by id ";
            $currentSwatches = $this->db->fetchAll($s);


            $s = "delete from " . $leadpop_background_swatches;
            $s .= " where client_id = " . $client_id;
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

            $sixnine = $this->getLeadLine($client_id, $leadpop_id, $leadpop_version_seq, FunnelVariables::LEAD_LINE);
            if ($sixnine != "") {
                $sixnine = $this->getReplacedColorHtml($sixnine, $fontcolor);
                $this->updateLeadLine(FunnelVariables::LEAD_LINE, $sixnine, $client_id, $leadpop_id, $leadpop_version_seq);
            }

            $s = "insert into leadpop_background_color (id,client_id,leadpop_vertical_id,";
            $s .= "leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,";
            $s .= "leadpop_id,leadpop_version_id,leadpop_version_seq,background_type,";
            $s .= "background_color,active,active_backgroundimage,default_changed) values (null,";
            $s .= $client_id . "," . $leadpop_vertical_id . ",";
            $s .= $leadpop_vertical_sub_id . ",";
            $s .= $leadpop_type_id . "," . $leadpop_template_id . ",";
            $s .= $leadpop_id . ",";
            $s .= $leadpop_version_id . ",";
            $s .= $leadpop_version_seq . ",";
            $s .= $background_type . ",";
            $s .= "'" . addslashes($background) . "','y','n','y')";

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

                $design_variables = array();
                $design_variables[FunnelVariables::LOGO_COLOR] = $logo_color;
                $design_variables[FunnelVariables::COLORED_DOT] = $colored_dot;
                $design_variables[FunnelVariables::MVP_DOT] = $mvp_dot;
                $design_variables[FunnelVariables::MVP_CHECK] = $mvp_check;
                $design_variables[FunnelVariables::FAVICON_DST] = $favicon_dst;
                $this->updateFunnelVariables($design_variables, $client_id, $leadpop_id, $leadpop_version_seq);

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
                if ($currentSwatches) {

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


                $design_variables = array();
                $design_variables[FunnelVariables::LOGO_COLOR] = $logo_color;
                $design_variables[FunnelVariables::COLORED_DOT] = $colored_dot;
                $design_variables[FunnelVariables::MVP_DOT] = $mvp_dot;
                $design_variables[FunnelVariables::MVP_CHECK] = $mvp_check;
                $design_variables[FunnelVariables::FAVICON_DST] = $favicon_dst;
                $this->updateFunnelVariables($design_variables, $client_id, $leadpop_id, $leadpop_version_seq);

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

        $s = "select * from global_settings where client_id = " . $client_id;
        $client = $this->db->fetchRow($s);
        $swatch_arr = array();
        if ($currentSwatches) {
            for ($j = 0; $j < count($currentSwatches); $j++) {
                $swatch_arr[$j] = addslashes($currentSwatches[$j]["swatch"]);
            }
        }
        $swatchs = json_encode($swatch_arr);
        if (!$client) {
            $s = "insert into global_settings (id,client_id,bk_image_active,swatches";
            $s .= ") values (null,";
            $s .= $client_id . ",'n','" . $swatchs . "')";
            $this->db->query($s);
        } else {
            $s = "update global_settings set bk_image_active = 'n',swatches='" . $swatchs . "'";
            $s .= " where client_id = " . $client_id;
            $this->db->query($s);
        }
        return 'ok';
    }

    public function updateglobalbackgroundimage($client_id, $post, $afiles)
    {
        $registry = DataRegistry::getInstance();
        extract($post->all(), EXTR_OVERWRITE, "form_");
        $tarr = [];
        $lplist = explode(",", $lpkey_backgroundimage);
        if ($post['background_type'] != "") {
            $background_type = $post['background_type'];
        } else {
            $background_type = '1';
        }
        $uploaded = false;
        $isfile = false;
        $global_bg_image = array();
        $container = $registry->leadpops->clientInfo['rackspace_container'];
        if ($container) {
            $res = \DB::select("SELECT * FROM current_container_image_path WHERE current_container = '" . $container . "'");
            $containerInfo = objectToArray($res[0]);
            $image_path = $containerInfo['image_path'];
            $parsedUrl = parse_url($containerInfo['image_path']);
            if (substr($parsedUrl['path'], 1) != "") {
                $rackspace_path = substr($parsedUrl['path'], 1);
            }
        }
        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $vertical_id = $lpconstt[0];
            $subvertical_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $version_seq = $lpconstt[3];
            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);
            $leadpop_type_id = $lpres['leadpop_type_id'];
            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];

            $section = substr($client_id, 0, 1);
            if ($afiles['background_name']['name'] == '') {
                $img_exp = explode("/", $post['image-url']);
                $img_name = end($img_exp);
                $imagename = rtrim($img_name, '/');
                //$imagename = substr(end(explode("/",$post['image-url'])),0,-1);
            } else {
                $isfile = true;
                $file_name = $afiles['background_name']['name'];
                $newfile_name = preg_replace('/[^A-Za-z0-9-.]/', "", $file_name);
                $imagename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq . "_" . $newfile_name);
            }

            $imagepath = $section . '/' . $client_id . '/pics/' . $imagename;
            $imageurl = getCdnLink() . '/pics/' . $imagename;

            $post['gradient'] = "url(" . getCdnLink() . '/pics/' . $imagename . ")";
            $background_overlay = $post['background-overlay'];
            $active_overlay = $post['active-overlay'];
            if ($active_overlay == "n") {
                //$post['overlay_color_opacity']=0;
            }

            //to save in db to slip for admin
            $bgimageprop = $post['background_size'] . "~" . $post['background-position'] . "~" . $post['background-repeat'] . "~" . $post['overlay_color_opacity'];


            $bgimage_style = "style='background-image: " . $post['gradient'] . ";";
            $bgimage_style .= " background-size: " . $post['background_size'] . ";";
            $bgimage_style .= " background-position: " . $post['background-position'] . ";";
            $bgimage_style .= " background-repeat: " . $post['background-repeat'] . ";'";
            //$bgimage_style .=" opacity: ".$post['overlay_color_opacity'].";'";
            $background_overlay_opacity = $post['overlay_color_opacity'];

            $s = "update leadpop_background_color set active_backgroundimage = 'y', bgimage_url = '" . $imageurl . "', active_overlay = '" . $active_overlay . "', background_overlay = '" . $background_overlay . "', bgimage_style = '" . addslashes($bgimage_style) . "', bgimage_properties = '" . addslashes($bgimageprop) . "',background_overlay_opacity='$background_overlay_opacity',background_type = '" . $background_type . "'";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
            //$tarr[]=$s;
            $this->db->query($s);

            if ($uploaded) {
                if ($isfile)
                    $global_bg_image[] = array('server_file' => $image_path . $uploaded,
                        'container' => $container,
                        'rackspace_path' => $rackspace_path . $imagepath
                    );
            } else {
                if ($isfile) {
                    if (move_uploaded_file_to_rackspace($afiles["background_name"]["tmp_name"], $imagepath)) {
                        $uploaded = $imagepath;
                    }
                }
            }
        }
        //debug($tarr);
        $s = "select * from global_settings where client_id = " . $client_id;
        $client = $this->db->fetchRow($s);

        if (!$client) {
            $s = "insert into global_settings (id,client_id,bk_image_active,active_backgroundimage,bgimage_url,active_overlay,background_overlay,bgimage_style,bgimage_properties,background_overlay_opacity";
            $s .= ") values (null,";
            $s .= $client_id . ",'y','y','" . $imageurl . "','" . $active_overlay . "','" . $background_overlay . "','" . addslashes($bgimage_style) . "','" . addslashes($bgimageprop) . "','" . $post['overlay_color_opacity'] . "')";
            $this->db->query($s);
        } else {
            $s = "update global_settings set bk_image_active = 'y', active_backgroundimage = 'y', bgimage_url = '" . $imageurl . "', active_overlay = '" . $active_overlay . "', background_overlay = '" . $background_overlay . "', bgimage_style = '" . addslashes($bgimage_style) . "', bgimage_properties = '" . addslashes($bgimageprop) . "', background_overlay_opacity = '" . $post['overlay_color_opacity'] . "'";
            $s .= " where client_id = " . $client_id;
            $this->db->query($s);
        }

        if (env('GEARMAN_ENABLE') == "1") {
            if (isset($_COOKIE['debug_bg_image']) and $_COOKIE['debug_bg_image'] == 1) {
                print_r($global_bg_image);
                die;
            }
            if ($global_bg_image) {
                MyLeadsEvents::getInstance()->executeRackspaceCDNClient($global_bg_image);
            }
        }
        return 'ok';
    }

    public function updatebackgroundimage($client_id, $post, $afiles, $funnel_data = array())
    {
            $vertical_id = $funnel_data["leadpop_vertical_id"];
            $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
            $leadpop_type_id = $funnel_data['leadpop_type_id'];
            $leadpop_id = $funnel_data["leadpop_id"];
            $leadpop_template_id = $funnel_data['leadpop_template_id'];
            $leadpop_version_id = $funnel_data['leadpop_version_id'];
            $leadpop_version_seq = $funnel_data["leadpop_version_seq"];

        if ($post['background_type'] != "") {
            $background_type = $post['background_type'];
        } else {
            $background_type = '1';
        }

        $section = substr($client_id, 0, 1);

        if ($afiles['background_name']['name'] == '') {
            $img_exp = explode("/", $post['image-url']);
            $img_name = end($img_exp);
            $imagename = rtrim($img_name, '/');
        } else {
            $path_parts = pathinfo($afiles["background_name"]["name"]);
            $file_name = $afiles['background_name']['name'];
            $extension = $path_parts['extension'];
            $newfile_name = preg_replace('/[^A-Za-z0-9]/', "", $file_name);
            $newfile_name = $newfile_name . "." . $extension;
            $imagename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $leadpop_version_seq . "_" . $newfile_name);

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
        $overlay_opacity = isset($post['overlay_color_opacity']) ? $post['overlay_color_opacity'] : 0;

        $activeOverlay = empty($_POST['bgoverly']) ? 'n' : 'y';

        $s = "update leadpop_background_color set bgimage_url = '" . $imageurl . "', background_overlay = '" . $background_overlay . "', bgimage_style = '" . addslashes($bgimage_style) . "', bgimage_properties = '" . addslashes($bgimageprop) . "',background_type = '" . $background_type . "', background_overlay_opacity = '" . $overlay_opacity . "',active_backgroundimage='y', active_overlay='$activeOverlay'";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
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
                    ### $logosrc['id'] = $this->getDefaultLogoId($vertical_id, $subvertical_id, $leadpop_version_id);
                    $logosrc['id'] = $logos[$i]['id'];
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
        //blank image use for create new custom funnel
        if($logos['logo_src'] === 'blank.png'){
            $logosrc = $stocklogopath = rackspace_stock_assets() . 'images/'.$logos['logo_src'];
        }
        else {
            if ($subverticalName == "") {
                //$logosrc = $stocklogopath = rackspace_stock_assets() . 'images/' . strtolower(str_replace(" ", "", $verticalName)) . '/' . $logos['logo_src'];
            $logosrc = $stocklogopath = rackspace_stock_assets() . config('rackspace.rs_stock_logo_dir') . strtolower(str_replace(" ", "", $verticalName)) . '/' . $logos['logo_src'];
            } else {
                //$logosrc = $stocklogopath = rackspace_stock_assets() . 'images/' . strtolower(str_replace(" ", "", $verticalName)) . '/' . strtolower(str_replace(" ", "", $subverticalName)) . '_logos/' . $logos['logo_src'];
                $logosrc = $stocklogopath = rackspace_stock_assets() . config('rackspace.rs_stock_logo_dir') . strtolower(str_replace(" ", "", $verticalName)) . '/' . strtolower(str_replace(" ", "", $subverticalName)) . '_logos/' . $logos['logo_src'];
            }
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

    public function getLogoSources($funnel_data = array())
    {
        $registry = DataRegistry::getInstance();
        $client_id = $funnel_data["client_id"];
        $vertical_id = $funnel_data["leadpop_vertical_id"];
        $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
        $leadpop_id = $funnel_data["leadpop_id"];
        $leadpop_template_id = $funnel_data['leadpop_template_id'];
        $leadpop_version_id = $funnel_data['leadpop_version_id'];
        $leadpop_type_id = $funnel_data['leadpop_type_id'];
        $leadpop_version_seq = $funnel_data["leadpop_version_seq"];
        $verticalName = strtolower($funnel_data["lead_pop_vertical"]);
        $subverticalName = strtolower($funnel_data["lead_pop_vertical_sub"]);

        $s = "select * from leadpop_logos where client_id = " . $client_id;
//        $s .= " and leadpop_id = " . $leadpop_id;
//        $s .= " and leadpop_type_id = " . $leadpop_type_id;
//        $s .= " and leadpop_vertical_id = " . $vertical_id;
//        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
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
                    //blank image use for create new custom funnel
                    if($logos[$i]["logo_src"] === 'blank.png'){
                        $logo_src = rackspace_stock_assets() . 'images/'.$logos[$i]["logo_src"];
                    }
                    else {
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
                            $logo_src = getCdnLink() . '/logos/' . $logos[$i]['logo_src'];
                        }
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
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $s .= " ORDER BY leadpop_version_seq ASC";
        $trialDefaults = $this->db->fetchRow($s);


        if ($trialDefaults) {
            $defaultimagename = $trialDefaults['image_name'];
        } else {
            $defaultimagename = config('leadpops.default_feature_image_name');
        }


        $s = "select * from leadpop_images where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id  = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq . " LIMIT 1";
        $current_image = $this->db->fetchRow($s);


        if ($current_image['image_src'] == $defaultimagename || strpos($current_image['image_src'], $defaultimagename) !== false) {
            $is_default_image = true;
            $s = "SELECT * FROM current_container_image_path WHERE cdn_type = 'default-assets'";
            $defaultCdn = $this->db->fetchRow($s);
            $imagesrc = $defaultCdn['image_path'] . config('rackspace.rs_featured_image_dir') . $defaultimagename;

            $s = "update leadpop_images  set use_default = 'y',use_me = 'n' ";
        } else {
            $is_default_image = false;
            $imagesrc = getCdnLink() . '/pics/' . $current_image['image_src'];

            $s = "update leadpop_images  set use_default = 'n',use_me = 'y' ";
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


        if ($trialDefaults) {
            $imagename = $trialDefaults['image_name'];
        } else {
            $imagename = config('leadpops.default_feature_image_name');
        }


        $imagesrc = rackspace_stock_assets() . config('rackspace.rs_featured_image_dir') . $imagename;

        $scaling_properties = [
            'maxWidth' => config('leadpops.design.featureImage.maxAllowedWidthPx'),
            'scalePercentage' => config('leadpops.design.featureImage.sliderDefault')
        ];

        $s = "update leadpop_images  set use_default = 'y',use_me = 'n' , image_src = '" . $imagename . "' ";
        $s .= " , scaling_properties = '" . json_encode($scaling_properties) . "'";
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

        // setting empty image_src column value when image is deleted and didn't browse any image after delete
        if (isset($_POST['delete_image']) && $_POST['delete_image'] == 1 && (!isset($_FILES["logo"]) || $_FILES["logo"]["name"] == "")) {
            $s .= ", image_src = '' ";
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

    /**
     * @since 2.1.0 - CR-Funnel-Builder: Removed leadpops_templates_placeholders_values -> placeholder_sixtynine
     *
     */
    function savegloballogonew($data, $client_id)
    {
        $registry = DataRegistry::getInstance();
        extract($_POST, EXTR_OVERWRITE, "form_");

        $lplist = explode(",", $lpkey_logo);
        // $file = file_get_contents($image_url);
        $cur_logo_exp = explode("/", $image_url);
        $cur_logo_name = end($cur_logo_exp);
        $global_logo_trim = rtrim($cur_logo_name);
        $replaced = $client_id . "_global_";

        $logo = str_replace($replaced, "", $global_logo_trim);
        $section = substr($client_id, 0, 1);

        $glogo_path = $section . '/' . $client_id . '/logos/' . $replaced . $logo;

        $logo_color = $this->getLogoProminentColor($image_url);

        if (is_array($logo_color)) {
            $logo_color = end($logo_color);
        }

        //for MM specific Logo
        $s = "select is_mm from clients where client_id = " . $client_id . "";
        $is_mm = $this->db->fetchOne($s);

        if ($is_mm == 1 && $logo_color == "#272827") {
            $logo_color = "#A8000D";
        }


        //for FW specific Logo
        $s = "select is_fairway from clients where client_id = " . $client_id . "";
        $is_fairway = $this->db->fetchOne($s);

        if ($is_fairway == 1 && $logo_color == "#94D60A") {
            $logo_color = "#18563E";
        }

        $_globalswatches = $globalswatches;
        $swatch_result = explode("#", $_globalswatches);
        $new_color = $this->hex2rgb($logo_color);
        array_unshift($swatch_result, implode('-', $new_color));

        $image_location = rackspace_stock_assets() . "images/dot-img.png";
        $favicon_location = rackspace_stock_assets() . "images/favicon-circle.png";
        $mvp_dot_location = rackspace_stock_assets() . "images/ring.png";
        $mvp_check_location = rackspace_stock_assets() . "images/mvp-check.png";

        if (isset($logo_color) && $logo_color != "") {
            $new_clr = $this->hex2rgb($logo_color);
            $im = imagecreatefrompng($image_location);
            $myRed = $new_clr[0];
            $myGreen = $new_clr[1];
            $myBlue = $new_clr[2];
        }

        // OUT
        // SET BACKGROUND COLOR
        $background_from_logo = '/*###>*/background-color: rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1);/*@@@*/
        background-image: linear-gradient(to right bottom,rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1) 0%,rgba(' . $new_color[0] . ', ' . $new_color[1] . ', ' . $new_color[2] . ', 1) 100%); /* W3C */';


        $tarr = array();
        $lpkeysarr = array();
        $fun_leadpop_ids = array();
        $global_logo = array();
        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];
            $lpkeysarr[$leadpop_vertical_id . "~" . $leadpop_vertical_sub_id . '~' . $leadpop_id . '~' . $leadpop_version_seq]['maindata'] = $leadpop_vertical_id . "~" . $leadpop_vertical_sub_id . '~' . $leadpop_id . '~' . $leadpop_version_seq;
            $fun_leadpop_ids[$leadpop_id] = $leadpop_id;
        }
        //$fun_key=implode("','", $lpkeysarr);

        $leadpop_id = implode(",", $fun_leadpop_ids);
        $s = "select * from leadpops where id IN (" . $leadpop_id . " )";
        //$tarr['leadpopsselect']=$s;
        $lpres = $this->db->fetchAll($s);

        foreach ($lpkeysarr as $key => $value) {
            $lpconstt = explode("~", $key);
            $leadpop_id = $lpconstt[2];
            $lp_data = $this->searchForId($leadpop_id, $lpres);
            $lpkeysarr[$key]['extdata'] = $lp_data['leadpop_type_id'] . '~' . $lp_data['leadpop_template_id'] . '~' . $lp_data['leadpop_version_id'];
        }

        $leadpop_vertical_id_arr = array();
        $leadpop_vertical_sub_id_arr = array();
        $leadpop_id_arr = array();
        $leadpop_version_seq_arr = array();
        $leadpop_type_id_arr = array();
        $leadpop_template_id_arr = array();
        $leadpop_version_id_arr = array();
        $composite_key = array();
        $logo_short_key = array();
        $ph_short_key = array();

        foreach ($lpkeysarr as $fd) {
            $lpconstt = explode("~", $fd["maindata"]);
            $leadpop_vertical_id = (int)$lpconstt[0];
            $leadpop_vertical_id_arr[] = (int)$lpconstt[0];
            $leadpop_vertical_sub_id = (int)$lpconstt[1];
            $leadpop_vertical_sub_id_arr[] = (int)$lpconstt[1];
            $leadpop_id = (int)$lpconstt[2];
            $leadpop_id_arr[] = (int)$lpconstt[2];
            $leadpop_version_seq = (int)$lpconstt[3];
            $leadpop_version_seq_arr[] = (int)$lpconstt[3];

            $lpres = explode("~", $fd["extdata"]);
            $leadpop_type_id = (int)$lpres[0];
            $leadpop_type_id_arr[] = (int)$lpres[0];
            $leadpop_template_id = (int)$lpres[1];
            $leadpop_template_id_arr[] = (int)$lpres[1];
            $leadpop_version_id = (int)$lpres[2];
            $leadpop_version_id_arr[] = (int)$lpres[2];
            $composite_key[] = $leadpop_version_seq . "~" . $leadpop_version_id;
            $logo_short_key[] = $leadpop_vertical_id . "~" . $leadpop_vertical_sub_id . "~" . $leadpop_version_id;
            $ph_short_key[] = $leadpop_template_id . "~" . $client_id . "~" . $leadpop_version_seq;
        }

        $leadpop_vertical_id_str = "'" . implode("','", $leadpop_vertical_id_arr) . "'";
        $leadpop_vertical_sub_id_str = "'" . implode("','", $leadpop_vertical_sub_id_arr) . "'";
        $leadpop_id_str = "'" . implode("','", $leadpop_id_arr) . "'";
        $leadpop_version_seq_str = "'" . implode("','", $leadpop_version_seq_arr) . "'";
        $leadpop_type_id_str = "'" . implode("','", $leadpop_type_id_arr) . "'";
        $leadpop_template_id_str = "'" . implode("','", $leadpop_template_id_arr) . "'";
        $leadpop_version_id_str = "'" . implode("','", $leadpop_version_id_arr) . "'";
        $composite_key_str = "'" . implode("','", $composite_key) . "'";
        $logo_short_key_str = "'" . implode("','", $logo_short_key) . "'";
        $ph_short_key_str = "'" . implode("','", $ph_short_key) . "'";
        //var_dump($ph_short_key_str);


        // common data as associative array
        $def_lpadm_obj = new LpAdminRepository($this->db);
        if (empty($def_lpadm_obj->_vertical)) {
            $def_lpadm_obj->setCommonDataForGlobalChanges();
        }
        $stock_logo = array();

        if ($useme_logo == 'y' && $usedefault_logo == 'n') {

            $s = "select id, numpics, logo_src from leadpop_logos ";
            $s .= " where client_id = " . $client_id . " and use_me = 'y'";
            $s .= " and CONCAT(leadpop_vertical_id,'~',leadpop_vertical_sub_id,'~',leadpop_id,'~',leadpop_version_seq,'~',leadpop_type_id,'~',leadpop_template_id,'~',leadpop_version_id) IN ( " . $composite_key_str . " ) ";
            //$tarr['respics_data']=$s;
            $respics_data = $this->db->fetchAll($s);

            $logo_del_ids = array();
            if ($respics_data) {
                foreach ($respics_data as $respics) {
                    $logo_del_ids[] = $respics['id'];
                }
            } else {
                $s = "select id,count(logo_src) as cnt from leadpop_logos ";
                $s .= " where client_id = " . $client_id;
                $s .= " and CONCAT(leadpop_vertical_id,'~',leadpop_vertical_sub_id,'~',leadpop_id,'~',leadpop_version_seq,'~',leadpop_type_id,'~',leadpop_template_id,'~',leadpop_version_id) IN ( " . $composite_key_str . " ) ";
                $s .= " AND logo_src NOT LIKE '%default/images/%' AND logo_src NOT LIKE '%itclix.com/images/%'";
                $s .= " group by leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_id,leadpop_version_seq,leadpop_type_id,leadpop_template_id,leadpop_version_id ";
                $s .= " HAVING cnt > 2 ";
                $logocountd = $this->db->fetchAll($s);

                if ($logocountd) {
                    foreach ($logocountd as $ldata) {
                        $logo_del_ids[] = $ldata['id'];
                    }
                }
            }

            if (!empty($logo_del_ids)) {
                $logo_del_ids_str = implode(",", $logo_del_ids);
                $s = "delete from leadpop_logos where client_id = " . $client_id . " and id IN ( " . $logo_del_ids_str . " );";
                //$tarr['leadpop_logos_del_query']=$s;
                //debug($s, ' >> ', 0);
                $this->db->query($s);
            }

            $s = "update leadpop_logos  set use_default = 'n',use_me = 'n' ";
            $s .= " where client_id = " . $client_id;
            $s .= " and CONCAT(leadpop_vertical_id,'~',leadpop_vertical_sub_id,'~',leadpop_id,'~',leadpop_version_seq,'~',leadpop_type_id,'~',leadpop_template_id,'~',leadpop_version_id) IN ( " . $composite_key_str . " ) ";
            //$tarr['leadpop_logos_update_query']=$s;
            //debug($s, ' >> ', 0);
            $this->db->query($s);
        } else if ($useme_logo == 'n' && $usedefault_logo == 'y') {
            // OUT
            $s = "select leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_version_id,logo_src,default_logo_color,default_logo_swatches ";
            $s .= " from stock_leadpop_logos  where ";
            $s .= " CONCAT(leadpop_vertical_id,'~',leadpop_vertical_sub_id,'~',leadpop_version_id) IN ( " . $logo_short_key_str . " ) ";
            //$tarr['stock_leadpop_logos']=$s;
            //var_dump($s);
            $logos = $this->db->fetchAll($s);
            foreach ($logos as $slogo) {
                $stock_logo[$slogo["leadpop_vertical_id"] . "~" . $slogo["leadpop_vertical_sub_id"] . "~" . $slogo["leadpop_version_id"]]['logo'] = $slogo["logo_src"];
                $stock_logo[$slogo["leadpop_vertical_id"] . "~" . $slogo["leadpop_vertical_sub_id"] . "~" . $slogo["leadpop_version_id"]]['logocolor'] = $slogo["default_logo_color"];
                if (isset($stock_logo[$slogo["leadpop_vertical_id"] . "~" . $slogo["leadpop_vertical_sub_id"] . "~" . $slogo["leadpop_version_id"]]['logocolor']) && $stock_logo[$slogo["leadpop_vertical_id"] . "~" . $slogo["leadpop_vertical_sub_id"] . "~" . $slogo["leadpop_version_id"]]['logocolor'] != "") {
                    $new_clr = $this->hex2rgb($stock_logo[$slogo["leadpop_vertical_id"] . "~" . $slogo["leadpop_vertical_sub_id"] . "~" . $slogo["leadpop_version_id"]]['logocolor']);
                    $drgb = $new_clr[0] . "--" . $new_clr[1] . "--" . $new_clr[2];
                    $stock_logo[$slogo["leadpop_vertical_id"] . "~" . $slogo["leadpop_vertical_sub_id"] . "~" . $slogo["leadpop_version_id"]]['rgb'] = $drgb;
                }
                $stock_logo[$slogo["leadpop_vertical_id"] . "~" . $slogo["leadpop_vertical_sub_id"] . "~" . $slogo["leadpop_version_id"]]['defaultswatches'] = $slogo["default_logo_swatches"];
            }

            $s = "update leadpop_logos set use_default = 'y', use_me = 'n' , default_colored = 'n' ";
            $s .= " where client_id = " . $client_id;
            $s .= " and CONCAT(leadpop_vertical_id,'~',leadpop_vertical_sub_id,'~',leadpop_id,'~',leadpop_version_seq,'~',leadpop_type_id,'~',leadpop_template_id,'~',leadpop_version_id) IN ( " . $composite_key_str . " ) ";
            //$tarr['stock_leadpop_leadpop_logos']=$s;
            //var_dump($s);
            $this->db->query($s);
        }
        //use for local
        if (env('APP_ENV') === config('app.env_local')) {
            $leadpop_background_swatches = 'leadpop_background_swatches';
        } else {
            $leadpop_background_swatches = getPartition($client_id, "leadpop_background_swatches");
        }
        $s = "delete from " . $leadpop_background_swatches;
        $s .= " where client_id = " . $client_id;
        $s .= " and CONCAT(leadpop_vertical_id,'~',leadpop_vertical_sub_id,'~',leadpop_id,'~',leadpop_version_seq,'~',leadpop_type_id,'~',leadpop_template_id,'~',leadpop_version_id) IN ( " . $composite_key_str . " ) ";
        //$tarr['leadpop_background_swatches_delquery']=$s;
        $this->db->query($s);

        $_lp_bk_clr_count = [];
        $s = " select * from leadpop_background_color ";
        $s .= " where client_id = " . $client_id;
        $s .= " and CONCAT(leadpop_version_seq,'~',leadpop_version_id) IN ( " . $composite_key_str . " ) ";
        $_lpbkcolor = $this->db->fetchAll($s);
        foreach ($_lpbkcolor as $d) {
            $background_type[$d['leadpop_vertical_id'] . '~' . $d['leadpop_vertical_sub_id'] . '~' . $d['leadpop_id'] . '~' . $d['leadpop_version_seq'] . '~' . $d['leadpop_type_id'] . '~' . $d['leadpop_template_id'] . '~' . $d['leadpop_version_id']] = $d['background_type'];
            $_lp_bk_clr_count[$d['leadpop_vertical_id'] . '~' . $d['leadpop_vertical_sub_id'] . '~' . $d['leadpop_id'] . '~' . $d['leadpop_version_seq'] . '~' . $d['leadpop_type_id'] . '~' . $d['leadpop_template_id'] . '~' . $d['leadpop_version_id']] = 1;
        }

        $leadpop_logos_inset_str_flag = true;
        $leadpop_logos_inset_str = " insert into leadpop_logos (id,client_id,leadpop_id,leadpop_type_id,";
        $leadpop_logos_inset_str .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
        $leadpop_logos_inset_str .= "leadpop_version_id,leadpop_version_seq,use_default,";
        $leadpop_logos_inset_str .= "logo_src,use_me,numpics,logo_color,ini_logo_color,swatches,last_update) values";
        $update_current_logo_str = [];
        $update_leadpops_templates_placeholders_values_str = [];
        $update_leadpops_bk_color_str = [];
        $delete_leadpops_bk_color_str = [];
        $leadpop_background_color_inset_str = " insert into leadpop_background_color (id,client_id,leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,leadpop_id,leadpop_version_id,leadpop_version_seq,background_color,active,default_changed,bgimage_url,background_overlay,bgimage_properties,bgimage_style) values ";
        $leadpop_background_swatches_inset_str = " insert into leadpop_background_swatches (id,client_id,leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,leadpop_id,leadpop_version_id,leadpop_version_seq,swatch,is_primary,active) values ";

        $lpkeyi = 0;
        $lpkeylen = count($lpkeysarr);
        $favicon_dst_src = $colored_dot_src = $mvp_dot_src = $mvp_check_src = "";
        $image_location_img = $favicon_location_img = $mvp_dot_location_img = $mvp_check_location_img = "";
        $container = $registry->leadpops->clientInfo['rackspace_container'];
        if ($container) {
            $res = \DB::select("SELECT * FROM current_container_image_path WHERE current_container = '" . $container . "'");
            $containerInfo = objectToArray($res[0]);
            $parsedUrl = parse_url($containerInfo['image_path']);
            if (substr($parsedUrl['path'], 1) != "") {
                $rackspace_path = substr($parsedUrl['path'], 1);
            }
        }
        foreach ($lpkeysarr as $fd) {
            $lpconstt = explode("~", $fd["maindata"]);
            $leadpop_vertical_id = (int)$lpconstt[0];
            $leadpop_vertical_id_arr[] = (int)$lpconstt[0];
            $leadpop_vertical_sub_id = (int)$lpconstt[1];
            $leadpop_vertical_sub_id_arr = (int)$lpconstt[1];
            $leadpop_id = (int)$lpconstt[2];
            $leadpop_id_arr = (int)$lpconstt[2];
            $leadpop_version_seq = (int)$lpconstt[3];
            $leadpop_version_seq_arr = (int)$lpconstt[3];

            $lpres = explode("~", $fd["extdata"]);
            $leadpop_type_id = (int)$lpres[0];
            $leadpop_type_id_arr = (int)$lpres[0];
            $leadpop_template_id = (int)$lpres[1];
            $leadpop_template_id_arr = (int)$lpres[1];
            $leadpop_version_id = (int)$lpres[2];
            $leadpop_version_id_arr = (int)$lpres[2];

            $filename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $leadpop_vertical_id . "_" . $leadpop_vertical_sub_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $leadpop_version_seq);
            if ($useme_logo == 'y' && $usedefault_logo == 'n') {

                $logoname = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $leadpop_vertical_id . "_" . $leadpop_vertical_sub_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $leadpop_version_seq . "_" . $logo);
                $logosrc = getCdnLink() . '/logos/' . $logoname;

                //$section = substr($client_id,0,1);
                $newlogopath = $section . '/' . $client_id . '/logos/' . $logoname;
                $global_logo[] = array('server_file' => public_path() . '/' . $temp_logo,
                    'container' => $container,
                    'rackspace_path' => $rackspace_path . $newlogopath
                );

                $numpics = 0;

                /* update the logo in question */
                $this->updateFunnelVar(FunnelVariables::LOGO_SRC, $logosrc, $client_id, $leadpop_id, $leadpop_version_seq);
                $update_current_logo_str[] = "update current_logo  SET logo_src='" . $logoname . "' WHERE client_id=" . $client_id . " and leadpop_vertical_id = " . $leadpop_vertical_id . " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id . " and leadpop_type_id = " . $leadpop_type_id . " and leadpop_template_id = " . $leadpop_template_id . " and leadpop_id = " . $leadpop_id . " and leadpop_version_id = " . $leadpop_version_id . " and leadpop_version_seq = " . $leadpop_version_seq . "; ";

                if ($lpkeyi == 0) {
                    $leadpop_logos_inset_str .= " (null,";
                    $leadpop_logos_inset_str .= $client_id . "," . $leadpop_id . "," . $leadpop_type_id . "," . $leadpop_vertical_id . "," . $leadpop_vertical_sub_id . ",";
                    $leadpop_logos_inset_str .= $leadpop_template_id . "," . $leadpop_version_id . "," . $leadpop_version_seq . ",";
                    $leadpop_logos_inset_str .= "'n','" . $logoname . "','y'," . $numpics . ", '" . $logo_color . "','" . $logo_color . "','" . $globalswatches . "'," . time() . ")";
                    if ($lpkeylen > 1) $leadpop_logos_inset_str .= ",";
                    else $leadpop_logos_inset_str .= ";";

                } else if ($lpkeyi == $lpkeylen - 1) {
                    // last
                    $leadpop_logos_inset_str .= " (null,";
                    $leadpop_logos_inset_str .= $client_id . "," . $leadpop_id . "," . $leadpop_type_id . "," . $leadpop_vertical_id . "," . $leadpop_vertical_sub_id . ",";
                    $leadpop_logos_inset_str .= $leadpop_template_id . "," . $leadpop_version_id . "," . $leadpop_version_seq . ",";
                    $leadpop_logos_inset_str .= "'n','" . $logoname . "','y'," . $numpics . ", '" . $logo_color . "','" . $logo_color . "','" . $globalswatches . "'," . time() . "); ";
                } else {
                    $leadpop_logos_inset_str .= " (null,";
                    $leadpop_logos_inset_str .= $client_id . "," . $leadpop_id . "," . $leadpop_type_id . "," . $leadpop_vertical_id . "," . $leadpop_vertical_sub_id . ",";
                    $leadpop_logos_inset_str .= $leadpop_template_id . "," . $leadpop_version_id . "," . $leadpop_version_seq . ",";
                    $leadpop_logos_inset_str .= "'n','" . $logoname . "','y'," . $numpics . ", '" . $logo_color . "','" . $logo_color . "','" . $globalswatches . "'," . time() . "),";
                }
                if ($favicon_dst_src == "") {

                    $favicon_dst_src = $section . '/' . $client_id . '/logos/' . $filename . '_favicon-circle.png';
                    $colored_dot_src = $section . '/' . $client_id . '/logos/' . $filename . '_dot_img.png';
                    $mvp_dot_src = $section . '/' . $client_id . '/logos/' . $filename . '_ring.png';
                    $mvp_check_src = $section . '/' . $client_id . '/logos/' . $filename . '_mvp-check.png';

                    $image_location_img = $this->colorizeBasedOnAplhaChannnel($image_location, $myRed, $myGreen, $myBlue, $colored_dot_src, true);
                    $favicon_location_img = $this->colorizeBasedOnAplhaChannnel($favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src, true);
                    $mvp_dot_location_img = $this->colorizeBasedOnAplhaChannnel($mvp_dot_location, $myRed, $myGreen, $myBlue, $mvp_dot_src, true);
                    $mvp_check_location_img = $this->colorizeBasedOnAplhaChannnel($mvp_check_location, $myRed, $myGreen, $myBlue, $mvp_check_src, true);
                    $global_logo[] = array('server_file' => public_path() . '/' . $favicon_location_img,
                        'container' => $container,
                        'rackspace_path' => $rackspace_path . $favicon_dst_src
                    );
                    $global_logo[] = array('server_file' => public_path() . '/' . $image_location_img,
                        'container' => $container,
                        'rackspace_path' => $rackspace_path . $colored_dot_src
                    );
                    $global_logo[] = array('server_file' => public_path() . '/' . $mvp_dot_location_img,
                        'container' => $container,
                        'rackspace_path' => $rackspace_path . $mvp_dot_src
                    );
                    $global_logo[] = array('server_file' => public_path() . '/' . $mvp_check_location_img,
                        'container' => $container,
                        'rackspace_path' => $rackspace_path . $mvp_check_src
                    );

                } else {
                    $favicon_dst_src = $section . '/' . $client_id . '/logos/' . $filename . '_favicon-circle.png';
                    $colored_dot_src = $section . '/' . $client_id . '/logos/' . $filename . '_dot_img.png';
                    $mvp_dot_src = $section . '/' . $client_id . '/logos/' . $filename . '_ring.png';
                    $mvp_check_src = $section . '/' . $client_id . '/logos/' . $filename . '_mvp-check.png';
//                    $this->colorizeBasedOnAplhaChannelCopy($image_location_img, $colored_dot_src);
//                    $this->colorizeBasedOnAplhaChannelCopy($favicon_location_img, $favicon_dst_src);
//                    $this->colorizeBasedOnAplhaChannelCopy($mvp_dot_location_img, $mvp_dot_src);
//                    $this->colorizeBasedOnAplhaChannelCopy($mvp_check_location_img, $mvp_check_src);
                    $global_logo[] = array('server_file' => public_path() . '/' . $favicon_location_img,
                        'container' => $container,
                        'rackspace_path' => $rackspace_path . $favicon_dst_src
                    );
                    $global_logo[] = array('server_file' => public_path() . '/' . $image_location_img,
                        'container' => $container,
                        'rackspace_path' => $rackspace_path . $colored_dot_src
                    );
                    $global_logo[] = array('server_file' => public_path() . '/' . $mvp_dot_location_img,
                        'container' => $container,
                        'rackspace_path' => $rackspace_path . $mvp_dot_src
                    );
                    $global_logo[] = array('server_file' => public_path() . '/' . $mvp_check_location_img,
                        'container' => $container,
                        'rackspace_path' => $rackspace_path . $mvp_check_src
                    );
                }
            } else if ($useme_logo == 'n' && $usedefault_logo == 'y') {
                $leadpop_logos_inset_str_flag = false;

                $verticalName = $def_lpadm_obj->_vertical[$leadpop_vertical_id];

                $subverticalName = $def_lpadm_obj->_sub_verical[$leadpop_vertical_sub_id];

                $stocklogopath = $this->getHttpServer() . '/images/' . strtolower(str_replace(" ", "", $verticalName)) . '/' . $stock_logo[$leadpop_vertical_id . "~" . $leadpop_vertical_sub_id . "~" . $leadpop_version_id]["logo"];

                if ($subverticalName == "") {
                    $logosrc = $this->getHttpServer() . '/images/' . $verticalName . '/' . $stock_logo[$leadpop_vertical_id . "~" . $leadpop_vertical_sub_id . "~" . $leadpop_version_id]["logo"];
                } else {
                    $subverticalName = str_replace(' ', '', $subverticalName);
                    $logosrc = $this->getHttpServer() . '/images/' . $verticalName . '/' . $subverticalName . '_logos/' . $stock_logo[$leadpop_vertical_id . "~" . $leadpop_vertical_sub_id . "~" . $leadpop_version_id]["logo"];
                }

                $defaultlogoname = $stock_logo[$leadpop_vertical_id . "~" . $leadpop_vertical_sub_id . "~" . $leadpop_version_id]["logo"];

                $logo_color = $stock_logo[$leadpop_vertical_id . "~" . $leadpop_vertical_sub_id . "~" . $leadpop_version_id]["logocolor"];

                if ($favicon_dst_src == "") {

                    $favicon_dst_src = $section . '/' . $client_id . '/logos/' . $filename . '_favicon-circle.png';
                    $colored_dot_src = $section . '/' . $client_id . '/logos/' . $filename . '_dot_img.png';
                    $mvp_dot_src = $section . '/' . $client_id . '/logos/' . $filename . '_ring.png';
                    $mvp_check_src = $section . '/' . $client_id . '/logos/' . $filename . '_mvp-check.png';
                }

                $logo_color_rgb = $stock_logo[$leadpop_vertical_id . "~" . $leadpop_vertical_sub_id . "~" . $leadpop_version_id]["rgb"];
                $stock_default_rgb = explode("--", $logo_color_rgb);
                $myRed = $stock_default_rgb[0];
                $myGreen = $stock_default_rgb[1];
                $myBlue = $stock_default_rgb[2];
                //comment from MZAC90
//                if (!isset($stock_logo[$slogo["leadpop_vertical_id"] . "~" . $slogo["leadpop_vertical_sub_id"] . "~" . $slogo["leadpop_version_id"]]['rgb'][$logo_color_rgb])) {
//                    $stock_logo[$slogo["leadpop_vertical_id"] . "~" . $slogo["leadpop_vertical_sub_id"] . "~" . $slogo["leadpop_version_id"]]['rgb'][$logo_color_rgb] = $logo_color_rgb;
//                    $this->colorizeBasedOnAplhaChannnel($image_location, $myRed, $myGreen, $myBlue, $colored_dot_src);
//                    $this->colorizeBasedOnAplhaChannnel($favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src);
//                    $this->colorizeBasedOnAplhaChannnel($mvp_dot_location, $myRed, $myGreen, $myBlue, $mvp_dot_src);
//                    $this->colorizeBasedOnAplhaChannnel($mvp_check_location, $myRed, $myGreen, $myBlue, $mvp_check_src);
//                }

                /* update the logo in question */
                $this->updateFunnelVar(FunnelVariables::LOGO_SRC, $defaultlogoname, $client_id, $leadpop_id, $leadpop_version_seq);
                $update_current_logo_str[] = "update current_logo SET logo_src='" . $defaultlogoname . "' WHERE client_id=" . $client_id . " and leadpop_vertical_id = " . $leadpop_vertical_id . " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id . " and leadpop_type_id = " . $leadpop_type_id . " and leadpop_template_id = " . $leadpop_template_id . " and leadpop_id = " . $leadpop_id . " and leadpop_version_id = " . $leadpop_version_id . " and leadpop_version_seq = " . $leadpop_version_seq . "; ";
                $swatch_result = explode("#", $stock_logo[$leadpop_vertical_id . "~" . $leadpop_vertical_sub_id . "~" . $leadpop_version_id]["defaultswatches"]);
                $new_color = $this->hex2rgb($logo_color);
                array_unshift($swatch_result, implode('-', $new_color));
                //$tarr["stocklogoswatches"][]=$swatch_result;

            }

            //Updating logo in thankyou page
            $this->updateThankYouPageLogo($logosrc, [
                "client_id" => $client_id,
                "leadpop_id" => $leadpop_id,
                "leadpop_type_id" => $leadpop_type_id,
                "leadpop_vertical_id" => $leadpop_vertical_id,
                "leadpop_vertical_sub_id" => $leadpop_vertical_sub_id,
                "leadpop_template_id" => $leadpop_template_id,
                "leadpop_version_id" => $leadpop_version_id,
                "leadpop_version_seq" => $leadpop_version_seq
            ]);

            // IN
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
            $this->updateFunnelVariables($design_variables, $client_id, $leadpop_id, $leadpop_version_seq);

            $sixnine = $this->getLeadLine($client_id, $leadpop_id, $leadpop_version_seq, FunnelVariables::LEAD_LINE);
            if ($sixnine != "") {
                $sixnine = $this->getReplacedColorHtml($sixnine, $logo_color);
                $this->updateLeadLine(FunnelVariables::LEAD_LINE, $sixnine, $client_id, $leadpop_id, $leadpop_version_seq);
            }


            $leadpop_vertical_id = (int)$lpconstt[0];
            $leadpop_vertical_id_arr[] = (int)$lpconstt[0];
            $leadpop_vertical_sub_id = (int)$lpconstt[1];
            $leadpop_vertical_sub_id_arr = (int)$lpconstt[1];
            $leadpop_id = (int)$lpconstt[2];
            $leadpop_id_arr = (int)$lpconstt[2];
            $leadpop_version_seq = (int)$lpconstt[3];
            $leadpop_version_seq_arr = (int)$lpconstt[3];

            $lpres = explode("~", $fd["extdata"]);
            $leadpop_type_id = (int)$lpres[0];
            $leadpop_type_id_arr = (int)$lpres[0];
            $leadpop_template_id = (int)$lpres[1];
            $leadpop_template_id_arr = (int)$lpres[1];
            $leadpop_version_id = (int)$lpres[2];
            $leadpop_version_id_arr = (int)$lpres[2];

            $iscount = 0;
            $isdeleteinsert = "yes";
            if (isset($_lp_bk_clr_count[$leadpop_vertical_id . '~' . $leadpop_vertical_sub_id . '~' . $leadpop_id . '~' . $leadpop_version_seq . '~' . $leadpop_type_id . '~' . $leadpop_template_id . '~' . $leadpop_version_id]) && $_lp_bk_clr_count[$leadpop_vertical_id . '~' . $leadpop_vertical_sub_id . '~' . $leadpop_id . '~' . $leadpop_version_seq . '~' . $leadpop_type_id . '~' . $leadpop_template_id . '~' . $leadpop_version_id] == 1) {
                $iscount = 1;
                $isdeleteinsert = "no";
            }
            if ($iscount == 1) {
                $bg_type = $background_type[$leadpop_vertical_id . '~' . $leadpop_vertical_sub_id . '~' . $leadpop_id . '~' . $leadpop_version_seq . '~' . $leadpop_type_id . '~' . $leadpop_template_id . '~' . $leadpop_version_id];
                $update_leadpops_bk_color_str[] = "update leadpop_background_color set background_color = '" . addslashes($background_from_logo) . "' ,background_type = " . $bg_type . " WHERE client_id=" . $client_id . " and leadpop_version_id = " . $leadpop_version_id . " and leadpop_version_seq = " . $leadpop_version_seq . "; ";
            }
            if ($isdeleteinsert == "yes") {
                $delete_leadpops_bk_color_str[] = "delete from leadpop_background_color  WHERE client_id=" . $client_id . " and leadpop_vertical_id = " . $leadpop_vertical_id . " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id . " and leadpop_type_id = " . $leadpop_type_id . " and leadpop_template_id = " . $leadpop_template_id . " and leadpop_id = " . $leadpop_id . " and leadpop_version_id = " . $leadpop_version_id . " and leadpop_version_seq = " . $leadpop_version_seq . "; ";
            }
            //@mzac90 no need it, i have handle rtrim function
//            if ($lpkeyi == $lpkeylen - 1) { // last
//                if ($isdeleteinsert == "yes") {
//                    $leadpop_background_color_inset_str .= " (null," . $client_id . "," . $leadpop_vertical_id . "," . $leadpop_vertical_sub_id . "," . $leadpop_type_id . "," . $leadpop_template_id . "," . $leadpop_id . "," . $leadpop_version_id . "," . $leadpop_version_seq . ",'" . addslashes($background_from_logo) . "','y','y','','','','');";
//                }
//            }
//            else {
//            }
            if ($isdeleteinsert == "yes") {
                $leadpop_background_color_inset_str .= " (null," . $client_id . "," . $leadpop_vertical_id . "," . $leadpop_vertical_sub_id . "," . $leadpop_type_id . "," . $leadpop_template_id . "," . $leadpop_id . "," . $leadpop_version_id . "," . $leadpop_version_seq . ",'" . addslashes($background_from_logo) . "','y','y','','','',''),";
            }
            $swindex = 0;
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

                $_globalswatches = array($str0, $str1, $str2, $str3);
                $globalsettingswatches[$key] = $_globalswatches;

                for ($i = 0; $i < 4; $i++) {
                    $swindex++;
                    $is_primary = 'n';
                    if ($swindex == 1) {
                        $is_primary = 'y';
                    }

                    $leadpop_background_swatches_inset_str .= "(null," . $client_id . "," . $leadpop_vertical_id . "," . $leadpop_vertical_sub_id . "," . $leadpop_type_id . "," . $leadpop_template_id . "," . $leadpop_id . "," . $leadpop_version_id . "," . $leadpop_version_seq . ",'" . addslashes($_globalswatches[$i]) . "','" . $is_primary . "','y'),";
                }
            }
            $lpkeyi++;
        }

        $leadpop_background_swatches_inset_str = substr($leadpop_background_swatches_inset_str, 0, -1);

        if ($leadpop_logos_inset_str_flag == true) $this->db->query($leadpop_logos_inset_str);
        foreach ($update_current_logo_str as $s) {
            $this->db->query($s);
        }

        foreach ($update_leadpops_templates_placeholders_values_str as $s) {
            $this->db->query($s);
        }
        if (!empty($update_leadpops_bk_color_str)) {
            foreach ($update_leadpops_bk_color_str as $updatebkclrquery) {
                $this->db->query($updatebkclrquery);
            }
        }
        if (!empty($delete_leadpops_bk_color_str)) {
            foreach ($delete_leadpops_bk_color_str as $delbkclrque) {
                $this->db->query($delbkclrque);
            }
        }
        $leadpop_background_color_inset_str1 = " insert into leadpop_background_color (id,client_id,leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_type_id,leadpop_template_id,leadpop_id,leadpop_version_id,leadpop_version_seq,background_color,active,default_changed,bgimage_url,background_overlay,bgimage_properties,bgimage_style) values ";
        if ($leadpop_background_color_inset_str != $leadpop_background_color_inset_str1) {
            $leadpop_background_color_inset_str = rtrim($leadpop_background_color_inset_str, ',') . ';';
            $this->db->query($leadpop_background_color_inset_str);
        }
        $this->db->query($leadpop_background_swatches_inset_str);

        $s = "select * from global_settings where client_id = " . $client_id;
        $client = $this->db->fetchRow($s);
        $swatch_arr = array();
        //old code for save swatches in the global setting
//        for ($j = 0; $j < count($_globalswatches); $j++) {
//            $swatch_arr[$j] = addslashes($_globalswatches[$j]);
//        }

        // New code for save 28 swatches in the global setting @mzac90
        foreach ($globalsettingswatches as $k => $val) {
            foreach ($val as $s => $v) {
                $swatch_arr[] = $v;
            }
        }
        $swatchs = json_encode($swatch_arr);
        if (!$client) {
            $s = "insert into global_settings (client_id,logo,";
            $s .= "logo_url,logo_path,logo_color,swatches) values (";
            $s .= $client_id . ",'" . $logo . "','" . $image_url . "','" . $glogo_path . "','" . $logo_color . "','" . $swatchs . "') ";
            $this->db->query($s);
        } else {
            $s = "update global_settings set logo = '" . $logo . "',logo_url = '" . $image_url . "',logo_path = '" . $glogo_path . "',logo_color = '" . $logo_color . "',swatches='" . $swatchs . "'";
            $s .= " where client_id = " . $client_id;
            $this->db->query($s);
        }
        if (getenv('GEARMAN_ENABLE') == "1") {
            if (isset($_COOKIE['debug_global_logo']) and $_COOKIE['debug_global_logo'] == 1) {
                print_r($global_logo);
                die;
            }
            if ($global_logo) {
                MyLeadsEvents::getInstance()->executeRackspaceCDNClient($global_logo);
            }
        }

        return "ok";

    }

    public function savegloballogo($data, $client_id)
    {
        $this->savegloballogonew($data, $client_id);
        return "ok";
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

        $s = "select * from global_settings where client_id = " . $client_id;
        $client = $this->db->fetchRow($s);

        if (!$client) {
            $s = "insert into global_settings (id,client_id,logo,";
            $s .= "logo_url,logo_path) values (null,";
            $s .= $client_id . ",'" . $logo . "','" . $image_url . "','" . $glogo_path . "') ";
            $this->db->query($s);
        } else {
            $s = "update global_settings set logo = '" . $logo . "',logo_url = '" . $image_url . "',logo_path = '" . $glogo_path . "'";
            $s .= " where client_id = " . $client_id;
            $this->db->query($s);
        }

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

       $scaling_defaultHeightPercentage = $adata["scaling_defaultHeightPercentage"];
       $scaling_maxHeightPx = $adata["scaling_maxHeightPx"];
       $current_logo_height = $adata["current_logo_height"];
       $scaling_properties = json_encode(['maxHeight' => $scaling_maxHeightPx, 'scalePercentage' => $scaling_defaultHeightPercentage,'current_logo_height' => $current_logo_height]);

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
//          $s .= " and leadpop_id = " . $leadpop_id;
//          $s .= " and leadpop_type_id = " . $leadpop_type_id;
//          $s .= " and leadpop_vertical_id = " . $vertical_id;
//          $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//          $s .= " and leadpop_template_id = " . $leadpop_template_id;
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
//            $s .= " and leadpop_id = " . $leadpop_id;
//            $s .= " and leadpop_type_id = " . $leadpop_type_id;
//            $s .= " and leadpop_vertical_id = " . $vertical_id;
//            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq != " . $version_seq;
            $this->db->query($s);

            $s = "select * from leadpop_logos   ";
            $s .= " where client_id = " . $client_id;
//            $s .= " and leadpop_id = " . $leadpop_id;
//            $s .= " and leadpop_type_id = " . $leadpop_type_id;
//            $s .= " and leadpop_vertical_id = " . $vertical_id;
//            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//            $s .= " and leadpop_template_id = " . $leadpop_template_id;
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
//            $s .= " where client_id = " . $client_id;
//            $s .= " and leadpop_id = " . $leadpop_id;
//            $s .= " and leadpop_type_id = " . $leadpop_type_id;
//            $s .= " and leadpop_vertical_id = " . $vertical_id;
//            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//            $s .= " and leadpop_template_id = " . $leadpop_template_id;
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
//                $s .= " and leadpop_id = " . $leadpop_id;
//                $s .= " and leadpop_type_id = " . $leadpop_type_id;
//                $s .= " and leadpop_vertical_id = " . $vertical_id;
//                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query($s);

                $s = "update leadpop_logos  set use_me = 'y', swatches = '" . $adata['swatches'] . "', scaling_properties = '" . $scaling_properties . "' ";
                $s .= " where client_id = " . $client_id;
                $s .= " and id = " . $adata['logo_id'];
                $this->db->query($s);

                $s = "update current_logo set logo_src = '" . $clientlogo . "'   ";
                $s .= " where client_id = " . $client_id;
//                $s .= " and leadpop_id = " . $leadpop_id;
//                $s .= " and leadpop_vertical_id = " . $vertical_id;
//                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//                $s .= " and leadpop_type_id = " . $leadpop_type_id;
//                $s .= " and leadpop_template_id = " . $leadpop_template_id;
                $s .= " and leadpop_version_id  	= " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $this->db->query($s);

            } else if ($adata['logo_source'] == 'default') {
                $s = "update leadpop_logos set use_default = 'y', use_me = 'n' , default_colored = 'n', swatches = '" . $adata['swatches'] . "', scaling_properties = '" . $scaling_properties . "'";
                $s .= " where client_id = " . $client_id;
//                $s .= " and leadpop_id = " . $leadpop_id;
//                $s .= " and leadpop_type_id = " . $leadpop_type_id;
//                $s .= " and leadpop_vertical_id = " . $vertical_id;
//                $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//                $s .= " and leadpop_template_id = " . $leadpop_template_id;
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
//                    $s .= " and leadpop_id = " . $leadpop_id;
//                    $s .= " and leadpop_vertical_id = " . $vertical_id;
//                    $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
//                    $s .= " and leadpop_type_id = " . $leadpop_type_id;
//                    $s .= " and leadpop_template_id = " . $leadpop_template_id;
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
                    $sixnine = $this->getReplacedColorHtml($sixnine, $logo_color);
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
			background-image: linear-gradient(to right bottom, rgba(' . $new_color[0] . ',' . $new_color[1] . ',' . $new_color[2] . ',1.0) 0%,rgba(' . $new_color[0] . ',' . $new_color[1] . ',' . $new_color[2] . ',1.0) 100%); /* W3C */';

                $s = " select * from leadpop_background_color where client_id = " . $client_id;
                $s .= " and leadpop_version_id = " . $leadpop_version_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $s .= " and active_backgroundimage = 'y'";
                $leadpop_background_color = $this->db->fetchRow($s);
                if ($leadpop_background_color) {
                    if ($leadpop_background_color['background_type'] == config('lp.leadpop_background_types.BACKGROUND_IMAGE')) {
                        $active_backgroundimage = 'y';
                        $background_type = config('lp.leadpop_background_types.BACKGROUND_IMAGE');
                    } else if ($leadpop_background_color['background_type'] == config('lp.leadpop_background_types.OWN_COLOR')) {
                        $active_backgroundimage = $leadpop_background_color['active_backgroundimage'];
                        $background_type = config('lp.leadpop_background_types.OWN_COLOR');
                    } else {
                        $active_backgroundimage = 'n';
                        $background_type = config('lp.leadpop_background_types.LOGO_COLOR');
                    }
                } else {
                    $active_backgroundimage = 'n';
                    $background_type = config('lp.leadpop_background_types.LOGO_COLOR');
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

                    /**
                     * It appears that swatches order matter and first swatch was intentionally made solid above with opacity=1 in $str0,
                     * that resulted in a duplicate swatch and a total of 27 swatches were being generated instead of 28
                     * to fix that without changing swatch generation order, I had to add this $key < 1 here too
                     */
                    if ($key < 1) {
                        $str3 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",.7) 100%)";
                    } else {
                        $str3 = "linear-gradient(to bottom, rgba(" . $red . "," . $green . "," . $blue . ",1.0) 0%,rgba(" . $red . "," . $green . "," . $blue . ",1.0) 100%)";
                    }

                    $swatches = array($str0, $str1, $str2, $str3);
                    //debug($swatches);
                    for ($i = 0; $i < 4; $i++) {
                        $index++;
                        $is_primary = 'n';

                        $backgroundSwatch = addslashes($swatches[$i]);

                        if ($index == 1) {
                            $is_primary = 'y';
                            LeadpopBackgroundColor::where([
                                'client_id' => $client_id,
                                'leadpop_vertical_id' => $vertical_id,
                                'leadpop_vertical_sub_id' => $subvertical_id,
                                'leadpop_type_id' => $leadpop_type_id,
                                'leadpop_template_id' => $leadpop_template_id,
                                'leadpop_id' => $leadpop_id,
                                'leadpop_version_id' => $leadpop_version_id,
                                'leadpop_version_seq' => $version_seq
                            ])->update([
                                'background_color' => $backgroundSwatch,
                                'background_type' => '1'
                            ]);
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
                        $s .= "'" . $backgroundSwatch . "',";
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

        $adata['titletag'] = str_replace('"', "", $adata['titletag']);
        $adata['description'] = str_replace('"', "", $adata['description']);
        $adata['metatags'] = str_replace('"', "", $adata['metatags']);

        $s = "update seo_options set titletag = '" . addslashes($adata['titletag']) . "', ";
        $s .= "titletag_active='" . $adata['seo_title_active'] . "', ";
        $s .= "description_active='" . $adata['seo_description_active'] . "', ";
        $s .= "metatags_active='" . $adata['seo_keyword_active'] . "', ";
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
        $vertical_id = $funnel_data["funnel"]["leadpop_vertical_id"];
        $subvertical_id = $funnel_data["funnel"]["leadpop_vertical_sub_id"];
        $leadpop_id = $funnel_data["funnel"]["leadpop_id"];
        $leadpop_template_id = $funnel_data['leadpop_template_id'];
        $leadpop_version_id = $funnel_data['leadpop_version_id'];
        $leadpop_type_id = $funnel_data['leadpop_type_id'];
        $version_seq = $funnel_data["funnel"]["leadpop_version_seq"];

        $whereData = [
            'client_id' => $data['client_id'],
            'leadpop_id' => $leadpop_id,
            'leadpop_type_id' => $leadpop_type_id,
            'leadpop_vertical_id' => $vertical_id,
            'leadpop_vertical_sub_id' => $subvertical_id,
            'leadpop_template_id' => $leadpop_template_id,
            'leadpop_version_id' => $leadpop_version_id,
            'leadpop_version_seq' => $version_seq,
        ];

        $updateData = [
            'html' => $data['htmlautoeditor'],
            'thetext' => $data['textautoeditor'],
            'subject_line' => trim($data['sline']),
            'text_active' => $data['active_respondertext'] ?? 'n',
            'active' => $data['active'] ?? 'n',
            'html_active' => $data['active_responderhtml'] ?? 'n',
            'date_updated' => Carbon::now()->toDateTimeString()
        ];

        AutoResponderOption::updateOrCreate($whereData, $updateData);

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
            $s .= "phonenumber = '" . addslashes($adata['phonenumber']) . "', email = '" . $adata['email'] . "', ";
            $s .= "companyname_active = '" . $adata['companyname_active'] . "', ";
            $s .= "phonenumber_active = '" . $adata['phonenumber_active'] . "', ";
            $s .= "email_active = '" . $adata['email_active'] . "' ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;

            $this->db->query($s);


            if ($adata['companyname_active'] == 'y') $funnel_variables[FunnelVariables::CONTACT_COMPANY] = $adata['companyname'];
            else $funnel_variables[FunnelVariables::CONTACT_COMPANY] = "";

            if ($adata['phonenumber_active'] == 'y') $funnel_variables[FunnelVariables::CONTACT_PHONE] = $adata['phonenumber'];
            else $funnel_variables[FunnelVariables::CONTACT_PHONE] = "";

            if ($adata['email_active'] == 'y') $funnel_variables[FunnelVariables::CONTACT_EMAIL] = $adata['email'];
            else $funnel_variables[FunnelVariables::CONTACT_EMAIL] = "";

        } else {
            $s = "insert into contact_options (client_id,leadpop_id,leadpop_type_id,leadpop_vertical_id,
                  leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,leadpop_version_seq
                  ,companyname,phonenumber,email,companyname_active,phonenumber_active,email_active) values($client_id,$leadpop_id,$leadpop_type_id,$vertical_id,
                  $subvertical_id,$leadpop_template_id,$leadpop_version_id,$version_seq,
                 '" . addslashes($adata['companyname']) . "', '" . $adata['phonenumber'] . "', '" . $adata['email'] . "'
                 , '" . $adata['companyname_active'] . "', '" . $adata['phonenumber_active'] . "' , '" . $adata['email_active'] . "'
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
        $lplist = explode(",", $lpkey);
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

            if ($adata['company_name']) {
                $s .= ", companyname = '" . addslashes($adata['company_name']) . "'";
            }
            if ($adata['phone_number']) {
                $s .= ", phonenumber = '" . $adata['phone_number'] . "'";
            }
            if ($adata['email_address']) {
                $s .= ", email = '" . $adata['email_address'] . "'";
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
                if ("" != $adata['company_name'] && null != $adata['company_name']) {
                    $funnel_variables[FunnelVariables::CONTACT_COMPANY] = $adata['company_name'];
                }
            }


            if ($phonenumber_active == 'y') {
                if ("" != $adata['phone_number'] && null != $adata['phone_number']) {
                    $funnel_variables[FunnelVariables::CONTACT_PHONE] = $adata['phone_number'];
                }
            }

            if ($email_active == 'y') {
                if ("" != $adata['email_address'] && null != $adata['email_address']) {
                    $funnel_variables[FunnelVariables::CONTACT_EMAIL] = $adata['email_address'];
                }
            }

            $this->concatCompanyNameAndSaveSeoTagTitle($adata['company_name'], [
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
        $s = "select * from global_settings where client_id = " . $client_id;
        $client = $this->db->fetchRow($s);

        if (!$client) {
            $s = "insert into global_settings (id,client_id,companyname,phonenumber,email,";
            $s .= "companyname_active,phonenumber_active,email_active) values (null,";
            $s .= $client_id . ",'" . $adata['company_name'] . "','" . $adata['phone_number'] . "','" . $adata['email_address'] . "','" . $companyname_active . "','" . $phonenumber_active . "','" . $email_active . "') ";
            $this->db->query($s);
        } else {
            $s = "update global_settings set companyname_active = '" . $companyname_active . "',phonenumber_active = '" . $phonenumber_active . "',email_active = '" . $email_active . "' ,";
            $s .= " companyname = '" . addslashes($adata['company_name']) . "', phonenumber = '" . $adata['phone_number'] . "', email = '" . $adata['email_address'] . "'";
            $s .= " where client_id = " . $client_id;
            $this->db->query($s);
        }


    }

    public function globalsavethankyouoptions($client_id, $adata)
    {
        extract($_POST, EXTR_OVERWRITE, "form_");
        $lplist = explode(",", $lpkey_thankyou);
        //if (isset($thirdparty_active) ) {
        $thirdpartyurl = str_replace(array('http://', 'https://'), '', $thirdpartyurl);
        $httpsflag = 'n';
        if (isset($https_flag) && $https_flag == 'on') {
            $httpsflag = 'y';
            $thirdpartyurl = 'https://' . $thirdpartyurl;
        } else {
            $thirdpartyurl = 'http://' . $thirdpartyurl;
        }
        //}
        //$thirdpartyurl=$thirdpartyurl;
        //debug($thirdpartyurl);
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
            if ($adata['thankyoumessage']) {
                //if ($thankyou_active == 'y') {
                $s .= ", thankyou = '" . addslashes($adata['thankyoumessage']) . "' ";
                //}
            }
            //if($thirdparty_active == 'y') {
            if ($thirdpartyurl) {
                $s .= " ,https_flag  = '" . $httpsflag . "' ";
                $s .= " ,thirdparty  = '" . $thirdpartyurl . "' ";
                //$s .= ", thankyou = '".addslashes($thirdpartyurl)."' ";
            }
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $leadpop_type_id;
            $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
            $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
            $s .= " and leadpop_template_id = " . $leadpop_template_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            /*var_dump($s);
			exit;*/
            $this->db->query($s);


            # placeholder usage removed from this section
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
    }


    public function saveglobalautoresponder($client_id, $adata)
    {
        extract($_POST, EXTR_OVERWRITE, "form_");
        $lplist = explode(",", $lpkey_responder);

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

            $s = "update autoresponder_options set  html_active = '" . $html_active . "' , text_active = '" . $text_active . "' , active = '" . $responder_active . "' ";
            if (isset($subline) && $subline != '') {
                $s .= ", subject_line = '" . addslashes($subline) . "'";
            }
            if ("" != $htmlautoeditor && null != $htmlautoeditor) {
                if ($html_active == 'y') {
                    $s .= ", html = '" . addslashes($htmlautoeditor) . "' ";
                }
            }

            if ("" != $textautoeditor && null != $textautoeditor) {
                if ($text_active == 'y') {
                    $s .= ", thetext = '" . addslashes($textautoeditor) . "' ";
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

            $this->db->query($s);
        }
    }

    public function updatestatusglobaladvancefooter($client_id, $data)
    {
        $funnel_info = $data['funnels-info'];
        $lplist = explode(",", $funnel_info);
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
                if ($data['footer_status'] == "true") {
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
    }

    public function updateglobaladvancefooter($client_id, $data)
    {
        $funnel_info = $data['funnels-info'];
        $advancehtml = $data['fr-html'];
        $hideofooter = $data['hideofooter'];
        $templateType = isset($data["templatetype"]) ? $data["templatetype"] : null;
        $isDefaultTplCtaMessage = (isset($_POST['defaultTplCtaMessage']) && $_POST['defaultTplCtaMessage'] == "y");

        $lplist = explode(",", $funnel_info);
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
                print_r($s);
            } else {
                $query = "INSERT INTO `bottom_links`.`comments` (`client_id`, `leadpop_id`,
                        `leadpop_type_id`, `leadpop_vertical_id`,
                        `leadpop_vertical_sub_id`, `leadpop_template_id`,
                         `leadpop_version_id`,`leadpop_version_seq`,`advancehtml`,`hide_primary_footer`)
                          VALUES ($client_id, $leadpop_id,
                          $leadpop_type_id, $leadpop_vertical_id, $leadpop_vertical_sub_id,
                          $leadpop_template_id, $leadpop_version_id,$leadpop_version_seq,addslashes($advancehtml),$hideofooter);";
                $this->db->query($query);
                print_r($query);

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


    public function saveglobalmaincontent($client_id, $adata)
    {
        extract($_POST, EXTR_OVERWRITE, "form_");
        $lplist = explode(",", $lpkey_maincontent);

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

            if ("" != $adata['mainheadingval'] && null != $adata['mainheadingval']) {
                $span = '<span style="font-family: ' . $adata['thefont'] . '; font-size:' . $adata['thefontsize'] . '; color: ' . $adata['savestyle'] . ';line-height:' . $adata['lineheight'] . ';">' . $adata['mainheadingval'] . '</span>';

                if ($adata['contenttype'] == 'mainmessage') {
                    $this->updateLeadLine(FunnelVariables::LEAD_LINE, $span, $client_id, $leadpop_id, $leadpop_version_seq);
                    $this->updateFunnelVar(FunnelVariables::FONT_FAMILY, $adata['thefont'], $client_id, $leadpop_id, $leadpop_version_seq);
                } else {
                    $this->updateLeadLine(FunnelVariables::SECOND_LINE, $span, $client_id, $leadpop_id, $leadpop_version_seq);
                    $this->updateFunnelVar(FunnelVariables::FONT_FAMILY_DESC, $adata['thefont'], $client_id, $leadpop_id, $leadpop_version_seq);
                }
            }
        }
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

        $s = "select * from global_settings where client_id = " . $client_id;
        $client = $this->db->fetchRow($s);


        if (!$client) {
            $s = "insert into global_settings (id,client_id,image,";
            $s .= "image_url,image_path) values (null,";
            $s .= $client_id . ",'" . addslashes($imagename) . "','" . addslashes($imageurl) . "','" . addslashes($imagepath) . "') ";
            $this->db->query($s);
        } else {
            $s = "update global_settings set image = '" . $imagename . "',image_url = '" . $imageurl . "',image_path = '" . $imagepath . "'";
            $s .= " where client_id = " . $client_id;
            $this->db->query($s);
        }
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
     * @since 2.1.0 - CR-Funnel-Builder: Removed leadpops_templates_placeholders_values -> placeholder_sixtyfive
     *
     * @param $client_id int
     * @param $adata array
     * @param $funnel_data array
     */
    public function saveSubmissionOptions($client_id, $adata, $funnel_data = array())
    {
        $vertical_id = $funnel_data["funnel"]["leadpop_vertical_id"];
        $subvertical_id = $funnel_data["funnel"]["leadpop_vertical_sub_id"];
        $leadpop_id = $funnel_data["funnel"]["leadpop_id"];
        $version_seq = $funnel_data["funnel"]["leadpop_version_seq"];
        $leadpop_template_id = $funnel_data["funnel"]['leadpop_template_id'];
        $leadpop_version_id = $funnel_data["funnel"]['leadpop_version_id'];
        $leadpop_type_id = $funnel_data["funnel"]['leadpop_type_id'];

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
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;

            if(isset($adata['submission_id'])) {
                $s .= " and id = " . $adata['submission_id'];
            }

            return $this->db->query($s);

        } else {
            $s = "update submission_options set " . $adata['theoption'] . " = '" . addslashes($adata['tfootereditor']) . "', ";
            $s .= " thankyou_slug  = '" . $adata['thankyou_slug'] . "' ";
            if (array_key_exists("thankyou_logo", $adata)) {
                $s .= ", thankyou_logo  = " . $adata["thankyou_logo"];
            }
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;

            if(isset($adata['submission_id'])) {
                $s .= " and id = " . $adata['submission_id'];
            }
            $this->db->query($s);
        }

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

        if (empty($submissionOptions) || !$submissionOptions) {
            $submissionOptionsthankyou_active = 'y';
            $submissionOptionsthirdparty_active = 'n';
            $submissionOptionsinformation_active = 'n';

        } else {
            $submissionOptionsthankyou_active = $submissionOptions['thankyou_active'];
            $submissionOptionsthirdparty_active = $submissionOptions['thirdparty_active'];
            $submissionOptionsinformation_active = $submissionOptions['information_active'];
        }


        if ($adata['theoption'] == 'thankyou' && $submissionOptionsthankyou_active == 'y') {
            $s = "select leadpop_template_id from leadpops where id = " . $leadpop_id;
            $leadpop_template_id = $this->db->fetchOne($s);

            $s = "select subdomain_name,top_level_domain from s_subdomains ";
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

        } else if ($adata['theoption'] == 'information' && $submissionOptionsinformation_active == 'y') {
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

        } else if ($adata['theoption'] == 'thirdparty' && $submissionOptionsthirdparty_active == 'y') {
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
    }

    public function saveMultipleSubmissionOptions($noOfPages, $funnel_data = array(), $post = array()) {

        $insert_id = true;
        $vertical_id = $funnel_data["funnel"]["leadpop_vertical_id"];
        $subvertical_id = $funnel_data["funnel"]["leadpop_vertical_sub_id"];
        $leadpop_id = $funnel_data["funnel"]["leadpop_id"];
        $version_seq = $funnel_data["funnel"]["leadpop_version_seq"];
        $leadpop_template_id = $funnel_data["funnel"]['leadpop_template_id'];
        $leadpop_version_id = $funnel_data["funnel"]['leadpop_version_id'];
        $leadpop_type_id = $funnel_data["funnel"]['leadpop_type_id'];

        $pages = [];

        $activeThankYouPage = $this->getActiveThankYouPage($funnel_data);
            if(isset($post['https_flag']) && $post['https_flag'] == 'https://')
            {
                $post['https_flag'] = 'y';
            }
            else if(isset($post['https_flag']) &&  $post['https_flag'] == 'http://')
            {
                $post['https_flag'] = 'n';
            }
        for($i = 0; $i < $noOfPages; $i++)
        {
            $pages[] = array(
                'client_id' =>  $funnel_data['client_id'],
                'leadpop_id' =>  $leadpop_id,
                'leadpop_type_id' =>  $leadpop_type_id,
                'leadpop_vertical_id' =>  $vertical_id,
                'leadpop_vertical_sub_id' =>  $subvertical_id,
                'leadpop_template_id' =>  $leadpop_template_id,
                'leadpop_version_id' =>  $leadpop_version_id,
                'leadpop_version_seq' =>  $version_seq,
                'thankyou' => ($post['thankyou']) ?? '',
                'thankyou_logo' => ($post['thankyou_logo']) ?? 1,
                'thirdparty' => ($post['thirdparty']) ?? '',
                'thankyou_active' =>  ($post['thankyou_active']) ?? 'y',
                'information_active' => 'n',
                'thirdparty_active' => ($post['thirdparty_active']) ?? 'n',
                'https_flag' => isset($post['https_flag']) ? $post['https_flag'] : 'n',
                'date_created' => now()->toDateTimeString(),
                'date_updated' => now()->toDateTimeString(),
                'thankyou_title' => ($post['thankyou_title']) ?? 'Default Success Message',
                'thankyou_slug' => ($post['thankyou_slug']) ?? '',
                'is_active' => $i == 0 && !$activeThankYouPage ? 1 : 0
            );
        }

        if (count($pages)) {
            if(isset($post["id"]) and !empty($post['id'])){
                SubmissionOption::where(array('id' => $post['id']))->update($pages[0]);
                $insert_id =  $post["id"];
            }
            else{
                SubmissionOption::insert($pages);
                $insert_id =  DB::getPDO()->lastInsertId();
            }
        }

        return $insert_id;
    }


    public function updateThankyouPage($request)
    {
        try {
            $submission = SubmissionOption::find($request->id);
            $submission->thankyou_title = $request->thankyou_title;
            $submission->thankyou_slug = $request->thankyou_slug;
            $submission->thankyou = $request->thankyou;
            $submission->thankyou_logo = $request->thankyou_logo;
            $submission->save();

            return ['status' => true, 'response' => $submission];

        } catch (\Exception $exception) {
            return ['status' => true, 'response' => $exception->getMessage()];
        }
    }

    public function saveBottomLinks($client_id, $adata, $funnel_data = array())
    {
        $privacy_policy_active = (isset($adata["privacy_policy_active"]) && $adata["privacy_policy_active"] == "y") ? "y" : "n";
        $terms_of_use_active = (isset($adata["terms_of_use_active"]) && $adata["terms_of_use_active"] == "y") ? "y" : "n";
        $disclosures_active = (isset($adata["disclosures_active"]) && $adata["disclosures_active"] == "y") ? "y" : "n";
        $licensing_information_active = (isset($adata["licensing_information_active"]) && $adata["licensing_information_active"] == "y") ? "y" : "n";
        $about_us_active = (isset($adata["about_us_active"]) && $adata["about_us_active"] == "y") ? "y" : "n";
        $contact_us_active = (isset($adata["contact_us_active"]) && $adata["contact_us_active"] == "y") ? "y" : "n";


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
            $s .= " privacy_active = '" . $privacy_policy_active . "', ";
            $s .= " privacy = '" . addslashes(htmlspecialchars($adata['footereditor'])) . "', ";
            $s .= " privacy_text = '" . addslashes($adata['theurltext']) . "' ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;

        }
        if ($adata['theselectiontype'] == 'termsofuse') {
            $s = "update bottom_links set terms_type = '" . $adata['theselection'] . "', ";
            $s .= " terms_url = '" . $adata['theurl'] . "', ";
            $s .= " terms_active = '" . $terms_of_use_active . "', ";
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
            $s .= " disclosures_active = '" . $disclosures_active . "', ";
            $s .= " disclosures_text = '" . addslashes($adata['theurltext']) . "' ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
        }
        if ($adata['theselectiontype'] == 'licensinginformation') {
            $s = "update bottom_links set licensing_type = '" . $adata['theselection'] . "', ";
            $s .= " licensing_url = '" . addslashes($adata['theurl']) . "', ";
            $s .= " licensing_active = '" . $licensing_information_active . "', ";
            $s .= " licensing = '" . addslashes(htmlspecialchars($adata['footereditor'])) . "', ";
            $s .= " licensing_text = '" . addslashes($adata['theurltext']) . "' ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
        }
        if ($adata['theselectiontype'] == 'aboutus') {
            $s = "update bottom_links set about_type = '" . $adata['theselection'] . "', ";
            $s .= " about_url = '" . $adata['theurl'] . "', ";
            $s .= " about_active = '" . $about_us_active . "', ";
            $s .= " about = '" . addslashes(htmlspecialchars($adata['footereditor'])) . "', ";
            $s .= " about_text = '" . addslashes($adata['theurltext']) . "' ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
        }
        if ($adata['theselectiontype'] == 'contactus') {
            $s = "update bottom_links set contact_type = '" . $adata['theselection'] . "', ";
            $s .= " contact_url = '" . $adata['theurl'] . "', ";
            $s .= " contact_active = '" . $contact_us_active . "', ";
            $s .= " contact = '" . addslashes(htmlspecialchars($adata['footereditor'])) . "', ";
            $s .= " contact_text = '" . addslashes($adata['theurltext']) . "' ";
            $s .= " where client_id = " . $client_id;
            $s .= " and leadpop_version_id = " . $leadpop_version_id;
            $s .= " and leadpop_version_seq = " . $version_seq;
        }

        $this->db->query($s);
//        dd($s);
    }

    public function getSeoOptions($hash_data)
    {
        $client_id = $hash_data["funnel"]["client_id"];
        $leadpop_vertical_id = $hash_data["funnel"]["leadpop_vertical_id"];
        $leadpop_vertical_sub_id = $hash_data["funnel"]["leadpop_vertical_sub_id"];
        $leadpop_id = $hash_data["funnel"]["leadpop_id"];
        $leadpop_type_id = $hash_data["funnel"]['leadpop_type_id'];
        $leadpop_template_id = $hash_data["funnel"]['leadpop_template_id'];
        $leadpop_version_id = $hash_data["funnel"]['leadpop_version_id'];
        $leadpop_version_seq = $hash_data["funnel"]["leadpop_version_seq"];

        $s = "select * from seo_options ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $leadpop_vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $leadpop_vertical_sub_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
        $seoOptions = $this->db->fetchRow($s);
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
        //  echo $s;
        //  print_r($autoresponderOptions);
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

    public function getSubmissionOptions($funnelData, $submission_id = null)
    {

        $s = "select * from submission_options ";
        $s .= " where client_id = " . $funnelData["funnel"]["client_id"];
        $s .= " and leadpop_version_id = " . $funnelData["funnel"]["leadpop_version_id"];
        $s .= " and leadpop_version_seq = " . $funnelData["funnel"]["leadpop_version_seq"];

        if (request()->has('id')) {
            $s .= " and id = " . request()->get('id');
        }
        /*var_dump($s);
            exit;*/
        $submissionOptions = $this->db->fetchRow($s);
        return $submissionOptions;

    }

    /* @handler getAllThankYouPages
     * @param $client_id
     * @param $vertical_id
     * @param $subvertical_id
     * @param $leadpop_id
     * @param $version_seq
     * @return Collection SubmissionOption
     * */
    public function getAllThankYouPages($funnelData, $pagination = true)
    {
        $pages = SubmissionOption::where([
            'client_id' => $funnelData["funnel"]["client_id"],
            'leadpop_id' => $funnelData["funnel"]["leadpop_id"],
            'leadpop_type_id' => $funnelData["funnel"]["leadpop_type_id"],
            'leadpop_vertical_id' => $funnelData["funnel"]["leadpop_vertical_id"],
            'leadpop_vertical_sub_id' => $funnelData["funnel"]["leadpop_vertical_sub_id"],
            'leadpop_template_id' => $funnelData["funnel"]["leadpop_template_id"],
            'leadpop_version_id' => $funnelData["funnel"]["leadpop_version_id"],
            'leadpop_version_seq' => $funnelData["funnel"]["leadpop_version_seq"],
        ])->orderBy('position');

        if ($pagination) {
            $perPage = request()->get('perPage', 20);
            $pages = $pages->paginate($perPage);
        } else {
            $pages = $pages->get();
        }

        return $pages;
    }



    /* @handler getAllThankYouPages
     * @param $client_id
     * @param $vertical_id
     * @param $subvertical_id
     * @param $leadpop_id
     * @param $version_seq
     * @return Collection SubmissionOption
     * */
    public function getActiveThankYouPage($funnel_data)
    {
        $client_id = $funnel_data["funnel"]["client_id"];
        $vertical_id = $funnel_data["funnel"]["leadpop_vertical_id"];
        $subvertical_id = $funnel_data["funnel"]["leadpop_vertical_sub_id"];
        $leadpop_id = $funnel_data["funnel"]["leadpop_id"];
        $version_seq = $funnel_data["funnel"]["leadpop_version_seq"];
        $leadpop_template_id = $funnel_data["funnel"]['leadpop_template_id'];
        $leadpop_version_id = $funnel_data["funnel"]['leadpop_version_id'];
        $leadpop_type_id = $funnel_data["funnel"]['leadpop_type_id'];
        $pages = SubmissionOption::where([
            'client_id' => $client_id,
            'leadpop_id' => $leadpop_id,
            'leadpop_type_id' => $leadpop_type_id,
            'leadpop_vertical_id' => $vertical_id,
            'leadpop_vertical_sub_id' => $subvertical_id,
            'leadpop_template_id' => $leadpop_template_id,
            'leadpop_version_id' => $leadpop_version_id,
            'leadpop_version_seq' => $version_seq,
            'is_active' => 1
        ])->first();

        return $pages;
    }

    /* @handler getThankYouPageByID
     * @param $id
     * @return Collection SubmissionOption
     * */
    public function getThankYouPageByID($id)
    {
        $pages = SubmissionOption::find($id);

        return $pages;
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
        $this->fixExtraContentHtml($bottomLinks["advancehtml"]);
        return $bottomLinks;
    }

    public function getAdvancedFooteroptions($funnelData)
    {
        $registry = DataRegistry::getInstance();
        $response = [
            'first_name' => $registry->leadpops->clientInfo['first_name'],
            "logocolor" => ""
        ];

        $logoQuery = \DB::table("leadpop_logos")
            ->where("client_id", $funnelData["client_id"])
            ->where("leadpop_version_id", $funnelData['leadpop_version_id'])
            ->where("leadpop_version_seq", $funnelData['leadpop_version_seq']);

//        \DB::enableQueryLog();
        $clientQuery = clone $logoQuery;
        // client uploaded logo
        $clientQuery = $clientQuery->where("use_me", "y");
        if($clientQuery->count()) {
            $clientLogo = $clientQuery->select("ini_logo_color", "logo_color")
                ->first();
            $response["logocolor"] = $clientLogo->logo_color ?? $clientLogo->ini_logo_color;
        } else {
            // default coloured logo, which is added by default with funnel
            $defaultColouredLogo = $logoQuery->where("use_default", "y")
                ->select("logo_color", "ini_logo_color", "default_colored")
                ->orderBy("id", "asc")
                ->first();
            if($defaultColouredLogo && $defaultColouredLogo->default_colored == "y") {
                $response["logocolor"] = $defaultColouredLogo->logo_color ?? $defaultColouredLogo->ini_logo_color;
            } else {
                // default logo color, if didn't found client logo and default coloured logo
                $stockLogo = \DB::table("stock_leadpop_logos")
                    ->select("default_logo_color")
                    ->where("leadpop_vertical_id", $funnelData["leadpop_vertical_id"])
                    ->where("leadpop_vertical_sub_id", $funnelData['leadpop_vertical_sub_id'])
                    ->where("leadpop_version_id", $funnelData['leadpop_version_id'])
                    ->first();
                if ($stockLogo) {
                    $response["logocolor"] = $stockLogo->default_logo_color;
                }
            }
        }
//        dd(\DB::getQueryLog());
        return $response;
    }



    /**
     * @since 2.1.0 - CR-Funnel-Builder: Moved leadpops_templates_placeholders_values -> placeholder_seventy   ==>   clients_leadpops -> second_line_more
     *
     * @param $adata array
     * @param $client_id int
     * @param $leadpop_id int
     * @param $leadpop_version_seq int
     */
    public function updateCTAMessage($data, $client_id, $leadpop_id, $leadpop_version_seq)
    {
        $s = "UPDATE clients_leadpops SET  lead_line = '" . addslashes($data["message"]) . "', second_line_more = '" . addslashes($data["description"]) . "' ";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_id = " . $leadpop_id;
        $s .= " AND leadpop_version_seq = " . $leadpop_version_seq;
        $this->db->query($s);
    }


    /**
     * @since 2.1.0 - CR-Funnel-Builder: Moved leadpops_templates_placeholders_values -> placeholder_seventy   ==>   clients_leadpops -> second_line_more
     * current funnel data
     * @param $leadpop
     * @return array
     */
    public function resetHomePageDescription($leadpop)
    {
        $client = Clients::where('client_id', $leadpop['client_id'])->first();
        $defaultsStockTable = $defaultsTable = $this->getStockFunnelDefaultTable($client);

        if ($leadpop['funnel_market'] == 'w') {
            $defaultsTable = $this->getWebsiteFunnelDefaultTable($client);
        }

        $subdomain_leadpop_id = $leadpop['leadpop_id'];
        if ($leadpop['leadpop_type_id'] == config('leadpops.leadpopDomainTypeId')) {
            $subdomain_leadpop_id = \DB::table('leadpops')
                ->where("leadpop_type_id", config('leadpops.leadpopSubDomainTypeId'))
                ->where("leadpop_vertical_id", $leadpop['leadpop_vertical_id'])
                ->where("leadpop_vertical_sub_id", $leadpop['leadpop_vertical_sub_id'])
                ->where("leadpop_template_id", $leadpop['leadpop_template_id'])
                ->where("leadpop_version_id", $leadpop['leadpop_version_id'])
                ->value("id");
        }
        // for custom funnels
        if($leadpop["leadpop_version_id"] == config('funnelbuilder.funnel_builder_version_id')){
            $newdescr["description_font"] = config('funnelbuilder.cta_description.fontfamily');
            $newdescr["description_font_size"] = config('funnelbuilder.cta_description.fontsize');
            $newdescr['description_color'] = config('funnelbuilder.cta_description.color');
            $newdescr["description"] = config('funnelbuilder.cta_description.messageStyle');
        }else{
            $s = "select  * from $defaultsTable ";
            $s .= " where leadpop_vertical_id 	= " . $leadpop["leadpop_vertical_id"];
            $s .= " and leadpop_vertical_sub_id 	= " . $leadpop["leadpop_vertical_sub_id"];
            $s .= " and leadpop_id = " . $subdomain_leadpop_id;
            $s .= " and leadpop_version_id =	" . $leadpop["leadpop_version_id"];
            $s .= " and leadpop_template_id =	" . $leadpop["leadpop_template_id"];
            $s .= " limit 1";
            if ($leadpop['client_id'] == 248 && $leadpop["leadpop_vertical_sub_id"] == 74) {
                $s = 'select * from trial_launch_defaults where leadpop_vertical_id = 3 and leadpop_vertical_sub_id = 11 and leadpop_type_id = 1 and leadpop_version_id = 14 and leadpop_template_id = 14 and leadpop_version_seq = 1 limit 1 ';
            }
            $newdescr = $this->db->fetchRow($s);
            //main_message 	main_message_font 	main_message_font_size
            //description 	description_font 	description_font_size description_color

            if ($leadpop['funnel_market'] == 'w') {
                $query = "select  * from $defaultsStockTable ";
                $query .= " where leadpop_vertical_id 	= " . $leadpop["leadpop_vertical_id"];
                $query .= " and leadpop_vertical_sub_id 	= " . $leadpop["leadpop_vertical_sub_id"];
                $query .= " and leadpop_id = " . $subdomain_leadpop_id;
                $query .= " and leadpop_version_id =	" . $leadpop["leadpop_version_id"];
                $query .= " and leadpop_template_id =	" . $leadpop["leadpop_template_id"];
                $query .= " limit 1";

                $stockDefaults = $this->db->fetchRow($query);

                if ($stockDefaults) {
                    $newdescr = $this->mapWebsiteFunnelDefaultsToStock($stockDefaults, $newdescr);
                }
            }
        }


        $lineHeight = '1.42857';
        $span = '<span style="font-family: ' . $newdescr["description_font"] . '; font-size:' . $newdescr["description_font_size"] . '; color:' . $newdescr['description_color'] . ';line-height:' . $lineHeight . '">' . $newdescr["description"] . '</span>';

        $s = "UPDATE clients_leadpops SET second_line_more = '" . addslashes($span) . "' WHERE client_id = " . $leadpop["client_id"] . " AND leadpop_version_id = " . $leadpop["leadpop_version_id"] . " AND leadpop_version_seq = " . $leadpop["leadpop_version_seq"];
        $this->db->query($s);
        return array("style" => array('font_family' => str_replace(';', '', $newdescr["description_font"]), 'font_size' => $newdescr["description_font_size"], 'color' => $newdescr['description_color'],'line_height' => $lineHeight, 'main_message' => $newdescr["description"]));
    }

    public function getStockFunnelDefaultTable(Clients $client)
    {
        if (!$client) {
            return 'trial_launch_defaults';
        }

        if ($client->is_mm) {
            return 'trial_launch_defaults_mm';
        } else if ($client->is_fairway || $client->is_fairway_branch) {
            return 'trial_launch_defaults_fairway';
        } else {
            return 'trial_launch_defaults';
        }
    }

    public function getWebsiteFunnelDefaultTable(Clients $client)
    {
        if (!$client) {
            return 'add_mortgage_website_funnels';
        }

        if ($client->is_mm) {
            return 'add_mortgage_website_funnels_mvp_movement';
        } else if ($client->is_fairway || $client->is_fairway_branch) {
            return 'add_mortgage_website_funnels_mvp_fairway';
        } else {
            return 'add_mortgage_website_funnels';
        }
    }

    public function mapWebsiteFunnelDefaultsToStock(array $stockDefaults, array $websiteDefaults)
    {
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
     * current funnel data
     * @param $leadpop
     * @return array
     */
    public function resetHomePageMessageMainMessage($leadpop)
    {
        $subdomain_leadpop_id = $leadpop['leadpop_id'];
        if ($leadpop['leadpop_type_id'] == config('leadpops.leadpopDomainTypeId')) {
            $subdomain_leadpop_id = \DB::table('leadpops')
                ->where("leadpop_type_id", config('leadpops.leadpopSubDomainTypeId'))
                ->where("leadpop_vertical_id", $leadpop['leadpop_vertical_id'])
                ->where("leadpop_vertical_sub_id", $leadpop['leadpop_vertical_sub_id'])
                ->where("leadpop_template_id", $leadpop['leadpop_template_id'])
                ->where("leadpop_version_id", $leadpop['leadpop_version_id'])
                ->value("id");
        }

        $client = Clients::where('client_id', $leadpop['client_id'])->first();

        $defaultsStockTable = $defaultsTable = $this->getStockFunnelDefaultTable($client);

        if ($leadpop['funnel_market'] == 'w') {
            $defaultsTable = $this->getWebsiteFunnelDefaultTable($client);
        }

        // for custom funnels
        if($leadpop["leadpop_version_id"] == config('funnelbuilder.funnel_builder_version_id')){
            $newmain["main_message_font"] = config('funnelbuilder.cta_heading.fontfamily');
            $newmain["main_message_font_size"] = config('funnelbuilder.cta_heading.fontsize');
            $newmain['mainmessage_color'] = config('funnelbuilder.cta_heading.color');
            $newmain["main_message"] = config('funnelbuilder.cta_heading.messageStyle');
        }
        else{
            $s = "select  * from $defaultsTable ";
            $s .= " where leadpop_vertical_id 	= " . $leadpop["leadpop_vertical_id"];
            $s .= " and leadpop_vertical_sub_id 	= " . $leadpop["leadpop_vertical_sub_id"];
            $s .= " and leadpop_id = " . $subdomain_leadpop_id;
            $s .= " and leadpop_version_id =	" . $leadpop["leadpop_version_id"];
            $s .= " and leadpop_template_id =	" . $leadpop["leadpop_template_id"];
            $s .= " limit 1";
            if ($leadpop['client_id'] == 248 && $leadpop["leadpop_vertical_sub_id"] == 74) {
                $s = 'select * from trial_launch_defaults where leadpop_vertical_id = 3 and leadpop_vertical_sub_id = 11 and leadpop_type_id = 1 and leadpop_version_id = 14 and leadpop_template_id = 14 and leadpop_version_seq = 1 limit 1 ';
            }
            $newmain = $this->db->fetchRow($s);

            if ($leadpop['funnel_market'] == 'w') {
                $query = "select  * from $defaultsStockTable ";
                $query .= " where leadpop_vertical_id 	= " . $leadpop["leadpop_vertical_id"];
                $query .= " and leadpop_vertical_sub_id 	= " . $leadpop["leadpop_vertical_sub_id"];
                $query .= " and leadpop_id = " . $subdomain_leadpop_id;
                $query .= " and leadpop_version_id =	" . $leadpop["leadpop_version_id"];
                $query .= " and leadpop_template_id =	" . $leadpop["leadpop_template_id"];
                $query .= " limit 1";

                $stockDefaults = $this->db->fetchRow($query);

                if ($stockDefaults) {
                    $newmain = $this->mapWebsiteFunnelDefaultsToStock($stockDefaults, $newmain);
                }
            }
        }


        $lineHeight = '1.42857';

        $span = '<span style="font-family: ' . $newmain["main_message_font"] . '; font-size:' . $newmain["main_message_font_size"] . '; color:' . $newmain['mainmessage_color'] . ';line-height:' . $lineHeight . '">' . $newmain["main_message"] . '</span>';


        //to get logo color if use_default = n
        $sql = "SELECT * FROM leadpop_logos WHERE client_id = " . $leadpop['client_id'] . " AND leadpop_vertical_id 	= " . $leadpop["leadpop_vertical_id"] . " AND leadpop_vertical_sub_id = " . $leadpop["leadpop_vertical_sub_id"] . " AND  leadpop_id = " . $leadpop['leadpop_id'] . " AND leadpop_template_id =	" . $leadpop["leadpop_template_id"] . " AND leadpop_version_id = " . $leadpop["leadpop_version_id"] . " AND leadpop_version_seq = " .$leadpop['leadpop_version_seq'];
        $rec = $this->db->fetchRow($sql);
        if (!empty($rec) and $rec['use_default'] == 'n') {
            $old_color = $rec['logo_color'];
            if ($old_color && strtolower($old_color) !== "#ffffff" && $old_color !== "") {
                $newmain['mainmessage_color'] = $old_color;
                $span = preg_replace('/color:(.*?)\"/', "color:$old_color\"", $span);
            }
        }

        $s = "UPDATE clients_leadpops SET lead_line = '" . addslashes($span) . "' WHERE client_id = " . $leadpop["client_id"] . " AND leadpop_version_id = " . $leadpop["leadpop_version_id"] . " AND leadpop_version_seq = " . $leadpop["leadpop_version_seq"];
        $this->db->query($s);

        return array("style" => array('font_family' => str_replace(';', '', $newmain["main_message_font"]), 'font_size' => $newmain["main_message_font_size"], 'color' => $newmain['mainmessage_color'],'line_height' => $lineHeight, 'main_message' => $newmain["main_message"]));
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
        $s = "SELECT lead_line FROM clients_leadpops ";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_id = " . $leadpop_id;
        $s .= " AND leadpop_version_seq = " . $leadpop_version_seq;
        $homePageMessageMainMessage = $this->db->fetchOne($s);
        return $homePageMessageMainMessage ?? '';
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
    ## TODO-COMPOSITE-INDEXING
    public function getFunnelVariables($client_id, $leadpop_id, $leadpop_version_seq, $key = '')
    {
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
        $currentFunnelKey = "";
        if(isset($_POST['current_hash'])){
            $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);
        }

        $funnel_variables = $this->getFunnelVariables($client_id, $leadpop_id, $leadpop_version_seq);
        $funnel_variables[$key] = $value;

        ## TODO-COMPOSITE-INDEXING
        $s = "UPDATE clients_leadpops SET funnel_variables = '" . addslashes(json_encode($funnel_variables)) . "' ";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_id = " . $leadpop_id;
        $s .= " AND leadpop_version_seq = " . $leadpop_version_seq;

        Query::execute($s, $currentFunnelKey);
//        $this->db->query($s);
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

        if ($variables) {
            foreach ($variables as $key => $value) {
                $funnel_variables[$key] = $value;
            }
            ## TODO-COMPOSITE-INDEXING
            $s = "UPDATE clients_leadpops SET funnel_variables = '" . addslashes(json_encode($funnel_variables)) . "' ";
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
    ## TODO-COMPOSITE-INDEXING
    public function getLeadLine($client_id, $leadpop_id, $leadpop_version_seq, $column = 'lead_line')
    {
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
        if(isset($_POST['current_hash'])){
            $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);
        }

        ## TODO-COMPOSITE-INDEXING
        $s = "UPDATE clients_leadpops SET " . $column . " = '" . addslashes($value) . "' ";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_id = " . $leadpop_id;
        $s .= " AND leadpop_version_seq = " . $leadpop_version_seq;
//        $this->db->query($s);
        Query::execute($s, $currentFunnelKey);
    }

    public function checkZapierAndLeadPopsIntegrations($client_id)
    {
        $s = "SELECT client_id, api_token, lp_access_token FROM clients WHERE client_id = " . $client_id . " limit 1 ";
        $res = $this->db->fetchRow($s);
        return $res;
    }

    /**
     * check if client integration is active against funnel
     * @param $client_id
     * @param $leadpop_id
     * @param $leadpop_vertical_id
     * @param $leadpop_vertical_sub_id
     * @param $leadpop_template_id
     * @param $leadpop_version_id
     * @param $lp_version_seq
     * @param $integrationName
     * @return mixed
     */
    public function isActiveClientIntegration($client_id, $leadpop_id, $leadpop_vertical_id, $leadpop_vertical_sub_id, $leadpop_template_id, $leadpop_version_id, $lp_version_seq, $integrationName)
    {
        return \DB::table("client_integrations")
            ->where("client_id", $client_id)
            ->where("leadpop_id", $leadpop_id)
            ->where("leadpop_vertical_id", $leadpop_vertical_id)
            ->where("leadpop_vertical_sub_id", $leadpop_vertical_sub_id)
            ->where("leadpop_template_id", $leadpop_template_id)
            ->where("leadpop_version_id", $leadpop_version_id)
            ->where("leadpop_version_seq", $lp_version_seq)
            ->where('name', $integrationName)
            ->where("active", "y")
            ->count();
    }

    /**
     * Add integration against funnel selected funnel
     * @param $integrationName
     * @param $funnel_data
     * @return mixed
     */
    public function insertClientIntegration($integrationName, $funnel_data)
    {
        $clientIntegration = [
            'url' => $funnel_data['funnel']['domain_name'],
            'client_id' => $funnel_data['client_id'],
            'leadpop_id' => $funnel_data['leadpop_id'],
            'leadpop_vertical_id' => $funnel_data['leadpop_vertical_id'],
            'leadpop_vertical_sub_id' => $funnel_data['leadpop_vertical_sub_id'],
            'leadpop_template_id' => $funnel_data['leadpop_template_id'],
            'leadpop_version_id' => $funnel_data['leadpop_version_id'],
            'leadpop_version_seq' => $funnel_data['leadpop_version_seq'],
            "name" => $integrationName,
            "active" => "y"
        ];

        return \DB::table('client_integrations')->insert($clientIntegration);
    }

    /**
     * remove existing client integration against integration name
     * add entries in client integration table for funnels against integration name
     * @param $integrationName
     * @return bool
     */
    public function insertClientIntegrations($integrationName, $client_id)
    {
        \DB::table("client_integrations")
            ->where("client_id", $client_id)
            ->where(\DB::raw('LOWER(name)'), $integrationName)
            ->delete();

        $funnels = \LP_Helper::getInstance()->getFunnels();

        $clientIntegration = [];
        foreach ($funnels as $vertical_id => $v_funnels) {
            foreach ($v_funnels as $vs_funnels) {
                foreach ($vs_funnels as $v_sub_id => $funnel_info) {
                    foreach ($funnel_info as $client_leadpop_id => $funnel) {
                        $clientIntegration[] = [
                            'url' => $funnel['domain_name'],
                            'client_id' => $client_id,
                            'leadpop_id' => $funnel['leadpop_id'],
                            'leadpop_vertical_id' => $funnel['leadpop_vertical_id'],
                            'leadpop_vertical_sub_id' => $funnel['leadpop_vertical_sub_id'],
                            'leadpop_template_id' => $funnel['leadpop_template_id'],
                            'leadpop_version_id' => $funnel['leadpop_version_id'],
                            'leadpop_version_seq' => $funnel['leadpop_version_seq'],
                            "name" => $integrationName,
                            "active" => "y"
                        ];
                    }
                }
            }
        }

        if (count($clientIntegration)) {
            return \DB::table('client_integrations')->insert($clientIntegration);
        }
        return true;
    }

    /**
     * Update existing records in client integration table for funnels against integration name
     * If records not found than insert records in client integration table for funnels
     * @param $integrationName
     * @return bool
     */
    public function updateOrInsertClientIntegrations($integrationName, $client_id, $status)
    {

        $existingClientIntegrations = \DB::table('client_integrations')
            ->select(\DB::raw("CONCAT(leadpop_id, '~', leadpop_vertical_id, '~', leadpop_vertical_sub_id, '~', leadpop_template_id, '~', leadpop_version_id, '~', leadpop_version_seq) as funnel_key"))
            ->where("name", $integrationName)
            ->where("client_id", $client_id)
            ->get();

        $existingClientIntegrations = $existingClientIntegrations->pluck('funnel_key')->toArray();
        $funnels = \LP_Helper::getInstance()->getFunnels();

        $newClientIntegrations = [];
        foreach ($funnels as $vertical_id => $v_funnels) {
            foreach ($v_funnels as $vs_funnels) {
                foreach ($vs_funnels as $v_sub_id => $funnel_info) {
                    foreach ($funnel_info as $client_leadpop_id => $funnel) {
                        $funnelKey = $funnel['leadpop_id'] . '~' . $funnel['leadpop_vertical_id'] . '~' . $funnel['leadpop_vertical_sub_id'] . '~' .
                            $funnel['leadpop_template_id'] . '~' . $funnel['leadpop_version_id'] . '~' . $funnel['leadpop_version_seq'];

                        if (!in_array($funnelKey, $existingClientIntegrations)) {
                            $newClientIntegrations[] = [
                                'url' => $funnel['domain_name'],
                                'client_id' => $client_id,
                                'leadpop_id' => $funnel['leadpop_id'],
                                'leadpop_vertical_id' => $funnel['leadpop_vertical_id'],
                                'leadpop_vertical_sub_id' => $funnel['leadpop_vertical_sub_id'],
                                'leadpop_template_id' => $funnel['leadpop_template_id'],
                                'leadpop_version_id' => $funnel['leadpop_version_id'],
                                'leadpop_version_seq' => $funnel['leadpop_version_seq'],
                                "name" => $integrationName,
                                'active' => $status
                            ];
                        }
                    }
                }
            }
        }

//        \DB::enableQueryLog();
        if (count($existingClientIntegrations)) {
            \DB::table('client_integrations')
                ->where("name", $integrationName)
                ->where("client_id", $client_id)
                ->update([
                    'active' => $status
                ]);
        }
        if (count($newClientIntegrations)) {
            \DB::table('client_integrations')
                ->insert($newClientIntegrations);
        }
//        dd(\DB::getQueryLog());
        return true;
    }

    /**
     * If found than Update record in client integration table
     * If records not found than insert record in client integration table
     * @param $integrationName
     * @return bool
     */
    public function updateOrInsertClientIntegration($integrationName, $funnel_data, $status)
    {
        $attributes = [
            'client_id' => $funnel_data['client_id'],
            'leadpop_id' => $funnel_data['leadpop_id'],
            'leadpop_vertical_id' => $funnel_data['leadpop_vertical_id'],
            'leadpop_vertical_sub_id' => $funnel_data['leadpop_vertical_sub_id'],
            'leadpop_template_id' => $funnel_data['leadpop_template_id'],
            'leadpop_version_id' => $funnel_data['leadpop_version_id'],
            'leadpop_version_seq' => $funnel_data['leadpop_version_seq'],
            "name" => $integrationName
        ];

        $values = array_merge($attributes, [
            'url' => $funnel_data['funnel']['domain_name'],
            "active" => $status
        ]);

        return \DB::table('client_integrations')
            ->updateOrInsert($attributes, $values);
    }

    /**
     * Remove client integration against funnel
     * @param $integrationName
     * @param $funnel_data
     * @return mixed
     */
    public function deleteClientIntegration($integrationName, $funnel_data)
    {
        return \DB::table("client_integrations")
            ->where(\DB::raw('LOWER(name)'), $integrationName)
            ->where("client_id", $funnel_data['client_id'])
            ->where("leadpop_id", $funnel_data['leadpop_id'])
            ->where("leadpop_vertical_id", $funnel_data['leadpop_vertical_id'])
            ->where("leadpop_vertical_sub_id", $funnel_data['leadpop_vertical_sub_id'])
            ->where("leadpop_template_id", $funnel_data['leadpop_template_id'])
            ->where("leadpop_version_id", $funnel_data['leadpop_version_id'])
            ->where("leadpop_version_seq", $funnel_data['leadpop_version_seq'])
            ->delete();
    }

    /**
     * remove all integrations with name against client
     * @param $integrationName
     * @return mixed
     */
    public function deleteClientIntegrations($integrationName, $client_id)
    {
        return \DB::table("client_integrations")
            ->where(\DB::raw('LOWER(name)'), $integrationName)
            ->where("client_id", $client_id)
            ->delete();
    }

    public function updateHomebotStatus($client_id, $status)
    {
        return \DB::table("homebot")
            ->where("client_id", $client_id)
            ->update([
                'active' => ($status == "active" ? 1 : 0)
            ]);
    }


    public function activeFunnelClientIntegrations($client_id, $leadpop_id, $leadpop_vertical_id, $leadpop_vertical_sub_id, $leadpop_template_id, $leadpop_version_id, $lp_version_seq)
    {
        $integrations = [
            config('integrations.iapp.HOMEBOT')['sysname'],
            config('integrations.iapp.ZAPIER')['sysname'],
            config('integrations.iapp.TOTAL_EXPERT')['sysname']
        ];

        $clientIntegrations = \DB::table("client_integrations")
            ->select("name", \DB::raw("count(*) as count"))
            ->where("client_id", $client_id)
            ->where("leadpop_id", $leadpop_id)
            ->where("leadpop_vertical_id", $leadpop_vertical_id)
            ->where("leadpop_vertical_sub_id", $leadpop_vertical_sub_id)
            ->where("leadpop_template_id", $leadpop_template_id)
            ->where("leadpop_version_id", $leadpop_version_id)
            ->where("leadpop_version_seq", $lp_version_seq)
            ->where("active", "y")
            ->whereIn('name', $integrations)
            ->groupBy("name")
            ->get();

        $activeClientIntegrations = [];
        foreach ($clientIntegrations as $clientIntegration) {
            $activeClientIntegrations[$clientIntegration->name] = ($clientIntegration->count ? 1 : 0);
        }

        return $activeClientIntegrations;
    }

    /**
     * Update funnel URL in funnel client integrations when domain/subdomain URL is updated
     * Update funnel URL & leadpop_id when switched from subdomain to domain OR vise versa
     * @param $values
     * @param $attributes
     * @return mixed
     */
    public function updateFunnelIntegrations($values, $attributes)
    {
        $query = \DB::table('client_integrations');

        foreach ($attributes as $key => $value) {
            $query->where($key, $value);
        }

        // update
//        \DB::enableQueryLog();
        $result = $query->update($values);
//        dd(\DB::getQueryLog());
//        dd("updateFunnelIntegrations", \DB::getQueryLog());

        return $result;
    }

    /**
     * @param $client_id
     * @param $post
     * @param array $funnel_data
     * @param boolean global
     * @throws Exception
     *setCustomizedBackgroundColor swtaches and lead line color update
     */
    function customizedBackgroundColorSwatches($client_id, $post, $data = array(), $global = false)
    {
        $this->clientId = $client_id;

        $dataCollection = collect($data);
        $currentFunnelKey = "";
        if(isset($_POST['current_hash'])){
            $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);
        }
        $leadpop_ids = implode(',', $dataCollection->pluck('leadpop_id')->unique()->all());
        $leadpop_version_seq_ids = implode(',', $dataCollection->pluck('leadpop_version_seq')->unique()->all());


//        dd($leadpop_ids, $leadpop_version_seq_ids);

        $allSixnines =   GlobalHelper::getLeadLineCollection($leadpop_ids, FunnelVariables::LEAD_LINE, $client_id);

        try {
            if ($data) {
                $registry = DataRegistry::getInstance();
                $container = $registry->leadpops->clientInfo['rackspace_container'];
                $usingDefaultLogo = $this->getLeadpopsLogosData($client_id, $data);

                $rackspace_stock_assets = rackspace_stock_assets();
                $getHttpServer = $this->getHttpServer();
//               dd($usingDefaultLogo);


                $getCdnLink = getCdnLink();
                foreach ($data as $key => $funnel_data) {

                    $this->setupLeadPopsCommonVariableFromFunnelData($funnel_data);

                    $where = "client_id = $this->clientId and
                       leadpop_vertical_id = $this->leadpop_vertical_id and
                       leadpop_vertical_sub_id = $this->leadpop_vertical_sub_id and
                       leadpop_type_id = $this->leadpop_type_id and
                       leadpop_template_id = $this->leadpop_template_id and
                       leadpop_id = $this->leadpop_id and
                       leadpop_version_id = $this->leadpop_version_id and
                       leadpop_version_seq = $this->leadpop_version_seq
                   ";

                    //update background color table
                    $this->leadpopBackgroundColor($post);


                    $lp = implode('~', [$this->leadpop_vertical_id,
                        $this->leadpop_vertical_sub_id,
                        $this->leadpop_id,
                        $this->leadpop_version_seq
                    ]);

                    $sixnine = $allSixnines
                        ->where('client_id', $client_id)
                        ->where('leadpop_id', $this->leadpop_id)
                        ->where('leadpop_version_seq', $this->leadpop_version_seq)
                        ->first();

                    /**
                     * Note:Currently, we don't need to update funnel variable and primary color.
                     * if need to this functionality then we ill uncomment the queries
                     * comment from @mzac90
                     * Card: A30-2938
                     */

                    if ($sixnine && $sixnine[FunnelVariables::LEAD_LINE] != "") {
                        $sixnine = $this->getReplacedColorHtml($sixnine[FunnelVariables::LEAD_LINE], $post['hexcolor']);
                        //$this->updateLeadLine(FunnelVariables::LEAD_LINE, $sixnine[FunnelVariables::LEAD_LINE], $client_id, $this->leadpop_id, $this->leadpop_version_seq);
                    }


                    //icons name list
                    $favicon = 'favicon-circle.png';
                    $dot = 'dot-img.png';
                    $ring = 'ring.png';
                    $mvp = 'mvp-check.png';


                    $logo_color = $post['hexcolor'];
                    // Managed in single query
                    /*
                      $s = "select count(*) as cnt from leadpop_logos where  client_id = " . $client_id;
                      $s .= " and leadpop_id = " . $this->leadpop_id;
                      $s .= " and leadpop_type_id = " . $this->leadpop_type_id;
                      $s .= " and leadpop_vertical_id = " . $this->leadpop_vertical_id;
                      $s .= " and leadpop_vertical_sub_id = " . $this->leadpop_vertical_sub_id;
                      $s .= " and leadpop_template_id = " . $this->leadpop_template_id;
                      $s .= " and leadpop_version_id  = " . $this->leadpop_version_id;
                      $s .= " and leadpop_version_seq = " . $this->leadpop_version_seq;
                      $s .= " and use_default = 'y' ";*/

                    //  $usingDefaultLogo = $this->db->fetchOne($s);

                    $isUsingDefaultLogo = $usingDefaultLogo
                        ->where('leadpop_id', $this->leadpop_id)
                        ->where('leadpop_type_id', $this->leadpop_type_id)
                        ->where('leadpop_vertical_id', $this->leadpop_vertical_id)
                        ->where('leadpop_vertical_sub_id', $this->leadpop_vertical_sub_id)
                        ->where('leadpop_template_id', $this->leadpop_template_id)
                        ->where('leadpop_version_id', $this->leadpop_version_id)
                        ->where('leadpop_version_seq', $this->leadpop_version_seq)
                        ->count();

                    /* echo "<pre>";
                     print_r($collectionWhere);
                      echo "</pre>";*/

                    /*echo $key . '=> ';
                     echo  $isUsingDefaultLogo;
                     echo "<br>";
                    continue;*/

                    // one == using default logo, zero equals uploaded a  logo
//                   if ($isUsingDefaultLogo == 1) {

                    if ($isUsingDefaultLogo) {
                        $filename1 = "default-" . $this->leadpop_vertical_id . "-" . $this->leadpop_vertical_sub_id . "-" . $this->leadpop_version_id . "-";
                        $filename2 = "default-" . $this->leadpop_vertical_id . "-" . $this->leadpop_vertical_sub_id . "-" . $this->leadpop_version_id . "-";
                        $filename3 = "default-" . $this->leadpop_vertical_id . "-" . $this->leadpop_vertical_sub_id . "-" . $this->leadpop_version_id . "-";
                        $filename4 = "default-" . $this->leadpop_vertical_id . "-" . $this->leadpop_vertical_sub_id . "-" . $this->leadpop_version_id . "-";

                        // For Production
                        $favicon_location = $rackspace_stock_assets . "images/" . $filename1 . $favicon;
                        $image_location = $rackspace_stock_assets . "images/" . $filename2 . $dot;
                        $mvp_dot_location = $rackspace_stock_assets . "images/" . $filename3 . $ring;
                        $mvp_check_location = $rackspace_stock_assets . "images/" . $filename4 . $mvp;

                        //make the new icons
                        $favicon_dst_src = $rackspace_stock_assets . "images/default/" . $filename1 . $this->leadpop_version_seq . "-" . $favicon;
                        $colored_dot_src = $rackspace_stock_assets . "images/default/" . $filename2 . $this->leadpop_version_seq . "-" . $dot;
                        $mvp_dot_src = $rackspace_stock_assets . "images/default/" . $filename3 . $this->leadpop_version_seq . "-" . $ring;
                        $mvp_check_src = $rackspace_stock_assets . "images/default/" . $filename4 . $this->leadpop_version_seq . "-" . $mvp;

                        //make new file url
                        $favicon_dst = $getHttpServer . '/images/' . $filename1;
                        $colored_dot = $getHttpServer . 'images/' . $filename2;
                        $mvp_dot = $getHttpServer . 'images/' . $filename3;
                        $mvp_check = $getHttpServer . 'images/' . $filename4;

                        //update leadpop_logos column values
                        $leadpop_logos_columns = array('default_colored' => 'y', 'logo_color' => $logo_color);
                        $where .= " and use_default = 'y'";

                    }
                    else {
                        $filename = strtolower($client_id . "_"
                            . $this->leadpop_id . "_"
                            . $this->leadpop_type_id . "_"
                            . $this->leadpop_vertical_id . "_"
                            . $this->leadpop_vertical_sub_id . "_"
                            . $this->leadpop_template_id . "_"
                            . $this->leadpop_version_id . "_"
                            . $this->leadpop_version_seq);

                        $favicon_location = $rackspace_stock_assets . "images/" . $favicon;
                        $image_location = $rackspace_stock_assets . "images/" . $dot;
                        $mvp_dot_location = $rackspace_stock_assets . "images/" . $ring;
                        $mvp_check_location = $rackspace_stock_assets . "images/" . $mvp;

                        //icons new name
                        $new_favicon = '_' . $favicon;
                        $new_dot = '_' . $dot;
                        $new_ring = '_' . $ring;
                        $new_mvp = '_' . $mvp;

                        //make the new icons
                        //image 1 folder path add when globally update logo
                        if ($global == true) {
                            $image1 = 'images1/';
                        } else {
                            $image1 = '';
                        }
                        $favicon_dst_src = $image1 . substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . $new_favicon;
                        $colored_dot_src = $image1 . substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . $new_dot;
                        $mvp_dot_src = $image1 . substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . $new_ring;
                        $mvp_check_src = $image1 . substr($client_id, 0, 1) . '/' . $client_id . '/logos/' . $filename . $new_mvp;

                        //make new file url
                        $colored_dot = $getCdnLink . '/logos/' . $filename . $new_dot;
                        $favicon_dst = $getCdnLink . '/logos/' . $filename . $new_favicon;
                        $mvp_dot = $getCdnLink . '/logos/' . $filename . $new_ring;
                        $mvp_check = $getCdnLink . '/logos/' . $filename . $new_mvp;

                        //update leadpop_logos column values
                        $leadpop_logos_columns = array('default_colored' => 'n', 'logo_color' => $logo_color);
                        $where .= " and use_me = 'y'";

                    }
                    if (isset($logo_color) && $logo_color != "") {
                        $new_clr = $this->hex2rgb($logo_color);
                    }

                    $myRed = $new_clr[0] ?? '#3c489e';
                    $myGreen = $new_clr[1] ?? '#3c489e';
                    $myBlue = $new_clr[2] ?? '#3c489e';


                    // upload icon on rackspace through gearman process when global setting enable
//                    if ($global == true) {
//                        if (getenv('APP_ENV') != "local") {
//                            MyLeadsEvents::getInstance()->colorizeBasedOnAplhaChannnel($container, $image_location, $myRed, $myGreen, $myBlue, $colored_dot_src, $client_id, "icons--" . $lp);
//                            MyLeadsEvents::getInstance()->colorizeBasedOnAplhaChannnel($container, $favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src, $client_id, "icons--" . $lp);
//                            MyLeadsEvents::getInstance()->colorizeBasedOnAplhaChannnel($container, $mvp_dot_location, $myRed, $myGreen, $myBlue, $mvp_dot_src, $client_id, "icons--" . $lp);
//                            MyLeadsEvents::getInstance()->colorizeBasedOnAplhaChannnel($container, $mvp_check_location, $myRed, $myGreen, $myBlue, $mvp_check_src, $client_id, "icons--" . $lp);
//                        }
//                    } // upload icon on rackspace through myleads code
//                    else {
//                          $this->colorizeBasedOnAplhaChannnel($image_location, $myRed, $myGreen, $myBlue, $colored_dot_src);
//                          $this->colorizeBasedOnAplhaChannnel($favicon_location, $myRed, $myGreen, $myBlue, $favicon_dst_src);
//                          $this->colorizeBasedOnAplhaChannnel($mvp_dot_location, $myRed, $myGreen, $myBlue, $mvp_dot_src);
//                          $this->colorizeBasedOnAplhaChannnel($mvp_check_location, $myRed, $myGreen, $myBlue, $mvp_check_src);
//                    }


                    //update funnel variables in client_leadpops table
                    $design_variables = array();
                    $design_variables[FunnelVariables::LOGO_COLOR] = $logo_color;
                    $design_variables[FunnelVariables::COLORED_DOT] = $colored_dot;
                    $design_variables[FunnelVariables::MVP_DOT] = $mvp_dot;
                    $design_variables[FunnelVariables::MVP_CHECK] = $mvp_check;
                    $design_variables[FunnelVariables::FAVICON_DST] = $favicon_dst;


                    ///////$this->updateFunnelVariables($design_variables, $client_id, $this->leadpop_id, $this->leadpop_version_seq);

                    //update the leadpop_logos table with new values
                    $query = "UPDATE leadpop_logos set default_colored = 'n',  logo_color = '$logo_color' where $where";
                    ///////Query::execute($query, $currentFunnelKey);
                }
                return "ok";
            } else {
                return "Something went wrong. Please try again.";
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * replace CSS color in provided HTML
     * @param $html
     * @param $newColor
     * @return string|string[]|null
     */
    public function getReplacedColorHtml($html, $newColor, $reColor = '/color:(.*?);/m')
    {
        $html = str_replace(';;', ';', $html);
        $html = str_replace(': #', ':#', $html);

        if (strpos($html, "span #") !== false) {
            // Fix: broken funnel
            $html = preg_replace('/span #(.*?)font-family/m', 'span style="font-family', $html);
        }

        $firstStr = 'color:';
        if (strpos($html, $firstStr) !== false) {
            $first = strpos($html, $firstStr);
            $first += strlen($firstStr);
            $closing_tag = strpos($html, '>', $first) - 1;
            if (strpos($html, ';', $first) === false) {
                $sec = $closing_tag;
            } else {
                $sec = strpos($html, ';', $first);
                //Fix: if semicolon not exist in CSS but in text
                if ($closing_tag < $sec) {
                    $sec = $closing_tag;
                } else if (isset($html[$sec]) && $html[$sec] == ";") {
                    return preg_replace($reColor, "color:" . $newColor . ";", $html);
                }
            }

            $to_replace = substr($html, $first, ($sec - $first));
            return str_replace($to_replace, $newColor, $html);
        }
        return $html;
    }


    private function leadpopBackgroundColor($post)
    {

        $background_type = $post['background_type'];
        $background_custom_color = $post['colorValue'];
        $color_mode = $post['colorMode'];
        $background_overlay_opacity = $post['background_overlay_opacity'];

        $currentFunnelKey = "";
        if(@isset($_POST['current_hash'])){
            $currentFunnelKey = @LP_Helper::getInstance()->getFunnelKeyStringFromHash(@$_POST['current_hash']);
        }

        $where = " `client_id` = '$this->clientId' and
                       `leadpop_version_id` = '$this->leadpop_version_id' and
                       `leadpop_version_seq` = '$this->leadpop_version_seq'
                   ";
        $leadpop_background_color_columns = array(
            'background_type' => $post['background_type'],
            'background_custom_color' => $post['colorValue'],
            'color_mode' => $post['colorMode'],
            'background_overlay_opacity' => $post['background_overlay_opacity']
        );
        //    extract($leadpop_background_color_columns);

        //update background color table
        $query = "UPDATE `leadpop_background_color` set `background_type` = '$background_type' ,
 `background_custom_color` = '$background_custom_color' ,
  `color_mode` = '$color_mode',
   `background_overlay_opacity` = '$background_overlay_opacity'
    where $where";


       // \DB::enableQueryLog();
       // $res = $this->db->query($query);
        Query::execute($query, $currentFunnelKey);
       // $res1 = $this->db->update('leadpop_background_color', $leadpop_background_color_columns, $where);
      //  dd(\DB::getQueryLog(), $query);

    }


    private function getLeadpopsLogosData($client_id, $data)
    {

        $dataCollection = collect($data);


        $leadpop_ids = implode(',', $dataCollection->pluck('leadpop_id')->unique()->all());
        $leadpop_type_ids = implode(',', $dataCollection->pluck('leadpop_type_id')->unique()->all());
        $leadpop_vertical_ids = implode(',', $dataCollection->pluck('leadpop_vertical_id')->unique()->all());
        $leadpop_vertical_sub_ids = implode(',', $dataCollection->pluck('leadpop_vertical_sub_id')->unique()->all());
        $leadpop_template_ids = implode(',', $dataCollection->pluck('leadpop_template_id')->unique()->all());
        $leadpop_version_ids = implode(',', $dataCollection->pluck('leadpop_version_id')->unique()->all());
        $leadpop_version_seqs = implode(',', $dataCollection->pluck('leadpop_version_seq')->unique()->all());


//        $s = "select count(*) as cnt from leadpop_logos where  client_id = " . $client_id;
        $s = "select leadpop_id, leadpop_type_id, leadpop_vertical_id, leadpop_vertical_sub_id, leadpop_template_id, leadpop_version_id, leadpop_vertical_sub_id, leadpop_template_id, leadpop_version_id, use_default, leadpop_version_seq from leadpop_logos where  client_id = " . $client_id;
        $s .= " and leadpop_id  in (" . $leadpop_ids . " )";
        $s .= " and leadpop_type_id in ( " . $leadpop_type_ids . " )";
        $s .= " and leadpop_vertical_id in  ( " . $leadpop_vertical_ids . " )";
        $s .= " and leadpop_vertical_sub_id in ( " . $leadpop_vertical_sub_ids . " )";
        $s .= " and leadpop_template_id in ( " . $leadpop_template_ids . " )";
        $s .= " and leadpop_version_id in  (  " . $leadpop_version_ids . " )";
        $s .= " and leadpop_version_seq in ( " . $leadpop_version_seqs . " )";
        $s .= " and use_default = 'y' ";

      //  dd($s, $data);


        $usingDefaultLogo = $this->db->fetchAll($s); // one == using default logo, zero equals uploaded a  logo

        return collect($usingDefaultLogo);

        // dd($usingDefaultLogo);


    }

    /**
     * get default thank you content against leadpop_vertical_id and leadpop_vertical_sub_id
     * @param $funnel_data
     * @return array|bool
     */
    function getDefaultThankyouContent($funnel_data){
        $registry = DataRegistry::getInstance();
        if($registry->leadpops->clientInfo['is_mm'] == 1){
            $table = 'thankyou_defaults_mm';
        }
        else if($registry->leadpops->clientInfo['is_fairway'] == 1){
            $table = 'thankyou_defaults_fairway';
        }
        else{
            $table = 'thankyou_defaults';
        }
        $s = "SELECT html from $table WHERE leadpop_vertical_id = '".$funnel_data['leadpop_vertical_id']."' and leadpop_vertical_sub_id = '".$funnel_data['leadpop_vertical_sub_id']."'";
        return $this->db->fetchRow($s);
    }

    /**
     * Fix issue with review template
     */
    public function fixExtraContentHtml(&$advanceHtml){
        // Review template circle image issue fix
        if(strpos($advanceHtml,"lp-contact-review") !== false &&
            strpos($advanceHtml,"lp-contact-review__img") !== false) {
            $widthStyle = "width:";
            $heightStyle = "height:";
            $str = 'lp-contact-review__img';
            $startingPos = strpos($advanceHtml, $str);
            while($startingPos !== false) {
                $endingPos = strpos($advanceHtml, "</span>", $startingPos);
                $startingPos += strlen($str) + 2;
                $image = substr($advanceHtml, $startingPos, ($endingPos - $startingPos));
                if(strpos($image, "style") !== false) {
                    $newImage = $this->fixReviewTemplateImageStyle($image, $widthStyle, $heightStyle);
                    $newImage = $this->fixReviewTemplateImageStyle($newImage, $heightStyle, $widthStyle);
                    $advanceHtml = str_replace($image, $newImage, $advanceHtml);
                }
                $startingPos = strpos($advanceHtml, $str, $endingPos);
            }
        }
    }

    /**
     * This will add CSS width/height style on image
     * @param $image
     * @param $searchStyle
     * @param $addStyle
     * @return $image
     */
    private function fixReviewTemplateImageStyle($image, $searchStyle, $addStyle) {
        $first = strpos($image, $searchStyle);
        if($first !== false && strpos($image, $addStyle) === false) {
            $sec = strpos($image, ";", $first);
            if($sec !== false) {
                $styles = substr($image, $first, ($sec - $first));
                $first += strlen($searchStyle);
                $styleValue = substr($image, $first, ($sec - $first));
                return str_replace($styles, $styles.";" . $addStyle.$styleValue, $image);
            }
        }
        return $image;
    }
}
