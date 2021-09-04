<?php

namespace Database\Factories;

use App\Models\Hosting;
use Illuminate\Database\Eloquent\Factories\Factory;

class HostingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hosting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'hosting_type_id' => $this->faker->randomDigitNotNull,
        'localisation' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
