<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function order(Request $request){
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

    public function acceptOrder(Request $request, $id){
        $order = Order::find($id);
        $order->update([
            'librarian_id' => auth()->user()->id,
            'givenDate' => Carbon::now()->format('Y-m-d'),
            'mustReturnDate' => Carbon::now()->addDays($order->wantedDuration)->format('Y-m-d'),
            'status_id' => 3
        ]);
        return response()->json('Order accepted successfully', 200);
    }

}
