<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
/**
 * Class RenameThankYouDefaultsTableSeeder
 *
 * Command to execute seeder - php artisan db:seed --class=RenameThankYouDefaultsTableSeeder
 */
class RenameThankYouDefaultsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasTable('thankyou_defaults_new')) {
            Schema::rename('thankyou_defaults', 'thankyou_defaults_old');
            Schema::rename('thankyou_defaults_new', 'thankyou_defaults');
        }
        else{
            if (Schema::hasTable('thankyou_defaults_old')) {
                $this->command->info('[Already Executed] Table already replaced.');
            } else {
                $this->command->info('[Manual Import Required] Please import `thankyou_defaults_new` table to proceed.');
            }
        }
    }
}
