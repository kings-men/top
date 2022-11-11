<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderService extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'service_id'
    ];

    public function services()
    {
        return $this->hasMany(Service::class, 'id','service_id');
    }

    public function serviceProvider(){
        return $this->belongsTo(ProviderService::class, 'id', 'provider_id');
    }

    public function service(){
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
