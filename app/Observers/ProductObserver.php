<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function creating(Product $product): void
    {
        if (empty($product->sku)) {
            $title = $product->getTranslations('title');
            $title = $title['en'] ?? $title['ar'] ?? 'product';

            $product->sku = $this->generateSKU($title);
        }
    }

private function generateSKU(string $title): string
{
    $slug = Str::slug($title, '-');

    $sku     = $slug;
    $counter = 1;

    while (Product::where('sku', $sku)->exists()) {
        $sku = $slug . '-' . $counter;
        $counter++;
    }

    return $sku;
}

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
