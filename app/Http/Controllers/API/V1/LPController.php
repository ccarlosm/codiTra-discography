<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\StoreLPRequest;
use App\Http\Requests\API\V1\UpdateLPRequest;
use App\Models\V1\LP;

class LPController extends BaseController
{
    protected $modelClass = LP::class;
    protected $storeRequestClass = StoreLPRequest::class;
    protected $updateRequestClass = UpdateLPRequest::class;
}
