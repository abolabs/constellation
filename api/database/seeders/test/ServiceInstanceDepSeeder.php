<?php

namespace Database\Seeders\test;

use App\Models\ServiceInstanceDependencies;
use Illuminate\Database\Seeder;

class ServiceInstanceDepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceInstanceDependencies::factory()->count(5)->create();
    }
}
