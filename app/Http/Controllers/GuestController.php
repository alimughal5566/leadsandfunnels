<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Services\gm_process\InfusionsoftGearmanClient;
use \DB;
use \LP_Helper;

class GuestController extends BaseController
{
    public function activateClient($hash, Request $request) {

        if(Session::get('clientDataExtractedFromHash') == null){
            return $this->_redirect(route('launcher', [ 'hash' => $hash]));
        }

        $isSetPassword = Session::get('launch_status');
        if ($isSetPassword == 1 || $isSetPassword == 2)
            return $this->_redirect(route('launcher', ['hash' => $hash]));

        $clientDataExtractedFromHash = (array) Session::get('clientDataExtractedFromHash');

        if(strtolower($request->method()) == 'get'){
            return view('guest.activateClient');
        }

        try {
            $rules = [
                'id' => 'required',
                'email' => 'required|email'
            ];

            if(is_array($clientDataExtractedFromHash)) {
                $request->merge($clientDataExtractedFromHash);
                /*  'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                 */
                if(isset($request->password)) {
                    $rules = array_merge($rules, [
                        'password' =>  'min:5',
                        'confirm_password' => "required_with:password|same:password"
                    ]);
                }
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                if(isset($request->password)) {
                    return Redirect::back()->withErrors($validator);
                }
                return redirect(LP_PATH . '/login');
            }

            $changePassword = DB::table("clients")
                ->where("client_id", $request->id)
               // ->where("contact_email", $request->email)
                ->value("launch_status");

            if ($changePassword == 0) {
                if(isset($request->password)) {
                    $updatedRow = DB::table("clients")
                        ->where("client_id", $request->id)
                       // ->where("contact_email", $request->email)
                        ->update([
                            "launch_status" => config('lp.launch_status.password_only'),
                            "password" => Hash::make($request->password)
                        ]);

                    if ($updatedRow) {

                        $hubspot_data = array();
                        $hubspot_data['funnels_password'] = $request->password;
                        InfusionsoftGearmanClient::getInstance()->updateContact($hubspot_data, $request->email);

                        Session::put('launch_status', 1);
                        Session::flash('success', 'Your password has been updated.');
                        return $this->_redirect(route('launcher', [ 'hash' => $hash]));

                    }
                }

                return view('guest.activateClient');
            }
        } catch (\Exception $e) {
            return redirect(LP_PATH . '/login');
        }
        return redirect(LP_PATH.'/login');
    }
}
