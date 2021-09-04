<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AppInstanceDependencies;

class AppInstanceDependenciesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_app_instance_dependencies()
    {
        $appInstanceDependencies = AppInstanceDependencies::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/app_instance_dependencies', $appInstanceDependencies
        );

        $this->assertApiResponse($appInstanceDependencies);
    }

    /**
     * @test
     */
    public function test_read_app_instance_dependencies()
    {
        $appInstanceDependencies = AppInstanceDependencies::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/app_instance_dependencies/'.$appInstanceDependencies->id
        );

        $this->assertApiResponse($appInstanceDependencies->toArray());
    }

    /**
     * @test
     */
    public function test_update_app_instance_dependencies()
    {
        $appInstanceDependencies = AppInstanceDependencies::factory()->create();
        $editedAppInstanceDependencies = AppInstanceDependencies::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/app_instance_dependencies/'.$appInstanceDependencies->id,
            $editedAppInstanceDependencies
        );

        $this->assertApiResponse($editedAppInstanceDependencies);
    }

    /**
     * @test
     */
    public function test_delete_app_instance_dependencies()
    {
        $appInstanceDependencies = AppInstanceDependencies::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/app_instance_dependencies/'.$appInstanceDependencies->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/app_instance_dependencies/'.$appInstanceDependencies->id
        );

        $this->response->assertStatus(404);
    }
}
