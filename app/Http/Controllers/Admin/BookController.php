<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookRequest;
use App\Http\Resources\Admin\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = BookResource::collection(Book::all());

        return response()->json($books, 200);
    }

    public function store(BookRequest $request)
    {
        $book = Book::create([
            'name' => $request->name,
            'author' => $request->author,
            'ISBN' => $request->ISBN,
            'description' => $request->description,
            'originalCount' => $request->originalCount,
            'count' => $request->originalCount,
            'image' => $request->image,
            'publishedDate' => $request->publishedDate,
        ]);
        if($request->hasFile('image')){
            Image::upload($request->file('image'), 'books', $book->id);
        }

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
            'originalCount' => $request->originalCount,
            'count' => $request->originalCount,
            'image' => $request->image,
            'publishedDate' => $request->publishedDate,
        ]);
        if ($request->hasFile('image')){
            Image::update($request->file('image'), 'books', $book->id);
        }

        return response()->json('Successfully updated', 200);
    }

    public function destroy($id)
    {
        //
    }
}
