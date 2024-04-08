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
    title: "Application",
    schema: "resource-application",
    description: "Application resource",
    type: "object"
)]
class ApplicationResource extends JsonResource
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
        property: "team_id",
        description: "Team id",
        type: "integer"
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
            'name' => $this->name,
            'team_id' => $this->team_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'meta' => $this->additional,
        ];
    }
}
