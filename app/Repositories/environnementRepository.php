<?php

namespace App\Repositories;

use App\Models\environnement;
use App\Repositories\BaseRepository;

/**
 * Class environnementRepository
 * @package App\Repositories
 * @version September 4, 2021, 3:05 pm UTC
*/

class environnementRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name'
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
        return environnement::class;
    }
}
