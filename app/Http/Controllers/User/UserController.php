<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Librarian;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function edit(Request $request){

    }

    public function showLibrarian($id): JsonResponse
    {
        $librarian = Librarian::query()
            ->where('id', $id)
            ->select('id', 'fullName', 'image')
            ->with('orders', function ($query){
                return $query->select('status_id', 'librarian_id', DB::raw('count(*) as count'))
                    ->groupBy('status_id', 'librarian_id')
                    ->with('status:id,message')
                    ->get();
            })
            ->firstOrFail();


        $data = [
            'id' => $librarian->id,
            'fullName' => $librarian->fullName,
            'image' => $librarian->image,
            'onProcess' => 0,
            'finished' => 0,
            'denied' => 0,
        ];

        foreach ($librarian->orders as $order){
                $data["{$order->status->message}"] = $order->count;
        }

        return response()->json($data, 200);
    }


}
