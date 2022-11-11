<?php

namespace App\Repositories;

use App\Models\Equipment;
use App\Repositories\BaseRepository;

/**
 * Class EquipmentRepository
 * @package App\Repositories
 * @version November 3, 2022, 12:10 pm UTC
*/

class EquipmentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Equipment::class;
    }
}
