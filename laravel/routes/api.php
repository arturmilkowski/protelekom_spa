<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\Product\{
    BrandController,
    CategoryController,
    ConditionController,
    ProductController,
    DestroyProductImageController,
    TypeController,
    DestroyTypeImageController
};
use App\Http\Controllers\Api\Admin\Slug\SlugController;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('admins/products/brands', BrandController::class);
    Route::apiResource('admins/products/categories', CategoryController::class);
    Route::apiResource('admins/products/conditions', ConditionController::class);
    Route::apiResource('admins/products/products', ProductController::class);
    Route::delete('admins/products/products/images/{product}', DestroyProductImageController::class);
    Route::apiResource('admins/products/{product}/types', TypeController::class);
    Route::delete('admins/products/{product}/types/images/{type}', DestroyTypeImageController::class);

    Route::post('slugs', SlugController::class)->name('api.slugs');
});
