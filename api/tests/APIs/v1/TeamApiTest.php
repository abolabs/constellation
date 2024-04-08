<?php

namespace Tests\APIs\v1;

use App\Models\Team;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use Tests\TestCase;

class TeamApiTest extends TestCase
{
    use ApiTestTrait;
    use DatabaseTransactions;

    private const ROUTE_PREFIX = '/api/v1/teams';

    /**
     * @test
     */
    public function test_create_team()
    {
        $team = Team::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            self::ROUTE_PREFIX,
            $team
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
            self::ROUTE_PREFIX . '/' . $team->id
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
            self::ROUTE_PREFIX . '/' . $team->id,
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
            self::ROUTE_PREFIX . '/' . $team->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            self::ROUTE_PREFIX . '/' . $team->id
        );

        $this->response->assertStatus(404);
    }
}
