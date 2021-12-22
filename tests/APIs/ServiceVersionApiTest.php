<?php

namespace Tests\APIs;

use App\Models\ServiceVersion;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\ApiTestTrait;
use Tests\TestCase;

class ServiceVersionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_service_version()
    {
        $serviceVersion = ServiceVersion::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/serviceVersions', $serviceVersion
        );

        $this->assertApiResponse($serviceVersion);
    }

    /**
     * @test
     */
    public function test_read_service_version()
    {
        $serviceVersion = ServiceVersion::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/serviceVersions/'.$serviceVersion->id
        );

        $this->assertApiResponse($serviceVersion->toArray());
    }

    /**
     * @test
     */
    public function test_update_service_version()
    {
        $serviceVersion = ServiceVersion::factory()->create();
        $editedServiceVersion = ServiceVersion::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/serviceVersions/'.$serviceVersion->id,
            $editedServiceVersion
        );

        $this->assertApiResponse($editedServiceVersion);
    }

    /**
     * @test
     */
    public function test_delete_service_version()
    {
        $serviceVersion = ServiceVersion::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/serviceVersions/'.$serviceVersion->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/serviceVersions/'.$serviceVersion->id
        );

        $this->response->assertStatus(404);
    }
}
