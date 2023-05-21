<?php

namespace Tests\APIs\v1;

use App\Models\Environment;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\ApiTestTrait;
use Tests\TestCase;

class EnvironmentApiTest extends TestCase
{
    use ApiTestTrait;
    use WithoutMiddleware;
    use DatabaseTransactions;

    private const ROUTE_PREFIX = '/api/v1/environments';

    /**
     * @test
     */
    public function test_create_environment()
    {
        $environment = Environment::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            self::ROUTE_PREFIX,
            $environment
        );

        $this->assertApiResponse($environment);
    }

    /**
     * @test
     */
    public function test_read_environment()
    {
        $environment = Environment::factory()->create();

        $this->response = $this->json(
            'GET',
            self::ROUTE_PREFIX.'/'.$environment->id
        );

        $this->assertApiResponse($environment->toArray());
    }

    /**
     * @test
     */
    public function test_update_environment()
    {
        $environment = Environment::factory()->create();
        $editedEnvironment = Environment::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            self::ROUTE_PREFIX.'/'.$environment->id,
            $editedEnvironment
        );

        $this->assertApiResponse($editedEnvironment);
    }

    /**
     * @test
     */
    public function test_delete_environment()
    {
        $environment = Environment::factory()->create();

        $this->response = $this->json(
            'DELETE',
            self::ROUTE_PREFIX.'/'.$environment->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            self::ROUTE_PREFIX.'/'.$environment->id
        );

        $this->response->assertStatus(404);
    }
}
