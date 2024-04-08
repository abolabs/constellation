<?php

namespace Tests\Repositories;

use App\Models\Environment;
use App\Repositories\EnvironmentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use Tests\TestCase;

class EnvironmentRepositoryTest extends TestCase
{
    use ApiTestTrait;
    use DatabaseTransactions;

    /**
     * @var EnvironmentRepository
     */
    protected $environmentRepo;

    public function setUp(): void
    {
        parent::setUp();
        $this->environmentRepo = \App::make(EnvironmentRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_environment()
    {
        $environment = Environment::factory()->make()->toArray();

        $createdEnvironment = $this->environmentRepo->create($environment);

        $createdEnvironment = $createdEnvironment->toArray();
        $this->assertArrayHasKey('id', $createdEnvironment);
        $this->assertNotNull($createdEnvironment['id'], 'Created Environment must have id specified');
        $this->assertNotNull(Environment::find($createdEnvironment['id']), 'Environment with given id must be in DB');
        $this->assertModelData($environment, $createdEnvironment);
    }

    /**
     * @test read
     */
    public function test_read_environment()
    {
        $environment = Environment::factory()->create();

        $dbEnvironment = $this->environmentRepo->find($environment->id);

        $dbEnvironment = $dbEnvironment->toArray();
        $this->assertModelData($environment->toArray(), $dbEnvironment);
    }

    /**
     * @test update
     */
    public function test_update_environment()
    {
        $environment = Environment::factory()->create();
        $fakeEnvironment = Environment::factory()->make()->toArray();

        $updatedEnvironment = $this->environmentRepo->update($fakeEnvironment, $environment->id);

        $this->assertModelData($fakeEnvironment, $updatedEnvironment->toArray());
        $dbEnvironment = $this->environmentRepo->find($environment->id);
        $this->assertModelData($fakeEnvironment, $dbEnvironment->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_environment()
    {
        $environment = Environment::factory()->create();

        $resp = $this->environmentRepo->delete($environment->id);

        $this->assertTrue($resp);
        $this->assertNull(Environment::find($environment->id), 'Environment should not exist in DB');
    }
}
