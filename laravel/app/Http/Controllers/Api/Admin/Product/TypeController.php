<?php

namespace App\Http\Controllers\Api\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\Admin\Product\StoreTypeRequest;
use App\Http\Resources\Admin\Product\TypeResource;
use App\Models\Admin\Product\{Product, Type};
use App\Services\File;

class TypeController extends Controller
{
    /*
    public function index(): AnonymousResourceCollection
    {
        return TypeResource::collection(Type::latest()->get());
    }

    public function store(StoreTypeRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $file = $request->file('img');
        if ($file) {
            $extension = $file->extension();
            $filename = $validated['slug'] . '.' . $extension;
            File::store($request, config('settings.filepath.type'), $filename);
            $validated['img'] = $filename;
        }

        $type = Type::create($validated);

        return response()->json($type, 201);
    }

    public function show(Type $type): TypeResource
    {
        return new TypeResource($type);
    }

    public function update(StoreTypeRequest $request, Type $type): JsonResponse
    {
        $validated = $request->validated();

        $file = $request->file('img');
        if ($file) {
            $extension = $file->extension();
            $filename = $validated['slug'] . '.' . $extension;
            $path = File::update($request, $type->img, config('settings.filepath.type'), $filename);
            if ($path) {
                $validated['img'] = $filename; // assign new path
            }
        }

        $type->update($validated);

        return response()->json($type, 200);
    }

    public function destroy(Type $type): Response
    {
        if ($type->img) {
            Storage::delete(config('settings.filepath.type') . $type->img);
        }
        $type->delete();

        return response()->noContent();
    }
    */

    public function index(Product $product): AnonymousResourceCollection
    {
        return TypeResource::collection($product->types);
    }

    public function store(StoreTypeRequest $request, Product $product): JsonResponse
    {
        $validated = $request->validated();

        $file = $request->file('img');
        if ($file) {
            $extension = $file->extension();
            $filename = $validated['slug'] . '.' . $extension;
            File::store($request, config('settings.filepath.type'), $filename);
            $validated['img'] = $filename;
        }
        $type = $product->types()->create($validated);

        return response()->json($type, 201);
    }

    public function show(Product $product, Type $type): TypeResource
    {
        return new TypeResource($type);
    }

    public function update(StoreTypeRequest $request, Product $product, Type $type): JsonResponse
    {
        $validated = $request->validated();

        $file = $request->file('img');
        if ($file) {
            $extension = $file->extension();
            $filename = $validated['slug'] . '.' . $extension;
            $path = File::update($request, $product->img, config('settings.filepath.type'), $filename);
            if ($path) {
                $validated['img'] = $filename; // assign new path
            }
        }

        $type->update($validated);
        // $type = $product->types()->save($validated);

        return response()->json($type, 200);
    }

    public function destroy(Product $product, Type $type): Response
    {
        if ($type->img) {
            Storage::delete(config('settings.filepath.type') . $type->img);
        }

        $type->delete();

        return response()->noContent();
    }
}
