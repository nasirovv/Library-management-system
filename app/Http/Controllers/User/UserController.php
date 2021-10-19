<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\UserEditPasswordRequest;
use App\Http\Requests\Front\UserEditRequest;
use App\Models\Librarian;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function edit(UserEditRequest $request): JsonResponse
    {
        User::query()->findOrFail(auth()->id())
            ->update($request->all());
        return response()->json('User updated successfully', 200);
    }

    public function editPassword(UserEditPasswordRequest $request): JsonResponse
    {
        $user = User::query()->findOrFail(auth()->id());
        if(!Hash::check($request->oldPassword, $user->password)){
            return response()->json('Old Password incorrect', 401);
        }
        if(!($request->newPassword === $request->confirmPassword)){
            return response()->json('Confirm Password incorrect', 401);
        }
        $user->update([
            'password' => $request->newPassword,
        ]);
        return response()->json('Password updated successfully', 200);
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

    public function returnBook(Request $request): JsonResponse
    {
        $order = Order::query()->where(['user_id'=> auth()->id(), 'id' => $request->orderId])->firstOrFail();
        if(!$order->librarian_id || $order->returnedDate !== null){
            return response()->json('Something went wrong', 401);
        }
        $order->update([
            'returnedDate' => Carbon::now(),
            'status_id' => 4
        ]);
        return response()->json('Book returned successfully', 200);
    }

}
