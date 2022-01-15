<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRolesRequest;
use App\Models\Role;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * @param CreateRolesRequest $request
     * @return JsonResponse
     */
    public function create(CreateRolesRequest $request): JsonResponse
    {
        try {
            /** @var Role $role */
            $role = Role::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            $role->permissions()->sync($request->permissions);

            return $this->sendSuccess('Role created', 201);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }
}
