<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppInstanceTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_instance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('application_id')->unsigned();
            $table->integer('service_version_id')->unsigned();
            $table->integer('environnement_id')->unsigned();
            $table->integer('hosting_id')->unsigned();
            $table->string('url');
            $table->boolean('statut')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('application_id')->references('id')->on('application');
            $table->foreign('service_version_id')->references('id')->on('service_version');
            $table->foreign('environnement_id')->references('id')->on('environnement');
            $table->foreign('hosting_id')->references('id')->on('hosting');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_instance');
    }
}
