<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AppInstance;

class AppInstanceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_app_instance()
    {
        $appInstance = AppInstance::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/app_instances', $appInstance
        );

        $this->assertApiResponse($appInstance);
    }

    /**
     * @test
     */
    public function test_read_app_instance()
    {
        $appInstance = AppInstance::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/app_instances/'.$appInstance->id
        );

        $this->assertApiResponse($appInstance->toArray());
    }

    /**
     * @test
     */
    public function test_update_app_instance()
    {
        $appInstance = AppInstance::factory()->create();
        $editedAppInstance = AppInstance::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/app_instances/'.$appInstance->id,
            $editedAppInstance
        );

        $this->assertApiResponse($editedAppInstance);
    }

    /**
     * @test
     */
    public function test_delete_app_instance()
    {
        $appInstance = AppInstance::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/app_instances/'.$appInstance->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/app_instances/'.$appInstance->id
        );

        $this->response->assertStatus(404);
    }
}
