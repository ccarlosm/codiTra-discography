<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\Controllers\OrderBy;
use App\Http\Requests\API\V1\StoreLPRequest;
use App\Http\Requests\API\V1\UpdateLPRequest;
use App\Models\V1\LP;
use Illuminate\Http\Request;

class LPController extends BaseController
{
    protected $modelClass = LP::class;

    protected $storeRequestClass = StoreLPRequest::class;

    protected $updateRequestClass = UpdateLPRequest::class;

    public function index(Request $request)
    {
        //Per page results
        $per_page = min(config('discography.per_page_limit'), (int) $request->input('per_page'));

        //use OrderBy Action
        $query = app(OrderBy::class)->handle($request, $this->modelClass);

        // If a name is provided in the request, add a where clause to filter by Artist name
        if ($request->filled('artist_name')) {
            $query->where(function ($query) use ($request) {
                $query->whereHas('artist', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->artist_name . '%');
                });
            });
        }

        // Execute the query with pagination
        $artists = $query->paginate($per_page);

        return new $this->resourceClass($artists);
    }
}
