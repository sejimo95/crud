<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ClientLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:client', ['except' => ['login']]);
    }

    // login
    public function login()
    {
        // validate
        $data = json_decode(request()->data, true);
        $validator = Validator::make($data, [
            'email' => 'required|string|email|max:191|min:6',
            'password' => 'required|string|min:6|max:191',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        // check pass & email
        if (!$token = auth()->guard('client')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            return response()->json(['message' => 'Unauthorized'],401);
        }

        return response()->json(['user' => auth()->guard('client')->user(), 'token' => $token], 200);
    }

}
