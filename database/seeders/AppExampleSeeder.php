<?php

namespace Database\Seeders;

use App\Models\{
    AppInstance,
    AppInstanceDependencies,
    Application,
    Team,Service,
    ServiceVersion,
    Environnement
};
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
        $application = Application::create([
            'name' => 'Example Laravel App',
            'team_id' => Team::first()->id
        ]);

        $envs = [
            'Dev' => Environnement::where('name','Dev')->first()->id,
            'Staging' => Environnement::where('name','Staging')->first()->id,
            'Production' => Environnement::where('name','Production')->first()->id
        ];

        // Mariadb
        $service = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'Mariadb',
            'git_repo' => 'https://github.com/MariaDB/server'
        ]);

        $serviceVersion = ServiceVersion::create([
            'service_id' => $service->id,
            'version' => 10.3
        ]);

        $mariadbInstances = [];
        foreach($envs as $envName => $env){
            // Master
            $mariadbInstance = AppInstance::factory()->create([
                'application_id' => $application->id,
                'service_version_id' => $serviceVersion->id,
                'environnement_id' => $env,
                'statut' => 1
            ]);
            $mariadbInstances[$envName] = $mariadbInstance->id;

            // Slave
            $mariadbInstanceSlave = AppInstance::factory()->create([
                'application_id' => $application->id,
                'service_version_id' => $serviceVersion->id,
                'environnement_id' => $env,
                'statut' => 1
            ]);
            AppInstanceDependencies::create([
                'instance_id' => $mariadbInstanceSlave->id,
                'instance_dep_id' => $mariadbInstance->id
            ]);
        }

        // Redis
        $service = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'Redis',
            'git_repo' => 'https://github.com/redis/redis'
        ]);

        $serviceVersion = ServiceVersion::create([
            'service_id' => $service->id,
            'version' => 6.2
        ]);

        $redisInstances = [];
        foreach($envs as $envName => $env){
            $redisInstance = AppInstance::factory()->create([
                'application_id' => $application->id,
                'service_version_id' => $serviceVersion->id,
                'environnement_id' => $env,
                'statut' => 1
            ]);
            $redisInstances[$envName] = $redisInstance->id;
        }

        // Backoffice Laravel
        $service = Service::create([
            'team_id' => Team::first()->id,
            'name' => 'Laravel Example',
            'git_repo' => 'https://github.com/laravel/quickstart-basic'
        ]);

        $serviceVersion = ServiceVersion::create([
            'service_id' => $service->id,
            'version' => 1.0
        ]);

        foreach($envs as $envName => $env){
            $laraApp = AppInstance::factory()->create([
                'application_id' => $application->id,
                'service_version_id' => $serviceVersion->id,
                'environnement_id' => $env,
                'statut' => 1
            ]);

            // Mariadb Dependency
            AppInstanceDependencies::create([
                'instance_id' => $laraApp->id,
                'instance_dep_id' => $mariadbInstances[$envName]
            ]);

            // Redis Dependency
            AppInstanceDependencies::create([
                'instance_id' => $laraApp->id,
                'instance_dep_id' => $redisInstances[$envName]
            ]);
        }
    }
}
