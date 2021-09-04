<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\HostingType;

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
            '/api/hosting_types', $hostingType
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
            '/api/hosting_types/'.$hostingType->id
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
            '/api/hosting_types/'.$hostingType->id,
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
             '/api/hosting_types/'.$hostingType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hosting_types/'.$hostingType->id
        );

        $this->response->assertStatus(404);
    }
}
