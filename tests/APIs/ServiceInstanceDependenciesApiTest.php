<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ServiceInstanceDependencies;

class ServiceInstanceDependenciesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_serviceInstanceDependencies()
    {
        $serviceInstanceDependencies = ServiceInstanceDependencies::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/serviceInstanceDependencies', $serviceInstanceDependencies
        );

        $this->assertApiResponse($serviceInstanceDependencies);
    }

    /**
     * @test
     */
    public function test_read_serviceInstanceDependencies()
    {
        $serviceInstanceDependencies = ServiceInstanceDependencies::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/serviceInstanceDependencies/'.$serviceInstanceDependencies->id
        );

        $this->assertApiResponse($serviceInstanceDependencies->toArray());
    }

    /**
     * @test
     */
    public function test_update_serviceInstanceDependencies()
    {
        $serviceInstanceDependencies = ServiceInstanceDependencies::factory()->create();
        $editedServiceInstanceDependencies = ServiceInstanceDependencies::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/serviceInstanceDependencies/'.$serviceInstanceDependencies->id,
            $editedServiceInstanceDependencies
        );

        $this->assertApiResponse($editedServiceInstanceDependencies);
    }

    /**
     * @test
     */
    public function test_delete_serviceInstanceDependencies()
    {
        $serviceInstanceDependencies = ServiceInstanceDependencies::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/serviceInstanceDependencies/'.$serviceInstanceDependencies->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/serviceInstanceDependencies/'.$serviceInstanceDependencies->id
        );

        $this->response->assertStatus(404);
    }
}
