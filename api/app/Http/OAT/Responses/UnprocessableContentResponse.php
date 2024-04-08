<?php

// Copyright (C) 2023 Abolabs (https://gitlab.com/abolabs/)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program. If not, see

namespace App\Http\OAT\Responses;

use OpenApi\Attributes as OAT;

class UnprocessableContentResponse extends OAT\Response
{
    public function __construct()
    {
        parent::__construct(
            response: 422,
            description: 'Invalid inputs.',
            content: new OAT\JsonContent(
                type: 'object',
                properties: [
                    new OAT\Property(
                        property: 'errors',
                        type: 'object',
                        properties: [
                            new OAT\Property(
                                property: '{name-of-invalid-field}',
                                type: 'array',
                                items: new OAT\Items(
                                    description: "Error message",
                                    type: "string"
                                )
                            )
                        ]
                    ),
                    new OAT\Property(property: 'message', type: 'string'),
                ]
            )
        );
    }
}
