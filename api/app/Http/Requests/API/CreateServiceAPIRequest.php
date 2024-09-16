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

namespace App\Http\Requests\API;

use App\Models\Service;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: "Create service",
    schema: "request-create-service",
    description: "Create service request",
    type: "object",
    required: ["name", "team_id"]
)]
class CreateServiceAPIRequest extends APIRequest
{
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
        property: "git_repo",
        description: "Git repository url",
        type: "string"
    )]
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Service::$rules;
    }
}
