<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
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
            'team_id' => $this->team_id,
            'name' => $this->name,
            'git_repo' => $this->git_repo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
