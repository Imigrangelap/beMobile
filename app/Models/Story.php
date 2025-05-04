<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = ['description', 'user_id', 'photo', 'latitude', 'longitude', "namatempat"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPhotoAttribute($value)
    {
        return asset('storage/' . $value);
    }
}
