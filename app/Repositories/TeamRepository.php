<?php

namespace App\Repositories;

use App\Models\Team;
use App\Repositories\BaseRepository;

/**
 * Class TeamRepository
 * @package App\Repositories
 * @version September 4, 2021, 4:07 pm UTC
*/

class TeamRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'manager'
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
        return Team::class;
    }
}
