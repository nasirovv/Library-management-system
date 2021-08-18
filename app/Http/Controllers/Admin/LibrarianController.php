<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LibrarianRequest;
use App\Http\Resources\Admin\LibrarianResource;
use App\Models\Librarian;
use Illuminate\Http\Request;

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

    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
