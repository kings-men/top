<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $table = "job_applications";

    protected $fillable = [
        'job_id',
        'provider_id',
        'application_status',
        'comment',
        'rate_type',
        'rate'
    ];

    protected $primaryKey = "id";

    public function job(){
        return $this->belongsTo(RestaurantJob::class, 'id','job_id');
    }

    public function provider(){
        return $this->belongsTo(Provider::class, 'id','provider_id');
    }

}
