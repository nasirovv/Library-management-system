<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LibrarianRequest;
use App\Http\Resources\Admin\LibrarianResource;
use App\Models\Librarian;
use Illuminate\Http\JsonResponse;

class LibrarianController extends Controller
{
    public function index(): JsonResponse
    {
        $librarians = Librarian::query()
            ->select('id', 'fullName', 'username', 'image')
            ->with('orders')
            ->get();

        return response()->json($librarians, 200);
    }

    public function store(LibrarianRequest $request): JsonResponse
    {
        $librarian = Librarian::create($request->validated());
        if($request->hasFile('image')){
            Image::upload($request->file('image'), 'librarians', $librarian->id);
        }

        return response()->json('Successfully added', 201);
    }

    public function show($id): JsonResponse
    {
        $librarian = Librarian::query()
            ->select('id', 'fullName', 'username', 'image')
            ->with('orders')
            ->firstOrFail();

        return response()->json($librarian, 200);
    }


    public function update(LibrarianRequest $request, $id): JsonResponse
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

    public function destroy(Librarian $librarian): JsonResponse
    {
        $librarian->delete();
        return response()->json('Librarian successfully deleted', 200);
    }
}
