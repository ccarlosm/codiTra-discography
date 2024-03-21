<?php

namespace API\V1\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Features;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanRegister()
    {
        if (!Features::enabled(Features::registration())) {
            $this->markTestSkipped('Registration feature is not enabled.');
        }

        $this->post('/api/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    public function testUserCanLogin()
    {
        User::factory()->create([
            'email' => 'john2@example.com',
            'password' => bcrypt('password2'),
        ]);

        $this->post('/api/login', [
            'email' => 'john2@example.com',
            'password' => 'password2',
        ]);

        // Assert the application authenticated the user
        $this->assertAuthenticated();
    }

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
