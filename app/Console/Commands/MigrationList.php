<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class MigrationList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:list';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Show the status of each migration including all sub-directories';

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
        $this->call('migrate:status');

        $mainPath = database_path('migrations');
        $directories = glob($mainPath . '/*' , GLOB_ONLYDIR);

        if($directories){
            foreach($directories as $directory){
                $this->comment(str_replace(LP_BASE_DIR, "",  $directory));
                $this->call('migrate:status', [
                    '--path' => str_replace(LP_BASE_DIR, "",  $directory)
                ]);
            }
        }
    }

}
