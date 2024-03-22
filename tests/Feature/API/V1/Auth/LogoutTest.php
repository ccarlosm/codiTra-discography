<?php

namespace API\V1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLogout()
    {
        $user = User::factory()->create([
            'email' => 'john2@example.com',
            'password' => bcrypt('password2'),
        ]);

        $this->post('/api/login', [
            'email' => 'john2@example.com',
            'password' => 'password2',
        ]);

        // Assert the application authenticated the user
        $this->assertAuthenticated();

        $this->actingAs($user)->post('/api/logout');

        $this->assertGuest();
    }
}
