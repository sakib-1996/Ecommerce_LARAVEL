<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableCountry extends Model
{
    use HasFactory;
    protected $fillable = [
        'country_name',
    ];
    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
    }
}
