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
    title: "ServiceInstanceDependencies",
    schema: "resource-service-instance-dependencies",
    description: "Service instance dependencies resource",
    type: "object"
)]
class ServiceInstanceDependenciesResource extends JsonResource
{
    #[OAT\Property(
        property: "id",
        description: "Id",
        type: "integer"
    )]
    #[OAT\Property(
        property: "instance_application_id",
        description: "Instance application id",
        type: "integer"
    )]
    #[OAT\Property(
        property: "instance_application_name",
        description: "Instance application name",
        type: "string"
    )]
    #[OAT\Property(
        property: "instance_id",
        description: "Instance id",
        type: "integer"
    )]
    #[OAT\Property(
        property: "instance_service_name",
        description: "Instance service name",
        type: "string"
    )]
    #[OAT\Property(
        property: "instance_dep_application_id",
        description: "Application id of the instance dependency",
        type: "integer"
    )]
    #[OAT\Property(
        property: "instance_dep_application_name",
        description: "Application name of the instance dependency",
        type: "string"
    )]
    #[OAT\Property(
        property: "instance_dep_id",
        description: "Instance dependency id",
        type: "integer"
    )]
    #[OAT\Property(
        property: "instance_dep_service_name",
        description: "Service name of the instance dependency",
        type: "string"
    )]
    #[OAT\Property(
        property: "level",
        description: "Dependency level (1: minor, 2: major, 3: critical)",
        type: "integer",
        enum: [1, 2, 3]
    )]
    #[OAT\Property(
        property: "description",
        description: "Dependency description",
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
            'instance_application_id' => $this->serviceInstance?->application?->id,
            'instance_application_name' => $this->serviceInstance?->application?->name,
            'instance_id' => $this->instance_id,
            'instance_service_name' => $this->serviceInstance?->serviceVersion?->service?->name,
            'instance_dep_application_id' => $this->serviceInstanceDep?->application?->id,
            'instance_dep_application_name' => $this->serviceInstanceDep?->application?->name,
            'instance_dep_id' => $this->instance_dep_id,
            'instance_dep_service_name' => $this->serviceInstanceDep?->serviceVersion?->service?->name,
            'level' => $this->level,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
