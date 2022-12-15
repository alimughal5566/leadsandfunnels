<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPositionToSubmissionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('submission_options', 'thankyou_title')){
            Schema::table('submission_options', function (Blueprint $table) {
                $table->string('thankyou_title', 200)->nullable();
                $table->integer('position')->nullable();
                $table->tinyInteger('is_active')->default('0')->nullable();
            });

            // Call seeder
            \Artisan::call('db:seed', [
                '--class' => 'SubmissionOptionSeeder',
                '--force' => true // <--- add this line for production
            ]);
        }
        else{
            $this->log('[Already Executed] submission_options already altered.');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('submission_options', 'thankyou_title')) {
            Schema::table('submission_options', function (Blueprint $table) {
                $table->dropColumn(['thankyou_title', 'position', 'is_active']);
            });
        }
    }

    private function log($exp){
        echo $exp.PHP_EOL;
    }
}
