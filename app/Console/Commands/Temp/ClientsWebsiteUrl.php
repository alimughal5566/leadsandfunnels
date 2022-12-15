<?php

namespace App\Console\Commands\Temp;

use App\Models\Clients;
use App\Repositories\CustomizeRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ClientsWebsiteUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deprecated:ClientsWebsiteUrl:process {action : sync / print}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    private $records_limit = 100;
    private $wpCoreClientsData = [];

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
        try {
            $action = $this->argument('action');
            if($action == "sync") {
                $this->setWPCoreData();
                $this->info("Updating lp_marketing_website into clients table.");

                $client_ids = array_keys($this->wpCoreClientsData);
                if(count($client_ids)) {
                    $clients = DB::table('clients')
                        ->select("client_id", "contact_email")
                        ->whereIn('client_id', $client_ids)
                        ->get();

                    foreach ($clients as $client) {
                        $website_url = $this->wpCoreClientsData[$client->client_id];
                        $this->comment("Client#" . $client->client_id . ", Website URL - " . $website_url);
                        DB::table('clients')
                            ->where("client_id", $client->client_id)
                            ->update([
                                "lp_marketing_website" => $website_url
                            ]);
                    }
                }
            } else if($action == "print") {
                $this->setWPCoreData();
                $this->info("These clients would be updated");
                foreach ($this->wpCoreClientsData as $clientId => $url) {
                    $this->comment("Client#" . $clientId . ", Website URL - " . $url);
                }
            } else {
                $this->error("Error: Wrong command action");
            }
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }

    /**
     * get WP core data
     */
    private function setWPCoreData(){
        $this->wpCoreClientsData = array_map('str_getcsv', file(__DIR__ . '/../input-data/wp-core.csv'));
        $this->wpCoreClientsData = collect($this->wpCoreClientsData);
        $this->wpCoreClientsData = $this->wpCoreClientsData->pluck(1, 0)->toArray();
   }

}
