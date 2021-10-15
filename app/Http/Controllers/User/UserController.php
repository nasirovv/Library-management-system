<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Librarian;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function edit(Request $request){

    }

    public function showLibrarian(Librarian $librarian): JsonResponse
    {
        return response()->json($librarian, 200);
    }


}
