<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Application;

class ApplicationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_application()
    {
        $application = Application::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/applications', $application
        );

        $this->assertApiResponse($application);
    }

    /**
     * @test
     */
    public function test_read_application()
    {
        $application = Application::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/applications/'.$application->id
        );

        $this->assertApiResponse($application->toArray());
    }

    /**
     * @test
     */
    public function test_update_application()
    {
        $application = Application::factory()->create();
        $editedApplication = Application::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/applications/'.$application->id,
            $editedApplication
        );

        $this->assertApiResponse($editedApplication);
    }

    /**
     * @test
     */
    public function test_delete_application()
    {
        $application = Application::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/applications/'.$application->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/applications/'.$application->id
        );

        $this->response->assertStatus(404);
    }
}
