<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(): bool|string
    {
        $products = Product::query()->simplePaginate();
        return json_encode([
            'status' => 'success',
            'message' => 'Products',
            'data' => $products
        ]);
    }

    public function get(string $sku): bool|string
    {
        $product = Product::query()->where('sku', $sku)->firstOrFail();
        return json_encode([
           'status' => 'success',
            'message' => 'Product found',
            'data' => $product
        ]);
    }
}
