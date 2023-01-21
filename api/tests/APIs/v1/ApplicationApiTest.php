<?php

namespace Tests\APIs\v1;

use App\Models\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\ApiTestTrait;
use Tests\TestCase;

class ApplicationApiTest extends TestCase
{
    use ApiTestTrait;
    use WithoutMiddleware;
    use DatabaseTransactions;

    private const ROUTE_PREFIX = '/api/v1/applications';

    /**
     * @test
     */
    public function test_create_application()
    {
        $application = Application::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            self::ROUTE_PREFIX,
            $application
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
            self::ROUTE_PREFIX . '/' . $application->id
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
            self::ROUTE_PREFIX . '/' . $application->id,
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
            self::ROUTE_PREFIX . '/' . $application->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            self::ROUTE_PREFIX . '/' . $application->id
        );

        $this->response->assertStatus(404);
    }
}
