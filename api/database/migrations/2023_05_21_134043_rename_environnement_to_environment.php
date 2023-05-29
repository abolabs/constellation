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
        Schema::rename('environnement', 'environment');
        Schema::table('service_instance', function (Blueprint $table) {
            $table->renameColumn('environnement_id', 'environment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('environment', 'environnement');
        Schema::table('service_instance', function (Blueprint $table) {
            $table->renameColumn('environment_id', 'environnement_id');
        });
    }
};
