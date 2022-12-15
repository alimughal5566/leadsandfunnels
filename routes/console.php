<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('release:funnel-builder', function () {

    // Command # 1
    $this->comment("Seeder: Switching Default Thankyou table with new table");
    Artisan::call('db:seed', ['--class' => 'RenameThankYouDefaultsTableSeeder'], $this->getOutput());
    $this->info("Seeder: Completed");

    // Command # 2
    sleep(3);
    $this->comment("Migration: Initialized 2021_11_08_075258_add_position_to_submission_options_table.php");
    Artisan::call('migrate', ['--path' => '/database/migrations/FunnelBuilder/2021_11_08_075258_add_position_to_submission_options_table.php'],$this->getOutput());
    Artisan::call('migrate:list',[],$this->getOutput());

    // Command # 3
    sleep(3);
    $this->comment("Migration: Initialized 2022_05_01_083021_client_funnel_tcpa_security.php");
    Artisan::call('migrate', ['--path' => '/database/migrations/FunnelBuilder/2022_05_01_083021_client_funnel_tcpa_security.php'],$this->getOutput());
    Artisan::call('migrate:list',[],$this->getOutput());

    // Command # 4
    sleep(3);
    $this->comment("Seeder: Fill update table with TCPA message for each production funnel.");
    Artisan::call('db:seed', ['--class' => 'TCPAInsertDataSeeder'], $this->getOutput());
    $this->info("Seeder: Completed");

    // Command # 4
    sleep(3);
    Artisan::call('optimize:clear',[],$this->getOutput());

})->describe('This artisan command groups all migrations, seeders & other commands required to release funnel builder feature');
