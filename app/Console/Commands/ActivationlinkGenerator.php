<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use LP_Helper;
use UserStatus;

class ActivationlinkGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:activation-link {email}';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Generate Email Activation link by email';

    /** @var  \App\Services\DbService $db */
    private $db;

	/**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct(){
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
	public function handle(){
		$time_start = microtime(true);

        $this->db = \App::make('App\Services\DbService');
        $client_email = $this->argument('email');

        $sql = "SELECT client_id, first_name, last_name, contact_email, client_type, password, launch_status FROM clients WHERE contact_email = '" . $client_email . "' AND launch_status IN (0,1) ORDER BY client_id DESC limit 1";
        $client = $resultSet = $this->db->fetchRow($sql);

        if($client) {
            $hash = LP_Helper::getInstance()->encrypt(json_encode(["id" => $client['client_id'], "email" => $client['contact_email']]));
            $activation_link = env("APP_URL") ."/lp/launcher?hash=". $hash;
            $this->info("Activation Link: ".$activation_link);
        }
        else{
            $this->error("No Client Found.");
        }

		$time_end = microtime(true);
		$execution_time = ($time_end - $time_start)/60;
		$this->comment("Total Execution Time: ".$execution_time." Mins");
	}
}
