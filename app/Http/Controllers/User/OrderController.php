<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\OrderRequest;
use App\Http\Services\SearchService;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        $orders = (new SearchService())->orderSearchForUser($request);

        return response()->json($orders, 200);
    }

    public function order(OrderRequest $request): JsonResponse
    {
        if(Book::query()->firstWhere('id', $request->bookId)->count <= 0){
            return response()->json('The books is over', 404);
        }
        Order::query()->create([
            'book_id' => $request->bookId,
            'user_id' => auth()->id(),
            'wantedDate' => $request->wantedDate,
            'wantedDuration' => $request->wantedDuration,
            'status_id' => 1,
        ]);

        return response()->json('Ordered successfully', 200);
    }

}
