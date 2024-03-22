<?php

namespace API\V1\Models;

use App\Models\V1\Artist;
use App\Models\V1\Author;
use App\Models\V1\LP;
use App\Models\V1\Song;
use App\Models\V1\SongAuthor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BaseModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testObjectTypeReturnsTheTableName()
    {
        // Create an instance of the Artist model for example
        $artist = new Artist();
        // The object_type attribute should match the table name for the Artist model
        $this->assertEquals($artist->getTable(), $artist->object_type);

        //The same for Song
        $song = new Song();
        $this->assertEquals($song->getTable(), $song->object_type);

        //The same for LP
        $lp = new LP();
        $this->assertEquals($lp->getTable(), $lp->object_type);

        //The same for Author
        $author = new Author();
        $this->assertEquals($author->getTable(), $author->object_type);

        //The same for SongAuthor
        $songAuthor = new SongAuthor();
        $this->assertEquals($songAuthor->getTable(), $songAuthor->object_type);
    }
}
