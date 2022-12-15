<?php

namespace App\Http\Controllers;

use App\Constants\LP_Constants;
use App\Helpers\ChargeBeeHelpers;
use App\Helpers\CustomErrorMessage;
use App\Helpers\GlobalHelper;
use App\LeadpopBranding;
use App\Models\Clients;
use App\Models\ClientsLeadpops;
use App\Repositories\CustomizeRepository;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ChargebeePlansAddons;
use LP_Helper;

class LeadpopBrandingController extends BaseController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $session;
    public function __construct(LpAdminRepository $lpAdmin, CustomizeRepository $customtizeRepo){
        $this->middleware(function($request, $next) use ($lpAdmin,$customtizeRepo) {
            $this->registry = DataRegistry::getInstance();
            $this->registry->leadpops->clientInfo = LP_Helper::getInstance()->get_loggedin_client_info();
            $this->registry->_initProperties(\Session::get('leadpops'));
            $this->init($lpAdmin);
            if($request->ajax()) $this->check_ajax_session(); else $this->check_session(1);
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        LP_Helper::getInstance()->getCurrentHashData();
        if(LP_Helper::getInstance()->getCurrentHash()){
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonData($funnel_data, $session);
            $this->active_menu = LP_Constants::BRANDING;
            $this->data->funnelData['hash'] = $funnel_data['funnel']['hash'];
            //Load Question Preview
            $this->getQuestionPreviewData($funnel_data, true);

            $client = Clients::where(array('client_id'=> $funnel_data['client_id']))->first();
            $this->data->active_branding_plan_id = $client->branding_plan_id;

            $image = '';
            $this->data->branding_active = 0;
            $this->data->imageWidth = 0;
            $this->data->imageHeight = 0;
            $this->data->planList = $this->_createPlanAddonArray();

            if($this->data->active_branding_plan_id != "") {
                $where = array('client_id' => $funnel_data['client_id'], 'leadpop_version_id' => $funnel_data['leadpop_version_id'], 'leadpop_version_seq' => $funnel_data['leadpop_version_seq']);
                $this->data->branding = LeadpopBranding::where($where)->first();
                $section = substr($funnel_data['client_id'], 0, 1);

                if ($this->data->branding) {
                    $this->data->branding_active = $this->data->branding->leadpop_branding_active;
                    if ($this->data->branding->branding_image) {
                        if (env('APP_ENV') == config('app.env_local')) {
                            $image = env("APP_URL") . '/' . $this->registry->leadpops->clientInfo['rackspace_container'] . '/' . $section . '/' . $funnel_data['client_id'] . '/pics/' . $this->data->branding->branding_image;
                        } else {
                            $image = rackspace_client_baseurl() . '/pics/' . $this->data->branding->branding_image;
                        }
                    }

                    if ($this->data->branding->image_dimension) {
                        $dimension = json_decode($this->data->branding->image_dimension, 1);
                        $this->data->imageWidth = $dimension['w'];
                        $this->data->imageHeight = $dimension['h'];
                    }
                }
            }

            $this->data->imagePath = $image;
            if(isset($this->data->planList['currentPlan'])){
                if($this->data->planList['currentPlan'] === 'marketer'){
                    $packageModel = 'branding-feature-modal';
                }
                else{
                    $packageModel = 'feature-modal-price';
                }
            }
            else{
                $packageModel = 'branding-feature-modal';
            }
            $this->data->planModal = $packageModel;
            return $this->response();
        }else{
            return $this->_redirect();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function _createPlanAddonArray()
    {
        $plan = array();
        $clientType = LP_Helper::getInstance()->getClientAccountType();
        $industryType = LP_Helper::getInstance()->getClientIndustry();
        $clientType = (strtolower($clientType) === 'standard')?"Default":$clientType;

        //get plan list from chargebee table according to client type
        $planList =  ChargebeePlansAddons::select('id', 'plan_id','client_plan_type','period_unit', 'plan_price','status')
            ->where(array('client_type' => $clientType, 'industry' => $industryType, 'is_used' => 1))
            ->get()->toArray();

        if($planList) {
            if(empty($this->registry->leadpops->clientInfo['client_plan_id'])){
                $planKey = array_search('Marketer',array_column($planList,'client_plan_type'));
                $planType = $planList[$planKey]['plan_id'];
            }
            else{
                $planType = $this->registry->leadpops->clientInfo['client_plan_id'];
            }
            $planKey = array_search($planType, array_column($planList, 'plan_id'));
            $plan_type = explode("-", strtolower($planList[$planKey]['client_plan_type']));
            $plan['currentPlan'] = $plan_type[0];

            foreach ($planList as $key => $value) {
                $plan_type_with_term = explode("-", strtolower($value['client_plan_type']));
                $type = $plan_type_with_term[0];
                if(count($plan_type_with_term) < 2){
                    $term = "month";
                } else {
                    $term = $plan_type_with_term[1];
                }
                $plan['plan'][$type][$term] = array('plan_id' => $value['plan_id'], 'period_unit' => $value['period_unit'], 'plan_price' => convertCentsToDollarsString($value['plan_price']));
            }
        }

        //remove leadpops branding logo
        $plan['addOn'] = array();
        $addOn =  ChargebeePlansAddons::select('id', 'plan_id','client_plan_type','period_unit', 'plan_price','status')
            ->whereIn('plan_id', config('chargebee.branding_plan_ids'))->where('plan_type','plan')->get()->toArray();
        if($addOn) {
            foreach ($addOn as $index => $res) {
                $plan['addOn'][$res['period_unit']] = array('plan_id' => $res['plan_id'], 'period_unit' => $res['period_unit'], 'plan_price' => convertCentsToDollarsString($res['plan_price']));
            }
        }

        return $plan;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        LP_Helper::getInstance()->getCurrentHashData($request->input("current_hash"));
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
            $request['client_id'] =  $funnel_data['client_id'];
            $request['leadpop_version_id'] = $funnel_data['leadpop_version_id'];
            $request['leadpop_version_seq'] = $funnel_data['leadpop_version_seq'];
            $request['image_dimension'] = json_encode(['h'=>$request->get('image_height'), 'w'=>$request->get('image_width')]);
            unset($request['image_height']);
            unset($request['image_width']);
            $this->saveBranding($request);

            return $this->successResponse('The funnel branding changes have been saved.');
        }
        return $this->errorResponse('Your request was not processed. Please try again.');
    }

    /**
     * @param $funnel_data
     */
    private function saveBranding(Request $request)
    {
        $where = array('client_id' => $request['client_id'],'leadpop_version_id' => $request['leadpop_version_id'],'leadpop_version_seq' => $request['leadpop_version_seq']);
        $branding = LeadpopBranding::where($where)->first();
        $arrayFill = $request->except(['_token','current_hash']);
        if(!isset($arrayFill['backlink_enable'])){
            $arrayFill['backlink_enable'] = 0;
        }
        if(!isset($arrayFill['leadpop_branding'])){
            $arrayFill['leadpop_branding'] = 0;
        }
        foreach($arrayFill as $key => $val){
            $arrayFill[$key] = ($val === 'on')?1:$val;
        }
        if($branding) {
            $branding->fill($arrayFill)->save();
        }
        else{
            $branding = new LeadpopBranding();
            $branding->fill($arrayFill)->save();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LeadpopBranding  $leadpopBranding
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LeadpopBranding $leadpopBranding)
    {
        LP_Helper::getInstance()->getCurrentHashData($request->input("current_hash"));
        try{
            if (LP_Helper::getInstance()->getCurrentHash()) {
                $funnel_data = LP_Helper::getInstance()->getFunnelData();
                $client = Clients::where(array('client_id'=> $funnel_data['client_id']))->first();
                $period = $request->input('period');

                //addon == 0 means addon adding with subscription id, addon =1 means only adding the addon
                $addon = $request->input('addon');

                //plan list according the current plan
                $planList = $this->_createPlanAddonArray();
                $branding_plans = $planList['addOn'];
                $brandingPlanId = $branding_plans[$period]['plan_id'];
                if(isset($planList['plan'])) {
                    if ($period && $client->client_plan_subscription_id) {
                        $success_txt = "Branding feature unlocked. Please wait while redirecting to leadPops branding settings.";

                        # UPGRADE PLAN TO PRO FROM MARKETER (Currently Its not updating plan status which should be update but need confirmation from AP)
                        if ($addon === LP_Constants::ADD_BRANDING_WITH_PLAN_UPGRADE) {
                            $plans = $planList['plan'];

                            // PRO Clients can't change their Primary Plan
                            if($planList['currentPlan'] === LP_Constants::PLAN_LEVEL_MARKETER) {
                                unset($plans['marketer']);
                                unset($plans[$planList['currentPlan']]);

                                if(array_key_exists($period, $plans['pro'])){
                                    $plan = $plans['pro'][$period];
                                } else {
                                    $plan = $plans['pro']['month'];
                                }

                                //plan key according to selected plan
                                $newPlanId = strip_tags($plan['plan_id']);

                                // Upgrade customer's subscription to new plan from MARKETER to PRO
                                $upgradeSubscriptionResponse = ChargeBeeHelpers::updateChargebeeCustomerPlan($client->client_plan_subscription_id, $newPlanId);
                                if (!$upgradeSubscriptionResponse['status']) {
                                    throw new \Exception($upgradeSubscriptionResponse['message']);
                                }

                                $client->client_plan_subscription_id = $upgradeSubscriptionResponse['result']['subscription']['id'];
                                $client->client_plan_id = $newPlanId;
                            }

                            $success_txt = "Your plan upgraded & branding feature unlocked. Please wait while redirecting to leadPops branding settings.";
                        }

                        # ADD BRANDING PACKAGE AGAINST CLIENT IN CHARGEBEE
                        $existingBrandingSubscription = ChargeBeeHelpers::getChargebeeCustomerSubscription($client->chargebee_customer_id, $brandingPlanId);
                        $status = 'cancelled';
                        if(count($existingBrandingSubscription['result']) > 0) {
                          $status =  $existingBrandingSubscription['result'][0]['subscription']['status'];
                        }
                        if(count($existingBrandingSubscription['result']) == 0 or $status != 'active') {
                            // Attaching Branding Plan to customer based on user's selection its Monthly or yearly branding package
                            $brandingSubscription = ChargeBeeHelpers::addNewPlanSubscription($client->chargebee_customer_id, $brandingPlanId);
                            if (!$brandingSubscription['status']) {
                                throw new \Exception($brandingSubscription['message']);
                            }
                        }

                        $client->branding_plan_id = $brandingPlanId;
                        $client->save();

                        $request['client_id'] = $funnel_data['client_id'];
                        $request['leadpop_version_id'] = $funnel_data['leadpop_version_id'];
                        $request['leadpop_version_seq'] = $funnel_data['leadpop_version_seq'];
                        $request['leadpop_branding_active'] = 1;
                        $request['leadpop_branding'] = 1;
                        $this->saveBranding($request);

                        // Return error message in case of exception
                        return response()->json(['success' => true, 'message' => $success_txt]);
                    }
                    else {
                        // Return error message in case of exception
                        return response()->json(['error' => false, 'message' => 'Something went wrong. Please try again!', 'responseText' => 'Subscription ID is required.']);
                    }
                }
                else{
                    // Return error message in case of exception
                    return response()->json(['error' => false, 'message' => 'Something went wrong. Please try again!', 'responseText' => 'Plan list is empty. Please check the plans against current login client in chargebee plans table.']);
                }
            }
        }
        catch (\Exception $e){
            // Return error message in case of exception
            return response()->json(['error' => false, 'message' => "Exception: ".$e->getMessage()]);
        }
    }

    //plan filter with key and value
    private function planFilterParentKey($plan,$key,$value): string
    {
        foreach($plan as $k => $v){
            if($v[$key] === $value){
             return $k;
            }
        }
    }

    public function uploadImage(Request $request){
        LP_Helper::getInstance()->getCurrentHashData();
        if(LP_Helper::getInstance()->getCurrentHash()){
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
            $validator = Validator::make($request->all(), [
                'branding' => 'mimes:gif,jpeg,jpg,png'
            ]);

            if ($validator->fails()) {
                $message = CustomErrorMessage::getInstance()->setFirstError($validator, "branding");
                return $this->errorResponse($message);
            }

            $file = preg_replace('/[^\.a-zA-Z0-9]/', '', $request->file('branding')->getClientOriginalName());
            $imageName = strtolower($funnel_data['client_id'] . "_" . $funnel_data['leadpop_id'] . "_" . $funnel_data['leadpop_type_id'] . "_" .  $funnel_data['leadpop_vertical_id'] . "_" . $funnel_data['leadpop_vertical_sub_id'] . "_" . $funnel_data['leadpop_template_id'] . "_" . $funnel_data['leadpop_version_id'] . "_" . $funnel_data['leadpop_version_seq'] . "_" . $file);
            $section = substr($funnel_data['client_id'], 0, 1);
            $imagePath = $section . '/' . $funnel_data['client_id'] . '/pics/' . $imageName;
            list($width,$height,$type) =  getimagesize($request->file('branding')->getRealPath());
            $resizeWidth = config('lp.branding_file_dimension.width');
            $resizeHeight = config('lp.branding_file_dimension.height');
            list($newWidth,$newHeight)  = explode("~",getImageDimensions($width, $height, $resizeWidth, $resizeHeight));
            if($width > $resizeWidth){
                $imagePath = dir_to_str($imagePath, true);
                imageResize($request->file('branding')->getRealPath(), $width, $height, $newWidth, $newHeight, $type, $imagePath);
                $response = move_file_to_rackspace($imagePath);
            }
            else{
                $response = move_uploaded_file_to_rackspace($request->file('branding')->getRealPath(), $imagePath);
            }
            $response['rs_cdn'] = $imageName;
            $response['width'] = $newWidth;
            $response['height'] = $newHeight;
            return $response;
        }else{
            return $this->_redirect();
        }
    }

    function brandingGlobalSetting(Request $request){
        LP_Helper::getInstance()->getCurrentHashData($request->input("current_hash"));
        if (LP_Helper::getInstance()->getCurrentHash()) {
        $lplist = explode(",", $request['selected_funnels']);
        $lplist = collect($lplist);
        // To ADD Source Funnel in Global QUE
        $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($_POST['current_hash']);
        if (isset($_POST['current_hash'])) {
            $lplist->prepend($currentFunnelKey);
            $lplist = $lplist->unique()->values()->all();
        }
        $lplist = GlobalHelper::createKeyArrayformString($lplist);

        $leadpop_ids =  $lplist->pluck( 'leadpop_id' )->unique()->all();
        $leadpop_version_seqs = $lplist->pluck( 'leadpop_version_seq' )->unique()->all();
        $client_leadpops_data = ClientsLeadpops::select('leadpop_version_id', 'leadpop_version_seq')->whereIn('leadpop_active', [1])->whereIn('client_id', [$this->registry->leadpops->clientInfo['client_id']])->whereIn('leadpop_id' , $leadpop_ids)->whereIn('leadpop_version_seq',$leadpop_version_seqs)->get()->toArray();
        $request['client_id'] =  $this->registry->leadpops->clientInfo['client_id'];
        $request['image_dimension'] = json_encode(['h'=>$request->get('image_height'), 'w'=>$request->get('image_width')]);
        unset($request['image_height']);
        unset($request['image_width']);
        foreach($client_leadpops_data as $val){
            $request['leadpop_version_id'] = $val['leadpop_version_id'];
            $request['leadpop_version_seq'] = $val['leadpop_version_seq'];
            $this->saveBranding($request);
        }
            return $this->successResponse('The funnel branding changes have been saved on selected Funnels.');
        }
        return $this->errorResponse('Your request was not processed. Please try again.');
    }
}
