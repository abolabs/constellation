<?php

namespace Tests\APIs\v1;

use App\Models\HostingType;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use Tests\TestCase;

class HostingTypeApiTest extends TestCase
{
    use ApiTestTrait;
    use DatabaseTransactions;

    private const ROUTE_PREFIX = '/api/v1/hosting_types';

    /**
     * @test
     */
    public function test_create_hosting_type()
    {
        $hostingType = HostingType::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            self::ROUTE_PREFIX,
            $hostingType
        );

        $this->assertApiResponse($hostingType);
    }

    /**
     * @test
     */
    public function test_read_hosting_type()
    {
        $hostingType = HostingType::factory()->create();

        $this->response = $this->json(
            'GET',
            self::ROUTE_PREFIX . '/' . $hostingType->id
        );

        $this->assertApiResponse($hostingType->toArray());
    }

    /**
     * @test
     */
    public function test_update_hosting_type()
    {
        $hostingType = HostingType::factory()->create();
        $editedHostingType = HostingType::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            self::ROUTE_PREFIX . '/' . $hostingType->id,
            $editedHostingType
        );

        $this->assertApiResponse($editedHostingType);
    }

    /**
     * @test
     */
    public function test_delete_hosting_type()
    {
        $hostingType = HostingType::factory()->create();

        $this->response = $this->json(
            'DELETE',
            self::ROUTE_PREFIX . '/' . $hostingType->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            self::ROUTE_PREFIX . '/' . $hostingType->id
        );

        $this->response->assertStatus(404);
    }
}
