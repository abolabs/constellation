<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           'app-mapping','service-mapping-per-app','service-mapping-per-host',
           'admin',
           'view audit'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $entities = [
            'application',
            'user',
            'hostingType',
            'hosting',
            'service',
            'serviceVersion',
            'serviceVersionDep',
            'serviceInstance',
            'serviceInstanceDep',
            'environnement',
            'team',
        ];

        foreach ($entities as $entitiesPermission) {
            Permission::create(['name' => "view ".$entitiesPermission]);
            Permission::create(['name' => "create ".$entitiesPermission]);
            Permission::create(['name' => "edit ".$entitiesPermission]);
            Permission::create(['name' => "delete ".$entitiesPermission]);
        }
    }
}
