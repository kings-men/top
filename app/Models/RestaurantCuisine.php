<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantCuisine extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'cuisine_id'
    ];

    public function cuisine()
    {
        return $this->belongsTo(Cuisine::class, 'cuisine_id','id');
    }

    public function cuisineRestaurant(){
        return $this->belongsTo(Company::class, 'id', 'restaurant_id');
    }
}
