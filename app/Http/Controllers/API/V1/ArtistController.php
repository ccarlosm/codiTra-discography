<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\StoreArtistRequest;
use App\Http\Requests\API\V1\UpdateArtistRequest;
use App\Models\V1\Artist;

class ArtistController extends BaseController
{
    protected $modelClass = Artist::class;
    protected $storeRequestClass = StoreArtistRequest::class;
    protected $updateRequestClass = UpdateArtistRequest::class;
}
