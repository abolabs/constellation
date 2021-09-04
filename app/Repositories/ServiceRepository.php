<?php

namespace App\Repositories;

use App\Models\Service;
use App\Repositories\BaseRepository;

/**
 * Class ServiceRepository
 * @package App\Repositories
 * @version September 4, 2021, 4:23 pm UTC
*/

class ServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'team_id',
        'name',
        'git_repo'
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
        return Service::class;
    }
}
