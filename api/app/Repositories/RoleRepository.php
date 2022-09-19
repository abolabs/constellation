<?php

namespace App\Repositories;

use App\Models\Role;

/**
 * Class HostingRepository.
 *
 * @version September 4, 2021, 3:53 pm UTC
 */
class RoleRepository extends BaseRepository
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
        return Role::class;
    }
}
