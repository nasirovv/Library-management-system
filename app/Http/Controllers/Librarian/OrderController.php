<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Comment;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{

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

    public function applications(Request $request){
        $text = strtolower($request->input('searchText'));

        $applications = Order::where('status_id', 1)
            ->when($request->input('searchBy'), function ($query) use ($request, $text){
                if($request->input('searchBy') === 'user'){

                    return $query->whereHas('user', function ($q) use ($request, $text){
                        return $q->where('fullName', $text);
                    });
                }
                return $query->whereHas('book', function ($q) use ($request, $text){
                    return $q->where('name', $text);
                });
            })
            ->select('id', 'wantedDate', 'wantedDuration', 'user_id', 'book_id')
            ->with('user:id,fullName')
            ->with('book:id,name')
            ->toSql();

        return response()->json($applications, 200);
    }

}
