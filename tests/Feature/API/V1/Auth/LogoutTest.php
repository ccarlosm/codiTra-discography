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

        //Assert there are no tokens in the database
        $this->assertDatabaseCount('personal_access_tokens', 0);

        // Create a real token for the user
        $token = $user->createToken('TestToken')->plainTextToken;

        // Split the token to get the token's ID part
        $tokenParts = explode('|', $token);
        $tokenID = $tokenParts[0];

        //Assert there is that 1 token in the database
        $this->assertDatabaseCount('personal_access_tokens', 1);

        // Use the token for subsequent requests
        $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->post('/api/logout');

        //Assert there are no tokens in the database
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }
}
