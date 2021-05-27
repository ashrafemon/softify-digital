<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with([
            'product' => function ($q) {
                return $q->with('category')->get();
            }
        ])->where('user_id', auth()->id())
            ->where('status', 'unordered')
            ->get();
        return response(['status' => 'done', 'carts' => $carts]);
    }

    public function store()
    {
        $validate = Validator::make(request()->all(), [
            'product_id' => 'required',
            'quantity' => 'required|numeric',
            'unit_price' => 'required|numeric',
        ]);

        if ($validate->fails()) {
            return response(['status' => 'validate_error', 'errors' => $validate->errors()]);
        }

        $cart = Cart::where('product_id', request('product_id'))
            ->where('user_id', auth()->id())
            ->where('status', 'unordered')
            ->first();

        if ($cart) {
            $cart->quantity = (int)$cart->quantity + (int)request('quantity');
            $cart->total_price = $cart->quantity * (float)$cart->unit_price;
            $cart->update();

            return response([
                'status' => 'done',
                'message' => 'Product updated to cart...',
            ]);
        }

        Cart::create([
            'product_id' => request('product_id'),
            'user_id' => auth()->id(),
            'quantity' => (int)request('quantity'),
            'unit_price' => (float)request('unit_price'),
            'total_price' => (int)request('quantity') * (float)request('unit_price'),
        ]);

        return response([
            'status' => 'done',
            'message' => 'Product added to cart...',
        ]);
    }

    public function update()
    {

    }

    public function destroy($id)
    {
        $cart = Cart::where('user_id', auth()->id())->where('id', $id)->delete();

        if ($cart === 0) {
            return response(['status' => 'error', 'message' => 'Cart not found...',], 404);
        }

        return response(['status' => 'done', 'message' => 'Cart deleted successful',], 201);
    }
}
