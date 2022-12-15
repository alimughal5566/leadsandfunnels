<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowCtaToLeadpopsAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('clients_leadpops_attributes', 'enable_cta')){
            Schema::table('clients_leadpops_attributes', function (Blueprint $table) {
                $table->tinyInteger('enable_cta')->default('1');
            });
        }
        else{
            $this->log('[Already Executed] clients_leadpops_attributes already altered.');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('clients_leadpops_attributes', 'enable_cta')) {
            Schema::table('clients_leadpops_attributes', function (Blueprint $table) {
                $table->dropColumn(['enable_cta']);
            });
        }
        else{
            $this->log('Column not available to drop.');
        }
    }

    private function log($exp){
        echo $exp.PHP_EOL;
    }
}
