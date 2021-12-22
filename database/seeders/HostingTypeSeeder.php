<?php

namespace Database\Seeders;

use App\Models\HostingType;
use Illuminate\Database\Seeder;

class HostingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hosting_types = [[
            'name'=> 'Cloud',
            'description' => 'Cloud hosting',
        ], [
            'name' => 'Dedicated server',
            'description' => 'Dedicated server hosting',
        ], [
            'name' => 'VPS',
            'description' => 'Virtual private server hosting',
        ]];

        foreach ($hosting_types as $hosting_type) {
            HostingType::create($hosting_type);
        }
    }
}
