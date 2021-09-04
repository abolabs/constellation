<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppInstanceResource extends JsonResource
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
            'application_id' => $this->application_id,
            'service_version_id' => $this->service_version_id,
            'environnement_id' => $this->environnement_id,
            'url' => $this->url,
            'statut' => $this->statut,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
