<?php

namespace App\Http\Controllers;

use App\Constants\FunnelVariables;
use App\Constants\LP_Constants;
use App\Helpers\GlobalHelper;
use App\Models\TcpaMessage;
use App\Repositories\CustomizeRepository;
use App\Repositories\LpAccountRepository;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
use App\Services\gm_process\MyLeadsEvents;
use Illuminate\Http\Request;
use leadPops\ThemeController;
use LP_Helper;
use Session;
use function Couchbase\defaultDecoder;

class FunnelController extends BaseController
{

    private $leadpop_vertical_id = 9;
    private $leadpop_vertical_sub_id = 120;
    private $leadpop_group_id = 31;
    private $leadpop_type_id = 1;
    private $leadpop_id = 252;
    private $leadpop_template_id = 126;
    private $leadpop_version_id = 126;
    private $leadpop_version_seq = 1;
    private $funneQuestionJson = '{}';
    private $Default_Model_Customize;
    public $logos = array(
        'eho_image'=>'images/EHO.svg',
        'ehl_image'=>'images/equal-housing-lender.svg',
        'bab_aime_logo'=>'images/bab_aime_logo.png',
    );

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $session;

    public function __construct(LpAdminRepository $lpAdmin, CustomizeRepository $customtizeRepo)
    {
        $this->middleware(function ($request, $next) use ($lpAdmin, $customtizeRepo) {
            $this->Default_Model_Customize = $customtizeRepo;
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(\Session::get('leadpops'));
            $this->init($lpAdmin);
            if($request->ajax()) $this->check_ajax_session(); else $this->check_session();
            $this->session = LP_Helper::getInstance()->getSession();
            //$this->funnelQuestion();
            return $next($request);
        });
    }

    protected function setCommonDataForView($hash_data, $session)
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

    /**
     * load funnel blade
     */
    function index()
    {
        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $this->data->recipients['workingLeadpop'] = @$this->registry->leadpops->workingLeadpop;
            $this->data->recipients['clickedkey'] = @$this->registry->leadpops->clickedkey;
            $this->data->recipients['workingLeadpop'] = $this->lp_admin_model->getWorkingLeadpopDescription($hash_data['funnel']);
            $this->data->recipients['keys'] =$hash_data['_key'];
            $this->data->recipients['clickedkey'] = $hash_data['_key'];
            $this->data->recipients['lpkeys'] = $this->getLeadpopKey($hash_data);
            $this->data->recipients['currenthash'] = $hash_data["current_hash"];
            $this->data->recipients['client_id'] = $this->registry->leadpops->client_id;
        }
        $questions_info = $this->getFunnelQuestions($hash_data['current_hash']);

        $this->data->funnelQuestion = LP_Helper::getInstance()->combine_json_attributes(json_decode($questions_info['funnel_questions'], 1), $hash_data["funnel"]['leadpop_version_id']);
        $this->data->funnelSequence = explode('-', $questions_info['question_sequence']);
        $this->data->funnelHiddenField = LP_Helper::getInstance()->combine_json_attributes(json_decode($questions_info['funnel_hidden_field'], 1));
        $thankyouPageList = $this->Default_Model_Customize->getAllThankYouPages($hash_data, false);
        $check_iteration = 0;
        foreach ($this->data->funnelQuestion as $key=>$findDateType)
        {
            if (isset($findDateType['question-type']) && $findDateType['question-type'] === 'date')
            {
                $this->data->funnelQuestion[$key]['question-type'] = 'birthday';
            }
        }

        $submission = renderThankYouContentCustomArray($thankyouPageList, $hash_data);
        $this->data->thankyouPageList = $submission;
        $this->data->funnelData = $hash_data;
        $this->active_menu = LP_Constants::FUNNEL_BUILDER;

        // set data variables for CTA message modal
        $customize = $this->Default_Model_Customize;

        $this->loadCtaSettings($hash_data);
        // set featured image
        $this->data->featured_image_active = trim($this->Default_Model_Customize->getFunnelVariables($hash_data["funnel"]["client_id"], $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"], FunnelVariables::FRONT_IMAGE));
        // set security messages
        $this->data->ls_tcpa_messages = $this->getSecurityMessages();
        // set cta active class
        $this->data->enable_cta_class = '';
        $clientCta = \DB::table('clients_leadpops_attributes')
            ->where('client_id', $hash_data['client_id'])
            ->where('clients_leadpop_id', $hash_data['client_leadpop_id'])
            ->first();
        if ($clientCta && $this->data->homePageMessageMainMessage != "") {
            if ($clientCta->enable_cta == 1) {
                $this->data->enable_cta_class = 'active';
            }
        } else if ($hash_data["funnel"]['leadpop_version_id'] != config('funnelbuilder.funnel_builder_version_id')) {
            // Make cta message active for pre-made funnels
            $setColumn = array(
                'enable_cta' => 1,
                'client_id' => $hash_data['client_id'],
                'clients_leadpop_id' => $hash_data['client_leadpop_id']
            );
            $this->db->insert('clients_leadpops_attributes', $setColumn);
            $this->data->enable_cta_class = 'active';
        }

        $this->data->conditional_active = 0;
        $this->data->conditionalLogic = $this->data->states = [];
        $this->data->states = LP_Helper::getInstance()->getStatesData();
        $this->data->vehicleModels = LP_Helper::getInstance()->getVehicleModels();
        $this->data->vehicleMake = LP_Helper::getInstance()->getVehicleMakes();
        if($questions_info['conditional_logic'] != 'null' && $questions_info['conditional_logic'] != '{}'){
            $this->data->conditionalLogic = json_decode($questions_info['conditional_logic']);
            if(isset($this->data->conditionalLogic->active)){
                $this->data->conditional_active = $this->data->conditionalLogic->active;
            }
            else{
                abort(423, "There's some data conflict for conditonal logic, Please contact support to upgrade funnel conditions.");
            }
        }

        // fetch header and footer info to use in right side previews on add/edit question screen
        $this->fetchHeaderFooterInfo($hash_data, $customize);
        $this->data->thankyoupageLogo = \View_Helper::getInstance()->getCurrentLogoImageSource($this->registry->leadpops->clientInfo['client_id'], 0, $hash_data) ;
        $this->data->advancedfooteroptions = $this->Default_Model_Customize->getAdvancedFooteroptions($hash_data);
        // client total integrations enabled on funnel
        $this->data->client_integrations = LP_Helper::getInstance()->hasClientIntegrations($hash_data);
        return $this->response();
    }

    /**
     * Fetch header footer info
     *
     * @param $hash_data
     * @param $customize
     */
    private function fetchHeaderFooterInfo($hash_data, $customize)
    {
        // fetch current logo if exists otherwise use default logo
        $this->data->selected_logo_src = \View_Helper::getInstance()->getCurrentLogoImageSource($hash_data['client_id'], 0, $hash_data["funnel"]);
        if ($this->data->selected_logo_src == "") {
            $stock = $this->Default_Model_Customize->getStockLogoSources($hash_data["client_id"], $hash_data["funnel"]);
            $astock = explode("~", $stock);
            $this->data->selected_logo_src = $astock[1];
        }

        // fetch contact info
        $footer_copyright = '';
        $contact = $customize->getContactOptions($hash_data["funnel"]["client_id"], $hash_data["funnel"]["leadpop_vertical_id"], $hash_data["funnel"]["leadpop_vertical_sub_id"], $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"]);
        $contact_info = array();
        if($contact){
            if ($contact['companyname_active'] == 'y') $contact_info['companyname'] = $contact['companyname'];
            if ($contact['phonenumber_active'] == 'y') $contact_info['phonenumber'] = $contact['phonenumber'];
            if ($contact['email_active'] == 'y') $contact_info['email'] = $contact['email'];
//            if ($contact['companyname_active'] == 'y') $footer_copyright.= $contact['companyname'];
        }
        $this->data->contact_info = $contact_info;

        // fetch footer links
        $bottomlinks = $customize->getBottomLinks($hash_data["client_id"], $hash_data["leadpop_vertical_id"], $hash_data["leadpop_vertical_sub_id"], $hash_data["leadpop_id"], $hash_data["leadpop_version_seq"]);
        $bottom_links = array();

        if($bottomlinks) {
            if ($bottomlinks['privacy_active'] == 'y') {
                $bottom_links[] = trim($bottomlinks['privacy_text']) == "" ? "Privacy Policy" : $bottomlinks['privacy_text'];
            }
            if ($bottomlinks['terms_active'] == 'y') {
                $bottom_links[] = trim($bottomlinks['terms_text']) == "" ? "Terms of Use" : $bottomlinks['terms_text'];
            }
            if ($bottomlinks['disclosures_active'] == 'y') {
                $bottom_links[] = trim($bottomlinks['disclosures_text']) == "" ? "Disclosures" : $bottomlinks['disclosures_text'];
            }
            if ($bottomlinks['licensing_active'] == 'y') {
                $bottom_links[] = trim($bottomlinks['licensing_text']) == "" ? "Licensing Information" : $bottomlinks['licensing_text'];
            }
            if ($bottomlinks['about_active'] == 'y') {
                $bottom_links[] = trim($bottomlinks['about_text']) == "" ? "About Us" : $bottomlinks['about_text'];
            }
            if ($bottomlinks['contact_active'] == 'y') {
                $bottom_links[] = trim($bottomlinks['contact_text']) == "" ? "Contact Us" : $bottomlinks['contact_text'];
            }
            if($bottomlinks['compliance_active'] == 'y' && $bottomlinks['license_number_active'] == 'y'){
                $footer_copyright = $bottomlinks['compliance_text'].'&nbsp;|&nbsp;'.$bottomlinks['license_number_text'];
            }elseif ($bottomlinks['compliance_active'] == 'y'){
                $footer_copyright = $bottomlinks['compliance_text'];
            }elseif ($bottomlinks['license_number_active']){
                $footer_copyright = $bottomlinks['license_number_text'];
            }
        }
        $this->data->bottomlinks = $bottom_links;

        // fetch footer right side copyright section
        $default_assets = rackspace_container_info('default-assets','image_path');
        $this->data->footer_copyright_logo = $this->get_footer_logos($default_assets, $hash_data["funnel"]);
        $this->data->footer_copyright_logo_mobile = $this->get_client_logos($default_assets, $hash_data["funnel"]);
        $this->data->footer_bab_logo = $this->get_footer_bab_logos($default_assets, $hash_data["funnel"]);

        $this->data->footer_copyright = $footer_copyright;
    }

    /**
     * Get footer's logos
     *
     * @param $default_assets
     * @param $funnel_info
     * @return array
     */
    private function get_footer_logos($default_assets, $funnel_info)
    {
        $footer_copyright_logo = array();
        if ((isset($this->session->clientInfo->is_fairway) && $this->session->clientInfo->is_fairway == LP_Helper::IS_FAIRWAY)
            || (isset($this->session->clientInfo->is_mm) && $this->session->clientInfo->is_mm == LP_Helper::IS_MM)) {
            $eho_logo = $this->logos['eho_image'];
            $logo = $default_assets . $eho_logo;
            array_push($footer_copyright_logo, $logo . '?v=' . getenv('ASSET_VERSION'));
        } else {
            $selected_logos = $this->get_client_logos($default_assets, $funnel_info);
            foreach ($selected_logos as $logo) {
                if ($logo == $default_assets . $this->logos['eho_image'] || $logo == $default_assets . $this->logos['ehl_image']) {
                    array_push($footer_copyright_logo, $logo . '?v=' . getenv('ASSET_VERSION'));
                }
            }
        }

        return $footer_copyright_logo;
    }

    /**
     * Get footer's babe logos
     *
     * @param $default_assets
     * @param $funnel_info
     * @return array
     */
    private function get_footer_bab_logos($default_assets, $funnel_info)
    {
        $footer_bab_logo = array();
        if (isset($this->session->clientInfo) and $this->session->clientInfo->is_aime == 1) {
            array_push($footer_bab_logo, $default_assets . $this->logos['bab_aime_logo']);
        }

        return $footer_bab_logo;
    }

    /**
     * Get client's logos
     *
     * @param $default_assets
     * @param $funnel_info
     * @return array
     */
    private function get_client_logos($default_assets, $funnel_info)
    {
        $selected_logos = array();
        if ($funnel_info['leadpop_vertical_id'] == 3) {
            $eho_active = LP_Helper::getInstance()->getFunnelOptions('eho_active');
            if ($this->session->client_id != 1316 && $eho_active != 'y') {
                array_push($selected_logos, $default_assets . $this->logos['ehl_image']);
            }
            if ($eho_active == 'y') {
                array_push($selected_logos, $default_assets . $this->logos['eho_image']);
            }
        } else if ($funnel_info['leadpop_vertical_id'] != 1) {
            array_push($selected_logos, $default_assets . $this->logos['eho_image']);
        }
        if (isset($this->session->clientInfo) and $this->session->clientInfo->is_aime == 1) {
            array_push($selected_logos, $default_assets . $this->logos['bab_aime_logo']);
        }

        return $selected_logos;
    }

    private function funnelQuestion()
    {
        $json = file_get_contents(env("constants.LP_BASE_DIR") . "/public" . config('view.theme_assets') . "/js/funnel/json/contact.json");
        $this->funneQuestionJson = json_encode(array('1' => json_decode($json, true)));
        return $this->funneQuestionJson;
    }

    /**
     * create new funnel process
     */
    function createFunnel(Request $request)
    {
        $this->funnelQuestion();
        $max_version_seq = LP_Helper::getInstance()->getMaxVersionSequence([$this->leadpop_id]);
        $this->leadpop_version_seq = $this->leadpop_version_seq + $max_version_seq; // increase sequence by one
        $domainName = preg_replace('/\s*[\-\ ]\s*/', '-', strtolower($request->input('funnel_name')));
        $domainName = preg_replace('/[^A-Za-z0-9\-]/', '', $domainName);
        $domainName .= config('leadpops.funnel_subdomain_postfix');
        $domaineExists = checkDomainName($domainName, config('leadpops.default_top_level_domain'));
        $clientId = $this->registry->leadpops->client_id;
        if ($domaineExists) {
            $domainName = $domainName . '-' . $clientId . config('leadpops.funnel_subdomain_postfix');
            $domaineExists = checkDomainName($domainName);
            if ($domaineExists) {
                $domainName = $domainName . '-' . $clientId . '-' . $this->leadpop_version_seq . config('leadpops.funnel_subdomain_postfix');
            }
        }
        $funnelName = str_replace('\\', '', $request->input('funnel_name'));
        $clientFunnelsDomains = array(
            'client_id' => $clientId,
            'subdomain_name' => $domainName,
            'leadpop_id' => $this->leadpop_id,
            'leadpop_type_id' => $this->leadpop_type_id,
            'top_level_domain' => config('leadpops.default_top_level_domain'),
            'leadpop_vertical_id' => $this->leadpop_vertical_id,
            'leadpop_vertical_sub_id' => $this->leadpop_vertical_sub_id,
            'leadpop_template_id' => $this->leadpop_template_id,
            'leadpop_version_id' => $this->leadpop_version_id,
            'leadpop_version_seq' => $this->leadpop_version_seq
        );
        $this->db->insert('clients_funnels_domains', $clientFunnelsDomains);

        if (strpos($request->input('create_funnel_folder_id'), 'new_') !== false) {
            $folder_name = str_replace('new_', '', $request->input('create_funnel_folder_id'));
            $folder_name = str_replace('\\', '', $folder_name);
            $folderList = folder_list();
            $arr = array(
                'folder_name' => htmlentities($folder_name, ENT_QUOTES),
                'client_id' => $this->registry->leadpops->client_id,
                'is_default' => 1,
                'order' => count($folderList) + 1
            );
            $create_funnel_folder_id = $this->db->insert('leadpops_client_folders', $arr);
        } else {
            $create_funnel_folder_id = $request->input('create_funnel_folder_id');
        }
        $questions_info = array(
            'question_sequence' => '1',
            'funnel_questions' => $this->funneQuestionJson,
            'funnel_variables' => '{}',
            'conditional_logic' => '{}',
            'lead_line' => '',
            'second_line_more' => '',
            'client_id' => $clientId,
            'leadpop_id' => $this->leadpop_id,
            'leadpop_version_id' => $this->leadpop_version_id,
            'leadpop_version_seq' => $this->leadpop_version_seq,
            'leadpop_folder_id' => $create_funnel_folder_id,
            'funnel_name' => htmlentities($funnelName, ENT_QUOTES, "UTF-8"),
            'leadpop_active' => 1
        );
        $client_leadpop_id = $this->db->insert('clients_leadpops', $questions_info);

        $clientsLeadpopsAttributes = array(
            'client_id' => $clientId,
            'clients_leadpop_id' => $client_leadpop_id,
            'is_clone' => 0
        );
        $this->db->insert('clients_leadpops_attributes', $clientsLeadpopsAttributes);
        $clientFunnelsDomains['client_leadpop_id'] = $client_leadpop_id;
        $clientFunnelsDomains['group_id'] = $this->leadpop_group_id;
        $currentHash = LP_Helper::getInstance()->funnel_hash($clientFunnelsDomains);
        $clientFunnelsDomains['tags'] = $request->input('tag_list');

        // entry in security messages
        $currentFunnelKey = LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        $lplist = collect([$currentFunnelKey]);
        $lpListCollection = GlobalHelper::createLpCollectionFromLpList($lplist);
        $clientDomains = GlobalHelper::getClientDomains($lpListCollection, $clientId);
        $clientDomain = $clientDomains
            ->where("client_id", $clientId)
            ->where("leadpop_id", $this->leadpop_id)
            ->where("leadpop_type_id", $this->leadpop_type_id)
            ->where("leadpop_vertical_id", $this->leadpop_vertical_id)
            ->where("leadpop_vertical_sub_id", $this->leadpop_vertical_sub_id)
            ->where("leadpop_template_id", $this->leadpop_template_id)
            ->where("leadpop_version_id", $this->leadpop_version_id)
            ->where("leadpop_version_seq", $this->leadpop_version_seq)
            ->first();


        $security_tcpa_msg =[
            // Insert Default Security Message
            array(
                'tcpa_title' => 'Security Message',
                'tcpa_text' => 'Privacy & Security Guaranteed',
                'client_id' => $clientId,
                'domain_id' => $clientDomain['clients_domain_id'],
                'leadpop_version_id' => $this->leadpop_version_id,
                'leadpop_version_seq' => $this->leadpop_version_seq,
                'content_type' => 2,
                'icon' => '{"enabled":true,"icon":"ico ico-lock-2","color":"#ffa800","position":"Left Align","size":20}',
                'tcpa_text_style' => '{"is_bold":false,"is_italic":false,"color":"#b4bbbc"}'
            ),
            // Insert Default TCPA Message
            array(
                'tcpa_title' => config('lp.tcpa_message.defaults.tcpa_title'),
                'tcpa_text' => config('lp.tcpa_message.defaults.tcpa_text'),
                'client_id' => $clientId,
                'domain_id' => $clientDomain['clients_domain_id'],
                'leadpop_version_id' => $this->leadpop_version_id,
                'leadpop_version_seq' => $this->leadpop_version_seq,
                'content_type' => 1,
                'icon' => '',
                'tcpa_text_style' => ''
            )
        ];
        $this->db->insert('client_funnel_tcpa_security', $security_tcpa_msg);



        $security_message = TcpaMessage::where('client_id', $clientId)->where('leadpop_version_id', $this->leadpop_version_id)
            ->where('leadpop_version_seq', $this->leadpop_version_seq)->where('content_type', 2)->first('id');
        if($security_message){
            $question_json_with_security = str_replace('"enable-security-message":0', '"enable-security-message": 1', $this->funneQuestionJson);
            $question_json_with_security = str_replace('"security-message-id":0', '"security-message-id": ' . $security_message->id, $question_json_with_security);
            $setColumn = array(
                'funnel_questions' => $question_json_with_security,
            );

            $where = "client_id = " . $clientId;
            $where .= " AND id = " . $client_leadpop_id;

            $this->db->update('clients_leadpops', $setColumn, $where);
        }

        // create new custom funnel funnel through gearman
        if (env('GEARMAN_ENABLE') == "1") {
            MyLeadsEvents::getInstance()->createCustomFunnel($clientFunnelsDomains);
        }
        $response['redirect'] = LP_BASE_URL . LP_PATH . '/popadmin/funnel/questions/' . $currentHash;
        return response()->json($response, 200);
    }

    public function saveFunnelQuestions()
    {
        $current_url = url()->current();
        $arr_data = explode("/", $current_url);
        $current_hash = end($arr_data);
        $hashData = LP_Helper::getInstance()->funnel_hash($current_hash);

        $vertical_id = $hashData['leadpop_vertical_id'];
        $subvertical_id = $hashData['leadpop_vertical_sub_id'];
        $leadpop_id = $hashData['leadpop_id'];
        $version_seq = $hashData['leadpop_version_seq'];
        $client_id = $hashData['client_id'];
        $leadpop_template_id = $hashData['leadpop_template_id'];
        $leadpop_version_id = $hashData['leadpop_version_id'];
        $leadpop_type_id = $hashData['leadpop_type_id'];

        // check if entry exists
        $s = "SELECT clients_leadpops.id FROM clients_leadpops INNER JOIN leadpops ON leadpops.id = clients_leadpops.leadpop_id";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND clients_leadpops.leadpop_id = " . $leadpop_id;
        $s .= " AND leadpops.leadpop_vertical_id = " . $vertical_id;
        $s .= " AND leadpops.leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " AND leadpop_template_id = " . $leadpop_template_id;
        $s .= " AND leadpops.leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $clientLeadpopInfo = $this->db->fetchRow($s);

        date_default_timezone_set('America/Los_Angeles');
        $now = new \DateTime();

        if ($clientLeadpopInfo) {
            $setColumn = array(
                'date_updated' => $now->format("Y-m-d H:i:s"),
                'question_sequence' => $_POST['sequence'],
                'funnel_questions' => $_POST['questions'],
                'funnel_hidden_field' => $_POST['hidden_fields'],
                'conditional_logic'=> $_POST['conditional_logic'] ?? '{}'
            );

            $where = "client_id = " . $client_id;
            $where .= " AND id = " . $clientLeadpopInfo['id'];

            $this->db->update('clients_leadpops', $setColumn, $where);

            /* update clients_leadpops table's col last edit*/
            update_clients_leadpops_last_eidt($clientLeadpopInfo['id']);
        } else {
            $setColumn = array(
                'id' => null,
                'client_id' => $client_id,
                'leadpop_id' => $leadpop_id,
                'leadpop_version_id' => $leadpop_version_id,
                'leadpop_active' => 1,
                'access_code' => "",
                'leadpop_version_seq' => $version_seq,
                'question_sequence' => $_POST['sequence'],
                'funnel_questions' => $_POST['questions'],
                'funnel_hidden_field' => $_POST['hidden_fields'],
                'date_added' => $now->format("Y-m-d H:i:s")
            );

            $this->db->insert('clients_leadpops', $setColumn);
        }

        return $this->successResponse('success');
    }

    function getFunnelQuestions($current_hash)
    {
        $hashData = LP_Helper::getInstance()->funnel_hash($current_hash);
        $leadpop_id = $hashData['leadpop_id'];
        $version_seq = $hashData['leadpop_version_seq'];
        $client_id = $hashData['client_id'];
        $leadpop_version_id = $hashData['leadpop_version_id'];
        $s = "SELECT id, funnel_questions, question_sequence, funnel_hidden_field, conditional_logic FROM clients_leadpops";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_id = " . $leadpop_id;
        $s .= " AND leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        return $this->db->fetchRow($s);
    }

    /**
     * Get security messages for current funnel
     */
    function getSecurityMessages()
    {
        $current_url = url()->current();
        $arr_data = explode("/", $current_url);
        $current_hash = end($arr_data);
        $hash_data = LP_Helper::getInstance()->funnel_hash($current_hash);

        $client_id = $hash_data['client_id'];
        $leadpop_id = $hash_data['leadpop_id'];
        $leadpop_vertical_id = $hash_data['leadpop_vertical_id'];
        $leadpop_vertical_sub_id = $hash_data['leadpop_vertical_sub_id'];
        $leadpop_template_id = $hash_data['leadpop_template_id'];
        $leadpop_version_id = $hash_data['leadpop_version_id'];
        $leadpop_version_seq = $hash_data['leadpop_version_seq'];


        $clientDomain = \DB::table('clients_funnels_domains')
            ->where('client_id', $client_id)
            ->where('leadpop_id', $leadpop_id)
            ->where('leadpop_vertical_id', $leadpop_vertical_id)
            ->where('leadpop_vertical_sub_id', $leadpop_vertical_sub_id)
            ->where('leadpop_template_id', $leadpop_template_id)
            ->where('leadpop_version_id', $leadpop_version_id)
            ->where('leadpop_version_seq', $leadpop_version_seq)
            ->first();

        $clients_domain_id = $clientDomain->clients_domain_id;
        $q = "SELECT sm.id, sm.tcpa_title, sm.tcpa_text,
                    sm.icon, sm.tcpa_text_style
                     FROM client_funnel_tcpa_security sm INNER JOIN clients_leadpops
                         ON sm.client_id = clients_leadpops.client_id
                                AND sm.leadpop_version_id = clients_leadpops.leadpop_version_id
                                AND sm.leadpop_version_seq = clients_leadpops.leadpop_version_seq
WHERE sm.client_id = '" . $client_id . "' ";
        $q .= " AND sm.leadpop_version_id = '" . $leadpop_version_id . "'";
        $q .= " AND sm.leadpop_version_seq = '" . $leadpop_version_seq . "'";
        $q .= " AND sm.content_type = '2'";
        $q .= " AND sm.domain_id = '" . $clients_domain_id . "'";
        $messages = $this->db->fetchAll($q);

        if ($messages) {
            return $messages;
        } else {
            return '';
        }
    }

    /**
     * update funnel name
     * @param Request $request
     * @throws \Exception
     */
    function updateFunnelName(Request $request)
    {
        $data = [];
        LP_Helper::getInstance()->getCurrentHashData($request->input('hash'));
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
            $old_funnel_name = htmlentities(str_replace('\\', '', $request->input('old_funnel_name')), ENT_QUOTES);
            $funnel_name = htmlentities(str_replace('\\', '', $request->input('funnel_name')), ENT_QUOTES);
            if ($funnel_name) {
                if (strtolower($funnel_name) != strtolower($old_funnel_name)) {
                    $rs = checkFunnelName($funnel_data['client_leadpop_id'], $funnel_name);
                    if ($rs) {
                        return $this->warningResponse("That name is already being used by another Funnel in your Admin. Try something else.");
                    } else {
                        $this->db->update('clients_leadpops',
                            array(
                                'funnel_name' => $funnel_name),
                            'client_id = ' . $this->registry->leadpops->client_id . '
                           AND id = ' . $funnel_data['client_leadpop_id']);
                    }
                    update_clients_leadpops_last_eidt();
                }
            } else {
                return $this->errorResponse('Please enter your funnel name.');
            }
        } else {
            return $this->errorResponse('Something went wrong. Please try again.');
        }
        return $this->successResponse('Funnel Name has been updated successfully.');
    }

    /**
     * Activate/inactivate cta message
     */
    function enableCta()
    {
        $current_url = url()->current();
        $arr_data = explode("/", $current_url);
        $current_hash = end($arr_data);
        $hash_data = LP_Helper::getInstance()->funnel_hash($current_hash);

        $client_id = $hash_data['client_id'];
        $client_leadpop_id = $hash_data['client_leadpop_id'];

        $clientCta = \DB::table('clients_leadpops_attributes')
            ->where('client_id', $client_id)
            ->where('clients_leadpop_id', $client_leadpop_id)
            ->first();

        if ($clientCta) {
            $setColumn = array('enable_cta' => $_POST['enable_cta']);
            $where = "client_id = " . $client_id;
            $where .= " AND clients_leadpop_id = " . $client_leadpop_id;
            $this->db->update('clients_leadpops_attributes', $setColumn, $where);
        } else {
            $setColumn = array(
                'enable_cta' => $_POST['enable_cta'],
                'client_id' => $client_id,
                'clients_leadpop_id' => $client_leadpop_id
            );
            $this->db->insert('clients_leadpops_attributes', $setColumn);
        }
    }

    /**
     * Activate/inactivate featured image
     */
    function toggleLpImage()
    {
        $current_url = url()->current();
        $arr_data = explode("/", $current_url);
        $current_hash = end($arr_data);
        $hash_data = LP_Helper::getInstance()->funnel_hash($current_hash);

        $client_id = $hash_data['client_id'];
        if ($_POST['enable_featured_image'] == '1') {
            $this->Default_Model_Customize->activatelpimage2($client_id, array(), $hash_data);
        } else {
            $this->Default_Model_Customize->deactivatelpimage($client_id, $hash_data);
        }
    }

    /**
     * Save security message
     */
    function saveSecurityMessage(Request $request)
    {
        if(!$request->has('id')) {
            $current_url = url()->current();
            $arr_data = explode("/", $current_url);
            $current_hash = end($arr_data);
            $hash_data = LP_Helper::getInstance()->funnel_hash($current_hash);

            $client_id = $hash_data['client_id'];
            $leadpop_id = $hash_data['leadpop_id'];
            $leadpop_vertical_id = $hash_data['leadpop_vertical_id'];
            $leadpop_vertical_sub_id = $hash_data['leadpop_vertical_sub_id'];
            $leadpop_template_id = $hash_data['leadpop_template_id'];
            $leadpop_version_id = $hash_data['leadpop_version_id'];
            $leadpop_version_seq = $hash_data['leadpop_version_seq'];
            $defaultSecurityMessage = config('lp.security_message.defaults');

            $clientDomain = \DB::table('clients_funnels_domains')
                ->where('client_id', $client_id)
                ->where('leadpop_id', $leadpop_id)
                ->where('leadpop_vertical_id', $leadpop_vertical_id)
                ->where('leadpop_vertical_sub_id', $leadpop_vertical_sub_id)
                ->where('leadpop_template_id', $leadpop_template_id)
                ->where('leadpop_version_id', $leadpop_version_id)
                ->where('leadpop_version_seq', $leadpop_version_seq)
                ->first();

            $security_msg = array(
                'tcpa_title' => $defaultSecurityMessage['tcpa_title'],
                'tcpa_text' => trim($request->input("tcpa_text")) == '' ? $defaultSecurityMessage['tcpa_text'] : trim($request->input("tcpa_text")),
                'client_id' => $client_id,
                'domain_id' => $clientDomain->clients_domain_id,
                'leadpop_version_id' => $leadpop_version_id,
                'leadpop_version_seq' => $leadpop_version_seq,
                'content_type' => 2,
                'icon' => $request->input('icon'),
                'tcpa_text_style' => $request->input('tcpa_text_style')
            );

            $id = $this->db->insert('client_funnel_tcpa_security', $security_msg);
            return $this->successResponse('Security messsage has been created', $id);
        } else {
            $security_msg = array(
                'tcpa_text' => $request->input('tcpa_text'),
                'icon' => $request->input('icon'),
                'tcpa_text_style' => $request->input('tcpa_text_style')
            );

            $where = "id = " . $_POST['id'];
            $this->db->update('client_funnel_tcpa_security', $security_msg, $where);
            return $this->successResponse('Security messsage has been updated.');
        }
    }

    public function resetToDefaultProvidedQuestions(Request $request){
        $current_hash = $request->current_hash;
        $hash_data = LP_Helper::getInstance()->funnel_hash($current_hash);
        $leadpop_version_id = $hash_data["leadpop_version_id"];

        if($leadpop_version_id >= config('funnelbuilder.funnel_builder_version_id')){
            die("Reset is not applicable on website funnels");
        }


        if ($this->registry->leadpops->clientInfo['is_fairway'] == 1)
            $trial_launch_defaults = "trial_launch_defaults_fairway";
        else if ($this->registry->leadpops->clientInfo['is_mm'] == 1)
            $trial_launch_defaults = "trial_launch_defaults_mm";
        else
            $trial_launch_defaults = "trial_launch_defaults";


        // get trial info from version_seq = 1 because if funnel is cloned manny times the higher version_seq not exist in trial tables
        $defaultData = \DB::table($trial_launch_defaults)
            ->where("leadpop_vertical_sub_id", $hash_data['leadpop_vertical_sub_id'])
            ->where("leadpop_version_id", $hash_data['leadpop_version_id'])
            ->orderBy('leadpop_version_seq', 'asc')
            ->first();
        $defaultFunnelQuestions = '';
        $defaultQuestionSequence = '';
        if ($defaultData) {
            $defaultFunnelQuestions = $defaultData->funnel_questions;
            $defaultQuestionSequence = $defaultData->question_sequence;
            $defaultConditional_logic = ($defaultData->conditional_logic == "" || $defaultData->conditional_logic == "null") ? "{}" : $defaultData->conditional_logic;
            $funnelQuestions = json_decode($defaultFunnelQuestions);
            $check_iteration = 0;
            foreach ($funnelQuestions as $key=>$findDateType)
            {
                if (isset($findDateType->{'question-type'}) && $findDateType->{'question-type'} === 'date')
                {
                    $funnelQuestions->{$key}->{'question-type'} = 'birthday';
                }
            }
            $defaultFunnelQuestions= json_encode($funnelQuestions);
        }

        $client_leadpop_id = $hash_data["client_leadpop_id"];
        \DB::table("clients_leadpops")
            ->where("id", $client_leadpop_id)
            ->where("client_id", $hash_data["client_id"])
            ->update([
                "question_sequence" => $defaultQuestionSequence,
                "funnel_questions" => $defaultFunnelQuestions,
                "conditional_logic" => $defaultConditional_logic
            ]);
        $data = [];
        $data['question_sequence'] = $defaultQuestionSequence;
        $data['funnel_questions'] = $defaultFunnelQuestions;

        $data['funnel_questions'] = LP_Helper::getInstance()->combine_json_attributes(json_decode( $data['funnel_questions'], 1), $hash_data['leadpop_version_id']);
        $data['funnel_questions'] = json_encode($data['funnel_questions']);
        $data['conditional_logic'] = $defaultConditional_logic;
        return $this->successResponse('Questions are reset to defaults.', $data);
    }

    public function allcontacts()
    {
        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $funnel = LP_Helper::getInstance()->getFunnelData();
            $this->data->workingLeadpop = @$this->registry->leadpops->workingLeadpop;
            $this->data->clickedkey = @$this->registry->leadpops->clickedkey;
            $this->data->workingLeadpop = $this->lp_admin_model->getWorkingLeadpopDescription($funnel['funnel']);
            $this->data->keys = $funnel['_key'];
            $this->data->clickedkey = $funnel['_key'];
            $this->data->lpkeys = $this->getLeadpopKey($funnel);
            $this->data->currenthash = $funnel["current_hash"];
            $this->data->client_id = $this->registry->leadpops->client_id;
            $this->data->clientName = \View_Helper::getInstance()->getClientName($this->registry->leadpops->client_id);
            $this->data->vertical_id = $funnel['funnel']['leadpop_vertical_id'];
            $this->data->subvertical_id = $funnel['funnel']['leadpop_vertical_sub_id'];
            $enterprise = array(7); // this array determins if you switch the menu to exclude items because enterprise page.
            if (in_array($this->data->vertical_id, $enterprise))
                $this->data->switchmenu = 'y';
            else
                $this->data->switchmenu = 'n';

            $newArray = array();
            $allRecipients = \View_Helper::getInstance()->getLeadRecipients($this->registry->leadpops->client_id, $funnel);
            if($allRecipients) {
                $key = array_search('y', array_column($allRecipients, 'is_primary'));
                //get primary email
                if($key) {
                    $newArray[] = $allRecipients[$key];
                }
                //did set the record other than primary email
                foreach ($allRecipients as $key => $value){
                    if(array_search($value['email_address'], array_column($newArray, 'email_address')) === false) {
                        $newArray[] = $value;
                    }
                }
            }
            return $newArray;
        }
    }



    public function saveNewRecipient(LpAccountRepository $lp_ac, Request $request)
    {
        $conditionlogic=1;
        $res = $lp_ac->saveNewRecipient($_POST, $this->registry->leadpops->client_id,$conditionlogic);
        if ($res == 'new-duplicate') {
            return $this->successResponse("This email address already exists in the list.",['data'=>$res]);
            //Session::flash('error', "This email address already exists in the list.");
        } else {
            return $this->successResponse("Lead recipient has been added.", ['action'=>'add', 'data'=>$res]);
        }
    }


    /*Condition Logic Start*/
    public function saveConditionalLogic(Request $request){
        $post_data = $request->all();
        if($post_data['conditional_logic'] != ""){
            $json = @json_decode($post_data['conditional_logic'], 1);
            if(isset($json['conditionSequence']) && $json['conditionSequence']==""){
                $setColumn = array(
                    'conditional_logic' => "{}"
                );
            }
            else{
                $setColumn = array(
                    'conditional_logic' => $post_data['conditional_logic']
                );
            }
        }
        $where = " id = " . $post_data['client_leadpop_id'];
        $this->db->update('clients_leadpops', $setColumn, $where);

        /* update clients_leadpops table's col last edit*/
        update_clients_leadpops_last_eidt($post_data['client_leadpop_id']);

        return $this->successResponse('success',$post_data);
    }

    /*Condition Logic End*/
    public function saveAfterDelete(Request $request){
        $post_data = $request->all();
        $setColumn = array(
            'conditional_logic' => $post_data['conditional_logic']
        );
        $where = " id = " . $post_data['client_leadpop_id'];
        $this->db->update('clients_leadpops', $setColumn, $where);

        /* update clients_leadpops table's col last edit*/
        update_clients_leadpops_last_eidt($post_data['client_leadpop_id']);

        return $this->successResponse('success',$post_data);
    }
}
