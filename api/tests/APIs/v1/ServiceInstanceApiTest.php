<?php

namespace Tests\APIs\v1;

use App\Models\ServiceInstance;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use Tests\TestCase;

class ServiceInstanceApiTest extends TestCase
{
    use ApiTestTrait;
    use DatabaseTransactions;

    private const ROUTE_PREFIX = '/api/v1/service_instances';

    /**
     * @test
     */
    public function test_create_service_instance()
    {
        $serviceInstance = ServiceInstance::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            self::ROUTE_PREFIX,
            $serviceInstance
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
            self::ROUTE_PREFIX . '/' . $serviceInstance->id
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
            self::ROUTE_PREFIX . '/' . $serviceInstance->id,
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
            self::ROUTE_PREFIX . '/' . $serviceInstance->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            self::ROUTE_PREFIX . '/' . $serviceInstance->id
        );

        $this->response->assertStatus(404);
    }
}
