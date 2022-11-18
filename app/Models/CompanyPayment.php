<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'company_payments';
    protected $fillable = [
        'company_id', 'subscription_id', 'amount', 'transaction_date', 'transaction_id','stranstion_status'
    ];

}
