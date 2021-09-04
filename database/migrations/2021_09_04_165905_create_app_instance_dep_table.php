<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppInstanceDepTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_instance_dep', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('instance_id')->unsigned();
            $table->integer('instance_dep_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('instance_id')->references('id')->on('app_instance');
            $table->foreign('instance_dep_id')->references('id')->on('app_instance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('app_instance_dep');
    }
}
