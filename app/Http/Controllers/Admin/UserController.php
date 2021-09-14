<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(Request $request){
        $users = User::select('id', 'fullName', 'email', 'active', 'image')
            ->when($request->input('filter') && $request->input('filter') != 'all', function ($query) use ($request){
                if($request->input('filter') === 'active'){
                    return $query->where('active', true);
                }
                else{
                    return $query->where('active', false);
                }
        })
            ->when($request->input('searchBy'), function ($query) use ($request){
                $text = strtolower($request->input('searchText'));
                if($request->input('searchBy') === 'email'){
                    return $query->where('email', 'LIKE', "%$text%");
                }
                return $query->where('fullName', 'LIKE', "%$text%");
            })
            ->simplePaginate(15);

        return response()->json($users, 200);
    }

}
