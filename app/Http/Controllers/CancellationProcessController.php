<?php
/**
 * @author mzac90
 * Date 21/07/2020
 */

namespace App\Http\Controllers;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
use App\Services\gm_process\MyLeadsEvents;
use Illuminate\Http\Request;

class CancellationProcessController extends BaseController
{

    public function __construct(LpAdminRepository $lpAdmin){
        $this->middleware(function($request, $next) use ($lpAdmin) {
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(\Session::get('leadpops'));
            $this->init($lpAdmin);
            if($request->ajax()) $this->check_ajax_session(); else $this->check_session(1);
            return $next($request);
        });
    }
    //client account pause
    /**
     *If  is_pause = 1 so the client cannot login and no email or SMS notifications will be sent (Lead Alerts)
     * If  is_pause = 0 so the client can login and email or SMS notifications will be sent (Lead Alerts)
     */
    public function accountPause(Request $request){
         $is_pause = $request->input('is_pause');
         $client_id = $request->input('client_id');
        if(isset($is_pause) and !empty($client_id)) {
            $s = "update clients set is_pause = " .$is_pause."
             where client_id = " . $client_id;

            $this->db->query($s);
            if(env('GEARMAN_ENABLE') == "1") {
                /** *If  is_pause = 1 so the client cannot login and could not access the funnel
                 * If  is_pause = 0 so the client can login and access the funnel
                 */
                    if($is_pause == 1){
                        $status = 0;
                    }else{
                        $status  = 1;
                    }
                    $arr = array('client_id' => $client_id,'status' => $status);
                    MyLeadsEvents::getInstance()->websiteClientAccountInactive($arr);
            }
            echo json_encode(array('message' => 'Your request has been updated.'));
        }else{
            echo json_encode(array('message' => 'Client ID/ Is Pause Parameter is missing.'));
        }

    }

    //account cancellation
    public function accountCancellation(Request $request){
        $client_id = $request->input('client_id');
        if(isset($client_id) and  !empty($client_id)) {
            $s = "update clients set cancellation_status = '0' , cancellation_date = NOW()
            where ";
            $s .= "client_id = " . $client_id;
            $this->db->query($s);
            if(env('GEARMAN_ENABLE') == "1") {
                $arr = array('client_id' => $client_id,'status' => 0);
                MyLeadsEvents::getInstance()->websiteClientAccountInactive($arr);
            }
            echo json_encode(array('message' => 'Your request has been updated.'));
        }else{
            echo json_encode(array('message' => 'Client ID Parameter is missing.'));
        }

    }

    //remove account cancellation
    public function removeAccountCancellation(Request $request){
        $client_id = $request->input('client_id');
        if(isset($client_id) and  !empty($client_id)) {
            $s = "update clients set cancellation_status = '1' , cancellation_date = NULL
            where ";
            $s .= "client_id = " . $client_id;
            $this->db->query($s);
            if(env('GEARMAN_ENABLE') == "1") {
                $arr = array('client_id' => $client_id,'status' => 1);
                MyLeadsEvents::getInstance()->websiteClientAccountInactive($arr);
            }
            echo json_encode(array('message' => 'Your request has been updated.'));
        }else{
            echo json_encode(array('message' => 'Client ID Parameter is missing.'));
        }

    }
}
