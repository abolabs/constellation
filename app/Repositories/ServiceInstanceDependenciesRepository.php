<?php

namespace App\Repositories;

use App\Models\ServiceInstanceDependencies;

/**
 * Class ServiceInstanceDependenciesRepository.
 *
 * @version September 4, 2021, 4:59 pm UTC
 */
class ServiceInstanceDependenciesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'instance_id',
        'instance_dep_id',
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
        return ServiceInstanceDependencies::class;
    }
}
