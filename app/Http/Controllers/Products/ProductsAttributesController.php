<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class ProductsAttributesController extends Controller
{

    public function getAllAttributes()
    {
        $attributes = ProductAttribute::with('product')
            ->paginate(10);

        return response()->json([
            'message' => 'Attributes retrieved successfully',
            'data'    => $attributes->map(fn($attr) => [
                'id'         => $attr->id,
                'key'        => $attr->key,
                'value'      => $attr->value,
                'product_id' => $attr->product_id,
                'product'    => $attr->product?->getTranslation('title', app()->getLocale()),
            ]),
        ]);
    }

    public function createAttribute(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
        ]);

        $attribute = ProductAttribute::create($data);

        return response()->json([
            'message' => 'Attribute created successfully',
            'attribute' => $attribute,
        ], 201);
    }
}
