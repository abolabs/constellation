<?php

namespace Tests\Repositories;

use App\Models\HostingType;
use App\Repositories\HostingTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use Tests\TestCase;

class HostingTypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var HostingTypeRepository
     */
    protected $hostingTypeRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->hostingTypeRepo = \App::make(HostingTypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_hosting_type()
    {
        $hostingType = HostingType::factory()->make()->toArray();

        $createdHostingType = $this->hostingTypeRepo->create($hostingType);

        $createdHostingType = $createdHostingType->toArray();
        $this->assertArrayHasKey('id', $createdHostingType);
        $this->assertNotNull($createdHostingType['id'], 'Created HostingType must have id specified');
        $this->assertNotNull(HostingType::find($createdHostingType['id']), 'HostingType with given id must be in DB');
        $this->assertModelData($hostingType, $createdHostingType);
    }

    /**
     * @test read
     */
    public function test_read_hosting_type()
    {
        $hostingType = HostingType::factory()->create();

        $dbHostingType = $this->hostingTypeRepo->find($hostingType->id);

        $dbHostingType = $dbHostingType->toArray();
        $this->assertModelData($hostingType->toArray(), $dbHostingType);
    }

    /**
     * @test update
     */
    public function test_update_hosting_type()
    {
        $hostingType = HostingType::factory()->create();
        $fakeHostingType = HostingType::factory()->make()->toArray();

        $updatedHostingType = $this->hostingTypeRepo->update($fakeHostingType, $hostingType->id);

        $this->assertModelData($fakeHostingType, $updatedHostingType->toArray());
        $dbHostingType = $this->hostingTypeRepo->find($hostingType->id);
        $this->assertModelData($fakeHostingType, $dbHostingType->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_hosting_type()
    {
        $hostingType = HostingType::factory()->create();

        $resp = $this->hostingTypeRepo->delete($hostingType->id);

        $this->assertTrue($resp);
        $this->assertNull(HostingType::find($hostingType->id), 'HostingType should not exist in DB');
    }
}
