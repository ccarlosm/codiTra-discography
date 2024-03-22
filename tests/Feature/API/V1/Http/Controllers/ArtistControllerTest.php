<?php

namespace API\V1\Http\Controllers;

use App\Models\V1\Artist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtistControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testIndexReturnListOfArtists()
    {
        $user = User::factory()->create();
        //Create 5 artists with the factory
        Artist::factory()->count(5)->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/artists');

        $response->assertOk()
            ->assertJsonCount(5, 'data');
    }

    /** @test */
    public function testStoreCreatesNewArtistAndReturnsIt()
    {
        $user = User::factory()->create();

        $artistData = [
            'name' => 'New Artist',
            'description' => 'Artist description',
        ];

        $this->actingAs($user, 'sanctum')->postJson('/api/v1/artists', $artistData);

        //Assert the user is in database
        $this->assertDatabaseHas('artists', ['name' => $artistData['name']]);
    }

    /** @test */
    public function testShowReturnsArtist()
    {
        $user = User::factory()->create();
        $artist = Artist::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson("/api/v1/artists/{$artist->id}");

        $response->assertOk()
            ->assertJson(['data' => ['id' => $artist->id]]);
    }

    /** @test */
    public function testUpdateModifiesExistingArtistAndReturnsIt()
    {
        $user = User::factory()->create();
        $artist = Artist::factory()->create();
        $updatedData = [
            'name' => 'Updated Artist',
            'description' => 'Artist updated description',
        ];

        $response = $this->actingAs($user, 'sanctum')->putJson("/api/v1/artists/{$artist->id}", $updatedData);

        $response->assertOk()
            ->assertJson(['data' => $updatedData]); // Simplified; adjust based on your actual JSON structure
    }

    /** @test */
    public function testDestroyDeletesAnArtist()
    {
        $user = User::factory()->create();
        $artist = Artist::factory()->create();

        $this->actingAs($user, 'sanctum')->deleteJson("/api/v1/artists/{$artist->id}");

        $this->assertDatabaseMissing('artists', ['id' => $artist->id]);
    }
}
