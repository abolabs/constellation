<?php

namespace Tests\APIs;

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

    /**
     * @test
     */
    public function test_create_hosting()
    {
        $hosting = Hosting::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hostings',
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
            '/api/hostings/' . $hosting->id
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
            '/api/hostings/' . $hosting->id,
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
            '/api/hostings/' . $hosting->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hostings/' . $hosting->id
        );

        $this->response->assertStatus(404);
    }
}
