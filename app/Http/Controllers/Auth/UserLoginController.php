<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserLoginController extends Controller
{

    public function login(LoginRequest $request){
        $user = User::where('username', $request->username)->first();
        if(!$user || !Hash::check($request->password, $user->password )){
            return response()->json('Something went wrong', 401);
        }

        return response()->json([
            'message' => 'Successfully logged in',
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ], 201);
    }

    public function logout()
    {
        auth()->guard('user')->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out!'
        ], 200);
    }

    public function user()
    {
        return response()->json(auth()->guard('user')->id(), 200);
    }

}
