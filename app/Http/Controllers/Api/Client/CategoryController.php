<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->where('status', 'active')->get();
        return response(['status' => 'done', 'categories' => $categories], 200);
    }

    public function show($slug)
    {
        $category = Category::with('products')->where('slug', $slug)->where('status', 'active')->first();

        if ($category === null) {
            return response(['status' => 'error', 'message' => 'Category not found...'], 404);
        }

        return response(['status' => 'done', 'category' => $category], 200);
    }
}
