<?php
namespace App\Http\Controllers;
use App\Constants\FunnelVariables;
use App\Constants\Layout_Partials;
use App\Constants\LP_Constants;
use App\Helpers\CustomErrorMessage;
use App\Repositories\CustomizeRepository;
use App\Repositories\GlobalRepository;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LP_Helper;
use Session;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Validator;

class GlobalController extends BaseController {
    Private $global_obj,$customize;
    protected $rackspace ;
    public function __construct(LpAdminRepository $lpAdmin, CustomizeRepository $customize ,GlobalRepository $global_obj){
        $this->middleware(function($request, $next) use ($lpAdmin) {
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(Session::get('leadpops'));

            $this->init($lpAdmin);
            if($request->ajax()) $this->check_ajax_session(); else $this->check_session();
            return $next($request);
        });
        $this->global_obj = $global_obj;
        $this->customize = $customize;
        $this->rackspace = \App::make('App\Services\RackspaceUploader');
    }

    function index(Request $request){
        $this->header_partial=Layout_Partials::GLOBAL_CHANGE;
        $this->data->maintab="design";
        $client_products = LP_Helper::getInstance()->getClientProducts();
        if($client_products[LP_Constants::PRODUCT_FUNNEL]!="0"){
            $this->data->action="logo";
        }else{
            $this->data->action="cta";
        }
        $target_id = $request->get('id');
        if($target_id)
            $this->data->action=$target_id;

        $maintab=array('design'=>array("logo","background","featured-image"),'content'=>
            array("autoresponder","contactinfo",'cta','thankyou','seo','footer'),'integration-pixels'=>
            array('integration','pixels','leadalerts', "ada-accessibility"));
        foreach ($maintab as $key => $subarr) {
            if(in_array($this->data->action, $subarr)){
                $this->data->maintab=$key;
                break;
            }
        }
        /* for logo scripts and styles */
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/jquery-ui.min.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/bootstrap-multiselect.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/bootstrap-checkbox.min.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/color-thief.js");
        array_push($this->assets_css, LP_BASE_URL.config('view.theme_assets')."/external/jquery-ui.min.css");
        array_push($this->assets_css, LP_BASE_URL.config('view.theme_assets')."/external/bootstrap-multiselect.css");

        /* for background scripts and styles */
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/color-thief.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/spectrum.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/jquery.base64.min.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/gradient-parser.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/tinycolor.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/bootstrap.touchspin.min.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/js/global/globallogo.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/js/global/globalfeaturedimage.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/js/global/grecipients.js");
        array_push($this->assets_css, LP_BASE_URL.config('view.theme_assets')."/external/spectrum.css");
        $this->data->fontfamilies = LP_Helper::getInstance()->getFontFamilies();
        $fontfamiliesfiles=LP_Helper::getInstance()->getFontFamilyFiles($this->data->fontfamilies);
        foreach ($fontfamiliesfiles as $file) {
            array_push($this->assets_css,$file);
        }
        //var_dump($this->assets_css);
        $this->inline_css=LP_Helper::getInstance()->getFontFamilesClass($this->data->fontfamilies);
        $this->inline_css .="
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
        }
        .funnel-selector-li-holder{
            overflow: hidden;
            max-height: 400px;
        }";

        $all_funnels = array();
        LP_Helper::getInstance()->_fetch_all_funnels();
        foreach (LP_Helper::getInstance()->getFunnels() as $vertical_id => $groups) {
            foreach ( $groups as $group_id => $group_item ) {
                foreach ( $group_item as $sub_verticals ) {
                    foreach ( $sub_verticals as $funnel ) {
                        $all_funnels[] = array("label"=>strtolower($funnel['domain_name']." -- ".$funnel['fs_display_label']), "domain_id"=>$funnel['domain_id'], "display"=>$funnel['fs_display_label']);
                        //$all_funnels[] = strtolower($funnel['domain_name']). " (".$funnel['fs_display_label'].")";
                    }
                }
            }
        }

        $this->inline_js = "var funnels = ".json_encode($all_funnels).";\n";
        $this->inline_js .= '$( "#search" ).autocomplete({
	        minLength: 0,
	        source: funnels,
	        focus: function( event, ui ) {
	            var label = ui.item.label.split(" -- ");
			    $( "#search" ).val( label[0] );
			    return false;
		    },
		    appendTo: "#search__wrapper",
	        select: function( event, ui ) {
                $(".domain_"+ui.item.domain_id).prop("checked", true)
                $(".domain_"+ui.item.domain_id).parent(".item").find("label").addClass("lp-white");
                $(".ui-menu").hide();
                $( "#search" ).val("");
                return false;

                var _target = $(".gfunnel"+ui.item.domain_id).parents(".mCustomScrollbar");
			    if (_target.length) {
			    	var offset = 10;
			    	console.info(ui.item.domain_id);
				    var elTop = $(".gfunnel"+ui.item.domain_id).offset().top - $(".gfunnel"+ui.item.domain_id).parents(".mCSB_container").offset().top;
				    var scrollNum = elTop - offset;
			        _target.mCustomScrollbar("scrollTo", scrollNum);
			    }

			    var _wtarget = $(".wfunnel"+ui.item.domain_id).parents(".mCustomScrollbar");
			    if (_target.length) {
			    	var offset = 10;
				    var elTop = $(".wfunnel"+ui.item.domain_id).offset().top - $(".wfunnel"+ui.item.domain_id).parents(".mCSB_container").offset().top;
				    var scrollNum = elTop - offset;
			        _wtarget.mCustomScrollbar("scrollTo", scrollNum);
			    }

		    }
        });';
        $this->inline_js .= "var div = '<div class=\"funnel-selector-li-holder\">';\n";
        $this->inline_js .= '$( "#search" ).on( "autocompleteopen", function( event, ui ) {
            if($("#ui-id-1  .funnel-selector-li-holder").length == 0){
                var $set_of_li = $("#ui-id-1").children();
                $set_of_li.wrapAll(div);
                $(".funnel-selector-li-holder").mCustomScrollbar({
                    axis:"y",
                    autoExpandScrollbar: false,
                    mouseWheel:{ scrollAmount: 300 }
                });
            }
        } );';

        //TODO remove autocomplete renderitem code.

        $this->data->client_id = $this->registry->leadpops->client_id;
        $this->data->clientName = \View_Helper::getInstance()->getClientName($this->registry->leadpops->client_id);
        $this->data->clientToken = $this->global_obj->getClientToken($this->registry->leadpops->client_id);
        $this->data->LeadpopAccessToken = $this->global_obj->getLeadpopAccessToken($this->registry->leadpops->client_id);
        $this->data->subscriptions = $this->customize->getClientSubscriptions($this->registry->leadpops->client_id);
        $this->data->integrations = $this->customize->getClientIntegrations($this->registry->leadpops->client_id);
        $this->data->globalOptions = $this->customize->getGlobalOptions($this->registry->leadpops->client_id);
        $this->data->backgroungOptions = $this->global_obj->getGlobalBackgroundImageOptions($this->registry->leadpops->client_id);
        $this->data->globalPixels = $this->global_obj->getGlobalPixels($this->registry->leadpops->client_id);
        $this->data->globalrecipients = $this->global_obj->getGlobalRecipients($this->registry->leadpops->client_id);

       return $this->response();

    }

    public function  uploadgloballogo(Request $request) {

        if ($request->input('logosavetype') == 'uploadlogo') {
            $globalLogo = \DB::table("global_settings")
                ->select(\DB::raw("(SELECT count(*) FROM global_settings WHERE client_id = " . $this->registry->leadpops->client_id . ") as records"),
                    \DB::raw("count(*) as count"))
                ->where("client_id", $this->registry->leadpops->client_id)
                ->where(function($query) {
                    $query->where("logo1", "")
                        ->orWhere("logo2", "")
                        ->orWhere("logo3", "");
                })->first();

            if($globalLogo->records && $globalLogo->count == 0) {
                Session::flash('error', '<strong>Error:</strong> ' . CustomErrorMessage::getInstance()->getByKey("logos_count"));
                return  $this->lp_redirect('/global/?id=logo');
            }

            $validator = Validator::make($request->all(), [
                'globallogo' => 'mimes:jpeg,jpg,png|file|max:' . config('validation.logo_image_size')
            ]);

            if($validator->fails()) {
                CustomErrorMessage::getInstance()->setFirstError($validator, "globallogo");
                return  $this->lp_redirect('/global/?id=logo');
            }

            $res = $this->customize->uploadgloballogo($_FILES,$this->registry->leadpops->client_id);
        }else if($request->input('logosavetype') == 'savelogo'){
            $res = $this->customize->savegloballogo($_POST,$this->registry->leadpops->client_id);
        }else {
            return;
        }
        if($res == 'ok') {
            Session::flash('success', '<strong>Success:</strong> Logo has been saved.');
        }else {
            Session::flash('error', '<strong>Error:</strong> Your request was not processed. Please try again. ');
        }
       return  $this->lp_redirect('/global/?id=logo');
    }

    public function  uploadglobalimage(Request $request) {
        $validator = Validator::make($request->all(), [
            'globalfeaturedlogo' => 'mimes:jpeg,jpg,png|file|max:' . config('validation.featured_image_size')
        ]);

        if($validator->fails()) {
            CustomErrorMessage::getInstance()->setFirstError($validator, "globalfeaturedlogo");
            return  $this->lp_redirect('/global/?id=featured-image');
        }

        $res = $this->global_obj->uploadGlobalFeaturedImage($_FILES,$this->registry->leadpops->client_id);
        if($res == 'ok') {
            Session::flash('success', '<strong>Success:</strong> Featured Image has been saved. ');
        }else {
            Session::flash('error', '<strong>Error:</strong> Saving Featured Image. ');
            }
        return $this->lp_redirect('/global/?id=featured-image#featured-image');
    }

    public function updateglobalbackgroundimage(Request $request) {
        $validator = Validator::make($request->all(), [
            'background_name' => 'mimes:jpeg,jpg,png|file|max:' . config('validation.background_image_size')
        ]);

        if($validator->fails()) {
            CustomErrorMessage::getInstance()->setFirstError($validator, "background_name");
            return  $this->lp_redirect('/global/?id=background');
        }

        $this->customize->updateglobalbackgroundimage($this->registry->leadpops->client_id,$request,$_FILES);
        Session::flash('success', '<strong>Success:</strong> Background Image has been saved.');
        return $this->lp_redirect('/global/?id=background#background');
    }

    public function updateglobalbackgroundcolor(Request $request) {
        $this->customize->updateglobalbackgroundcolor($this->registry->leadpops->client_id,$_POST);
        echo true;
    }

    function saveglobalmaincontent(Request $request){

        $data=array();
        $data["message"]=array('thefont'=>$request->input("mthefont"),
            'thefontsize'=>$request->input("mthefontsize"),
            'mainheadingval'=>trim($request->input("mmainheadingval")),
            'savestyle'=>$request->input("mmessagecpval"),
            'lineheight'=>$request->input("mlineheight"),
            'contenttype'=>'mainmessage'
        );
        $data["description"]=array('thefont'=>$request->input("dthefont"),
            'thefontsize'=>$request->input("dthefontsize"),
            'mainheadingval'=>trim($request->input("dmainheadingval")),
            'savestyle'=>$request->input("dmessagecpval"),
            'lineheight'=>$request->input("dlineheight"),
            'contenttype'=>'description'
        );
        $is_error=false;
        if($is_error===false){
            $this->customize->saveglobalmaincontent($this->registry->leadpops->client_id,$data["message"]);
            $this->customize->saveglobalmaincontent($this->registry->leadpops->client_id,$data["description"]);

            Session::flash('success', '<strong>Success:</strong> Call-to-Action has been saved.');
        }else {
            Session::flash('error', '<strong>Error:</strong> Saving Call-to-Action. ');
        }
        return $this->lp_redirect('/global/?id=cta');
    }

    public function saveglobalautoresponder(Request $request) {
    //    dd($request->all());
        $this->customize->saveglobalautoresponder($this->registry->leadpops->client_id,$_POST);
        Session::flash('success', '<strong>Success:</strong> Autoresponder has been saved.');
       return $this->lp_redirect('/global/?id=autoresponder');
    }

    public function updatestatusglobaladvancefooter() {
        $this->customize->updatestatusglobaladvancefooter($this->registry->leadpops->client_id,$_POST);
        echo "updated";
        exit;
        //Session::flash('success', '<strong>Success:</strong> Super Footer has been saved.');
        //return $this->lp_redirect('/global/?id=superfooter');
    }

    public function updateglobaladvancefooter() {
        $this->customize->updateglobaladvancefooter($this->registry->leadpops->client_id, $_POST);
        Session::flash('success', '<strong>Success:</strong> Super Footer has been saved.');
        return $this->lp_redirect('/global/?id=superfooter');
    }

    function globalsaveseo(){

        $return_val=$this->global_obj->globalSaveSeo($this->registry->leadpops->client_id,$_POST);
        if($return_val==true){
            Session::flash('success', '<strong>Success:</strong> SEO setting has been saved.');
        }else{
            Session::flash('error', '<strong>Eror:</strong> Your request was not processed. Please try again.');
        }
        return $this->lp_redirect('/global/?id=seo');
    }

    public function globalsavecontactoptions() {
        $this->customize->globalsaveContactOptions($this->registry->leadpops->client_id,$_POST);
        Session::flash('success', '<strong>Success:</strong> Contact Info has been saved.');
        return $this->lp_redirect('/global/?id=contactinfo');
    }

    public function globalsavethankyouoptions() {
        $this->customize->globalsavethankyouoptions($this->registry->leadpops->client_id,$_POST);
        Session::flash('success', '<strong>Success:</strong> Thank You Page has been saved.');
        return $this->lp_redirect('/global/?id=thankyou');
    }

    function privacypolicy(){
        $this->data->globalpagetitle = " : Privacy Policy";
        $this->commonFooterGlobalSetting();
        $this->global_funnel_selection_sreach($this);
        return $this->response();
    }

    function termsofuse(){
        $this->data->globalpagetitle = " : Terms Of Use";
        $this->commonFooterGlobalSetting();
        $this->global_funnel_selection_sreach($this);
        return $this->response();
    }


    function disclosures(){
        $this->data->globalpagetitle = " : Disclosures";
        $this->commonFooterGlobalSetting();
        $this->global_funnel_selection_sreach($this);
        return $this->response();
    }


    function licensinginformation(){
        $this->data->globalpagetitle = " : Licensing Information";
        $this->commonFooterGlobalSetting();
        $this->global_funnel_selection_sreach($this);
        return $this->response();
    }


    function aboutus(){
        $this->data->globalpagetitle = " : About Us";
        $this->commonFooterGlobalSetting();
        $this->global_funnel_selection_sreach($this);
        return $this->response();
    }

    function contactus(){
        $this->data->globalpagetitle = " : Contact Us";
        $this->global_funnel_selection_sreach($this);
        $this->commonFooterGlobalSetting();
        return $this->response();
    }


    function commonFooterGlobalSetting(){
        $this->header_partial=Layout_Partials::GLOBAL_CHANGE;
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/bootstrap-multiselect.js");
        array_push($this->assets_css, LP_BASE_URL.config('view.theme_assets')."/external/bootstrap-multiselect.css");
        $this->data->client_id = $this->registry->leadpops->client_id;
        $this->data->clientName = \View_Helper::getInstance()->getClientName($this->registry->leadpops->client_id);
        $this->data->clientToken = $this->global_obj->getClientToken($this->registry->leadpops->client_id);
        $this->data->globalOptions = $this->customize->getGlobalOptions($this->registry->leadpops->client_id);
    }

    function updatecompliance(Request $request){
        /* update clients_leadpops table's col last edit*/
        update_clients_leadpops_last_eidt($this->registry->leadpops->client_id);
        $return_val=$this->global_obj->updateGlobalCompliance();
        echo json_encode($return_val);
    }

    function savefooteroptions(Request $request){
        $is_error=false;
        $message_action=ucfirst($request->input("theurltext"));
        $action="";
        switch ($_POST["theselectiontype"]) {
            case 'footeroptionsprivacypolicy':
                //$message_action="Global Privacy policy";
                $action="privacypolicy";
                break;
            case 'termsofuse':
                //$message_action="Global Terms of use";
                $action="termsofuse";
                break;
            case 'disclosures':
                //$message_action="Global Disclosures";
                $action="disclosures";
                break;
            case 'licensinginformation':
                //$message_action="Global Licensing Information";
                $action="licensinginformation";
                break;
            case 'aboutus':
                //$message_action="Global About Us";
                $action="aboutus";
                break;
            case 'contactus':
                //$message_action="Global Contact Us";
                $action="contactus";
                break;
        }
        if($is_error===false){
            $this->global_obj->saveBottomLinks($this->registry->leadpops->client_id,$_POST);
            Session::flash('success', '<strong>Success:</strong> '.$message_action.' has been saved.');
        }else{
            Session::flash('error', '<strong>Error:</strong> Saving '.$message_action);
        }
        return $this->lp_redirect('/global/'.$action);

    }

    function deletelogoglobal(LpAdminRepository $admin_obj){
        $return_val= $admin_obj->deleteLogoGlobal();
        echo $return_val;
    }

    public function activetodefaultimageglobal() {
        $return_val= $this->global_obj->activateDefaultlpimageGlobal();
        echo json_encode($return_val);
    }
        //======================================================================================//

    public function createauthkeyAction() {
        if($_POST){
            $url = "http://zapier.leadpops.com/api/v1/create-token/".$this->registry->leadpops->client_id;
            #$url = "http://zapier.dev/api/v1/create-token/".$this->client_id;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
                exit;
            } else {
                $resp = json_decode($response,1);
                if($resp['code'] == 200){
                    $this->customize->createClientKey($this->client_id, $resp['token']);
                    $this->lp_redirect('/global/index?id=integration');
                }else{
                    echo "Error #401 - " . $resp['error'];
                    exit;
                }
            }
        }else{
            $this->lp_redirect('/global/index?id=integration');
        }
    }

    /* Saif */

    function footerimageupload(Request $request){
        LP_Helper::getInstance()->getCurrentHashData($_POST["current_hash"]);
        if(LP_Helper::getInstance()->getCurrentHash()){
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            if (!empty($funnel_data)) {
                $vertical_id = $funnel_data["leadpop_vertical_id"];
                $subvertical_id = $funnel_data["leadpop_vertical_sub_id"];
                $leadpop_id = $funnel_data["leadpop_id"];
                $version_seq = $funnel_data["leadpop_version_seq"];
                $leadpop_template_id = $funnel_data["leadpop_template_id"];
                $leadpop_version_id = $funnel_data["leadpop_version_id"];
                $leadpop_type_id = $funnel_data["leadpop_type_id"];
            } else {
                // todo
            }
            $client_id  = $funnel_data['funnel']['client_id'];
            $_FILES['file']['name'] = preg_replace('/[^\.a-zA-Z0-9]/', '', $_FILES['file']['name']);
            $time = time();
            $filename = strtolower($client_id . "_" . $leadpop_id . "_" . $leadpop_type_id . "_" . $vertical_id . "_" . $subvertical_id . "_" . $leadpop_template_id . "_" . $leadpop_version_id . "_" . $version_seq . "_" . $time . "_" . $_FILES['file']['name']);
            $section = substr($client_id, 0, 1);
            $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "PNG","GIF", "JPEG");
            // Get filename.
            $temp = explode(".", $_FILES["file"]["name"]);
            // Get extension.
            $extension = end($temp);
            // An image check is being done in the editor but it is best to
            // check that again on the server side.
            // Do not use $_FILES["file"]["type"] as it can be easily forged.
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES["file"]["tmp_name"]);
            if ((($mime == "image/gif")
                    || ($mime == "image/jpeg")
                    || ($mime == "image/pjpeg")
                    || ($mime == "image/x-png")
                    || ($mime == "image/png"))
                && in_array($extension, $allowedExts)) {
                // Save file in the uploads folder.
                $container = $this->registry->leadpops->clientInfo['rackspace_container'];
                //compressing image
                $imageCompresser = \App\Helpers\ImageCompression_Helper::getInstance();
                $compressedFilePath = $imageCompresser->compress($_FILES["file"]["tmp_name"], $filename);
                $rackspace_path = 'images1/'. $section . '/' . $client_id . '/pics/' . $filename;
                $data = fopen($compressedFilePath, 'r+');
                $cdn = $this->rackspace->uploadTo($container, $data, $rackspace_path);
                @unlink($compressedFilePath);
                // Generate response.
                $response = [];
                $response["link"] = $cdn['image_url'];
                echo stripslashes(json_encode($response));
                die();
            }
            else if (in_array($extension,["pdf","docx","doc","ppt","xlsx","xls"])) {
                // Save file in the uploads folder.
                $container = $this->registry->leadpops->clientInfo['rackspace_container'];
                $rackspace_path = 'images1/'. $section . '/' . $client_id . '/pics/' . $filename;
                $data = fopen($_FILES["file"]["tmp_name"], 'r+');
                $cdn = $this->rackspace->uploadTo($container, $data, $rackspace_path);
                // Generate response.
                $response = [];
                $response["link"] = $cdn['image_url'];
                echo stripslashes(json_encode($response));
                die();
            }
        }else{
            // LP-TODO 404 REDIRECT
        }
        // Allowed extentions.
    }

    public function footerimageremove()
    {
        LP_Helper::getInstance()->getCurrentHashData($_POST["current_hash"]);
        if (LP_Helper::getInstance()->getCurrentHash()) {
            // Delete file.
            $container = $this->registry->leadpops->clientInfo['rackspace_container'];
            $file_path = str_replace("https://images.lp-images1.com/", "", $_POST['src']);
            if (strpos($file_path , '_global_image_') !== false) {
            }else{
                $this->rackspace->deleteTo($container, $file_path);
            }
            $status = true;
            $response = array('status' => $status);
            echo stripslashes(json_encode($response));
            die();
        }
    }

    /* for global setting */

    function globalimageupload(Request $request)
    {
        if ($request->input('client_id')) {
            $client_id = $request->input('client_id');
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
            $section = substr($client_id, 0, 1);
            $_FILES['file']['name'] = preg_replace('/[^\.a-zA-Z0-9]/', '', $_FILES['file']['name']);
            $time = time();
            $filename = strtolower($client_id . "_global_image_" . $time . "_" . $_FILES['file']['name']);
            $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "PNG", "GIF", "JPEG");
            // Get filename.
            $temp = explode(".", $_FILES["file"]["name"]);
            // Get extension.
            $extension = end($temp);
            // An image check is being done in the editor but it is best to
            // check that again on the server side.
            // Do not use $_FILES["file"]["type"] as it can be easily forged.
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES["file"]["tmp_name"]);
            if ((($mime == "image/gif")
                    || ($mime == "image/jpeg")
                    || ($mime == "image/pjpeg")
                    || ($mime == "image/x-png")
                    || ($mime == "image/png"))
                && in_array($extension, $allowedExts)) {
                // Save file in the uploads folder.
                $container = $this->registry->leadpops->clientInfo['rackspace_container'];
                //compressing image
                $imageCompresser = \App\Helpers\ImageCompression_Helper::getInstance();
                $compressedFilePath = $imageCompresser->compress($_FILES["file"]["tmp_name"], $filename);
                $rackspace_path = 'images1/' . $section . '/' . $client_id . '/images/default_logos/' . $filename;
                $data = fopen($compressedFilePath, 'r+');
                $cdn = $this->rackspace->uploadTo($container, $data, $rackspace_path);
                @unlink($compressedFilePath);
                // Generate response.
                $response = [];
                $response["link"] = $cdn['image_url'];
                echo stripslashes(json_encode($response));
                die();
            }
        } else {
            // LP-TODO 404 REDIRECT
        }
        // Allowed extentions.
    }

    public function globalimageremove(Request $request)
    {
        if ($request->input('client_id')) {
            // Delete file.
           /* $container = $this->registry->leadpops->clientInfo['rackspace_container'];
            $file_path = str_replace("https://images.lp-images1.com/", "", $_POST['src']);
            $this->rackspace->deleteTo($container, $file_path);*/
            $status = true;
            $response = array('status' => $status);
            echo stripslashes(json_encode($response));
            die();
        }
    }

    /*
     * Note: for funnel sreach in global setting pop up
     * */
    function global_funnel_selection_sreach($this_page){

        /* for logo scripts and styles */
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/jquery-ui.min.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/bootstrap-multiselect.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/bootstrap-checkbox.min.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/color-thief.js");
        array_push($this->assets_css, LP_BASE_URL.config('view.theme_assets')."/external/jquery-ui.min.css");
        array_push($this->assets_css, LP_BASE_URL.config('view.theme_assets')."/external/bootstrap-multiselect.css");

        /* for background scripts and styles */
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/color-thief.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/spectrum.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/jquery.base64.min.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/gradient-parser.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/tinycolor.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/bootstrap.touchspin.min.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/js/global/globallogo.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/js/global/globalfeaturedimage.js");
        array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/js/global/grecipients.js");
        array_push($this->assets_css, LP_BASE_URL.config('view.theme_assets')."/external/spectrum.css");
        $this->data->fontfamilies = LP_Helper::getInstance()->getFontFamilies();
        $fontfamiliesfiles=LP_Helper::getInstance()->getFontFamilyFiles($this->data->fontfamilies);
        foreach ($fontfamiliesfiles as $file) {
            array_push($this_page->assets_css,$file);
        }
        //var_dump($this->assets_css);
        $this_page->inline_css .="
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
        }
        .funnel-selector-li-holder{
            overflow: hidden;
            max-height: 400px;
        }";

        $all_funnels = array();
        LP_Helper::getInstance()->_fetch_all_funnels();
        foreach (LP_Helper::getInstance()->getFunnels() as $vertical_id => $groups) {
            foreach ( $groups as $group_id => $group_item ) {
                foreach ( $group_item as $sub_verticals ) {
                    foreach ( $sub_verticals as $funnel ) {
                        $all_funnels[] = array("label"=>strtolower($funnel['domain_name']." -- ".$funnel['fs_display_label']), "domain_id"=>$funnel['domain_id'], "display"=>$funnel['fs_display_label']);
                        //$all_funnels[] = strtolower($funnel['domain_name']). " (".$funnel['fs_display_label'].")";
                    }
                }
            }
        }

        $this_page->inline_js = "var funnels = ".json_encode($all_funnels).";\n";
        $this_page->inline_js .= '$( "#search" ).autocomplete({
	        minLength: 0,
	        source: funnels,
	        focus: function( event, ui ) {
	        	var label = ui.item.label.split(" -- ");
			    $( "#search" ).val( label[0] );
			    return false;
		    },
		    appendTo: "#search__wrapper",
	        select: function( event, ui ) {
                $(".domain_"+ui.item.domain_id).prop("checked", true)
                $(".domain_"+ui.item.domain_id).parent(".item").find("label").addClass("lp-white");
                $(".ui-menu").hide();
                $( "#search" ).val("");
                 return false;
                var _target = $(".gfunnel"+ui.item.domain_id).parents(".mCustomScrollbar");
			    if (_target.length) {
			    	var offset = 10;
				    var elTop = $(".gfunnel"+ui.item.domain_id).offset().top - $(".gfunnel"+ui.item.domain_id).parents(".mCSB_container").offset().top;
				    var scrollNum = elTop - offset;
			        _target.mCustomScrollbar("scrollTo", scrollNum);
			    }

			    var _wtarget = $(".wfunnel"+ui.item.domain_id).parents(".mCustomScrollbar");
			    if (_target.length) {
			    	var offset = 10;
				    var elTop = $(".wfunnel"+ui.item.domain_id).offset().top - $(".wfunnel"+ui.item.domain_id).parents(".mCSB_container").offset().top;
				    var scrollNum = elTop - offset;
			        _wtarget.mCustomScrollbar("scrollTo", scrollNum);
			    }


		    }
        });';
        $this->inline_js .= "var div = '<div class=\"funnel-selector-li-holder\">';\n";
        $this->inline_js .= '$( "#search" ).on( "autocompleteopen", function( event, ui ) {
            if($("#ui-id-1  .funnel-selector-li-holder").length == 0){
                var $set_of_li = $("#ui-id-1").children();
                $set_of_li.wrapAll(div);
                $(".funnel-selector-li-holder").mCustomScrollbar({
                    axis:"y",
                    autoExpandScrollbar: false,
                    mouseWheel:{ scrollAmount: 300 }
                });
            }
        } );';

    }

    public function updateAdaAccessibility(Request $request) {
        $lpkey_ada_accessibility = $request->input('lpkey_ada_accessibility');
        $is_ada_accessibility = $request->input("is_ada_accessibility") == 1 ? 1 : 0;

        $lplist = explode(",", $lpkey_ada_accessibility);

        if(is_array($lplist)) {
            try {
                $leadpopIds = [];
                $leadpopVersionSeqIds = [];
                foreach ($lplist as $index => $lp) {
                    $lpconstt = explode("~", $lp);

                    if($lpconstt[2] && $lpconstt[3]) {
                        $leadpopIds[] = $lpconstt[2];
                        $leadpopVersionSeqIds[] = $lpconstt[3];
                    }
                }

                \DB::table('clients_leadpops')
                    ->where("client_id", $this->registry->leadpops->client_id)
                    ->whereIn("leadpop_id", $leadpopIds)
                    ->whereIn('leadpop_version_seq', $leadpopVersionSeqIds)
                    ->update([
                        'is_ada_accessibility' => $is_ada_accessibility]
                    );
                $updatedStatus = $is_ada_accessibility ? "active" : "inactive";
                Session::flash('success', "<strong>Success:</strong> Your ADA accessibility settings are $updatedStatus.");
            } catch(\Exception $e) {
                Session::flash('error', '<strong>Error:</strong> Saving ADA Accessibility. ');
                return $this->lp_redirect('/global?id=ada');
            }
        } else {
            Session::flash('error', '<strong>Error:</strong> Saving ADA Accessibility. ');
        }

        return $this->lp_redirect('/global?id=ada');
    }

}
