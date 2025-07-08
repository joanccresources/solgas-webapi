<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    private const FOLDER_IMAGE =  DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => $this->image,
            'path' => $this->image ? self::FOLDER_IMAGE . $this->image : null,
            'avatar_initials' => $this->avatar_initials,
            'active' => $this->active,
            'rol_id' => COUNT($this->roles) > 0 ? $this->roles[0]->id : '',
            'role' => COUNT($this->roles) > 0 ?  new RoleResource($this->roles[0]) : array(),
            'notifications' => $this->notifications,
            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
        ];
    }
}
