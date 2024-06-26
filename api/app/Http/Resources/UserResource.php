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
    title: "User",
    schema: "resource-user",
    description: "User resource",
    type: "object"
)]
class UserResource extends JsonResource
{
    #[OAT\Property(
        property: "id",
        description: "Id",
        type: "integer"
    )]
    #[OAT\Property(
        property: "name",
        description: "Name",
        type: "string"
    )]
    #[OAT\Property(
        property: "email",
        description: "Email",
        type: "string"
    )]
    #[OAT\Property(
        property: "roles",
        description: "Role ids",
        type: "array",
        items: new OAT\Items(
            description: "Role id",
            type: "string"
        )
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
        $formattedRoles = [];
        foreach ($this->roles as $role) {
            $formattedRoles[] = $role['id'];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $formattedRoles,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'meta' => $this->additional,
        ];
    }
}
