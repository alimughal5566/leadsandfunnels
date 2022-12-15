<?php

namespace App\Http\Controllers;

use App\Constants\Layout_Partials;
use App\Constants\LP_Constants;
use App\Helpers\Query;
use App\Helpers\ResponseHelpers;
//use App\Models\Leadpops;
use App\Models\SubmissionOption;
use App\Repositories\CustomizeRepository;
use App\Repositories\LeadpopsRepository;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
//use Guzzle\Tests\Service\Mock\Command\Sub\Sub;
use Illuminate\Http\Request;

use App\Repositories\GlobalRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use LP_Helper;
use DateTime;
use Session;
use Carbon\Carbon;
use App\Helpers\Utils;

class ContentController extends BaseController
{

    private $Default_Model_Customize, $global_obj;
    private $Default_Model_Leadpops;

    public function __construct(LpAdminRepository $lpAdmin, CustomizeRepository $customtizeRepo, LeadpopsRepository $leadpopsRepo, GlobalRepository $global_obj)
    {
        $this->middleware(function ($request, $next) use ($lpAdmin, $customtizeRepo, $leadpopsRepo) {
            $this->Default_Model_Customize = $customtizeRepo;
            $this->Default_Model_Leadpops = $leadpopsRepo;
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(Session::get('leadpops'));
            $this->init($lpAdmin);
            if($request->ajax()) $this->check_ajax_session(); else $this->check_session();
            return $next($request);
        });
        $this->global_obj = $global_obj;
    }

    public function test($hash, Request $request)
    {
     //   dd(LP_Helper::decrypt($hash));
    }

    private function updateFunnelTimestamp($args)
    {
        $now = new DateTime();

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

        /* update clients_leadpops table's col last edit*/
        /* if LP_Helper::getInstance()->getFunnelData() not work then send id in parameter */
        update_clients_leadpops_last_eidt($client_leadpop_id);


        if ($client_leadpop_id) {
            $s = "UPDATE clients_leadpops SET date_updated = '" . $now->format("Y-m-d H:i:s") . "'";
            $s .= " WHERE client_id = " . $client_id;
            $s .= " AND id = " . $client_leadpop_id;
            $this->db->query($s);
        }
    }

    function resetctamessageAction()
    {
        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $customize = $this->Default_Model_Customize;
            $data["message"] = array('thefont' => $_POST["mthefont"], 'thefontsize' => $_POST["mthefontsize"], 'mainheadingval' => trim($_POST["mmainheadingval"]), 'savestyle' => $_POST["mmessagecpval"]);
            $return_val = $customize->resetHomePageMessageMainMessage($hash_data["funnel"]);
            echo json_encode($return_val);
        }
    }

    function resetctadescriptionAction()
    {
        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $customize = $this->Default_Model_Customize;
            $return_val = $customize->resetHomePageDescription($hash_data['funnel']);
            echo json_encode($return_val);
        }
    }

    function footeroptionAction()
    {
        LP_Helper::getInstance()->getCurrentHashData();

        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $customize = $this->Default_Model_Customize;;
            $this->data->bottomlinks = $customize->getBottomLinks($hash_data["client_id"], $hash_data["leadpop_vertical_id"], $hash_data["leadpop_vertical_sub_id"], $hash_data["leadpop_id"], $hash_data["leadpop_version_seq"]);
            $this->data->advancedfooteroptions = $customize->getAdvancedFooteroptions($hash_data);

            /*
             * Overriding compliance_active=y flag with n
             *      if compliance_text is blank
             *
             * Overriding license_number_active=y flag with n
             *      if license_number_text is blank
             */

            if ($this->data->bottomlinks['compliance_active'] == 'y' && $this->data->bottomlinks['compliance_text'] == "") {
                $this->data->bottomlinks['compliance_active'] = 'n';
            }
            if ($this->data->bottomlinks['license_number_active'] == 'y' && $this->data->bottomlinks['license_number_text'] == "") {
                $this->data->bottomlinks['license_number_active'] = 'n';
            }


            if ($this->data->bottomlinks['compliance_text'] == 'd') {
                $this->data->bottomlinks['compliance_text'] = 'NMLS Consumer Look Up';
            }
            if ($this->data->bottomlinks['license_number_text'] == 'd') {
                $this->data->bottomlinks['license_number_text'] = 'NMLS #456';
            }
            if ($this->data->bottomlinks['compliance_link'] == 'd') {
                $this->data->bottomlinks['compliance_link'] = 'http://www.nmlsconsumerlookup.org';
            }
            $this->active_menu = LP_Constants::FOOTER;
            return $this->response();
        } else {
            return $this->_redirect();
        }

    }

    /**
     * Will update advance footer options
     * @param $request
     * @return $response
     */
    public function advanceFooter(Request $request){
        LP_Helper::getInstance()->getCurrentHashData();
        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);

            if ($request->isMethod('post')){
                try {
                    $query = \DB::table("bottom_links")
                        ->where("client_id", $this->client_id)
                        ->where("leadpop_id", $hash_data['funnel']['leadpop_id'])
                        ->where("leadpop_type_id", $hash_data['funnel']['leadpop_type_id'])
                        ->where("leadpop_vertical_id", $hash_data['leadpop_vertical_id'])
                        ->where("leadpop_vertical_sub_id", $hash_data['leadpop_vertical_sub_id'])
                        ->where("leadpop_template_id", $hash_data['leadpop_template_id'])
                        ->where("leadpop_version_id", $hash_data['leadpop_version_id'])
                        ->where("leadpop_version_seq", $hash_data['leadpop_version_seq']);

                    $advancehtml = $request->advancehtml ?? '';
                    $hideofooter = (isset($request->hideofooter) && $request->hideofooter == 'y') ? 'y' : 'n';
                    $advanced_footer_active = (isset($request->advanced_footer_active) && $request->advanced_footer_active == 'y') ? 'y' : 'n';

                    $updateData = [
                        "hide_primary_footer" => $hideofooter,
                        "advanced_footer_active" => $advanced_footer_active,
                        "advancehtml" => $advancehtml
                    ];
                    $query->update($updateData);

                    $template_type = isset($request->templatetype) ? $request->templatetype : null;
                    $is_default_tpl_cta_msg = (isset($request->default_tpl_cta_msg) && $request->default_tpl_cta_msg == "y");

                    // updating client leadpops
                    $clientLeadpopQuery = \DB::table("clients_leadpops")
                        ->where("client_id", $this->client_id)
                        ->where("leadpop_version_id", $hash_data['leadpop_version_id'])
                        ->where("leadpop_version_seq", $hash_data['leadpop_version_seq']);
                    $currentDateTime = date("Y-m-d H:i:s");
                    $updateData = [
                        "last_edit" => $currentDateTime,
                        "date_updated" => $currentDateTime
                    ];

                    if ($is_default_tpl_cta_msg && ($template_type == "property_template" || $template_type == "property_template2")) {
                        $logo_color = (isset($request->logo_color) && !empty($request->logo_color)) ? $request->logo_color : "#666666";
                        //CTA message & description will be updated here
                        $updateData['lead_line'] = '<span style="font-family: Montserrat; font-size:36px; color:' . $logo_color . '">Check Out the Home for Sale Below & If You Love it, See if You Qualify!</span>';
                        $updateData['second_line_more'] = '<span style="font-family: Open Sans; font-size:18px; color: #666666">Find out if you qualify for this home (or other homes in a similar price range) by getting pre-approved here for FREE. Enter your zip code to get started now!</span>';
                    }
                    $clientLeadpopQuery->update($updateData);

                    return $this->successResponse(config("alerts.advanceFooter.success"));
//                    Session::flash('success', config("alerts.advanceFooter.success"));
                } catch (\Exception $e) {
                    return $this->errorResponse(config("alerts.error"));
//                    Session::flash('error', config("alerts.error"));
                }
            }

            $this->data->bottomlinks = $this->Default_Model_Customize->getBottomLinks($hash_data["funnel"]["client_id"], $hash_data["funnel"]["leadpop_vertical_id"], $hash_data["funnel"]["leadpop_vertical_sub_id"], $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"]);
            $this->data->advancedfooteroptions = $this->Default_Model_Customize->getAdvancedFooteroptions($hash_data);
            $this->active_menu = LP_Constants::ADVANCE_FOOTER;
            return $this->response();
        } else {
            return $this->_redirect();
        }
    }

    function footerOptionPageSaveAction()
    {
        if(isset($_POST['openSections'])){
            Session::put('openSections', $_POST['openSections']);
        }

        LP_Helper::getInstance()->getCurrentHashData();

        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();

            $vertical_id         = $hash_data['leadpop_vertical_id'];
            $subvertical_id      = $hash_data['leadpop_vertical_sub_id'];
            $leadpop_id          = $hash_data['funnel']['leadpop_id'];
            $version_seq         = $hash_data['leadpop_version_seq'];
            $client_id           = $hash_data['client_id'];
            $leadpop_template_id = $hash_data['leadpop_template_id'];
            $leadpop_version_id  = $hash_data['leadpop_version_id'];
            $leadpop_type_id     = $hash_data['funnel']['leadpop_type_id'];

            $privacy_active         = empty($_POST['privacy_active']) ? 'n' : 'y';
            $terms_active           = empty($_POST['terms_active']) ? 'n' : 'y';
            $disclosures_active     = empty($_POST['disclosures_active']) ? 'n' : 'y';
            $licensing_active       = empty($_POST['licensing_active']) ? 'n' : 'y';
            $about_active           = empty($_POST['about_active']) ? 'n' : 'y';
            $contact_active         = empty($_POST['contact_active']) ? 'n' : 'y';
            $compliance_active      = empty($_POST['compliance_active']) ? 'n' : 'y';
            $license_number_active  = empty($_POST['license_number_active']) ? 'n' : 'y';

            $license_number_is_linked = empty($_POST['license_number_is_linked']) ? 'n' : $_POST['license_number_is_linked'];
            $compliance_is_linked     = empty($_POST['compliance_is_linked']) ? 'n' : $_POST['compliance_is_linked'];
            $compliance_text          = $_POST['compliance_text'] ?? '';
            $compliance_link          = $_POST['compliance_link'] ?? '';
            $license_number_text      = $_POST['license_number_text'] ?? '';
            $license_number_link      = $_POST['license_number_link'] ?? '';

            // Add missing http or https
            $compliance_link     = LP_Helper::getInstance()->addScheme($compliance_link);
            $license_number_link = LP_Helper::getInstance()->addScheme($license_number_link);

            $query = "update bottom_links set ";
            $query .= " privacy_active = '" .$privacy_active . "',";
            $query .= " terms_active = '" .$terms_active . "',";
            $query .= " disclosures_active = '" .$disclosures_active . "',";
            $query .= " licensing_active = '" .$licensing_active . "',";
            $query .= " about_active = '" .$about_active . "',";
            $query .= " contact_active = '" .$contact_active . "',";
            $query .= " compliance_active = '" .$compliance_active . "',";
            $query .= " license_number_active = '" .$license_number_active . "',";
            $query .= " compliance_text = '".$compliance_text."', ";
            $query .= " compliance_is_linked = '".$compliance_is_linked."', ";
            $query .= " compliance_link = '".$compliance_link."', ";
            $query .= " license_number_text = '".$license_number_text."', ";
            $query .= " license_number_is_linked = '".$license_number_is_linked."', ";
            $query .= " license_number_link = '".$license_number_link."' ";

            $query .= " where client_id = " . $client_id;
            $query .= " and leadpop_version_id = " . $leadpop_version_id;
            $query .= " and leadpop_version_seq = " . $version_seq;
            $this->db->query($query);

            $currentDateTime = date("Y-m-d H:i:s");

            $query = "UPDATE clients_leadpops SET " .
                "last_edit = '" . $currentDateTime . "'," .
                "date_updated = '" . $currentDateTime . "'";

            $templateType           = isset($_POST['templatetype']) ? $_POST['templatetype'] : null;
            $isDefaultTplCtaMessage = (isset($_POST['defaultTplCtaMessage']) && $_POST['defaultTplCtaMessage'] == "y");
            if($isDefaultTplCtaMessage && ($templateType == "property_template" || $templateType == "property_template2")) {
                $logocolor =  $_POST['logocolor'] ?? '#666666';
                $query .= ",lead_line='" . addslashes('<span style="font-family: Montserrat; font-size:36px; color:'.$logocolor.'">Check Out the Home for Sale Below & If You Love it, See if You Qualify!</span>')."' ";
                $query .= ",second_line_more='" . addslashes('<span style="font-family: Open Sans; font-size:18px; color: #666666">Find out if you qualify for this home (or other homes in a similar price range) by getting pre-approved here for FREE. Enter your zip code to get started now!</span>')."' ";
            }

            $query .=    " WHERE client_id = " . $this->client_id .
                " AND leadpop_version_id  = " . $leadpop_version_id .
                " AND leadpop_version_seq  = " . $version_seq;
            $this->db->query ($query);

            return $this->successResponse(config("alerts.footerOptionSuccess." . config('view.theme')));
//            Session::flash('success', config("alerts.footerOptionSuccess." . config('view.theme')));
//            return redirect()->back();
        } else {
            return $this->_redirect();
        }

    }

    function commonFooterGlobalSetting()
    {
        //  $this->header_partial=Layout_Partials::GLOBAL_CHANGE;
        //  array_push($this->assets_js, LP_BASE_URL.config('view.theme_assets')."/external/bootstrap-multiselect.js");
        // array_push($this->assets_css, LP_BASE_URL.config('view.theme_assets')."/external/bootstrap-multiselect.css");
        $this->data->client_id = $this->registry->leadpops->client_id;
        $this->data->clientName = \View_Helper::getInstance()->getClientName($this->registry->leadpops->client_id);
        $this->data->clientToken = $this->global_obj->getClientToken($this->registry->leadpops->client_id);
        $this->data->globalOptions = $this->Default_Model_Customize->getGlobalOptions($this->registry->leadpops->client_id);

        /*$video_info=$this->lp_admin_model->getVideoByKey('global', 'index');
        $this->data->globalOptions['videolink'] = @$video_info["url"];
        $this->data->globalOptions['videotitle'] = @$video_info["title"];
        $this->data->globalOptions['videothumbnail'] = @$video_info["thumbnail"];
        $this->data->globalOptions['wistia_id'] = @$video_info["wistia_id"];*/


    }

    function privacypolicyAction()
    {
        LP_Helper::getInstance()->getCurrentHashData();

        // same pages used for global setting
        $this->commonFooterGlobalSetting();



        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $customize = $this->Default_Model_Customize;
            $this->data->bottomlinks = $customize->getBottomLinks($hash_data["funnel"]["client_id"], $hash_data["funnel"]["leadpop_vertical_id"], $hash_data["funnel"]["leadpop_vertical_sub_id"], $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"]);
            $this->active_menu = LP_Constants::PRIVACY_POLICY;

            return $this->response();

        } else {
            return $this->_redirect();
        }

    }

    function termsofuseAction()
    {
        LP_Helper::getInstance()->getCurrentHashData();

        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $customize = $this->Default_Model_Customize;
            $this->data->bottomlinks = $customize->getBottomLinks($hash_data["funnel"]["client_id"], $hash_data["funnel"]["leadpop_vertical_id"], $hash_data["funnel"]["leadpop_vertical_sub_id"], $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"]);
            $this->active_menu = LP_Constants::TERMS_OF_USE;
            return $this->response();
        } else {
            return $this->_redirect();
        }
    }

    function disclosuresAction()
    {
        LP_Helper::getInstance()->getCurrentHashData();

        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $customize = $this->Default_Model_Customize;
            $this->data->bottomlinks = $customize->getBottomLinks($hash_data["funnel"]["client_id"], $hash_data["funnel"]["leadpop_vertical_id"], $hash_data["funnel"]["leadpop_vertical_sub_id"], $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"]);
            $this->active_menu = LP_Constants::DISCLOSURES;
            return $this->response();
        } else {
            return $this->_redirect();
        }
    }

    function licensinginformationAction()
    {
        LP_Helper::getInstance()->getCurrentHashData();

        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $customize = $this->Default_Model_Customize;
            $this->data->bottomlinks = $customize->getBottomLinks($hash_data["funnel"]["client_id"], $hash_data["funnel"]["leadpop_vertical_id"], $hash_data["funnel"]["leadpop_vertical_sub_id"], $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"]);
            $this->active_menu = LP_Constants::LICENSE_INFO;
            return $this->response();
        } else {
            return $this->_redirect();
        }
    }

    function aboutusAction()
    {
        LP_Helper::getInstance()->getCurrentHashData();

        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $customize = $this->Default_Model_Customize;
            $this->data->bottomlinks = $customize->getBottomLinks($hash_data["funnel"]["client_id"], $hash_data["funnel"]["leadpop_vertical_id"], $hash_data["funnel"]["leadpop_vertical_sub_id"], $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"]);
            $this->active_menu = LP_Constants::ABOUT_US;
            return $this->response();
        } else {
            return $this->_redirect();
        }

    }

    function contactusAction()
    {
        LP_Helper::getInstance()->getCurrentHashData();

        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $customize = $this->Default_Model_Customize;
            $this->data->bottomlinks = $customize->getBottomLinks($hash_data["funnel"]["client_id"], $hash_data["funnel"]["leadpop_vertical_id"], $hash_data["funnel"]["leadpop_vertical_sub_id"], $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"]);
            $this->active_menu = LP_Constants::CONTACT_US;
            return $this->response();
        } else {
            return $this->_redirect();
        }
    }

    function savefooteroptionsAction(Request $request)
    {



        $customize = $this->Default_Model_Customize;
        LP_Helper::getInstance()->getCurrentHashData($_POST["current_hash"]);
        $hash_data = [];
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
        }
        $is_error = (empty($hash_data)) ? true : false;
        $message_action = ucfirst($_POST["theurltext"]);
        //$message_action="";
        $action = "";
        switch ($_POST["theselectiontype"]) {
            case 'footeroptionsprivacypolicy':
                //$message_action="Privacy policy";
                $action = "privacypolicy";
                break;
            case 'termsofuse':
                //$message_action="Terms of use";
                $action = "termsofuse";
                break;
            case 'disclosures':
                //$message_action="Disclosures";
                $action = "disclosures";
                break;
            case 'licensinginformation':
                //$message_action="Licensing Information";
                $action = "licensinginformation";
                break;
            case 'aboutus':
                //$message_action="About Us";
                $action = "aboutus";
                break;
            case 'contactus':
                //$message_action="Contact Us";
                $action = "contactus";
                break;
        }

        if ($is_error === false) {
            $customize->saveBottomLinks($hash_data["client_id"], $_POST, $hash_data);

            /* update clients_leadpops table's col last edit*/
            update_clients_leadpops_last_eidt();

            /* success message */
            if (config('view.theme') === 'theme_admin2')
                Session::flash('success', 'Success: ' . $message_action . ' has been saved.');
             else
                return $this->successResponse($message_action . ' has been saved.');
        } else {
            /* error message */
            if (config('view.theme') === 'theme_admin2')
                Session::flash('error', 'Error: Saving ' . $message_action);
            else
                return $this->errorResponse('Saving ' . $message_action);
        }

        return $this->lp_redirect('/popadmin/' . $action . '/' . $_POST["current_hash"]);
    }

    function autoresponderAction()
    {
        LP_Helper::getInstance()->getCurrentHashData();
        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $customize = $this->Default_Model_Customize;
            $this->data->autoresponder = $customize->getAutoResponderOptions($hash_data["funnel"]["client_id"], $hash_data["funnel"]["leadpop_vertical_id"], $hash_data["funnel"]["leadpop_vertical_sub_id"], $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"]);
            $pops = $this->Default_Model_Leadpops;
            $this->active_menu = LP_Constants::AUTO_RESPONDER;
            $this->updateFunnelTimestamp(array("client_id" => $hash_data["client_id"], "client_leadpop_id" => $hash_data['client_leadpop_id']));
            return $this->response();
        } else {
            return $this->_redirect();
        }
    }

    function updateautoresponderAction()
    {

        $customize = $this->Default_Model_Customize;
        $return_val = $customize->updateAutoresponderFlag();

        $this->updateFunnelTimestamp($_POST);

        /* update clients_leadpops table's col last edit*/
        /* if LP_Helper::getInstance()->getFunnelData() not work then send id in parameter */
//        update_clients_leadpops_last_eidt();
        print_r(LP_Helper::getInstance()->getFunnelData());
        die;
        echo $return_val;
    }

    function autorespondsaveAction(Request $request)
    {
        // dd($request->all());
        $customize = $this->Default_Model_Customize;
        LP_Helper::getInstance()->getCurrentHashData($_POST["current_hash"]);
        $hash_data = [];
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
        }

        if ($hash_data) {
            $data = $_POST;
            $customize->saveTextandHtmlAutoOptions($data, $hash_data);
            /* update clients_leadpops table's col last edit*/
            update_clients_leadpops_last_eidt();
//            Session::flash('success', config("alerts.autorespondsaveAction." . config('view.theme')));
            // if global setting enable and select the funnels
            $globalSelectedFunnels = $request->input('selected_funnels');
            if($globalSelectedFunnels and env('GEARMAN_ENABLE')) {
                $lplist = explode(",",$globalSelectedFunnels);
                foreach ($lplist as $index => $lp) {
                    $lpconstt = explode("~", $lp);
                    $leadpop_vertical_id = $lpconstt[0];
                    $leadpop_vertical_sub_id = $lpconstt[1];
                    $leadpop_id = $lpconstt[2];
                    $leadpop_version_seq = $lpconstt[3];

                    $lpres = Utils::findFirstInRowsByValues($this->allFunnel, [
                        'id' => $leadpop_id
                    ]);

                    $leadpop_template_id = $lpres['leadpop_template_id'];
                    $leadpop_version_id = $lpres['leadpop_version_id'];
                    $leadpop_type_id = $lpres['leadpop_type_id'];

                    $whereData = [
                        'client_id'               => $hash_data['client_id'],
                        'leadpop_version_id'      => $leadpop_version_id,
                        'leadpop_version_seq'     => $leadpop_version_seq,
                    ];

                    $whereData = queryFormat($whereData,' and ');

                    $updateData = [
                        'html'         => $data['htmlautoeditor'],
                        'thetext'      => $data['textautoeditor'],
                        'subject_line' => trim($data['sline']),
                        'text_active'  => $data['active_respondertext'] ?? 'n',
                        'active'       => $data['active'] ?? 'n',
                        'html_active'  => $data['active_responderhtml'] ?? 'n',
                        'date_updated' => Carbon::now()->toDateTimeString()
                    ];

                    $updateData = queryFormat($updateData,' , ');

                    $s = "UPDATE autoresponder_options SET $updateData WHERE $whereData";
                    Query::execute($s, $lp);
                }
            }
            return $this->successResponse(config("alerts.autorespondsaveAction." . config('view.theme')));
        } else {
            /* error message */
            return $this->errorResponse('Your request was not processed. Please try again.');
//            Session::flash('error', 'Your request was not processed. Please try again.');
        }
        return $this->lp_redirect('/popadmin/autoresponder/' . $_POST["current_hash"]);
    }

    public function calltoactionAction()
    {
        LP_Helper::getInstance()->getCurrentHashData();

        // same pages used for global setting
        $this->commonFooterGlobalSetting();



        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            // $this->assets_css = LP_Helper::getInstance()->getFontFamilyFiles($this->data->fontfamilies);
            // $this->inline_css = LP_Helper::getInstance()->getFontFamilesClass($this->data->fontfamilies);
//            dd("HE");
            $this->setCommonDataForView($hash_data, $session);


            //$pops = $this->Default_Model_Leadpops;
            //$this->data->previewlink = $pops->getPreviewLink($hash_data["funnel"]["client_id"], $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"]);
            $customize = $this->Default_Model_Customize;
            $this->active_menu = LP_Constants::CALL_TO_ACTION;
            // set data variables for CTA message
            $this->loadCtaSettings($hash_data);

            return $this->response();
        } else {
            return $this->_redirect();
        }
    }

    public function calltoactionsaveAction(Request $request)
    {

        //  dd($request->all());
        $customize = $this->Default_Model_Customize;
        $data = array();

        LP_Helper::getInstance()->getCurrentHashData($_POST["current_hash"]);
        $hash_data = [];
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
        }
        if ($hash_data) {

            // save enable_cta toggle
            if (isset($_POST['submit_from_cta_popup'])) {
                $enable_cta_toggle = isset($_POST['enable_cta_toggle']) ? 1 : 0;
                $client_id = $hash_data['client_id'];
                $client_leadpop_id = $hash_data['client_leadpop_id'];
                $clientCta = \DB::table('clients_leadpops_attributes')
                    ->where('client_id', $client_id)
                    ->where('clients_leadpop_id', $client_leadpop_id)
                    ->first();
                if ($clientCta) {
                    $setColumn = array('enable_cta' => $enable_cta_toggle);
                    $where = "client_id = " . $client_id;
                    $where .= " AND clients_leadpop_id = " . $client_leadpop_id;
                    $this->db->update('clients_leadpops_attributes', $setColumn, $where);
                } else {
                    $setColumn = array(
                        'enable_cta' => $enable_cta_toggle,
                        'client_id' => $client_id,
                        'clients_leadpop_id' => $client_leadpop_id
                    );
                    $this->db->insert('clients_leadpops_attributes', $setColumn);
                }
            }

            if ($request['mthefont'] == 'Exo 2') {
                $request['mthefont'] = "'Exo 2'";
            }
            if ($request['dthefont'] == 'Exo 2') {
                $request['dthefont'] = "'Exo 2'";
            }

            $mainMessage = '<span style="font-family: ' .$request->input('mthefont') . '; font-size:' .$request->input('mthefontsize') . '; color: ' .$request->input('mmessagecpval') . ';line-height:' . $request->input('mlineheight') . ';">' . htmlentities($request->input('mmainheadingval'),ENT_QUOTES) . '</span>';
            $mainDescription = '<span style="font-family: ' .$request->input('dthefont') . '; font-size:' .$request->input('dthefontsize') . '; color: ' .$request->input('dmessagecpval') . ';line-height:' . $request->input('dlineheight') . ';">' . htmlentities($request->input('dmainheadingval'),ENT_QUOTES) . '</span>';
            $data["message"] = $mainMessage;
            $data["description"] = $mainDescription;
            $customize->updateCTAMessage($data, $hash_data["client_id"], $hash_data["leadpop_id"], $hash_data["leadpop_version_seq"]);
            /* update clients_leadpops table's col last edit*/
            update_clients_leadpops_last_eidt();
            // if global setting enable and select the funnels
            $globalSelectedFunnels = $request->input('selected_funnels');
            if ($globalSelectedFunnels and env('GEARMAN_ENABLE')) {
                $lplist = explode(",", $globalSelectedFunnels);
                foreach ($lplist as $index => $lp) {
                    $lpconstt = explode("~", $lp);
                    $leadpop_id = $lpconstt[2];
                    $leadpop_version_seq = $lpconstt[3];

                    $lpres = Utils::findFirstInRowsByValues($this->allFunnel, [
                        'id' => $leadpop_id
                    ]);

                    $leadpop_version_id = $lpres['leadpop_version_id'];
                    $whereData = [
                        'client_id' => $hash_data['client_id'],
                        'leadpop_version_id' => $leadpop_version_id,
                        'leadpop_version_seq' => $leadpop_version_seq,
                    ];

                    $whereData = queryFormat($whereData, ' and ');

                    $updateData = [
                        'lead_line' => $mainMessage,
                        'second_line_more' => $mainDescription
                    ];

                    $updateData = queryFormat($updateData, ' , ');

                    $s = "UPDATE clients_leadpops SET $updateData WHERE $whereData";
                    Query::execute($s, $lp);
                }
            }

            /* success message */
            return $this->successResponse(config("alerts.calltoactionsaveAction." . config('view.theme')));
        } else {
            /* error message */
            return $this->errorResponse('Your request was not processed. Please try again.');
        }
        return $this->lp_redirect('/popadmin/calltoaction/' . $_POST["current_hash"]);
    }


    function seoAction()
    {
        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $this->data->seo = $this->Default_Model_Customize->getSeoOptions($hash_data);
            $this->active_menu = LP_Constants::SEO;
            return $this->response();
        } else {
            return $this->_redirect();
        }
    }

    function seosaveAction()
    {

        LP_Helper::getInstance()->getCurrentHashData($_POST["current_hash"]);
        $hash_data = [];
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
        }

        $is_error = (empty($hash_data)) ? true : false;
        if ($is_error === false) {
            $this->updateFunnelTimestamp(array("client_id" => $hash_data["client_id"], "client_leadpop_id" => $hash_data['client_leadpop_id']));
            $this->Default_Model_Customize->saveSeoOptions($hash_data["client_id"], $_POST, $hash_data);

            /* update clients_leadpops table's col last edit*/
            update_clients_leadpops_last_eidt();

            /* success message */
            return $this->successResponse(config("alerts.seosaveAction." . config('view.theme')));
        } else {
            /* error message */
            return $this->errorResponse('Unable to update content.');
        }
    }

    function contactAction()
    {
        LP_Helper::getInstance()->getCurrentHashData();

        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);

            $customize = $this->Default_Model_Customize;
            $this->data->contact = $customize->getContactOptions($hash_data["funnel"]["client_id"], $hash_data["funnel"]["leadpop_vertical_id"], $hash_data["funnel"]["leadpop_vertical_sub_id"], $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"]);
            $this->active_menu = LP_Constants::CONTACT_INFO;
            return $this->response();
        } else {
            return $this->_redirect();
        }
    }

    function contactinfosaveAction(Request $request)
    {

        $customize = $this->Default_Model_Customize;
        LP_Helper::getInstance()->getCurrentHashData($_POST["current_hash"]);
        $hash_data = [];
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
        }
        $is_error = (empty($hash_data)) ? true : false;
        if ($is_error === false) {
            $customize->saveContactOptions($hash_data["client_id"], $_POST, $hash_data);

            /* update clients_leadpops table's col last edit*/
            update_clients_leadpops_last_eidt();


            /* success message */
            $this->updateFunnelTimestamp(array("client_id" => $hash_data["client_id"], "client_leadpop_id" => $hash_data['client_leadpop_id']));

            return $this->successResponse(config("alerts.contactinfosaveAction." . config('view.theme')));
        } else {
            return $this->errorResponse('Your request was not processed. Please try again.');
        }
        return $this->lp_redirect('/popadmin/contact/' . $_POST["current_hash"]);
    }

    function thanksettingsaveAction(Request $request)
    {
//        dd($request->all());
        $customize = $this->Default_Model_Customize;
        LP_Helper::getInstance()->getCurrentHashData($_POST["current_hash"]);
        $hash_data = [];
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
        }
        //debug($_POST);
        $is_error = (empty($hash_data)) ? true : false;
        if ($is_error === false) {
            if (isset($_POST["thankyou"]) && $_POST["thankyou"]) {
                if (isset($_POST["changebtn"]) && $_POST["changebtn"] == "1")
                    $customize->updateSubmission($hash_data["client_id"], $hash_data, "thankyou_active");
            }
            if (isset($_POST["thirldparty"]) && $_POST["thirldparty"]) {
                if (isset($_POST["changebtn"]) && $_POST["changebtn"] == "1")
                    $customize->updateSubmission($hash_data["client_id"], $hash_data, "thirdparty_active");
            }
            $customize->saveSubmissionOptions($hash_data["client_id"], $_POST, $hash_data);
            $this->updateFunnelTimestamp(array("client_id" => $hash_data["client_id"], "client_leadpop_id" => $hash_data['client_leadpop_id']));


            /* success message */
            return $this->successResponse(config("alerts.thankyouPageSuccess." . config('view.theme')));
        } else {
            /* error message */
            return $this->errorResponse(config("alerts.failaureError." . config('view.theme')));
        }
        return redirect()->back();
    }

    function thankyouAction(Request $request)
    {
        LP_Helper::getInstance()->getCurrentHashData();

        // same pages used for global setting
        $this->commonFooterGlobalSetting();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $customize = $this->Default_Model_Customize;
            $this->data->submission = $customize->getSubmissionOptions($hash_data);
            if ($hash_data['funnel']['funnel_type'] == 'w' && !request()->has('id')) {
                request()->route()->action['controller'] = 'App\Http\Controllers\ContentController@thankyoupagesAction';
                $this->data->pages = $customize->getAllThankYouPages($hash_data,false);
            }
            $this->data->submission_id  = $request->get('id') ?? 0;
            $this->active_menu = LP_Constants::THANK_YOU;
            return $this->response();
        } else {
            return $this->_redirect();
        }
    }

    function thankyoumessageAction()
    {
        LP_Helper::getInstance()->getCurrentHashData();

        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $funnel_data = $hash_data["funnel"];
            $this->data->funnelData = $funnel_data;

            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $customize = $this->Default_Model_Customize;
            $this->data->advancedfooteroptions = $customize->getAdvancedFooteroptions($hash_data);
            $submission_opts = $customize->getSubmissionOptions($hash_data);

            /* Requirement is to change the Lock Icon without going into updating all rows in database records. (A30-2351) */
            $old_lock_ico = "/default/images/lock-icon.png";
            $new_lock_ico = "/default/images/email-privacy-icon.png";
            if(strpos($submission_opts['thankyou'], $old_lock_ico) !== false){
                $submission_opts['thankyou'] = str_replace($old_lock_ico, $new_lock_ico, $submission_opts['thankyou']);
                $re = '/email-privacy-icon\.png".*?style="(.*?)"/m';
                preg_match_all($re, $submission_opts['thankyou'], $matches, PREG_SET_ORDER, 0);

                if(count($matches) > 0 && count($matches[0]) > 1) {
                    $submission_opts['thankyou'] = str_replace($matches[0][1], "", $submission_opts['thankyou']);
                }
            }

            $this->data->submission = $submission_opts;
            $this->active_menu = LP_Constants::THANK_YOU_EDIT;
            return $this->response();
        } else {
            return $this->_redirect();
        }
    }

    function thankmessagesaveAction()
    {
        $customize = $this->Default_Model_Customize;
        LP_Helper::getInstance()->getCurrentHashData($_POST["current_hash"]);
        $hash_data = [];
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
        }
        $is_error = (empty($hash_data)) ? true : false;
        if ($is_error === false) {
            $customize->saveSubmissionOptions($hash_data["client_id"], $_POST, $hash_data);
            $this->updateFunnelTimestamp(array("client_id" => $hash_data["client_id"], "client_leadpop_id" => $hash_data['client_leadpop_id']));

            /* update clients_leadpops table's col last edit*/
            update_clients_leadpops_last_eidt();

            /* success message */
            return $this->successResponse(config("alerts.thankyouPageSuccess." . config('view.theme')));
//            Session::flash('success', config("alerts.thankyouPageSuccess." . config('view.theme')));
        } else {
            /* error message */
            return $this->errorResponse(config("alerts.failaureError." . config('view.theme')));
//            Session::flash('error', config("alerts.failaureError." . config('view.theme')));
        }
        return $this->lp_redirect('/popadmin/thankyoumessage/' . $_POST["current_hash"]);
    }

    public function thankyoupagesAction()
    {
        LP_Helper::getInstance()->getCurrentHashData();

        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $customize = $this->Default_Model_Customize;
            /**
             * @var $customize CustomizeRepository
             */
            $this->data->submission = $customize->getSubmissionOptions($hash_data);
            $this->data->pages = $customize->getAllThankYouPages($hash_data,false);
            $this->active_menu = LP_Constants::THANK_YOU;
            $this->body_class = ['funnel-thank-you-page'];

            return $this->response();
        } else {
            return $this->_redirect();
        }
    }

    public function thankyoupagesDeleteAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'id' => [
               'required'
            ]
        ]);

        if ($validator->fails()) {
            /* error message */
//            Session::flash('error', __('messages.thankyou-page-error'));;
            return ResponseHelpers::validationResponse(__('messages.thankyou-page-error'));
//            return redirect()->back();
        }

        try {
            $submission = SubmissionOption::find($request->id);
            $submission->delete();
//            Session::flash('success', __('messages.thankyou-page-deleted'));
            return ResponseHelpers::successResponse(__('messages.thankyou-page-deleted'));
//            return redirect()->back();
        } catch (\Exception $exception) {
            return ResponseHelpers::validationResponse(__('messages.thankyou-page-error'));
            //Session::flash('error', __('messages.thankyou-page-error'));
        }
    }

    public function thankyouPagesDuplicateAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'submission_id' => 'required|exists:submission_options,id'
        ]);

        if ($validator->fails()) {
            return ResponseHelpers::validationResponse($validator->errors(), $request->all());
        }
        LP_Helper::getInstance()->getCurrentHashData($request->input("current_hash"));
        $funnel_data = [];
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
        }

        $submissionOption = SubmissionOption::find($request->input('submission_id'));
        $newSubmissionOption = $submissionOption->replicate();
        $newSubmissionOption->thankyou_active = 'n';
        $newSubmissionOption->thankyou_title = empty($newSubmissionOption->thankyou_title) ? 'Thank You' : 'Copy of ' . $newSubmissionOption->thankyou_title;
        $newSubmissionOption->thankyou_slug = Str::slug($newSubmissionOption->thankyou_title);
        $newSubmissionOption->save();

        $submission = $this->Default_Model_Customize->getAllThankYouPages($funnel_data,false);
        $submission = renderThankYouContentCustomArray($submission,$funnel_data);
        /* success message */
        return ResponseHelpers::successResponse(__('messages.thankyou-pages-coped'),  $submission);
    }

    public function thankyouPagesReOrdering(Request $request) {
        for($i = 0; $i < count($request->input('ids')); $i++) {
            SubmissionOption::whereId($request->input('ids')[$i])->update([
                'position' => $i
            ]);
        }

        return ResponseHelpers::successResponse(__('messages.re-ordering-successfully'));
    }

    public function thankyouPagesAddAction()
    {
        LP_Helper::getInstance()->getCurrentHashData();

        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $funnel_data = $hash_data["funnel"];
            $this->data->funnelData = $funnel_data;
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $customize = $this->Default_Model_Customize;
            $this->data->logo = \View_Helper::getInstance()->getCurrentLogoImageSource($this->registry->leadpops->clientInfo['client_id'], 0, $funnel_data);
            $res = $customize->getDefaultThankyouContent($funnel_data);
            $thankYouContent = str_replace('##clientlogo##',$this->data->logo,$res['html']);
            $thankYouContent = str_replace('##clientphonenumber##',$this->registry->leadpops->clientInfo['phone_number'],$thankYouContent);
            $this->data->thankyou = $thankYouContent;
            $this->active_menu = LP_Constants::THANK_YOU;
            $this->body_class = ['funnel-thank-you-page'];

            return $this->response();
        } else {
            return $this->_redirect();
        }
    }

    public function thankyoupageseditAction($id, $hash)
    {
        LP_Helper::getInstance()->getCurrentHashData();

        // same pages used for global setting
        $this->commonFooterGlobalSetting();

        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $funnel_data = $hash_data["funnel"];
            $this->data->funnelData = $funnel_data;
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            $customize = $this->Default_Model_Customize;
            $this->data->logo = \View_Helper::getInstance()->getCurrentLogoImageSource($this->registry->leadpops->clientInfo['client_id'], 0, $funnel_data);
            $this->data->page = $customize->getThankYouPageByID($id);
            $res = $customize->getDefaultThankyouContent($funnel_data);
            /*
            if(empty($this->data->page->thankyou) || is_null($this->data->page->thankyou)){
                $thankYouContent = str_replace('##clientlogo##',$this->data->logo,$res['html']);
                $thankYouContent = str_replace('##clientphonenumber##',$this->registry->leadpops->clientInfo['phone_number'],$thankYouContent);
                $this->data->thankyou = $thankYouContent;
            }
            else{
                $this->data->thankyou = $this->data->page->thankyou;
            }
            */
            $this->data->thankyou = $this->data->page->thankyou;

            $this->active_menu = LP_Constants::THANK_YOU;
            $this->body_class = ['funnel-thank-you-page'];

            return $this->response();
        } else {
            return $this->_redirect();
        }
    }

    public function updateThankyouPage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'             => 'required|exists:submission_options,id',
            'thankyou_title' => 'required|max:150',
            'thankyou_slug'  => 'required|max:200',
            'thankyou_logo'  => 'required',
            'thankyou'       => 'required'
        ]);

        if ($validator->fails()) {
            return ResponseHelpers::validationResponse(__($validator->errors()));
        }

        $customize = $this->Default_Model_Customize;
        $response = $customize->updateThankyouPage($request);
        return ResponseHelpers::successResponse(__('messages.thankyou-pages-saved'), $response);
    }

    public function thankyouPagesSaveAction(Request $request) {

        $validaor = Validator::make($request->all(), [
           'noOfPages' => 'required',
        ]);

        if ($validaor->fails()) {
            return ResponseHelpers::validationResponse(__($validaor->errors()));
        }
        $customize = $this->Default_Model_Customize;
        LP_Helper::getInstance()->getCurrentHashData($request->input("current_hash"));
        $funnel_data = [];
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
        }
        $customize->saveMultipleSubmissionOptions($request->input('noOfPages'), $funnel_data,$request);
        $submission = $this->Default_Model_Customize->getAllThankYouPages($funnel_data,false);
        $submission = renderThankYouContentCustomArray($submission,$funnel_data);
        return ResponseHelpers::successResponse(__('messages.thankyou-pages-saved'),$submission);
    }

    function funnelBuilderThankSetting(Request $request)
    {
        $customize = $this->Default_Model_Customize;
        LP_Helper::getInstance()->getCurrentHashData($request->input("current_hash"));
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
            $request['thirdparty'] = $request->input('https_flag').str_replace(array('http://', 'https://'), '', $request->input('thirdparty'));
            $customize->saveMultipleSubmissionOptions($request->input('noOfPages'), $funnel_data,$request);
            $submission = $this->Default_Model_Customize->getAllThankYouPages($funnel_data,false);
            $submission = renderThankYouContentCustomArray($submission,$funnel_data);
            /* success message */
            return ResponseHelpers::successResponse(__( config("alerts.thankyouPageSuccess." . config('view.theme'))),$submission);

        } else {
            /* error message */
            return ResponseHelpers::successResponse(__(config("alerts.failaureError." . config('view.theme'))));
        }
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
}
