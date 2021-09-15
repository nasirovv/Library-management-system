<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LibrarianRequest;
use App\Http\Resources\Admin\LibrarianResource;
use App\Models\Librarian;

class LibrarianController extends Controller
{
    public function index()
    {
        $librarians = LibrarianResource::collection(Librarian::all());

        return response()->json($librarians, 200);
    }

    public function store(LibrarianRequest $request)
    {
        $librarian = Librarian::create($request->validated());
        if($request->hasFile('image')){
            Image::upload($request->file('image'), 'librarians', $librarian->id);
        }

        return response()->json('Successfully added', 201);
    }

    public function show(Librarian $librarian)
    {
        return response()->json(new LibrarianResource($librarian), 200);
    }


    public function update(LibrarianRequest $request, $id)
    {
        $librarian = Librarian::find($id);
        if (!$librarian){
            return response()->json('Librarian not found', 404);
        }
        if($request->password){
            return response()->json('Admin cannot edit librarians password', 401);
        }
        $librarian->update($request->all());
        if ($request->hasFile('image')){
            Image::update($request->file('image'), 'librarians', $librarian->id);
        }

        return response()->json('Successfully updated', 200);
    }

    public function destroy(Librarian $librarian)
    {
        if (!$librarian){
            return response()->json('Librarian not found', 404);
        }
        $librarian->delete();
        return response()->json('Librarian successfully deleted', 200);
    }
}
