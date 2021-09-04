<?php

namespace Database\Factories;

use App\Models\AppInstanceDependencies;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppInstanceDependenciesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AppInstanceDependencies::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'instance_id' => $this->faker->randomDigitNotNull,
        'instance_dep_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
