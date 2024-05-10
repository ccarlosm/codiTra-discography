<?php

namespace Tests\Feature\API\V1;

use App\Models\User;
use App\Models\V1\Song;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExceptionHandlerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Example tests for custom exception handling
     * The exception custom messages are supposed to be only for production
     */

    /** @test */
    public function testRouteNotFoundExceptionReturnsCustomResponse()
    {
        //set environment to production
        $this->app['env'] = 'production';

        $response = $this->get('/nonexistingroute'); //

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'data' => [
                    'message' => 'Route not found',
                ],
            ]);
    }

    /** @test RelationNotFoundException*/
    public function testRelationNotFoundExceptionReturnsCustomResponse()
    {
        //set environment to production
        $this->app['env'] = 'production';

        $user = User::factory()->create();
        $song = Song::factory()->create();

        $response = $this->actingAs($user)->get('/api/v1/songs/'.$song->id.'?relationships=non_existent_relationship');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'data' => [
                    'message' => 'Bad relationship provided or not found',
                ],
            ]);
    }
}
