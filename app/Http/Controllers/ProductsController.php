<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductsRequest;
use App\Http\Requests\CreateRolesRequest;
use App\Http\Requests\CreateUsersRequest;
use App\Http\Requests\UpdateProductsRequest;
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
     * @param Request $request
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index( Request $request): AnonymousResourceCollection
    {
        // authorize ability to view all products
        $this->authorize('viewAny', Product::class);

        $products = Product::orderBy('created_at','desc')
            ->search('name', $request->name )
            ->lessThan('price', $request->maxprice)
            ->greaterThan('price', $request->minprice)
            ->get();

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
     * get specific role
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function myProducts(): AnonymousResourceCollection
    {
        // authorize ability to view a product
        $this->authorize('view', Product::class);

        /** @var User $user */
        $user = auth()->user();

        /** @var Product $products */
        $products = $user->products;

        return ProductResource::collection( $products );
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
     * @param UpdateProductsRequest $request
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateProductsRequest $request, $id): JsonResponse
    {
        // authorize ability to update roles
        $this->authorize('update', Product::class);

        $product = Product::findOrFail( $id );

        try {
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'category' => $request->category,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'manufacturer' => $request->manufacturer,
                'distributor' => $request->distributor,
            ]);

            return $this->sendSuccess('Product updated', 200);
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
        $this->authorize('destroy', Product::class);

        $product = Product::findOrFail( $id );

        $product->delete();

        return $this->sendSuccess('Product deleted', 200);
    }

}
