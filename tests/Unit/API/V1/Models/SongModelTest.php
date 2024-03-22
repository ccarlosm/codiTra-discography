<?php

namespace API\V1\Models;

use App\Models\V1\Song;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tests\TestCase;

class SongModelTest extends TestCase
{
    /** @test */
    public function testSongsBelongsToManyAuthors()
    {
        $song = new Song();

        $this->assertInstanceOf(BelongsToMany::class, $song->authors());

        $this->assertInstanceOf(Collection::class, $song->authors);
    }

    /** @test */
    public function testSongBelongsToLP()
    {
        $song = new Song();

        $this->assertInstanceOf(BelongsTo::class, $song->LP());
    }

    /** @test */
    public function testFillable()
    {
        $song = new Song();
        $this->assertEquals(['title'], $song->getFillable());
    }
}
