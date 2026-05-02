<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function CatTree()
    {
        return Category::roots()->with('allChildren')->active()->get();
    }

    public function getAllCategories()
    {
        return Category::with('parent')->latest()->get();
    }

    public function getCategoryById($id)
    {
        return Category::findOrFail($id);
    }

    public function createCategory($data)
    {

        $category = Category::create($data);

        if (isset($data['image'])) {
            $this->mediaService->createMedia($data['image'], $category, 'category-image');
        }

        return $category;
    }

    public function updateCategory(Category $category, $data)
    {

        $category->update($data);

        if (isset($data['image'])) {
            $this->mediaService->updateMedia($data['image'], $category, 'category-image');
        }

        return $category;
    }

    public function deleteCategory(Category $category)
    {
        $this->mediaService->deleteMedia($category, 'category-image');
        $category->delete();
    }
}
