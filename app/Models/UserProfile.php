<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'address_1',
        'address_2',
        'city',
        'post_code',
        'country_id',
        'districts_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(AvailableCountry::class);
    }

    public function district()
    {
        return $this->belongsTo(AvailableDistrict::class);
    }
}
