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

class NotFoundItemResponse extends OAT\Response
{
    public function __construct()
    {
        parent::__construct(
            response: 404,
            description: 'Resource not found',
            content: new OAT\JsonContent(
                type: 'object',
                properties: [
                    new OAT\Property(property: 'message', type: 'string'),
                    new OAT\Property(property: 'exception', type: 'string'),
                    new OAT\Property(property: 'file', type: 'string'),
                    new OAT\Property(property: 'line', type: 'integer'),
                    new OAT\Property(
                        property: 'trace',
                        type: 'array',
                        items: new OAT\Items(
                            properties: [
                                new OAT\Property(property: 'file', type: 'string'),
                                new OAT\Property(property: 'line', type: 'integer'),
                                new OAT\Property(property: 'function', type: 'string'),
                                new OAT\Property(property: 'class', type: 'string'),
                                new OAT\Property(property: 'type', type: 'string')
                            ]
                        )
                    )
                ]
            )
        );
    }
}
