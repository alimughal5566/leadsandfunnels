<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmissionOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'submission_options';

        $data_third_party = [
            "is_active" => 1,
            "position" => 1,
            "thankyou_title" => 'Third Party URL',
        ];

        $data_thankyou_page = [
            "is_active" => 1,
            "position" => 1,
            "thankyou_title" => 'Default Success Message',
        ];
        \DB::table($table)->where('thirdparty_active','y')->update($data_third_party);
        \DB::table($table)->where('thankyou_active','y')->update($data_thankyou_page);

    }
}
