<?php

namespace Tests\Repositories;

use App\Models\ServiceInstanceDependencies;
use App\Repositories\ServiceInstanceDependenciesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use Tests\TestCase;

class ServiceInstanceDependenciesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ServiceInstanceDependenciesRepository
     */
    protected $serviceInstanceDependenciesRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->serviceInstanceDependenciesRepo = \App::make(ServiceInstanceDependenciesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_service_instance_dependencies()
    {
        $serviceInstanceDependencies = ServiceInstanceDependencies::factory()->make()->toArray();

        $createdServiceInstanceDependencies = $this->serviceInstanceDependenciesRepo->create($serviceInstanceDependencies);

        $createdServiceInstanceDependencies = $createdServiceInstanceDependencies->toArray();
        $this->assertArrayHasKey('id', $createdServiceInstanceDependencies);
        $this->assertNotNull($createdServiceInstanceDependencies['id'], 'Created ServiceInstanceDependencies must have id specified');
        $this->assertNotNull(ServiceInstanceDependencies::find($createdServiceInstanceDependencies['id']), 'ServiceInstanceDependencies with given id must be in DB');
        $this->assertModelData($serviceInstanceDependencies, $createdServiceInstanceDependencies);
    }

    /**
     * @test read
     */
    public function test_read_service_instance_dependencies()
    {
        $serviceInstanceDependencies = ServiceInstanceDependencies::factory()->create();

        $dbServiceInstanceDependencies = $this->serviceInstanceDependenciesRepo->find($serviceInstanceDependencies->id);

        $dbServiceInstanceDependencies = $dbServiceInstanceDependencies->toArray();
        $this->assertModelData($serviceInstanceDependencies->toArray(), $dbServiceInstanceDependencies);
    }

    /**
     * @test update
     */
    public function test_update_service_instance_dependencies()
    {
        $serviceInstanceDependencies = ServiceInstanceDependencies::factory()->create();
        $fakeServiceInstanceDependencies = ServiceInstanceDependencies::factory()->make()->toArray();

        $updatedServiceInstanceDependencies = $this->serviceInstanceDependenciesRepo->update($fakeServiceInstanceDependencies, $serviceInstanceDependencies->id);

        $this->assertModelData($fakeServiceInstanceDependencies, $updatedServiceInstanceDependencies->toArray());
        $dbServiceInstanceDependencies = $this->serviceInstanceDependenciesRepo->find($serviceInstanceDependencies->id);
        $this->assertModelData($fakeServiceInstanceDependencies, $dbServiceInstanceDependencies->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_service_instance_dependencies()
    {
        $serviceInstanceDependencies = ServiceInstanceDependencies::factory()->create();

        $resp = $this->serviceInstanceDependenciesRepo->delete($serviceInstanceDependencies->id);

        $this->assertTrue($resp);
        $this->assertNull(ServiceInstanceDependencies::find($serviceInstanceDependencies->id), 'ServiceInstanceDependencies should not exist in DB');
    }
}
