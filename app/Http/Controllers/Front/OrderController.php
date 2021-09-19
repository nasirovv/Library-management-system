<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\OrderRequest;
use App\Models\Book;
use App\Models\Comment;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

    public function acceptOrder($id){
        $order = Order::findOrFail($id);
        if(!($order->status_id === 1)){
            return response()->json('You cannot accept this order', 400);
        }
        $order->update([
            'librarian_id' => auth()->user()->id,
            'givenDate' => Carbon::now()->format('Y-m-d'),
            'mustReturnDate' => Carbon::now()->addDays($order->wantedDuration)->format('Y-m-d'),
            'status_id' => 3
        ]);
        $book = Book::firstWhere('id', $order->book_id);
        $book->count--;
        $book->save();
        return response()->json('Order accepted successfully', 200);
    }

    public function rejectOrder(Request $request, $id){
        $request->validate([
            'message' => 'required|string'
        ]);
        $order = Order::findOrFail($id);
        if(!($order->status_id === 1)){
            return response()->json('You cannot reject this order', 400);
        }
        $order->update([
            'librarian_id' => auth()->user()->id,
            'status_id' => 2
        ]);
        Comment::create([
            'message' => $request->message,
            'order_id' => $id
        ]);

        return response()->json('Order rejected successfully', 200);
    }

}
