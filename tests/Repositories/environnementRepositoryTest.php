<?php namespace Tests\Repositories;

use App\Models\environnement;
use App\Repositories\environnementRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class environnementRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var environnementRepository
     */
    protected $environnementRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->environnementRepo = \App::make(environnementRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_environnement()
    {
        $environnement = environnement::factory()->make()->toArray();

        $createdenvironnement = $this->environnementRepo->create($environnement);

        $createdenvironnement = $createdenvironnement->toArray();
        $this->assertArrayHasKey('id', $createdenvironnement);
        $this->assertNotNull($createdenvironnement['id'], 'Created environnement must have id specified');
        $this->assertNotNull(environnement::find($createdenvironnement['id']), 'environnement with given id must be in DB');
        $this->assertModelData($environnement, $createdenvironnement);
    }

    /**
     * @test read
     */
    public function test_read_environnement()
    {
        $environnement = environnement::factory()->create();

        $dbenvironnement = $this->environnementRepo->find($environnement->id);

        $dbenvironnement = $dbenvironnement->toArray();
        $this->assertModelData($environnement->toArray(), $dbenvironnement);
    }

    /**
     * @test update
     */
    public function test_update_environnement()
    {
        $environnement = environnement::factory()->create();
        $fakeenvironnement = environnement::factory()->make()->toArray();

        $updatedenvironnement = $this->environnementRepo->update($fakeenvironnement, $environnement->id);

        $this->assertModelData($fakeenvironnement, $updatedenvironnement->toArray());
        $dbenvironnement = $this->environnementRepo->find($environnement->id);
        $this->assertModelData($fakeenvironnement, $dbenvironnement->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_environnement()
    {
        $environnement = environnement::factory()->create();

        $resp = $this->environnementRepo->delete($environnement->id);

        $this->assertTrue($resp);
        $this->assertNull(environnement::find($environnement->id), 'environnement should not exist in DB');
    }
}
