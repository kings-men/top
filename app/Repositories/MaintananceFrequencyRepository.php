<?php

namespace App\Repositories;

use App\Models\MaintananceFrequency;
use App\Repositories\BaseRepository;

/**
 * Class MaintananceFrequencyRepository
 * @package App\Repositories
 * @version November 7, 2022, 11:36 am UTC
*/

class MaintananceFrequencyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'equipment_id',
        'service_title',
        'frequency_type',
        'frequency_every'
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
        return MaintananceFrequency::class;
    }
}
