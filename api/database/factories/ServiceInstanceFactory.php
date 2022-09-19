<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Environnement;
use App\Models\Hosting;
use App\Models\ServiceInstance;
use App\Models\ServiceVersion;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceInstanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceInstance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'application_id' => function () {
                return Application::factory()->create()->id;
            },
            'service_version_id' => function () {
                return ServiceVersion::factory()->create()->id;
            },
            'environnement_id' => function () {
                return Environnement::factory()->create()->id;
            },
            'hosting_id' => function () {
                return Hosting::factory()->create()->id;
            },
            'url' => $this->faker->url,
            'statut' => $this->faker->boolean(50), // 50% chance
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
