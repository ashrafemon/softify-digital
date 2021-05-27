<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'carts' => function ($q) {
                return $q->with('product')->get();
            }
        ])->get();
        return response(['status' => 'done', 'orders' => $orders]);
    }

    public function update($id)
    {
        $validate = Validator::make(request()->all(), [
            'status' => 'required'
        ]);

        if ($validate->fails()) {
            return response(['status' => 'validate_error', 'errors' => $validate->errors()]);
        }

        $order = Order::with([
            'carts' => function ($q) {
                return $q->with('products')->get();
            }
        ])->where('id', $id)->first();

        $order->status = request('status');
        $order->update();

        return response(['status' => 'done', 'message' => 'Order update successful', 'order' => $order]);
    }

    public function destroy($id)
    {
        $order = Order::with([
            'carts' => function ($q) {
                return $q->with('products')->get();
            }
        ])->where('id', $id)->first();

        if ($order === null) {
            return response(['status' => 'error', 'message' => 'Order not found...']);
        }

        $order->carts->each(function ($item) {
            $item->delete();
        });
        $order->delete();

        return response([
            'status' => 'done',
            'message' => 'Order deleted successful'
        ]);
    }

}
