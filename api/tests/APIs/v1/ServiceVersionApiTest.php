<?php

namespace Tests\APIs\v1;

use App\Models\ServiceVersion;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use Tests\TestCase;

class ServiceVersionApiTest extends TestCase
{
    use ApiTestTrait;
    use DatabaseTransactions;

    private const ROUTE_PREFIX = '/api/v1/service_versions';

    /**
     * @test
     */
    public function test_create_service_version()
    {
        $serviceVersion = ServiceVersion::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            self::ROUTE_PREFIX,
            $serviceVersion
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
            self::ROUTE_PREFIX . '/' . $serviceVersion->id
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
            self::ROUTE_PREFIX . '/' . $serviceVersion->id,
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
            self::ROUTE_PREFIX . '/' . $serviceVersion->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            self::ROUTE_PREFIX . '/' . $serviceVersion->id
        );

        $this->response->assertStatus(404);
    }
}
