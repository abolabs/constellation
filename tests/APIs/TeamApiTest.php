<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Team;

class TeamApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_team()
    {
        $team = Team::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/teams', $team
        );

        $this->assertApiResponse($team);
    }

    /**
     * @test
     */
    public function test_read_team()
    {
        $team = Team::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/teams/'.$team->id
        );

        $this->assertApiResponse($team->toArray());
    }

    /**
     * @test
     */
    public function test_update_team()
    {
        $team = Team::factory()->create();
        $editedTeam = Team::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/teams/'.$team->id,
            $editedTeam
        );

        $this->assertApiResponse($editedTeam);
    }

    /**
     * @test
     */
    public function test_delete_team()
    {
        $team = Team::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/teams/'.$team->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/teams/'.$team->id
        );

        $this->response->assertStatus(404);
    }
}
