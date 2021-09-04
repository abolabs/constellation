<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ServiceVersion;

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
            '/api/service_versions', $serviceVersion
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
            '/api/service_versions/'.$serviceVersion->id
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
            '/api/service_versions/'.$serviceVersion->id,
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
             '/api/service_versions/'.$serviceVersion->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/service_versions/'.$serviceVersion->id
        );

        $this->response->assertStatus(404);
    }
}