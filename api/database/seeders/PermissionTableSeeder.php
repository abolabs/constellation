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
            'app-mapping', 'service-mapping-per-app', 'service-mapping-per-host',
            'admin',
            'view audit',
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
            Permission::create(['name' => 'view ' . $entitiesPermission]);
            Permission::create(['name' => 'create ' . $entitiesPermission]);
            Permission::create(['name' => 'edit ' . $entitiesPermission]);
            Permission::create(['name' => 'delete ' . $entitiesPermission]);
        }
    }
}
