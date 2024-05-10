<?php

namespace API\V1\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLogin()
    {
        User::factory()->create([
            'email' => 'john2@example.com',
            'password' => bcrypt('password2'),
        ]);

        //Assert there are no tokens in the database
        $this->assertDatabaseCount('personal_access_tokens', 0);

        $this->post('/api/login', [
            'email' => 'john2@example.com',
            'password' => 'password2',
        ]);

        //Assert there is one record in the database
        $this->assertDatabaseCount('personal_access_tokens', 1);

        // Assert the application authenticated the user
        $this->assertAuthenticated();
    }
}
