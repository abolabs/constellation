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

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OAT;

class GetListAppBaseAPIRequest extends FormRequest
{
    #[OAT\Parameter(
        name: "perPage",
        parameter: "base-filter-per-page",
        description: "Number of items displayed by page.",
        in: 'query',
        schema: new OAT\Schema(
            type: "integer",
            default: 100,
            enum: [5, 10, 25, 100, 1000]
        )
    )]
    #[OAT\Parameter(
        name: "page",
        parameter: "base-filter-page",
        description: "Current page.",
        in: 'query',
        schema: new OAT\Schema(
            type: "integer"
        )
    )]
    #[OAT\Parameter(
        name: "sort",
        parameter: "base-filter-sort",
        description: "Field used to sort the result.",
        in: 'query',
        examples: [new OAT\Examples(example: "string", value: "-id", summary: "-id")],
        schema: new OAT\Schema(
            type: "string",
        )
    )]
    #[OAT\Parameter(
        name: 'q',
        parameter: "base-filter-q",
        description: "Query string",
        in: 'query',
        required: false,
        schema: new OAT\Schema(
            type: "string",
        )
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'perPage' => ['nullable', Rule::in([5, 10, 25, 100, 1000])],
            'page' => 'nullable|numeric',
            'sort' => 'nullable|string',
            'filter' => 'nullable|array',
            'q' => 'nullable|string',
        ];
    }
}
