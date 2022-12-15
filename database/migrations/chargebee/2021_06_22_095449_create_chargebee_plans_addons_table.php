<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargebeePlansAddonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('chargebee_plans_addons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plan_id')->index();
            $table->string('plan_name');
            $table->string('period_unit')->nullable();
            $table->string('plan_price')->nullable();
            $table->string('pricing_model')->nullable();
            $table->string('client_type')->nullable();
            $table->string('client_plan_type')->nullable();
            $table->string('additional_fields')->nullable();
            $table->string('plan_type')->index();
            $table->string('date_created')->nullable()->comment('The creation date on Chargebee');
            $table->string('date_updated')->nullable()->comment('The updation date on Chargebee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chargebee_plans_addons');
    }
}
