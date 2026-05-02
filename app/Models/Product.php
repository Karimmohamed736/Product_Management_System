<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use SoftDeletes, HasTranslations ,InteractsWithMedia;
    protected $guarded = ['id'];
    protected $casts= [
        'price' => 'float',
        'sale_price' => 'float',
        'status' => 'boolean',
        'stock' => 'integer',
    ];
    
    public $translatable = ['title', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes(){
        return $this->hasMany(ProductAttribute::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main_image')->singleFile();
        $this->addMediaCollection('gallery');
        $this->addMediaCollection('files');
    }


}


