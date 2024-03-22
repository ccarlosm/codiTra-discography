<?php

namespace API\V1\Models;

use App\Models\V1\Author;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tests\TestCase;

class AuthorModelTest extends TestCase
{
    /** @test */
    public function testAuthorBelongsToManySongs()
    {
        $author = new Author();

        //Relationship many to many through pivot table SongAuthor
        $this->assertInstanceOf(BelongsToMany::class, $author->songs());

        $this->assertInstanceOf(Collection::class, $author->songs);
    }

    /** @test */
    public function testFillable()
    {
        $author = new Author();
        $this->assertEquals(['firstname', 'lastname'], $author->getFillable());
    }
}
