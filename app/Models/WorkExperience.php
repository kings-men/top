<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id', 'restaurant_id'
    ];

    public function saveWorkExperience($provider_id,$restaurants){

        $restaurants = explode(',',$restaurants);

        self::where('provider_id',$provider_id)->whereNotIn('restaurant_id',$restaurants)->delete();

        if(count($restaurants) > 0 ){
            foreach($restaurants as $restaurant_id){
                self::updateOrCreate(['provider_id'=>$provider_id,'restaurant_id'=>$restaurant_id],['restaurant_id'=>$restaurant_id]);
            }
        }

    }
}
