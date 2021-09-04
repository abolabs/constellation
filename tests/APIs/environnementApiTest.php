<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\environnement;

class environnementApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_environnement()
    {
        $environnement = environnement::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/environnements', $environnement
        );

        $this->assertApiResponse($environnement);
    }

    /**
     * @test
     */
    public function test_read_environnement()
    {
        $environnement = environnement::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/environnements/'.$environnement->id
        );

        $this->assertApiResponse($environnement->toArray());
    }

    /**
     * @test
     */
    public function test_update_environnement()
    {
        $environnement = environnement::factory()->create();
        $editedenvironnement = environnement::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/environnements/'.$environnement->id,
            $editedenvironnement
        );

        $this->assertApiResponse($editedenvironnement);
    }

    /**
     * @test
     */
    public function test_delete_environnement()
    {
        $environnement = environnement::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/environnements/'.$environnement->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/environnements/'.$environnement->id
        );

        $this->response->assertStatus(404);
    }
}
