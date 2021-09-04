<?php

namespace Database\Factories;

use App\Models\AppInstance;
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
            'application_id' => $this->faker->randomDigitNotNull,
        'service_version_id' => $this->faker->randomDigitNotNull,
        'environnement_id' => $this->faker->randomDigitNotNull,
        'url' => $this->faker->word,
        'statut' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
