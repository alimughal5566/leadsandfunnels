<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChargebeePlansAddonsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chargebee_plans_addons', function (Blueprint $table) {
          //  $table->dropColumn('additional_fields');
            $table->json("additional_fields")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('charge_plans_addons', function (Blueprint $table) {
            //
        });
    }
}
