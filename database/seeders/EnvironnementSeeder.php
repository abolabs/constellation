<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Environnement;

class EnvironnementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $envs = ['Dev','Staging','Production'];
        foreach($envs as $env){
            Environnement::create([
                'name' => $env
            ]);
        }
    }
}
