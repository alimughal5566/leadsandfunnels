<?php

namespace App\Http\Controllers;

use App\Constants\FunnelVariables;
use App\Constants\Layout_Partials;
use App\Helpers\ChargeBeeHelpers;
use App\Helpers\HooksClient;
use App\Models\Clients;
use App\Models\ClientVerticalPackagesPermissions;
use App\Repositories\CustomizeRepository;
use App\Repositories\LeadpopsRepository;
use App\Repositories\LpAccountRepository;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
use App\Services\gm_process\InfusionsoftGearmanClient;
use App\Services\gm_process\MyLeadsEvents;
use App\Services\gm_process\ReportSqlHelper;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use LP_Helper;
use Session;
use iSDK;
use DateTime;
class IndexController extends BaseController {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LpAdminRepository $lpAdmin){
        $this->middleware(function($request, $next) use ($lpAdmin) {
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(\Session::get('leadpops'));
            $this->init($lpAdmin);
            if($request->ajax()) $this->check_ajax_session(); else $this->check_session(1);
            return $next($request);
        });
    }

    public function testpage(Request $request){
        \Illuminate\Support\Facades\Redis::set('thetest','theteststring-test');
        $test = \Illuminate\Support\Facades\Redis::get('thetest');
        return view('welcome', ['test' => $test]);
        // return view('welcome');

    }

    public function indexAction(LeadpopsRepository $leadpops, Request $request){
        // action body
        $this->registry->leadpops->adclickedkey = $this->getAdKey($this->client_id);
        list($verticalName ,$verticalSubName) = explode("~",$this->registry->leadpops->adclickedkey);
        if(is_file($_SERVER['DOCUMENT_ROOT'].config('view.theme_assets')."//js/pagination.js")) {
            array_push($this->assets_js, config('view.theme_assets') . '/js/pagination.js');
        }

        $this->registry->leadpops->AdcustomVertical = $verticalName;
        $this->registry->leadpops->AdcustomSubvertical = $verticalSubName;

        $s = "select id from leadpops_verticals where lead_pop_vertical = '".$this->registry->leadpops->AdcustomVertical."' ";
        $this->registry->leadpops->AdcustomVertical_id = $this->db->fetchOne($s);

        $this->data->displayCorporate = 'n';
        /* corporate is not available in devleadspops so commenting this SQL */
        /*
        $s = "select * from corporate where corp_id = ".$this->client_id . " and active = 'y' ";
        $corporate = $this->db->fetchAll($s);

        if($corporate) {
            $this->registry->leadpops->corp_id = $this->client_id;
            $this->data->corp_id = $this->client_id;
            $this->data->corpClients = $corporate;
            $this->data->displayCorporate = 'y';
        }
        */
        $s = "select id from leadpops_verticals_sub where leadpop_vertical_id = ".$this->registry->leadpops->AdcustomVertical_id." ";
        $s .= " and lead_pop_vertical_sub = '".$this->registry->leadpops->AdcustomSubvertical."' ";
        $this->registry->leadpops->AdcustomSubvertical_id = $this->db->fetchOne($s);

        $this->data->workingLeadpop = @$this->registry->leadpops->workingLeadpop;
        $this->data->clickedkey = @$this->registry->leadpops->clickedkey;

        $this->registry->leadpops->hasunlimited = 'y'; // reset this flag is you are re-directed here

        $this->data->seenwelcome = 'n'; #$leadpops->getSeenWelcome($this->client_id);
        $this->data->client_id = $this->client_id;
        $this->data->clientName = \View_Helper::getInstance()->getClientName($this->client_id);

        $this->registry->leadpops->skipnewadmin = 'n';
        $this->data->leadpopList  = array();
        $fields = 'clone';
        $this->registry->leadpops->cloneLeadpop = $leadpops->getPackagePermissions($this->client_id,$fields);
        $this->data->cloneLeadpop = $this->registry->leadpops->cloneLeadpop;
        $this->overlay_data = LP_Helper::getInstance()->get_overlay_detail();

        $this->data->client_type = LP_Helper::getInstance()->get_loggedin_client_info()['client_type'];
        $this->header_partial = Layout_Partials::HOME;

        // check if previous url is set to redirect to, we cannot redirect
        // in start of this function because subsequent page depends on
        // session state set by above code
        $previousUrl = $request->session()->pull('lp.previousUrl');

        // if previous url is set for redirection
        if($previousUrl != null && strpos($previousUrl, LP_PATH."login")!==FALSE){
            // we simply redirect to it
            return redirect($previousUrl);
        }
        $this->data->stats_video = $this->lp_admin_model->getVideoByKey("stats", "summary");
//        dd($this->data);
        return $this->response();
    }

    private function getAdKey ($client_id) {
        /*
        $s =  " select distinct a.leadpop_vertical_id,a.leadpop_vertical_sub_id ";
        $s .= " from leadpops a,clients_leadpops b ";
        $s .= " where b.client_id = " . $client_id;
        $s .= " and b.leadpop_id = a.id limit 1 ";
        */

        $s = "SELECT a.leadpop_vertical_id, a.leadpop_vertical_sub_id FROM leadpops a INNER JOIN clients_leadpops b ON b.leadpop_id = a.id WHERE client_id = ".$client_id." LIMIT 1";
        $vertical = $this->db->fetchAll($s);

        $s = "select lead_pop_vertical from leadpops_verticals where id  = " . $vertical[0]['leadpop_vertical_id'];
        $verticalName = $this->db->fetchOne($s);

        $s = "select lead_pop_vertical_sub from leadpops_verticals_sub ";
        $s .= " where leadpop_vertical_id = " . $vertical[0]['leadpop_vertical_id'];
        $s .= " and id = " . $vertical[0]['leadpop_vertical_sub_id'];
        $verticalSubName = $this->db->fetchOne($s);
        $adkey = $verticalName ."~". $verticalSubName . "~" . $client_id;
        return $adkey;
    }


    public function clonefunnel(Request $request, CustomizeRepository $customizeRepo) {

        if(LP_Helper::getInstance()->getCloneFlag()!='y'){
            return;
        }

        LP_Helper::getInstance()->getCurrentHashData($request->input("current_hash"));
        if(LP_Helper::getInstance()->getCurrentHash()){
            $now = new \DateTime();
            $funnelData = LP_Helper::getInstance()->getFunnelData();

            $registry = \App\Services\DataRegistry::getInstance();
            $leadpopType = $funnelData['funnel']['leadpop_type_id'];                // This variable holds leadpop_type_id for source funnel (i.e which is being cloned)
            $old_domain_id = $funnelData['funnel']['domain_id'];

            $lpHelper = LP_Helper::getInstance();
            $domainData = $lpHelper->getDomainDataByIdAndType($old_domain_id, $leadpopType);
            $new_leadpop_id = $domainData->leadpop_id;

            if($leadpopType == config('leadpops.leadpopDomainTypeId')){ //fetching new subdomain leadpop ID
                $new_leadpop_id = \DB::table("leadpops")
                    ->where("leadpop_type_id", config('leadpops.leadpopSubDomainTypeId'))
                    ->where("leadpop_vertical_id", $domainData->leadpop_vertical_id)
                    ->where("leadpop_vertical_sub_id", $domainData->leadpop_vertical_sub_id)
                    ->where("leadpop_template_id", $domainData->leadpop_template_id)
                    ->where("leadpop_version_id", $domainData->leadpop_version_id)
                    ->value("id");
            }
            $max_version_seq = $lpHelper->getMaxVersionSequence();
            // $leadpopIds in where is leading towards miss calculation of leadpops_version_seq therefore removed
          //  $max_version_seq = $lpHelper->getMaxVersionSequence([$domainData->leadpop_id, $new_leadpop_id]);
            $max_version_seq += 1; // increase sequence by one

            if($registry->leadpops->clientInfo['is_fairway'] == 1) $trial_launch_defaults = "trial_launch_defaults_fairway";
            else if($registry->leadpops->clientInfo['is_mm'] == 1) $trial_launch_defaults = "trial_launch_defaults_mm";
            else $trial_launch_defaults = "trial_launch_defaults";

            // get trial info from version_seq = 1 because if funnel is cloned manny times the higher version_seq not exist in trial tables
            $s = "select * from ".$trial_launch_defaults;
            $s .= " where leadpop_vertical_sub_id = " . $domainData->leadpop_vertical_sub_id ;
            $s .= " and leadpop_template_id = " . $domainData->leadpop_template_id;
            $s .= " and leadpop_version_id  = " . $domainData->leadpop_version_id;
            $s .= " ORDER BY leadpop_version_seq ASC";
            $trialDefaults = $this->db->fetchRow($s);

            $s = "SELECT * FROM clients_leadpops WHERE client_id=".$this->client_id." AND leadpop_version_id=".$domainData->leadpop_version_id;
            $s .= " AND leadpop_version_seq=" . $domainData->leadpop_version_seq;
            $ex_clients_leadpops = $this->db->fetchRow( $s );

            if(!$ex_clients_leadpops || empty($ex_clients_leadpops) ){
                return;
            }

            $funnel_name =  ($this->registry->leadpops->clientInfo['dashboard_v2'] == 1) ? $request->input('funnel_name') : $ex_clients_leadpops['funnel_name']." Clone";
            if(isset($_COOKIE['clone']) and $_COOKIE['clone'] == 1){
                echo $new_leadpop_id;
                die;
            }

            $new_leadpop_type = config('leadpops.leadpopSubDomainTypeId');
            $subdomain = $request->input('subdomain');
            if(config('leadpops.funnel_subdomain_postfix') !== ""){
                if(strpos($subdomain, config('leadpops.funnel_subdomain_postfix')) !== false) {
                    $subdomain = str_replace(config('leadpops.funnel_subdomain_postfix'), "", $subdomain);
                }
                $subdomain =  $subdomain . config('leadpops.funnel_subdomain_postfix');
            }
            $topdomain =  $request->input('topleveldomain');

            if ($leadpopType == $new_leadpop_type) { // subdomain case
                // Start Customize Sub Domain functionality
                $clients_subdomains = array(
                    'client_id' => $this->client_id,
                    'subdomain_name' => $subdomain,
                    'top_level_domain' => $topdomain,
                    'leadpop_vertical_id' => $domainData->leadpop_vertical_id,
                    'leadpop_vertical_sub_id' => $domainData->leadpop_vertical_sub_id,
                    'leadpop_type_id' => $new_leadpop_type,
                    'leadpop_template_id' => $domainData->leadpop_template_id,
                    'leadpop_id' => $new_leadpop_id,
                    'leadpop_version_id' => $domainData->leadpop_version_id,
                    'leadpop_version_seq' => $max_version_seq
                );
                $new_domain_id = $this->db->insert('clients_funnels_domains', $clients_subdomains);
            }
            else{
                // Domain Case
                if ($topdomain == "") $topdomain = "secure-clix.com";
                $clients_subdomains = array(
                    'client_id' => $this->client_id,
                    'subdomain_name' => $subdomain,
                    'top_level_domain' => $topdomain,
                    'leadpop_vertical_id' => $domainData->leadpop_vertical_id,
                    'leadpop_vertical_sub_id' => $domainData->leadpop_vertical_sub_id,
                    'leadpop_type_id' => $new_leadpop_type,
                    'leadpop_template_id' => $domainData->leadpop_template_id,
                    'leadpop_id' => $new_leadpop_id,
                    'leadpop_version_id' => $domainData->leadpop_version_id,
                    'leadpop_version_seq' => $max_version_seq
                );
                $new_domain_id = $this->db->insert('clients_funnels_domains', $clients_subdomains);
            }
            //assing folder if condition will work for theme admin3 else for theme admin2
            if(getenv('APP_THEME') == "theme_admin3"){
                //new folder id
                $folder_id = $request->input('folder_id');
                $tags = $request->input('tag_list');
                $cloning = 'v3';
            }
            else {
                //old folder id
                $folder_id = $ex_clients_leadpops['leadpop_folder_id'];
                $tags = '';
                $cloning = 'v2';
            }

            $s = "INSERT INTO clients_leadpops (question_sequence, funnel_questions, funnel_variables, conditional_logic, lead_line, second_line_more, client_id, leadpop_id, leadpop_version_id, leadpop_active,";
            $s .= " access_code, leadpop_version_seq, funnel_market, static_thankyou_active, static_thankyou_slug, lt_client_id, lt_user_id, xverify_flag, date_added, date_updated, language, funnel_name, container,leadpop_folder_id)";
            $s .= " SELECT question_sequence, funnel_questions, funnel_variables, conditional_logic, lead_line, second_line_more, client_id, ".$new_leadpop_id.", leadpop_version_id, leadpop_active,";
            $s .= " access_code, ".$max_version_seq.", funnel_market, static_thankyou_active, static_thankyou_slug, lt_client_id, lt_user_id, xverify_flag, '".$now->format('Y-m-d H:i:s')."', '".$now->format('Y-m-d H:i:s')."',";
            $s .= " language, '".$funnel_name."', container,'".$folder_id."' FROM clients_leadpops WHERE id = ".$ex_clients_leadpops['id'];

            $client_leadpop_id = $this->db->query( $s );



            $clientsLeadpopsAttributes = array(
                'client_id' => $this->client_id,
                'clients_leadpop_id' => $client_leadpop_id,
                'is_clone' => 1
            );
            $this->db->insert('clients_leadpops_attributes', $clientsLeadpopsAttributes);




            $cloneClientInfo = array(
                'leadpop_type' => $leadpopType,
                'new_leadpop_type'=> config('leadpops.leadpopSubDomainTypeId'),
                'client_id' => $this->client_id,
                'funnel_name' => $funnel_name,
                'max_seq' => $max_version_seq,
                'new_funnel_leadpop_id' => $new_leadpop_id,
                'ex_clients_leadpops' => $ex_clients_leadpops,
                'client_domain' => (array) $domainData, //subdomain / domain data
                'subdomain_type' => config('leadpops.leadpopSubDomainTypeId'),
                'trialDefault' => $trialDefaults,
                'client_leadpop_id' => $client_leadpop_id,
                'old_domain' => $lpHelper->getDomainName($domainData),
                'subdomain' => $request->input('subdomain'),
                'topdomain' => $request->input('topleveldomain'),
                'old_domain_id' => $old_domain_id,
                'tags' => $tags,
                'cloning' => $cloning,
                'new_domain_id' => $new_domain_id,
            );

            // client clone funnel through gearman
            if (env('GEARMAN_ENABLE') == "1") {
                MyLeadsEvents::getInstance()->clientCloneFunnel($cloneClientInfo);
            }
            /* MOVEMENT GEARMAN INTEGATION CODE - START - new-funnel */

            if ($registry->leadpops->clientInfo['gearman_enable'] == 1) {
                $now = new \DateTime();
                $funnelInfo = $this->db->fetchAll(ReportSqlHelper::Instance()->funnels($this->client_id, $client_leadpop_id));
                if ($funnelInfo) {
                    $funnelInfo[0]['is_clone'] = 1;
                    $funnelInfo[0]['create_date'] = $now->format("Y-m-d H:i:s");
                    $funnelInfo[0]['update_date'] = $now->format("Y-m-d H:i:s");
                    $funnelInfo[0]['is_deleted'] = 0;
                }
            }

            return \response()->json(['message' =>  config("alerts.cloneFunnelSuccess." . config('view.theme')),'result' => $this->loadFunnel()]);

            /* MOVEMENT GEARMAN INTEGATION CODE - END */
        }
    }

    public function deletefunnel(Request $request) {
        LP_Helper::getInstance()->getCurrentHashData($request->input("current_hash"));
        if(LP_Helper::getInstance()->getCurrentHash()) {
            $funnelData = LP_Helper::getInstance()->getFunnelData();

            $leadpopType = $funnelData['funnel']['leadpop_type_id'];
            $domainId = $funnelData['funnel']['domain_id'];

            $setColumn = array('leadpop_active' => '3');

            $where = "client_id = " . $this->registry->leadpops->client_id;
            $where .= " and leadpop_id = " . $funnelData['funnel']["leadpop_id"];
            $where .= " and leadpop_version_id = " . $funnelData['funnel']["leadpop_version_id"];
            $where .= " and leadpop_version_seq = " . $funnelData['funnel']["leadpop_version_seq"];
            //$where .= " and leadpop_type_id = " . $leadpopType;

            $this->db->update( 'clients_leadpops', $setColumn, $where );
            if(getenv('APP_THEME') == "theme_admin3") {
                Session::flash('success', config("alerts.deleteFunnelSuccess." . config('view.theme')));
            }

            return $this->lp_redirect('/');
        }
    }

    public function upgradeClientToProPlan(Request $request){
        $client = Clients::where('client_id', $this->client_id)->first();
        $clientPackagePermission = ClientVerticalPackagesPermissions::where('client_id', $this->client_id)->first();

        // We will check for each exception that could happen during update
        // and return descriptive error
        try{
            // We should fail early if we are in an unexpected state
            if(!$client){
                throw new \Exception('Client not found');
            }
            if(!$clientPackagePermission){
                throw new \Exception('Client vertical package not found');
            }

            // Plan period (month or year)
            $planPeriod = $request->input('period');

            // Set default plan Id if not defined in DB
            if(empty($client->client_plan_id)){
                $currentPlanId = ChargeBeeHelpers::getDefaultPlanId();
            } else {
                $currentPlanId = $client->client_plan_id;
            }

            // Get plan info for current plan
            $currentPlanInfo = ChargeBeeHelpers::getChargebeePlanById($currentPlanId);
            // If there is no plan in chargebee for, then return error
            if(!$currentPlanInfo['status']){
                throw new \Exception($currentPlanInfo['message']);
            }

            // Return error if plan not found
            if(empty($currentPlanInfo['result']['plan'])){
                throw new \Exception('Plan not found for given plan Id');
            }

            // Client type for current plan
            $clientType = $currentPlanInfo['result']['plan']['cf_client_type'];

            // Plan upgrade map based on client type
            $map = config('chargebee.plan_upgrade_map');

            if(empty($map[$clientType][$currentPlanId][$planPeriod])){
                throw new \Exception("Client upgrade plan ID not defined in map for $planPeriod period");
            }

            // Get customer data from chargebee
            $customer = ChargeBeeHelpers::getChargebeeCustomer($client->contact_email);

            // If customer data not found, return related error
            if(!$customer['status']){
                throw new \Exception($customer['message']);
            }

            if(empty($customer['result'][0]['customer']['id'])){
                throw new \Exception('Could not find chargebee customer for client\'s email');
            }

            $customerId = $customer['result'][0]['customer']['id'];

            // Get subscription data for current plan
            $subscriptionResponse = ChargeBeeHelpers::getChargebeeCustomerSubscription($customerId, $currentPlanId);

            // If subscription data not found, return error
            if(!$subscriptionResponse['status']){
                throw new \Exception($subscriptionResponse['message']);
            }

            if(empty($subscriptionResponse['result'][0]['subscription']['id'])){
                throw new \Exception('No subscription found for current plan');
            }

            // Subscription Id for current plan
            $subscrptionId = $subscriptionResponse['result'][0]['subscription']['id'];

            // Upgrade plan Id
            $newPlanId = $map[$clientType][$currentPlanId][$planPeriod];

            // Upgrade customer's subscription to new plan
            $upgradeSubscriptionResponse = ChargeBeeHelpers::updateChargebeeCustomerPlan($subscrptionId, $newPlanId);

            // Return error if not successfully upgraded
            if(!$upgradeSubscriptionResponse['status']){
                throw new \Exception($upgradeSubscriptionResponse['message']);
            }

            // Save upgraded plan to client's table
            $client->client_plan_id = $newPlanId;
            // Update funnel clone flag
            $clientPackagePermission->clone = 'y';

            $client->save();
            $clientPackagePermission->save();

            // We are here, it means we have successfully upgraded plan
            return response()->json(['success' => true]);

        } catch (\Exception $e){
            // Return error message in case of exception
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    //tag and folder mapping
    public function tagmapping(){
        $id = (int)$_GET['id'];
        $sql = "select c_lp.id as client_leadpop_id,c_lp.leadpop_id,c_sd.client_id,lp_v.lead_pop_vertical,
            lp_gp.group_name,lp_vs.fs_display_label,c_lp.funnel_market
            from clients_funnels_domains c_sd
            INNER JOIN `leadpops_verticals` lp_v ON lp_v.id = c_sd.`leadpop_vertical_id`
            INNER JOIN leadpops_verticals_sub lp_vs ON lp_vs.id = c_sd.leadpop_vertical_sub_id
            INNER JOIN leadpops_vertical_groups lp_gp ON lp_gp.id = lp_vs.group_id
            INNER JOIN clients_leadpops c_lp ON (
            c_lp.client_id = c_sd.client_id
	        AND c_lp.leadpop_id = c_sd.leadpop_id
            AND c_lp.leadpop_version_id  = c_sd.leadpop_version_id
	        AND c_lp.leadpop_version_seq  = c_sd.leadpop_version_seq
	        )  ";

        $whereTemp = "((c_sd.leadpop_type_id = " . config('leadpops.leadpopSubDomainTypeId') . " AND c_sd.subdomain_name NOT LIKE '%temporary%')
	            OR (c_sd.leadpop_type_id = " . config('leadpops.leadpopDomainTypeId') . " AND c_sd.domain_name NOT LIKE '%temporary%'))";

        if(is_numeric($id)) {
            $sql .=" WHERE c_sd.client_id = " . $id . " AND " . $whereTemp;
        } else {
            $sql .= " WHERE " . $whereTemp;
        }
        $sql .= " GROUP BY c_sd.domain_name, CONCAT(c_sd.subdomain_name,'.',c_sd.top_level_domain)";

        $r = $this->db->fetchAll($sql);
        foreach($r as $v) {

            assign_tag_to_funnel($v['client_leadpop_id'],$v['leadpop_id'],$v['group_name']);
            $t = strpos_arr($v['fs_display_label']);
            if($t != false){
                $t = $t;
            }else{
                $t = $v['fs_display_label'];
            }
            assign_tag_to_funnel($v['client_leadpop_id'],$v['leadpop_id'],$t);
            if($v['funnel_market'] == 'w'){
                $folder_id =  assign_folder_to_funnel('Website Funnels');
            }else{
                $folder_id =  assign_folder_to_funnel($v['lead_pop_vertical'].' Funnels');
            }
            $data = array(
                'leadpop_folder_id' => $folder_id
            );
            $where = ' id = '.$v['client_leadpop_id']." ";
            $this->db->update('clients_leadpops',$data,$where);
        }
        echo 'Total Funnel ' . count($r) . "<br /><br />";
        if(isset($_COOKIE['sql_tag']) and $_COOKIE['sql_tag'] == 1) {
            debug($sql, '', 0);
            debug($r);
        }
        print('done');

    }

    public function tagfiltersession(Request $request) {

        $this->registry->leadpops->tag_filter = array(
            'funnel' => $request->input('funnel'),
            'funnel_type_name' => $request->input('funnel_type_name'),
            'search_type' => $request->input('search_type'),
            'search_type_name' => $request->input('search_type_name'),
            'tag_type' => $request->input('tag_type'),
            'tag_type_name' => $request->input('tag_type_name'),
            'tag' => $request->input('tag'),
            'funnel_search' => $request->input('funnel_search'),
            'funnel_url' => $request->input('funnel_url'),
            'sort' => $request->input('sort'),
            'sort_name' => $request->input('sort_name'),
            'order' => $request->input('order'),
            'perPage' => $request->input('perPage'),
            'page' => $request->input('page'),
            'sidebar' => $request->input('sidebar'),
            'searchFilter' => $request->input('searchFilter'),
            'excludeVisitor' => $request->input('excludeVisitor'),
            'filterFunnelVisitor' => $request->input('filterFunnelVisitor'),
            'statsFilter' => $request->input('statsFilter'),
            'excludeConversionRate' => $request->input('excludeConversionRate'),
            'filterConversionRate' => $request->input('filterConversionRate')
        );
        $this->registry->updateRegistry();
        $data = array(
            'dashboard_menu_filter' => json_encode($this->registry->leadpops->tag_filter)
        );
        $where = ' client_id = '.$this->registry->leadpops->client_id." ";
        $this->db->update('clients',$data,$where);
        echo 'tag filter saved in session!';
    }

    function clienttraningsetting(CustomizeRepository $cus_obj){
        $return_val= $cus_obj->setClientTrainingSetting($this->registry->leadpops->client_id);
        echo $return_val;
    }

    public function modifydomainstatusAction () {
        $now = new DateTime();
        $status   = $_POST["status"]; // active or inactive
        $domainId = $_POST['domain_id'];
        $leadpop_id   = $_POST["leadpop_id"];
        $leadpop_version_id   = $_POST["leadpop_version_id"];
        $leadpop_version_seq   = $_POST["leadpop_version_seq"];

        $s = "  update clients_leadpops set leadpop_active = " . ( $status == "true" ? '1' : '0' ). ", last_edit = '" . $now->format("Y-m-d H:i:s") . "'";
        $s .= " where leadpop_id = " . $leadpop_id . " and client_id = " . $this->registry->leadpops->client_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
        $this->db->query( $s );
        if ( $status == "true" ) {
            echo json_encode(array("status"=>"active"));
        } else {
            echo json_encode(array("status"=>"inactive"));
        }
    }

    function setoverlaysessionflagAction(){
        $this->registry->leadpops->show_overlay = 0;
        echo TRUE;
    }

    function overlaycancelAction(){
        $client_id=$this->registry->leadpops->client_id;
        if($client_id){
            $s = "update clients set overlay_flag = 0 where client_id = ".$client_id;
            $this->db->query($s);
            $this->registry->leadpops->show_overlay = 0;
        }
        echo TRUE;
    }

    private function generateRandomString($length = 10) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    private function getHttpServer() {
        $s = "select http from httpclientserver limit 1 " ;
        $http = $this->db->fetchOne($s);
        return $http;
    }

    private function getHttpAdminServer() {
        $s = "select http from httpadminserver limit 1 " ;
        $http = $this->db->fetchOne($s);
        return $http;
    }

    /**
     * @param LpAccountRepository $account
     */
    public function syncportalpasswordAction (LpAccountRepository $account) {
        $email="";
        $clientInfo = $account->getClient($this->registry->leadpops->client_id);

        if($clientInfo['client_id']){
            if($clientInfo['is_mm'] == 1 || $clientInfo['is_fairway'] == 1){

                if($clientInfo['is_mm'] == 1){
                    $portal = MOVEMENT_PORTAL;
                }
                else if($clientInfo['is_fairway'] == 1){
                    $portal = FAIREAY_PORTAL;
                }

                $api_url = $portal . "/api/myleads/sync/password";
                $domain = str_replace(array("http://", "https://"), "", $portal);

                if($clientInfo['ifs_email']==''){
                    $email = $clientInfo['contact_email'];
                }else{
                    $email = $clientInfo['ifs_email'];
                }

                $fields = array();
                $fields['email'] = $email;
                $fields['password'] = $clientInfo['password'];

                $fields_string = http_build_query($fields);

                $ch = curl_init();
                curl_setopt( $ch, CURLOPT_URL, $api_url );
                curl_setopt( $ch, CURLOPT_POST, true );
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields_string );
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec( $ch );
                curl_close( $ch );
                $result=json_decode($response, true);
                if($result['status']==200){
                    $s = "update clients set sync_password =1 where client_id = ".$this->registry->leadpops->client_id;
                    $this->db->query($s);

                    //Send Password to IFS
                    if(env('APP_ENV') === config('app.env_production')) {
                        $ifs_data = array();
                        $ifs_data['Contact._ReportingPassword'] = $clientInfo['password'];
                        $ifs_email = $email;
                        InfusionsoftGearmanClient::getInstance()->updateContact($ifs_data, $ifs_email);
                    }

                    $email = urlencode($email);
                    $email = str_replace("+", "%2B",$email);
                    $email = urldecode($email);
                    $encrypted_email = str_replace("+", "~", LP_Helper::getInstance()->encrypt($email));
                    $loginUrl = $portal . "/lplogin?myleads=".$encrypted_email;

                    $portal_response = json_encode(array("status"=>"200", "messages"=>array("title"=>"Performance Reporting","description"=>"Success! You've been registered.<br /><br />You can access the portal directly by going to ".$portal.", using the same username and password as your Funnels Admin.<br /><br />You can also click the Performance Reporting Portal button directly from your Funnels Admin. <a href='".$loginUrl."' target='_blank'>Click Here</a> to go there now!")));
                }else{
                    $portal_response = json_encode(array("status"=>"400", "messages"=>array("title"=>'Performance Reporting',"description"=>'Error! Your account doesn\'t have access.')));
                }
                echo $portal_response;
            }
            else{
                $response = json_encode(array("status"=>"400", "messages"=>array("title"=>'Performance Reporting',"description"=>"Error! You are not authorized for perform this activity.")));
                echo $response;
            }
        } else {
            $response = json_encode(array("status"=>"400", "messages"=>array("title"=>'Performance Reporting',"description"=>"Error! Invalid client id.")));
            echo $response;
        }
    }

    public function testgm(Request $request){
        $client_id = $request->get('client_id');
        $client_leadpop_id = $request->get('client_leadpop_id');

        $s      = "SELECT * FROM clients WHERE client_id = " . $client_id . " LIMIT 1 ";
        $client = $this->db->fetchRow( $s );

        lp_debug($client, "Client", false);

        if ($client['gearman_enable'] == 1) {
            $now = new \DateTime();
            $funnelInfo = $this->db->fetchAll(ReportSqlHelper::Instance()->funnels($this->client_id, $client_leadpop_id));
            if ($funnelInfo) {
                $funnelInfo[0]['is_clone'] = 1;
                $funnelInfo[0]['create_date'] = $now->format("Y-m-d H:i:s");
                $funnelInfo[0]['update_date'] = $now->format("Y-m-d H:i:s");
                $funnelInfo[0]['is_deleted'] = 0;
            }
        }
    }

    /**
     * When we will call this function account will be lock and clients table column will be update
     *      payment_pending_flag = 1
     *      active = 0
     *  this will give error => This account is no longer active, please contact support@leadpops.com
     */
    function account_lock(){
        if(!@$_REQUEST['client_id']){
            die("Invalid Access");
        }

        $client_id = $_REQUEST['client_id'];
        $this->db->query("UPDATE clients set payment_pending_flag = 1, active = 0, payment_date = '".date('Y-m-d H:i:s')."' where client_id = $client_id");

        /*
        $app = new iSDK();
        $app->cfgCon("leadpops");
        $returnFields = array('_AssociatedID');
        $query = array('_leadPopsClientID' => $client_id);
        $contacts = $app->dsQuery("Contact",1,0,$query,$returnFields);

        if($contacts[0]){
            $contact = end($contacts);
            $a_client_id = explode('~',$contact['_AssociatedID']);
            foreach ($a_client_id as $_client_id){
                $this->db->query("UPDATE clients set payment_pending_flag = 1, payment_date = '".date('Y-m-d H:i:s')."' where client_id = $_client_id");
            }
        }
        */

        echo json_encode(['status'=>'success', 'message'=>'Account locked.']);
    }

    /**
     * When we will call this function account will be unlock and clients table column will be update
     *      payment_pending_flag = 0
     *      active = 1
     */
    function account_unlock(){
        if(!@$_REQUEST['client_id']){
            die("Invalid Access");
        }

        $client_id = $_REQUEST['client_id'];
        $this->db->query("UPDATE clients set payment_pending_flag = 0, active = 1, payment_date = '".date('Y-m-d H:i:s')."' where client_id = $client_id");

        /*
        $app = new iSDK();
        $app->cfgCon("leadpops");
        $returnFields = array('_AssociatedID');
        $query = array('_leadPopsClientID' => $client_id);
        $contacts = $app->dsQuery("Contact",1,0,$query,$returnFields);

        if($contacts[0]){
            $contact = end($contacts);
            if (stristr($contact['_AssociatedID'],"~")) {
                $a_client_id = explode('~',$contact['_AssociatedID']);
                foreach ($a_client_id as $_client_id){
                    $this->db->query("UPDATE clients set payment_pending_flag = 0, payment_date = '".date('Y-m-d H:i:s')."' where client_id = $_client_id");
                }
            }
            if (stristr($contact['_AssociatedID'],",")) {
                $a_client_id = explode(',',$contact['_AssociatedID']);
                foreach ($a_client_id as $_client_id){
                    $this->db->query("UPDATE clients set payment_pending_flag = 0, payment_date = '".date('Y-m-d H:i:s')."' where client_id = $_client_id");
                }
            }
        }
        */

        echo json_encode(['status'=>'success', 'message'=>'Account unlocked.']);

    }

    //client account pause

    /**
     *If  is_pause = 1 so the client cannot login and no email or SMS notifications will be sent (Lead Alerts)
     * If  is_pause = 0 so the client can login and email or SMS notifications will be sent (Lead Alerts)
     */
    public function accountpause(){
        if(isset($_GET['is_pause']) and isset($_GET['client_id']) and !empty($_GET['client_id'])) {
            $client_id = (int)$_GET['client_id'];
            $is_pause = $_GET['is_pause'];
            $s = "update clients set is_pause = " .$is_pause."
         where ";
            $s .= "client_id = " . $client_id;
            $this->db->query($s);
            print('done');
        }else{
            print('Client ID/ Is Pause Parameter is missing.');
        }

    }

    /**
     * load funnel data for top header search funnel after domain/subdomain and tags/folder insertion and updation for admin v3
     */
    public function loadFunnel(){
        LP_Helper::getInstance()->setAllFunnel( []);
        $this->check_session(1);
       return json_encode(LP_Helper::getInstance()->getAllFunnel() , JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_APOS);
    }
}
