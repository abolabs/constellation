<?php

namespace Tests\APIs;

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

    /**
     * @test
     */
    public function test_create_service()
    {
        $service = Service::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/services',
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
            '/api/services/' . $service->id
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
            '/api/services/' . $service->id,
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
            '/api/services/' . $service->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/services/' . $service->id
        );

        $this->response->assertStatus(404);
    }
}
