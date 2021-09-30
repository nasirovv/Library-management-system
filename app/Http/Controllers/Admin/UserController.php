<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\SearchService;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(Request $request){
        $users = (new SearchService())->userSearch($request);

        return response()->json($users, 200);
    }

    public function show($id){
        $user = User::where('id', $id)
            ->select('id', 'fullName', 'username', 'image', 'active')
            ->firstOrFail();
        return response()->json($user, 200);
    }

    public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json('Successfully deleted', 200);
    }

}
