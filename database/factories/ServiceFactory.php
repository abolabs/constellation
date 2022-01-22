<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'team_id' => function () {
                return Team::factory()->create()->id;
            },
            'name' => "Service ".$this->faker->word,
            'git_repo' => $this->faker->randomElement(['http://', 'https://']) . $this->faker->domainName . '/',
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
