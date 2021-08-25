<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::select('id', 'name')->get();
        return response()->json($categories, 200);
    }


    public function store(CategoryRequest $request)
    {
        Category::create([
            'name' => $request->name
        ]);

        return response()->json('Successfully added', 201);
    }


    public function show($id)
    {
        //
    }


    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);
        if(!$category){
            return response()->json('Category not found', 404);
        }
        $category->update($request->all());
        return response()->json('Successfully updated', 201);
    }


    public function destroy($id)
    {
        $category = Category::find($id);
        if(!$category){
            return response()->json('Category not found', 404);
        }
        $category->delete();
        return response()->json('Category successfully deleted');
    }
}
