<?php

namespace App\Http\Controllers;

use App;
use App\Repositories\LpAdminRepository;
use App\Repositories\LeadpopsRepository;
use App\Constants\Layout_Partials;
use App\Constants\LP_Constants;
use App\Services\DataRegistry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use LP_Helper;
use stdClass;

class BaseController extends Controller{

    /** @var  App\Services\DbService $db */
    protected $db;
    protected $view, $data, $helperPath, $layout, $client_id, $db2, $flashMessenger, $is_secured,$overlay_data;

    /** @var  LpAdminRepository $lp_admin_model */
    protected $lp_admin_model;
    protected $lp_model;

    protected $assets_css = [];
    protected $inline_css = '';
    protected $assets_js = [];
    protected $inline_js = '';
    protected $body_class = [];

    /* TODO-CLEANUP */
    protected $model;
    protected $registry;
    protected $header_partial = Layout_Partials::INNER;
    protected $header_main = Layout_Partials::MAIN;
    protected $footer = Layout_Partials::FOOTER;
    protected $popup = '';
    protected $lp_helper;
    protected $allFunnel = array();
    public function init(LpAdminRepository $repo){
        $this->lp_admin_model = $repo;
        $this->db = App::make('App\Services\DbService');
        $this->data = new stdClass();
        $this->view = new stdClass();

        $this->active_menu = LP_Constants::NONE;

        $this->global_support_ticket();

        $this->lp_helper = LP_Helper::getInstance();
        $this->dashboard_v2();
        $this->allFunnel = $this->getAllLeadpops();

        if(config('app.beta_feature') && isset($this->registry->leadpops->client_id) && in_array($this->registry->leadpops->client_id, config('app.beta_clients'))){
            \Config::set('rackspace.rs_featured_image_dir', 'stockimages/featured/');
        }
    }

    protected function _redirect($route_uri='/', $flashMessage='', $flashKey=''){
        if(strpos($route_uri, "http") === false) $route_uri = env('APP_URL') . $route_uri;
        if($flashMessage != ""){
            return redirect($route_uri)->with($flashKey, $flashMessage);
        }
        else{
            return redirect($route_uri);
        }
    }


    /**
     * @deprecated 2.1.0
     * @deprecated No longer required in new base coode
     */
    private function client_admin_version_restriction(){
        $session = LP_Helper::getInstance()->getSession();
        $prefix = explode('/',$_SERVER['REQUEST_URI']);
        if(@$session->clientInfo->admin_version == 1 && $prefix[1]=='lp'){
            return $this->_redirect('/');
        }
    }

    private function global_support_ticket(){
        $issue_data = $this->lp_admin_model->getSupportIssue();
        $this->data->global_maintopic = $issue_data['maindata'];
        $this->data->global_subissuedata = $issue_data['final_data'];
    }

    private function init_controller_action_js(){
        $action = app('request')->route()->getAction();
        $controller = class_basename($action['controller']);
        list($controller, $action) = explode('@', $controller);
        $controller = strtolower(str_replace("Controller", "", $controller));
        $action = strtolower(str_replace("Action", "", $action));

        $c_action_js = strtolower($controller).".js";
        if(is_file($_SERVER['DOCUMENT_ROOT'].config('view.theme_assets')."/js/".$c_action_js)){
            array_push($this->assets_js, config('view.theme_assets')."/js/".$c_action_js);
        }

        if($this->isLoginVersionV2($controller, $action)){
            $action .= "v2";
        }
        $action_js = strtolower($action).".js";
        if(is_file($_SERVER['DOCUMENT_ROOT'].config('view.theme_assets')."/js/".strtolower($controller)."/".$action_js)){
            array_push($this->assets_js, config('view.theme_assets')."/js/".strtolower($controller)."/".$action_js);
        }

        return array("controller"=>$controller, "action"=>$action);
    }

    public function response(){
        $layout = $this->init_controller_action_js();

        $this->data->active_menu = $this->active_menu;
        if($layout['controller'] == 'index' and $layout['action'] == 'index'){
            $action = 'home';
            $controller = 'index';
        }else{
            $action = $layout['action'];
            $controller = $layout['controller'];
        }
        $video_info=$this->lp_admin_model->getVideoByKey($controller, $action);

        $this->data->videolink = @$video_info["url"];
        $this->data->videotitle = @$video_info["title"];
        $this->data->videothumbnail = @$video_info["thumbnail"];
        $this->data->wistia_id = @$video_info["wistia_id"];
        $this->data->globalVideos = $this->lp_admin_model->getVideosByKeys(['global-index', 'sticky-bars', 'settings-status']);

        $this->view->data = $this->data;
        $this->view->is_secured = $this->is_secured;
        $this->view->assets_css = $this->assets_css;
        $this->view->inline_css = $this->inline_css;
        $this->view->assets_js = $this->assets_js;
        $this->view->inline_js = $this->inline_js;
        $this->view->body_class = $this->body_class;
        $this->view->header_partial = $this->header_partial;
        $this->view->header_main = $this->header_main;
        $this->view->footer = $this->footer;
        $this->view->popup = $this->popup;
        $this->view->session = LP_Helper::getInstance()->getSession();
        $this->view->verticals = LP_Helper::getInstance()->getVerticals();

        if($this->isLoginVersionV2($layout['controller'], $layout['action'])){
            $layout['action'] .= 'v2';
        }
        return view($layout['controller'].".".$layout['action'])->with('view', $this->view);
        #return view($layout['controller'].".".$layout['action'],  json_decode(json_encode($this->view),1));
    }

    protected function check_ajax_session()
    {
        if (isset($this->registry->leadpops->ccinfo)) unset($this->registry->leadpops->ccinfo);

        if (isset($this->registry->leadpops->corp_id) && $this->registry->leadpops->corp_id != '' && (!isset($this->registry->leadpops->sublogin))) {
            $this->client_id = $this->registry->leadpops->corp_id;
            $this->registry->leadpops->client_id = $this->registry->leadpops->corp_id;
        }

        if (!isset($this->registry->leadpops->client_id) || $this->registry->leadpops->loggedIn != 1) {
            return $this->_redirect(LP_PATH . '/logout');
        } else {
            $this->is_secured = $this->registry->leadpops->clientInfo['is_secured'];
            $this->client_id = $this->registry->leadpops->client_id;

            $routeName = Route::currentRouteName();
            if($routeName == "clone_funnel_route"){
                LP_Helper::getInstance()->get_client_products();
            }
        }
    }

    public function check_session($is_home = 0)
    {
        if ($is_home) {
            if (isset($_COOKIE["loantek_session"]) && $_COOKIE["loantek_session"] != "") {
                $tempid = $this->lp_admin_model->isloantekclient($_COOKIE["loantek_session"]);
                if ($tempid != 0) {
                    $this->client_id = $tempid;
                    setcookie("loantek_session", "", time() - 3600, "/", ".leadpops.com");
                    unset($_SESSION["loantek_session"]);
                }
            }
        }

        if (isset($this->registry->leadpops->ccinfo)) unset($this->registry->leadpops->ccinfo);

        if (isset($this->registry->leadpops->corp_id) && $this->registry->leadpops->corp_id != '' && (!isset($this->registry->leadpops->sublogin))) {
            $this->client_id = $this->registry->leadpops->corp_id;
            $this->registry->leadpops->client_id = $this->registry->leadpops->corp_id;
        }
        if (!isset($this->registry->leadpops->client_id) || $this->registry->leadpops->loggedIn != 1) {
            return $this->_redirect(LP_PATH . '/logout');
        } else {
            $this->is_secured = $this->registry->leadpops->clientInfo['is_secured'];
            $this->client_id = $this->registry->leadpops->client_id;

            LP_Helper::getInstance()->_fetch_all_funnels();
            LP_Helper::getInstance()->get_client_products();
        }
    }

    protected function lp_redirect($route = ''){
        if($route != "")
            return $this->_redirect(LP_PATH.$route);
        else
            return $this->_redirect(LP_PATH.'/index');
    }

    private function dashboard_v2(){
        $registry = DataRegistry::getInstance();
        if(@$this->registry->leadpops->client_id) {
            //$acc = $this->lp_admin_model->CheckDashboardActive($this->registry->leadpops->client_id);
            $acc = $this->lp_helper->client_info;
            if($acc) {
                # tag and folder enable and disable for specify client
                if ($acc['tag_folder'] == 0) {
                    $registry->leadpops->clientInfo['tag_folder'] = 0;
                }else {
                    $registry->leadpops->clientInfo['tag_folder'] = 1;
                }
                # ALWAYS LOAD V2 DASHBOARD for ALL CLIENTS
                $registry->leadpops->clientInfo['dashboard_v2'] = 1;

                if (isset($acc['sticky_bar_v2']) and $acc['sticky_bar_v2'] == 0) {
                    $registry->leadpops->clientInfo['sticky_bar_v2'] = 0;
                } else {
                    $registry->leadpops->clientInfo['sticky_bar_v2'] = 1;
                }
            }
        }
    }

    protected function _getAltCon(){
        return new mysqli(DB2HOST,DB2USER,DB2PASS, DB2DBNAME);
    }

    private function isLoginVersionV2($controller, $action)
    {
        /**
         * Commented cookie logic to always show login design version2
         */
//        if (isset($_COOKIE['login']) && $_COOKIE['login'] == "v2") {
            if ($controller == "login" && $action == "index") {
                return true;
            } else if ($controller == "password" && $action == "newpasswordreset") {
                return true;
            }
//        }
        return false;
    }

    /**
     * get lp key from current funnel hash
     * @param $lead_data
     * @return string
     */
    protected function getLeadpopKey($lead_data)
    {
        return $lead_data["funnel"]["leadpop_vertical_id"] . "~" . $lead_data["funnel"]["leadpop_vertical_sub_id"] . "~" . $lead_data["funnel"]["leadpop_id"] . "~" . $lead_data["funnel"]["leadpop_version_seq"];
    }

    /**
     * get all leadpops rows
     * @return array
     */
    function getAllLeadpops(){
        return $this->db->fetchAll('select * from leadpops');
    }

    /**
     * success response for AJAX requests
     * @param $message
     * @param array $data
     * @param null $responseCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($message, $data = [], $responseCode = Response::HTTP_OK)
    {
        return response()->json(['status' => true, 'message' => $message, 'result' => $data], $responseCode);
    }

    /**
     * error response for AJAX requests
     * @param $message
     * @param array $data
     * @param null $responseCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message = null, $data = [], $responseCode = Response::HTTP_BAD_REQUEST)
    {
        return response()->json(['status' => false, 'error' => $message, 'result' => $data], $responseCode);
    }

    /**
     * warning response for AJAX requests
     * @param $message
     * @param array $data
     * @param null $responseCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function warningResponse($message, $data = [], $responseCode = Response::HTTP_BAD_REQUEST){

        return response()->json(['status' => false, 'warning' => $message, 'result' => $data], $responseCode);

    }

    /**
     * Get Call-to-Action Settings
     *
     * @param $hash_data
     * @param $customize
     */
    protected function loadCtaSettings($hash_data, $return_data=false) {
        $cta_object = new stdClass();
        $cta_object->fontfamilies = LP_Helper::getInstance()->getFontFamilies();

        $client_leadpops = App\Models\ClientsLeadpops::select(['lead_line', 'second_line_more'])
            ->where('client_id', $hash_data["funnel"]["client_id"])
            ->where('leadpop_id', $hash_data["funnel"]["leadpop_id"])
            ->where('leadpop_version_id', $hash_data["funnel"]['leadpop_version_id'])
            ->where('leadpop_version_seq', $hash_data["funnel"]["leadpop_version_seq"])
            ->first();

        $style_tag_start = '/style\s*=\s*[\'\"]/';
        $style_tag_end = '/\s*[\'\"]\s*>/';


        /* ** MAIN MESSAGE (CTA) Text+STYLE ** */

        ## $cta_object->homePageMessageMainMessage = stripslashes($customize->getHomePageMessageMainMessage($hash_data["funnel"]["client_id"], $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"]));
        $cta_object->homePageMessageMainMessage = html_entity_decode($client_leadpops['lead_line']);

        preg_match_all($style_tag_start, $cta_object->homePageMessageMainMessage, $style_start, PREG_SET_ORDER, 0);
        preg_match_all($style_tag_end, $cta_object->homePageMessageMainMessage, $style_end, PREG_SET_ORDER, 0);
        if (@$style_start[0][0]) {
            $pos1 = @strpos($cta_object->homePageMessageMainMessage, @$style_start[0][0]) + strlen($style_start[0][0]);
            $pos2 = @strpos($cta_object->homePageMessageMainMessage, @$style_end[0][0], $pos1);
            $style = substr($cta_object->homePageMessageMainMessage, $pos1, ($pos2 - $pos1));
            $cta_object->homePageMessageMainMessage = strip_tags($cta_object->homePageMessageMainMessage);

            $astyle = explode(";", str_replace(';;', ';', $style));

            $afontfamily = explode(":", $astyle[0]);

            if (isset($afontfamily[1])) $cta_object->fontfamily = str_replace("'", '', trim($afontfamily[1]));
            if (isset($astyle[1]))
                $afontsize = explode(":", $astyle[1]);
            if (isset($afontsize[1])) $cta_object->fontsize = trim($afontsize[1]);

            if (isset($astyle[2]))
                $acolor = explode(":", $astyle[2]);
            if (isset($acolor[1])) $cta_object->color = trim($acolor[1]);


            if (isset($astyle[3]))
                @$lineHeight = explode(":", @$astyle[3]);
            if (isset($lineHeight[1])) $cta_object->lineheight = trim(@$lineHeight[1]);
            if( empty($cta_object->lineheight)){
                $astyle[3] = 'line-height:1.42857';
                $cta_object->lineheight = '1.42857';
            }
            $style = implode(';',$astyle);
            $cta_object->messageStyle = $style;
        }
        else{
            // If message is not set
            $cta_object->fontfamily = config('funnelbuilder.cta_heading.fontfamily');
            $cta_object->fontsize = config('funnelbuilder.cta_heading.fontsize');
            $cta_object->color = config('funnelbuilder.cta_heading.color');
            $cta_object->lineheight = config('funnelbuilder.cta_heading.lineheight');
            $cta_object->messageStyle = config('funnelbuilder.cta_heading.messageStyle');
        }


        /* ** MAIN DESCRIPTION (CTA) Text+STYLE ** */
        ## $cta_object->homePageMessageDescription = stripslashes($customize->getHomePageDescriptionMessage($hash_data["funnel"]["client_id"], $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"]));
        $cta_object->homePageMessageDescription = html_entity_decode($client_leadpops['second_line_more']);

        //get start and end position of style
        if (@$style_start[0][0]) {
            preg_match_all($style_tag_start, $cta_object->homePageMessageDescription, $style_start, PREG_SET_ORDER, 0);
            preg_match_all($style_tag_end, $cta_object->homePageMessageDescription, $style_end, PREG_SET_ORDER, 0);
            $pos1 = @strpos($cta_object->homePageMessageDescription, $style_start[0][0]) + strlen($style_start[0][0]);
            $pos2 = @strpos($cta_object->homePageMessageDescription, $style_end[0][0], $pos1);
            $style = substr($cta_object->homePageMessageDescription, $pos1, ($pos2 - $pos1));
            $cta_object->homePageMessageDescription = strip_tags($cta_object->homePageMessageDescription);
            $astyle = explode(";", str_replace(';;', ';',$style));

            $afontfamily = explode(":", $astyle[0]);
            $afontsize = explode(":", $astyle[1]);
            $acolor = explode(":", $astyle[2]);

            if (isset($astyle[3]))
                @$lineHeight = explode(":", @$astyle[3]);

            if (isset($afontfamily[1])) $cta_object->dfontfamily = str_replace("'", '', trim($afontfamily[1]));
            if (isset($afontsize[1])) $cta_object->dfontsize = trim($afontsize[1]);
            if (isset($acolor[1])) $cta_object->dcolor = trim($acolor[1]);

            $cta_object->dlineheight = trim(@$lineHeight[1]);
            if(empty($cta_object->dlineheight)){
                $astyle[3] = 'line-height:1.42857';
                $cta_object->dlineheight = '1.42857';
            }
            $style = implode(';',$astyle);
            $cta_object->dmessageStyle = $style;

        }
        else{
            // If message is not set
            $cta_object->dfontfamily = config('funnelbuilder.cta_description.fontfamily');
            $cta_object->dfontsize = config('funnelbuilder.cta_description.fontsize');
            $cta_object->dcolor = config('funnelbuilder.cta_description.color');
            $cta_object->dlineheight = config('funnelbuilder.cta_description.lineheight');
            $cta_object->dmessageStyle = config('funnelbuilder.cta_description.messageStyle');
        }

        array_push($this->assets_js, LP_BASE_URL . config('view.theme_assets') . "/external/auto-resize/autosize.min.js");

        // fixing issue if no font set for cta main message or description then use default fonts
        if (!isset($cta_object->fontfamily) || trim($cta_object->fontfamily) == '') {
            $cta_object->fontfamily = 'Fjalla One';
        }
        if (!isset($cta_object->dfontfamily) || trim($cta_object->dfontfamily) == '') {
            $cta_object->dfontfamily = 'Open Sans';
        }

        if($return_data){
            return $cta_object;
        } else {
            $this->data = (object) array_merge((array) $this->data, (array) $cta_object);
        }
    }


    /**
     * This function gets the funnel Questions and return question preview source file
     *
     * @param $hash_data
     * @param bool $first_question
     * @return object
     */
    protected function getQuestionPreviewData($hash_data, $first_question=true, $return=false){
        $clientLeadpops = \DB::table('clients_leadpops')
            ->select("id", "question_sequence", "funnel_questions")
            ->where("client_id", $hash_data['client_id'])
            ->where("leadpop_id", $hash_data['leadpop_id'])
            ->where('leadpop_version_id', $hash_data['leadpop_version_id'])
            ->where('leadpop_version_seq', $hash_data['leadpop_version_seq'])
            ->first();

        $questionSeq = explode("-", $clientLeadpops->question_sequence);
        $funnel_questions = json_decode($clientLeadpops->funnel_questions, 1);
        $previewFile = "";
        $question_params = "";
        if($first_question){
            $cta_messages_enable = \DB::table('clients_leadpops_attributes')
                ->select("enable_cta")
                ->where("client_id", $hash_data['client_id'])
                ->where("clients_leadpop_id", $hash_data['client_leadpop_id'])
                ->first();

            $cta_image_enable = \DB::table('leadpop_images')
                ->select("use_default","use_me")
                ->where("client_id", $hash_data['client_id'])
                ->where("leadpop_version_id", $hash_data['leadpop_version_id'])
                ->where("leadpop_version_seq", $hash_data['leadpop_version_seq'])
                ->first();

            // CTA Messages in case of first question
            $cta_messages = $cta_messages_enable->enable_cta == 1 ? $this->loadCtaSettings($hash_data, true):false;
            // Question Sequence
            $requiredQuestionNumber = $questionSeq[0];

            // Featured Image Information in case of first question
            $imagesrc = \View_Helper::getInstance()->getCurrentFrontImageSource( $hash_data['client_id'], $hash_data );
            $theimage = "";
            if($imagesrc && ($cta_image_enable->use_default == 'y' || $cta_image_enable->use_me == 'y')){
                list($imagestatus,$theimage, $noimage) = explode("~",$imagesrc);
                $currentImage = "";
                if(!empty($theimage)) {
                    $arr = explode('/', $theimage);
                    if(is_array($arr)) {
                        $currentImage = end($arr);
                    }
                }
            }
            else{
                $theimage = false;
            }
            switch ($funnel_questions[$requiredQuestionNumber]['question-type']) {
                case "zipcode":
                    $previewFile = 'zipcode-preview.php';
                    break;

                case "menu":
                    $previewFile = 'menu-preview.php';
                    break;

                case "dropdown":
                    $previewFile = 'dropdown-preview.php';
                    break;

                case "slider":
                    $previewFile = 'slider-preview.php';
                    break;

                case "contact":
                    $previewFile = 'contact-preview.php';
                    break;

                case "birthday":
                    $previewFile = 'birthday-preview.php';
                    break;

                case "ctamessage":
                    $previewFile = 'CTA-preview.php';
                    break;

                case "number":
                    $previewFile = 'number-preview.php';
                    break;

                case "text":
                    $previewFile = 'textfield-preview.php';
                    break;

                case "vehicle":
                    $previewFile = 'vehicle-preview.php';
                    $question_params = '&bundle_question_step=0';
                    break;
            }
        } else {
            // No CTA Messages in case of last question
            $cta_messages = false;
            // No Featured Image Information in case of last question
            $theimage = false;
            // Question Sequence
            $requiredQuestionNumber = '';
            $previewFile = 'TCPA-contact-preview.php';
            if(strpos($clientLeadpops->funnel_questions,'"question-type": "contact"'))
            {
                $find_phone = false;
                foreach ($questionSeq as $seq)
                {
                    if($funnel_questions[$seq]['question-type'] == 'contact')
                    {
                        $active_step = $funnel_questions[$seq]['options']['activesteptype']-1;
                        foreach ($funnel_questions[$seq]['options']['all-step-types'][$active_step]['steps'] as $key => $step)
                        {
                            if(in_array(5,$step['field-order']) && $step['fields'][5]['phone']['value'] == 1)
                            {
                                $find_phone = true;
                                $funnel_questions[$seq]['active_slide'] = $key;
                                $requiredQuestionNumber = $seq;
                                break;
                            }
                        }
                        if($find_phone)
                        {
                            break;
                        }
                    }
                }
            }

        }

        $iframeSrc = LP_BASE_URL.'/previewbars/'.$previewFile.'?ls_key=tcpa_module_'.$hash_data[ "current_hash" ] . '&is_messages_module=1&ques_id='. @$requiredQuestionNumber.$question_params;

        $previewData = new stdClass();
        $previewData->iframeSrc = $iframeSrc;
        $previewData->funnel_questions = json_encode(LP_Helper::getInstance()->combine_json_attributes($funnel_questions,$hash_data['leadpop_version_id']));
        $previewData->clients_leadpops = $clientLeadpops;
        $previewData->cta_settings = $cta_messages;

        if (!empty($requiredQuestionNumber))
        {
            $previewData->required_question = $funnel_questions[$requiredQuestionNumber];
            $previewData->required_question_number = $requiredQuestionNumber;

            $previewData->featured_image = $theimage;
        }

        if($return) {
            return $previewData;
        }
        else{
            $this->data->questionPreview = $previewData;
        }
    }

    /**
     * set common data for view
     * @param $hash_data
     * @param $session
     */

    protected function setCommonData($hash_data, $session)
    {
        $this->data->lpkeys = $this->getLeadpopKey($hash_data);
        $this->data->client_id = $hash_data["funnel"]["client_id"];
        $this->data->funnel_url = $hash_data["funnel"]["domain_name"];
        $this->data->vertical_id = $hash_data["funnel"]["leadpop_vertical_id"];
        $this->data->subvertical_id = $hash_data["funnel"]["leadpop_vertical_sub_id"];
        $this->data->currenthash = $hash_data["current_hash"];
        $this->data->funnelData = $hash_data["funnel"];
        $this->loadCtaSettings($hash_data);
        $this->data->clickedkey = $this->data->lpkeys;
        if (isset($session->clickedkey)) {
            $this->data->clickedkey = $session->clickedkey;
        }
    }
}
