<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceInstanceResource extends JsonResource
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
            'application_name' => $this->application->name,
            'service_version_id' => $this->service_version_id,
            'service_version_name' => $this->serviceVersion->service->name,
            'service_version' => $this->serviceVersion->version,
            'environnement_id' => $this->environnement_id,
            'environnement_name' => $this->environnement->name,
            'hosting_id' => $this->hosting_id,
            'hosting_name' => $this->hosting->name,
            'url' => $this->url,
            'role' => $this->role,
            'statut' => $this->statut,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
