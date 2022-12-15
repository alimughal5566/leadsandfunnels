<?php
/**
 * Created by PhpStorm.
 * User: Jazib
 * Date: 11/02/2020
 * Time: 12:35 AM
 *
 * Code Migrated from Zend to Laravel  ==>  LpAcccountRepository --> Source: api/homebot.php
 */
namespace App\Http\Controllers;

use App;
use App\Repositories\CustomizeRepository;
use App\Services\DbService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LP_Helper;
use Session;

class HomebotController extends Controller {

    /** @var  DbService $db */
    protected $db;
    private $Default_Model_Customize;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomizeRepository $customtizeRepo){
        $this->Default_Model_Customize = $customtizeRepo;
    }

    public function actionCall(Request $request){
        $app_url = config('app.url');
        $session_id = session()->getId();
        $SESSION = array();

        if (!isset($_GET['code']) && !isset($_GET['error']))  {
            header("Location: ".env("APP_URL"));
            exit;
        }

        date_default_timezone_set('America/Los_Angeles');

        $dt = date("Y-m-d H:i:s");
        $code = (isset($_GET['code']) ? $_GET['code'] : false);
        $state = (isset($_GET['state']) ? $_GET['state'] : false);
        $error = (isset($_GET['error']) ? $_GET['error'] : false);

        if ($error == "access_denied") {
            Session::put('homebotExpertError', "access denied");
            $homebotHash = Session::get('homebotHash');

            if($homebotHash == "global-settings") {
                header("Location: ".$app_url."/lp/global?id=integration");
                exit;
            }
            else {
                header("Location: ".$app_url."/lp/popadmin/integration/" . $homebotHash);
                exit;
            }
            exit;
        }

        $this->db = App::make('App\Services\DbService');

        # We don't need to Query Separately for this database as our session is already active when user is redirect back so just compare session id to valid session mismatch case
        /*
        $s = "select * from session_console where session_id = '" . $state . "' limit 1 ";
        $session_console = $sdb->fetchAll($s);
        session_decode($session_console[0]["session_data"]);
        */

        $homebotExpertHash = Session::get('homebotExpertHash');
        if(Session::get('leadpops') !== null){
            $session_console = json_decode(json_encode(Session::get('leadpops')),1);
        } else {
            $session_console = array();
        }

        if(count($session_console) == 0) {
            Session::put('homebotError', "session mismatch");
            if($homebotExpertHash == "global-settings") {
                header("Location: ".env("APP_URL")."/lp/global?id=integration");
                exit;
            }
            else {
                header("Location: ".env("APP_URL")."/lp/popadmin/integration/" . $homebotExpertHash);
                exit;
            }
            exit;
        }

        $SESSION["leadpops"] = $session_console;


        $redirect = "https://app.leadpops.com/api/homebot.php";
        //$redirect = env("APP_URL") . "/api/homebot.php";
        $homebot_client_id = "GGZbPSDB6P06ZEpNPaMzuN3AqqANnwsNnS0iNPT0B5U";
        $homebot_secret = "19JNXCn4nVg223ox7ABud1n_EzEkRxoykzdiWnM34Xw";
        $api = "https://api.homebotapp.com/";
        //$granttype = '{"grant_type": "client_credentials"}';
        $granttype = '{"grant_type": "authorization_code"}';
        $auth = base64_encode($homebot_client_id.":".$homebot_secret);

        $s = "select * from homebot where client_id = " . $SESSION["leadpops"]["client_id"];
        $exists = $this->db->fetchAll($s);

        if(count($exists) == 0) {
            $s = "insert into homebot (id,client_id,basic_auth,";
            $s .= "authorization_code,access_token,api,grant_type,active,created_at,updated_at) values (null,";
            $s .= $SESSION["leadpops"]["client_id"] . ",'". $auth . "',";
            $s .= "'".$code."','','".$api."','".$granttype."',1,'".$dt."','".$dt."')";
            if($this->db->query($s)) {
                $this->Default_Model_Customize->insertClientIntegrations(config('integrations.iapp.HOMEBOT')['sysname'], $SESSION["leadpops"]["client_id"]);
            }
        }
        else {
            $s = "update homebot set authorization_code = '".$code."',";
            $s .= "access_token = '',updated_at = '".$dt."' ";
            $s .= "where client_id = " . $SESSION["leadpops"]["client_id"];
            $this->db->query($s);
        }

        // then get access_token


        $tokenurl = "https://api.homebotapp.com/oauth/token";
        //$data = array("grant_type" =>"client_credentials","client_id" => $homebot_client_id,"client_secret" => $homebot_secret, "code" => $code, "redirect_uri" => $redirect);
        $data = array("grant_type" =>"authorization_code","client_id" => $homebot_client_id,"client_secret" => $homebot_secret, "code" => $code, "redirect_uri" => $redirect);
        $jsondata = json_encode($data);
        $tokenapi = curl_init($tokenurl);
        curl_setopt($tokenapi, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json')
        );
        curl_setopt($tokenapi, CURLOPT_POSTFIELDS, $jsondata);
        curl_setopt($tokenapi, CURLOPT_POST, 1);
        curl_setopt($tokenapi, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($tokenapi);
        @$tokenObj = json_decode($result);
        @$token = $tokenObj->access_token;
        @$refreshToken = $tokenObj->refresh_token;
        @$expires_in = $tokenObj->expires_in;

        if (is_string($token)) {
            $s = "update homebot set access_token = '".$token."',";
            $s .= "refresh_token = '".$refreshToken."', ";
            $s .= "expires_in = '".$expires_in."' ";
            $s .= "where client_id = " .  $SESSION["leadpops"]["client_id"];
            $this->db->query($s);
        }
        else {
            Session::put('homebotError', "no token");
            if($homebotExpertHash == "global-settings") {
                header("Location: ".env("APP_URL")."/lp/global?id=integration");
                exit;
            }
            else {
                header("Location: ".env("APP_URL")."/lp/popadmin/integration/" . $homebotExpertHash);
                exit;
            }
        }
        Session::put('homebotError', "");

        if($homebotExpertHash == "global-settings") {
            header("Location: ".env("APP_URL")."/lp/global?id=integration");
            exit;
        }
        else {
            header("Location: ".env("APP_URL")."/lp/popadmin/integration/" . $homebotExpertHash);
            exit;
        }
        exit;
    }
}
