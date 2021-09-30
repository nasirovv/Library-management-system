<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use App\Http\Services\SearchService;
use App\Models\Book;
use App\Models\Comment;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function acceptOrder($id): JsonResponse
    {
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

    public function rejectOrder(Request $request, $id): JsonResponse
    {
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

    public function applications(Request $request): JsonResponse
    {
        $applications = (new SearchService())->applicationSearch($request);

        return response()->json($applications, 200);
    }

    public function orders(Request $request): JsonResponse
    {
        $orders = (new SearchService())->orderSearchForLibrarian($request);

        return response()->json($orders, 200);
    }

}
