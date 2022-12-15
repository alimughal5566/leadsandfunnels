<?php

namespace App\Http\Controllers;

use App\Repositories\CustomizeRepository;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
use Illuminate\Http\Request;
use LP_Helper;

class IntegrationController extends BaseController
{

    protected $session;
    private $Default_Model_Customize;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LpAdminRepository $lpAdmin, CustomizeRepository $customtizeRepo){
        $this->middleware(function($request, $next) use ($lpAdmin,$customtizeRepo) {
            $this->Default_Model_Customize = $customtizeRepo;
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(\Session::get('leadpops'));
            $this->init($lpAdmin);
            if($request->ajax()) $this->check_ajax_session(); else $this->check_session(1);
            $this->session=LP_Helper::getInstance()->getSession();
            return $next($request);
        });
    }

    public function update($key, Request $request)
    {

        if(!in_array($key, [config('integrations.iapp.TOTAL_EXPERT')['sysname'], config('integrations.iapp.HOMEBOT')['sysname']])) {
            return $this->errorResponse();
        }

        if( $this->registry->leadpops->client_id) {
            LP_Helper::getInstance()->getCurrentHashData($request->input('current_hash'));
            if (LP_Helper::getInstance()->getCurrentHash()) {
                $integration = null;
                if($key == config('integrations.iapp.TOTAL_EXPERT')['sysname']) {
                    $integration = LP_Helper::getInstance()->getTotalExpertInfo();
                    $integration = $integration[0];
                } elseif($key == config('integrations.iapp.HOMEBOT')['sysname']) {
                    $integration = LP_Helper::getInstance()->getHomebotInfo();
                    $integration = $integration[0];
                }
                if(!$integration) {
                    $this->errorResponse();
                }

                $hash_data = LP_Helper::getInstance()->getFunnelData();
                \DB::enableQueryLog();
                $integration = config('integrations.iapp.HOMEBOT')['name'];
                if($key == config('integrations.iapp.TOTAL_EXPERT')['sysname']) {
                    $integration = config('integrations.iapp.TOTAL_EXPERT')['name'];
                }

                if(in_array($request->input('update_type'), ['account', 'both'])) {
                    if($key == config('integrations.iapp.TOTAL_EXPERT')['sysname']) {
                        $this->Default_Model_Customize->updateTotalExpert($this->registry->leadpops->client_id, $request->input('active_on_account'));
                    } elseif($key == config('integrations.iapp.HOMEBOT')['sysname']) {
                        $this->Default_Model_Customize->updateHomebotStatus($this->registry->leadpops->client_id, $request->input('active_on_account'));
                    }

                    //Updating client integrations status
                    $this->Default_Model_Customize->updateOrInsertClientIntegrations($key, $this->registry->leadpops->client_id, ($request->input('active_on_account') == "active" ? 'y' : 'n'));
                }
                //Funnel specific action
                else if ($request->input('update_type') == 'funnel') {
                    //Updating client integration
                    $this->Default_Model_Customize->updateOrInsertClientIntegration($key, $hash_data, ($request->input('active_on_funnel') == "active" ? 'y' : 'n'));
                }
            }

            return $this->successResponse($integration . " changes has been saved.", [ "active"=>($request->input('active_on_account') == "active")]);
        }

        return $this->errorResponse();
    }
}
