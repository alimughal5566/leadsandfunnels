<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chargebee_plans_addons', function (Blueprint $table) {
            $table->string('industry')->nullable()->after('client_type');
            $table->string('funnel_type')->nullable()->after('industry');
            $table->string('status')->nullable()->after('plan_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chargebee_plans_addons', function (Blueprint $table) {
            $table->dropColumn('industry');
            $table->dropColumn('funnel_type');
            $table->dropColumn('status');
        });
    }
}
