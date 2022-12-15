<?php

namespace App\Http\Controllers;

use App\Constants\FunnelVariables;
use App\Constants\Layout_Partials;
use App\Constants\LP_Constants;
use App\Helpers\CustomErrorMessage;
use App\Helpers\GlobalHelper;
use App\Helpers\Utils;
use App\Repositories\CustomizeRepository;
use App\Repositories\CustomizeDesignRepositoryAdminThree;
use App\Repositories\CustomizeRepositoryAdminThree;
use App\Repositories\GlobalRepository;
use App\Repositories\GlobalRepositoryAdminThree;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LP_Helper;
use Session;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Validator;

class GlobalDesignControllerAdminThree extends BaseController
{
    Private $global_obj,
        $customize,
        $customizeAdminThree,
        $customizeDesignRepoAdminThree;

    protected $rackspace;

    public function __construct(LpAdminRepository $lpAdmin,
                                CustomizeRepository $customize,
                                CustomizeRepositoryAdminThree $customizeAdminThree,
                                CustomizeDesignRepositoryAdminThree $customizeDesignAdminThree,
                                GlobalRepositoryAdminThree $global_obj)
    {
        $this->middleware(function ($request, $next) use ($lpAdmin) {
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(Session::get('leadpops'));

            $this->init($lpAdmin);
            if($request->ajax()) $this->check_ajax_session(); else $this->check_session();
            return $next($request);
        });
        $this->global_obj = $global_obj;
        $this->customize = $customize;
        $this->customizeAdminThree = $customizeAdminThree;
        $this->customizeDesignRepoAdminThree = $customizeDesignAdminThree;
        $this->rackspace = \App::make('App\Services\RackspaceUploader');


    }

    //=======================================================================================================================================================
    //=========================================================START GLOBAL DESIGN ACTIONS===================================================================
    //=======================================================================================================================================================


    /*
 * Set customized background color (Used in HTTP POST request)
 * @param $request
 * */
    public function setCustomizedBackgroundColor(Request $request)
    {


        if (empty($request->input('selected_funnels'))) {
            return $this->errorResponse('Please select funnels for global action.');
        }
        $lplist = $request->input('selected_funnels') . ',' . LP_Helper::getInstance()->getFunnelKeyStringFromHash($request->input('current_hash'));
        $lplist = array_unique( explode(",", $lplist));
        $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);
        $funnel_data = array();
        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];

            // old query
            // @todo need to remove this old query after verification

      /*      $leadpop_data = $this->db->fetchRow('select id as leadpop_id,leadpop_type_id,leadpop_vertical_id,
            leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id from leadpops where id = ' . $leadpop_id . '');*/

//            $funnel_data[] = $queryDataCollection->where('leadpop_id', $leadpop_id)->first();

            // replaced query with collection where
            $funnel_data[] = array_merge($lpListCollection->where('leadpop_id', $leadpop_id)->first(), array('leadpop_version_seq' => $leadpop_version_seq));
        }
      //  dd($lplist, $lpListCollection, $_POST, $funnel_data);
      /*  echo "<pre>";
        dd($lplist, $funnel_data);
        var_export($funnel_data);
        exit;*/
        $res = $this->customize->customizedBackgroundColorSwatches($request->input('client_id'), $request, $funnel_data, true);
        if ($res == 'ok') {
            return $this->successResponse('Background Color has been saved.');
        } else {
            return $this->errorResponse('Your request was not processed. Please try again.');
        }
    }

    public function updateglobalbackgroundcolor(Request $request)
    {
        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
            /* Session::flash('error', '<strong>Error:</strong> Please select Funnels for global action.');
             return redirect()->back();*/
            return json_encode(array('status' => true, 'message' => 'Please select Funnels for global action.'));
        }

        $this->customizeDesignRepoAdminThree->updateGlobalBackgroundColorAdminThree($this->registry->leadpops->client_id, $_POST);
        echo true;
    }


    public function setAutoPulledLogoColorAdminThree(Request $request)
    {
//        Validating data
        try {

            $validatedData = $request->validate([
                'background' => 'required',
                'background_type' => 'required',
                'client_id' => 'required',
                'current_hash' => 'required'
            ]);
            if (empty($request->input('selected_funnels'))) {
                return $this->errorResponse( 'Please select funnels for global action.');
            }
            $_POST['selected_funnels'] = $_POST['selected_funnels'] . ',' . LP_Helper::getInstance()->getFunnelKeyStringFromHash($validatedData['current_hash']);
            $this->customizeDesignRepoAdminThree->updateGlobalBackgroundColorAdminThree($this->registry->leadpops->client_id, $_POST);
            $message = config("alerts.background.auto_pull_success." . config('view.theme'));
            return $this->successResponse( $message);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }


    public function updateglobalbackgroundimage(Request $request)
    {
        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
          return $this->errorResponse('Please select Funnels for global action.');
        }
        $validator = Validator::make($request->all(), [
            'background_name' => 'mimes:jpeg,jpg,png|file|max:' . config('validation.background_image_size')
        ]);

        if ($validator->fails()) {
            $message = CustomErrorMessage::getInstance()->setFirstError($validator, "background_name");
            return $this->errorResponse($message);
        }

        $this->customizeDesignRepoAdminThree->updateglobalbackgroundimageAdminThree($this->registry->leadpops->client_id, $request, $_FILES);
        return $this->successResponse('Background Image has been saved.');
    }


    public function uploadgloballogo(Request $request)
    {
        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
            return $this->errorResponse(' Please select Funnels for global action.');
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
            $message =  CustomErrorMessage::getInstance()->setFirstError($validator, "logo");
            return $this->errorResponse($message);
        }

        $swatches = $request->input("swatches");
        if ($request->input('uploadlogotype') == '' || $request->input('uploadlogotype') == null) {
            $res = $this->customizeDesignRepoAdminThree->savegloballogonew($_FILES, $request, $this->registry->leadpops->client_id, $swatches);
        }
        if ($request->input('uploadlogotype') == 'combine') {
            $res = $this->customizeDesignRepoAdminThree->uploadGlobalCombineLogo($_FILES, $_POST, $this->registry->leadpops->client_id);
        }

        if (isset($res["status"]) && $res["status"]) {
            return $this->successResponse('Logo has been saved.', $res["data"]);
        } else {
            return $this->errorResponse('Your request was not processed. Please try again.');
        }
    }


    // FEATURE IMAGE
    public function uploadglobalimage(Request $request)
    {
      //  dd($request->all(), $_FILES);

        $funneldataencode = $request->input("funneldata");
        $funnel_data = json_decode($funneldataencode, true);

        /**
         * UPLOAD / SYNC Feature Image Settings
         */
        $image_uploaded = false;
        $image_error = false;


        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
            return $this->errorResponse('Please select Funnels for global action.');
        }


        $response = [];
        if ($request->hasFile('logo')) {
            $hasFile = true;
            $validator = Validator::make($request->all(), [
                'logo' => 'mimes:gif,jpeg,jpg,png|file|max:' . config('validation.featured_image_size')
            ]);

            if ($validator->fails()) {
                $message = CustomErrorMessage::getInstance()->setFirstError($validator, "logo");
                return $this->errorResponse($message);
            }

            if ($_FILES["logo"]["name"] != "") {
                $response = $this->global_obj->uploadGlobalFeaturedImageAdminThree($_FILES, $this->registry->leadpops->client_id, $funnel_data, $hasFile);
                if ($response["status"]) {
                    $response = $response["data"];
                } else {
                    return $this->errorResponse('Unable to upload image.');
                }
            }
        }

        /**
         * Feature Image Status Settings Update
         */

        if (!$image_error) {
            if ($request->input("imagestatus") && $request->input("imagestatus") == "inactive") {
                $this->customizeDesignRepoAdminThree->deactivateFeaturedImageGlobally($this->registry->leadpops->client_id, $_POST);
            } else {
                $this->customizeDesignRepoAdminThree->activateFeaturedImageGlobally($this->registry->leadpops->client_id, $_POST);
            }
            return $this->successResponse('Featured image settings updated on selected Funnels.', $response);
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


    function deletelogoglobal(LpAdminRepository $admin_obj)
    {
        // dd($_POST);
        $return_val = $admin_obj->deleteLogoGlobal();
        echo $return_val;
    }


    /*
     * Feature Image Reset:
     *     This will reset feature image to default image with active state.
     */
    public function activetodefaultimageglobal(Request $request)
    {
        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
            Session::flash('error', '<strong>Error:</strong> Please select Funnels for global action.');
            return redirect()->back();
        }
//        dd($request->all());
        $data = $this->customizeDesignRepoAdminThree->activateDefaultlpimageGlobal($this->registry->leadpops->client_id, $_POST);
//        echo json_encode($return_val);

        return $this->successResponse('Featured media default image has been reset on selected Funnels.', $data);
//        Session::flash('success', 'Featured media default image has been reset on selected Funnels.');
//        return $this->lp_redirect('/popadmin/featuredmedia/' . $_POST["current_hash"]);
    }


    /*
     * Activate featured Image:
     *     This just change status of feature image in leadpop_images.
     */
    public function activateFeaturedImage()
    {
        $lplist = explode(",", $_POST['selected_funnels']);
        if (empty($_POST['selected_funnels']) || !count($lplist)) {
            /* Session::flash('error', '<strong>Error:</strong> Please select Funnels for global action.');
             return redirect()->back();*/
            return json_encode(array('status' => true, 'message' => 'Please select Funnels for global action.'));
        }

        $return_val = $this->customizeDesignRepoAdminThree->activateFeaturedImageGlobally($this->registry->leadpops->client_id, $_POST);
        echo json_encode($return_val);
    }

    /*
     * Deactivate featured Image:
     *     This just deactivates status of feature image in leadpop_images by turning use_default=n AND use_me=n.
     */
    public function deactivateFeaturedImage()
    {
        $lplist = explode(",", $_POST['selected_funnels']);
        if (empty($_POST['selected_funnels']) || !count($lplist)) {
            /* Session::flash('error', '<strong>Error:</strong> Please select Funnels for global action.');
             return redirect()->back();*/
            return json_encode(array('status' => true, 'message' => 'Please select Funnels for global action.'));
        }

        $return_val = $this->customizeDesignRepoAdminThree->deactivateFeaturedImageGlobally($this->registry->leadpops->client_id, $_POST);
    }




    //=========================================================LOGO ACTIONS===================================================================


    /*

     "_token" => "jeFT04ZODgaXtV5pYOTe1buIjfUQJUUPtE94auR2"
  "swatches" => "164-211-224#47-54-61#225-60-43#237-193-163#171-135-40#177-79-68"
  "key" => "8514~3~93~198~1~99~99~1"
  "scope" => null
  "logocnt" => "3"
  "funneldata" => "{"domain_name":"harp-8514.farhan-itclix.pk","subdomain_name":"harp-TElkBtMs","top_level_domain":"farhan-itclix.pk",
    "domain_id":208847,"client_leadpop_id":208502,"id":8,"funnel_variables":null,"lead_line":null,"second_line_more":null,"client_id":8514,
    "leadpop_id":198,"leadpop_version_id":99,"leadpop_active":"1","access_code":"","leadpop_version_seq":1,"leadpop_folder_id":149,"funnel_market":"f","static_thankyou_active":"y","static_thankyou_slug":"thank-you.html","lt_client_id":null,"lt_user_id":null,"xverify_flag":0,"date_added":"2020-07-14 10:42:04","date_updated":"2020-10-26 08:49:46","language":"en","funnel_name":"Harp","container":null,"partial_lead":0,"last_submission":null,"last_edit":"2020-10-27 11:38:52","funnel_tab_flag":null,"is_ada_accessibility":0,"leadpop_type_id":1,"leadpop_vertical_id":3,"leadpop_vertical_sub_id":93,"leadpop_template_id":99,"lead_pop_vertical":"Mortgage","vertical_label":"Mortgage","lead_pop_vertical_sub":"Multi HARP","active":"y","group_id":8,"display_label":"HARP Loans","ordering":2,"fs_display_label":"HARP Loans","v_sticky_cta":"Are you underwater on your mortgage? A HARP loan can help!","v_sticky_button":"See if I\u0027m Eligible!","group_name":"HARP Loans","group_order":8,"total_visits":0,"total_leads":0,"conversion_rate":0,"visits_sunday":null,"visits_month":null,"new_leads":0,"funnel_type":"f","subvertorder":2,"sticky_id":null,"sticky_name":null,"sticky_cta":"","sticky_button":"","sticky_url":null,"sticky_url_pathname":null,"sticky_funnel_url":null,"sticky_js_file":null,"sticky_website_flag":null,"sticky_status":null,"pending_flag":null,"sticky_updated":null,"sticky_location":null,"show_cta":null,"sticky_size":null,"zindex":null,"zindex_type":null,"hide_animation":null,"stickybar_number":null,"stickybar_number_flag":null,"sticky_data":"","third_party_website_flag":null,"sticky_script_type":null,"hash":"bpIx1ooozKeDp9qFaCLWFzWFCy95pOVSdi4QxlzFh0hsAlsBPbFPwc5ve8cRPkz2HlsUlPO","client_tag_name":"HARP Loans","client_tag_id":"1276","funnelGraphStats":{"datasrc":"data","step_size":1,"max_step":5,"day":["10\/20\/2020","10\/21\/2020","10\/22\/2020","10\/23\/2020","10\/24\/2020","10\/25\/2020","10\/26\/2020","10\/27\/2020"],"leads":[0,0,0,0,0,0,0,0]}}"
  "theselectiontype" => "logo"
  "client_id" => "8514"
  "logo_source" => "client"
  "stocklogopath" => "https://images.lp-images1.com/default/images/mortgage/multiharp_logos/home_loan_life_preserver.png"
  "logo_id" => "464768"
  "badlogo" => "0"
  "firstkey" => "3~93~198~1"
  "clickedkey" => "3~93~198~1"
  "treecookie" => "11"
  "treecookiediv" => "browserdivpopadmin"
  "logouploaded" => null
  "uploadlogotype" => null
  "current_hash" => "bpIx1ooozKeDp9qFaCLWFzWFCy95pOVSdi4QxlzFh0hsAlsBPbFPwc5ve8cRPkz2HlsUlPO"
  "pre-image-style" => "270~0"
  "post-image-style" => "270~0"
    */

    public function changelplogo(Request $request)
    {
        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
            return $this->errorResponse('Please select Funnels for global action.');
        }

        $client_id = $request->input("client_id");
        LP_Helper::getInstance()->getCurrentHashData($request->input("current_hash"));
        $funnel_data = [];
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
        }
        $return_val = $this->customizeDesignRepoAdminThree->changelplogo($client_id, $request, $funnel_data['funnel']);
        if (true == $return_val) {
            /* success message */
            return $this->successResponse('Logo has been updated.');
        } else {
            /* error message */
            return $this->errorResponse('Your request was not processed. Please try again.');
        }

    }


    //=======================================================================================================================================================
    //=========================================================END GLOBAL DESIGN ACTIONS===================================================================
    //=======================================================================================================================================================


    //=======================================================================================================================================================
    //=========================================================deprecated in admin3.0-----===================================================================
    //=======================================================================================================================================================


    /**
     * @deprecated deprecated in admin3.0
     * Individual Ajax replaced with common save button
     */

    // Deactivate Feature Image
    public function changetodefaultimageAction()
    {
        /* $client_id = $_POST["client_id"];
         $funneldataencode = $_POST["funneldata"];
         $funnel_data = json_decode($funneldataencode, true);
         $customize = $this->Default_Model_Customize;
         $customize->deactivatelpimage($client_id, $funnel_data);

         $this->updateFunnelTimestamp(array("client_id" => $client_id, "client_leadpop_id" => $funnel_data['client_leadpop_id']));
         print("1");*/
        $lplist = explode(",", $_POST['selected_funnels']);
        if (empty($_POST['selected_funnels']) || !count($lplist)) {
            /* Session::flash('error', '<strong>Error:</strong> Please select Funnels for global action.');
             return redirect()->back();*/
            return json_encode(array('status' => true, 'message' => 'Please select Funnels for global action.'));
        }


        $return_val = $this->customizeDesignRepoAdminThree->deactivateFeaturedImageGlobally($this->registry->leadpops->client_id, $_POST);
    }

    /**
     * @deprecated deprecated in admin3.0
     * Individual Ajax replaced with common save button
     */

    public function backgroundoptionstoggle(Request $request)
    {
        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
            /* Session::flash('error', '<strong>Error:</strong> Please select Funnels for global action.');
             return redirect()->back();*/
            return json_encode(array('status' => true, 'message' => 'Please select Funnels for global action.'));
        }

        $return_val = $this->customizeDesignRepoAdminThree->backgroundOptionsToggle();
        echo $return_val;
    }
}
//TODO: optimization => we need to rmove the code global setting old code, now we using new controller and custom design repository for admin3.0 from @mzac90
