<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderDocument extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia,SoftDeletes;
    protected $table = 'provider_documents';
    protected $fillable = [
       'provider_id','file_id','user_id','is_verified','document_type'
    ];

    protected $casts = [
        'provider_id'   => 'integer',
        'file_id'   => 'integer',
        'is_verified'   => 'integer',
        'user_id'       => 'integer',
    ];

    public function providers(){
        return $this->belongsTo(User::class,'provider_id','id');
    }
    public function document(){
        return $this->belongsTo(File::class,'file_id','id');
    }

}
