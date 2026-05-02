<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function catTree()
    {
        return response()->json([
            'message' => 'Category tree retrieved successfully',
            'categories' => CategoryResource::collection($this->categoryService->CatTree())
        ]);
    }

    public function getAllCategories()
    {
        return response()->json([
            'message' => 'Categories retrieved successfully',
            'categories' => CategoryResource::collection($this->categoryService->getAllCategories())
        ]);
    }

    public function createCategory(CreateCategoryRequest $request)
    {
        $category = $this->categoryService->createCategory($request->validated());
        return response()->json([
            'message' => 'Category created successfully',
            'category' => CategoryResource::make($category)
        ], 201);
    }


    public function show(Category $category)
    {
        $category = $this->categoryService->getCategoryById($category->id);
        return response()->json([
            'message' => 'Category retrieved successfully',
            'category' => CategoryResource::make($category)
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category = $this->categoryService->updateCategory($category, $request->validated());
        return response()->json([
            'message' => 'Category updated successfully',
            'category' => CategoryResource::make($category)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->categoryService->deleteCategory($category);
        return response()->json([
            'message' => 'Category deleted successfully'
        ], 200);
    }
}
