<?php

namespace Tests\APIs;

use App\Models\ServiceVersionDependencies;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\ApiTestTrait;
use Tests\TestCase;

class ServiceVersionDependenciesApiTest extends TestCase
{
    use ApiTestTrait;
    use WithoutMiddleware;
    use DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_service_version_dependencies()
    {
        $serviceVersionDependencies = ServiceVersionDependencies::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/service_version_dependencies',
            $serviceVersionDependencies
        );

        $this->assertApiResponse($serviceVersionDependencies);
    }

    /**
     * @test
     */
    public function test_read_service_version_dependencies()
    {
        $serviceVersionDependencies = ServiceVersionDependencies::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/service_version_dependencies/' . $serviceVersionDependencies->id
        );

        $this->assertApiResponse($serviceVersionDependencies->toArray());
    }

    /**
     * @test
     */
    public function test_update_service_version_dependencies()
    {
        $serviceVersionDependencies = ServiceVersionDependencies::factory()->create();
        $editedServiceVersionDependencies = ServiceVersionDependencies::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/service_version_dependencies/' . $serviceVersionDependencies->id,
            $editedServiceVersionDependencies
        );

        $this->assertApiResponse($editedServiceVersionDependencies);
    }

    /**
     * @test
     */
    public function test_delete_service_version_dependencies()
    {
        $serviceVersionDependencies = ServiceVersionDependencies::factory()->create();

        $this->response = $this->json(
            'DELETE',
            '/api/service_version_dependencies/' . $serviceVersionDependencies->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/service_version_dependencies/' . $serviceVersionDependencies->id
        );

        $this->response->assertStatus(404);
    }
}
