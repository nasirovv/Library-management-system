<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Librarian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LibrarianLoginController extends Controller
{

    public function login(LoginRequest $request){
        $librarian = Librarian::where('username', $request->username)->first();
        if(!$librarian || !Hash::check($request->password, $librarian->password )){
            return response()->json('Something went wrong', 401);
        }

        return response()->json([
            'message' => 'Successfully logged in',
            'librarian' => $librarian,
            'token' => $librarian->createToken('auth_token')->plainTextToken
        ], 201);
    }

    public function logout()
    {
        auth()->guard('librarian')->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out!'
        ], 200);
    }

    public function librarian()
    {
        return response()->json(auth()->guard('librarian')->user()->id, 200);
    }

}
