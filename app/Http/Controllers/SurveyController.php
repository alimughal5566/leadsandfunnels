<?php
/**
 * Created by MZAC90.
 * User: mzac90
 * Date: 1/16/20
 * Time: 10:17 PM
 */

namespace App\Http\Controllers;
use App\Constants\Layout_Partials;
use App\Repositories\LpAdminRepository;
use App\Services\DataRegistry;
use App\Services\gm_process\InfusionsoftGearmanClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use LP_Helper;
use Session;
use iSDK;
class SurveyController extends BaseController
{
    public function __construct(LpAdminRepository $lpAdmin){
        $this->middleware(function($request, $next) use ($lpAdmin) {

            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(Session::get('leadpops'));
            $this->init($lpAdmin);
            if($request->ajax()) $this->check_ajax_session(); else $this->check_session();
            return $next($request);
        });
    }
//Infusionsoft Integration

    public function index(Request $request){

        header("Access-Control-Allow-Origin: https://mortgage.leadpops.com");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Origin");
        header('P3P: CP="CAO PSA OUR"'); // Makes IE to support cookies*/

        if(!empty($request)) {
            $sd = $request->input('value');

            // This code is not required anymore
            /*
            if(@$_COOKIE['surveyv2'] == 1){
                $conDat = array(
                    'Email' => $this->registry->leadpops->clientInfo['contact_email'],
                    '_WhatKindOfDigitalMarketingAreYouDoingSEOBlogsFB' => $sd['online_marketing'],
                    '_WhatKindOfTraditionalMarketingAreYouDoingMailRadio' => $sd['offline_marketing'],
                    '_MonthlyMarketingBudgetSurvey' => $sd['monthly_marketing_budget'],
                    '_WhatCRMAreYouUsing' => $sd['lead_management_system'],
                    '_Website13' => $sd['website_url'],
                    '_LandingPage' => $sd['landing_page_url'],
                    '_OnAverageHowManyLoansHaveYouClosedPerMonth' => $sd['average_loans_closed_monthly'],
                    '_NowHowManyLoansWouldYouLIKEToCloseEachMonth' => $sd['goal_loans_closed_monthly'],
                );
            }else{
                $conDat = array(
                    'Email' => $this->registry->leadpops->clientInfo['contact_email'],
                    '_WhatKindOfDigitalMarketingAreYouDoingSEOBlogsFB' => $sd['online_marketing'],
                    '_WhatKindOfTraditionalMarketingAreYouDoingMailRadio' => $sd['offline_marketing'],
                    '_MonthlyMarketingBudgetSurvey' => $sd['monthly_marketing_budget'],
                    '_WhatCRMAreYouUsing' => $sd['lead_management_system'],
                    '_Website13' => $sd['website_url'],
                    '_LandingPage' => $sd['landing_page_url'],
                    '_OnAverageHowManyLoansHaveYouClosedPerMonth' => $sd['average_loans_closed_monthly'],
                    '_NowHowManyLoansWouldYouLIKEToCloseEachMonth' => $sd['goal_loans_closed_monthly'],
                );
            }
            */

            if(getenv('APP_THEME') == "theme_admin3") {
                $conDat = $sd;
                $conDat['Email'] = $this->registry->leadpops->clientInfo['contact_email'];

                //The datepicker field wants a Unix timestamp with microseconds, but it must be the exact value of midnight in UTC
                $target_date = date( 'Y-m-d', strtotime( 'now' ) );
                $timezone_object = new \DateTimeZone( 'UTC' );
                $date_object = new \DateTime( $target_date, $timezone_object );
                $conDat['customer_survey_completed'] = $date_object->format( 'U' ) * 1000;
            } else {
                $conDat = array(
                    'Email' => $this->registry->leadpops->clientInfo['contact_email'],
                    'what_kind_of_digital_marketing_are_you_doing_' => $sd['online_marketing'],
                    'what_kind_of_offline_marketing_are_you_doing_' => $sd['offline_marketing'],
                    'what_s_your_average_monthly_marketing_budget_' => $sd['monthly_marketing_budget'],
                    'what_s_your_lead_management_system_or_crm_' => $sd['lead_management_system'],
                    'website' => $sd['website_url'],
                    'landing_page' => $sd['landing_page_url'],
                    'on_average_how_many_loans_do_you_close_each_month_' => $sd['average_loans_closed_monthly'],
                    'how_many_loans_would_you_like_to_close_each_month_' => $sd['goal_loans_closed_monthly'],
                );
            }

            if(env('SUBMIT_SURVEY_HUBSPOT') == "true") {
                $ifs_data = array();
                $ifs_data['Contact._MyLeadsLastLogin'] = date('m/d/Y @ g:ia');

                //Block IFS communication for @test-leadpops.com
                if (strpos($conDat['Email'], "@test-leadpops.com") === false) {
                    $email = $conDat['Email'];
                    unset($conDat['Email']);
                    InfusionsoftGearmanClient::getInstance()->updateContact($conDat, $email);
                } else {
                    Log::debug("[Survey Form] Submission blocked for @test-leadpops.com ==> ".$conDat['Email']);
                }
            }
            else{
                Log::debug("[Survey Form] ENV blocked submission");
            }

            $table_data = array('survey_flag' => 0);
            $this->db->update('clients', $table_data, 'client_id = '.$this->client_id);
            $this->registry->leadpops->clientInfo['survey_flag'] = false;
            $this->registry->updateRegistry();
            echo json_encode(['status'=>'success']);
        }else{
            echo json_encode(['status'=>'error', 'Unable to save Survey.']);
        }
    }

    public function setsurveysession(){
        $this->registry->leadpops->skip_survey = 1;
        $this->registry->updateRegistry();
        echo  $this->registry->leadpops->skip_survey;
    }
}

