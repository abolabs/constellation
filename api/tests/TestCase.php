<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $user->assignRole('Admin');
        Passport::actingAs(
            $user,
            ['api']
        );
    }
}
