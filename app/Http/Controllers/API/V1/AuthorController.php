<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\StoreAuthorRequest;
use App\Http\Requests\API\V1\UpdateAuthorRequest;
use App\Models\V1\Author;

class AuthorController extends BaseController
{
    protected $modelClass = Author::class;
    protected $storeRequestClass = StoreAuthorRequest::class;
    protected $updateRequestClass = UpdateAuthorRequest::class;
}
