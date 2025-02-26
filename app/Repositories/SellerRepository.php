<?php

namespace App\Repositories;

use App\Models\EcomSeller;
use App\Models\SvcVendor;
use App\Repositories\BaseRepository;

/**
 * Class RestaurantRepository
 * @package App\Repositories
 * @version June 01, 2021, 3:01 pm UTC
*/

class SellerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'phone',
        'email',
        'location',
        'lat',
        'lng',
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
        return EcomSeller::class;
    }
}
