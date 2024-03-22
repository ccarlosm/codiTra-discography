<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $relations_array = request('relationships', $default = '');
        //The relationships array is passed as a query parameter in the request but it will be a string
        //Convert it to an array
        $relations_array = explode(',', $relations_array);

        if (! empty($relations_array)) {
            $with = (array) $relations_array;
        } else {
            $with = [];
        }

        //Load relationships only when necessary
        $this->loadMissing($with);

        return parent::toArray($request);
    }
}
