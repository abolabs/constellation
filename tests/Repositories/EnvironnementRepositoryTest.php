<?php

namespace Tests\Repositories;

use App\Models\Environnement;
use App\Repositories\EnvironnementRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use Tests\TestCase;

class EnvironnementRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var EnvironnementRepository
     */
    protected $environnementRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->environnementRepo = \App::make(EnvironnementRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_environnement()
    {
        $environnement = Environnement::factory()->make()->toArray();

        $createdEnvironnement = $this->environnementRepo->create($environnement);

        $createdEnvironnement = $createdEnvironnement->toArray();
        $this->assertArrayHasKey('id', $createdEnvironnement);
        $this->assertNotNull($createdEnvironnement['id'], 'Created Environnement must have id specified');
        $this->assertNotNull(Environnement::find($createdEnvironnement['id']), 'Environnement with given id must be in DB');
        $this->assertModelData($environnement, $createdEnvironnement);
    }

    /**
     * @test read
     */
    public function test_read_environnement()
    {
        $environnement = Environnement::factory()->create();

        $dbEnvironnement = $this->environnementRepo->find($environnement->id);

        $dbEnvironnement = $dbEnvironnement->toArray();
        $this->assertModelData($environnement->toArray(), $dbEnvironnement);
    }

    /**
     * @test update
     */
    public function test_update_environnement()
    {
        $environnement = Environnement::factory()->create();
        $fakeEnvironnement = Environnement::factory()->make()->toArray();

        $updatedEnvironnement = $this->environnementRepo->update($fakeEnvironnement, $environnement->id);

        $this->assertModelData($fakeEnvironnement, $updatedEnvironnement->toArray());
        $dbEnvironnement = $this->environnementRepo->find($environnement->id);
        $this->assertModelData($fakeEnvironnement, $dbEnvironnement->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_environnement()
    {
        $environnement = Environnement::factory()->create();

        $resp = $this->environnementRepo->delete($environnement->id);

        $this->assertTrue($resp);
        $this->assertNull(Environnement::find($environnement->id), 'Environnement should not exist in DB');
    }
}
