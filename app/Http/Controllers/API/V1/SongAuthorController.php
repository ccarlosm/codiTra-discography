<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\StoreSongAuthorRequest;
use App\Models\V1\SongAuthor;
use Illuminate\Http\Request;

class SongAuthorController extends BaseController
{
    protected $modelClass = SongAuthor::class;
    protected $storeRequestClass = StoreSongAuthorRequest::class;

    public function update(Request $request, $id)
    {
        return $this->handleError('Not allowed to update', [], 403);
    }
}
