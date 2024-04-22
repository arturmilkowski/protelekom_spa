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
use App\Http\Controllers\Api\Page\{IndexController, AboutController};
use App\Http\Controllers\Api\Product\ShowController as ProductShowController;



Route::get('/', IndexController::class)->name('pages.index');
Route::get('about', AboutController::class)->name('pages.about');
Route::get('products/{product:slug}', ProductShowController::class)->name('products.show');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('admins/products/brands', BrandController::class)->names('admins.brands');
    Route::apiResource('admins/products/categories', CategoryController::class)->names('admins.categories');
    Route::apiResource('admins/products/conditions', ConditionController::class)->names('admins.conditions');
    Route::apiResource('admins/products/products', ProductController::class)->names('admins.products');
    Route::delete('admins/products/products/images/{product}', DestroyProductImageController::class)->name('admins.products.images.destroy');
    Route::apiResource('admins/products/{product}/types', TypeController::class)->names('admins.types');
    Route::delete('admins/products/{product}/types/images/{type}', DestroyTypeImageController::class)->name('admins.types.images.destroy');

    Route::post('admins/slugs', SlugController::class)->name('admins.slugs');
});


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
