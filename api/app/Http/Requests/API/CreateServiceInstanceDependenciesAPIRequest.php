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

use App\Models\ServiceInstanceDependencies;
use App\Rules\ServiceInstancesDep\ServiceInstancesHasSameEnv;
use InfyOm\Generator\Request\APIRequest;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: "Create service instance dependency",
    schema: "request-create-service-instance-dependency",
    description: "Create service instance dependency request",
    type: "object",
    required: ["instance_id", "instance_dep_id"]
)]
class CreateServiceInstanceDependenciesAPIRequest extends APIRequest
{
    #[OAT\Property(
        property: "instance_id",
        description: "Instance id",
        type: "integer"
    )]
    #[OAT\Property(
        property: "instance_dep_id",
        description: "Instance dependency id",
        type: "integer"
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
        return [
            'instance_id' => [
                new ServiceInstancesHasSameEnv($this->all()),
                ...ServiceInstanceDependencies::$rules['instance_id'],
            ],
            'instance_dep_id' => [
                ...ServiceInstanceDependencies::$rules['instance_dep_id'],
            ],
            'level' => 'integer|between:1,3',
            'description' => 'string|nullable|max:255',
        ];
    }
}
