<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDefaultCategoryRequest;
use App\Http\Resources\DefaultCategoryResource;
use App\Models\DefaultCategory;

class DefaultCategoryController extends Controller
{
    public function index()
    {
        return DefaultCategoryResource::collection(DefaultCategory::all());
    }

    public function show(DefaultCategory $defaultCategory)
    {
        return new DefaultCategoryResource($defaultCategory);
    }

    public function updateDefaultCategory(StoreDefaultCategoryRequest $request, DefaultCategory $defaultCategory)
    {
        $defaultCategory->update($request->validated());
        return new DefaultCategoryResource($defaultCategory);
    }

    //Soft delete, it will stay in the DB
    public function destroyDefaultCategory(DefaultCategory $defaultCategory)
    {
        $defaultCategory->delete();
        return new DefaultCategoryResource($defaultCategory);
    }
}