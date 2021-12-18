<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DefaultCategory;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\DefaultCategoryResource;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StoreDefaultCategoryRequest;
use App\Http\Requests\StoreDefaultCategoryResource;
use App\Models\VCard;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function getDefaultCategory()
    {
        return DefaultCategoryResource::collection(DefaultCategory::all());
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

    public function showMyCategory(VCard $vcard){
        return CategoryResource::collection($vcard->categories);
    }

    public function updateCategory(StoreCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return new CategoryResource($category);
    }


    public function storeDefaultCategory(StoreDefaultCategoryRequest $request, DefaultCategory $category) {
        $newDefaultCategory = DefaultCategory::create($request->validated());
        return new DefaultCategoryResource($newDefaultCategory);
    }

    public function deleteDefaultCategory(DefaultCategory $category)
    {
        $category = DefaultCategory::findOrFail($category->id);
        $category->delete();
    }

    //Soft delete, it will stay in the DB
    public function destroyCategory(Category $category)
    {
        $category->delete();
        return new CategoryResource($category);
    }
}