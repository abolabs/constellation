<?php

namespace Tests\APIs\v1;

use App\Models\ServiceInstanceDependencies;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\ApiTestTrait;
use Tests\TestCase;

class ServiceInstanceDependenciesApiTest extends TestCase
{
    use ApiTestTrait;
    use WithoutMiddleware;
    use DatabaseTransactions;

    private const ROUTE_PREFIX = '/api/v1/service_instance_dependencies';

    /**
     * @test
     */
    public function test_create_serviceInstanceDependencies()
    {
        $serviceInstanceDependencies = ServiceInstanceDependencies::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            self::ROUTE_PREFIX,
            $serviceInstanceDependencies
        );

        $this->assertApiResponse($serviceInstanceDependencies);
    }

    /**
     * @test
     */
    public function test_read_serviceInstanceDependencies()
    {
        $serviceInstanceDependencies = ServiceInstanceDependencies::factory()->create();

        $this->response = $this->json(
            'GET',
            self::ROUTE_PREFIX . '/' . $serviceInstanceDependencies->id
        );

        $this->assertApiResponse($serviceInstanceDependencies->toArray());
    }

    /**
     * @test
     */
    public function test_update_serviceInstanceDependencies()
    {
        $serviceInstanceDependencies = ServiceInstanceDependencies::factory()->create();
        $editedServiceInstanceDependencies = ServiceInstanceDependencies::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            self::ROUTE_PREFIX . '/' . $serviceInstanceDependencies->id,
            $editedServiceInstanceDependencies
        );

        $this->assertApiResponse($editedServiceInstanceDependencies);
    }

    /**
     * @test
     */
    public function test_delete_serviceInstanceDependencies()
    {
        $serviceInstanceDependencies = ServiceInstanceDependencies::factory()->create();

        $this->response = $this->json(
            'DELETE',
            self::ROUTE_PREFIX . '/' . $serviceInstanceDependencies->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            self::ROUTE_PREFIX . '/' . $serviceInstanceDependencies->id
        );

        $this->response->assertStatus(404);
    }
}
