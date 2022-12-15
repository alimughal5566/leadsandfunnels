<?php
// Helps with capturing script termination
declare(ticks = 1);

namespace App\Console\Commands;

use App\Models\Clients;
use Illuminate\Console\Command;
use App\Helpers\ChargeBeeHelpers;
use Illuminate\Support\Facades\Schema;
use App\Models\ClientVerticalPackagesPermissions;

class PopulatePlanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deprecated:client:populate-plan
                            {--update-clone-flag : Updates clone flag to "y" for pro plans}
                            {--ignore-existing : Ignore existing plan id data in client\'s table and update it with latest from chargebee}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populates each client\'s current chargebee plan if it not already added and optionally updates clone flag';

    // Path to file containing all valid plan Ids
    protected $planIdsFilePath;
    // Path to file containing all valid pro plan Ids
    protected $proPlanIdsFilePath;
    // Output directory path for generated CSV log file
    protected $csvOutputDirPath;
    // CSV file name
    protected $csvFileName;
    // An array containing all valid plan Ids
    protected $allPlanIds;
    // An array containing all pro plan Ids
    protected $allProPlanIds;
    // CSV generated log
    protected $csvLog;
    // Progress bar format specifier string
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
        // Initialize configuration and check pre conditions
        $this->init();

        // Total number of clients in database
        $noOfClients = Clients::count();
        // Progress bar that would be shown in terminal
        $progressBar = $this->output->createProgressBar($noOfClients);
        // Specifying progress bar format
        $progressBar->setFormat($this->progressBarFormat);

        // To minimize memory consumption, we process data in chunks
        Clients::chunkById(100, function ($clients) use ($progressBar) {
            foreach($clients as $client){
                // This would show currently processing client's ID and email in terminal
                $progressBar->setMessage("Processed client ID: {$client->client_id}  Email: {$client->contact_email}");
                // We populate client plan if it exists, log for any errors
                $this->populateClientPlan($client);
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
     * It initializes all properties to desired values and checks for pre conditions
     *
     * @return void
     */
    protected function init(){
        // Path to file containing all plan Ids
        $this->planIdsFilePath = __DIR__ . '/input-data/plans.csv';
        // Path to file containing all pro plan Ids
        $this->proPlanIdsFilePath = __DIR__ . '/input-data/pro-plans.csv';
        // Output directory path
        $this->csvOutputDirPath = __DIR__ . '/output-data';

        // We will append date and time to CSV file name
        $dateTime = date('Y-m-d_H-i-s');
        $this->csvFileName = "populate-plans-log-{$dateTime}.csv";

        // Get an array of all plan Ids
        $this->allPlanIds = $this->getAllPlanIds($this->planIdsFilePath);
        // Get an array of all pro plan Ids
        $this->allProPlanIds = $this->getAllPlanIds($this->proPlanIdsFilePath);
        // Initialize CSV log with header
        $this->csvLog = "Client ID|Email|Status|Message\n";

        // Progress bar format
        $this->progressBarFormat = "%message%\n%current%/%max% [%bar%] %percent%%\nTime Elapsed: %elapsed%\nEstimated Remaining: %remaining%\nTotal Estimated: %estimated%";

        // Check for pre conditions
        $this->checkPreConditions();

        // Let the use know the path to generated CSV file
        echo "A CSV file with '|' as delimiter will be generated at path:\n{$this->csvOutputDirPath}/{$this->csvFileName}\n\n";


        // We want to save progress before exit in CSV, so we are subscribing to
        // termination signals
        pcntl_signal(SIGTERM, [$this, 'saveCsvLogFile']);// Termination ('kill' was called)
        pcntl_signal(SIGHUP, [$this, 'saveCsvLogFile']); // Terminal log-out
        pcntl_signal(SIGINT, [$this, 'saveCsvLogFile']); // Ctrl+C called
    }

    /**
     * Responsible for fetching client's plan from chargbee and saving in DB
     * and logging on errors
     *
     * @param Clients $client
     * @return void
     */
    protected function populateClientPlan(Clients $client) {
        // We return if plan is already set for a client
        if(!empty($client->client_plan_id) && !$this->option('ignore-existing')){
            $this->log('exists', $client->client_id, $client->contact_email);
            return;
        }

        try{
            // Get customer data from Chargebee for client's email
            $customer = ChargeBeeHelpers::getChargebeeCustomer($client->contact_email);

            // If customer data not found, log related error
            if(!$customer['status']){
                throw new \Exception($customer['message']);
            }

            if(empty($customer['result'][0]['customer']['id'])){
                throw new \Exception('Could not find chargebee customer for client\'s email');
            }

            // Chargebee customer Id
            $customerId = $customer['result'][0]['customer']['id'];

            // Fetch all plans related to funnel for this customer
            $subscriptions = ChargeBeeHelpers::getCustomerSubscriptionsHavingPlans($customerId, $this->allPlanIds);

            // Log error if we could not get data
            if(!$subscriptions['status']){
                throw new \Exception($subscriptions['message']);
            }

            // Return error if no subscription found
            if(empty($subscriptions['result'][0]['subscription']['plan_id'])){
                throw new \Exception('No subscription found related to funnels');
            }

            // If more than one subscriptions found, we would log it as an error
            if(count($subscriptions['result']) > 1){
                $allSubscriptions = array_column($subscriptions['result'], 'subscription');
                $planIds = array_column($allSubscriptions, 'plan_id');
                $planIds = array_unique($planIds);
                $planIdsStr = implode(',', $planIds);

                throw new \Exception('More than one subscriptions found for this client: ' . $planIdsStr);
            }

            // Chargebee plan Id
            $planId = $subscriptions['result'][0]['subscription']['plan_id'];

            // Save to client table
            $client->client_plan_id = $planId;


            // If option is set to update clone flag and it is a pro plan
            if($this->option('update-clone-flag') && in_array($planId, $this->allProPlanIds)){
                // then we update it to 'y'
                $clientPackagePermission = ClientVerticalPackagesPermissions::where('client_id', $client->client_id)->first();

                // If data could not be found, we log it as error
                if(!$clientPackagePermission){
                    throw new \Exception('Clone flag could not be updated, data not found for this client in clone permission table');
                }

                $clientPackagePermission->clone = 'y';
                $clientPackagePermission->save();
            }

            // If everything is well, we update client data
            $client->save();

            // We are here, it means we have successfully added plan to DB, lets log it
            $this->log('added', $client->client_id, $client->contact_email);

        } catch (\Exception $e){
            // Log any error, while add client's plan
            $this->log('error', $client->client_id, $client->contact_email, $e->getMessage());
        }

        // Chargebee rate limit is 150 requests per minute which translates
        // to 2.5 requests per second, we are sending two requests per client
        // so we will sleep for one second after processing each client
        // to not exceed that limit
        sleep(1);
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
     * Reads and converts data from plan ids CSV file to array
     *
     * @return array
     */
    protected function getAllPlanIds(string $file) : array {
        // Returns a multidimensional array for CSV
        $allPlanIds = array_map('str_getcsv', file($file));
        // Lets flatten the array to single dimension
        return array_merge([], ...$allPlanIds);
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
    protected function log(string $type, string $clientId, string $email, string $message = ''){
        $this->csvLog .= "$clientId|$email|$type|$message\n";
    }
}
