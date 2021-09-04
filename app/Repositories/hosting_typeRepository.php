<?php

namespace App\Repositories;

use App\Models\hosting_type;
use App\Repositories\BaseRepository;

/**
 * Class hosting_typeRepository
 * @package App\Repositories
 * @version September 4, 2021, 3:29 pm UTC
*/

class hosting_typeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description'
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
        return hosting_type::class;
    }
}
