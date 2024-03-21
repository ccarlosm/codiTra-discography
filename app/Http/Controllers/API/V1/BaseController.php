<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\BaseResource;
use App\Http\Resources\API\V1\DeletedDefaultResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    protected $modelClass;// Should be given in child controllers
    protected $resourceClass = BaseResource::class;
    protected $storeRequestClass = Request::class; // Default, should be overridden in child controllers
    protected $updateRequestClass = Request::class; // Default, should be overridden in child controllers

    public function handleResponse($result, $msg, $code = 200): Response|JsonResponse
    {
        $res = [
            'success' => true,
            'data' => $result,
            'message' => $msg,
        ];

        return response()->json($res, $code);
    }

    public function handleError($error, $errorMsg = [], $code = 404): Response|JsonResponse
    {
        $res = [
            'success' => false,
            'message' => $error,
        ];
        if (! empty($errorMsg)) {
            $res['data'] = $errorMsg;
        }

        return response()->json($res, $code);
    }

    public function index(Request $request)
    {
        $per_page = min(config('your_app_config.per_page_limit'), intval($request->per_page));
        $model = $this->modelClass::paginate($per_page);
        return $this->handleResponse(new $this->resourceClass($model), 'List of resources fetched successfully');
    }

    public function store(Request $request)
    {
        $requestClass = app($this->storeRequestClass);
        $validated = $requestClass->validated();
        $model = $this->modelClass::create($validated);
        return $this->handleResponse(new $this->resourceClass($model), 'Resource created successfully');
    }

    public function show($id)
    {
        $model = $this->modelClass::findOrFail($id);
        return $this->handleResponse(new $this->resourceClass($model), 'Resource details fetched successfully');
    }

    public function update(Request $request, $id)
    {
        $requestClass = app($this->updateRequestClass);
        $validated = $requestClass->validated();
        $model = $this->modelClass::findOrFail($id);
        $model->update($validated);
        return $this->handleResponse(new $this->resourceClass($model), 'Resource updated successfully');
    }

    public function destroy($id)
    {
        $model = $this->modelClass::findOrFail($id);
        $model->delete();
        return $this->handleResponse(new DeletedDefaultResource($model), 'Resource deleted successfully');
    }
}
