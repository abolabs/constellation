<?php

namespace Database\Factories;

use App\Models\ServiceInstance;
use App\Models\ServiceInstanceDependencies;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceInstanceDependenciesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceInstanceDependencies::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sourceService = ServiceInstance::factory()->create();
        $targetService = ServiceInstance::factory()->create([
            'environnement_id' => $sourceService->environnement_id,
        ]);

        return [
            'instance_id' => function () use ($sourceService) {
                return $sourceService->id;
            },
            'instance_dep_id' => function () use ($targetService) {
                return $targetService->id;
            },
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
