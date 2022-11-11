<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'job_id',
        'file_id',
    ];

    public function fileDetail()
    {
        return $this->belongsTo(File::class, 'file_id', 'id');
    }

}
