<?php namespace Tests\Repositories;

use App\Models\AppInstanceDependencies;
use App\Repositories\AppInstanceDependenciesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AppInstanceDependenciesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AppInstanceDependenciesRepository
     */
    protected $appInstanceDependenciesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->appInstanceDependenciesRepo = \App::make(AppInstanceDependenciesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_app_instance_dependencies()
    {
        $appInstanceDependencies = AppInstanceDependencies::factory()->make()->toArray();

        $createdAppInstanceDependencies = $this->appInstanceDependenciesRepo->create($appInstanceDependencies);

        $createdAppInstanceDependencies = $createdAppInstanceDependencies->toArray();
        $this->assertArrayHasKey('id', $createdAppInstanceDependencies);
        $this->assertNotNull($createdAppInstanceDependencies['id'], 'Created AppInstanceDependencies must have id specified');
        $this->assertNotNull(AppInstanceDependencies::find($createdAppInstanceDependencies['id']), 'AppInstanceDependencies with given id must be in DB');
        $this->assertModelData($appInstanceDependencies, $createdAppInstanceDependencies);
    }

    /**
     * @test read
     */
    public function test_read_app_instance_dependencies()
    {
        $appInstanceDependencies = AppInstanceDependencies::factory()->create();

        $dbAppInstanceDependencies = $this->appInstanceDependenciesRepo->find($appInstanceDependencies->id);

        $dbAppInstanceDependencies = $dbAppInstanceDependencies->toArray();
        $this->assertModelData($appInstanceDependencies->toArray(), $dbAppInstanceDependencies);
    }

    /**
     * @test update
     */
    public function test_update_app_instance_dependencies()
    {
        $appInstanceDependencies = AppInstanceDependencies::factory()->create();
        $fakeAppInstanceDependencies = AppInstanceDependencies::factory()->make()->toArray();

        $updatedAppInstanceDependencies = $this->appInstanceDependenciesRepo->update($fakeAppInstanceDependencies, $appInstanceDependencies->id);

        $this->assertModelData($fakeAppInstanceDependencies, $updatedAppInstanceDependencies->toArray());
        $dbAppInstanceDependencies = $this->appInstanceDependenciesRepo->find($appInstanceDependencies->id);
        $this->assertModelData($fakeAppInstanceDependencies, $dbAppInstanceDependencies->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_app_instance_dependencies()
    {
        $appInstanceDependencies = AppInstanceDependencies::factory()->create();

        $resp = $this->appInstanceDependenciesRepo->delete($appInstanceDependencies->id);

        $this->assertTrue($resp);
        $this->assertNull(AppInstanceDependencies::find($appInstanceDependencies->id), 'AppInstanceDependencies should not exist in DB');
    }
}
