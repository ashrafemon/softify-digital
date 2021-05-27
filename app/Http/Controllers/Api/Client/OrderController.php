<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'carts' => function ($q) {
                return $q->with('products')->get();
            }
        ])
            ->where('user_id', auth()->id())
            ->get();
        return response(['status' => 'done', 'orders' => $orders]);
    }

    public function store()
    {
        $validate = Validator::make(request()->all(), [
            'carts_id' => 'required',
        ]);

        if ($validate->fails()) {
            return response(['status' => 'validate_error', 'errors' => $validate->errors()]);
        }

        $requestCarts = request('carts_id');
        $totalPrice = 0;

        foreach ($requestCarts as $requestCart) {
            $cart = Cart::where('user_id', auth()->id())
                ->where('id', $requestCart)
                ->where('status', 'unordered')
                ->first();
            if ($cart) {
                $totalPrice += (float)$cart->total_price;
            }
        }

        if ($totalPrice === 0) {
            return response([
                'status' => 'error',
                'message' => 'No cart found...'
            ]);
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'carts_id' => (array)request('carts_id'),
            'total_price' => $totalPrice,
            'invoice_id' => 'INVOICE#' . strtoupper(Str::random())
        ]);

        if ($order) {
            foreach ($requestCarts as $requestCart) {
                $cart = Cart::where('user_id', auth()->id())->where('id', $requestCart)->where('status', 'unordered')->first();

                if ($cart) {
                    $cart->status = 1;
                    $cart->order_id = $order->id;
                    $cart->update();
                }
            }
        }

        return response([
            'status' => 'done',
            'message' => 'Checkout complete'
        ]);
    }

    public function cancel_order($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('id', $id)
            ->first();
        $order->status = 4;
        $order->update();

        return response([
            'status' => 'done',
            'message' => 'Order cancelled...'
        ]);
    }
}
