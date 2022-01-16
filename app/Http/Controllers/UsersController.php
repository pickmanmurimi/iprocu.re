<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsersRequest;
use App\Http\Requests\UpdateRolesRequest;
use App\Http\Requests\UpdateUsersRequest;
use App\Http\Resources\UserResource;
use App\Mail\AccountCreatedMail;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UsersController extends Controller
{

    /**
     * get all roles
     * @throws AuthorizationException
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        // authorize ability to view all roles
        $this->authorize('viewAny', User::class);

        $roles = User::orderBy('created_at','desc')->with('roles')->get();
        return UserResource::collection($roles);
    }

    /**
     * get specific role
     * @param $id
     * @return UserResource
     * @throws AuthorizationException
     */
    public function show($id): UserResource
    {
        // authorize ability to view a role
        $this->authorize('viewAny', User::class);

        $user = User::findOrFail( $id );

        return new UserResource( $user );
    }

    /**
     * @param CreateUsersRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function create(CreateUsersRequest $request): JsonResponse
    {
        // authorize ability to create roles
        $this->authorize('create', User::class);

        try {
            $password = Str::random(6);
            /** @var User $role */
            $user = User::create([
                'firstName' => $request->first_name,
                'lastName' => $request->last_name,
                'phoneNumber' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($password), // Uses bcrypt as the default driver
            ]);

            $user->roles()->sync($request->role);

            // Mail the password
            Mail::to($user)->send( new AccountCreatedMail( $user, $password ));

            return $this->sendSuccess('User created', 201);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * @param UpdateUsersRequest $request
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateUsersRequest $request, $id): JsonResponse
    {
        // authorize ability to update roles
        $this->authorize('update', User::class);

        $user = User::findOrFail( $id );

        try {
            $user->update([
                'firstName' => $request->first_name,
                'lastName' => $request->last_name,
                'phoneNumber' => $request->phone_number,
                'email' => $request->email,
            ]);

            $user->roles()->sync($request->role);

            return $this->sendSuccess('User updated', 200);
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
        $this->authorize('destroy', User::class);

        $user = User::findOrFail( $id );

        $user->delete();

        return $this->sendSuccess('User deleted', 200);
    }

}
