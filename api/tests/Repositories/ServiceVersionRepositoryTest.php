<?php

namespace Tests\Repositories;

use App\Models\ServiceVersion;
use App\Repositories\ServiceVersionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use Tests\TestCase;

class ServiceVersionRepositoryTest extends TestCase
{
    use ApiTestTrait;
    use DatabaseTransactions;

    /**
     * @var ServiceVersionRepository
     */
    protected $serviceVersionRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->serviceVersionRepo = \App::make(ServiceVersionRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_service_version()
    {
        $serviceVersion = ServiceVersion::factory()->make()->toArray();

        $createdServiceVersion = $this->serviceVersionRepo->create($serviceVersion);

        $createdServiceVersion = $createdServiceVersion->toArray();
        $this->assertArrayHasKey('id', $createdServiceVersion);
        $this->assertNotNull($createdServiceVersion['id'], 'Created ServiceVersion must have id specified');
        $this->assertNotNull(ServiceVersion::find($createdServiceVersion['id']), 'ServiceVersion with given id must be in DB');
        $this->assertModelData($serviceVersion, $createdServiceVersion);
    }

    /**
     * @test read
     */
    public function test_read_service_version()
    {
        $serviceVersion = ServiceVersion::factory()->create();

        $dbServiceVersion = $this->serviceVersionRepo->find($serviceVersion->id);

        $dbServiceVersion = $dbServiceVersion->toArray();
        $this->assertModelData($serviceVersion->toArray(), $dbServiceVersion);
    }

    /**
     * @test update
     */
    public function test_update_service_version()
    {
        $serviceVersion = ServiceVersion::factory()->create();
        $fakeServiceVersion = ServiceVersion::factory()->make()->toArray();

        $updatedServiceVersion = $this->serviceVersionRepo->update($fakeServiceVersion, $serviceVersion->id);

        $this->assertModelData($fakeServiceVersion, $updatedServiceVersion->toArray());
        $dbServiceVersion = $this->serviceVersionRepo->find($serviceVersion->id);
        $this->assertModelData($fakeServiceVersion, $dbServiceVersion->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_service_version()
    {
        $serviceVersion = ServiceVersion::factory()->create();

        $resp = $this->serviceVersionRepo->delete($serviceVersion->id);

        $this->assertTrue($resp);
        $this->assertNull(ServiceVersion::find($serviceVersion->id), 'ServiceVersion should not exist in DB');
    }
}
