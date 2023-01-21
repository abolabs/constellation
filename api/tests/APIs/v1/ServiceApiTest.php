<?php

namespace Tests\APIs\v1;

use App\Models\Service;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\ApiTestTrait;
use Tests\TestCase;

class ServiceApiTest extends TestCase
{
    use ApiTestTrait;
    use WithoutMiddleware;
    use DatabaseTransactions;

    private const ROUTE_PREFIX = '/api/v1/services';

    /**
     * @test
     */
    public function test_create_service()
    {
        $service = Service::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            self::ROUTE_PREFIX,
            $service
        );

        $this->assertApiResponse($service);
    }

    /**
     * @test
     */
    public function test_read_service()
    {
        $service = Service::factory()->create();

        $this->response = $this->json(
            'GET',
            self::ROUTE_PREFIX . '/' . $service->id
        );

        $this->assertApiResponse($service->toArray());
    }

    /**
     * @test
     */
    public function test_update_service()
    {
        $service = Service::factory()->create();
        $editedService = Service::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            self::ROUTE_PREFIX . '/' . $service->id,
            $editedService
        );

        $this->assertApiResponse($editedService);
    }

    /**
     * @test
     */
    public function test_delete_service()
    {
        $service = Service::factory()->create();

        $this->response = $this->json(
            'DELETE',
            self::ROUTE_PREFIX . '/' . $service->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            self::ROUTE_PREFIX . '/' . $service->id
        );

        $this->response->assertStatus(404);
    }
}
