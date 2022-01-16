<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductsRequest;
use App\Http\Requests\CreateRolesRequest;
use App\Http\Requests\CreateUsersRequest;
use App\Http\Requests\UpdateRolesRequest;
use App\Http\Requests\UpdateUsersRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductsController extends Controller
{

    /**
     * get all roles
     * @throws AuthorizationException
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        // authorize ability to view all products
        $this->authorize('viewAny', Product::class);

        $products = Product::orderBy('created_at','desc')->get();
        return ProductResource::collection($products);
    }

    /**
     * get specific role
     * @param $id
     * @return ProductResource
     * @throws AuthorizationException
     */
    public function show($id): ProductResource
    {
        // authorize ability to view a product
        $this->authorize('viewAny', Product::class);

        $product = Product::findOrFail( $id );

        return new ProductResource( $product );
    }

    /**
     * @param CreateProductsRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function create(CreateProductsRequest $request): JsonResponse
    {
        // authorize ability to create products
        $this->authorize('create', Product::class);

        try {
            /** @var User $user */
            $user = auth()->user();

            $user->products()->create([
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'category' => $request->category,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'manufacturer' => $request->manufacturer,
                'distributor' => $request->distributor,
            ]);

            return $this->sendSuccess('Product created', 201);
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
        $this->authorize('destroy', User::class);

        $user = User::findOrFail( $id );

        $user->delete();

        return $this->sendSuccess('User deleted', 200);
    }

}
