<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use UserStatus;

class PasswordGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:password {--plainText=}';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Generate Password by Random Script. If any option provided then directly updates particular user.';


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
		$options = $this->options();

		if(@$options['plainText'] != ""){
			$password = $options['plainText'];
		} else {
			$password = $this->randomPassword();
		}
		$hash = Hash::make($password);

		$this->info( "Plain Password: ".$password );
		$this->info( "Password Hash: ".$hash );

		$time_end = microtime(true);
		$execution_time = ($time_end - $time_start)/60;
		$this->comment("Total Execution Time: ".$execution_time." Mins");
	}


	function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}
}
