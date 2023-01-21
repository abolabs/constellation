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

use App\Models\Audit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Audit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_type' => $this->faker->word,
            'user_id' =>  function () {
                return User::factory()->create()->id;
            },
            'event' => $this->faker->word,
            'auditable_type' => $this->faker->word,
            'auditable_id' => $this->faker->numberBetween(1, 1000),
            'old_values' => $this->faker->text,
            'new_values' => $this->faker->text,
            'url' => $this->faker->text,
            'ip_address' => $this->faker->ipv4,
            'user_agent' => $this->faker->word,
            'tags' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
