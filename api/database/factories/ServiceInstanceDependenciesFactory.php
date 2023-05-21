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

namespace Database\Factories;

use App\Models\ServiceInstance;
use App\Models\ServiceInstanceDependencies;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceInstanceDependenciesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceInstanceDependencies::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sourceService = ServiceInstance::factory()->create();
        $targetService = ServiceInstance::factory()->create([
            'environment_id' => $sourceService->environment_id,
        ]);

        return [
            'instance_id' => function () use ($sourceService) {
                return $sourceService->id;
            },
            'instance_dep_id' => function () use ($targetService) {
                return $targetService->id;
            },
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
