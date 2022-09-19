<?php

namespace Database\Seeders;

use App\Models\Environnement;
use Illuminate\Database\Seeder;

class EnvironnementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $envs = ['Dev', 'Staging', 'Production'];
        foreach ($envs as $env) {
            Environnement::create([
                'name' => $env,
            ]);
        }
    }
}
