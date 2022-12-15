<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\ChargeBeeHelpers;
use App\Models\ChargebeePlansAddons;

class ChargebeePlans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chargebee:get-all-plans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch all plans & addons from Chargebee and save/update into chargebee_plans_addons table';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public $chargeBeePlans = [];
    public $chargeBeeAddons = [];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $chargebeePlans = $this->getChargeBeePlans();

        $chargebeeAddons = $this->getChargeBeeAddons();

        $this->comment("\n Fetching data from endpoint");
        \Log::info("\n\n\n Fetching data from endpoint");
        // Plans Loop
        if ($this->chargeBeePlans && count($this->chargeBeePlans)) {
            //  dd($this->chargeBeePlans);
            foreach ($this->chargeBeePlans as $onePlan) {
                $insert = [
                    'plan_id' => $onePlan['id'],
                    'plan_name' => $onePlan['name'],
                    'period_unit' => $onePlan['period_unit'],
                    'plan_price' => $onePlan['price'],
                    'pricing_model' => $onePlan['pricing_model'],
                    'client_type' => @$onePlan['cf_client_type'],
                    'industry' => @$onePlan['cf_industry'],
                    'funnel_type' => @$onePlan['cf_funnel_type'],
                    'status' => @$onePlan['status'],
                    'client_plan_type' => @$onePlan['period_unit'],
                    'additional_fields' => json_encode($onePlan),
                    'plan_type' => 'plan',
                    'date_created' => '',
                    'date_updated' => $onePlan['updated_at'],
                ];
                $this->comment("\n Plan Data: " . json_encode($insert));
                // \Log::info("\n Plan Data: " . json_encode($insert));
                ChargebeePlansAddons::updateOrCreate(['plan_id' => $onePlan['id']], $insert);
            }
        }

        // Addons Loop
        if ($this->chargeBeeAddons && count($this->chargeBeeAddons)) {
            //  dd($this->chargeBeeAddons);
            foreach ($this->chargeBeeAddons as $oneAddon) {
                $insert = [
                    'plan_id' => $oneAddon['id'],
                    'plan_name' => $oneAddon['name'],
                    'period_unit' => $oneAddon['period_unit'],
                    'plan_price' => $oneAddon['price'],
                    'pricing_model' => @$oneAddon['pricing_model'],
                    'status' => @$onePlan['status'],
                    'additional_fields' => json_encode($oneAddon),

                    'plan_type' => 'addon',
                    'date_created' => '',
                    'date_updated' => $oneAddon['updated_at'],
                ];
                $this->comment("\n Addon Data: " . json_encode($insert));
                ChargebeePlansAddons::updateOrCreate(['plan_id' => $oneAddon['id']], $insert);
            }

        }

    }

    function getChargeBeePlans()
    {
        $getPlans = function ($params) use (&$getPlans) {
            $plans = ChargeBeeHelpers::getChargebeePlans($params);
            if ($plans && $plans['status'] && count($plans['result']['plan'])) {
                $this->chargeBeePlans = array_merge($this->chargeBeePlans, $plans['result']['plan']);
            }
            if ($plans && $plans['status'] && $plans['result']['offset']) {
                $params["offset"] = $plans['result']['offset'];
                return $getPlans($params);
            }
            return $this->chargeBeePlans;
        };
        $params = ['limit' => 100];
        return $getPlans($params);
    }



    function getChargeBeeAddons()
    {
        $getPlans = function ($params) use (&$getPlans) {
            $plans = ChargeBeeHelpers::getChargebeeAddons($params);
            if ($plans && $plans['status'] && count($plans['result']['addon'])) {
                $this->chargeBeeAddons = array_merge($this->chargeBeeAddons, $plans['result']['addon']);
            }
            if ($plans && $plans['status'] && $plans['result']['offset']) {
                $params["offset"] = $plans['result']['offset'];
                return $getPlans($params);
            }
            return $this->chargeBeeAddons;
        };


        $params = ['limit' => 100];
        return $getPlans($params);
    }
}
