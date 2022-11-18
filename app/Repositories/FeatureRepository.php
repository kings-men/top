<?php

namespace App\Repositories;

use App\Models\Feature;
use App\Repositories\BaseRepository;

/**
 * Class FeatureRepository
 * @package App\Repositories
 * @version November 15, 2022, 5:30 am UTC
*/

class FeatureRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title'
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
        return Feature::class;
    }
}
