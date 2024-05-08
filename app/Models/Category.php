<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_name',
        'category_slug',
        'front_page',
        'cat_img'
    ];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function childCategories()
    {
        return $this->hasManyThrough(ChildCategory::class, SubCategory::class);
    }
}
