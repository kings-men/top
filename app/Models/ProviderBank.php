<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_type'
        , 'provider_id'
        , 'iban'
        , 'bic'
        , 'currency_type'
    ];

    public static function saveBankDetails($provider_id,$data){

        $response = Self::updateOrCreate(['provider_id'=>$provider_id],$data);
        return $response;
    }
}
