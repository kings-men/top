<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanFeature extends Model
{
    use HasFactory;
    protected $table = 'plan_features';
    protected $fillable = [
        'plan_id', 'feature_id', 'status'
    ];
    protected $casts = [
        'plan_id'    => 'integer',
        'feature_id'    => 'integer',
    ];
    public function plan(){
        return $this->belongsTo(Plans::class,'id', 'plan_id');
    }
    public function feature(){
        return $this->hasOne(Feature::class,'id', 'feature_id');
    }
}
