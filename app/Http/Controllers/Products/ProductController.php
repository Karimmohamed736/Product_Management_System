<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductsService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $ProductsService;
    public function __construct(ProductsService $ProductsService)
    {
        $this->ProductsService = $ProductsService;
    }
       public function getAllProducts(Request $request)
    {
        return response()->json([
            'message' => 'Products retrieved successfully',
            'products' => ProductResource::collection($this-> ProductsService->getAllProducts($request->all()))
        ]);
    }

    public function createProduct(CreateProductRequest $request)
    {
        $product = $this->ProductsService->createProduct($request->validated());
        return response()->json([
            'message' => 'Product created successfully',
            'product' => ProductResource::make($product)
        ], 201);
    }


    public function show(Product $product)
    {
        $product = $this->ProductsService->getProductById($product->id);
        return response()->json([
            'message' => 'Product retrieved successfully',
            'product' => ProductResource::make($product)
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = $this->ProductsService->updateProduct($product, $request->validated());
        return response()->json([
            'message' => 'Product updated successfully',
            'product' => ProductResource::make($product)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->ProductsService->deleteProduct($product);
        return response()->json([
            'message' => 'Product deleted successfully'
        ], 200);
    }
}

