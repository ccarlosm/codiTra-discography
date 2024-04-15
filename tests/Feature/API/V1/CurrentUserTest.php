<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrentUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticatedUserCanRetrieveItsProfile()
    {
        // Arrange: Create a user
        $user = User::factory()->create();

        // Act: Simulate a login and make a GET request to the '/user' route
        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/user');

        // Assert: Check if the response has the correct structure and data
        $response->assertOk() // or $response->assertStatus(200) if you prefer
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);
    }
}
