<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->get();
        return response(['status' => 'done', 'categories' => $categories]);
    }

    public function store()
    {
        $validate = Validator::make(request()->all(), [
            'name' => 'required|min: 3',
        ]);

        if ($validate->fails()) {
            return response([
                'status' => 'validate_error',
                'errors' => $validate->errors()
            ]);
        }

        $category = Category::create([
            'name' => request('name'),
            'slug' => Str::slug(request('name') . '-' . uniqid()),
        ]);

        return response([
            'status' => 'done',
            'message' => 'Category added successful',
            'category' => $category
        ], 201);
    }

    public function show($id)
    {
        $category = Category::with('products')->where('id', $id)->first();

        if ($category === null) {
            return response([
                'status' => 'error',
                'message' => 'Category not found...'
            ], 404);
        }

        return response(['status' => 'done', 'category' => $category], 200);
    }

    public function update($id)
    {
        $validate = Validator::make(request()->all(), [
            'name' => 'required|min: 3',
        ]);

        if ($validate->fails()) {
            return response([
                'status' => 'validate_error',
                'errors' => $validate->errors()
            ]);
        }

        $category = Category::where('id', $id)->first();

        if ($category === null) {
            return response([
                'status' => 'error',
                'message' => 'Category not found...'
            ], 404);
        }

        $category->name = request('name') ?? $category->name;
        if (request('name')) {
            $category->slug = Str::slug(request('name') . '-' . uniqid());
        }
        $category->update();

        return response([
            'status' => 'done',
            'message' => 'Category updated successful',
            'category' => $category
        ], 201);
    }

    public function destroy($id)
    {
        Category::where('id', $id)->delete();

        return response([
            'status' => 'done',
            'message' => 'Category deleted successful',
        ], 201);
    }
}
