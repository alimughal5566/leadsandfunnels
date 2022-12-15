<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadpopBrandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leadpop_brandings', function (Blueprint $table) {
            $table->increments('id',11);
            $table->integer('client_id')->index();
            $table->integer('leadpop_version_id')->index();
            $table->integer('leadpop_version_seq');
            $table->tinyInteger('leadpop_branding_active')->default(0)->comment('branding feature is enable or not');
            $table->tinyInteger('leadpop_branding')->default(0)->comment('custom branding enable disable flag');
            $table->string('branding_image')->nullable();
            $table->integer('image_size')->default(65)->comment('image size in percentage');
            $table->string('image_dimension')->nullable();
            $table->string('image_position')->nullable();
            $table->tinyInteger('backlink_enable')->default(0);
            $table->string('backlink_url')->nullable();
            $table->string('backlink_target')->nullable();
            $table->string('image_title')->nullable();
            $table->string('image_alt')->nullable();
            $table->timestamps();
            $table->index(['client_id', 'leadpop_version_id', 'leadpop_version_seq'], 'key_client_versions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leadpop_brandings');
    }
}
