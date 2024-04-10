<?php

namespace App\Http\Controllers\Api\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Resources\Admin\Product\ProductResource;
use App\Models\Admin\Product\Product;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(Product::latest()->get());
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function update(StoreProductRequest $request, Product $product): JsonResponse
    {
        $validated = $request->validated();
        $product->update($validated);

        return response()->json($product, 200);
    }

    public function destroy(Product $product): Response
    {
        $product->delete();

        return response()->noContent();
    }
}
