<?php

namespace App\Http\Resources\API\V1;

class DeletedDefaultResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'object_type' => $this->object_type,
        ];
    }
}
