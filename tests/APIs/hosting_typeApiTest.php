<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\hosting_type;

class hosting_typeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_hosting_type()
    {
        $hostingType = hosting_type::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hosting_types', $hostingType
        );

        $this->assertApiResponse($hostingType);
    }

    /**
     * @test
     */
    public function test_read_hosting_type()
    {
        $hostingType = hosting_type::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hosting_types/'.$hostingType->id
        );

        $this->assertApiResponse($hostingType->toArray());
    }

    /**
     * @test
     */
    public function test_update_hosting_type()
    {
        $hostingType = hosting_type::factory()->create();
        $editedhosting_type = hosting_type::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hosting_types/'.$hostingType->id,
            $editedhosting_type
        );

        $this->assertApiResponse($editedhosting_type);
    }

    /**
     * @test
     */
    public function test_delete_hosting_type()
    {
        $hostingType = hosting_type::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hosting_types/'.$hostingType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hosting_types/'.$hostingType->id
        );

        $this->response->assertStatus(404);
    }
}
