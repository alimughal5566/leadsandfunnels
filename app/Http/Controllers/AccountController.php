<?php

namespace App\Http\Controllers;

use App\Helpers\CustomErrorMessage;
use App\Repositories\CustomizeRepository;
use App\Repositories\ExportRepository;
use App\Repositories\LeadpopsRepository;
use App\Repositories\LpAccountRepository;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
use App\Constants\LP_Constants;
use App\Services\gm_process\MyLeadsEvents;
use Illuminate\Http\Request;
use App\Services\gm_process\InfusionsoftGearmanClient;
use Illuminate\Support\Facades\Validator;
use LP_Helper;
use iSDK;
use Session;

class AccountController extends BaseController
{


    private $_videolink = "http://www.youtube.com/embed/W7qWa52k-nE";
    private $Default_Model_Customize;

    /**
     * @var $Mylead_Model LeadpopsRepository
     */
    private $Mylead_Model;
    private $_exp_mod_obj;
    private $endpoint;
    private $auth_key;

    public function __construct(LpAdminRepository $lpAdmin, CustomizeRepository $customize, LeadpopsRepository $mylead, ExportRepository $_exp_mod_obj)
    {
        $this->middleware(function ($request, $next) use ($lpAdmin, $customize, $mylead, $_exp_mod_obj) {
            $this->Default_Model_Customize = $customize;
            $this->Mylead_Model = $mylead;
            $this->_exp_mod_obj = $_exp_mod_obj;
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(Session::get('leadpops'));
            $endpointUrl = getenv('LP_API_ENDPOINT_BASE_URL');
            $authKey = getenv('LP_API_ENDPOINT_AUTH_KEY');
            $this->endpoint = $endpointUrl ? $endpointUrl : config('lp.chargebee.lp_api_endpoint_base_url');
            $this->auth_key = $authKey ? $authKey : config('lp.chargebee.lp_api_endpoint_auth_key');
            $this->init($lpAdmin);
            if($request->ajax()) $this->check_ajax_session(); else $this->check_session();
            return $next($request);
        });
    }

    public function index()
    {
        return $this->response();
    }


    public function profile(LeadpopsRepository $lp, LpAccountRepository $lp_ac)
    {

        $this->header_partial = "";
        $this->data->client_id = $this->registry->leadpops->client_id;
        $this->data->clientInfo = $lp_ac->getClient($this->registry->leadpops->client_id);
        $this->data->clientName = \View_Helper::getInstance()->getClientName($this->registry->leadpops->client_id);
        $this->data->workingLeadpop = @$this->registry->leadpops->workingLeadpop;
        $this->data->clickedkey = @$this->registry->leadpops->clickedkey;
        $this->data->skeletonLogin = @$this->registry->leadpops->skeletonLogin;
        $this->data->leadpopList = $lp->getLeadpopList($this->registry->leadpops->client_id);
//        if(env('APP_ENV') === config('app.env_production')) {
        #require_once ('/var/www/vhosts/launch.leadpops.com/isdk/src/isdk.php');
        $app = new iSDK();
        $app->cfgCon("leadpops");
        $returnFields = array('Id', 'Email');
        if (@$_COOKIE['ifs_client_id'] != "") {
            $query = array('_leadPopsClientID' => $_COOKIE['ifs_client_id']);
        } else {
            $query = array('_leadPopsClientID' => $this->registry->leadpops->client_id);
        }
        $contacts = $app->dsQuery("Contact", 1, 0, $query, $returnFields);
        $contact = end($contacts);
        $this->data->payment_url = "https://leadpops.fortapay.com/invoice/list?Id=" . $contact['Id'] . "&Email=" . $contact['Email'];
//        }else{
//            $this->data->payment_url = "#";
//        }
        return $this->response();
    }

    public function savecontactinfo(Request $request, LpAccountRepository $lp_ac)
    {
        $error = array();
        $validator = Validator::make($request->all(), [
            'profile_img' => 'mimes:jpeg,jpg,png|image|max:2048'
        ]);

        if ($validator->fails()) {
            $error[] = CustomErrorMessage::getInstance()->getFirstError($validator, "profile_img");
        }

        $required_fields = array('contact_email' => "Email", 'password' => "Password", 'confirmpassword' => "Confirm Password", 'first_name' => "First Name", 'last_name' => "Last Name", 'company_name' => "Company Name", 'cell_number' => "Cell Phone", 'state' => "State", 'zip' => "Postal Code");
        if (getenv('APP_THEME') == "theme_admin3") {
            $required_fields['zip'] = "Zip Code";
        }
        foreach ($required_fields as $key => $label) {
            if ($request->input($key) == "" && !in_array($key, array('password', 'confirmpassword'))) {
                $error[] = $label . " field is required.";
            } else if ($key == "contact_email" && !filter_var($request->input("contact_email"), FILTER_VALIDATE_EMAIL)) {
                $error[] = $request->input("contact_email") . " is not a valid email address.";
            } else if ($key == "password" && $request->input("password") == "" && $request->input("confirmpassword") != "") {
                $error[] = "Password field is required.";
            } else if ($key == "confirmpassword" && $request->input("password") != "" && $request->input("confirmpassword") == "") {
                $error[] = "Confirm Password field is required.";
            }
        }

        if (($request->input('current_password') == "" || $request->input('current_password') == null) && $request->input('password') != "" && $request->input('confirmpassword') != "") {
            $error[] = "Current Password is required to change your password.";
        }

        if ($request->input('confirmpassword') != $request->input('password') && $request->input('password') != "" && $request->input('confirmpassword') != "") {
            $error[] = "New Password and Confirm Password fields do not match.";
        }

        $post = $request->input();

        $clientInfoBeforeUpdate = $lp_ac->getClient($post['client_id']);
        if ($post['current_password'] != "skeleton-login" && $post['current_password'] != "" && !\Hash::check($post['current_password'], $clientInfoBeforeUpdate['password'])) {
            $error[] = "You have entered an invalid current password.";
        }
        if ($clientInfoBeforeUpdate['contact_email'] != $post['contact_email']) {
            $emailExists = \DB::table('clients')->where(array('contact_email' => $post['contact_email']))->count();
            if ($emailExists > 0) {
                $error[] = str_replace("________", $post['contact_email'], config("alerts.accountSettingsDuplicateEmail." . config('view.theme')));
            }
        }
        /*
        if($post["emailnotify"] == "y" || ($post["emailnotify"] == "y" && $post["notify_email"] == "") ){
            $post["emailnotify"] = "y";
            $post["notify_email"] = $post["contact_email"];
        }
       */
        if (!empty($error)) {
            return $this->errorResponse($error[0]);
//            Session::flash('error', $error);
        } else {
            $ifs_data = array();
            // when client will update the email then will be email and funnels_user_name fields update on hubspot from @mzac90
            $ifs_email = $clientInfoBeforeUpdate['contact_email'];
            if ($clientInfoBeforeUpdate['contact_email'] != $post['contact_email']) {
                $ifs_data['new_email'] = $post['contact_email'];
                $ifs_data['funnels_user_name'] = $post['contact_email'];
                //email update on chargebee by customer id @mzac90
                if (env('APP_ENV') === config('app.env_production')) {
                    $response = $this->getChargebeeCustomer($ifs_email);
                    if ($response['status'] and $response['result']) {
                        $this->updateCustomerOnChargebee($response, $post['contact_email']);
                    }
                }
            }
            if (!empty($post['cell_number']) and $clientInfoBeforeUpdate['cell_number'] != $post['cell_number']) {
                $ifs_data['phone'] = $post['cell_number'];
            }
            if (!empty($post['zip']) and $clientInfoBeforeUpdate['zip'] != $post['zip']) {
                $ifs_data['zip'] = $post['zip'];
            }

            $lp_ac->saveEditProfileContact($post, $_FILES);

            if (!empty($post['password']) && ((\Hash::check($post['current_password'], $clientInfoBeforeUpdate['password']) && $post['current_password'] != $post['password']) || ($post['current_password'] == "skeleton-login"))) {

                $lp_ac->updatePassword($post['password'], $post);
                $ifs_data['funnels_password'] = $post['password'];
                /*
                $app = new iSDK();
                $app->cfgCon("leadpops");
                $returnFields = array('Id','Email','_AdminPassword');
                $query = array('_leadPopsClientID' => $post['client_id']);
                $contacts = $app->dsQuery("Contact",1,0,$query,$returnFields);
                if (count($contacts) > 0) {
                    $conDat = array('_AdminPassword' => $post['password']);
                    $conID = $app->updateCon($contacts[0]["Id"], $conDat);
                }
                */
            }

            if (!empty($ifs_data) and env('APP_ENV') === config('app.env_production')) {
                InfusionsoftGearmanClient::getInstance()->updateContact($ifs_data, $ifs_email);
            }

            if ($clientInfoBeforeUpdate['contact_email'] != $post['contact_email'] ||
                $clientInfoBeforeUpdate['cell_number'] != $post['cell_number'] ||
                $clientInfoBeforeUpdate['carrier'] != $post['carrier']) {
                $this->updatePrimaryLeadsOnAllFunnelsAction($clientInfoBeforeUpdate['contact_email'], $post['contact_email'], $post['cell_number'], $post['carrier'], $post['client_id']);
            }

            $_SESSION['leadpops']['clientInfo']['first_name'] = $post['first_name'];
            $_SESSION['leadpops']['clientInfo']['last_name'] = $post['last_name'];
            $_SESSION['leadpops']['clientInfo']['company_name'] = $post['company_name'];

            return $this->successResponse("Your profile has been updated.");
        }
        return back();
    }


    public function updatePrimaryLeadsOnAllFunnelsAction($previousEmail, $email, $phone_number, $carrier, $client_id)
    {

        $keys = array("leadpop_id", "leadpop_type_id", "leadpop_vertical_id", "leadpop_vertical_sub_id",
            "leadpop_template_id", "leadpop_version_id", "leadpop_version_seq");
        $recipient_uids = array();
        $sql = 'SELECT r.id as id, tr.id AS lp_auto_text_recipient_id, CONCAT(r.client_id,"-",r.leadpop_id,"-",r.leadpop_type_id,"-",
        r.leadpop_vertical_id,"-",r.leadpop_vertical_sub_id,"-",r.leadpop_template_id,"-",r.leadpop_version_id,"-",
        r.leadpop_version_seq) AS uid, r.email_address, tr.phone_number, tr.carrier
        FROM lp_auto_recipients r LEFT JOIN lp_auto_text_recipients tr ON r.id = tr.lp_auto_recipients_id
        WHERE r.client_id = ' . $client_id . ' AND r.is_primary = "y"';
        $recipients = $this->db->fetchAll($sql);

        $existing_uids_recipient = array();
        $existing_uids_recipient_text = array();
        $new_uids_recipient = array();
        $new_uids_recipient_text = array();

        if ($recipients) {
            $recipient_uids = array_column($recipients, 'uid');    //recepients entries exists for these
        }

        $_funnel_keys = array();
        LP_Helper::getInstance()->_fetch_all_funnels();
        foreach (LP_Helper::getInstance()->getFunnels() as $vertical => $vfunnels) {
            if ($vfunnels) {
                foreach ($vfunnels as $group => $gfunnels) {
                    if ($gfunnels) {
                        foreach ($gfunnels as $subvertical => $svfunnels) {
                            if ($svfunnels) {
                                foreach ($svfunnels as $client_leadpops_id => $funnelData) {
                                    $funnels_uid = $funnelData['client_id'] . '-' . $funnelData['leadpop_id'] . '-' . $funnelData['leadpop_type_id'] . '-' . $funnelData['leadpop_vertical_id'] . '-' . $funnelData['leadpop_vertical_sub_id'] . '-' . $funnelData['leadpop_template_id'] . '-' . $funnelData['leadpop_version_id'] . '-' . $funnelData['leadpop_version_seq'];
                                    $_funnel_keys[] = $funnels_uid;

                                    if (in_array($funnels_uid, $recipient_uids)) {
                                        foreach ($keys as $key) {
                                            $existing_uids_recipient[$key][] = $funnelData[$key];
                                        }
                                    } else {
                                        foreach ($keys as $key) {
                                            $new_uids_recipient[$key][] = $funnelData[$key];
                                        }
                                    }

                                    $key = array_search($funnels_uid, $recipient_uids);
                                    if (is_int($key)) {
                                        if ($recipients[$key]['lp_auto_text_recipient_id'] != "") {
                                            $existing_uids_recipient_text[$funnels_uid] = $recipients[$key]['lp_auto_text_recipient_id'];
                                        } else {
                                            $new_uids_recipient_text[$funnels_uid] = $recipients[$key]['id'];
                                        }
                                    } else {
                                        $new_uids_recipient_text[$funnels_uid] = "";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        ## debug($_funnel_keys,'funnel_keys', 0);
        ## debug($existing_uids_recipient_text,'existing_uids_recipient_text # '.count($existing_uids_recipient_text), 0);
        ## debug($new_uids_recipient_text,'new_uids_recipient_text # '.count($new_uids_recipient_text), 1);

        /* UPDATING EMAIL IN lp_auto_recipients */
        if ($existing_uids_recipient) {
            $where = array();
            foreach ($keys as $key) {
                $existing_uids_recipient[$key] = array_unique($existing_uids_recipient[$key]);
                $where[] = $key . " IN (" . implode(",", $existing_uids_recipient[$key]) . ")";
            }

            $sql = "UPDATE lp_auto_recipients SET email_address = '$email' WHERE client_id = $client_id AND " . implode(' AND ', $where) . " AND is_primary = 'y'";
            $this->db->query($sql);
            ## debug($sql,'',0);
        }

        /* INSERT EMAIL IN lp_auto_recipients */
        if ($new_uids_recipient) {
            foreach ($new_uids_recipient['leadpop_type_id'] as $i => $v) {
                $cols = $values = array();

                $cols[] = "client_id";
                $values[] = $client_id;

                $cols[] = "email_address";
                $values[] = "'$email'";

                $cols[] = "is_primary";
                $values[] = "'y'";
                foreach ($keys as $key) {
                    $cols[] = $key;
                    $values[] = $new_uids_recipient[$key][$i];
                }
                $sql = "INSERT INTO `lp_auto_recipients` (" . implode(", ", $cols) . ") VALUES (" . implode(", ", $values) . ");";
                $this->db->query($sql);
                $last_id = $this->db->lastInsertId();
                ## debug( $sql, '', 0 );

                $_funnels_uid = $client_id . '-' . $new_uids_recipient['leadpop_id'][$i] . '-' . $new_uids_recipient['leadpop_type_id'][$i] . '-' . $new_uids_recipient['leadpop_vertical_id'][$i] . '-' . $new_uids_recipient['leadpop_vertical_sub_id'][$i] . '-' . $new_uids_recipient['leadpop_template_id'][$i] . '-' . $new_uids_recipient['leadpop_version_id'][$i] . '-' . $new_uids_recipient['leadpop_version_seq'][$i];
                $new_uids_recipient_text[$_funnels_uid] = $last_id;
            }
        }

        /* UPDATING PHONE NUMBER IN lp_auto_text_recipients */
        if ($existing_uids_recipient_text) {
            $sql = "UPDATE lp_auto_text_recipients SET phone_number = '$phone_number', carrier = '$carrier' WHERE client_id = $client_id AND lp_auto_recipients_id IN (" . implode(',', $existing_uids_recipient_text) . ")";
            $this->db->query($sql);
            ## debug($sql,'',0);
        }

        /* INSERTING PHONE NUMBER IN lp_auto_text_recipients */
        if ($new_uids_recipient_text) {
            foreach ($new_uids_recipient_text as $keys => $lp_auto_recipients_id) {
                list($cid, $leadpop_id, $leadpop_type_id, $leadpop_vertical_id, $leadpop_vertical_sub_id, $leadpop_template_id, $leadpop_version_id, $leadpop_version_seq) = explode("-", $keys);
                $sql = "INSERT INTO `lp_auto_text_recipients` (`lp_auto_recipients_id`,`client_id`,`leadpop_id`,`leadpop_type_id`,`leadpop_vertical_id`,`leadpop_vertical_sub_id`,`leadpop_template_id`,`leadpop_version_id`,`leadpop_version_seq`,`phone_number`,`carrier`,`is_primary`) ";
                $sql .= " VALUES ($lp_auto_recipients_id, $client_id, $leadpop_id, $leadpop_type_id, $leadpop_vertical_id, $leadpop_vertical_sub_id, $leadpop_template_id, $leadpop_version_id, $leadpop_version_seq, '$phone_number', '$carrier', 'y');";
                $this->db->query($sql);
            }
        }

        //Removing entry from lp_auto_recipients, lp_auto_text_recipients when is_primary=n and email matched with previou OR current email address
        $sql = 'SELECT r.id as id, tr.id AS lp_auto_text_recipient_id,r.email_address
        FROM lp_auto_recipients r INNER JOIN lp_auto_text_recipients tr ON r.id = tr.lp_auto_recipients_id
        WHERE r.client_id = ' . $client_id . ' AND r.email_address in("' . $email . '", "' . $previousEmail . '") AND r.is_primary = "n"';
        $oldRecipients = $this->db->fetchAll($sql);

        if ($oldRecipients) {
            foreach ($oldRecipients as $recipient) {
                if ($recipient["lp_auto_text_recipient_id"]) {
                    $sql = "DELETE from lp_auto_text_recipients WHERE id = " . $recipient["lp_auto_text_recipient_id"] . " AND client_id = $client_id AND is_primary = 'n'";
                    $this->db->query($sql);
                }
            }

            //Removing entry with same primary email
            $sql = "DELETE from lp_auto_recipients WHERE client_id = $client_id AND email_address in('$email', '$previousEmail') AND is_primary = 'n'";
            $this->db->query($sql);
        }
    }

    public function contacts()
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
            $this->data->recipients = $newArray;
            $this->active_menu = LP_Constants::ALERTS;
            return $this->response();
        }
    }

    public function savenewrecipient(LpAccountRepository $lp_ac)
    {
        if ($_POST) {
            $r_id = $lp_ac->saveNewRecipient($_POST, $this->registry->leadpops->client_id);
            //$this->_forward('contacts','account', null, array('forwardpost' => $_POST));
            echo($r_id != "" ? trim(rtrim($r_id . "~~~" . $_POST['newclient_id'])) : (@$_POST['editrowid'] != "" ? $_POST['editrowid'] . '~~~edit-success' : 'new-row~added'));
            exit;
        }
    }

    public function deleteleadrecipient(Request $request)
    {
        $lp_auto_recipients_id = $request->input('recipient_id');
        $client_id = $request->input('client_id');
        $group_identifier = $request->input('group_identifier');
        if (isset($group_identifier) && $group_identifier != "") { // global recipent delete
            $s = "select id from lp_auto_recipients where group_identifier = '" . $group_identifier . "'";
            $s .= " and client_id = " . $client_id;
            $recipient_ids = $this->db->fetchAll($s);

            if ($recipient_ids) {
                $recipient_ids = array_column($recipient_ids, 'id');
                $recipient_ids = implode(",", $recipient_ids);
                $s = "delete from lp_auto_text_recipients where lp_auto_recipients_id IN (" . $recipient_ids . " ) ";
                $s .= " and client_id = " . $client_id;
                $this->db->query($s);

                $s = "delete from lp_auto_recipients where id IN (" . $recipient_ids . " ) ";
                $s .= " and client_id = " . $client_id;
                $this->db->query($s);
            }
        } else {
            $s = "delete from lp_auto_text_recipients where lp_auto_recipients_id = " . $lp_auto_recipients_id;
            $s .= " and client_id = " . $client_id;
            $this->db->query($s);

            $s = "delete from lp_auto_recipients where id = " . $lp_auto_recipients_id;
            $s .= " and client_id = " . $client_id;
            $this->db->query($s);

        }

        return $this->successResponse("Lead recipient has been deleted.");
//        Session::flash('success', "Lead recipient has been deleted.");
//        return $this->lp_redirect('/account/contacts/' . $_POST["current_hash"]);
    }


    //Comment: support controller function merge in acccount controller

    public function support()
    {
        $current_url = url()->current();
        $arr_data = explode("/", $current_url);

        $target_ele = end($arr_data);

        if ($target_ele == "videos") {
            $target_ele = "lp-sup-videos";

        } elseif ($target_ele == "ticket") {
            $target_ele = "lp-sup-ticket";
        }

        array_push($this->assets_js, LP_BASE_URL . config('view.theme_assets') . "/external/bootstrap.youtubepopup.min.js");
        $this->header_partial = "";
        $this->inline_js = '
            $("#btn-spt-form").click(function(event){
                $("#lp-support-form").submit();
                event.preventDefault();
            });
            ';
        $issue_data = $this->lp_admin_model->getSupportIssue();
        $this->data->support_video_data = $this->lp_admin_model->getSupportVideoData();
        $this->data->maintopic = $issue_data['maindata'];
        $this->data->subissuedata = $issue_data['final_data'];
        $this->data->target_ele = $target_ele;


        return $this->response();
    }

    function cancelrequest()
    {
        $sender_email = $this->registry->leadpops->clientInfo["contact_email"];
        $sender_name = $this->registry->leadpops->clientInfo["first_name"] . " " . $this->registry->leadpops->clientInfo["last_name"];
        LP_Helper::getInstance()->subject = "Request to cancel the leadPops Funnels account";
        LP_Helper::getInstance()->body = "This user wants to cancel the leadpops account .";
        LP_Helper::getInstance()->from_email = $sender_email;
        LP_Helper::getInstance()->from_name = $sender_name;
        LP_Helper::getInstance()->to = array(LP_ADMIN_EMAIL, LP_ADMIN_NAME);

        $return = array('responce' => '', "msg" => "");
        $s = "update clients set cancellation_status = '0' , cancellation_date = NOW()
         where ";
        $s .= "client_id = " . $this->registry->leadpops->clientInfo['client_id'];
        $this->db->query($s);
        if (LP_Helper::getInstance()->send_mail()) {
            $return['responce'] = "yes";
            $return['msg'] = "Your request has been sent.";
        } else {
            $return['responce'] = "no";
            $return['msg'] = 'An error occurred. Please try again.';
        }
        echo json_encode($return);
    }

    public function feed()
    {
        $sender_email = $this->registry->leadpops->clientInfo["contact_email"];
        $sender_name = $this->registry->leadpops->clientInfo["first_name"] . " " . $this->registry->leadpops->clientInfo["last_name"];
        LP_Helper::getInstance()->subject = $_POST['subject'];
        LP_Helper::getInstance()->body = $_POST['message'];
        LP_Helper::getInstance()->from_email = $sender_email;
        LP_Helper::getInstance()->from_name = $sender_name;
        LP_Helper::getInstance()->to = array(LP_ADMIN_EMAIL, LP_ADMIN_NAME);


        if (array_key_exists('format', $_POST) && $_POST["format"] == "json") {

            if (LP_Helper::getInstance()->send_mail()) {
                $msg = 'Your request has been sent.';
                $code = '200';
            } else {
                $msg = 'An error occurred. Please try again.';
                $code = '401';
            }
            echo json_encode(array("code" => $code, "msg" => $msg));
            exit;
        } else {
            if (LP_Helper::getInstance()->send_mail()) {
                Session::flash('success', 'Your request has been sent.');
            } else {
                Session::flash('error', 'Email or password is incorrect.');
            }
            return back();
        }
    }

    function testemail()
    {
        $email_conf = array(
            'auth' => 'login',
            'username' => 'saleemawasi@gmail.com',
            'password' => 'saleemawasi123',
            'ssl' => 'tls',
            'port' => '587'
        );
        $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $email_conf);
        Zend_Mail::setDefaultTransport($transport);
        $recipientEmail = "joomlogic@gmail.com";
        $subject = "This is the mail using the smtp gmail server";
        $html = "<p>Hy how r u ? Did u make a work that i ask u if u let me khow bro.</p>";

        $mailer = new Zend_Mail('utf-8');
        $mailer->addTo($recipientEmail);
        $mailer->setSubject($subject);
        $mailer->setBodyHtml($html);
        try {
            $mailer->send();
        } catch (Exception $e) {
            die('Exception caught: ' . $e->getMessage() . "\n");
        }
    }

    //Comment: myleads controller function merge in acccount controller

    public function myleads()
    {
        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);
            array_push($this->assets_js, LP_BASE_URL . config('view.theme_assets') . "/external/jquery.twbsPagination.min.js");
            $this->active_menu = LP_Constants::MY_LEADS;
            $this->data->result_per_page = (isset($_POST["result_per_page_val"]) && $_POST["result_per_page_val"] != NUll) ? $_POST["result_per_page_val"] : RESULT_PER_PAGE;
            $this->data->page = (isset($_POST["page"]) && $_POST["page"] != NUll) ? $_POST["page"] : 1;
            $this->data->letter = (isset($_POST["letter"]) && $_POST["letter"] != NUll) ? $_POST["letter"] : "";
            $this->data->sortby = (isset($_POST["sortby"]) && $_POST["sortby"] != NUll) ? $_POST["sortby"] : "desc";
            return $this->response();
        }
    }

    private function setCommonDataForView($hash_data, $session)
    {
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
        $this->data->unlimitedDomains = $this->Default_Model_Customize->checkUnlimitedDomains($hash_data["funnel"]["client_id"], $hash_data["funnel"]["leadpop_id"], $hash_data["funnel"]["leadpop_version_seq"]);
        $this->data->currenturl = LP_Helper::getInstance()->getCurrentUrl();
        $this->data->currenturlstatus = $this->Default_Model_Customize->getLeadpopStatusV2($hash_data);
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

    function getleads()
    {
        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $session = LP_Helper::getInstance()->getSession();
            $this->setCommonDataForView($hash_data, $session);

            $return_data = \MyLeads_Helper::getInstance()->getMyLeadsKeyDB($_POST['client_id'], $_POST['leadpop_id'], $_POST['leadpop_version_seq'], $_POST);

            echo json_encode($return_data);

        } else {
            echo 'something wronge ajax call';

        }
    }

    function getallfunnelkey()
    {
        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $return_data = $this->Mylead_Model->getAllFunnelKey();
            echo json_encode($return_data["allkey"]);
        } else {
            echo 'something wronge ajax call';
        }
    }

    function getleaddetail()
    {
        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $return_data = $this->Mylead_Model->getLeadDetail();
            if (env('APP_ENV') != config('app.env_local')) {
                MyLeadsEvents::getInstance()->updateStatsRedis(array('client_id' => $hash_data['funnel']['client_id'], 'leadpop_client_id' => $hash_data['funnel']['client_leadpop_id'], 'domain_id' => $hash_data['funnel']['domain_id']));
                // Update opened flag in Redis Record
                \MyLeads_Helper::getInstance()->updateLeadContentKeyDb($hash_data['client_id'], $hash_data['leadpop_id'], $hash_data['leadpop_version_seq'], $_POST['unique_key']);
                if ($return_data) {
                    if (RADIS_LEAD_UPDATE == true || @$_COOKIE['myleads'] == "keydb") {
                        updateFunnelNewLeadDashboard($hash_data);
                    }
                }
            }
            echo $return_data;
        }
    }

    function leadchangestatus()
    {
        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $return_data = $this->Mylead_Model->updateLeadStatus();
        }
    }

    function myleadpopprint()
    {
        $return_data = $this->Mylead_Model->getMyLeadPopPrint();
        echo $return_data;

    }

    /**
     * Deletes a Multiple Leads
     */
    function deleteMultipleLeads()
    {
        LP_Helper::getInstance()->getCurrentHashData();
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $delete_ids = array();
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $sunique = $_POST['allfunnelkey'];
            $delete_ids = $_POST['u'];
            if ($sunique == 1) {
                $allfunnelkeys = $this->Mylead_Model->getAllFunnelKey();
                $delete_ids = implode('~', $allfunnelkeys['allkey']);
            }

            $del_counter = $this->Mylead_Model->deleteSelectesLeads($delete_ids, $_POST['client_id']);
            if (getenv('APP_ENV') != config('app.env_local')) {
                if ($del_counter > 0) {
                    if (RADIS_LEAD_UPDATE == true || @$_COOKIE['myleads'] == "keydb") {
                        updateLeadContentInKeyDB($hash_data, $delete_ids);
                    }
                }
            }
            echo $del_counter;
        }
    }

    /**
     * Deletes a specific Lead
     */
    function deleteLead()
    {
        LP_Helper::getInstance()->getCurrentHashData($_POST["hash"]);
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $delete_id = $_POST['u'];
            $del_counter = $this->Mylead_Model->deleteSelectesLeads($delete_id, $_POST['client_id']);
            if (getenv('APP_ENV') != config('app.env_local')) {
                if ($del_counter > 0) {
                    if (RADIS_LEAD_UPDATE == true || @$_COOKIE['myleads'] == "keydb") {
                        updateLeadContentInKeyDB($hash_data, $delete_id);
                    }
                }
            }
            echo $del_counter;
        }
    }


    /**
     * get chargebee customer by email @mzac90
     * @param $email
     * @return mixed
     */
    function getChargebeeCustomer($email)
    {
        $handle = curl_init();
        $url = $this->endpoint . '/api/chargebee/customer/get-customers';
        $postField = json_encode(array('email[is]' => $email));
        $headers = array(
            'Authorization:' . $this->auth_key,
            "Content-Type:application/json",
            'Content-Length:' . strlen($postField)
        );
        curl_setopt_array($handle,
            array(
                CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLINFO_HEADER_OUT => true,
                CURLOPT_POSTFIELDS => $postField,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_RETURNTRANSFER => true
            )
        );

        $data = curl_exec($handle);
        curl_close($handle);
        return json_decode($data, true);
    }

    /**
     * update customer email by chargebee customer id on chargebee @mzac90
     * @param $customer
     * @param $email
     */
    function updateCustomerOnChargebee($customer, $email)
    {
        $customerId = $customer['result'][0]['customer']['id'];
        $handle = curl_init();
        $url = $this->endpoint . '/api/chargebee/customer/update-customer/' . $customerId;
        $postField = json_encode(array('email' => $email));
        $headers = array(
            'Authorization:' . $this->auth_key,
            "Content-Type: application/json",
            'Content-Length:' . strlen($postField)
        );
        curl_setopt_array($handle,
            array(
                CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLINFO_HEADER_OUT => true,
                CURLOPT_POSTFIELDS => $postField,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_RETURNTRANSFER => true
            )
        );
        $data = curl_exec($handle);
        curl_close($handle);
    }


    //==============================================================================================
    //=================================AdminThree===================================================
    //==============================================================================================

    public function saveNewRecipientAdminThree(LpAccountRepository $lp_ac, Request $request)
    {
        // dd($request->all());


        if ($request->isnewrowid == 'n') {
            $res = $lp_ac->editRecipientAdminThree($_POST, $this->registry->leadpops->client_id);
            if ($res == 'edit') {
                return $this->successResponse("Lead recipient has been updated.", ['action'=>'edit']);
//                Session::flash('success', "Lead recipient has been updated.");
            } elseif ($res == 'edit-duplicate') {
                return $this->errorResponse("This email address already exists in the list.");
//                Session::flash('error', "This email address already exists in the list.");
            }

        } else {
            $res = $lp_ac->saveNewRecipientAdminThree($_POST, $this->registry->leadpops->client_id);
            if (is_numeric($res) && $res) {
                return $this->successResponse("Lead recipient has been added.", ['action'=>'add', 'id'=>$res]);
//                Session::flash('success', "Lead recipient has been added.");
            } elseif ($res == 'new-duplicate') {
                return $this->errorResponse("This email address already exists in the list.");
//                Session::flash('error', "This email address already exists in the list.");
            }
        }


        return $this->lp_redirect('/account/contacts/' . $_POST["current_hash"]);
    }


    public function saveNewRecipientGlobalAdminThree(LpAccountRepository $lp_ac, Request $request)
    {
        $lplist = explode(",", $request->selected_funnels);
        if (empty($request->selected_funnels) || !count($lplist)) {
            return $this->errorResponse("Please select Funnels for global action.");
//            Session::flash('error', '<strong>Error:</strong> Please select Funnels for global action.');
//            return redirect()->back();
        }

         //dd($_POST);
//            $r_id = $lp_ac->saveNewRecipient($_POST,$this->registry->leadpops->client_id);
//        if ($request->isnewrowid == 'n') {
//            $res = $lp_ac->editRecipientGlobalAdminThree($_POST, $this->registry->leadpops->client_id);
//        } else {
            $res = $lp_ac->saveRecipientGlobalAdminThree($_POST, $this->registry->leadpops->client_id);
//        }
        //$this->_forward('contacts','account', null, array('forwardpost' => $_POST));
        //  echo($r_id != "" ? trim(rtrim($r_id . "~~~" . $_POST['newclient_id'])) : (@$_POST['editrowid'] != "" ? $_POST['editrowid'] . '~~~edit-success' : 'new-row~added'));
        //  exit;
//      dd($res);

        if ($res === 'edit-duplicate') {
            return $this->errorResponse("This email address already exists in the list.");
//            Session::flash('error', "This email address already exists in the list.");
        } else {
            $data = ['action' => $res];
            if(is_numeric($res)) {
                $data = ['action' => 'add', 'id' => $res];
            }
            return $this->successResponse("Lead recipient has been saved.", $data);
//            Session::flash('success', "Lead recipient has been saved.");
        }

        return $this->lp_redirect('/account/contacts/' . $_POST["current_hash"]);
    }

    public function deleteRecipientGlobalAdminThree(Request $request)
    {
        $lp_auto_recipients_id = $request->input('recipient_id');
        $client_id = $request->input('client_id');
        //  $group_identifier = $request->input('group_identifier');

        $lplist = explode(",", $_POST['selected_funnels']);
        if (empty($lplist) || !count($lplist)) {
            return $this->errorResponse("Please select Funnels.");
        }

        //start add current Funnel key
        $currentHash = $_POST['current_hash'];
        $currentKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        if (!empty($currentKey)) {
            array_push($lplist, $currentKey);
        }
        //end add current Funnel key

        $s = "select * from lp_auto_recipients ";
        $s .= " where client_id =  " . $client_id;
        $s .= " AND id =  '" . $request->recipient_id . "'";
        $referenceRecord = $this->db->fetchRow($s);
        if($referenceRecord == null){
            return $this->errorResponse("This lead recipient isn't exists in the list.");
        }

        foreach ($lplist as $index => $lp) {
            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];

            $s = "select id from lp_auto_recipients ";
            $s .= " where client_id =  " . $client_id;
            $s .= " AND leadpop_vertical_id =  " . $leadpop_vertical_id;
            $s .= " AND leadpop_vertical_sub_id =  " . $leadpop_vertical_sub_id;
            $s .= " AND leadpop_id =  " . $leadpop_id;
            $s .= " AND leadpop_version_seq =  " . $leadpop_version_seq;
            $s .= " AND email_address =  '" . $referenceRecord["email_address"] . "'"; //added

            $s = "select id from lp_auto_recipients where  email_address =  '" . $referenceRecord["email_address"] . "'";
            $s .= " AND leadpop_vertical_id =  " . $leadpop_vertical_id;
            $s .= " AND leadpop_vertical_sub_id =  " . $leadpop_vertical_sub_id;
            $s .= " AND leadpop_id =  " . $leadpop_id;
            $s .= " AND leadpop_version_seq =  " . $leadpop_version_seq;
            $s .= " and client_id = " . $client_id;
            $recipient_ids = $this->db->fetchAll($s);

            if ($recipient_ids) {
                $recipient_ids = array_column($recipient_ids, 'id');
                $recipient_ids = implode(",", $recipient_ids);
//            dd($recipient_ids);
                $s = "delete from lp_auto_text_recipients where lp_auto_recipients_id IN (" . $recipient_ids . " ) ";
                $s .= " AND leadpop_vertical_id =  " . $leadpop_vertical_id;
                $s .= " AND leadpop_vertical_sub_id =  " . $leadpop_vertical_sub_id;
                $s .= " AND leadpop_id =  " . $leadpop_id;
                $s .= " AND leadpop_version_seq =  " . $leadpop_version_seq;
                $s .= " and client_id = " . $client_id;
                $this->db->query($s);

                $s = "delete from lp_auto_recipients where id IN (" . $recipient_ids . " ) ";
                $s .= " AND leadpop_vertical_id =  " . $leadpop_vertical_id;
                $s .= " AND leadpop_vertical_sub_id =  " . $leadpop_vertical_sub_id;
                $s .= " AND leadpop_id =  " . $leadpop_id;
                $s .= " AND leadpop_version_seq =  " . $leadpop_version_seq;
                $s .= " and client_id = " . $client_id;
                $this->db->query($s);
            }
        }

        return $this->successResponse("Lead recipient has been deleted.");
//        Session::flash('success', "Lead recipient has been deleted.");
//        return $this->lp_redirect('/account/contacts/' . $_POST["current_hash"]);

       /* $s = "delete from lp_auto_text_recipients where email_address =  '" . $referenceRecord["email_address"] . "'";
        $s .= " and client_id = " . $client_id;
        $this->db->query($s);

        $s = "delete from lp_auto_recipients where id = " . $lp_auto_recipients_id;
        $s .= " and client_id = " . $client_id;
        $this->db->query($s);*/

    }
}
