<?php

namespace Tests\APIs\v1;

use App\Models\Audit;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response as HttpCode;
use Tests\ApiTestTrait;
use Tests\TestCase;

class AuditApiTest extends TestCase
{
    use ApiTestTrait;
    use DatabaseTransactions;

    private const ROUTE_PREFIX = '/api/v1/audits';

    /**
     * @test
     */
    public function test_create_audit()
    {
        $audit = Audit::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            self::ROUTE_PREFIX,
            $audit
        );

        $this->response->assertStatus(HttpCode::HTTP_NOT_IMPLEMENTED);
    }

    /**
     * @test
     */
    public function test_read_audit()
    {
        $audit = Audit::factory()->create();

        $this->response = $this->json(
            'GET',
            self::ROUTE_PREFIX . '/' . $audit->id
        );

        $this->assertApiResponse($audit->toArray());
    }

    /**
     * @test
     */
    public function test_update_audit()
    {
        $audit = Audit::factory()->create();

        $this->response = $this->json(
            'PUT',
            self::ROUTE_PREFIX . '/' . $audit->id
        );

        $this->response->assertStatus(HttpCode::HTTP_NOT_IMPLEMENTED);
    }

    /**
     * @test
     */
    public function test_delete_audit()
    {
        $audit = Audit::factory()->create();

        $this->response = $this->json(
            'DELETE',
            self::ROUTE_PREFIX . '/' . $audit->id
        );

        $this->response->assertStatus(HttpCode::HTTP_NOT_IMPLEMENTED);
    }
}
