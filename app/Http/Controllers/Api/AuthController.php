<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        $validate = Validator::make(request()->all(), [
            'email' => 'required|exists:users',
            'password' => 'required|min:6'
        ]);

        if ($validate->fails()) {
            return response(['status' => 'validate_error', 'errors' => $validate->errors()]);
        }

        if (!auth()->attempt($validate->validated())) {
            return response(['status' => 'error', 'message' => 'Credentials not matched...']);
        }

        $token = auth()->user()->createToken('authToken');

        return response([
            'status' => 'done',
            'message' => 'Login successful',
            'token' => 'Bearer ' . $token->plainTextToken,
            'user' => auth()->user()
        ]);
    }

    public function register()
    {
        $validate = Validator::make(request()->all(), [
            'user_name' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validate->fails()) {
            return response(['status' => 'validate_error', 'errors' => $validate->errors()]);
        }

        $user = User::create([
            'user_name' => request('user_name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
        ]);

        if ($user) {
            Profile::create([
                'user_id' => $user->id,
                'first_name' => request('first_name'),
                'last_name' => request('last_name'),
                'phone' => request('phone'),
            ]);
        }

        return response(['status' => 'done', 'message' => 'Registration successful']);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response([
            'status' => 'done',
            'message' => 'Successfully logout...',
        ], 200);

    }
}
