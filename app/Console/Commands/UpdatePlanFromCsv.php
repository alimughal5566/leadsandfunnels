<?php
// Helps with capturing script termination
declare(ticks = 1);

namespace App\Console\Commands;

use App\Models\Clients;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use App\Models\ClientVerticalPackagesPermissions;

class UpdatePlanFromCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deprecated:client:update-plan-from-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates plans from CSV for all clients';

    protected $csvLog;
    protected $clientPlansData;
    protected $csvOutputDirPath;
    protected $csvFileName;
    protected $progressBarFormat;


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
        $this->init();
        // Total number of clients in database
        $noOfClients = Clients::count();
        // Progress bar that would be shown in terminal
        $progressBar = $this->output->createProgressBar($noOfClients);
        // Specifying progress bar format
        $progressBar->setFormat($this->progressBarFormat);

        Clients::chunkById(200, function($clients) use ($progressBar) {
            foreach($clients as $client){
                // This would show currently processing client's ID and email in terminal
                $progressBar->setMessage("Processed client ID: {$client->client_id}  Email: {$client->contact_email}");

                if(isset($this->clientPlansData[$client->contact_email])){
                    $this->updateClientPlan($client, $this->clientPlansData[$client->contact_email]);
                } else {
                    $this->log('skipped', $client->client_id, $client->contact_email);
                }

                // This would advance the progress bar by 1
                $progressBar->advance();
            }
        }, 'client_id');

        // We will save log to CSV file upon completion
        file_put_contents($this->csvOutputDirPath . '/' . $this->csvFileName, $this->csvLog);
        // This would move the progress bar to 100% if it is not already
        $progressBar->finish();
    }

    /**
     * Initializes propterties and other data and check for pre conditions
     *
     * @return void
     */
    protected function init(){

        // Output directory path
        $this->csvOutputDirPath = __DIR__ . '/output-data';

        // We will append date and time to CSV file name
        $dateTime = date('Y-m-d_H-i-s');
        $this->csvFileName = "update-plan-from-csv-log-{$dateTime}.csv";

        $this->checkPreConditions();

        $this->csvLog = "Client ID|Email|Status|Message|Current Client Package|Previous Client Package|Previous Clone Flag\n";

        $this->clientPlansData = array_map('str_getcsv', file(__DIR__ . '/input-data/all-client-plans.csv'));
        $this->clientPlansData = collect($this->clientPlansData)->keyBy(1);

        // Progress bar format
        $this->progressBarFormat = "%message%\n%current%/%max% [%bar%] %percent%%\nTime Elapsed: %elapsed%\nEstimated Remaining: %remaining%\nTotal Estimated: %estimated%";

        // Let the use know the path to generated CSV file
        echo "A CSV file with '|' as delimiter will be generated at path:\n{$this->csvOutputDirPath}/{$this->csvFileName}\n\n";

        // We want to save progress before exit in CSV, so we are subscribing to
        // termination signals
        pcntl_signal(SIGTERM, [$this, 'saveCsvLogFile']);// Termination ('kill' was called)
        pcntl_signal(SIGHUP, [$this, 'saveCsvLogFile']); // Terminal log-out
        pcntl_signal(SIGINT, [$this, 'saveCsvLogFile']); // Ctrl+C called
    }

     /**
     * It checks for conditions that should be met before executing command
     *
     * @return void
     */
    protected function checkPreConditions(){
        // If there is no column in clients table, we would to be able to store
        // plan Ids, so we exit early
        if(!Schema::hasColumn('clients', 'client_plan_id')){
            echo "Error: clients table does not have a column named 'client_plan_id'";
            exit;
        }

        // If log output directory is not writable, we would exit early to let
        // the user fix permissions
        if(!is_writable($this->csvOutputDirPath)){
            echo "Error: can not create file in '{$this->csvOutputDirPath}', permission denied.";
            exit;
        }
    }

    /**
     * Updates client package in DB and also updates clone flag if client is pro
     *
     * @param Clients $client
     * @param array $data
     * @return void
     */
    protected function updateClientPlan(Clients $client, array $data){
        try{

            list($planId, $email, $packageType) = $data;

            $previousPlan = !empty($client->client_plan_id) ? $client->client_plan_id : '';
            $message = '';
            $previousPermission = '';

            $clientPackagePermission = ClientVerticalPackagesPermissions::where('client_id', $client->client_id)->first();
            // If data could not be found, we log it as error
            if(!$clientPackagePermission){
                throw new \Exception('Data not found for this client in clone permission table');
            }
            $previousPermission = !empty($clientPackagePermission->clone) ? $clientPackagePermission->clone : '';

            if(trim($packageType) == 'Marketer Pro' || $client->is_mm == 1 || $client->is_fairway == 1 || $client->is_aime == 1 || $client->is_thrive == 1 || $client->is_stearns == 1){
                $clientPackagePermission->clone = 'y';
                $clientPackagePermission->save();

                $message = $previousPermission == 'y' ? "Cloning already active" : "Cloning enabled";

                if(trim($packageType) == 'Marketer Pro') $message .= " - Marketer Pro";
                else if($client->is_stearns == 1) $message .= " - Stearns";
                else if($client->is_thrive == 1) $message .= " - Thrive";
                else if($client->is_aime == 1) $message .= " - AIME";
                else if($client->is_fairway == 1) $message .= " - Fairway";
                else if($client->is_mm == 1) $message .= " - Movement";
            }
            else{
                $message = "No Cloning";
            }

            $client->client_plan_id = $planId;
            $client->save();

            $this->log('success', $client->client_id, $client->contact_email, $message, $planId, $previousPlan, $previousPermission);

        } catch (\Exception $e){
            $this->log('error', $client->client_id, $client->contact_email, $e->getMessage());
        }
    }


    /**
     * Saves CSV log to file, used by termination traps
     *
     * @return void
     */
    public function saveCsvLogFile(){
        file_put_contents($this->csvOutputDirPath . '/' . $this->csvFileName, $this->csvLog);
        exit;
    }

    /**
     * Log function used to log to CSV file
     *
     * @param string $type
     * @param string $clientId
     * @param string $email
     * @param string $message
     * @return void
     */
    protected function log(string $type, string $clientId, string $email, string $message = '', string $currentPlan = '', string $previousPlan = '', string $previousClonePackage = ''){
        $this->csvLog .= "$clientId|$email|$type|$message|$currentPlan|$previousPlan|$previousClonePackage\n";
    }
}
