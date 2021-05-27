<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();

        return response([
            'status' => 'done',
            'products' => $products
        ]);
    }

    public function store()
    {
        $validate = Validator::make(request()->all(), [
            'name' => 'required|min: 3',
            'category_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        if ($validate->fails()) {
            return response([
                'status' => 'validate_error',
                'errors' => $validate->errors()
            ]);
        }

        $data = [
            'name' => request('name'),
            'category_id' => request('category_id'),
            'description' => request('description'),
            'slug' => Str::slug(request('name') . '-' . uniqid()),
            'price' => request('price'),
            'stock' => request('stock')
        ];

        $images = [];

        if (request()->has('image_1')) {
            $file = request()->file('image_1');

            $upload_url = cloudinary()->upload($file->getRealPath(), [
                'folder' => 'softify-digital/images/products/',
                'public_id' => $data['name'] . '-' . uniqid(),
                'overwrite' => true,
                'resource_type' => 'image'
            ])->getSecurePath();

            array_push($images, $upload_url);
        }

        if (request()->has('image_2')) {
            $file = request()->file('image_2');

            $upload_url = cloudinary()->upload($file->getRealPath(), [
                'folder' => 'images/products/',
                'public_id' => $data['name'] . '-' . uniqid(),
                'overwrite' => true,
                'resource_type' => 'image'
            ])->getSecurePath();

            array_push($images, $upload_url);
        }

        if (request()->has('image_3')) {
            $file = request()->file('image_3');

            $upload_url = cloudinary()->upload($file->getRealPath(), [
                'folder' => 'images/products/',
                'public_id' => $data['name'] . '-' . uniqid(),
                'overwrite' => true,
                'resource_type' => 'image'
            ])->getSecurePath();

            array_push($images, $upload_url);
        }

        $data['images'] = $images;
        $product = Product::create($data);

        return response([
            'status' => 'done',
            'message' => 'Product added successful',
            'product' => $product
        ], 201);
    }

    public function show($id)
    {
        $product = Product::with('category')->where('id', $id)->first();

        if ($product === null) {
            return response([
                'status' => 'error',
                'message' => 'Product not found...'
            ], 404);
        }

        return response([
            'status' => 'done',
            'product' => $product
        ], 200);
    }

    public function update($id)
    {
        $product = Product::with('category')->where('id', $id)->first();

        if ($product === null) {
            return response([
                'status' => 'error',
                'message' => 'Product not found...'
            ], 404);
        }

        $product->name = request('name') ?? $product->name;
        if (request('name')) {
            $product->slug = Str::slug(request('name') . '-' . uniqid());
        }
        $product->category_id = request('category_id') ?? $product->category_id;
        $product->description = request('description') ?? $product->description;
        $product->price = request('price') ?? $product->price;
        $product->stock = request('stock') ?? $product->stock;
        $product->status = request('status') ?? $product->status;
        $product->update();

        return response([
            'status' => 'done',
            'message' => 'Product updated successful',
            'product' => $product
        ], 201);
    }

    public function destroy($id)
    {
        $product = Product::where('id', $id)->delete();

        if ($product === 0) {
            return response([
                'status' => 'error',
                'message' => 'Product not found...',
            ], 404);
        }

        return response([
            'status' => 'done',
            'message' => 'Product deleted successful',
        ], 201);
    }
}
