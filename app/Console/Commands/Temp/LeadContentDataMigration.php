<?php

namespace App\Console\Commands\Temp;

use Illuminate\Console\Command;



class LeadContentDataMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deprecated:db-optimization:migrate-leads-content-v2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate leads content from lead_content table to lead_content_v2 table';


    /** @var  \App\Services\DbService $db */
    private $db;

    private $chunk = 100;
    private $new_table = "lead_content_v2";

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
    public function handle(){
        try {
            $this->db = \App::make('App\Services\DbService');
            $client_id = $this->ask("Please Enter Client Id, Enter 0 for all clients");
            $update_type = $this->ask("Do you want to migrate New Rows Only? (Default: no)\n Type 'yes' YES, Migrate new rows only \n Type 'no' to re-migrate all rows");
            if($update_type == ""){
                $update_type = "no";
            }

            $lead_content = \DB::table('lead_content')->select('*')->orderBy('id', 'asc');

            if($client_id > 0){
                if(strtolower($update_type) !== 'yes'){
                    // Remove Old entries first
                    \DB::table($this->new_table)->where('client_id', $client_id)->delete();

                    $this->comment("Removed all rows for ".$client_id." from ".$this->new_table);
                }
                else {
                    $last_id = \DB::table($this->new_table)->where('client_id', $client_id)->max('id');
                    $lead_content->where('id', '>', $last_id);
                    $this->comment("Fetching leads for Client: ".$client_id." from ID ".$last_id);
                }

                $lead_content->where('client_id', $client_id);
            }
            else{
                // For all clients
                if(strtolower($update_type) === 'yes') {
                    $last_id = \DB::table($this->new_table)->max('id');
                    $lead_content->where('id', '>', $last_id);
                    $this->comment("Fetching leads from ID ".$last_id);
                }
                else{
                    \DB::table($this->new_table)->truncate();
                }
            }

            $total_rows = $lead_content->count();
            if($total_rows === 0){
                $this->error("\n\nNo Data Found.\n\n");
                return false;
            }

            $bar = $this->output->createProgressBar($total_rows);
            $bar->start();


            $lead_content->chunk($this->chunk, function ($leads) use ($bar) {
                $insertData = [];

                foreach ($leads as $key => $lead) {
                    $lead = (array)$lead;
                    $questions = [];
                    $answers = [];
                    $key = 1;
                    for ($i = 1; $i <= 50; $i++) {
                        if ($lead['q' . $i]) {
                            $questions[$key] = $lead['q' . $i] ?? "";
                            $answers[$key] = $lead['a' . $i] ?? "";
                            $key++;

                        }
                    }
                    $questionsJson = json_encode($questions);
                    $answersJson = json_encode($answers);

                    $insertOneRecord = [
                        'id' => $lead['id'],
                        'client_id' => $lead['client_id'],
                        'leadpop_id' => $lead['leadpop_id'],
                        'leadpop_vertical_id' => $lead['leadpop_vertical_id'],
                        'leadpop_vertical_sub_id' => $lead['leadpop_vertical_sub_id'],
                        'leadpop_template_id' => $lead['leadpop_template_id'],

                        'leadpop_version_id' => $lead['leadpop_version_id'],
                        'leadpop_version_seq' => $lead['leadpop_version_seq'],
                        'unique_key' => $lead['unique_key'],
                        'opened' => $lead['opened'],
                        'deleted' => $lead['deleted'],

                        'firstname' => $lead['firstname'],
                        'lastname' => $lead['lastname'],
                        'email' => $lead['email'],
                        'phone' => $lead['phone'],
                        'date_completed' => $lead['date_completed'],

                        'lead_questions' => $questionsJson,
                        'lead_answers' => $answersJson,
                        'date_updated' => $lead['date_updated'],
                        'date_created' => $lead['date_created'],
                    ];

                    $insertData[] = $insertOneRecord;

                    $bar->setMessage("ID: ".$lead['id']);
                    $bar->advance();
                }

                $insertDataCollection = collect($insertData);
                $chunks = $insertDataCollection->chunk($this->chunk/3);
                foreach ($chunks as $chunk){
                    \DB::table($this->new_table)->insert($chunk->toArray());
                }

            });


            $this->info( "\nLeads have Migrated from lead_content to ".$this->new_table."\n" );
            $bar->finish();
        }
        catch (\Exception $ex) {
            $this->error($ex->getMessage());
            exit;
        }
    }
}
