<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\OrderRequest;
use App\Models\Book;
use App\Models\Order;

class OrderController extends Controller
{

    public function order(OrderRequest $request){
        if(Book::firstWhere('id', $request->bookId)->count <= 0){
            return response()->json('The books is over', 404);
        }
        Order::create([
            'book_id' => $request->bookId,
            'user_id' => auth()->id(),
            'wantedDate' => $request->wantedDate,
            'wantedDuration' => $request->wantedDuration,
            'status_id' => 1,
        ]);

        return response()->json('Ordered successfully', 200);
    }

}
