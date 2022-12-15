<?php

namespace App\Console\Commands;

use App\Client;
use Illuminate\Console\Command;
use App\Helpers\ChargeBeeHelpers;
use App\Models\ChargebeePlansAddons;

class ChargebeeClientPlanInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chargebee:client-plan-info {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch information for client\'s Plan ID & Subscription ID and update into clients table';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    private $plans = [];

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
        $email = $this->argument('email');
        $this->plans = array_column(ChargebeePlansAddons::where(array('is_used' => 1))->get()->toArray(), 'plan_id');
        $client = Client::where('contact_email', $email)->first();
        if($client) {
            $clientInfo = $client->toArray();

            $customer_id = $this->getChargebeeClientInfo($email);
            if ($customer_id) {
                $subscriptionInfo = $this->getSubscriptionsInfo($customer_id, $clientInfo['client_plan_id']);

                if ($subscriptionInfo) {
                    Client::where('contact_email', $email)->update([
                        'client_plan_id' => $subscriptionInfo['plan_id'],
                        'client_plan_subscription_id' => $subscriptionInfo['id'],
                        'chargebee_customer_id' => $customer_id
                    ]);

                    $this->comment('Subscription Updated for Client ID # ' . $clientInfo['client_id']);
                } else {
                    Client::where('contact_email', $email)->update([
                        'chargebee_customer_id' => $customer_id
                    ]);

                    $this->error('No Subscription found on chargebee for plan <' . $clientInfo['client_plan_id'] . '> for client <' . $customer_id . '>');
                }
            } else {
                $this->error('No Customer found on chargebee with email '.$email);
            }
        }
        else{
            $this->error($email . ' not found in database');
        }
    }

    private function getChargebeeClientInfo($email)
    {
        $id = "";
        $info = ChargeBeeHelpers::getChargebeeCustomer($email);
        if($info['status'] == true){
            $id = $info['result'][0]['customer']['id'];
        }
        return $id;
    }

    private function getSubscriptionsInfo($customer_id, $plan_id='')
    {
        $info = array();
        if($plan_id != ""){
            $subscriptions = ChargeBeeHelpers::getChargebeeCustomerSubscription($customer_id, $plan_id);
        } else {
             $subscriptions = ChargeBeeHelpers::getChargebeeCustomerAllSubscription($customer_id);
        }

        if($subscriptions['status'] == true){
            foreach($subscriptions['result'] as $i=>$subscription){
                if(in_array($subscription['subscription']['plan_id'], $this->plans)){
                    $info = ['id'=>$subscription['subscription']['id'], 'plan_id'=>$subscription['subscription']['plan_id']];
                }
            }
        }
        return $info;
    }
}
