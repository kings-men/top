<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cuisine;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name'
        , 'restaurant_name'
        , 'user_id'
        , 'rest_address'
        , 'rest_country_id'
        , 'rest_state_id'
        , 'rest_city_id'
        // , 'cuisine'
        , 'types_of_restaurant'
        , 'seats'
        , 'bar_on_premise'
    ];

    public function cousine()
    {
        return $this->hasMany(Cuisine::class);
    }

    public function state(){
        return $this->hasOne('App\Models\State','id', 'rest_state_id');
    }

    public function city(){
        return $this->hasOne('App\Models\City','id', 'rest_city_id');
    }

    public function country(){
        return $this->hasOne('App\Models\Country','id', 'rest_country_id');
    }

    public static function updateProfile($id,$update){

        $where = ['user_id'=>$id];
        $data = self::updateOrCreate($where,$update);

        unset($data->attributes['created_at']);
        unset($data->attributes['updated_at']);

        return $data->attributes;

    }


}

