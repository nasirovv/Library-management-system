<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $text = strtolower($request->input('searchText'));

        $books = Book::select('id', 'name', 'author', 'ISBN', 'description', 'originalCount', 'count', 'image', 'publishedYear', 'created_at')
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
        return response()->json($books, 200);
    }

    public function store(BookRequest $request)
    {
        $book = Book::create([
            'name' => $request->name,
            'author' => $request->author,
            'ISBN' => $request->ISBN,
            'description' => $request->description,
            'originalCount' => $request->count,
            'count' => $request->count,
            'image' => $request->image,
            'publishedYear' => $request->publishedYear,
        ]);
        if($request->hasFile('image')){
            Image::upload($request->file('image'), 'books', $book->id);
        }
        $book->categories()->attach(json_decode($request->categories));
        return response()->json('Successfully added', 201);
    }

    public function show($id)
    {
        //
    }

    public function update(BookRequest $request, $id)
    {
        $book = Book::find($id);
        if (!$book){
            return response()->json('Book not found', 404);
        }
        $book->update([
            'name' => $request->name,
            'author' => $request->author,
            'ISBN' => $request->ISBN,
            'description' => $request->description,
            'originalCount' => $request->count,
            'count' => $request->count,
            'image' => $request->image,
            'publishedYear' => $request->publishedYear,
        ]);
        if ($request->hasFile('image')){
            Image::update($request->file('image'), 'books', $book->id);
        }
        $book->categories()->sync(json_decode($request->categories));
        return response()->json('Successfully updated', 200);
    }

    public function destroy(Book $book)
    {
        if (!$book){
            return response()->json('Book not found', 404);
        }
        $book->delete();
        return response()->json('Successfully deleted', 200);
    }
}
