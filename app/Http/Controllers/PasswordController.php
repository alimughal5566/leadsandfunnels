<?php

namespace App\Http\Controllers;
use App\Client;
use App\Mail\ResetPassword;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
use App\Services\DbService;
use App\Services\gm_process\InfusionsoftGearmanClient;
use DB;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use iSDK;
use LP_Helper;

class PasswordController extends BaseController {

    public function __construct(LpAdminRepository $lpAdmin){
        $this->init($lpAdmin);
    }

    private function __getToken($length = 16){
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    public function sendResetLinkEmail(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if( ! $validator->fails() ){
            if( $user = Client::where('contact_email', $request->input('email') )->first() ){
                $token = $this->__getToken(64);

                $now = new \DateTime();
                DB::delete("DELETE FROM ".config('auth.passwords.users.table')." WHERE email = '".$user->contact_email."'");
                DB::table(config('auth.passwords.users.table'))->insert([
                    'email' => $user->contact_email,
                    'token' => $token,
                    'created_at' => $now->format('Y-m-d H:i:s'),
                ]);

                Mail::to($user->contact_email)->send(new ResetPassword($user, $token));
                echo json_encode(['status'=>'200', 'message' => trans(Password::RESET_LINK_SENT)]);
                exit;
            }
            else{
                echo json_encode(['http_code'=>'400', 'message' => trans(Password::INVALID_USER)]);
                exit;
            }
        }

        echo json_encode(['http_code'=>'400', 'message' => trans(Password::INVALID_USER)]);
        exit;
    }

//    public function newPasswordAction($token, Request $request){
//        $resetTokenInfo = DB::table(config('auth.passwords.users.table'))
//            ->where('token', $token)->first();
//
//        $now = new \DateTime();
//        $created_at = new \DateTime($resetTokenInfo->created_at);
//
//        $interval = $now->diff($created_at);
//        $hours   = $interval->format('%h');
//        $minutes = $interval->format('%i') + ($hours * 60);
//
//        if(config('auth.passwords.users.expire') > $minutes){
//            $this->data->token = $token;
//            $this->data->email = $resetTokenInfo->email;
//        } else {
//            $this->data->token = "";
//            $this->data->email = "";
//        }
//
//        $this->body_class = ['login-bg'];
//        return $this->response();
//    }

    public function resetPassword(Request $request){
        if( ($request->input('password') === $request->input('password2')) && $request->input('email') != ""){
            $rows = DB::select("SELECT * FROM clients WHERE contact_email = '".$request->input('email')."'");
            if($rows){
                $res = objectToArray($rows[0]);

                #DB::delete("DELETE FROM ".config('auth.passwords.users.table')." WHERE email = '".$request->input('email')."'");
                DB::update("UPDATE clients SET password = '".Hash::make($request->input('password'))."' WHERE contact_email = '".$request->input('email')."'");

                if (Auth::attempt(['contact_email' => $request->input('email'), 'password' => $request->input('password')])) {
                    $registry = DataRegistry::getInstance();
                    $registry->leadpops->client_id = $res['client_id'];
                    $registry->leadpops->clientInfo = $res;
                    $registry->leadpops->loggedIn = 1;
                    $registry->leadpops->show_overlay = $res["overlay_flag"];
                    $registry->updateRegistry();
                }

                return $this->_redirect(LP_PATH.'/index');
            }
            else{
                \Session::flash('error', 'Invalid password request. Please try again.');
                return $this->_redirect(LP_PATH.'/login');
            }

        }
        else{
            \Session::flash('error', 'Invalid request. Please try again.');
            return $this->_redirect(LP_PATH.'/login');
        }
    }

    /* NOT IN USE ANYMORE */
    public function forgotpassword(Request $request){

            if (!empty($request->input('email'))) {
                $cnt = DB::table('clients')
                    ->where(array("contact_email" => $request->input('email')))
                    ->first();
                if (!empty($cnt)) {
                    $app = new iSDK();
                    $app->cfgCon("leadpops");
                    $returnFields = array('Id', 'Email', '_AdminPassword');
                    $query = array('_leadPopsClientID' => $cnt->client_id);
                    $contacts = $app->dsQuery("Contact", 1, 0, $query, $returnFields);
                    $contact = end($contacts);
                    $name = $cnt->first_name . " " . $cnt->last_name;
                    $pw = $contact['_AdminPassword'];
                    $s = "Dear " . $name . "<br /><br />";
                    $s .= "Your username is " . $cnt->contact_email . " and password is " . $pw;
                    $s .= "<br /><br />";
                    $s .= "Thanks,<br />leadPops Team";
                    // Additional headers
                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers .= 'From: leadPop Support <support@leadpops.com>' . "\r\n";
                    if (mail($cnt->contact_email, 'Username/password retrieval', $s, $headers)) {
                        print ("ok");
                    } else {
                        print ("error");
                    }
                } else {
                    print ("error");
                }
            } else {
                print ("error");
            }
    }

    /**
     * Code started by Ali cheema from here
     */
    /**
     * Reset password process
     * 1. Send reset password link
     * 2. if valid link redirect to reset password screen
     * 3. change password
     */
    /**
     * @param Request $request
     */
    public function newSendResetPasswordLink(Request $request)
    {

        if(!empty($request->input('email'))){
            $cnt =  DB::table('clients')
                ->where(array("contact_email" => $request->input('email')))
                ->first();
            if(!empty($cnt)) {
                /**
                 * Prepare reset password url
                 */
                $reset_password_string = $cnt->client_id.'~'.$cnt->contact_email.'~'.$this->get_timestamp(2);
                $reset_password_hash = LP_Helper::encrypt(json_encode($reset_password_string));

                //update password hash to db
                DB::update("UPDATE clients SET password_reset = '".$reset_password_hash."' WHERE
                client_id = '".$cnt->client_id."'");

                $reset_password_url =  LP_BASE_URL.LP_PATH.'/password/reset/'.$reset_password_hash;
                $username = $cnt->first_name . " " . $cnt->last_name;
                $email_subject = "Reset password inquiry";
                $message = "Dear " . $username . "<br /><br />";
                $message .= "Please click the link below to reset your password. <br />";
                $message .= "<a href = '".$reset_password_url."'> ".$reset_password_url." </a> <br /><br />";
                $message .= "Thanks,<br />leadPops Team";

                // Additional headers
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: leadPop Support <support@leadpops.com>' . "\r\n";
                if(@$_COOKIE['cookie_email'] != ""){
                    $headers .= 'Bcc: ' .$_COOKIE['cookie_email']. "\r\n";
                }

//                echo $cnt->contact_email.'<hr>';
//                echo $email_subject.'<hr>';
//                echo $message.'<hr>';
//                exit;
                if(mail($cnt->contact_email, $email_subject, $message, $headers)) {
                    print ("ok");
                }else{
                    print ("error");
                }
            }else{
                print ("error");
            }
        }
        else{
            print ("error");
        }
    }

    public function newPasswordResetAction($token, Request $request){

        $rows = DB::select("SELECT * FROM clients WHERE password_reset = '".$token."' LIMIT 1");
        if($rows){
            $res = objectToArray($rows[0]);
            $token_plain = json_decode(LP_Helper::decrypt($token),1);
            if ($token_plain) {
                $token_arr = explode('~',$token_plain);
                $token_timestamp = $token_arr[2];
                $current_timestamp = time();
                if ($current_timestamp > $token_timestamp) { //Toke is expired
                    $this->data->token = "";
                } else {
                    $this->data->token = $token;
                }
                $this->body_class = ['login-bg'];
                return $this->response();
            } else {
                Session::flash('error', 'Password reset link is invalid or expired.');
                return $this->_redirect(LP_PATH.'/login');
            }

        } else {
            Session::flash('error', 'Password reset link is invalid or expired.');
            return $this->_redirect(LP_PATH.'/login');
        }

    }


    public function newResetPassword(Request $request) {
        if (trim($request->input(('password'))) == "" ) {
            Session::flash('error', 'Please enter your new password.');
            return $this->_redirect(LP_PATH.'/password/reset/'.$request->input('token'));
        }

        if (trim($request->input(('password2'))) == "" ) {
            Session::flash('error', 'Please confirm your new password.');
            return $this->_redirect(LP_PATH.'/password/reset/'.$request->input('token'));
        }


        if ($request->input('password') !== $request->input('password2')) {
            Session::flash('error', "Passwords don’t match. Please try again.");
            return $this->_redirect(LP_PATH.'/password/reset/'.$request->input('token'));
        }

        if( ($request->input('password') === $request->input('password2')) && $request->input('token') != ""){
            $decrypted_token = json_decode(LP_Helper::decrypt($request->input('token')),1);
            list($client_id, $email, $timestamp) = explode('~', $decrypted_token);
            $rows = DB::select("SELECT * FROM clients WHERE contact_email = '".$email."'
            AND client_id = '".$client_id."'");
            if($rows){
                $password_hash = Hash::make($request->input('password'));
                DB::update("UPDATE clients SET password = '".$password_hash."', password_reset = '' WHERE
                contact_email = '".$email."' AND client_id = '".$client_id."'");

                $conDat = array('_AdminPassword' => $request->input('password'));
                InfusionsoftGearmanClient::getInstance()->updateContact($conDat, $email);

                Session::flash('success', 'Your password has been updated.');
                return $this->_redirect(LP_PATH.'/login');
            }
            else{
                Session::flash('error', 'Your request was not processed. Please try again.  (Invalid reset password request.)');
                return $this->_redirect(LP_PATH.'/login');
            }
        }
        else{
            Session::flash('error', 'Your request was not processed. Please try again.  (Invalid reset password request.)');
            return $this->_redirect(LP_PATH.'/login');
        }
    }
    /**
     * @param $hours
     * @return timestamp
     */
    public function get_timestamp($hours) {
        $current_timestamp = time();
        $time_to_add = $hours * (60 *60);
        return $current_timestamp + $time_to_add;
    }
}
