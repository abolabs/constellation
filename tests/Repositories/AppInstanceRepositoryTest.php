<?php namespace Tests\Repositories;

use App\Models\AppInstance;
use App\Repositories\AppInstanceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AppInstanceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AppInstanceRepository
     */
    protected $appInstanceRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->appInstanceRepo = \App::make(AppInstanceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_app_instance()
    {
        $appInstance = AppInstance::factory()->make()->toArray();

        $createdAppInstance = $this->appInstanceRepo->create($appInstance);

        $createdAppInstance = $createdAppInstance->toArray();
        $this->assertArrayHasKey('id', $createdAppInstance);
        $this->assertNotNull($createdAppInstance['id'], 'Created AppInstance must have id specified');
        $this->assertNotNull(AppInstance::find($createdAppInstance['id']), 'AppInstance with given id must be in DB');
        $this->assertModelData($appInstance, $createdAppInstance);
    }

    /**
     * @test read
     */
    public function test_read_app_instance()
    {
        $appInstance = AppInstance::factory()->create();

        $dbAppInstance = $this->appInstanceRepo->find($appInstance->id);

        $dbAppInstance = $dbAppInstance->toArray();
        $this->assertModelData($appInstance->toArray(), $dbAppInstance);
    }

    /**
     * @test update
     */
    public function test_update_app_instance()
    {
        $appInstance = AppInstance::factory()->create();
        $fakeAppInstance = AppInstance::factory()->make()->toArray();

        $updatedAppInstance = $this->appInstanceRepo->update($fakeAppInstance, $appInstance->id);

        $this->assertModelData($fakeAppInstance, $updatedAppInstance->toArray());
        $dbAppInstance = $this->appInstanceRepo->find($appInstance->id);
        $this->assertModelData($fakeAppInstance, $dbAppInstance->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_app_instance()
    {
        $appInstance = AppInstance::factory()->create();

        $resp = $this->appInstanceRepo->delete($appInstance->id);

        $this->assertTrue($resp);
        $this->assertNull(AppInstance::find($appInstance->id), 'AppInstance should not exist in DB');
    }
}
