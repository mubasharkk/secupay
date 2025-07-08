<?php

namespace Tests\Unit;

use Tests\TestCase;

class ApiBasicTest extends TestCase
{
    /**
     * Test endpoint for server time
     */
    public function test_api_server_time(): void
    {
        $response = $this->get('/api/server-time');
        $response->assertStatus(200);

        $response->assertJsonStructure(['time']);
        $response->assertJson(['time' => now()->toIso8601String()]);

        $response->assertJson(function ($json) {
            $json->has('time');
            $json->whereType('time', 'string');
        });
    }
}
