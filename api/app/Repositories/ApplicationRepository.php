<?php

namespace App\Repositories;

use App\Models\Application;

/**
 * Class ApplicationRepository.
 *
 * @version September 4, 2021, 4:16 pm UTC
 */
class ApplicationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name',
        'team_id',
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
        return Application::class;
    }
}
