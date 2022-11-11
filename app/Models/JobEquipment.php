<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobEquipment extends Model
{
    use HasFactory;
    protected $table = 'job_equipments';
    protected $fillable = [
        'id',
        'job_id',
        'equipment_id'
    ];

}
