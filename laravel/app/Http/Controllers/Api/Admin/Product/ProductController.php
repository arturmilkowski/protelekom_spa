<?php

namespace App\Http\Controllers\Api\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Resources\Admin\Product\ProductResource;
use App\Models\Admin\Product\Product;
use App\Services\File;

class ProductController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(Product::latest()->get());
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $validated = $request->validated();
        
        $file = $request->file('img');
        if ($file) {
            $extension = $file->extension();
            $filename = $validated['slug'] . '.' . $extension;
            File::store($request, config('settings.filepath.product'), $filename);
            $validated['img'] = $filename;
        }

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
        
        $file = $request->file('img');
        if ($file) {
            $extension = $file->extension();
            $filename = $validated['slug'] . '.' . $extension;
            $path = File::update($request, $product->img, config('settings.filepath.product'), $filename);
            if ($path) {
                $validated['img'] = $filename; // assign new path
            }
        }

        $product->update($validated);

        return response()->json($product, 200);
    }

    public function destroy(Product $product): Response
    {
        if ($product->img) {
            Storage::delete(config('settings.filepath.product') . $product->img);
        }
        $product->delete();

        return response()->noContent();
    }
}
