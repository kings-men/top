<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;


class CompanyLocation extends Model implements  HasMedia
{

    use InteractsWithMedia, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'company_id',
        'restaurant_name',
        'contact_name',
        'email',
        'address',
        'city',
        'state_id',
        'phone_number',
        'company_cusine_id',
        'restaurant_type',
        'seats',
        'bar',
        'parking'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'company_id'
    ];

    public function states(){
        return $this->hasMany(State::class, 'id','state_id');
    }


}
