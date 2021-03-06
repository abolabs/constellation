<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\ServiceVersion;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceVersionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceVersion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'service_id' => function () {
                return Service::factory()->create()->id;
            },
            'version' => $this->faker->randomFloat(1, 1, 15),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
