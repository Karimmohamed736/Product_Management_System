<?php

namespace App\Services;

use App\Models\Product;

class ProductsService
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function getAllProducts($filters = [])
    {
        $query = Product::with(['category', 'media', 'attributes']);

        // search by title en or ar
        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title->en', 'like', '%'.$filters['search'].'%')
                    ->orWhere('title->ar', 'like', '%'.$filters['search'].'%');
            });
        }

        // filter by category
        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // filter by brand
        if (isset($filters['brand'])) {
            $query->where('brand', $filters['brand']);
        }

        // filter by price range
        if (isset($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (isset($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        return $query->latest()->paginate(10);
    }

    public function getProductById($id)
    {
        return Product::with(['category', 'media', 'attributes'])->findOrFail($id);
    }

    public function createProduct($data)
    {

        $product = Product::create(collect($data)->except(['main-image', 'gallery', 'files'])->toArray());

        if (isset($data['main-image'])) {
            $this->mediaService->createMedia($data['main-image'], $product, 'main-image');
        }
        if(isset($data['gallery'])){
            $this->mediaService->createMedia($data['gallery'], $product, 'gallery');
        }
        if(isset($data['files'])){
            $this->mediaService->createMedia($data['files'], $product, 'files');
        }

        return $product;
    }

    public function updateProduct(Product $product, $data)
    {

        $product->update(collect($data)->except(['main-image', 'gallery', 'files'])->toArray());

        if (isset($data['main-image'])) {
            $this->mediaService->updateMedia($data['main-image'], $product, 'main-image');
        }
        if (isset($data['gallery'])) {
            $this->mediaService->updateMedia($data['gallery'], $product, 'gallery');
        }
        if (isset($data['files'])) {
            $this->mediaService->updateMedia($data['files'], $product, 'files');
        }

        return $product;
    }

    public function deleteProduct(Product $product)
    {
        foreach (['main-image', 'gallery', 'files'] as $collection) {
            $this->mediaService->deleteMedia($product, $collection);
        }
        $product->delete();
    }

}
