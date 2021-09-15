<?php

namespace App\Http\Services;

use App\Models\Book;
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
}

