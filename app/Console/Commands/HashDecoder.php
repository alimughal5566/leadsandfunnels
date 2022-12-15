<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use LP_Helper;
use UserStatus;

class HashDecoder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hash:decode {hash}';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Get funnel unique hash information';

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

        $hash = $this->argument('hash');

        $funnel_data = LP_Helper::getInstance()->funnel_hash($hash);
        foreach($funnel_data as $key=>$val){
            $this->info($key.": ".$val);
        }

		$time_end = microtime(true);
		$execution_time = ($time_end - $time_start)/60;
		$this->comment("Total Execution Time: ".$execution_time." Mins");
	}
}
