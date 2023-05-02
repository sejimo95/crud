<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // is-login
    public function isLogin() {
        if (auth()->guard('client')->check()) {
            return ['success' => true, 'user' => auth()->guard('client')->user()];
        }
        elseif(auth()->guard('admin')->check()) {
            return ['success' => true, 'user' => auth()->guard('admin')->user()];
        }
        else {
            return ['success' => false, 'user' => null,'isLogout' => false];
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
