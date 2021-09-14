<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
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

    public function admin(){
        return response()->json(auth()->guard('admin')->user()->username, 200);
    }

    public function editPassword(EditPasswordRequest $request){
        if (!(Hash::check($request->oldPassword, auth()->user()->password))){
            return response()->json('Old Password incorrect', 401);
        }
        if (!($request->newPassword === $request->confirmPassword)){
            return response()->json('Password Confirmation does not match', 401);
        }
        auth()->user()->update([
            'password' => $request->newPassword
        ]);
        return response()->json('Password updated successfully', 200);
    }
}
