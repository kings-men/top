<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @SWG\Definition(
 *      definition="ProviderPaymentMethod",
 *      required={"account_holder_name", "bank_name"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="payment_method",
 *          description="payment_method",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="account_holder_name",
 *          description="account_holder_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="account_number",
 *          description="account_number",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="account_holder_type",
 *          description="account_holder_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="routing_number",
 *          description="routing_number",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="bank_name",
 *          description="bank_name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="last4",
 *          description="last4",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="country_id",
 *          description="country_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="currency",
 *          description="currency",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="status",
 *          description="status",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class ProviderPaymentMethod extends Model
{
    use SoftDeletes;


    public $table = 'provider_payment_methods';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'uuid',
        'provider_id',
        'payment_method',
        'account_holder_name',
        'account_number',
        'account_holder_type',
        'routing_number',
        'bank_name',
        'last4',
        'country_id',
        'currency',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'provider_id' => 'integer',
        'payment_method' => 'string',
        'account_holder_name' => 'string',
        'account_number' => 'string',
        'account_holder_type' => 'string',
        'routing_number' => 'integer',
        'bank_name' => 'string',
        'last4' => 'integer',
        'country_id' => 'integer',
        'currency' => 'string',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        // 'account_holder_name' => 'required',
        // 'bank_name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function provider()
    {
        // return $this->hasOne(\App\Models\Provider::class, 'id', 'provider_id');
        return $this->belongsTo(S\App\Models\Provider::class, 'id', 'provider_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function country()
    {
        return $this->hasOne(\App\Models\Country::class, 'id', 'country_id');
    }
}
