<?php

namespace Database\Seeders;

use Database\Seeders\test\ServiceInstanceDepSeeder;
use Database\Seeders\test\ServiceVersionDepSeeder;
use Illuminate\Database\Seeder;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ServiceInstanceDepSeeder::class,
            ServiceVersionDepSeeder::class
        ]);
    }
}
