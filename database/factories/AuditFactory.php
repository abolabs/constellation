<?php

namespace Database\Factories;

use App\Models\Audit;
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
            'user_id' => $this->faker->word,
            'event' => $this->faker->word,
            'auditable_type' => $this->faker->word,
            'auditable_id' => $this->faker->word,
            'old_values' => $this->faker->text,
            'new_values' => $this->faker->text,
            'url' => $this->faker->text,
            'ip_address' => $this->faker->word,
            'user_agent' => $this->faker->word,
            'tags' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
