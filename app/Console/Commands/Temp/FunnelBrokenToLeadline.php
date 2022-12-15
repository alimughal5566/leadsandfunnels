<?php

namespace App\Console\Commands\Temp;

use App\Models\Clients;
use App\Repositories\CustomizeRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/*
 * This command will fix broken issue with client funnels
 */
class FunnelBrokenToLeadline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'funnelBrokenToLeadline:process {action : clients / fix}';
    protected $signature = 'db-fix:broken-lead-line';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will fix broken lead Line';

    /**
     * Create a new command instance.
     *
     * @return void
     */


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
            $client_ids = $this->ask("Please enter client ID");
            if($client_ids == "" || $client_ids == null){
                $this->error("Client ID is required");
                exit;
            }

            $action = $this->ask("Do you want to Fix? (Default: n)\n y=yes (Yes) | n=no (Dry Run) ");
            if($action == "" || $action == null || $action != "y"){
                $action = "n";
            }

            //$action = $this->argument('action');
            $this->comment( ($action == "y" ? "====> FIXING DATA <====" : "====> DRY RUN <====") );
            sleep(2);

            if($action == "n") {
                $funnelsBrokenData = DB::table('clients_leadpops')
                    ->select("client_id", DB::raw('count(*) as count'))
                    ->where('lead_line', "LIKE", "%<span #%")
                    ->where('leadpop_active', "!=", 3)
                    ->where('client_id', explode(",", $client_ids))
                    ->groupBy("client_id")
                    ->get();
                foreach ($funnelsBrokenData as $clientFunnelBrokenData) {
                    $this->info("Client ID# " . $clientFunnelBrokenData->client_id . ", Broken Funnels: " . $clientFunnelBrokenData->count);
                }
            } else {
                $this->processBrokenFunnels($client_ids);
            }
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }

    /**
     * This function will fix lead line broken issues with funnels
     */
    private function processBrokenFunnels($_client_ids){
        if($_client_ids != "" && $_client_ids != null){
            $client_ids = explode(",", $_client_ids);
            $this->comment("Executing command for client IDs# " . $_client_ids);

            for($i=5; $i>0; $i--){
                sleep(1);
                $this->comment("Executing in ".$i." seconds...");
            }

            $clientLeadpops = DB::table('clients_funnels_domains AS domain')
                ->select("domain.domain_name", "cl.id as client_leadpop_id",
                    "cl.funnel_market", "cl.lead_line", "cl.client_id",
                    "cl.leadpop_id", "domain.leadpop_vertical_id", "domain.leadpop_vertical_sub_id",
                    "cl.leadpop_version_id", "domain.leadpop_template_id", "domain.leadpop_type_id",
                    "cl.leadpop_version_seq"
                )
                ->join('clients_leadpops AS cl', function ($join) {
                    $join->on('cl.leadpop_id', '=', DB::raw('domain.leadpop_id'))
                        ->where('cl.client_id', DB::raw('domain.client_id'))
                        ->where('cl.leadpop_version_id', DB::raw('domain.leadpop_version_id'))
                        ->where('cl.leadpop_version_seq', DB::raw('domain.leadpop_version_seq'));
                })
                ->where('cl.lead_line', "LIKE", "%<span #%")
                ->where('cl.leadpop_active', "!=", 3)
                ->where('domain.client_id', $client_ids)
                ->where('domain.domain_name', 'NOT LIKE', "%temporary%")
                ->groupBy("domain.domain_name")
                ->get();

            $clientLeadpops1 = DB::table('clients_funnels_domains AS cs')
                ->select(DB::raw("concat(cs.subdomain_name, '.', cs.top_level_domain) as domain_name"),
                    "cl.id as client_leadpop_id", "cl.funnel_market", "cl.lead_line", "cl.client_id",
                    "cl.leadpop_id", "cs.leadpop_vertical_id", "cs.leadpop_vertical_sub_id",
                    "cl.leadpop_version_id", "cs.leadpop_template_id", "cs.leadpop_type_id",
                    "cl.leadpop_version_seq"
                )
                ->join('clients_leadpops AS cl', function ($join) {
                    $join->on('cl.leadpop_id', '=', DB::raw('cs.leadpop_id'))
                        ->where('cl.client_id', DB::raw('cs.client_id'))
                        ->where('cl.leadpop_version_id', DB::raw('cs.leadpop_version_id'))
                        ->where('cl.leadpop_version_seq', DB::raw('cs.leadpop_version_seq'));
                })
                ->where('cl.lead_line', "LIKE", "%<span #%")
                ->where('cl.leadpop_active', "!=", 3)
                ->whereIn('cs.client_id', $client_ids)
                ->groupBy("domain_name")
                ->get();

            $clientLeadpops = $clientLeadpops->merge($clientLeadpops1);

            foreach ($clientLeadpops as $clientLeadpop) {
                $this->info("\nUpdating client ID " . $clientLeadpop->client_id . ",client leadpop ID#". $clientLeadpop->client_leadpop_id . " \n- Lead line: " . $clientLeadpop->lead_line);
                $clientLeadpop->lead_line = preg_replace('/span #(.*?)font-family/m', 'span style="font-family', $clientLeadpop->lead_line);

                if(strpos($clientLeadpop->lead_line, "span #") !== false) {
                    $clientLeadpop->lead_line = $this->resetLeadlineToDefaults($clientLeadpop);
                    $this->comment("Defaults - " . $clientLeadpop->lead_line);

                    //Update to logo_color, if not default logo
                    $clientLeadpop->lead_line = $this->updateLeadlineLogoColor($clientLeadpop);
                    $this->comment("reset to - " . $clientLeadpop->lead_line);
                } else {
                    $this->comment("Fixed without reset - " . $clientLeadpop->lead_line);
                }

                // updating entry in database
                DB::table("clients_leadpops")
                    ->where('id', $clientLeadpop->client_leadpop_id)
                    ->where('client_id', $clientLeadpop->client_id)
                    ->update([
                        'lead_line' => $clientLeadpop->lead_line
                    ]);
            }
        } else {
            $this->error("Error: Client ID is required");
        }
    }

    private $stock_clients_default_table = [];
    private $website_clients_default_table = [];

    /**
     * reset to default CTA message styles
     * reset to default text too, if both cases failed
     * @param $clientLeadpop
     * @return string|string[]|null
     */
    private function resetLeadlineToDefaults($clientLeadpop) {
        $leadpop_id = $clientLeadpop->leadpop_id;
        /*
         * Funnel default tables only have entries against leadpop_type_id=1, don't have entries against leadpop_type_id=2
         * To fix this issue getting leadpop_id against leadpop_type_id=1
         */
        if($clientLeadpop->leadpop_type_id == 2) {
            $leadpop_id = DB::table("leadpops")
                ->where("leadpop_vertical_id", $clientLeadpop->leadpop_vertical_id)
                ->where("leadpop_vertical_sub_id", $clientLeadpop->leadpop_vertical_sub_id)
                ->where("leadpop_version_id", $clientLeadpop->leadpop_version_id)
                ->where("leadpop_template_id", $clientLeadpop->leadpop_template_id)
                ->value("id");
        }

        $cutomizeRepo = \App::make('App\Repositories\CustomizeRepository');
        $client = Clients::where('client_id', $clientLeadpop->client_id)->first();
        $defaultsStockTable = $defaultsTable = $cutomizeRepo->getStockFunnelDefaultTable($client);

        if($clientLeadpop->funnel_market == 'w'){
            $defaultsTable = $cutomizeRepo->getWebsiteFunnelDefaultTable($client);
        }

        if ($clientLeadpop->client_id == 248 && $clientLeadpop->leadpop_vertical_sub_id == 74) {
            $defaultData = DB::table("trial_launch_defaults")
                ->where("leadpop_id", 1)
                ->where("leadpop_vertical_id", 3)
                ->where("leadpop_vertical_sub_id", 11)
                ->where("leadpop_template_id", 14)
                ->where("leadpop_version_id", 14)
                ->where("leadpop_version_seq", 1)
                ->first();
        } else {
            $defaultData = DB::table($defaultsTable)
                ->where("leadpop_id", $leadpop_id)
                ->where("leadpop_vertical_id", $clientLeadpop->leadpop_vertical_id)
                ->where("leadpop_vertical_sub_id", $clientLeadpop->leadpop_vertical_sub_id)
                ->where("leadpop_version_id", $clientLeadpop->leadpop_version_id)
                ->where("leadpop_template_id", $clientLeadpop->leadpop_template_id)
                ->first();
        }
        $defaultData = (array) $defaultData;

        // Website-funnel - get defaults
        if($clientLeadpop->funnel_market == 'w'){
            $stockDefault = DB::table($defaultsStockTable)
                ->where("leadpop_id", $leadpop_id)
                ->where("leadpop_vertical_id", $clientLeadpop->leadpop_vertical_id)
                ->where("leadpop_vertical_sub_id", $clientLeadpop->leadpop_vertical_sub_id)
                ->where("leadpop_version_id", $clientLeadpop->leadpop_version_id)
                ->where("leadpop_template_id", $clientLeadpop->leadpop_template_id)
                ->first();

            if($stockDefault){
                $defaultData = $cutomizeRepo->mapWebsiteFunnelDefaultsToStock((array) $stockDefault, $defaultData);
            }
        }

        $length = strlen($clientLeadpop->lead_line);
        $span_str = "<span #";
        $span_pos = strpos($clientLeadpop->lead_line, $span_str);
        if($span_pos !== false){
            if(strpos($clientLeadpop->lead_line, '>', $span_pos) < $length - 7) {
                $this->comment("Case 1: updating styles");
                return preg_replace('/<span #(.*?)>/m', '<span style="font-family: ' . $defaultData["main_message_font"] . '; font-size:' . $defaultData["main_message_font_size"] . '; color:' . $defaultData['mainmessage_color'] . ';">', $clientLeadpop->lead_line);
            } else if($length > 20 && strpos($clientLeadpop->lead_line, '</span>', $span_pos) !== false) {
                $this->comment("Case 2: updating styles");
                $sec = $span_pos + strlen($span_str)  + 6;
                $to_replace = substr($clientLeadpop->lead_line, $span_pos, ($sec - $span_pos));

                return str_replace($to_replace, '<span style="font-family: ' . $defaultData["main_message_font"] . '; font-size:' . $defaultData["main_message_font_size"] . '; color:' . $defaultData['mainmessage_color'] . ';">', $clientLeadpop->lead_line);
            }
        }
        $this->comment("Case 3: update styles + text");
        return '<span style="font-family: ' . $defaultData["main_message_font"] . '; font-size:' . $defaultData["main_message_font_size"] . '; color:' . $defaultData['mainmessage_color'] . ';">'  . $defaultData['main_message'] . '</span>';
    }

    /**
     * Update leadline color with logo color
     * @param $clientLeadpop
     * @param $span
     */
    private function updateLeadlineLogoColor($clientLeadpop){
        //to get logo color if use_default = n
        $leadpopLogo = DB::table("leadpop_logos")
            ->where("client_id", $clientLeadpop->client_id)
            ->where("leadpop_id", $clientLeadpop->leadpop_id)
            ->where("leadpop_vertical_id", $clientLeadpop->leadpop_vertical_id)
            ->where("leadpop_vertical_sub_id", $clientLeadpop->leadpop_vertical_sub_id)
            ->where("leadpop_template_id", $clientLeadpop->leadpop_template_id)
            ->where("leadpop_version_id", $clientLeadpop->leadpop_version_id)
            ->where("leadpop_version_seq", $clientLeadpop->leadpop_version_seq)
            ->first();

        if($leadpopLogo && $leadpopLogo->use_default == 'n') {
            if ($leadpopLogo->logo_color  && $leadpopLogo->logo_color != "" &&  strtolower($leadpopLogo->logo_color) !== "#ffffff") {
                $clientLeadpop->lead_line = preg_replace('/color:(.*?);/', "color:" . $leadpopLogo->logo_color . ";", $clientLeadpop->lead_line);
            }
        }

        return $clientLeadpop->lead_line;
    }
}
