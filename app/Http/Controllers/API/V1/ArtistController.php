<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\Controllers\OrderBy;
use App\Http\Requests\API\V1\StoreArtistRequest;
use App\Http\Requests\API\V1\UpdateArtistRequest;
use App\Models\V1\Artist;
use Illuminate\Http\Request;

class ArtistController extends BaseController
{
    protected $modelClass = Artist::class;

    protected $storeRequestClass = StoreArtistRequest::class;

    protected $updateRequestClass = UpdateArtistRequest::class;

    public function index(Request $request)
    {
        //Per page results
        $per_page = min(config('discography.per_page_limit'), (int) $request->input('per_page'));

        //use OrderBy Action
        $query = app(OrderBy::class)->handle($request, $this->modelClass);

        // If a name is provided in the request, add a where clause to filter by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Execute the query with pagination
        $artists = $query->paginate($per_page);

        return new $this->resourceClass($artists);
    }
}
