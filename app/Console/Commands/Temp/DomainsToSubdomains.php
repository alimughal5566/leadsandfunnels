<?php

namespace App\Console\Commands\Temp;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * To combine clients_domains and Clients_subdomains records
 * Adding clients somains entries from domain to subdomains
 * Class DomainsToSubdomains
 * @package App\Console\Commands\Temp
 */
class DomainsToSubdomains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deprecated:db-optimization:merge-domain-subdomain';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "[One Time Command] This command will migrate data from domains table to subdomains + it will update subdomains row with domain_id";

    /**
     * Create a new command instance.
     *
     * @return void
     */

    private $domains_table = "clients_domains";
    private $subdomains_table = "clients_subdomains";
    private $subdomain_type = 1;
    private $domain_type = 2;
    private $executeForAllClients = false;

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
        /**
         *  1) Move all data from domains to Sub-domains table
         *          Note: Akram's logic has BUG it only process those specific clients which have entries in domains table
         *                  it was not updating subdomains which don't have top level domains
         *
         *  2) Update Subdomains table (Columns: clients_domain_id, domain_id) for client_type_id=1
         */
        try {
            $client_id = $this->ask("Client ID (optional)");

            //DB::enableQueryLog();
            $this->updateTopLevelDomains($client_id);
            $this->updateSubDomains($client_id);
            //dd(DB::getQueryLog());

        } catch (\Exception $e) {
            $this->error("Error:" . $e->getMessage());
        }
    }

    private function updateTopLevelDomains($client_id){
        if($client_id == "" || $client_id == null){
            $this->comment("== == == == == == == == == == == ==\n Domains -to- Subdomains (All Clients)\n== == == == == == == == == == == ==");

            $domains = DB::table($this->domains_table)
                ->select("client_id", DB::raw("count(*) as funnels"))
                ->groupBy("client_id")
                ->get();

            $domains = $domains->mapWithKeys(function ($item) {
                return [$item->client_id => $item->funnels];
            })->toArray();
        }
        else {
            $this->comment("== == == == == == == == == == == ==\n Domains -to- Subdomains ({$client_id})\n== == == == == == == == == == == ==");

            $query = DB::table($this->domains_table)->select("client_id", DB::raw("count(*) as funnels"));

            if(strstr($client_id, ",") !== false) {
                $client_ids = explode(",", $client_id);
                $query->whereIn('client_id', $client_ids);
            }
            else {
                $query->where('client_id', $client_id);
            }
            $domains = $query->groupBy("client_id")->get();

            $domains = $domains->mapWithKeys(function ($item) {
                return [$item->client_id => $item->funnels];
            })->toArray();
        }

        if($domains) {
            $this->processClientsDomains($domains);
        } else {
            $this->comment("No top level domain found to move into subdomains table.");
        }
    }


    /**
     * Check subdomains table for domains entries against every client, add entries if not found
     * @param $domains
     */
    private function processClientsDomains($domains){
        $index = 1;
        $domainEntries = [];
        $totalClientsCount = count($domains);
        $entriesPerQuery = 100;

        foreach ($domains as $client_id=>$domainCounts) {
            $clientSubdomainsCount = DB::table($this->subdomains_table)
                ->where('client_id', $client_id)
                ->where('leadpop_type_id', $this->domain_type)
                ->count();

            // domain only inserted when subdomains table don't have domain entries
            if($clientSubdomainsCount == 0) {

                $clientDomains = DB::table($this->domains_table)->select("*")->where('client_id', $client_id)->get();

                if ($clientDomains) {
                    foreach ($clientDomains as $clientDomain) {

                        if($clientDomain->domain_name == "temporary") continue;

                        $domainEntries[] = [
                            "client_id" => $clientDomain->client_id,
                            "leadpop_vertical_id" => $clientDomain->leadpop_vertical_id,
                            "leadpop_vertical_sub_id" => $clientDomain->leadpop_vertical_sub_id,
                            "leadpop_type_id" => $clientDomain->leadpop_type_id,
                            "leadpop_template_id" => $clientDomain->leadpop_template_id,
                            "leadpop_id" => $clientDomain->leadpop_id,
                            "leadpop_version_id" => $clientDomain->leadpop_version_id,
                            "leadpop_version_seq" => $clientDomain->leadpop_version_seq,
                            "clients_domain_id" => $clientDomain->id,
                            "funnel_name" => $clientDomain->funnel_name,
                            "domain_name" => $clientDomain->domain_name,
                            "showbadge" => $clientDomain->showbadge,
                            "date_created" => DB::raw("now()")
                        ];
                    }
                    echo" Adding entries for client ID#" . $client_id . "\n";
                }
            }

            // insert domain entries
            if ($domainEntries && (count($domainEntries) >= $entriesPerQuery || $index == $totalClientsCount)) {
                DB::table($this->subdomains_table)->insert($domainEntries);
                $this->info("Inserted " . count($domainEntries) . " domain entries.");
                $domainEntries = [];
            }
            $index++;
        }

        if(count($domainEntries)) {
            echo "Domain Entries:" . count($domainEntries) . "\n";
            DB::table($this->subdomains_table)->insert($domainEntries);
        }
    }


    private function updateSubDomains($client_id){
        if($client_id == "" || $client_id == null){
            $this->comment("\n\n== == == == == == == == == == == ==\n Subdomains [clients_domain_id, domain_id] Update - (All Clients)\n== == == == == == == == == == == ==");

            $this->updateSubdomainsExistingEntries();
        }
        else {
            $this->comment("\n\n== == == == == == == == == == == ==\n Subdomains [clients_domain_id, domain_id] Update - ({$client_id})\n== == == == == == == == == == == ==");

            if(strstr($client_id, ",") !== false) {
                $client_ids = explode(",", $client_id);
                foreach($client_ids as $cid){
                    $this->updateSubdomainsExistingEntries($cid);
                }
            }
            else {
                $this->updateSubdomainsExistingEntries($client_id);
            }
        }
    }


    /**
     * update existing entries in clients_domains table, set clients_domain_id=id
     * @param null $client_id
     */
    private function updateSubdomainsExistingEntries($client_id=null){
        if($client_id == null) {
            $updatedRows = DB::table($this->subdomains_table)
                ->where("leadpop_type_id", $this->subdomain_type)
                ->whereNull("clients_domain_id")
                ->update([
                    "clients_domain_id" => "$this->subdomains_table.id"
                ]);
        }
        elseif($client_id) {
            $updatedRows = DB::table($this->subdomains_table)
                ->where("client_id", $client_id)
                ->where("leadpop_type_id", $this->subdomain_type)
                ->whereNull("clients_domain_id")
                ->update([
                    "clients_domain_id" => DB::raw("$this->subdomains_table.id")
                ]);
        }

        $this->info("[Subdomains] " . $updatedRows . " Rows updated.\n\n");
    }
}
