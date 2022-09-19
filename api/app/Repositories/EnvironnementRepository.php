<?php

namespace App\Repositories;

use App\Models\Environnement;

/**
 * Class EnvironnementRepository.
 *
 * @version September 4, 2021, 3:37 pm UTC
 */
class EnvironnementRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
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
        return Environnement::class;
    }
}
