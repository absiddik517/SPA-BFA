<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      return [
        'id'                => $this->id,
        'name'              => $this->name,
        'email'             => $this->email,
        'role_id'           => $this->role_id ?? null,
        'role'              => $this->role_name,
        'profile_photo_url' => $this->profile_photo_url,
      ];
    }
}
