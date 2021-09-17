<?php

namespace Database\Factories;

use App\Models\AppInstance;
use App\Models\Application;
use App\Models\Environnement;
use App\Models\ServiceVersion;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppInstanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AppInstance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'application_id' => Application::factory()->create()->id,
            'service_version_id' => ServiceVersion::factory()->create()->id,
            'environnement_id' => Environnement::factory()->create()->id,
            'url' => $this->faker->url,
            'statut' => $this->faker->boolean(50), // 50% chance
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
