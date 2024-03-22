<?php

namespace API\V1\Http\Controllers;

use App\Models\User;
use App\Models\V1\Song;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SongControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testIndexReturnListOfLps()
    {
        $user = User::factory()->create();
        //Create 5 songs with the factory
        Song::factory()->count(5)->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/songs');

        $response->assertOk()
            ->assertJsonCount(5, 'data');
    }

    /** @test */
    public function testStoreCreatesNewSongAndReturnsIt()
    {
        $user = User::factory()->create();

        $songData = [
            'title' => 'New Song',
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/songs', $songData);

        //Assert the user is in database
        $this->assertDatabaseHas('songs', ['title' => $songData['title']]);
    }

    /** @test */
    public function testShowReturnsSong()
    {
        $user = User::factory()->create();
        $song = Song::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson("/api/v1/songs/{$song->id}");

        $response->assertOk()
            ->assertJson(['data' => ['id' => $song->id]]);
    }

    /** @test */
    public function testUpdateModifiesExistingSongAndReturnsIt()
    {
        $user = User::factory()->create();
        $song = Song::factory()->create();
        $updatedData = [
            'title' => 'Updated Song',
        ];

        $response = $this->actingAs($user, 'sanctum')->putJson("/api/v1/songs/{$song->id}", $updatedData);

        //Assert the user is in database
        $this->assertDatabaseHas('songs', ['title' => $updatedData['title']]);
    }

    /** @test */
    public function testDestroyDeletesASong()
    {
        $user = User::factory()->create();
        $song = Song::factory()->create();

        $this->actingAs($user, 'sanctum')->delete("/api/v1/songs/{$song->id}");

        $this->assertDatabaseMissing('songs', ['id' => $song->id]);
    }
}
