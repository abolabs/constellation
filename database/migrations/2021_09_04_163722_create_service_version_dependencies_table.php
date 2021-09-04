<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceVersionDependenciesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_version_dependencies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_version_id')->unsigned();
            $table->integer('service_version_dependency_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('service_version_id','fk_service_ver_id')->references('id')->on('service_version');
            $table->foreign('service_version_dependency_id','fk_service_ver_dep_id')->references('id')->on('service_version');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('service_version_dependencies');
    }
}
