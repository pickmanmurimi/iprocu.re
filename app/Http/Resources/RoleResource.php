<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $name
 * @property mixed $description
 * @property mixed $permissions
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $id
 * @method relationLoaded(string $string)
 */
class RoleResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            // only show permissions if lazy loaded
            'permissions' => $this->relationLoaded('permissions') ? PermissionResource::collection( $this->permissions ) : [],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ] : [];
    }
}
