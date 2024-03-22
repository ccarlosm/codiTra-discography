<?php

namespace Tests\Unit\API\V1\Models;

use App\Models\V1\Artist;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class ArtistModelTest extends TestCase
{
    /** @test */
    public function testArtistHasManyLps()
    {
        $artist = new Artist();

        $this->assertInstanceOf(HasMany::class, $artist->LPs());

        $this->assertInstanceOf(Collection::class, $artist->LPs);
    }

    /** @test */
    public function testFillable()
    {
        $artist = new Artist();
        $this->assertEquals(['name', 'description'], $artist->getFillable());
    }
}
