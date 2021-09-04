<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HostingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'hosting_type_id' => $this->hosting_type_id,
            'localisation' => $this->localisation,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
