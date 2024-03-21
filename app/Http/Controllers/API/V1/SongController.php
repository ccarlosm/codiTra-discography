<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\StoreSongRequest;
use App\Http\Requests\API\V1\UpdateSongRequest;
use App\Models\V1\Song;

class SongController extends BaseController
{
    protected $modelClass = Song::class;
    protected $storeRequestClass = StoreSongRequest::class;
    protected $updateRequestClass = UpdateSongRequest::class;
}
