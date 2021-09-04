<?php

namespace App\Repositories;

use App\Models\ServiceVersion;
use App\Repositories\BaseRepository;

/**
 * Class ServiceVersionRepository
 * @package App\Repositories
 * @version September 4, 2021, 4:27 pm UTC
*/

class ServiceVersionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'service_id',
        'version'
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
        return ServiceVersion::class;
    }
}
