<?php

namespace App\Http\Controllers;
use App\Constants\Layout_Partials;
use App\Constants\LP_Constants;
use App\Repositories\LeadpopsRepository;
use App\Repositories\LpAdminRepository;
use App\Repositories\ClientRepository;
use App\Services\DataRegistry;
use App\Services\gm_process\InfusionsoftGearmanClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use LP_Helper;

class LoginController extends BaseController {

    protected $loginRepo;
    protected $lpAdmin;

    public function __construct(LpAdminRepository $lpAdmin, ClientRepository $client){
        $this->init($lpAdmin);
        $this->loginRepo = $client;
        $this->lpAdmin = $lpAdmin;
    }

    public function logout(Request $request){
        $request->session()->flush();
        Auth::logout();

        // we dont want to redirect to previous url if we are logging out
        // so we set it to true to check in subsequent request
        $request->session()->put('lp.loggedOut', true);

        return redirect()->route('login');
    }

    public function indexAction(Request $request) {
        $emailUsername = $request->get('u');
        $emailPassword = $request->get('p');
        $emailInvoice = $request->get('i');

        if($request->get('keys') != null){
            $this->data->key = str_replace("key=","",end(explode('&',$_SERVER['QUERY_STRING'])));
        }

        if(isset($emailUsername) && $emailUsername != '' && isset($emailPassword) && $emailPassword != ''  && isset($emailUsername) && $emailInvoice != '' ) {
            $redirect = $this->loginRepo->checkEmailClick($emailUsername,$emailPassword,$emailInvoice);
            $registry = DataRegistry::getInstance();
            if($redirect) {
                return $this->_redirect($redirect);
            }else if($registry->leadpops->loggedIn == 1) {
                return $this->_redirect('/shoppops');
            }
        }

        $this->body_class = ['login-bg'];

        // To redirect user to previous funnel or some admin specific url after login
        // we first get previous url
        $previousUrl = url()->previous();
        // making it consistent because URL has non https links on few places in admin
        $previousUrl = str_replace('https://', 'http://', $previousUrl);

        // also get base url to check if previous url was from admin
        $baseUrl = url('/');
        // making it consistent because URL has non https links on few places in admin
        $baseUrl = str_replace('https://', 'http://', $baseUrl);

        // extract path from it for later use
        $urlPath = str_replace($baseUrl, '', $previousUrl);

        // preparing regex to match home or login page URLs
        $lpPathRegex = str_replace('/', '\/', rtrim(LP_PATH, '/'));
        $excludedPaths = "/^\/$|^$lpPathRegex\/?$|^$lpPathRegex\/index\/?$|^$lpPathRegex\/login\/?.*\/|^$lpPathRegex\/password\/?.*/";

        // before queuing previous url for redirection
        // we check if previous url is an admin url and not some third party
        $isPreviousAnAdminUrl = strpos($previousUrl, $baseUrl) === 0;
        // we also check if it is not home or login url
        $isExcludedPath = $urlPath == '' || preg_match($excludedPaths, $urlPath);

        // we dont want to save previous url if last action was to log out of admin
        $wasLoggingOut = $request->session()->pull('lp.loggedOut');

        // check if previous login attempt failed
        $queryParam = $request->query();
        $loginAttemptFailed = isset($queryParam['ok']) && $queryParam['ok'] == 'no';

        // we don't want to clear previous URL if previous login attempt failed
        if(!$loginAttemptFailed){
            // clear previous set url for each login page request
            $request->session()->pull('lp.previousUrl');
        }

        // we check for above tested conditions
        if($isPreviousAnAdminUrl && !$isExcludedPath && !$wasLoggingOut){
            // previous url for this key will be available in subsequent requests
            $request->session()->put('lp.previousUrl', $previousUrl);
        }

        return $this->response();
    }

    public function isandrewAction() {
        $key = LP_Helper::encrypt(json_encode($_REQUEST));
        if(array_key_exists(env('APP_SKELETON'), $_REQUEST) && $_REQUEST[env('APP_SKELETON')] == ""){
            Session::flash('error', 'Skeleton client ID is missing.');
            return $this->_redirect(LP_PATH."/login");
        }
        else if(!array_key_exists(env('APP_SKELETON'), $_REQUEST)){
            Session::flash('error', 'Invalid Skeleton Key.');
            return $this->_redirect(LP_PATH."/login");
        }

        return $this->_redirect(LP_PATH."/login?key=".$key);
    }



    public function goAction(){
        $login = $this->loginRepo;
        if(@$_POST["s_key"]!=""){
            $s_key = $_POST["s_key"];
            $registry = DataRegistry::getInstance();
            $registry->leadpops->skeletonLogin = 0;
            if($_POST['un']==LEADPOPS_USER && $_POST['pw']==LEADPOPS_PASSWORD){
                $s_key = json_decode(LP_Helper::decrypt($s_key),1);
                $val = $login->isandrew($s_key);
                if($val == 'ok') {
                    $registry->leadpops->skeletonLogin = 1;
                    return $this->_redirect(LP_PATH.'/index');
                    exit;
                }
            }
            else if($_POST['un']==MOVEMENT_USER && $_POST['pw']==MOVEMENT_PASSWORD){
                $s_key = json_decode(LP_Helper::decrypt($s_key),1);
                $val = $login->ismovement($s_key);
                if($val == 'ok') {
                    return $this->_redirect(LP_PATH.'/index');
                    exit;
                }
            }
            else if($_POST['un']==FAIRWAY_USER && $_POST['pw']==FAIRWAY_PASSWORD){
                $s_key = json_decode(LP_Helper::decrypt($s_key),1);
                $val = $login->isfairwaymc($s_key);
                if($val == 'ok') {
                    return $this->_redirect(LP_PATH.'/index');
                    exit;
                }
            }

            if(isset($val) and $val == "blocked"){   //active = 0
                Session::flash('error', 'This account is no longer active, please contact support@leadpops.com.');
            }
            else if(isset($val) and $val == 'pause'){
                Session::flash('error', 'Your account state is paused, please contact support@leadpops.com.');
            }else{
                Session::flash('error', 'Email or password is incorrect.');
            }

            return $this->_redirect(LP_PATH.'/login?ok=no&key='.$_POST["s_key"]);
        }
        else {
            // check if client is fully Launched
            $client = DB::table('clients')
                ->where('contact_email', $_POST['un'])
                ->where('launch_status',   config('lp.launch_status.both_password_and_launchscreen'))
                ->first();

            if ($client !== null) {
                $loginResp = $login->isOk($_POST);

                if(!empty($loginResp) and $loginResp == "blocked"){   //active = 0
                    Session::flash('error', 'This account is no longer active, please contact support@leadpops.com.');
                    return $this->_redirect(LP_PATH.'/login?ok=no');
                }
                else if(!empty($loginResp) and $loginResp == "pause"){ //active = 1 AND is_pause = 1
                    Session::flash('error', 'Your account state is paused, please contact support@leadpops.com.');
                    return $this->_redirect(LP_PATH.'/login?ok=no');
                }
                else if(!empty($loginResp) and $loginResp == 1){
                    Session::flash('error', 'Account does not exist.');
                    return $this->_redirect(LP_PATH.'/login?ok=no');
                }
                else if ($loginResp) {
                    if (env('APP_ENV') === config('app.env_production')) {
                        $ifs_data = array();
                        $ifs_data['Contact._MyLeadsLastLogin'] = date('m/d/Y @ g:ia');
                        $ifs_email = $_POST['un'];
                        if (@$_COOKIE['ifs-email'] != "") {
                            $ifs_email = $_COOKIE['ifs-email'];
                        }

                        //Block IFS communication for @test-leadpops.com
                        if (strpos($ifs_email, "@test-leadpops.com") === false) {
                            InfusionsoftGearmanClient::getInstance()->updateContact($ifs_data, $ifs_email);

                            $clientInfo = array();
                            $clientInfo['client_id'] = $loginResp;
                            $clientInfo['email'] = $ifs_email;
                            InfusionsoftGearmanClient::getInstance()->updateLoginReport($clientInfo);
                        }
                    }

                    return $this->_redirect(LP_PATH . '/index');
                } else {
                    Session::flash('error', 'Email or password is incorrect.');
                    return $this->_redirect(LP_PATH.'/login?ok=no');
                }
            } else {
                /*
                 * Change Request from Peter: (09/10/2020)
                 * Instead showing below message we need to redirect user to Launch Screen because we got few cases where clients
                 * not getting emails so if user has setup their password then they can go to login screen. and in case if they have not set
                 * password they have to contact our support team
                 *
                 */
                //Session::flash('error', 'User is not active or not exist!');
                //return $this->_redirect(LP_PATH . '/login?ok=no');

                $client = DB::table('clients')->where('contact_email', $_POST['un'])->first();

                if ($client !== null) {
                    if($client->launch_status == config('lp.launch_status.password_only')){
                        if(  \Hash::check($_POST["pw"], $client->password) ){
                            $hash = \LP_Helper::encrypt(json_encode(["id" => $client->client_id, "email" => $client->contact_email]));
                            return $this->_redirect(LP_PATH.'/launcher?hash='.$hash);
                        } else {
                            Session::flash('error', 'You have entered an incorrect password. Please check and try again.');
                            return $this->_redirect(LP_PATH.'/login?ok=no');
                        }
                    } else {
                        Session::flash('error', 'Your account has not been activated yet. Please contact support@leadpops.com.');
                        return $this->_redirect(LP_PATH . '/login?ok=no');
                    }
                }
                else{
                    Session::flash('error', 'The email you entered did not match our records. Please check and try again.');
                    return $this->_redirect(LP_PATH . '/login?ok=no');
                }
            }
        }
    }

    public function reportingAction() {
        $login = $this->loginRepo;
        $hash = str_replace("~", "+", $_GET['key']);
        $key = explode("=", LP_Helper::getInstance()->decrypt($hash));
        $get[$key[0]] = $key[1];
        if(@$_GET['debug'] === "reporting_login"){
            echo $hash."<br />";
            echo "<pre>".print_r($get,1)."</pre>"; exit;
        }
        $val =   $login->isandrew($get);
        if($val == 'ok') {
            return $this->_redirect(LP_PATH.'/index');
        }else {
            return $this->_redirect(LP_PATH.'/login?ok=no');
        }
    }

    public function ismovementAction() {
        $key = LP_Helper::encrypt(json_encode($_REQUEST));
        return $this->_redirect(LP_PATH."/login?key=".$key);
    }

    public function isfairwaymcAction() {
        $key = LP_Helper::encrypt(json_encode($_REQUEST));
        return $this->_redirect(LP_PATH."/login?key=".$key);
    }

    public function freeTrialLogin(){
        if (isset($_COOKIE["leadpops_session"]) && $_COOKIE["leadpops_session"] != "") {
            $tempid = $this->lpAdmin->isfreetrial($_COOKIE["leadpops_session"]);
            if ($tempid != 0) {
                #$this->lpAdmin->deletetrialdata($_COOKIE["leadpops_session"]);
                $this->client_id = $tempid;
                setcookie("leadpops_session", "", time() - 3600, "/", ".leadpops.com");
            }

            return $this->_redirect(LP_PATH.'/index');
        }
        else{
            die("Invalid Route.");
        }
    }


    /* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
                    CODE BELOW TO THIS SEPERATION NEEDS TO VERIFY
     ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */


    public function mmlinkAction() {
        $login = $this->loginRepo;
        $val =   $login->mmlink($_GET);

        if($val == 'ok') {
            return $this->_redirect('/index');
        }
        else {
            return $this->_redirect('/login?ok=no');
        }
    }

    public function fwlinkAction() {
        $login = $this->loginRepo;
        $val =   $login->fwlink($_GET);

        if($val == 'ok') {
            return $this->_redirect('/index');
        }
        else {
            return $this->_redirect('/login?ok=no');
        }
    }

}
