<?php

namespace App\Http\Controllers\Api\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product\Product;
use App\Http\Resources\Page\ProductResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $products = Product::latest()->get();

        return ProductResource::collection($products);
    }
}
