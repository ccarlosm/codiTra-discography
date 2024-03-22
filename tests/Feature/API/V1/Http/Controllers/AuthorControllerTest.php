<?php

namespace API\V1\Http\Controllers;

use App\Models\User;
use App\Models\V1\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testIndexReturnListOfAuthors()
    {
        $user = User::factory()->create();
        //Create 5 authors with the factory
        Author::factory()->count(5)->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/authors');

        $response->assertOk()
            ->assertJsonCount(5, 'data');
    }

    /** @test */
    public function testStoreCreatesNewAuthorAndReturnsIt()
    {
        $user = User::factory()->create();

        $authorData = [
            'firstname' => 'New Author',
            'lastname' => 'Author lastname',
        ];

        $this->actingAs($user, 'sanctum')->postJson('/api/v1/authors', $authorData);

        //Assert the user is in database
        $this->assertDatabaseHas('authors', ['firstname' => $authorData['firstname'], 'lastname' => $authorData['lastname']]);
    }

    /** @test */
    public function testShowReturnsAuthor()
    {
        $user = User::factory()->create();
        $author = Author::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson("/api/v1/authors/{$author->id}");

        $response->assertOk()
            ->assertJson(['data' => ['id' => $author->id]]);
    }

    /** @test */
    public function testUpdateModifiesExistingAuthorAndReturnsIt()
    {
        $user = User::factory()->create();
        $author = Author::factory()->create();
        $updatedData = [
            'firstname' => 'Updated Author',
            'lastname' => 'Updated Author lastname',
        ];

        $response = $this->actingAs($user, 'sanctum')->putJson("/api/v1/authors/{$author->id}", $updatedData);

        $response->assertOk()
            ->assertJson(['data' => ['id' => $author->id, 'firstname' => $updatedData['firstname'], 'lastname' => $updatedData['lastname']]]); // Adjust based on your JSON structure
    }

    /** @test */
    public function testDestroyDeletesAuthor()
    {
        $user = User::factory()->create();
        $author = Author::factory()->create();

        $this->actingAs($user, 'sanctum')->deleteJson("/api/v1/authors/{$author->id}");

        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}
