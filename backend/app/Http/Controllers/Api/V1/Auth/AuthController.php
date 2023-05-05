<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // is-login
    public function isLogin() {
        if (auth()->guard('client')->check()) {
            return response()->json(['user' => auth()->guard('client')->user()], 200);
        }
        elseif(auth()->guard('admin')->check()) {
            return response()->json(['user' => auth()->guard('admin')->user()], 200);
        }
        else {
            return response()->json(['user' => null, 'isLogout' => false], 401);
        }
    }

    // logout
    public function logout()
    {
        auth()->guard('client')->logout();
        auth()->guard('admin')->logout();
        return response()->json(['success' => true]);
    }

}
