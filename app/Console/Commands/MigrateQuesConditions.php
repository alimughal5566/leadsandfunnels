<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\gm_process\ConditionalLogicEvents;


class MigrateQuesConditions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'funnel-builder:upgrade-conditions {ClientId}  {--FunnelId= : Funnel id is ID from clients_leadpops table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[One Time Command] This command upgrades the old conditions to new version via gearman process';

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
        $this->db = \App::make('App\Services\DbService');
        $client_id = $this->argument('ClientId');
        $funnel_id = $this->option('FunnelId');

        $s = "SELECT client_id, count(*) as num_of_funnels from clients_leadpops WHERE conditional_logic LIKE '[{%'";
        if($client_id == "all") $s .= " AND client_id = ".$client_id;
        if($funnel_id != "") $s .= " AND id = ".$funnel_id;
        $s .= " GROUP BY client_id ORDER BY client_id";
        $client_ids = $this->db->fetchAll($s);
        if(count($client_ids)){
            foreach ($client_ids as $d){
                if($funnel_id && is_numeric($funnel_id))
                    $this->comment("Client ID: ".$client_id." / Funnel ID: ".$funnel_id." => sent to gearman server for upgrading.");
                else
                    $this->comment("Client: ".$d['client_id']." -> matched ".$d['num_of_funnels']." funnels - Request sent to gearman server to process.");

                $data = ['clientid' => intval($d['client_id'])];
                if($funnel_id && is_numeric($funnel_id)) $data['funnelid'] = $funnel_id;
                ConditionalLogicEvents::getInstance()->conditionalLogicUpdateMapData($data);
            }
        }
        else {
            $this->info("No funnel(s) found to process".($client_id!="all" ? " for client # ".$client_id : ""));
        }
    }
}
