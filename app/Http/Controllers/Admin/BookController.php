<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookRequest;
use App\Http\Services\SearchService;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $service;

    public function __construct(SearchService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return response()->json($this->service->bookSearch($request));
    }

    public function store(BookRequest $request)
    {
        $book = Book::create([
            'name' => $request->name,
            'author' => $request->author,
            'ISBN' => $request->ISBN,
            'description' => $request->description,
            'originalCount' => (int)$request->count,
            'count' => (int)$request->count,
            'image' => $request->image,
            'publishedYear' => $request->publishedYear,
        ]);
        if($request->hasFile('image')){
            Image::upload($request->file('image'), 'books', $book->id);
        }
        $book->categories()->attach(json_decode($request->categories));
        return response()->json('Successfully added', 201);
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
            'originalCount' => (int)$request->count,
            'count' => (int)$request->count,
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
