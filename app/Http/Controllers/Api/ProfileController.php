<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::with('profile')->where('id', auth()->id())->first();
        return response(['status' => 'done', 'user' => $user]);
    }
}
