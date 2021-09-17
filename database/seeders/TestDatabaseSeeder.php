<?php

namespace Database\Seeders;

use Database\Seeders\test\AppInstanceDepSeeder;
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
            AppInstanceDepSeeder::class,
            ServiceVersionDepSeeder::class
        ]);
    }
}
