<?php

namespace App\Repositories;

use App\Models\SvcVendor;
use App\Repositories\BaseRepository;

/**
 * Class RestaurantRepository
 * @package App\Repositories
 * @version June 01, 2021, 3:01 pm UTC
*/

class VendorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'phone',
        'email',
        'location',
        'status',
        'image'
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
        return SvcVendor::class;
    }
}
