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

class SuccessDeleteResponse extends OAT\Response
{
    public function __construct(string $description)
    {
        parent::__construct(
            response: 200,
            description: $description,
            content: new OAT\JsonContent(
                type: 'object',
                properties: [
                    new OAT\Property(property: 'success', type: 'boolean'),
                    new OAT\Property(property: 'message', type: 'string'),
                ]
            ),
        );
    }
}
