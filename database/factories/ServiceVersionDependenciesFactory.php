<?php

namespace Database\Factories;

use App\Models\ServiceVersionDependencies;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceVersionDependenciesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceVersionDependencies::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'service_version_id' => $this->faker->randomDigitNotNull,
        'service_version_dependency_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
