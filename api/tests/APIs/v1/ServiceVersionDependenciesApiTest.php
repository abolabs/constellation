<?php

namespace Tests\APIs\v1;

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

    private const ROUTE_PREFIX = '/api/v1/service_version_dependencies';

    /**
     * @test
     */
    public function test_create_service_version_dependencies()
    {
        $serviceVersionDependencies = ServiceVersionDependencies::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            self::ROUTE_PREFIX,
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
            self::ROUTE_PREFIX.'/'.$serviceVersionDependencies->id
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
            self::ROUTE_PREFIX.'/'.$serviceVersionDependencies->id,
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
            self::ROUTE_PREFIX.'/'.$serviceVersionDependencies->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            self::ROUTE_PREFIX.'/'.$serviceVersionDependencies->id
        );

        $this->response->assertStatus(404);
    }
}
