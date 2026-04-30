<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations, SoftDeletes, HasMedia, InteractsWithMedia;
    protected $fillable = ['name', 'status', 'parent_id'];
    public $translatable = ['name'];


    //cat parent
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    //child cat
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function allChildren()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('allChildren');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    //Root cat
    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('category-image')->singleFile();
    }


}



