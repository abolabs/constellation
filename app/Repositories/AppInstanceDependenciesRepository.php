<?php

namespace App\Repositories;

use App\Models\AppInstanceDependencies;
use App\Repositories\BaseRepository;

/**
 * Class AppInstanceDependenciesRepository
 * @package App\Repositories
 * @version September 4, 2021, 4:59 pm UTC
*/

class AppInstanceDependenciesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'instance_id',
        'instance_dep_id'
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
        return AppInstanceDependencies::class;
    }
}
