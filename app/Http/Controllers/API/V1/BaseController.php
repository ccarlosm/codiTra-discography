<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\BaseResource;
use App\Http\Resources\API\V1\DeletedDefaultResource;
use App\Actions\Controllers\OrderBy;
use Illuminate\Support\Facades\Response as ResponseFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    protected $modelClass; // Should be given in child controllers

    protected $resourceClass = BaseResource::class;

    protected $storeRequestClass = Request::class; // Default, should be overridden in child controllers

    protected $updateRequestClass = Request::class; // Default, should be overridden in child controllers

    public function index(Request $request)
    {
        //Per page results
        $per_page = min(config('discography.per_page_limit'), (int) $request->input('per_page'));

        //use OrderBy Action
        $model = app(OrderBy::class)->handle($request, $this->modelClass)->paginate($per_page);

        return new $this->resourceClass($model);
    }

    public function store(Request $request)
    {

        $requestClass = app($this->storeRequestClass);

        $validated = $requestClass->validated();

        $model = $this->modelClass::create($validated);

        return $this->handleResponse(new $this->resourceClass($model), __('responses.created', ['object_type' => $model->object_type]));
    }

    public function show($id)
    {
        $model = $this->modelClass::findOrFail($id);

        return $this->handleResponse(new $this->resourceClass($model), __('responses.list', ['object_type' => $model->object_type]));
    }

    public function update(Request $request, $id)
    {
        $requestClass = app($this->updateRequestClass);
        $validated = $requestClass->validated();
        $model = $this->modelClass::findOrFail($id);
        $model->update($validated);

        return $this->handleResponse(new $this->resourceClass($model), __('responses.updated', ['object_type' => $model->object_type]));
    }

    public function destroy($id)
    {
        $model = $this->modelClass::findOrFail($id);
        $model->delete();

        return $this->handleResponse(new DeletedDefaultResource($model), __('responses.deleted', ['object_type' => $model->object_type]));
    }

    public function handleResponse($data, $success, $status = 200): Response|JsonResponse
    {
        //Use Response macro from AppServiceProvider
        return ResponseFacade::apiV1($data, $success, $status);
    }
}
