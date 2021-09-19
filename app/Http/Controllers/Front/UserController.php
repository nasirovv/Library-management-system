<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BlockMessage;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function block(Request $request, $id){
        $user = User::findOrFail($id);
        if(!$user->active){
            return response()->json('User already blocked', 400);
        }
        BlockMessage::create([
            'user_id' => $id,
            'librarian_id' => auth()->user()->id,
            'message' => $request->message
        ]);
        $user->update([
            'active' => false
        ]);
        return response()->json("User blocked", 200);
    }

    public function unblock($id){
        $user = User::findOrFail($id);
        if($user->active){
            return response()->json('User already unblocked', 400);
        }
        $user->update([
            'active' => true
        ]);
        return response()->json("User unblocked", 200);
    }

}
