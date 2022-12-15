<?php

namespace App\Helpers;

use App\Models\Clients;
use App\Helpers\HooksClient;

/**
 * A collection of helper functions to get data related to ChargeBee
 */
class ChargeBeeHelpers {

    private static $client;

    /**
     * Get prices for current plan and upgrade plan
     *
     * @return array
     */
    public static function getClientPlansPricesData(){

        // Default map for plan and plan prices
        $defaultPlanMap = self::getDefaultPlanMap();

        // this data would be shown if plan is not defined for client
        $defaults = $defaultPlanMap['prices'];

        // If client has already upgraded, we don't need to show plan prices
        // anywhere on admin according to current requirement, so we return early
        // and return defaults instead of empty array
        if(\LP_Helper::getInstance()->getCloneFlag()  == 'y'){
            return $defaults;
        }

        $client = self::getClientModel();

        // Set default plan Id if not defined in DB
        if(empty($client->client_plan_id)){
            $currentPlanId = $defaultPlanMap['plan'];
        } else {
            $currentPlanId = $client->client_plan_id;
        }

        // Get current plan info
        $currentPlanInfo = self::getChargebeePlanById($currentPlanId);
        // If no plan exists for current plan Id return default
        if(empty($currentPlanInfo['result']['plan'])){
            return $defaults;
        }

        $currentPlanInfo = $currentPlanInfo['result']['plan'];

        $planMap = config('chargebee.plan_upgrade_map');

        // Pro plan related to curent marketer plan
        $upgradeMonthlyPlanId = $planMap[$currentPlanInfo['cf_client_type']][$currentPlanId]['monthly'] ?? null;
        $upgradeYearlyPlanId = $planMap[$currentPlanInfo['cf_client_type']][$currentPlanId]['yearly'] ?? null;

        // Upgrade plan map is not defined for current marketer plan, so we return defaults
        if(!$upgradeMonthlyPlanId || !$upgradeYearlyPlanId){
            return $defaults;
        }

        // Get plan info for pro plan
        $upgradeMonthlyPlanInfo = self::getChargebeePlanById($upgradeMonthlyPlanId);
        // In case of error return defaults
        if(empty($upgradeMonthlyPlanInfo['result']['plan'])){
            return $defaults;
        }

        $upgradeMonthlyPlanInfo = $upgradeMonthlyPlanInfo['result']['plan'];

        // Get plan info for yearly pro plan
        $upgradeYearlyPlanInfo = self::getChargebeePlanById($upgradeYearlyPlanId);
        // In case of error return defaults
        if(empty($upgradeYearlyPlanInfo['result']['plan'])){
            return $defaults;
        }

        $upgradeYearlyPlanInfo = $upgradeYearlyPlanInfo['result']['plan'];

        return [
            // Sending price value as cents instead of float to avoid losing precision
            'marketer' => $currentPlanInfo['price'],
            'pro' => $upgradeMonthlyPlanInfo['price'],
            'pro_yearly' => $upgradeYearlyPlanInfo['price']
        ];
    }

    /**
     * Returns default plan map for current client type
     *
     * @return array default plan array
     */
    public static function getDefaultPlanMap(Clients $client = null) : array {
        if(!$client){
            $client = self::getClientModel();
        }

        $verticalMap = self::getVerticalIdToNameMap();
        $verticalName = $verticalMap[$client->client_type];

        $clientType = 'Default';

        // Client's table have multiple columns for detecting client type
        // we can only reliabely detect client type if only exactly one of the
        // following flag is active, so we are assuming that this is the case
        // otherwise we are in an unreliable state
        if($client->is_mm){
            $clientType = 'Movement';
        } else if ($client->is_fairway){
            $clientType = 'Fairway';
        } else if ($client->is_aime){
            $clientType = 'AIME';
        } else if ($client->is_thrive){
            $clientType = 'Thrive';
        } else if ($client->is_c2){
            $clientType = 'C2';
        }
        // We don't have detection for Baller or Bab client

        $defaultPlanMap = config('chargebee.default_plan_map');

        return $defaultPlanMap[$verticalName][$clientType];
    }

    /**
     * Returns vertical Ids to vertical name map
     *
     * @return array map array
     */
    public static function getVerticalIdToNameMap(){
        return [
            '1' => 'insurance',
            '3' => 'mortgage',
            '5' => 'real_estate'
        ];
    }

    /**
     * Returns the default fallback plan price for current client type
     *
     * @return void
     */
    public static function getDefaultPlanPrices(Clients $client = null) : array {
        if(!$client){
            $client = self::getClientModel();
        }

        $defaultPlanMap = self::getDefaultPlanMap($client);
        return $defaultPlanMap['prices'];
    }

    /**
     * Returns default plan Id for client type
     *
     * @param Clients $client
     * @return string plan Id
     */
    public static function getDefaultPlanId(Clients $client = null) : string {
        if(!$client){
            $client = self::getClientModel();
        }

        $defaultPlanMap = self::getDefaultPlanMap();
        return $defaultPlanMap['plan'];
    }


    /**
     * Returns client Id for logged in user
     *
     * @return void
     */
    public static function getClientId(){
        // It is assumed the this session would never be null
        // because lot of internal functionality of LP_Helper
        // also depends on this session
        $session = \LP_Helper::getInstance()->getSession();

        // If session is not defined, it should fail and it should fail early
        if(empty($session->client_id)){
            throw new \Exception('Undefined client ID in lp helper\'s session');
        }
        return $session->client_id;
    }

    /**
     * Returns client model for current logged in client
     *
     * @return void
     */
    public static function getClientModel() : Clients {
        if(self::$client){
            return self::$client;
        }

        $client = Clients::where('client_id', self::getClientId())->first();

        // If data does not exist for current client in client's table
        // then we are in an unexcpected state, we should fail early
        if(!$client){
            throw new \Exception('Client data not found for current client ID');
        }

        self::$client = $client;
        return $client;
    }


    /**
     * Returns all created Chargebee plans
     *
     * @return array api response data
     */
    public static function getChargebeePlans($params = []) : array {
        return HooksClient::send('/api/chargebee/plan/get-plans',$params);
    }


    /**
     * Returns plan for given Id
     *
     * @param string $planId
     * @return array api response data
     */
    public static function getChargebeePlanById($planId) : array {
        return HooksClient::send('/api/chargebee/plan/get-plan/' . $planId);
    }


    /**
     * Returns all created Chargebee Addons
     *
     * @return array api response data
     */
    public static function getChargebeeAddons($params = []) : array {
        return HooksClient::send('/api/chargebee/addons/get-addons', $params);
    }

    /**
     * Returns customer data for given email
     *
     * @param string $email
     * @return array api response data
     */
    public static function getChargebeeCustomer($email) : array {
        return HooksClient::send('/api/chargebee/customer/get-customers', [
            'email[is]' => $email
        ]);
    }

    /**
     * Returns a subscription for given customer and plan ID
     *
     * @param string $customerId
     * @param string $currentPlanId
     * @return array api response data
     */
    public static function getChargebeeCustomerSubscription($customerId, $currentPlanId) : array {
        return HooksClient::send('/api/chargebee/subscription/get-subscriptions', [
            "limit" => 1,
            "customerId[is]" => $customerId,
            "planId[is]" => $currentPlanId
        ]);
    }

    /**
     * Returns a subscription for given customer and plan ID
     *
     * @param string $customerId
     * @param string $currentPlanId
     * @return array api response data
     */
    public static function getChargebeeCustomerAllSubscription($customerId) : array {
        return HooksClient::send('/api/chargebee/subscription/get-subscriptions', [
            "limit" => 15,
            "customerId[is]" => $customerId
        ]);
    }

    /**
     * Updates customer's plan to new plan for given subscription Id
     *
     * @param string $subscrptionId
     * @param string $newPlanId
     * @return array api response data
     */
    public static function updateChargebeeCustomerPlan($subscrptionId, $newPlanId) : array {
        return HooksClient::send('/api/chargebee/subscription/update-subscription/'. $subscrptionId,[
            'planId' => $newPlanId,
            'autoCollection' => 'on'
        ]);
    }

    /**
     * Fetches all subscription for a customer having plans in given array
     *
     * @param string $customerId
     * @param array $planIds
     * @return array
     */
    public static function getCustomerSubscriptionsHavingPlans(string $customerId, array $planIds) : array {
        return HooksClient::send('/api/chargebee/subscription/get-subscriptions', [
            "customerId[is]" => $customerId,
            "planId[in]" => $planIds
        ]);
    }

    /**
     * Updates customer's plan to new plan for given subscription Id
     *
     * @param string $subscrptionId
     * @param string $addonId
     * @return array api response data
     */
    public static function addSubcriptionAddon($subscrptionId, $addonId) : array {
        return HooksClient::send('/api/chargebee/subscription/addon-subscription',[
            'subscription_id' => $subscrptionId,
            'addon_id' => $addonId
        ]);
    }

    /**
     * Updates customer's plan to new plan for given subscription Id
     *
     * @param string $customerId
     * @param string $planId
     * @return array api response data
     */
    public static function addNewPlanSubscription($customerId, $planId) : array {
        return HooksClient::send('/api/chargebee/subscription/create-with-existed-customer/'.$customerId,[
            'planId' => $planId
        ]);
    }
}
