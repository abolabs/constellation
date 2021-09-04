<?php

namespace App\Repositories;

use App\Models\ServiceVersionDependencies;
use App\Repositories\BaseRepository;

/**
 * Class ServiceVersionDependenciesRepository
 * @package App\Repositories
 * @version September 4, 2021, 4:37 pm UTC
*/

class ServiceVersionDependenciesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'service_version_id',
        'service_version_dependency_id'
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
        return ServiceVersionDependencies::class;
    }
}
