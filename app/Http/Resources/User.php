<?php

namespace App\Http\Resources;
use App\Http\Resources\Projet as ProjetResource;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
        'name' => $this->name,
        'email' => $this->email,
        'projets' => ProjetResource::collection($this->projets),
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
        ];
    }
}
