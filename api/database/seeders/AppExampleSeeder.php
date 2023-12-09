<?php

// Copyright (C) 2022 Abolabs (https://gitlab.com/abolabs/)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Environment;
use App\Models\Service;
use App\Models\ServiceInstance;
use App\Models\ServiceInstanceDependencies;
use App\Models\ServiceVersion;
use App\Models\Team;
use Illuminate\Database\Seeder;

class AppExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $application = Application::factory()->create();

        $envs = [
            'Production' => Environment::where('name', 'Production')->first()->id,
            'Staging' => Environment::where('name', 'Staging')->first()->id,
            'Dev' => Environment::where('name', 'Dev')->first()->id,
        ];

        // Mariadb
        $service = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'Mariadb',
            'git_repo' => 'https://github.com/MariaDB/server',
        ]);

        $serviceVersion = ServiceVersion::create([
            'service_id' => $service->id,
            'version' => 10.3,
        ]);

        $mariadbInstances = [];
        foreach ($envs as $envName => $env) {
            // Master
            $mariadbInstance = ServiceInstance::factory()->create([
                'application_id' => $application->id,
                'service_version_id' => $serviceVersion->id,
                'environment_id' => $env,
                'statut' => 1,
            ]);
            $mariadbInstances[$envName] = $mariadbInstance->id;

            // Slave
            $mariadbInstanceSlave = ServiceInstance::factory()->create([
                'application_id' => $application->id,
                'service_version_id' => $serviceVersion->id,
                'environment_id' => $env,
                'statut' => 1,
            ]);
            ServiceInstanceDependencies::create([
                'instance_id' => $mariadbInstanceSlave->id,
                'instance_dep_id' => $mariadbInstance->id,
            ]);
        }

        // Redis
        $service = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'Redis',
            'git_repo' => 'https://github.com/redis/redis',
        ]);

        $serviceVersion = ServiceVersion::create([
            'service_id' => $service->id,
            'version' => 6.2,
        ]);

        $redisInstances = [];
        foreach ($envs as $envName => $env) {
            $redisInstance = ServiceInstance::factory()->create([
                'application_id' => $application->id,
                'service_version_id' => $serviceVersion->id,
                'environment_id' => $env,
                'statut' => 1,
            ]);
            $redisInstances[$envName] = $redisInstance->id;
        }

        // Backoffice Laravel
        $service = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'Laravel Example',
            'git_repo' => 'https://github.com/laravel/quickstart-basic',
        ]);

        $serviceVersion = ServiceVersion::create([
            'service_id' => $service->id,
            'version' => 1.0,
        ]);

        foreach ($envs as $envName => $env) {
            $laraApp = ServiceInstance::factory()->create([
                'application_id' => $application->id,
                'service_version_id' => $serviceVersion->id,
                'environment_id' => $env,
                'statut' => 1,
            ]);

            // Mariadb Dependency
            ServiceInstanceDependencies::create([
                'instance_id' => $laraApp->id,
                'instance_dep_id' => $mariadbInstances[$envName],
            ]);

            // Redis Dependency
            ServiceInstanceDependencies::create([
                'instance_id' => $laraApp->id,
                'instance_dep_id' => $redisInstances[$envName],
            ]);
        }
    }
}
