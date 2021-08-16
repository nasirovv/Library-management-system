<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{

    public function login(LoginRequest $request){
        $admin = Admin::where('username', $request->username)->first();
        if(!$admin || !Hash::check($request->password, $admin->password )){
            return response()->json('Something went wrong', 401);
        }

        return response()->json([
            'message' => 'Successfully logged in',
            'admin' => $admin,
            'token' => $admin->createToken('auth_token')->plainTextToken
        ], 201);
    }

    public function logout()
    {
        auth()->guard('admin')->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out!'
        ], 200);
    }

}
