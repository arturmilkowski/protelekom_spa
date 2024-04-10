<?php

namespace App\Http\Controllers\Api\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\Admin\Product\StoreBrandRequest;
use App\Http\Resources\Admin\Product\BrandResource;
use App\Models\Admin\Product\Brand;

class BrandController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return BrandResource::collection(Brand::latest()->get());
    }

    public function store(StoreBrandRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $brand = Brand::create($validated);

        return response()->json($brand, 201);
    }

    public function show(Brand $brand): BrandResource
    {
        return new BrandResource($brand);
    }

    public function update(StoreBrandRequest $request, Brand $brand): JsonResponse
    {
        $validated = $request->validated();
        $brand->update($validated);

        return response()->json($brand, 200);
    }

    public function destroy(Brand $brand): Response
    {
        $brand->delete();

        return response()->noContent();
    }
}
