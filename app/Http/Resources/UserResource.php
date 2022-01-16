<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $first_name
 * @property mixed $last_name
 * @property mixed $phone_number
 * @property mixed $email
 * @property mixed $roles
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource ? [
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'phoneNumber' => $this->phone_number,
            'email' => $this->email,
            'roles' => RoleResource::collection($this->roles),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ] : [];
    }
}
