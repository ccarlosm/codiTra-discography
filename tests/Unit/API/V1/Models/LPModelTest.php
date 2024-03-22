<?php

namespace API\V1\Models;

use App\Models\V1\LP;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Tests\TestCase;

class LPModelTest extends TestCase
{
    /** @test */
    public function testLPHasManySongs()
    {
        $lp = new LP();

        $this->assertInstanceOf(hasMany::class, $lp->songs());

        $this->assertInstanceOf(Collection::class, $lp->songs);
    }

    /** @test */
    public function testLPBelongsToArtist()
    {
        $lp = new LP();

        $this->assertInstanceOf(BelongsTo::class, $lp->artist());
    }

    /** @test */
    public function testFillable()
    {
        $lp = new LP();
        $this->assertEquals(['title', 'description'], $lp->getFillable());
    }
}
