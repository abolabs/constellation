<?php

namespace App\Repositories;

use App\Models\AppInstance;
use App\Repositories\BaseRepository;

/**
 * Class AppInstanceRepository
 * @package App\Repositories
 * @version September 4, 2021, 4:52 pm UTC
*/

class AppInstanceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'application_id',
        'service_version_id',
        'environnement_id',
        'url',
        'statut'
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
        return AppInstance::class;
    }
}
