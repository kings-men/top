<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\State;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
            'uuid',
            'user_id',
            'bussiness_name',
            'contact_number',
            'address',
            'city',
            'zipcode',
            'state_id',
            'dob',
            'ssn',
            'experience_years',
            'education',
            'previous_employer',
            'referral',
            'trade_education',
            'bio',
            'preferred_distance',
            'insurance',
            'trade_organization',
            'hourly_rate',
            'weekend_rate',
            'status',
    ];

    protected $hidden = [
        'id',
        'user_id'
    ];

    public function states(){
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function services(){
        return $this->hasMany(ProviderService::class, 'provider_id','id');
    }

    public function documents(){
        return $this->hasMany(ProviderDocument::class, 'provider_id','id');
    }

     public function user()
    {
         return $this->belongsTo(User::class, 'user_id','id');
    }


    public function providerPatymentMethod()
    {
        return $this->hasOne(\App\Models\ProviderPaymentMethod::class, 'provider_id', 'id');
    }
}
