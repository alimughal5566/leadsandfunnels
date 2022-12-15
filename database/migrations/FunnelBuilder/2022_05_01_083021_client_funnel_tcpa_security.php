<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClientFunnelTcpaSecurity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('client_funnel_tcpa_security')) {
            Schema::create('client_funnel_tcpa_security', function (Blueprint $table) {
                $table->increments('id',11);
                $table->string('tcpa_title', 255);
                $table->text('tcpa_text')->nullable();
                $table->tinyInteger('is_required')->default(0);
                $table->tinyInteger('is_active')->default(0);
                $table->integer('client_id')->index();
                $table->integer('domain_id')->index();
                $table->integer('leadpop_version_id');
                $table->integer('leadpop_version_seq');
                $table->tinyInteger('content_type')->default(1)->comment('1=TCPA / 2=Security');
                $table->text('icon')->nullable();
                $table->text('tcpa_text_style')->nullable();
                $table->dateTime('date_added')->default(\DB::raw('CURRENT_TIMESTAMP'));
                $table->dateTime('date_updated')->default(\DB::raw('CURRENT_TIMESTAMP'));
                $table->index(['client_id', 'leadpop_version_id', 'leadpop_version_seq'], 'key_client_versions');
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_funnel_tcpa_security');
    }
}
