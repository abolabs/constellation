<?php namespace Tests\Repositories;

use App\Models\hosting_type;
use App\Repositories\hosting_typeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class hosting_typeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var hosting_typeRepository
     */
    protected $hostingTypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->hostingTypeRepo = \App::make(hosting_typeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_hosting_type()
    {
        $hostingType = hosting_type::factory()->make()->toArray();

        $createdhosting_type = $this->hostingTypeRepo->create($hostingType);

        $createdhosting_type = $createdhosting_type->toArray();
        $this->assertArrayHasKey('id', $createdhosting_type);
        $this->assertNotNull($createdhosting_type['id'], 'Created hosting_type must have id specified');
        $this->assertNotNull(hosting_type::find($createdhosting_type['id']), 'hosting_type with given id must be in DB');
        $this->assertModelData($hostingType, $createdhosting_type);
    }

    /**
     * @test read
     */
    public function test_read_hosting_type()
    {
        $hostingType = hosting_type::factory()->create();

        $dbhosting_type = $this->hostingTypeRepo->find($hostingType->id);

        $dbhosting_type = $dbhosting_type->toArray();
        $this->assertModelData($hostingType->toArray(), $dbhosting_type);
    }

    /**
     * @test update
     */
    public function test_update_hosting_type()
    {
        $hostingType = hosting_type::factory()->create();
        $fakehosting_type = hosting_type::factory()->make()->toArray();

        $updatedhosting_type = $this->hostingTypeRepo->update($fakehosting_type, $hostingType->id);

        $this->assertModelData($fakehosting_type, $updatedhosting_type->toArray());
        $dbhosting_type = $this->hostingTypeRepo->find($hostingType->id);
        $this->assertModelData($fakehosting_type, $dbhosting_type->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_hosting_type()
    {
        $hostingType = hosting_type::factory()->create();

        $resp = $this->hostingTypeRepo->delete($hostingType->id);

        $this->assertTrue($resp);
        $this->assertNull(hosting_type::find($hostingType->id), 'hosting_type should not exist in DB');
    }
}
