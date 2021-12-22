<?php

namespace Tests\Repositories;

use App\Models\ServiceInstance;
use App\Repositories\ServiceInstanceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use Tests\TestCase;

class ServiceInstanceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ServiceInstanceRepository
     */
    protected $serviceInstanceRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->serviceInstanceRepo = \App::make(ServiceInstanceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_service_instance()
    {
        $serviceInstance = ServiceInstance::factory()->make()->toArray();

        $createdServiceInstance = $this->serviceInstanceRepo->create($serviceInstance);

        $createdServiceInstance = $createdServiceInstance->toArray();
        $this->assertArrayHasKey('id', $createdServiceInstance);
        $this->assertNotNull($createdServiceInstance['id'], 'Created ServiceInstance must have id specified');
        $this->assertNotNull(ServiceInstance::find($createdServiceInstance['id']), 'ServiceInstance with given id must be in DB');
        $this->assertModelData($serviceInstance, $createdServiceInstance);
    }

    /**
     * @test read
     */
    public function test_read_service_instance()
    {
        $serviceInstance = ServiceInstance::factory()->create();

        $dbServiceInstance = $this->serviceInstanceRepo->find($serviceInstance->id);

        $dbServiceInstance = $dbServiceInstance->toArray();
        $this->assertModelData($serviceInstance->toArray(), $dbServiceInstance);
    }

    /**
     * @test update
     */
    public function test_update_service_instance()
    {
        $serviceInstance = ServiceInstance::factory()->create();
        $fakeServiceInstance = ServiceInstance::factory()->make()->toArray();

        $updatedServiceInstance = $this->serviceInstanceRepo->update($fakeServiceInstance, $serviceInstance->id);

        $this->assertModelData($fakeServiceInstance, $updatedServiceInstance->toArray());
        $dbServiceInstance = $this->serviceInstanceRepo->find($serviceInstance->id);
        $this->assertModelData($fakeServiceInstance, $dbServiceInstance->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_service_instance()
    {
        $serviceInstance = ServiceInstance::factory()->create();

        $resp = $this->serviceInstanceRepo->delete($serviceInstance->id);

        $this->assertTrue($resp);
        $this->assertNull(ServiceInstance::find($serviceInstance->id), 'ServiceInstance should not exist in DB');
    }
}
