<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Admin\EditPasswordRequest;
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

    public function admin(){
        return response()->json([
            'username' => auth()->guard('admin')->user()->username
        ], 200);
    }

    public function edit(AdminRequest $request){
        if ($request->has('oldPassword') && $request->has('newPassword') && $request->has('confirmPassword'))
        {
            if (!(Hash::check($request->oldPassword, auth()->user()->password))){
                return response()->json('Old Password incorrect', 401);
            }
            if (!($request->newPassword === $request->confirmPassword)){
                return response()->json('Password Confirmation does not match', 401);
            }
        }
        if ($request->has('newPassword')){
            auth()->user()->password = $request->newPassword;
        }
        if ($request->has('username')){
            auth()->user()->username = $request->username;
        }
        auth()->user()->save();

        return response()->json('Updated successfully', 200);

    }

}
