<?php namespace Tests\Repositories;

use App\Models\ServiceVersionDependencies;
use App\Repositories\ServiceVersionDependenciesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ServiceVersionDependenciesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ServiceVersionDependenciesRepository
     */
    protected $serviceVersionDependenciesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->serviceVersionDependenciesRepo = \App::make(ServiceVersionDependenciesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_service_version_dependencies()
    {
        $serviceVersionDependencies = ServiceVersionDependencies::factory()->make()->toArray();

        $createdServiceVersionDependencies = $this->serviceVersionDependenciesRepo->create($serviceVersionDependencies);

        $createdServiceVersionDependencies = $createdServiceVersionDependencies->toArray();
        $this->assertArrayHasKey('id', $createdServiceVersionDependencies);
        $this->assertNotNull($createdServiceVersionDependencies['id'], 'Created ServiceVersionDependencies must have id specified');
        $this->assertNotNull(ServiceVersionDependencies::find($createdServiceVersionDependencies['id']), 'ServiceVersionDependencies with given id must be in DB');
        $this->assertModelData($serviceVersionDependencies, $createdServiceVersionDependencies);
    }

    /**
     * @test read
     */
    public function test_read_service_version_dependencies()
    {
        $serviceVersionDependencies = ServiceVersionDependencies::factory()->create();

        $dbServiceVersionDependencies = $this->serviceVersionDependenciesRepo->find($serviceVersionDependencies->id);

        $dbServiceVersionDependencies = $dbServiceVersionDependencies->toArray();
        $this->assertModelData($serviceVersionDependencies->toArray(), $dbServiceVersionDependencies);
    }

    /**
     * @test update
     */
    public function test_update_service_version_dependencies()
    {
        $serviceVersionDependencies = ServiceVersionDependencies::factory()->create();
        $fakeServiceVersionDependencies = ServiceVersionDependencies::factory()->make()->toArray();

        $updatedServiceVersionDependencies = $this->serviceVersionDependenciesRepo->update($fakeServiceVersionDependencies, $serviceVersionDependencies->id);

        $this->assertModelData($fakeServiceVersionDependencies, $updatedServiceVersionDependencies->toArray());
        $dbServiceVersionDependencies = $this->serviceVersionDependenciesRepo->find($serviceVersionDependencies->id);
        $this->assertModelData($fakeServiceVersionDependencies, $dbServiceVersionDependencies->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_service_version_dependencies()
    {
        $serviceVersionDependencies = ServiceVersionDependencies::factory()->create();

        $resp = $this->serviceVersionDependenciesRepo->delete($serviceVersionDependencies->id);

        $this->assertTrue($resp);
        $this->assertNull(ServiceVersionDependencies::find($serviceVersionDependencies->id), 'ServiceVersionDependencies should not exist in DB');
    }
}
