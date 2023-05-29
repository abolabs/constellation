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
            'app-mapping',              // Allow to view mapping per app
            'service-mapping-per-app',  // Allow to view mapping per app <-> service
            'service-mapping-per-host', // Allow to view mapping per host <-> service
            'admin',                    // Allow to access to admin menu
            'view audits',               // Allow to access to audit logs
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $entities = [
            'applications',
            'users',
            'hosting_types',
            'hostings',
            'services',
            'service_versions',
            'service_instances',
            'service_instance_dependencies',
            'environments',
            'teams',
            'roles',
        ];

        foreach ($entities as $entity) {
            // For each resource allow to...
            Permission::firstOrCreate(['name' => 'view ' . $entity]);      // ... view entities
            Permission::firstOrCreate(['name' => 'create ' . $entity]);    // ... create new entities
            Permission::firstOrCreate(['name' => 'edit ' . $entity]);      // ... edit an existing entity
            Permission::firstOrCreate(['name' => 'delete ' . $entity]);    // ... delete an existing entity
        }
    }
}
