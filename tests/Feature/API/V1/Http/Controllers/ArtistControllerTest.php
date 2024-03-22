<?php

namespace API\V1\Http\Controllers;

use App\Models\User;
use App\Models\V1\Artist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtistControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    /**
     * IMPORTANT: This test is the only Feature test that tests the index method with relationships, order_by, direction and per_page parameters.
     * Should work as a reference for the other tests since it works in the same way for the other endpoints.
     * The relationships for each model have their own unit tests.
     * 
     * @return void
     */
    public function testIndexReturnListOfArtistsWithOrderDirectionAndPerPageLimit()
    {
        $user = User::factory()->create();
        //Create 5 artists with the factory
        Artist::factory()->count(5)->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/artists');

        $response->assertOk()
            ->assertJsonCount(5, 'data');

        //test order_by with direction
        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/artists?order_by=id&direction=desc');

        //test the results were given by name in descending order
        $response->assertOk()
            ->assertJsonPath('data.0.id', 5)
            ->assertJsonPath('data.4.id', 1)
            ->assertJsonPath('data.3.id', 2)
            ->assertJsonPath('data.2.id', 3)
            ->assertJsonPath('data.1.id', 4)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                    ],
                ],
            ]);

        //test per_page
        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/artists?per_page=2');

        //test the results were paginated
        $response->assertOk()
            ->assertJsonCount(2, 'data');
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

    /** @test */
    public function testShowReturnsArtistWithLPs()
    {
        $user = User::factory()->create();
        $artist = Artist::factory()->hasLPs(3)->create();

        $response = $this->actingAs($user, 'sanctum')->getJson("/api/v1/artists/{$artist->id}?relationships=lps");

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'lps' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                        ],
                    ],
                ],
            ]);
    }
}
