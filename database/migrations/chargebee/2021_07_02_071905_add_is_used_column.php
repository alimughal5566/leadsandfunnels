<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsUsedColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chargebee_plans_addons', function (Blueprint $table) {
            $table->tinyInteger('is_used')->default(0)->after('client_plan_type');
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
            $table->dropColumn('is_used');
        });
    }
}
