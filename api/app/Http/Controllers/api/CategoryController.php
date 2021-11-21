<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;


class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function storeCategory(StoreCategoryRequest $request)
    {
        $newCategory = Category::create($request->validated());
        return new CategoryResource($newCategory);
    }

    public function updateCategory(StoreCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return new CategoryResource($category);
    }

    //Soft delete, it will stay in the DB
    public function destroyCategory(Category $category)
    {
        $category->delete();
        return new CategoryResource($category);
    }
}
