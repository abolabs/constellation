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
        $hosting_types = [
            [
                'name' => 'Cloud',
                'description' => 'Cloud provider',
            ], [
                'name' => 'Dedicated server',
                'description' => 'Dedicated server hosting',
            ], [
                'name' => 'VPS',
                'description' => 'Virtual private server hosting',
            ], [
                'name' => 'Saas',
                'description' => '"Software as a Service" solutions',
            ]
        ];

        foreach ($hosting_types as $hosting_type) {
            HostingType::create($hosting_type);
        }
    }
}
