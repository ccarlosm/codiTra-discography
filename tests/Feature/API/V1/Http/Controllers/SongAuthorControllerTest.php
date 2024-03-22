<?php

namespace API\V1\Http\Controllers;

use App\Models\User;
use App\Models\V1\Author;
use App\Models\V1\Song;
use App\Models\V1\SongAuthor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SongAuthorControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testIndexReturnListOfLps()
    {
        $user = User::factory()->create();
        //Create 1 song and 1 author
        $song = Song::factory()->create();
        $author = Author::factory()->create();

        //Attach the author to the song
        $song->authors()->attach($author);

        //Create another song and another author
        $song_2 = Song::factory()->create();
        $author_2 = Author::factory()->create();

        //Attach the author to the song
        $song_2->authors()->attach($author_2);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/song_authors');

        $response->assertOk()
            ->assertJsonCount(2, 'data');
    }

    /** @test */
    public function testStoreCreatesNewSongAuthorAndReturnsIt()
    {
        $user = User::factory()->create();
        $song = Song::factory()->create();
        $author = Author::factory()->create();

        $songAuthorData = [
            'song_id' => $song->id,
            'author_id' => $author->id,
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/song_authors', $songAuthorData);

        //Assert the user is in database
        $this->assertDatabaseHas('song_authors', ['song_id' => $song->id, 'author_id' => $author->id]);
    }

    /** @test */
    public function testShowReturnsSongAuthor()
    {
        $user = User::factory()->create();
        $song = Song::factory()->create();
        $author = Author::factory()->create();

        $song->authors()->attach($author);

        //Get the song author from the database
        $song_author = SongAuthor::where('song_id', $song->id)->where('author_id', $author->id)->first();

        $response = $this->actingAs($user, 'sanctum')->getJson("/api/v1/song_authors/{$song_author->id}");

        $response->assertOk()
            ->assertJson(['data' => ['id' => $song_author->id, 'song_id' => $song->id, 'author_id' => $author->id]]);
    }

    /** @test */
    public function testDestroyDeletesASong()
    {
        $user = User::factory()->create();
        $song = Song::factory()->create();
        $author = Author::factory()->create();

        $song->authors()->attach($author);

        //Get the song author from the database
        $song_author = SongAuthor::where('song_id', $song->id)->where('author_id', $author->id)->first();

        $this->actingAs($user, 'sanctum')->deleteJson("/api/v1/song_authors/{$song_author->id}");

        $this->assertDatabaseMissing('song_authors', ['id' => $song_author->id]);
    }
}
