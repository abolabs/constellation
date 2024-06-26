<?php

// Copyright (C) 2022 Abolabs (https://gitlab.com/abolabs/)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: "Service instance",
    schema: "resource-service-instance",
    description: "Service -nstance resource",
    type: "object"
)]
class ServiceInstanceResource extends JsonResource
{
    #[OAT\Property(
        property: "id",
        description: "id",
        type: "integer"
    )]
    #[OAT\Property(
        property: "application_id",
        description: "application_id",
        type: "integer"
    )]
    #[OAT\Property(
        property: "service_version_id",
        description: "service_version_id",
        type: "integer"
    )]
    #[OAT\Property(
        property: "environment_id",
        description: "environment_id",
        type: "integer"
    )]
    #[OAT\Property(
        property: "url",
        description: "url",
        type: "string"
    )]
    #[OAT\Property(
        property: "statut",
        description: "statut",
        type: "string"
    )]
    #[OAT\Property(
        property: "created_at",
        description: "created_at",
        type: "string",
        format: "date-time"
    )]
    #[OAT\Property(
        property: "updated_at",
        description: "updated_at",
        type: "string",
        format: "date-time"
    )]
    #[OAT\Property(
        property: "meta",
        description: "meta",
        type: "array",
        items: new OAT\Items(type: "string")
    )]
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
            'application_name' => $this->application?->name,
            'service_version_id' => $this->service_version_id,
            'service_name' => $this->serviceVersion?->service?->name,
            'service_id' => $this->serviceVersion?->service?->id,
            'service_version' => $this->serviceVersion?->version,
            'environment_id' => $this->environment_id,
            'environment_name' => $this->environment->name,
            'hosting_id' => $this->hosting_id,
            'hosting_name' => $this->hosting->name,
            'service_git_repo' => $this->serviceVersion?->service?->git_repo,
            'url' => $this->url,
            'role' => $this->role,
            'statut' => $this->statut,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'meta' => $this->additional,
        ];
    }
}
