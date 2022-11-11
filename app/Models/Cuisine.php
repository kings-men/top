<?php

namespace App\Models;

use Customers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Cuisine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function cuisine(){
        return $this->belongsTo(RestaurantCuisine::class, 'cuisine_id', 'id');
    }

}
