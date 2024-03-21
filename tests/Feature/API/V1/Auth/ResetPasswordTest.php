<?php

namespace API\V1\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Features;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanResetPassword()
    {
        if (!Features::enabled(Features::resetPasswords())) {
            $this->markTestSkipped('Password reset feature is not enabled.');
        }

        Notification::fake();

        $user = User::factory()->create([
            'email' => 'john3@example.com',
            'password' => bcrypt('password3'),
        ]);

        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'Accept' => 'application/json',
        ])->post('/api/forgot-password', [
            'email' => 'john3@example.com',
        ]);

        $response->assertStatus(200);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification, $channels) use (&$token) {
            $token = $notification->token;
            return true;
        });

        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'Accept' => 'application/json',
        ])->post('/api/reset-password', [
            'token' => $token,
            'email' => 'john3@example.com',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertStatus(200);

        // Attempt to log in with the new password
        $this->post('/api/login', [
            'email' => 'john3@example.com',
            'password' => 'newpassword',
        ]);

        $this->assertAuthenticated();
    }
}
