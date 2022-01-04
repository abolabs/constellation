<?php

namespace Tests\APIs;

use App\Models\Environnement;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\ApiTestTrait;
use Tests\TestCase;

class EnvironnementApiTest extends TestCase
{
    use ApiTestTrait;
    use WithoutMiddleware;
    use DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_environnement()
    {
        $environnement = Environnement::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/environnements',
            $environnement
        );

        $this->assertApiResponse($environnement);
    }

    /**
     * @test
     */
    public function test_read_environnement()
    {
        $environnement = Environnement::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/environnements/' . $environnement->id
        );

        $this->assertApiResponse($environnement->toArray());
    }

    /**
     * @test
     */
    public function test_update_environnement()
    {
        $environnement = Environnement::factory()->create();
        $editedEnvironnement = Environnement::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/environnements/' . $environnement->id,
            $editedEnvironnement
        );

        $this->assertApiResponse($editedEnvironnement);
    }

    /**
     * @test
     */
    public function test_delete_environnement()
    {
        $environnement = Environnement::factory()->create();

        $this->response = $this->json(
            'DELETE',
            '/api/environnements/' . $environnement->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/environnements/' . $environnement->id
        );

        $this->response->assertStatus(404);
    }
}
