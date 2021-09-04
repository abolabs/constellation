<?php namespace Tests\Repositories;

use App\Models\Team;
use App\Repositories\TeamRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TeamRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TeamRepository
     */
    protected $teamRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->teamRepo = \App::make(TeamRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_team()
    {
        $team = Team::factory()->make()->toArray();

        $createdTeam = $this->teamRepo->create($team);

        $createdTeam = $createdTeam->toArray();
        $this->assertArrayHasKey('id', $createdTeam);
        $this->assertNotNull($createdTeam['id'], 'Created Team must have id specified');
        $this->assertNotNull(Team::find($createdTeam['id']), 'Team with given id must be in DB');
        $this->assertModelData($team, $createdTeam);
    }

    /**
     * @test read
     */
    public function test_read_team()
    {
        $team = Team::factory()->create();

        $dbTeam = $this->teamRepo->find($team->id);

        $dbTeam = $dbTeam->toArray();
        $this->assertModelData($team->toArray(), $dbTeam);
    }

    /**
     * @test update
     */
    public function test_update_team()
    {
        $team = Team::factory()->create();
        $fakeTeam = Team::factory()->make()->toArray();

        $updatedTeam = $this->teamRepo->update($fakeTeam, $team->id);

        $this->assertModelData($fakeTeam, $updatedTeam->toArray());
        $dbTeam = $this->teamRepo->find($team->id);
        $this->assertModelData($fakeTeam, $dbTeam->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_team()
    {
        $team = Team::factory()->create();

        $resp = $this->teamRepo->delete($team->id);

        $this->assertTrue($resp);
        $this->assertNull(Team::find($team->id), 'Team should not exist in DB');
    }
}
