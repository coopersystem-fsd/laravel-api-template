<?php

namespace Modules\User\Tests;

use Illuminate\Foundation\Testing\TestResponse;

trait AssertsAuth
{
    /**
     * @param TestResponse $response
     * @return TestResponse
     */
    private function assertUnauthenticatedResponse(TestResponse $response): TestResponse
    {
        return $response
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    /**
     * @param TestResponse $response
     * @return TestResponse
     */
    private function assertAuthenticatedResponse(TestResponse $response): TestResponse
    {
        return $response
            ->assertSuccessful()
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
            ]);
    }
}
