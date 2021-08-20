<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{

    public function register(RegisterRequest $request){
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function token(){
        if (auth()->guard('librarian')->user()){
            return response()->json([
                'verified' => true,
                'role' => 'librarian'
            ]);
        }
        if (auth()->guard('admin')->user()){
            return response()->json([
                'verified' => true,
                'role' => 'admin'
            ]);
        }
        if (auth()->guard('user')->user()){
            return response()->json([
                'verified' => true,
                'role' => 'user'
            ]);
        }

        return response()->json([
            'verified' => false,
        ]);
    }

}
