<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('service_instance', function (Blueprint $table) {
            $table->dropForeign('service_instance_application_id_foreign');
            $table->foreign('application_id')->references('id')->on('application')->onDelete('cascade');
        });
        Schema::table('service_instance_dep', function (Blueprint $table) {
            $table->dropForeign('service_instance_dep_instance_id_foreign');
            $table->dropForeign('service_instance_dep_instance_dep_id_foreign');

            $table->foreign('instance_id')->references('id')->on('service_instance')->onDelete('cascade');
            $table->foreign('instance_dep_id')->references('id')->on('service_instance')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
