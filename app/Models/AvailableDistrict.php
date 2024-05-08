<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableDistrict extends Model
{
    use HasFactory;
    protected $fillable = [
        'district_name',
        'base_cost',
        'cost_by_condition',
        'country_id',
    ];

    public function country()
    {
        return $this->belongsTo(AvailableCountry::class);
    }
    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
    }
}
