<?php

namespace Database\Seeders\test;

use App\Models\AppInstanceDependencies;
use Illuminate\Database\Seeder;

class AppInstanceDepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppInstanceDependencies::factory()->count(5)->create();
    }
}
