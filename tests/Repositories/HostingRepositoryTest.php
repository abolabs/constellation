<?php

namespace Tests\Repositories;

use App\Models\Hosting;
use App\Repositories\HostingRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use Tests\TestCase;

class HostingRepositoryTest extends TestCase
{
    use ApiTestTrait;
    use DatabaseTransactions;

    /**
     * @var HostingRepository
     */
    protected $hostingRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->hostingRepo = \App::make(HostingRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_hosting()
    {
        $hosting = Hosting::factory()->make()->toArray();

        $createdHosting = $this->hostingRepo->create($hosting);

        $createdHosting = $createdHosting->toArray();
        $this->assertArrayHasKey('id', $createdHosting);
        $this->assertNotNull($createdHosting['id'], 'Created Hosting must have id specified');
        $this->assertNotNull(Hosting::find($createdHosting['id']), 'Hosting with given id must be in DB');
        $this->assertModelData($hosting, $createdHosting);
    }

    /**
     * @test read
     */
    public function test_read_hosting()
    {
        $hosting = Hosting::factory()->create();

        $dbHosting = $this->hostingRepo->find($hosting->id);

        $dbHosting = $dbHosting->toArray();
        $this->assertModelData($hosting->toArray(), $dbHosting);
    }

    /**
     * @test update
     */
    public function test_update_hosting()
    {
        $hosting = Hosting::factory()->create();
        $fakeHosting = Hosting::factory()->make()->toArray();

        $updatedHosting = $this->hostingRepo->update($fakeHosting, $hosting->id);

        $this->assertModelData($fakeHosting, $updatedHosting->toArray());
        $dbHosting = $this->hostingRepo->find($hosting->id);
        $this->assertModelData($fakeHosting, $dbHosting->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_hosting()
    {
        $hosting = Hosting::factory()->create();

        $resp = $this->hostingRepo->delete($hosting->id);

        $this->assertTrue($resp);
        $this->assertNull(Hosting::find($hosting->id), 'Hosting should not exist in DB');
    }
}
