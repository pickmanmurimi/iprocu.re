<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRolesRequest;
use App\Http\Requests\UpdateRolesRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RolesController extends Controller
{

    /**
     * get all roles
     * @throws AuthorizationException
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        // authorize ability to view all roles
        $this->authorize('viewAny', Role::class);

        $roles = Role::orderBy('created_at','desc')->with('permissions')->get();
        return RoleResource::collection($roles);
    }

    /**
     * get specific role
     * @param $id
     * @return RoleResource
     * @throws AuthorizationException
     */
    public function show($id): RoleResource
    {
        // authorize ability to view a role
        $this->authorize('viewAny', Role::class);

        $role = Role::findOrFail( $id );

        return new RoleResource( $role );
    }

    /**
     * @param CreateRolesRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function create(CreateRolesRequest $request): JsonResponse
    {
        // authorize ability to create roles
        $this->authorize('create', Role::class);

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

    /**
     * @param UpdateRolesRequest $request
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateRolesRequest $request, $id): JsonResponse
    {
        // authorize ability to update roles
        $this->authorize('update', Role::class);

        $role = Role::findOrFail( $id );

        try {
            /** @var Role $role */
            $role->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            $role->permissions()->sync($request->permissions);

            return $this->sendSuccess('Role updated', 200);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * delete a role
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function delete($id): JsonResponse
    {
        // authorize ability to update roles
        $this->authorize('destroy', Role::class);

        $role = Role::findOrFail( $id );

        $role->delete();

        return $this->sendSuccess('Role deleted', 200);
    }

}
