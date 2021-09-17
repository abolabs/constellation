<?php

namespace Database\Seeders\test;

use App\Models\ServiceVersionDependencies;
use Illuminate\Database\Seeder;

class ServiceVersionDepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceVersionDependencies::factory()->count(5)->create();
    }
}
