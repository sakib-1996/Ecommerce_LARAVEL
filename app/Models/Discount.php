<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'dis_details',
        'start_date',
        'end_date',
        'product_id',
        'run_time',
        'status',
        'dis_title',
        'druft',
        'dis_rate'
    ];

    // Define the relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
