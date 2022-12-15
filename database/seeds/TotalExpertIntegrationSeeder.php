<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class TotalExpertIntegrationSeeder
 *
 * Command to execute seeder - php artisan db:seed --class=TotalExpertIntegrationSeeder
 */

class TotalExpertIntegrationSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    private $integrationName = null;

    public function run()
    {

        $this->integrationName = config('integrations.iapp.TOTAL_EXPERT')['sysname'];

        if(!$this->integrationName || empty($this->integrationName)) {
            echo"#################################################################### \n";
            echo"Integration name not found, Name: " . $this->integrationName. " \n";
            echo"#################################################################### \n";
            return false;
        }

//        Global check for entries in client_integrations for Total Expert
//        $count = DB::table('client_integrations')
//            ->where("name", $this->integrationName)
//            ->count();
//
//        if ($count) {
//            echo"####################################################################### \n";
//            echo"Found records against Total Expert, looking like seeder already executed \n";
//            echo"####################################################################### \n";
//            return false;
//        }

        $clients = DB::table('clients')
            ->select("clients.client_id")
            ->join('totalexpert', function ($join) {
                $join->on('clients.client_id', '=', 'totalexpert.client_id')
                    ->where('totalexpert.active', '=', 1);
            })
            ->where("clients.is_pause", "!=", 1)
//            ->where("clients.client_id", 3111)
            ->get();

        foreach ($clients as $client) {
            // Check if client already have entries than won't add entries for client.
            $count = DB::table('client_integrations')
                ->where("name", $this->integrationName)
                ->where("client_id", $client->client_id)
                ->count();

            if ($count) {
                echo"####################################################################### \n";
                echo"Already found Total Expert integrations against this client, ID#" . $client->client_id . " \n";
                echo"####################################################################### \n\n";
                continue;
            }

            $clientLeadpops = DB::table('clients_domains AS domain')
                ->select("domain.domain_name", "cl.leadpop_id",
                    "cl.leadpop_version_id", "cl.leadpop_version_seq",
                    "domain.leadpop_vertical_id", "domain.leadpop_vertical_sub_id",
                    "domain.leadpop_template_id"
                )
                ->join('clients_leadpops AS cl', function ($join) {
                    $join->on('cl.leadpop_id', '=', DB::raw('domain.leadpop_id'))
                        ->where('cl.client_id', DB::raw('domain.client_id'))
                        ->where('cl.leadpop_version_id', DB::raw('domain.leadpop_version_id'))
                        ->where('cl.leadpop_version_seq', DB::raw('domain.leadpop_version_seq'));
                })
                ->where('cl.leadpop_active', "!=", 3)
                ->where('domain.client_id', $client->client_id)
                ->where('domain.domain_name', 'NOT LIKE', "%temporary%")
                ->groupBy("domain.domain_name")
                ->get();

            $clientLeadpops1 = DB::table('clients_subdomains AS cs')
                ->select(DB::raw("concat(cs.subdomain_name, '.', cs.top_level_domain) as domain_name"),
                    "cl.leadpop_id", "cl.leadpop_version_id", "cl.leadpop_version_seq",
                    "cs.leadpop_vertical_id", "cs.leadpop_vertical_sub_id",
                    "cs.leadpop_template_id"
                )
                ->join('clients_leadpops AS cl', function ($join) {
                    $join->on('cl.leadpop_id', '=', DB::raw('cs.leadpop_id'))
                        ->where('cl.client_id', DB::raw('cs.client_id'))
                        ->where('cl.leadpop_version_id', DB::raw('cs.leadpop_version_id'))
                        ->where('cl.leadpop_version_seq', DB::raw('cs.leadpop_version_seq'));
                })
                ->where('cl.leadpop_active', "!=", 3)
                ->where('cs.client_id', $client->client_id)
                ->groupBy("domain_name")
                ->get();

            $clientLeadpops = $clientLeadpops->merge($clientLeadpops1);

//                dd(DB::getQueryLog(), count($clientLeadpops), count($clientLeadpops1));

            if(count($clientLeadpops)) {
                echo"Adding Total Expert integrations against this client, ID#" . $client->client_id . " \n";

                //Inserting integrations
                $this->insertClientIntegrations($client->client_id, $clientLeadpops);
            }
        }
    }


    private function insertClientIntegrations($client_id, $clientLeadpops)
    {
        $clientIntegrations = [];

        foreach ($clientLeadpops as $clientLeadpop) {
            $clientIntegrations[] = [
                'client_id' => $client_id,
                'name' => $this->integrationName,
                'url' => $clientLeadpop->domain_name,
                'leadpop_id' => $clientLeadpop->leadpop_id,
                'leadpop_vertical_id' => $clientLeadpop->leadpop_vertical_id,
                'leadpop_vertical_sub_id' => $clientLeadpop->leadpop_vertical_sub_id,
                'leadpop_template_id' => $clientLeadpop->leadpop_template_id,
                'leadpop_version_id' => $clientLeadpop->leadpop_version_id,
                'leadpop_version_seq' => $clientLeadpop->leadpop_version_seq,
                "active" => "y"
            ];
        }

//        DB::enableQueryLog();
        DB::table('client_integrations')->insert($clientIntegrations);
//        dd("Insert Query -- ", DB::getQueryLog());
    }
}
