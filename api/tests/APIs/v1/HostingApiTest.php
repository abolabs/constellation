<?php

namespace Tests\APIs\v1;

use App\Models\Hosting;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\ApiTestTrait;
use Tests\TestCase;

class HostingApiTest extends TestCase
{
    use ApiTestTrait;
    use WithoutMiddleware;
    use DatabaseTransactions;

    private const ROUTE_PREFIX = '/api/v1/hostings';

    /**
     * @test
     */
    public function test_create_hosting()
    {
        $hosting = Hosting::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            self::ROUTE_PREFIX,
            $hosting
        );

        $this->assertApiResponse($hosting);
    }

    /**
     * @test
     */
    public function test_read_hosting()
    {
        $hosting = Hosting::factory()->create();

        $this->response = $this->json(
            'GET',
            self::ROUTE_PREFIX . '/' . $hosting->id
        );

        $this->assertApiResponse($hosting->toArray());
    }

    /**
     * @test
     */
    public function test_update_hosting()
    {
        $hosting = Hosting::factory()->create();
        $editedHosting = Hosting::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            self::ROUTE_PREFIX . '/' . $hosting->id,
            $editedHosting
        );

        $this->assertApiResponse($editedHosting);
    }

    /**
     * @test
     */
    public function test_delete_hosting()
    {
        $hosting = Hosting::factory()->create();

        $this->response = $this->json(
            'DELETE',
            self::ROUTE_PREFIX . '/' . $hosting->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            self::ROUTE_PREFIX . '/' . $hosting->id
        );

        $this->response->assertStatus(404);
    }
}
