<?php

namespace Tests\Unit;

use Illuminate\Http\Response;
use Tests\TestCase;

class ApiKeyTest extends TestCase
{
    use ApiKeyTestTrait;

    public function test_valid_api_key(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TEST_API_KEY,
        ])->get('/api/flagbits');

        $response->assertSuccessful();
    }

    public function test_invalid_api_key()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer 8067562d7138d72501485s941246cf9b229c3a46a',
        ])->get('/api/flagbits');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $response->assertExactJson([
            'error' => 'Invalid API key provided.',
        ]);
    }

    public function test_valid_master_api_key()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TEST_MASTER_API_KEY,
        ])->delete('/api/flagbits/105');

        $response->assertSuccessful();
    }

    public function test_invalid_master_api_key()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . self::TEST_API_KEY,
        ])->delete('/api/flagbits/105');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

        $response->assertExactJson([
            'error' => 'Invalid API key provided.',
        ]);
    }
}
