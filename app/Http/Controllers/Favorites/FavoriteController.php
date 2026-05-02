<?php

namespace App\Http\Controllers\Favorites;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function allFavorites(Request $request)
    {
        $products = Auth::user()->favoriteProducts()->with(['category','media', 'attributes'])->latest()->paginate(10);
        return response()->json([
            'message' => 'Favorites retrieved successfully',
            'favorites' => ProductResource::collection($products)
        ], 200);
    }

    public function addToFavorites(Product $product)
    {
        $user = Auth::user();
        if ($user->favorites()->where('user_id', $user->id)->where('product_id', $product->id)->exists()) {
            return response()->json([
                'message' => 'Product is already in favorites'
            ], 400);
        }

        Favorite::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
        return response()->json([
            'message' => 'Product added to favorites successfully'
        ], 201);
    }

    public function removeFromFavorites(Product $product)
    {
        $user = Auth::user();
        $favorite = $user->favorites()->where('product_id', $product->id)->first();

        if (!$favorite) {
            return response()->json([
                'message' => 'Product is not in favorites'
            ], 400);
        }

        $favorite->delete();

        return response()->json([
            'message' => 'Product removed from favorites successfully'
        ], 200);
    }
}
