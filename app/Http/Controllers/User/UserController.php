<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Librarian;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function edit(Request $request){

    }

    public function showLibrarian($id): JsonResponse
    {
//        $accepted = Order::query()->where(['librarian_id' => $id, 'status_id' => 3])->count();



        return response()->json('', 200);
    }


}
