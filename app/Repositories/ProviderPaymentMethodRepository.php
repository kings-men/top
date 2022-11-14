<?php

namespace App\Repositories;

use App\Models\ProviderPaymentMethod;
use App\Repositories\BaseRepository;

/**
 * Class ProviderPaymentMethodRepository
 * @package App\Repositories
 * @version November 14, 2022, 11:21 am UTC
*/

class ProviderPaymentMethodRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'provider_id',
        'uuid',
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
        return ProviderPaymentMethod::class;
    }
}
