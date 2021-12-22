<?php

namespace Tests\APIs;

use App\Models\HostingType;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\ApiTestTrait;
use Tests\TestCase;

class HostingTypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_hosting_type()
    {
        $hostingType = HostingType::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hostingTypes', $hostingType
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
            '/api/hostingTypes/'.$hostingType->id
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
            '/api/hostingTypes/'.$hostingType->id,
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
             '/api/hostingTypes/'.$hostingType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hostingTypes/'.$hostingType->id
        );

        $this->response->assertStatus(404);
    }
}
