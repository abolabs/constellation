<?php

namespace Tests\APIs;

use App\Models\ServiceInstance;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\ApiTestTrait;
use Tests\TestCase;

class ServiceInstanceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_service_instance()
    {
        $serviceInstance = ServiceInstance::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/service_instances', $serviceInstance
        );

        $this->assertApiResponse($serviceInstance);
    }

    /**
     * @test
     */
    public function test_read_service_instance()
    {
        $serviceInstance = ServiceInstance::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/service_instances/'.$serviceInstance->id
        );

        $this->assertApiResponse($serviceInstance->toArray());
    }

    /**
     * @test
     */
    public function test_update_service_instance()
    {
        $serviceInstance = ServiceInstance::factory()->create();
        $editedServiceInstance = ServiceInstance::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/service_instances/'.$serviceInstance->id,
            $editedServiceInstance
        );

        $this->assertApiResponse($editedServiceInstance);
    }

    /**
     * @test
     */
    public function test_delete_service_instance()
    {
        $serviceInstance = ServiceInstance::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/service_instances/'.$serviceInstance->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/service_instances/'.$serviceInstance->id
        );

        $this->response->assertStatus(404);
    }
}
