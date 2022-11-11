<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @SWG\Definition(
 *      definition="MaintananceFrequency",
 *      required={"equipment_id", "service_title", "frequency_type", "frequency_every"},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="equipment_id",
 *          description="equipment_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="service_title",
 *          description="service_title",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="frequency_type",
 *          description="frequency_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="frequency_every",
 *          description="frequency_every",
 *          type="integer",
 *          format="int32"
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
class MaintananceFrequency extends Model
{
    use SoftDeletes;


    public $table = 'maintanance_frequencies';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'equipment_id',
        'service_title',
        'frequency_type',
        'frequency_every'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'equipment_id' => 'integer',
        'service_title' => 'string',
        'frequency_type' => 'string',
        'frequency_every' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'equipment_id' => 'required',
        'service_title' => 'required',
        'frequency_type' => 'required',
        'frequency_every' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function equipment()
    {
        return $this->hasOne(\App\Models\Equipment::class, 'id', 'equipment_id');
    }
}
