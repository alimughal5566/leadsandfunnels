<?php

use Illuminate\Database\Seeder;

class ZipcodesDeleteEntries extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'zipcodes';

        if (Schema::hasTable($table)) {
           \DB::table($table)->where('state','GU')->orWhere('state','PR')->delete();
            $this->command->info('zipcode table record has deleted');
        }else{
            $this->command->info('zipcode table does not exist');
        }

    }
}
