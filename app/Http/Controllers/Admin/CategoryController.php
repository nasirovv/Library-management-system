<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{

    public function index(): JsonResponse
    {
        $categories = Category::select('id', 'name')->get();
        return response()->json($categories, 200);
    }


    public function store(CategoryRequest $request): JsonResponse
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


    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $category->update($request->all());
        return response()->json('Successfully updated', 201);
    }


    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        return response()->json('Category successfully deleted');
    }
}
