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

use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: "Import application",
    schema: "request-import-application",
    description: "Import an application request",
    type: "object",
    required: [
        "name",
        "team_id",
        "environment_id",
        "hosting_id",
        "default_service_status",
        "stack_file"
    ]
)]
class ImportApplicationAPIRequest extends APIRequest
{
    #[OAT\Property(
        property: "name",
        description: "Name",
        type: "string"
    )]
    #[OAT\Property(
        property: "team_id",
        description: "Team id",
        type: "integer",
    )]
    #[OAT\Property(
        property: "environment_id",
        description: "Environment id",
        type: "integer",
    )]
    #[OAT\Property(
        property: "hosting_id",
        description: "Hosting id",
        type: "integer",
    )]
    #[OAT\Property(
        property: "default_service_status",
        description: "Default service status",
        type: "boolean"
    )]
    #[OAT\Property(
        property: "stack_file",
        description: "Stack file, base64 encoded",
        example: "data:application/octet-stream;base64,dmVyc2lvbjogJzMuOCcKCnNlcnZpY2VzOgogIG1haWxkZXY6CiAgICBpbWFnZTogZGpmYXJyZWxseS9tYWlsZGV2CiAgICBwb3J0czoKICAgICAgLSAiJHtTTVRQfToyNSIKICAgICAgLSAiJHtXRUJVSX06ODAiCgogIG1hcmlhZGI6CiAgICBpbWFnZTogbWFyaWFkYjoxMC41CiAgICBlbnZpcm9ubWVudDoKICAgICAgTUFSSUFEQl9ST09UX1BBU1NXT1JEOiAke01BUklBREJfUk9PVF9QQVNTV09SRH0KICAgICAgTUFSSUFEQl9VU0VSOiAke01BUklBREJfVVNFUn0KICAgICAgTUFSSUFEQl9QQVNTV09SRDogJHtNQVJJQURCX1BBU1NXT1JEfQogICAgICBNQVJJQURCX0RBVEFCQVNFOiAke01BUklBREJfREFUQUJBU0V9CiAgICBwb3J0czoKICAgICAgLSAiJHtNQVJJQURCX1BPUlQtMzMwNn06MzMwNiIKICAgIHZvbHVtZXM6CiAgICAgIC0gJHtEQVRBX1ZPTFVNRX0vbWFyaWFkYjovdmFyL2xpYi9teXNxbAoKICB3ZWItdWk6CiAgICAgIGJ1aWxkOgogICAgICAgIGNvbnRleHQ6IC4KICAgICAgICBkb2NrZXJmaWxlOiB3ZWItdWkvRG9ja2VyZmlsZQogICAgICAgIGFyZ3M6CiAgICAgICAgLSBNWVVTRVI9JHtNWVVTRVJ9CiAgICAgIHBvcnRzOgogICAgICAgIC0gIiR7SFRUUC0zMDAwfTozMDAwIgogICAgICB2b2x1bWVzOgogICAgICAgIC0gICR7RlJPTlRfU09VUkNFX1ZPTFVNRX06L3Zhci93d3cKICAgICAgZGVwZW5kc19vbjoKICAgICAgICAtIGFwaQoKICBuZ2lueDoKICAgICAgaW1hZ2U6IG5naW54OmxhdGVzdAogICAgICBwb3J0czoKICAgICAgICAtICIke0FQSV9QT1JULTgwODB9OjgwIgogICAgICB2b2x1bWVzOgogICAgICAgIC0gICR7QVBJX1NPVVJDRV9WT0xVTUV9Oi92YXIvd3d3CiAgICAgICAgLSAke0RBVEFfVk9MVU1FfS9uZ2lueDovdmFyL2xvZy9uZ2lueAogICAgICAgIC0gLi9uZ2lueC9kZWZhdWx0LmNvbmY6L2V0Yy9uZ2lueC9jb25mLmQvZGVmYXVsdC5jb25mCiAgYXBpOgogICAgICBidWlsZDoKICAgICAgICBjb250ZXh0OiAuCiAgICAgICAgZG9ja2VyZmlsZTogYXBpL0RvY2tlcmZpbGUKICAgICAgICBhcmdzOgogICAgICAgIC0gTVlVU0VSPSR7TVlVU0VSfQogICAgICB2b2x1bWVzOgogICAgICAgIC0gICR7QVBJX1NPVVJDRV9WT0xVTUV9Oi92YXIvd3d3CiAgICAgIGRlcGVuZHNfb246CiAgICAgICAgLSBuZ2lueAogICAgICAgIC0gcmVkaXMKICAgICAgICAtIG1hcmlhZGIKICAgICAgICAtIG1laWxpc2VhcmNoCgogIHJlZGlzOgogICAgaW1hZ2U6IHJlZGlzCiAgICBwb3J0czoKICAgICAgLSAiJHtSRURJU19QT1JULTYzNzl9OjYzNzkiCiAgICB2b2x1bWVzOgogICAgICAtICR7REFUQV9WT0xVTUV9L3JlZGlzOi9kYXRhCgogIG1laWxpc2VhcmNoOgogICAgaW1hZ2U6IGdldG1laWxpL21laWxpc2VhcmNoOnYxLjEKICAgIGVudmlyb25tZW50OgogICAgICAtIE1FSUxJX01BU1RFUl9LRVk9JHtNRUlMSV9NQVNURVJfS0VZfQogICAgdm9sdW1lczoKICAgICAgLSAke0RBVEFfVk9MVU1FfS9tZWlsaV9kYXRhOi9tZWlsaV9kYXRhCiAgICBwb3J0czoKICAgICAtICIke01FSUxJX01BU1RFUl9QT1JULTc3MDB9Ojc3MDAiCiAgICBkZXBlbmRzX29uOgogICAgICAtIG1hcmlhZGIKCg==",
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
        return  [
            'name' => 'required|string|max:255',
            'team_id' => 'required|exists:team,id',
            'environment_id' => 'required|exists:environment,id',
            'hosting_id' => 'required|exists:hosting,id',
            'default_service_status' => 'required|boolean',
            'stack_file' => 'required',
        ];
    }
}
