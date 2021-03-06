<?php

namespace App\Repositories;

use App\Models\HostingType;

/**
 * Class HostingTypeRepository.
 *
 * @version September 4, 2021, 3:38 pm UTC
 */
class HostingTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
    ];

    /**
     * Return searchable fields.
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model.
     **/
    public function model()
    {
        return HostingType::class;
    }
}
