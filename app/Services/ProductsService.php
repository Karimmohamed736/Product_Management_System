<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

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
        // Caching product details for 60 minutes
        return Cache::remember('product_' . $id, now()->addMinutes(60), function () use ($id) {
        return Product::with(['category', 'media', 'attributes'])->findOrFail($id);
             });
    }

    public function createProduct($data)
    {

        $product = Product::create(collect($data)->except(['main-image', 'gallery', 'files'])->toArray());

        if (isset($data['main-image'])) {
            $this->mediaService->createMedia($data['main-image'], $product, 'main-image');
        }
        if(isset($data['gallery'])){
            foreach ($data['gallery'] as $image) {
                $this->mediaService->createMedia($image, $product, 'gallery');
            }
        }
        if(isset($data['files'])){
            foreach ($data['files'] as $file) {
                $this->mediaService->createMedia($file, $product, 'files');
            }
        }

        Cache::flush(); //clear cache
        return $product;
    }

    public function updateProduct(Product $product, $data)
    {

        $product->update(collect($data)->except(['main-image', 'gallery', 'files'])->toArray());

        if (isset($data['main-image'])) {
            $this->mediaService->updateMedia($data['main-image'], $product, 'main-image');
        }
        if (isset($data['gallery'])) {
            foreach ($data['gallery'] as $image) {
                $this->mediaService->createMedia($image, $product, 'gallery');
            }
        }
        if (isset($data['files'])) {
            foreach ($data['files'] as $file) {
                $this->mediaService->createMedia($file, $product, 'files');
            }
        }

        Cache::forget('products_' . $product->id); //clear cache for this product
        Cache::flush();

        return $product;
    }

    public function deleteProduct(Product $product)
    {
        foreach (['main-image', 'gallery', 'files'] as $collection) {
            $this->mediaService->deleteMedia($product, $collection);
        }

        Cache::forget('products_' . $product->id); //clear cache for this product
        Cache::flush();
        return $product->forceDelete();
        // return $product->delete(); //trash only
    }

    // Get only trashed products
    public function trashedProducts()
    {
        return Product::onlyTrashed()->with(['category', 'media', 'attributes'])->latest()->paginate(10);
    }

}
