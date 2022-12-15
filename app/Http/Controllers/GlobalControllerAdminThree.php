<?php

namespace App\Http\Controllers;

use App\Constants\FunnelVariables;
use App\Constants\Layout_Partials;
use App\Constants\LP_Constants;
use App\Helpers\CustomErrorMessage;
use App\Repositories\CustomizeRepository;
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
use App\Models\LeadpopBackgroundColor;
use DateTime;

use App\Repositories\LpAccountRepository;
use App\Repositories\PixelRepository;
use Exception;

class GlobalControllerAdminThree extends BaseController
{
    Private $global_obj,
        $customize,
        $customizeAdminThree;

    protected $rackspace;

    public function __construct(LpAdminRepository $lpAdmin,
                                CustomizeRepository $customize,
                                CustomizeRepositoryAdminThree $customizeAdminThree,
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
        $this->rackspace = \App::make('App\Services\RackspaceUploader');


    }


    /**
     * Module: Footer
     * POST action route
     * @param Request $request
     * @return mixed
     */

    // Footer Options Save (Inner Pages)
    function saveFooterOptionsAdminThree(Request $request)
    {
        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
            return $this->errorResponse('Please select Funnels for global action.');
        }

        $this->checkClient();

        // dd($request->all());
        $is_error = false;
        $message_action = ucfirst($request->input("theurltext"));
        $action = "";
        switch ($_POST["theselectiontype"]) {
            case 'footeroptionsprivacypolicy':
                //$message_action="Global Privacy policy";
                $action = "privacypolicy";
                break;
            case 'termsofuse':
                //$message_action="Global Terms of use";
                $action = "termsofuse";
                break;
            case 'disclosures':
                //$message_action="Global Disclosures";
                $action = "disclosures";
                break;
            case 'licensinginformation':
                //$message_action="Global Licensing Information";
                $action = "licensinginformation";
                break;
            case 'aboutus':
                //$message_action="Global About Us";
                $action = "aboutus";
                break;
            case 'contactus':
                //$message_action="Global Contact Us";
                $action = "contactus";
                break;
        }
        if ($is_error === false) {
            $res = $this->global_obj->saveBottomLinks($this->registry->leadpops->client_id, $_POST);

            if ($res) {
                return $this->successResponse($message_action . ' has been saved.');
            } else {
                return $this->errorResponse('Something went wrong, please try again.');
            }

        } else {
            return $this->errorResponse('Saving ' . $message_action);
        }

        return $this->lp_redirect('/popadmin/' . $action . '/' . $_POST["current_hash"]);

    }





    function saveGlobalContactOption(Request $request)
    {
        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
            return $this->errorResponse('Please select Funnels for global action.');
        }

        $this->checkClient();
        $res = $this->customizeAdminThree->globalsaveContactOptions($this->registry->leadpops->client_id, $_POST);

        if ($res) {
            return $this->successResponse('Contact Info has been saved.');
        } else {
            return $this->errorResponse('Something went wrong, please try again.');
        }
        return $this->lp_redirect('/popadmin/contact/' . $_POST["current_hash"]);
    }












    public function globalsavethankyouoptions(Request $request)
    {
        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
//            Session::flash('error', '<strong>Error:</strong> Please select Funnels for global action.');
            return $this->errorResponse('Please select Funnels for global action.');
        }

        $this->checkClient();
        $this->customizeAdminThree->globalsavethankyouoptions($this->registry->leadpops->client_id, $_POST);
        //Session::flash('success', '<strong>Success:</strong> Thank You Page has been saved.');

        return $this->successResponse(config("alerts.thankyouPageSuccess." . config('view.theme')));

//        Session::flash('success', config("alerts.thankyouPageSuccess." . config('view.theme')));
        //  return $this->lp_redirect('/global/?id=thankyou');
//        return $this->lp_redirect('/popadmin/thankyou/' . $_POST["current_hash"]);
    }


    public function globalsavethankyouMessage(Request $request)
    {
        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
            return $this->errorResponse('Please select Funnels for global action.');
//            Session::flash('error', '<strong>Error:</strong> Please select Funnels for global action.');
//            return redirect()->back();
        }

        $this->checkClient();
        $this->customizeAdminThree->globalsavethankyouMessage($this->registry->leadpops->client_id, $_POST);
        //Session::flash('success', '<strong>Success:</strong> Thank You Page has been saved.');
        return $this->successResponse(config("alerts.thankyouPageSuccess." . config('view.theme')));
//        Session::flash('success', config("alerts.thankyouPageSuccess." . config('view.theme')));
        //  return $this->lp_redirect('/global/?id=thankyou');
//        return $this->lp_redirect('/popadmin/thankyoumessage/' . $_POST["current_hash"]);
    }

    public function checkClient()
    {
        $s = "select * from global_settings where client_id = " . $this->registry->leadpops->client_id;
        $client = $this->db->fetchRow($s);
        if (!$client) {
            \DB::table('global_settings')->insert([
                'id' => null,
                'client_id' => $this->registry->leadpops->client_id
            ]);
        }

    }



    function globalsaveseo(Request $request)
    {
        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
            Session::flash('error', '<strong>Error:</strong> Please select Funnels for global action.');
            return redirect()->back();
        }

        $return_val = $this->global_obj->globalSaveSeo($this->registry->leadpops->client_id, $_POST);
        if ($return_val == true) {
            /* success message */
            return $this->successResponse('SEO setting has been saved.');
        } else {
            /* error message */
            return $this->errorResponse('<strong>Eror:</strong> Your request was not processed. Please try again.');
        }
    }

    function updateseotags()
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

        $s = "select * from seo_options ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $seo = $this->db->fetchRow($s);

        if ($thelink == 'titletag_active') {
            if ($seo['titletag_active'] == 'y') {
                $changeto = 'n';
            } else {
                $changeto = 'y';
            }
        }

        if ($thelink == 'description_active') {
            if ($seo['description_active'] == 'y') {
                $changeto = 'n';
            } else {
                $changeto = 'y';
            }
        }

        if ($thelink == 'metatags_active') {
            if ($seo['metatags_active'] == 'y') {
                $changeto = 'n';
            } else {
                $changeto = 'y';
            }
        }

        $s = "update seo_options  set " . $thelink . " = '" . addslashes($changeto) . "' ";
        $s .= " where client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $leadpop_type_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_template_id = " . $leadpop_template_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " and leadpop_version_seq = " . $version_seq;
        $this->db->query($s);

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
        if ($clientLeadpopInfo) {
            date_default_timezone_set('America/Los_Angeles');
            $now = new DateTime();

            $s = "UPDATE clients_leadpops SET date_updated = '" . $now->format("Y-m-d H:i:s") . "'";
            $s .= ", last_edit = '" . date("Y-m-d H:i:s") . "'";
            $s .= " WHERE client_id = " . $client_id;
            $s .= " AND id = " . $clientLeadpopInfo['id'];
            $this->db->query($s);

        }


        print($thelink . "~" . $changeto);
    }

    /**
     * Update advance Footer options on selected funnels
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    function advanceFooterSaveActionGlobalAdminThree(Request $request)
    {

        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
            Session::flash('error', '<strong>Error:</strong> Please select Funnels.');
            return redirect()->back();
        }

        //start add current Funnel key
        $currentHash = $_POST['current_hash'];
        $currentKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        if (!empty($currentKey)) {
            array_push($lplist, $currentKey);
        }
        //end add current Funnel key

        $advancehtml = $request->advancehtml ?? '';
        $hideofooter = (isset($request->hideofooter) && $request->hideofooter == 'y') ? 'y' : 'n';
        $advanced_footer_active = (isset($request->advanced_footer_active) && $request->advanced_footer_active == 'y') ? 'y' : 'n';
        $template_type = isset($request->templatetype) ? $request->templatetype : null;
        $is_default_tpl_cta_msg = (isset($request->default_tpl_cta_msg) && $request->default_tpl_cta_msg == "y");
        $logo_color = (isset($request->logo_color) && !empty($request->logo_color)) ? $request->logo_color : "#666666";

        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $vertical_id = $lpconstt[0];
            $subvertical_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $version_seq = $lpconstt[3];

            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);

            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            $leadpop_type_id = $lpres['leadpop_type_id'];

            $query = "update bottom_links set " .
                "advanced_footer_active = '" . $advanced_footer_active . "', " .
                "advancehtml = '" . addslashes($advancehtml) . "', " .
                "hide_primary_footer = '" . $hideofooter . "' " .
                "where client_id = " . $this->client_id .
                " and leadpop_version_id = " . $leadpop_version_id .
                " and leadpop_version_seq = " . $version_seq;
            $this->db->query($query);

            $currentDateTime = date("Y-m-d H:i:s");
            $query = "UPDATE clients_leadpops SET " .
                "last_edit = '" . $currentDateTime . "', ".
                "date_updated = '" . $currentDateTime . "'";

            //CTA message & description will be updated here to defaults
            if ($is_default_tpl_cta_msg && ($template_type == "property_template" || $template_type == "property_template2")) {
                $cta_msg = '<span style="font-family: Montserrat; font-size:36px; color:' . $logo_color . '">Check Out the Home for Sale Below & If You Love it, See if You Qualify!</span>';
                $cta_desc = '<span style="font-family: Open Sans; font-size:18px; color: #666666">Find out if you qualify for this home (or other homes in a similar price range) by getting pre-approved here for FREE. Enter your zip code to get started now!</span>';
                $query .= ",lead_line='" . addslashes($cta_msg) . "', " .
                    "second_line_more='" . addslashes($cta_desc) . "' ";
            }

            $query .= " WHERE client_id = " . $this->client_id .
                " AND leadpop_version_id  = " . $leadpop_version_id .
                " AND leadpop_version_seq  = " . $version_seq;
            $this->db->query($query);
        }

        return $this->successResponse(config("alerts.advanceFooter.success"));
//        Session::flash('success', config("alerts.advanceFooter.success"));
//
//        return redirect()->back();
    }


    function footerOptionPageSaveActionGlobalAdminThree(Request $request)
    {

        if(isset($_POST['openSections'])){
            Session::put('openSections', $_POST['openSections']);
        }
        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
            return $this->errorResponse("Please select Funnels.");
//            Session::flash('error', '<strong>Error:</strong> Please select Funnels.');
//            return redirect()->back();
        }

        //start add current Funnel key
        $currentHash = $_POST['current_hash'];
        $currentKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        if (!empty($currentKey)) {
            array_push($lplist, $currentKey);
        }
        //end add current Funnel key

        $client_id = $_POST['client_id'];
        $privacy_active = empty($_POST['privacy_active']) ? 'n' : 'y';
        $terms_active = empty($_POST['terms_active']) ? 'n' : 'y';
        $disclosures_active = empty($_POST['disclosures_active']) ? 'n' : 'y';
        $licensing_active = empty($_POST['licensing_active']) ? 'n' : 'y';
        $about_active = empty($_POST['about_active']) ? 'n' : 'y';
        $contact_active = empty($_POST['contact_active']) ? 'n' : 'y';
        $compliance_active = empty($_POST['compliance_active']) ? 'n' : 'y';
        $license_number_active = empty($_POST['license_number_active']) ? 'n' : 'y';

        $license_number_is_linked = empty($_POST['license_number_is_linked']) ? 'n' : $_POST['license_number_is_linked'];
        $compliance_is_linked = empty($_POST['compliance_is_linked']) ? 'n' : $_POST['compliance_is_linked'];
        $compliance_text = $_POST['compliance_text'] ?? '';
        $compliance_link = $_POST['compliance_link'] ?? '';
        $license_number_text = $_POST['license_number_text'] ?? '';
        $license_number_link = $_POST['license_number_link'] ?? '';

        // Add missing http or https
        $compliance_link = LP_Helper::getInstance()->addScheme($compliance_link);
        $license_number_link = LP_Helper::getInstance()->addScheme($license_number_link);

        $templateType = isset($_POST['templatetype']) ? $_POST['templatetype'] : null;
        $isDefaultTplCtaMessage = (isset($_POST['defaultTplCtaMessage']) && $_POST['defaultTplCtaMessage'] == "y");

        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $vertical_id = $lpconstt[0];
            $subvertical_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $version_seq = $lpconstt[3];

            $s = "select * from leadpops where id = " . $leadpop_id;
            $lpres = $this->db->fetchRow($s);

            $leadpop_template_id = $lpres['leadpop_template_id'];
            $leadpop_version_id = $lpres['leadpop_version_id'];
            $leadpop_type_id = $lpres['leadpop_type_id'];

            $query = "update bottom_links set ";
            $query .= "privacy_active = '" . $privacy_active . "',";
            $query .= "terms_active = '" . $terms_active . "',";
            $query .= "disclosures_active = '" . $disclosures_active . "',";
            $query .= "licensing_active = '" . $licensing_active . "',";
            $query .= "about_active = '" . $about_active . "',";
            $query .= "contact_active = '" . $contact_active . "',";
            $query .= "compliance_active = '" . $compliance_active . "',";
            $query .= "license_number_active = '" . $license_number_active . "',";
            $query .= "compliance_text = '" . $compliance_text . "', ";
            $query .= "compliance_is_linked = '" . $compliance_is_linked . "', ";
            $query .= "compliance_link = '" . $compliance_link . "', ";
            $query .= "license_number_text = '" . $license_number_text . "', ";
            $query .= "license_number_is_linked = '" . $license_number_is_linked . "', ";
            $query .= "license_number_link = '" . $license_number_link . "' ";

            $query .= " where client_id = " . $client_id;
            $query .= " and leadpop_version_id = " . $leadpop_version_id;
            $query .= " and leadpop_version_seq = " . $version_seq;
            $this->db->query($query);

            $currentDateTime = date("Y-m-d H:i:s");
            $query = "UPDATE clients_leadpops SET " .
                "last_edit = '" . $currentDateTime . "'," .
                "date_updated = '" . $currentDateTime . "'";

            if($isDefaultTplCtaMessage && ($templateType == "property_template" || $templateType == "property_template2")) {
                $logocolor =  $_POST['logocolor'] ?? '#666666';
                $query .= ",lead_line='" . addslashes('<span style="font-family: Montserrat; font-size:36px; color:'.$logocolor.'">Check Out the Home for Sale Below & If You Love it, See if You Qualify!</span>')."' ";
                $query .= ",second_line_more='" . addslashes('<span style="font-family: Open Sans; font-size:18px; color: #666666">Find out if you qualify for this home (or other homes in a similar price range) by getting pre-approved here for FREE. Enter your zip code to get started now!</span>')."' ";
            }

            $query .=    " WHERE client_id = " . $this->client_id .
                " AND leadpop_version_id  = " . $leadpop_version_id .
                " AND leadpop_version_seq  = " . $version_seq;
            $this->db->query($query);
        }

        return $this->successResponse('Footer Options have been saved.');
//        Session::flash('success', 'Footer Options have been saved.');
//        return redirect()->back();


        /* if($return_val==true){
             Session::flash('success', '<strong>Success:</strong> SEO setting has been saved.');
         }else{
             Session::flash('error', '<strong>Eror:</strong> Your request was not processed. Please try again.');
         }*/


    }


    function resetCtaMessageActionGlobalAdminThree(Request $request)
    {
      //  dd($request->all());
        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
            Session::flash('error', '<strong>Error:</strong> Please select Funnels for global action.');
            return redirect()->back();
        }

        $data["message"] = array('thefont' => $_POST["mthefont"], 'thefontsize' => $_POST["mthefontsize"], 'mainheadingval' => trim($_POST["mmainheadingval"]), 'savestyle' => $_POST["mmessagecpval"]);
        $return_val = $this->customizeAdminThree->resetHomePageMessageMainMessageGlobal($_POST["client_id"]);

        Session::flash('success', "CTA Main Message style updated on selected Funnels.");
        return redirect()->back();
//        echo json_encode($return_val);
    }



    function resetCtaDescriptionActionGlobalAdminThree(Request $request)
    {
        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
            Session::flash('error', '<strong>Error:</strong> Please select Funnels for global action.');
            return redirect()->back();
        }


        $return_val = $this->customizeAdminThree->resetHomePageDescriptionGlobal($_POST["client_id"]);
        Session::flash('success', "CTA Description style updated on selected Funnels.");
        return redirect()->back();
    }





    public function pixelActionGlobalAdminThree(Request $request)
    {
//        dd($request->all());


        try {

            if (empty($_POST['action'])) {
                throw new \Exception('Action is required.');
            }

            $action = $_POST['action'];
            $response = ['action' => $action];

            if ($action == 'delete') {
                $expectedFields = ['client_id', 'saved_pixel_code', 'saved_pixel_type', 'saved_pixel_placement', 'selected_funnels', 'current_hash'];

                $receivedFields = array_intersect_key($_POST, array_flip($expectedFields));

                if (count($expectedFields) !== count($receivedFields)) {
                    $requiredFields = array_diff($expectedFields, $receivedFields);
                    throw new \Exception('These fields are required: ' . implode(',', $requiredFields));
                }
            }

            $whitelistValues = ['client_id', 'pixel_code', 'pixel_name', 'pixel_placement', 'pixel_type', "pixel_other"];

            $post = array_intersect_key($_POST, array_flip($whitelistValues));

            if (empty($post)) {
                return $this->lp_redirect();
            }

            if ($action != 'delete') {
                $error = [];
                $required_fields = array('pixel_code' => "Tracking ID");
                foreach ($required_fields as $key => $label) {
                    if ($_POST[$key] == "") {
                        $error[] = $label . " field is required.";
                    }
                }

                if (!empty($error)) {
                    Session::flash('error', $error);
                    return redirect()->back();
                }
            }


            if (empty($_POST['selected_funnels'])) {
                throw new \Exception('Please select Funnels.');
            }

            $lplist = explode(",", $_POST['selected_funnels']);
            if (!count($lplist)) {
                throw new \Exception('Please select Funnels.');
            }

            $current_hash = $_POST['current_hash'];
            $currentKey = $this->getFunnelInfoStringFromHash($current_hash);
            if (!empty($current_hash)) {
                array_push($lplist, $currentKey);
            }

            $lplist = array_unique($lplist);

            $client_id = $_POST['client_id'];

            $clientLeadpops = $this->db->fetchAll('select * from clients_leadpops where client_id = ' . $client_id);


            if (empty($clientLeadpops)) {
                throw new \Exception('No data found for client.');
            }

            $leadpopsSubVerticals = $this->db->fetchAll('select id, group_id from leadpops_verticals_sub');

            if (empty($leadpopsSubVerticals)) {
                throw new \Exception('No sub verticals found for client.');
            }

            $allPixels = $this->db->fetchAll('select id,client_id,leadpops_id,client_leadpops_id,domain_id,pixel_code,pixel_type, pixel_placement from leadpops_pixels where client_id = ' . $client_id);

            $allLeadpops = $this->db->fetchAll('select * from leadpops');

            LP_Helper::getInstance()->_fetch_all_funnels();
            $allFunnels = LP_Helper::getInstance()->getFunnels();

            foreach ($lplist as $index => $lp) {
                $lpconstt = explode("~", $lp);
                $vertical_id = $lpconstt[0];
                $subvertical_id = $lpconstt[1];
                $leadpop_id = $lpconstt[2];
                $version_seq = $lpconstt[3];

                $lpres = $this->findFirstInRowsByValues($allLeadpops, [
                    'id' => $leadpop_id
                ]);

                $leadpop_template_id = $lpres['leadpop_template_id'];
                $leadpop_version_id = $lpres['leadpop_version_id'];
                $leadpop_type_id = $lpres['leadpop_type_id'];

                $clientLeadpop = $this->findFirstInRowsByValues($clientLeadpops, [
                    'leadpop_id' => $leadpop_id,
                    'leadpop_version_id' => $leadpop_template_id,
                    'leadpop_version_seq' => $version_seq
                ]);

                if (empty($clientLeadpop)) {
                    continue; // client leadpops not found
                }

                $subVertical = $this->findFirstInRowsByValues($leadpopsSubVerticals, [
                    'id' => $subvertical_id
                ]);

                if (empty($subVertical)) {
                    continue; // sub vertical not found
                }

                $funnel = $allFunnels[$vertical_id]
                    [$subVertical['group_id']]
                    [$subvertical_id]
                    [$clientLeadpop['id']]
                    ?? [];

                if (empty($funnel)) {
                    continue; // funnel not found
                }

                if ($action != 'delete') {
                    if ($_POST['pixel_type'] == LP_Constants::FACEBOOK_PIXELS and $_POST["pixel_placement"] == LP_Constants::PIXEL_PLACEMENT_BODY) {
                        $post["pixel_placement"] = 1;
                    } else if ($_POST["pixel_placement"] != LP_Constants::PIXEL_PLACEMENT_TYP) {
                        $post["pixel_placement"] = $_POST["pixel_position"];
                    }
                }

                if ($action == 'add') {
                    $currentPixel = $this->findFirstInRowsByValues($allPixels, [
                        'client_id' => $client_id,
                        'client_leadpops_id' => $clientLeadpop['id'],
                        'leadpops_id' => $leadpop_id,
                        'domain_id' => $funnel['domain_id'],
                        'pixel_code' => $_POST['pixel_code'],
                        'pixel_type' => $_POST['pixel_type'],
                        "pixel_placement" => $post["pixel_placement"]
                    ]);

                    if (!empty($currentPixel)) {
                        continue; // pixel with given code type already exists
                    }
                } else if ($action == 'delete') {

                    $query = <<<EOD

                    delete from leadpops_pixels where
                    client_id          = '$client_id' and
                    leadpops_id        = '$leadpop_id' and
                    client_leadpops_id = '{$clientLeadpop['id']}' and
                    domain_id          = '{$funnel['domain_id']}' and
                    pixel_code         = '{$_POST['saved_pixel_code']}' and
                    pixel_type         = '{$_POST['saved_pixel_type']}' and
                    pixel_placement    = '{$_POST['saved_pixel_placement']}'

EOD;

                    $this->db->query($query);
                    continue;
                }

                $post['client_leadpops_id'] = $clientLeadpop['id'];
                $post['leadpops_id'] = $leadpop_id;
                $post['domain_id'] = $funnel['domain_id'];

                $post['pixel_action'] = "";
                if($_POST['pixel_type'] != LP_Constants::FACEBOOK_CONVERSION_API){
                    $post['pixel_other'] = "";
                }

                if ($_POST['pixel_type'] == LP_Constants::FACEBOOK_PIXELS && $_POST['pixel_placement'] == LP_Constants::PIXEL_PLACEMENT_TYP) {
                    $post['pixel_action'] = LP_Constants::PIXEL_ACTION_LEAD;
                }

                if (isset($_POST["tracking_options"]) && $_POST["tracking_options"] == LP_Constants::PIXEL_PAGE_PLUS_QUESTION) {
                    $post["fb_questions_flag"] = 1;
                    $json = array();
                    if (!empty($_POST['zip_code'])) {
                        $ar = explode(',', $_POST['zip_code']);
                        foreach ($ar as $vl) {
                            if ($vl) {
                                $zip = preg_replace("/\r|\n/", "", $vl);
                                $json['enteryourzipcode'][] = $zip;
                            }
                        }
                    }
                    if (isset($_POST['answer'])) {
                        foreach ($_POST['answer'] as $k => $v) {
                            if ($v) {
                                list($a, $b) = explode('|', $v);
                                $json[$a][] = $b;
                            }
                        }
                    }

                    $post['fb_questions_json'] = json_encode($json, true);

                } else {
                    $post["fb_questions_flag"] = 0;
                    $post['fb_questions_json'] = '';
                }

                $pixelUtils = new PixelRepository($this->db);
                if ($action == "add") {
//                    dd($action);
                    $lastId = $pixelUtils->addPixel($post);
                    if($currentKey == $lp) {
                        $response['id'] = $lastId;
                    }
                } else if ($action == "update") {
                    $pixelUtils->updatePixel($post, [
                        'client_id' => $client_id,
                        'client_leadpops_id' => $clientLeadpop['id'],
                        'leadpops_id' => $leadpop_id,
                        'domain_id' => $funnel['domain_id'],
                        'pixel_code' => $_POST['saved_pixel_code'],
                        'pixel_type' => $_POST['saved_pixel_type'],
                    ]);
                }

                $this->updateFunnelTimestamp(array("client_id" => $client_id, "client_leadpop_id" => $clientLeadpop['id']));
            }

           // if ($action == "add")
           // exit('hi');

            if ($action == "add") {
                $msg = 'Pixel code has been added.';
            } else if ($action == "update") {
                $msg = 'Pixel code has been updated.';
            } else if ($action == "delete") {
                $msg = "Code has been deleted.";
            }

            return $this->successResponse($msg, $response);

//            Session::flash('success', $msg);
//            return redirect()->back();

        } catch (\Exception $e) {
            if (!empty($_POST['action']) && $_POST['action'] == 'delete') {
                return $this->errorResponse('Unable to delete code.');
//                return json_encode(['status' => 'error']);
            }

            return $this->errorResponse($e->getMessage());
//            Session::flash('error', "<strong>Error:</strong> " . $e->getMessage());
//            return redirect()->back();
        }
    }

    public function findFirstInRowsByValues(array $rows, array $values)
    {
        foreach ($rows as $index => $row) {
            if (count(array_intersect_assoc($row, $values)) === count($values)) {
                return $row;
            }
        }

        return [];
    }

    public function getFunnelInfoStringFromHash($hash)
    {
        if (empty($hash)) {
            return '';
        }

        $funnelInfo = LP_Helper::getInstance()->funnel_hash($hash);

        return implode('~', [
            $funnelInfo['leadpop_vertical_id'],
            $funnelInfo['leadpop_vertical_sub_id'],
            $funnelInfo['leadpop_id'],
            $funnelInfo['leadpop_version_seq']
        ]);
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


        if ($client_leadpop_id) {
            $s = "UPDATE clients_leadpops SET date_updated = '" . $now->format("Y-m-d H:i:s") . "'
                  , last_edit = '" . $now->format("Y-m-d H:i:s") . "'";
            $s .= " WHERE client_id = " . $client_id;
            $s .= " AND id = " . $client_leadpop_id;
            $this->db->query($s);
        }
    }

    //=======================================================================================================================================================
    //=========================================================END GLOBAL CONTENT ACTIONS===================================================================
    //=======================================================================================================================================================




    //=======================================================================================================================================================
    //=========================================================START Account ACTIONS===================================================================
    //=======================================================================================================================================================


    public function updateAdaAccessibility(Request $request)
    {
        $lpkey_ada_accessibility = $request->input('lpkey_ada_accessibility');
        $is_ada_accessibility = $request->input("is_ada_accessibility") == 1 ? 1 : 0;

        //$lplist = explode(",", $request->selected_funnels);
        $lplist = explode(",", $request->lpkeys . "," . $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
            return $this->errorResponse("Please select Funnels for global action.");
//            Session::flash('error', '<strong>Error:</strong> Please select Funnels for global action.');
//            return redirect()->back();
        }

        //start add current Funnel key
        $currentHash = $_POST['current_hash'];
        $currentKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        if (!empty($currentKey)) {
            array_push($lplist, $currentKey);
        }
        //end add current Funnel key

        $lplist = array_unique($lplist);


        try {
            $leadpopIds = [];
            $leadpopVersionSeqIds = [];
            foreach ($lplist as $index => $lp) {
                $lpconstt = explode("~", $lp);

                if ($lpconstt[2] && $lpconstt[3]) {
                    $leadpopIds[] = $lpconstt[2];
                    $leadpopVersionSeqIds[] = $lpconstt[3];
                }
            }


            // dd($leadpopIds, $leadpopVersionSeqIds);


            \DB::table('clients_leadpops')
                ->where("client_id", $this->registry->leadpops->client_id)
                ->whereIn("leadpop_id", $leadpopIds)
                ->whereIn('leadpop_version_seq', $leadpopVersionSeqIds)
                ->update(
                    [
                        'is_ada_accessibility' => $is_ada_accessibility,
                        'last_edit' => date("Y-m-d H:i:s")
                    ]);
            $updatedStatus = $is_ada_accessibility ? "active" : "inactive";
            return $this->successResponse("Your ADA accessibility settings are $updatedStatus.");
//            Session::flash('success', "<strong>Success:</strong> Your ADA accessibility settings are $updatedStatus.");
        } catch (\Exception $e) {
            return $this->errorResponse("Saving ADA Accessibility.");
//            Session::flash('error', '<strong>Error:</strong> Saving ADA Accessibility. ');
//                return $this->lp_redirect('/global?id=ada');
//            return $this->lp_redirect('/popadmin/adaaccessibility/' . $request->current_hash);
        }

        return $this->lp_redirect('/popadmin/adaaccessibility/' . $request->current_hash);


    }

    //=======================================================================================================================================================
    //=========================================================END Account ACTIONS===========================================================================
    //=======================================================================================================================================================





    //=======================================================================================================================================================
    //======================================================== TAG Methods ==================================================================================
    //=======================================================================================================================================================

    /**
     * save funnel when change the tag , folder and funnel name
     * @param Request $request
     * @throws \Exception
     */
    function saveFunnelTagGlobal(Request $request)
    {

        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
            return $this->errorResponse('Please select Funnels for global action.');
        }

        //start add current Funnel key
        $currentHash = $request->input('hash');
        $currentKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        if (!empty($currentKey)) {
            array_push($lplist, $currentKey);
        }
        //end add current Funnel key

        $client_id = $this->registry->leadpops->client_id;

        $lplist = array_unique($lplist);

        // dd($request->all(), $lplist);


        $data = [];
        if ($this->registry->leadpops->client_id) {
            LP_Helper::getInstance()->getCurrentHashData($currentHash);
            $funnel_data = LP_Helper::getInstance()->getFunnelData();
            foreach ($lplist as $index => $lp) {
                $lpconstt = explode("~", $lp);
                $vertical_id = $lpconstt[0];
                $subvertical_id = $lpconstt[1];
                $leadpop_id = $lpconstt[2];
                $version_seq = $lpconstt[3];

                $s = "select id,leadpop_id,funnel_name from clients_leadpops where client_id = " . $client_id;
                $s .= " and leadpop_version_seq = " . $version_seq;
                $s .= " and leadpop_id = " . $leadpop_id;
                $lpres = $this->db->fetchRow($s);

                $tmp = $this->saveTagsRecord($request, $lpres['id'], $lpres['funnel_name']);
                if($index == 0) {
                    $data = $tmp;
                }
                update_clients_leadpops_last_eidt($lpres['id']);

                if($currentKey == $lp) {
                    $selectedTags = collect(getFunnelSelectedTags($this->registry->leadpops->client_id, $funnel_data['client_leadpop_id']));
                    $data["_tags"] = $selectedTags->pluck("leadpop_tag_id");
                }
            }
            return $this->successResponse('Tags have been updated.', $data);

        } else {
            return $this->errorResponse(' Please select Funnels for global action.');
        }
    }


    /**
     * save folder and funnel name
     * @param $request
     * @param $clients_leadpops_id
     * @param $funnel_name
     * @throws \Exception
     */
    function saveTagsRecord($request, $clients_leadpops_id, $funnel_name)
    {
        $tags = $request->input('tag_list');
        $oldTags = $tags;
        $matches  = preg_grep ('/^new_(\w+)/i', $tags);
        if($matches) {
            foreach($matches as $key => $val){
                unset($oldTags[$key]);
            }
        }

        $leadpop_folder_id = $request->input('folder_list');
        if ($leadpop_folder_id != 0) {
            $this->db->update('clients_leadpops',
                array('leadpop_folder_id' => $request->input('folder_list'),
                    'funnel_name' => htmlentities($funnel_name, ENT_QUOTES)),
                'client_id = ' . $this->registry->leadpops->client_id . '
                           AND id = ' . $clients_leadpops_id);
        }

//        dd($tags);

        $s = "DELETE FROM leadpops_client_tags WHERE client_id = " . $this->registry->leadpops->client_id . "
                    AND client_leadpop_id = " . $clients_leadpops_id;
        $s .= " AND  leadpop_tag_id in (" . implode(',', $oldTags) . ")";

        $this->db->query($s);

        $addedTags = [];
        // return false;
        if ($tags) {
            foreach ($tags as $k => $v) {
                if(strpos($v,'new_') !== false){
                    $tag = str_replace('new_','',$v);
                    $v = customTagSave($tag);
                    $addedTags[$v] = $tag;
                }
                $this->db->insert('leadpops_client_tags', array('leadpop_tag_id' => $v,
                    'client_id' => $this->registry->leadpops->client_id,
                    'client_leadpop_id' => $clients_leadpops_id));
            }
        }
        update_clients_leadpops_last_eidt();
        return ["_new_tags"=>$addedTags];
        //  echo json_encode(array('response' => 'updated'));
    }




    //=======================================================================================================================================================
    //=========================================================deprecated in admin3.0-----===================================================================
    //=======================================================================================================================================================


    // On Secondary Footer Options Save Button


    /**
     * @deprecated deprecated in admin3.0
     * Individual Ajax replaced with common save button
     */
    function updateComplianceAdminThree(Request $request)
    {
        $this->checkClient();
//        dd($request->all());

        update_clients_leadpops_last_eidt($this->registry->leadpops->client_id);
        $return_val = $this->global_obj->updateGlobalCompliance($request);
        echo json_encode($return_val);
    }


    /**
     * @deprecated deprecated in admin3.0
     * Individual Ajax replaced with common save button
     */

    public function updatePrimaryFooterTogglesAdminThree(Request $request)
    {
        $this->checkClient();
//        dd($request->all());
//        $message_action = ucfirst($request->input("theurltext"));


        $this->global_obj->updatePrimaryFooterTogglesAdminThree($this->registry->leadpops->client_id, $_POST);


    }

    /**
     * @deprecated deprecated in admin3.0
     * Individual Ajax replaced with common save button
     */

    public function updatestatusglobaladvancefooter(Request $request)
    {
        $this->checkClient();
        $this->customizeAdminThree->updatestatusglobaladvancefooter($this->registry->leadpops->client_id, $_POST);
        echo "updated";
        exit;
        //Session::flash('success', '<strong>Success!</strong> Super Footer has been saved.');
        //return $this->lp_redirect('/global/?id=superfooter');
    }


    /**
     * @deprecated deprecated in admin3.0
     * Individual Ajax replaced with common save button
     */

    public function updateglobaladvancefooter()
    {
        $this->checkClient();
        $this->customizeAdminThree->updateglobaladvancefooter($this->registry->leadpops->client_id, $_POST);
        //  Session::flash('success', '<strong>Success!</strong> Super Footer has been saved.');
//        return $this->lp_redirect('/global/?id=superfooter');
        // return $this->lp_redirect('/popadmin/footeroption/'.$_POST["current_hash"]);
    }



}
