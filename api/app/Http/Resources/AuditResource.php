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
    title: "Audit",
    schema: "resource-audit",
    description: "Audit resource",
    type: "object"
)]

class AuditResource extends JsonResource
{
    #[OAT\Property(
        property: "id",
        description: "Id",
        type: "integer"
    )]
    #[OAT\Property(
        property: "user_type",
        description: "User type",
        type: "string"
    )]
    #[OAT\Property(
        property: "user_id",
        description: "User id",
        type: "integer"
    )]
    #[OAT\Property(
        property: "user_name",
        description: "User name",
        type: "string"
    )]
    #[OAT\Property(
        property: "event",
        description: "Event",
        type: "string"
    )]
    #[OAT\Property(
        property: "auditable_type",
        description: "Auditable type",
        type: "string"
    )]
    #[OAT\Property(
        property: "auditable_id",
        description: "Auditable id",
        type: "integer"
    )]
    #[OAT\Property(
        property: "old_values",
        description: "Old values",
        type: "string"
    )]
    #[OAT\Property(
        property: "new_values",
        description: "New values",
        type: "string"
    )]
    #[OAT\Property(
        property: "url",
        description: "Url",
        type: "string"
    )]
    #[OAT\Property(
        property: "ip_address",
        description: "Ip address",
        type: "string"
    )]
    #[OAT\Property(
        property: "user_agent",
        description: "User-agent",
        type: "string"
    )]
    #[OAT\Property(
        property: "tags",
        description: "Tags",
        type: "string"
    )]
    #[OAT\Property(
        property: "created_at",
        description: "Creation date",
        type: "string",
        format: "date-time"
    )]
    #[OAT\Property(
        property: "updated_at",
        description: "Last update date",
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
            'user_type' => $this->user_type,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name ?? '',
            'event' => $this->event,
            'auditable_type' => $this->auditable_type,
            'auditable_id' => $this->auditable_id,
            'old_values' => $this->old_values,
            'new_values' => $this->new_values,
            'url' => $this->url,
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'tags' => $this->tags,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
