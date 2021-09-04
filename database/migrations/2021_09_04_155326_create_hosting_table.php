<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostingTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hosting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('hosting_type_id')->unsigned();
            $table->string('localisation');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('hosting_type_id')->references('id')->on('hosting_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hosting');
    }
}
