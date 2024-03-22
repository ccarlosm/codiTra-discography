<?php

namespace API\V1\Models;

use App\Models\V1\SongAuthor;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class SongAuthorModelTest extends TestCase
{
    /** @test */
    public function testSongAuthorsBelongsToSong()
    {
        $song_author = new SongAuthor();

        $this->assertInstanceOf(BelongsTo::class, $song_author->song());
    }

    /** @test */
    public function testSongAuthorBelongsToAuthor()
    {
        $song_author = new SongAuthor();

        $this->assertInstanceOf(BelongsTo::class, $song_author->author());
    }

    /** @test */
    public function testFillable()
    {
        $song_author = new SongAuthor();
        $this->assertEquals(['song_id', 'author_id'], $song_author->getFillable());
    }
}
