<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductQty extends Model
{
    use HasFactory;
    protected $fillable = [
        'qty',
        'unit_price',
        'purchase_price',
        'current_qty',
        'product_id',
        'size_id',
        'color_id',
        'unit',
        'druft',
        'sku',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
