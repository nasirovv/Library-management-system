<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\SearchService;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Request $request){
        $orders = (new SearchService())->orderSearchForAdmin($request);

        return response()->json($orders, 200);
    }

}
