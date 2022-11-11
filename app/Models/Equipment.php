<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @SWG\Definition(
 *      definition="Equipment",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="uuid",
 *          description="uuid",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="company_id",
 *          description="company_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="equipment_number",
 *          description="equipment_number",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="file_id",
 *          description="file_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="make",
 *          description="make",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="category_id",
 *          description="category_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="model_no",
 *          description="model_no",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="location",
 *          description="location",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="sn_no",
 *          description="sn_no",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="refrigerant_type",
 *          description="refrigerant_type",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="warranty_info",
 *          description="warranty_info",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="voltage_amps",
 *          description="voltage_amps",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="date_of_purchase",
 *          description="date_of_purchase",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="filter_no",
 *          description="filter_no",
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
class Equipment extends Model
{
    use SoftDeletes;


    public $table = 'equipments';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'uuid',
        'company_id',
        'equipment_number',
        'file_id',
        'make',
        'name',
        'category_id',
        'model_no',
        'location',
        'sn_no',
        'refrigerant_type',
        'warranty_info',
        'voltage_amps',
        'date_of_purchase',
        'filter_no'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'company_id' => 'integer',
        'equipment_number' => 'string',
        'file_id' => 'integer',
        'make' => 'integer',
        'name' => 'string',
        'category_id' => 'integer',
        'model_no' => 'integer',
        'location' => 'string',
        'sn_no' => 'string',
        'refrigerant_type' => 'string',
        'warranty_info' => 'string',
        'voltage_amps' => 'string',
        'date_of_purchase' => 'datetime',
        'filter_no' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    protected $hidden = [
        'id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function comanies()
    {
        return $this->hasOne(\App\Models\comanies::class, 'id', 'company_id');
    }

    public function frequency()
    {
        return $this->hasOne(\App\Models\MaintananceFrequency::class, 'equipment_id', 'id');
    }

    public function file()
    {
        return $this->hasOne(\App\Models\File::class, 'id', 'file_id');
    }
}
