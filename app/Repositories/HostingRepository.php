<?php

namespace App\Repositories;

use App\Models\Hosting;
use App\Repositories\BaseRepository;

/**
 * Class HostingRepository
 * @package App\Repositories
 * @version September 4, 2021, 3:53 pm UTC
*/

class HostingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'hosting_type_id',
        'localisation'
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
        return Hosting::class;
    }
}
