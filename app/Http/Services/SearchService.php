<?php

namespace App\Http\Services;

use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class SearchService
{
    public function bookSearch(Request $request)
    {
        $text = strtolower($request->input('searchText'));

        return Book::query()
            ->select('id', 'name', 'author', 'ISBN', 'description', 'originalCount', 'count', 'image', 'publishedYear', 'created_at')
            ->with('categories:id,name')
            ->when($request->input('filter') && $request->input('filter') === 'category', function ($query) use ($request, $text){
                return $query->whereHas('categories', function ($q) use ($text){
                    return $q->where('name', 'LIKE', "%$text%");
                });
            })
            ->when($request->input('searchBy'), function ($query) use ($request, $text){
                if ($request->input('searchBy') === 'author'){
                    return $query->where('author', 'LIKE', "%$text%");
                }
                if ($request->input('searchBy') === 'ISBN'){
                    return $query->where('ISBN', 'LIKE', "%$text%");
                }
                return $query->where('name', 'LIKE', "%$text%");
            })
            ->when($request->input('fromYear'), function ($query) use ($request){
                return $query->where('publishedYear', '>=', $request->input('fromYear'));
            })
            ->when($request->input('toYear'), function ($query) use ($request){
                return $query->where('publishedYear', '<=', $request->input('toYear'));
            })
            ->when($request->input('sort'), function ($query) use ($request){
                if($request->input('sort') === 'alphabet'){
                    return $query->orderBy('name');
                }
                return $query->orderByDesc('publishedYear');
            })
            ->simplePaginate(10);
    }

    public function userSearch(Request $request){
        return User::select('id', 'fullName', 'email', 'active', 'image')
            ->when($request->input('filter') && $request->input('filter') != 'all', function ($query) use ($request){
                if($request->input('filter') === 'active'){
                    return $query->where('active', true);
                }
                else{
                    return $query->where('active', false);
                }
            })
            ->when($request->input('searchBy'), function ($query) use ($request){
                $text = strtolower($request->input('searchText'));
                if($request->input('searchBy') === 'email'){
                    return $query->where('email', 'LIKE', "%$text%");
                }
                return $query->where('fullName', 'LIKE', "%$text%");
            })
            ->simplePaginate(15);
    }

    public function applicationSearch(Request $request){
        $text = strtolower($request->input('searchText'));

        return Order::where('status_id', 1)
            ->when($request->input('searchBy'), function ($query) use ($request, $text){
                if($request->input('searchBy') === 'user'){
                    return $query->whereHas('user', function ($q) use ($request, $text){
                        return $q->where('fullName', 'LIKE', "%$text%");
                    });
                }
                return $query->whereHas('book', function ($q) use ($request, $text){
                    return $q->where('name', 'LIKE', "%$text%");
                });
            })
            ->select('id', 'wantedDate', 'wantedDuration', 'user_id', 'book_id')
            ->with('user:id,fullName')
            ->with('book:id,name')
            ->simplePaginate();
    }

    public function orderSearchForAdmin(Request $request){
        $text = strtolower($request->input('searchText'));

        return Order::query()
            ->when($request->input('filter') === 'status', function ($query) use ($text){
                return $query->whereHas('status', function ($q) use($text){
                    return $q->where('message', 'LIKE', "%$text%");
                });
            })
            ->when($request->input('searchBy'), function ($query) use ($request, $text){
                if($request->input('searchBy') === 'user'){
                    return $query->whereHas('user', function ($q) use ($request, $text){
                        return $q->where('fullName', 'LIKE', "%$text%");
                    });
                }
                if($request->input('searchBy') === 'librarian'){
                    return $query->whereHas('librarian', function ($q) use ($request, $text){
                        return $q->where('fullName', 'LIKE', "%$text%");
                    });
                }
                return $query->whereHas('book', function ($q) use ($request, $text){
                    return $q->where('name', 'LIKE', "%$text%");
                });
            })
            ->select('id', 'book_id', 'user_id', 'wantedDate', 'wantedDuration',
                'status_id', 'librarian_id', 'givenDate', 'mustReturnDate', 'returnedDate')
            ->with('user:id,fullName')
            ->with('book:id,name')
            ->with('librarian:id,fullName')
            ->simplePaginate();
    }

}

