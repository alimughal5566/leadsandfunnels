<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('client_plan_subscription_id')->nullable()->after('client_plan_id')->comment("Primary Plan's subscription ID");
            $table->string('branding_plan_id')->nullable()->after('client_plan_subscription_id')->comment("Currently active branding plan's ID");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('client_plan_subscription_id');
            $table->dropColumn('branding_plan_id');
        });
    }
}
