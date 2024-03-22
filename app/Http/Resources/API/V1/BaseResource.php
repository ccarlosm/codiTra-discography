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
        $relations_array = request('relationships', $default = []);

        if (! empty($relations_array)) {
            $relations_array = explode(',', $relations_array);
            $this->loadMissing($relations_array);
        }

        return parent::toArray($request);
    }
}
