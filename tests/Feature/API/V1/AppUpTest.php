<?php

namespace API\V1;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppUpTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_up_returns_a_successful_response(): void
    {
        $response = $this->get('/up');

        $response->assertStatus(200);
    }
}
