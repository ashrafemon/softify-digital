<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('profile')->where('role', 'user')->get();
        return response(['status' => 'done', 'users' => $users]);
    }

    public function show($id)
    {
        $user = User::with('profile')->where('id', $id)->first();

        if ($user === null) {
            return response(['status' => 'error', 'message' => 'User not found...'], 404);
        }

        return response(['status' => 'done', 'user' => $user], 200);
    }

    public function update($id)
    {
        $user = User::with('profile')->where('id', $id)->first();

        if ($user === null) {
            return response(['status' => 'error', 'message' => 'User not found...'], 404);
        }

        $user->user_name = request('user_name') ?? $user->user_name;
        $user->profile->first_name = request('first_name') ?? $user->profile->first_name;
        $user->profile->last_name = request('last_name') ?? $user->profile->last_name;
        $user->profile->phone = request('phone') ?? $user->profile->phone;
        $user->profile->address = request('address') ?? $user->profile->address;
        $user->profile->status = request('status') ?? $user->profile->status;
        $user->push();

        return response([
            'status' => 'done',
            'message' => 'User updated successful',
            'user' => $user
        ], 201);
    }

    public function destroy($id)
    {
        User::with('profile')->where('id', $id)->delete();
        return response(['status' => 'done', 'message' => 'User deleted successful',], 201);
    }
}
