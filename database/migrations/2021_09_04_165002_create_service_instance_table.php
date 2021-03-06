<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceInstanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_instance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('application_id')->unsigned();
            $table->integer('service_version_id')->unsigned();
            $table->integer('environnement_id')->unsigned();
            $table->integer('hosting_id')->unsigned();
            $table->string('url')->nullable();
            $table->string('role')->nullable();
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
        Schema::drop('service_instance');
    }
}
