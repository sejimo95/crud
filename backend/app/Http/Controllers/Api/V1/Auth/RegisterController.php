<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

//     register
    public function register()
    {
        // validate
        $data = json_decode(request()->data, true);
        $validator = Validator::make($data, [
            'first_name' => 'required|string|max:255|min:2',
            'last_name' => 'nullable|string|max:255|min:2',
            'email' => 'required|string|email|max:255|min:6|unique:users,email',
            'password' => 'required|string|min:8|max:250'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        // user store
        User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        // user login
        $login = new ClientLoginController;
        return $login->login();
    }

}
