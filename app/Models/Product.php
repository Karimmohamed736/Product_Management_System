<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use SoftDeletes, HasTranslations,HasMedia ,InteractsWithMedia;
    protected $fillable = ['title', 'description', 'sku', 'price', 'sale_price', 'stock', 'brand', 'status', 'category_id'];
    public $translatable = ['title', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


}


