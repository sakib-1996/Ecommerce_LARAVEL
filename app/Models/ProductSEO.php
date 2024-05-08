<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSEO extends Model
{
    use HasFactory;

    protected $fillable = [
        'meta_title',
        'meta_des',
        'meta_img',
        'meta_slug',
        'product_id',
        'tags'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
