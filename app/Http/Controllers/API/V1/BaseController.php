<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\BaseResource;
use App\Http\Resources\API\V1\DeletedDefaultResource;
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
        //Ordering
        $order_by_field = $request->has('order_by') ? $request->order_by : 'id';
        $order_by_direction = $request->has('direction') ? $request->direction : 'asc';

        // Ensure the order is safe and matches one of the columns in the table
        $order_by_field = in_array($order_by_field, $this->modelClass::getModel()->getConnection()->getSchemaBuilder()->getColumnListing($this->modelClass::getModel()->getTable())) ? $order_by_field : 'id';
        $order_by_direction = in_array($order_by_direction, ['asc', 'desc']) ? $order_by_direction : 'asc';

        //Per page results
        $per_page = min(config('discography.per_page_limit'), (int) $request->input('per_page', 15));
        $model = $this->modelClass::orderBy($order_by_field, $order_by_direction)->paginate($per_page);

        return new $this->resourceClass($model); // Assuming $this->resourceClass is now pointing to your collection resource
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
}
