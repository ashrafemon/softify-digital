<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->where('status', 'active')->get();
        return response(['status' => 'done', 'products' => $products], 200);
    }

    public function show($slug)
    {
        $product = Product::with('category')->where('slug', $slug)->where('status', 'active')->first();

        if ($product === null) {
            return response(['status' => 'error', 'message' => 'Product not found...'], 404);
        }

        return response(['status' => 'done', 'product' => $product], 200);
    }

    public function new_arrivals()
    {
        $products = Product::with('category')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get();

        return response([
            'status' => 'done',
            'products' => $products
        ]);
    }
}
