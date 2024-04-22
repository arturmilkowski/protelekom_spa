<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product\Product;
use App\Http\Resources\Admin\Product\ProductResource;

class ShowController extends Controller
{
    public function __invoke(Product $product): ProductResource
    {
        return new ProductResource($product);
    }
}
