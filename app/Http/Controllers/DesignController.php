<?php

namespace App\Http\Controllers;

use App\Constants\Layout_Partials;
use App\Constants\FunnelVariables;
use App\Helpers\CustomErrorMessage;
use App\Repositories\CustomizeDesignRepositoryAdminThree;
use Illuminate\Support\Facades\Validator;
use App\Constants\LP_Constants;
use App\Repositories\CustomizeRepository;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\GlobalRepository;
use LP_Helper;
use Session;
use App\Models\LeadpopBackgroundColor;

class DesignController extends BaseController
{

    private $Default_Model_Customize, $global_obj;
    private $lpAdmin;
    private $customizeDesignRepoAdminThree;

    public function __construct(LpAdminRepository $lpAdmin,
                                CustomizeRepository $customtizeRepo,
                                CustomizeDesignRepositoryAdminThree $customizeDesignAdminThree,
                                GlobalRepository $global_obj)
    {
        $this->middleware(function ($request, $next) use ($lpAdmin, $customtizeRepo) {
            $this->Default_Model_Customize = $customtizeRepo;
            $this->lpAdmin = $lpAdmin;
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(Session::get('leadpops'));
            $this->init($lpAdmin);
            if ($request->ajax()) $this->check_ajax_session(); else $this->check_session();
            return $next($request);
        });
        $this->customizeDesignRepoAdminThree = $customizeDesignAdminThree;
        $this->global_obj = $global_obj;
    }

    public function getinitialswatches(Request $request)
    {
        $client_id = $request->input("client_id");
        $funneldataencode = $request->input("funneldata");
        $funnel_data = json_decode($funneldataencode, true);
        $swatches = $this->Default_Model_Customize->getInitialSwatches($client_id, $funnel_data);
        print($swatches);
    }

    private function setCommonDataForView($hash_data, $session)
    {
        $customize = $this->Default_Model_Customize;
        $this->data->customVertical_id = $hash_data["funnel"]["leadpop_vertical_id"];
        $this->data->customSubvertical_id = $hash_data["funnel"]["leadpop_vertical_sub_id"];
        $this->data->customVertical = $hash_data["funnel"]["lead_pop_vertical"];
        $this->data->customSubvertical = $hash_data["funnel"]["lead_pop_vertical_sub"];
        $this->data->customLeadpopid = $hash_data["funnel"]["leadpop_id"];
        $this->data->customLeadpopVersionseq = $hash_data["funnel"]["leadpop_version_seq"];
        if (isset($session->popdescription))
            $this->data->popdescription = $session->popdescription;
        $this->data->lpkeys = $this->getLeadpopKey($hash_data);
        $this->data->client_id = $hash_data["funnel"]["client_id"];
        $this->data->workingLeadpop = $hash_data["funnel"]["domain_name"];
        $key = $hash_data["funnel"]["lead_pop_vertical"] . "~" . $hash_data["funnel"]["lead_pop_vertical_sub"] . "~" . $hash_data["funnel"]["leadpop_id"] . "~" . $hash_data["funnel"]["leadpop_version_seq"] . "~" . $hash_data["funnel"]["client_id"];
        $this->data->clickedkey = $this->data->lpkeys;
        if (isset($session->clickedkey))
            $this->data->clickedkey = $session->clickedkey;
        $this->data->clientName = ucfirst($session->clientInfo->first_name) . " " . ucfirst($session->clientInfo->last_name);
        $this->data->groupname = $hash_data['funnel']['group_name'];
        $this->data->unlimitedDomains = $customize->checkUnlimitedDomains($hash_data["funnel"]["client_id"], $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"]);
        $this->data->currenturl = LP_Helper::getInstance()->getCurrentUrl();
        $this->data->currenturlstatus = $customize->getLeadpopStatusV2($hash_data);
        $this->data->cloneLeadpop = $session->cloneLeadpop;
        $this->data->vertical_id = $hash_data["funnel"]["leadpop_vertical_id"];
        $this->data->subvertical_id = $hash_data["funnel"]["leadpop_vertical_sub_id"];
        $this->data->currenthash = $hash_data["current_hash"];
        // switch menu varible
        $enterprise = array(7); // this array determins if you switch the menu to exclude items because enterprise page.
        if (in_array($this->data->vertical_id, $enterprise)) {
            $this->data->switchmenu = 'y';
        } else {
            $this->data->switchmenu = 'n';
        }
        $this->data->currenthash = $hash_data["current_hash"];
        return;
    }

    public function logoAction(Request $request)
    {
        LP_Helper::getInstance()->getCurrentHashData();

        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);

            if (getenv('APP_THEME') != "theme_admin3") {
                array_push($this->assets_css, LP_BASE_URL . config('view.theme_assets') . "/css/combinelogo.css");
                array_push($this->assets_js, LP_BASE_URL . config('view.theme_assets') . "/external/jquery-ui.min.js");
                array_push($this->assets_js, LP_BASE_URL . config('view.theme_assets') . "/external/color-thief.js");
                array_push($this->assets_css, LP_BASE_URL . config('view.theme_assets') . "/external/jquery-ui.min.css");
                array_push($this->assets_js, LP_BASE_URL . config('view.theme_assets') . "/external/jquery.base64.min.js");
                array_push($this->assets_js, LP_BASE_URL . config('view.theme_assets') . "/external/gradient-parser.js");
                array_push($this->assets_js, LP_BASE_URL . config('view.theme_assets') . "/external/tinycolor.js");
                array_push($this->assets_js, LP_BASE_URL . config('view.theme_assets') . "/external/bootstrap.touchspin.min.js");
            }
            $r = $request->get('u');
            if (isset($r) && $r == "0") {
                $this->data->badupload = 1;
            } else {
                $this->data->badupload = 0;
            }
            $s = "select * from leadpops where id = " . $hash_data["leadpop_id"];
            $lpres = $this->db->fetchRow($s);

            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            $leadpop_type_id = $lpres['leadpop_type_id'];
            $funnel_data = $hash_data["funnel"];
            $this->data->key = $funnel_data["client_id"] . '~' . $funnel_data["leadpop_vertical_id"] . '~' . $funnel_data["leadpop_vertical_sub_id"] . '~' . $funnel_data["leadpop_id"] . '~' . $funnel_data["leadpop_version_seq"] . '~' . $funnel_data["leadpop_template_id"] . '~' . $funnel_data["leadpop_version_id"] . '~' . $funnel_data["leadpop_type_id"];

            $this->data->logouploaded = @$this->registry->leadpops->logouploaded;
            $this->registry->leadpops->logouploaded = "";
            $this->data->logos = $this->Default_Model_Customize->getLogoSources($funnel_data);
            $stock = $this->Default_Model_Customize->getStockLogoSources($funnel_data["client_id"], $funnel_data);
            $astock = explode("~", $stock);
            $this->data->stocklogopath = $astock[2];
            $this->data->stocklogosource = $astock[1];
            $this->data->stocklogoid = $astock[0];
            $this->data->stocklogoswatches = $astock[3];
            ## NO NEED FOR THIS, we already have function [getCurrentLogoImageSource] call in view
            ## $this->data->logoids = $this->Default_Model_Customize->getCurrentLogoIds($this->registry->leadpops->client_id, $funnel_data);
            if ($this->registry->leadpops->client_id == 1348) {
                $this->data->bgimage_active = $this->Default_Model_Customize->checkActiveBackgroundImage($this->registry->leadpops->client_id, $funnel_data);
            }
            //debug($this->registry->leadpops->imagedeleted);

            $this->data->funnelData = $funnel_data;
            $this->active_menu = LP_Constants::LOGO;
            return $this->response();
        } else {
            return $this->_redirect();
        }
    }
    /*************************************************************************************************
     * New Code For Admin 3.0 (Auto Pull Logo Color And Customize your own color in background page.)
     *************************************************************************************************/

    /*
     * Save Previously Used Colors In Db (Max 8)
     * @param $request
     * @param $funnel_data
     * */
    private function savePreviouslyUsedColors(Request $request, $funnel_data)
    {

        $data = $this->getInitialData($request->get('client_id'), $funnel_data, []);

        $query = LeadpopBackgroundColor::where('client_id', $request->get('client_id'));

        foreach ($data as $key => $value) {
            $query->where($key, $value);
        }

        $select_query = $query;
        $result = $select_query->select('previously_used_colors')->first();

//      Check if there is any data in db in prevopusly_used_colors column
        if ($result && $result->previously_used_colors) {
            $previously_used_colors = json_decode($result->previously_used_colors);
            if (!in_array($request->get('background-overlay'), $previously_used_colors)) {
                array_push($previously_used_colors, $request->get('background-overlay'));
                if (count($previously_used_colors) == 9) {
                    array_shift($previously_used_colors);
                }
                $data_to_update['previously_used_colors'] = json_encode($previously_used_colors);
                $query->update($data_to_update);
            }
        } else {
            $previously_used_colors = json_encode(array($request->get('background-overlay')));
            $data_to_update['previously_used_colors'] = $previously_used_colors;
            $query->update($data_to_update);
        }
    }

    /*
     * Get Initial Data function is used to combine and add required fields while quering any data.
     * @param $client_id
     * @param $funnel_data
     * $param $data
     * returns $data
     * */
    private function getInitialData($client_id, $funnel_data, $data = [])
    {
        $data["client_id"] = $client_id;
        $data["leadpop_vertical_id"] = $funnel_data["leadpop_vertical_id"];
        $data["leadpop_vertical_sub_id"] = $funnel_data["leadpop_vertical_sub_id"];
        $data["leadpop_type_id"] = $funnel_data["leadpop_type_id"];
        $data["leadpop_template_id"] = $funnel_data["leadpop_template_id"];
        $data["leadpop_id"] = $funnel_data["leadpop_id"];
        $data["leadpop_version_id"] = $funnel_data["leadpop_version_id"];
        $data["leadpop_version_seq"] = $funnel_data["leadpop_version_seq"];
        return $data;
    }

    /*
     * Set customized background color (Used in HTTP POST request)
     * @param $request
     * */
    public function setCustomizedBackgroundColor(Request $request)
    {
        LP_Helper::getInstance()->getCurrentHashData($request->input("current_hash"));


        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $funnel_data = array($hash_data['funnel']);
            // Setting initial data to check if exists or not
            $response = $this->Default_Model_Customize->customizedBackgroundColorSwatches($request->get('client_id'), $_POST, $funnel_data);
            if ($response == 'ok') {
                return $this->successResponse('Background Color has been saved.');
            } else {
                return $this->errorResponse($response);
            }
        } else {
            /* error message */
            return $this->errorResponse('Your request was not processed. Please try again.');
        }
    }

    /*
     * Get logo colors (Used in HTTP GET request)
     * @param $request
     * */
    public function getLogoColors($funnel_data)
    {

        $colors = \DB::table("leadpop_background_swatches")
            ->select('id', 'swatch')
            ->where("client_id", $funnel_data['client_id'])
            ->where("leadpop_version_id", $funnel_data['leadpop_version_id'])
            ->where("leadpop_version_seq", $funnel_data['leadpop_version_seq'])
            ->get();


        return json_encode($colors);
    }


    private function getDefaultLogoName($funnel_data)
    {
        $registry = DataRegistry::getInstance();

        if ($registry->leadpops->clientInfo['is_fairway'] == 1)
            $trial_launch_defaults = "trial_launch_defaults_fairway";
        else if ($registry->leadpops->clientInfo['is_mm'] == 1)
            $trial_launch_defaults = "trial_launch_defaults_mm";
        else
            $trial_launch_defaults = "trial_launch_defaults";

        // get trial info from version_seq = 1 because if funnel is cloned manny times the higher version_seq not exist in trial tables
        $default = \DB::table($trial_launch_defaults)
            ->where("leadpop_vertical_sub_id", $funnel_data['leadpop_vertical_sub_id'])
            ->where("leadpop_version_id", $funnel_data['leadpop_version_id'])
            ->orderBy('leadpop_version_seq', 'asc')
            ->first();
        $defaultlogoname = '';
        if ($default) {
            $defaultlogoname = $default->logo_name;
        }
        return $defaultlogoname;
    }

    /*************************************************************************************************
     ******************************** New Code For Admin 3.0 Ends here *******************************
     *************************************************************************************************/

    public function uploadlogo(Request $request)
    {


        LP_Helper::getInstance()->getCurrentHashData();

        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        if (LP_Helper::getInstance()->getCurrentHash()) {
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
            $client_id = $request->input("client_id");
            $defaultlogoname = $this->getDefaultLogoName($funnel_data);

            $imagesCount = \DB::table("leadpop_logos")
                ->where("client_id", $client_id)
                ->where("leadpop_id", $funnel_data['funnel']['leadpop_id'])
                //              ->where("leadpop_type_id", $funnel_data['leadpop_type_id'])
                ->where("leadpop_version_id", $funnel_data['leadpop_version_id'])
                ->where("leadpop_version_seq", $funnel_data['leadpop_version_seq'])
                ->where('logo_src', '!=', $defaultlogoname)
                ->where("logo_src", "NOT LIKE", "%default/images/%")
                ->where("logo_src", "NOT LIKE", "%itclix.com/images/%")
                ->count();
            if ($imagesCount >= 3) {
                return $this->errorResponse(CustomErrorMessage::getInstance()->getByKey("logos_count"));
            }

            $rules = [
                'logo' => "mimes:gif,jpeg,jpg,png|file|max:" . config('validation.logo_image_size')
            ];

            if ($request->input('uploadlogotype') == 'combine') {
                $rules = [
                    'pre-image' => "mimes:gif,jpeg,jpg,png|file|max:" . config('validation.logo_image_size'),
                    'post-image' => 'mimes:gif,jpeg,jpg,png|file|max:' . config('validation.logo_image_size')
                ];
            }
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $message = CustomErrorMessage::getInstance()->setFirstError($validator);
                return $this->errorResponse($message);
            }
            $swatches = $request->input("swatches");
            if ($request->input('uploadlogotype') == '' || $request->input('uploadlogotype') == null) {
                $res = $this->Default_Model_Customize->uploadlogo($_FILES, $client_id, $funnel_data, $swatches);
            }
            if ($request->input('uploadlogotype') == 'combine') {
                $res = $this->Default_Model_Customize->uploadcombinelogos($request, $_FILES, $funnel_data);
            }
            if (isset($res) && $res['status']) {
                $this->updateFunnelTimestamp(array("client_id" => $client_id, "client_leadpop_id" => $funnel_data['client_leadpop_id']));
                $this->registry->leadpops->logouploaded = 'y';
                /* success message */
                return $this->successResponse('Logo has been saved.', $res['data']);
            } else {
                /* error message */
                return $this->errorResponse('Your request was not processed. Please try again.');
            }
        } else {
            /* error message */
            return $this->errorResponse('Your request was not processed. Please try again.');
        }
    }


    public function changelplogo(Request $request)
    {
        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {

            $client_id = $request->input("client_id");
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
            $return_val = $this->Default_Model_Customize->changelplogo($client_id, $request, $funnel_data['funnel']);
            if ($return_val) {
                $logo_url = \View_Helper::getInstance()->getCurrentLogoImageSource($this->client_id, 0, $funnel_data['funnel']);
                if ($logo_url) {
                    $this->Default_Model_Customize->updateThankYouPageLogo($logo_url, $funnel_data['funnel']);
                }
                /* success message */
                return $this->successResponse('Logo has been updated.');
            } else {
                /* error message */
                return $this->errorResponse('Your request was not processed. Please try again.');
            }
        } else {
            /* error message */
            return $this->errorResponse('Your request was not processed. Please try again.');
        }
    }


    public function updateLogoScale(Request $request)
    {
        LP_Helper::getInstance()->getCurrentHashData();
        $client_id = $request->input("client_id");
        $funnel_data = [];
        $scaling_defaultHeightPercentage = $request->input("scaling_defaultHeightPercentage") ;
        $scaling_maxHeightPx = $request->input("scaling_maxHeightPx") ;
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
           // dd($request->all());
            $lplist = explode(",", $request->selected_funnels);
            if (!empty($request->selected_funnels) && count($lplist)) {
                $this->customizeDesignRepoAdminThree->changelplogoScalingProperties($client_id, $request, $funnel_data['funnel']);
            } else {

                if ($request->has("logo_id")) {
                    $scaling_properties = json_encode(['maxHeight' => $scaling_maxHeightPx, 'scalePercentage' => $scaling_defaultHeightPercentage]);
                    $s = "UPDATE leadpop_logos SET scaling_properties = '" . $scaling_properties . "'";
                    $s .= " WHERE id = " . $request->input("logo_id");
                    $this->db->query($s);
                }
            }
            return $this->successResponse('Logo has been updated.');
        } else {
            /* error message */
            return $this->errorResponse('Your request was not processed. Please try again.');
        }
    }

    public function deletelogo()
    {
        $response = $this->lpAdmin->deleteLogo();
        if (true == $response['status']) {
            $data = [];
            LP_Helper::getInstance()->getCurrentHashData($_POST["current_hash"]);
            if (LP_Helper::getInstance()->getCurrentHash()) {
                $funnel_data = LP_Helper::getInstance()->getFunnelData();
                $data = \View_Helper::getInstance()->getFunnelCurrentLogo($funnel_data["funnel"]);
            }
            return $this->successResponse('Logo has been deleted.', $data);
        } else {
            return $this->errorResponse(' Your request was not processed. Please try again.');
        }
    }

    public function backgroundAction()
    {
        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            // Below code is not for admin 3
            if (getenv('APP_THEME') != "theme_admin3") {
                //array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/jquery.ics-gradient-editor-combo.js");
                array_push($this->assets_js, LP_BASE_URL . config('view.theme_assets') . "/external/color-thief.js");
                array_push($this->assets_js, LP_BASE_URL . config('view.theme_assets') . "/external/spectrum.js");
                array_push($this->assets_js, LP_BASE_URL . config('view.theme_assets') . "/external/jquery.base64.min.js");
                array_push($this->assets_js, LP_BASE_URL . config('view.theme_assets') . "/external/gradient-parser.js");
                array_push($this->assets_js, LP_BASE_URL . config('view.theme_assets') . "/external/tinycolor.js");
                array_push($this->assets_js, LP_BASE_URL . config('view.theme_assets') . "/external/bootstrap.touchspin.min.js");
                //array_push($this->assets_css, LP_BASE_URL.config('view.theme_assets')."/external/jquery.ics-gradient-editor-combo.min.css");
                array_push($this->assets_css, LP_BASE_URL . config('view.theme_assets') . "/external/spectrum.css");
                $this->inline_css = "
                .ics-ge-container .ics-ge-swatches .ics-ge-save,
                .ics-ge-linear-direction-implicit .btn:first-of-type,
                .ics-ge-linear-direction-implicit .btn:last-of-type,
                .ics-ge-linear-direction-implicit .btn-sm,
                .css-gradient-repeating,
                .css-gradient-type,
                .ics-ge-container .ics-ge-controller.active.ics-ge-direction-angle,
                .ics-ge-container span.ics-ge-direction-angle,
                .ics-ge-linear-direction-implicit.mid .btn{
                    display:none;
                }";
            }
            $this->data->logouploaded = @$this->registry->leadpops->logouploaded;
            $this->registry->leadpops->logouploaded = "";
            $customize = $this->Default_Model_Customize;
            list($this->data->clientLogo, $this->data->generateLogo) = explode("~", $customize->determineLogoUseAndNeedCreateSwatches($this->registry->leadpops->client_id, $hash_data["funnel"]));
            $this->data->backgroungOptions = $customize->getBackgroundImageOptions($this->registry->leadpops->client_id, $hash_data["funnel"]);
            $this->data->backgroungSwatches = $this->getLogoColors($hash_data["funnel"]);
            unset($hash_data["funnel"]['sticky_cta']);
            unset($hash_data['funnel']['sticky_attributes']);
            unset($hash_data['funnel']['lead_line']);
            unset($hash_data['funnel']['second_line_more']);
            $this->data->funnelData = $hash_data["funnel"];
            $this->active_menu = LP_Constants::BACKGROUND;
            $this->inline_js = "$('.colorSelector').ColorPickerSetColor('" . @$this->data->backgroungOptions[0]['background_overlay'] . "')";
            return $this->response();
        } else {
            return $this->_redirect();
        }
    }
//
//    public function updatebackgroundcolors(Request $request)
//    {
//        $client_id = $request->input("client_id");
//        $funneldataencode = $request->input("funneldata");
//        $background_type = $request->input("background_type");
//        $funnel_data = json_decode($funneldataencode, true);
//        $return_val = $this->Default_Model_Customize->updateBackgroundColors($client_id, $request, $funnel_data);
//        $this->updateFunnelTimestamp(array("client_id" => $client_id, "client_leadpop_id" => $funnel_data['client_leadpop_id']));
//        //$return_val=array('leadpop_bk_clr_qry' => "count",'query'=>"sdsd" );
//        echo json_encode($return_val);
//        //echo TRUE;
//    }

    public function updatebackgroundcolors(Request $request)
    {
//        Validating data
        $validatedData = $request->validate([
            'background' => 'required',
            'background_type' => 'required',
            'client_id' => 'required',
            'current_hash' => 'required',
        ]);

        LP_Helper::getInstance()->getCurrentHashData($request->input("current_hash"));

        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();

            $funnel_data = $hash_data['funnel'];
            $saved = $this->Default_Model_Customize->updateBackgroundColors($request->get('client_id'), $_POST, $funnel_data);
            if ($saved) {
                $this->updateFunnelTimestamp(array("client_id" => $validatedData['client_id'], "client_leadpop_id" => $funnel_data['client_leadpop_id']));
                $message = config("alerts.background.auto_pull_success." . config('view.theme'));
                return $this->successResponse($message);
            } else {
                $message = config("alerts.background.auto_pull_error." . config('view.theme'));
                return $this->errorResponse($message);
            }
        } else {
            $message = config("alerts.background.auto_pull_error." . config('view.theme'));
            return $this->errorResponse($message);
        }
    }

    public function updatebackgroundimageAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'background_name' => 'mimes:jpeg,jpg,png|file|max:' . config('validation.background_image_size')
        ]);

        if ($validator->fails()) {
            $message = CustomErrorMessage::getInstance()->setFirstError($validator, "background_name");
            return $this->errorResponse($message);
        }

        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $client_id = $request->input("client_id");
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
            $res = $this->Default_Model_Customize->updatebackgroundimage($client_id, $request, $_FILES, $funnel_data['funnel']);
            if ($res == 'ok') {
                $this->savePreviouslyUsedColors($request, $funnel_data);
                $this->updateFunnelTimestamp(array("client_id" => $client_id, "client_leadpop_id" => $funnel_data['client_leadpop_id']));
                return $this->successResponse('Background Image has been updated.');
            } else {
                return $this->errorResponse('Something went wrong, please try again.');
            }
        } else {
            /* error message */
            return $this->errorResponse('Your request was not processed. Please try again.');
        }
    }

    function featuredmediaAction()
    {

        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            //$r = $this->_request->getParam('r');
            if ($this->registry->leadpops->badimageupload = 'y') {
                $this->data->badupload = 1;
            } else {
                $this->data->badupload = 0;
            }
            $this->data->funnelData = $hash_data["funnel"];
            $this->data->imageuploaded = isset($this->registry->leadpops->imageuploaded) ? $this->registry->leadpops->imageuploaded : "";
            $this->registry->leadpops->imageuploaded = "";
            $this->registry->leadpops->badimageupload = "";
            $this->active_menu = LP_Constants::FEATURED_MEDIA;
            return $this->response();
        } else {
            return $this->_redirect();
        }
    }

    public function uploadimage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logo' => 'mimes:gif,jpeg,jpg,png|file|max:' . config('validation.featured_image_size')
        ]);

        if ($validator->fails()) {
            $message = CustomErrorMessage::getInstance()->setFirstError($validator, "logo");
            return $this->errorResponse($message);
        }

        $client_id = $request->input("client_id");
        $funneldataencode = $request->input("funneldata");
        $funnel_data = json_decode($funneldataencode, true);

        // Upload Image if image file is selected
        $image_uploaded = false;
        $image_error = false;
        $response = [];
        if(isset($_FILES["logo"]["name"]) && $_FILES["logo"]["name"] != "") {
            $image_uploaded = true;
            $res = $this->Default_Model_Customize->uploadImage($_FILES, $client_id, $funnel_data, $_POST);
            if ($res['status']) {
                $response = $res['data'];
                $this->updateFunnelTimestamp(array("client_id" => $client_id, "client_leadpop_id" => $funnel_data['client_leadpop_id']));
                $this->registry->leadpops->imageuploaded = 'y';

                /* update clients_leadpops table's col last edit*/
                /* if LP_Helper::getInstance()->getFunnelData() not work then send id in parameter */
                update_clients_leadpops_last_eidt($funnel_data['client_leadpop_id']);

                /* success message */
                //Session::flash('success', '<strong>Success:</strong> Featured Image has been saved.');
            } else {
                $image_error = true;
                return $this->errorResponse('Unable to upload image.');
            }
        }


        //Update Status Case
        if (!$image_error) {
            $imagestatus = array('imagestatus' => $request->input("imagestatus"));
            if ($request->input("imagestatus") == "inactive") {
                /*
                 * Inactive case
                 */
                $this->Default_Model_Customize->deactivatelpimage($client_id, $funnel_data);
                $this->updateFunnelTimestamp(array("client_id" => $client_id, "client_leadpop_id" => $funnel_data['client_leadpop_id']));

                if ($image_uploaded) {
                    return $this->successResponse('Featured image uploaded & deactivated.', $response);
                } else {
                    return $this->successResponse('Featured image deactivated.');
                }
            } else {
                /*
                 * Active case
                 */
                $this->Default_Model_Customize->activatelpimage2($client_id, $imagestatus, $funnel_data);
                $this->updateFunnelTimestamp(array("client_id" => $client_id, "client_leadpop_id" => $funnel_data['client_leadpop_id']));

                if ($image_uploaded) {
                    return $this->successResponse('Featured image uploaded & activated.', $response);
                } else {
                    return $this->successResponse('Featured image activated.');
                }
            }
        }
    }


    public function changelpIimageScalingProperties(Request $request)
    {
        LP_Helper::getInstance()->getCurrentHashData();
        $client_id = $request->input("client_id");
        $funnel_data = [];
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
        }

        $currentFunnelKey = "";
        if(isset($_POST['current_hash'])){
            $currentFunnelKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);
        }

        if($request->has('selected_funnels'))
        $lplist = explode(",", $_POST['selected_funnels']);

        if (!empty($request->selected_funnels) && count($lplist)) {
            // Logic to add REFERENCE/SOURCE to list if not added.
            $lplist = json_decode(json_encode($lplist), 1);
            array_unshift($lplist, $currentFunnelKey);
            $lplist = array_unique($lplist);
        } else {
            $lplist = [$currentFunnelKey];
        }


        if (LP_Helper::getInstance()->getCurrentHash()) {
            $this->customizeDesignRepoAdminThree->changelpImageScalingProperties($client_id, $request, $funnel_data['funnel'], $lplist);
            if ($request['imagestatus'] == "inactive") {
                return $this->successResponse('Featured image deactivated.');
            } else {
                return $this->successResponse('Featured image has been updated.');
            }
        } else {
            /* error message */
            return $this->errorResponse('Your request was not processed. Please try again.');
        }
    }

    private function updateFunnelTimestamp($args)
    {
        $now = new \DateTime();

        $client_leadpop_id = "";
        $client_id = "";
        if (!array_key_exists('client_leadpop_id', $args)) {
            $s = "SELECT clients_leadpops.id FROM clients_leadpops INNER JOIN leadpops ON leadpops.id = clients_leadpops.leadpop_id";
            $s .= " WHERE client_id = " . $args['client_id'];
            $s .= " AND clients_leadpops.leadpop_id = " . $args['leadpop_id'];
            $s .= " AND leadpops.leadpop_vertical_id = " . $args['vertical_id'];
            $s .= " AND leadpops.leadpop_vertical_sub_id = " . $args['subvertical_id'];
            $s .= " AND leadpops.id = " . $args['leadpop_id'];
            if (array_key_exists('leadpop_template_id', $args)) $s .= " AND leadpop_template_id = " . $args['leadpop_template_id'];
            if (array_key_exists('leadpop_version_id', $args)) $s .= " AND leadpops.leadpop_version_id = " . $args['leadpop_version_id'];
            if (array_key_exists('version_seq', $args)) $s .= " and leadpop_version_seq = " . $args['version_seq'];
            if (array_key_exists('leadpop_type_id', $args)) $s .= " and leadpop_type_id = " . $args['leadpop_type_id'];
            $clientLeadpopInfo = $this->db->fetchRow($s);

            $client_id = $args['client_id'];
            $client_leadpop_id = $clientLeadpopInfo['id'];
        } else {
            $client_id = $args['client_id'];
            $client_leadpop_id = $args['client_leadpop_id'];
        }


        if ($client_leadpop_id) {
            $s = "UPDATE clients_leadpops SET date_updated = '" . $now->format("Y-m-d H:i:s") . "'";
            $s .= " WHERE client_id = " . $client_id;
            $s .= " AND id = " . $client_leadpop_id;
            $this->db->query($s);

            /* update clients_leadpops table's col last edit*/
            /* if LP_Helper::getInstance()->getFunnelData() not work then send id in parameter */
            update_clients_leadpops_last_eidt($client_leadpop_id);
        }
    }

    public function backgroundoptionstoggle()
    {
        $return_val = $this->lpAdmin->backgroundOptionsToggle();
        echo $return_val;
    }

    public function changeimageAction()
    {
        $client_id = $_POST["client_id"];
        $imagestatus = array('imagestatus' => $_POST["imagestatus"]);
        $funneldataencode = $_POST["funneldata"];
        $funnel_data = json_decode($funneldataencode, true);
        $customize = $this->Default_Model_Customize;
        $customize->activatelpimage2($client_id, $imagestatus, $funnel_data);

        $this->updateFunnelTimestamp(array("client_id" => $client_id, "client_leadpop_id" => $funnel_data['client_leadpop_id']));
        print("1");
    }

    public function changetodefaultimageAction()
    {
        $client_id = $_POST["client_id"];
        $funneldataencode = $_POST["funneldata"];
        $funnel_data = json_decode($funneldataencode, true);
        $customize = $this->Default_Model_Customize;
        $customize->deactivatelpimage($client_id, $funnel_data);

        $this->updateFunnelTimestamp(array("client_id" => $client_id, "client_leadpop_id" => $funnel_data['client_leadpop_id']));
        print("1");
    }

    public function activetodefaultimageAction()
    {
        $client_id = $_POST["client_id"];
        $funneldataencode = $_POST["funneldata"];
        $funnel_data = json_decode($funneldataencode, true);
        $customize = $this->Default_Model_Customize;

        // for leadpop_version_id = 126 on reset we will simply turn off featured image
        if ($funnel_data['leadpop_version_id'] == config('funnelbuilder.funnel_builder_version_id')) {
            $this->Default_Model_Customize->deactivatelpimage($client_id, $funnel_data);
            return $this->successResponse('Featured image deactivated.');
        } else {
            $data = $customize->activateDefaultlpimage($client_id, $funnel_data);
            return $this->successResponse("Featured media default image has been reset.", $data);
        }
    }


    function commonFooterGlobalSetting()
    {
        //  $this->header_partial=Layout_Partials::GLOBAL_CHANGE;
        //  array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/bootstrap-multiselect.js");
        // array_push($this->assets_css, LP_BASE_URL.config('view.theme_assets')."/external/bootstrap-multiselect.css");
        $this->data->client_id = $this->registry->leadpops->client_id;
        // $this->data->clientName = \View_Helper::getInstance()->getClientName($this->registry->leadpops->client_id);
        //  $this->data->clientToken = $this->global_obj->getClientToken($this->registry->leadpops->client_id);
        $this->data->globalOptions = $this->Default_Model_Customize->getGlobalOptions($this->registry->leadpops->client_id);

        /*$video_info = $this->lp_admin_model->getVideoByKey('global', 'index');
        $this->data->globalOptions['videolink'] = @$video_info["url"];
        $this->data->globalOptions['videotitle'] = @$video_info["title"];
        $this->data->globalOptions['videothumbnail'] = @$video_info["thumbnail"];
        $this->data->globalOptions['wistia_id'] = @$video_info["wistia_id"];*/


    }
}
