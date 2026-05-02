<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->getTranslation('title', app()->getLocale()),
            'description' => $this->getTranslation('description', app()->getLocale()),
            'sku' => $this->sku,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'brand' => $this->brand,
            'stock' => $this->stock,
            'status' => $this->status,
            'category' => $this->whenLoaded('category', fn () => [
                'id' => $this->category->id,
                'name' => $this->category->getTranslation('name', app()->getLocale()),
            ]),
            'attributes' => $this->whenLoaded('attributes', fn () => $this->attributes->map(fn ($attr) => [
                'key' => $attr->key,
                'value' => $attr->value,
            ])
            ),
            'main-image' => $this->getFirstMediaUrl('main-image'),
            'gallery' => $this->getMedia('gallery')->map->getUrl(),
            'files' => $this->getMedia('files')->map->getUrl(),

        ];
    }
}
