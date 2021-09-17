<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class AppInstance
 * @package App\Models
 * @version September 4, 2021, 4:52 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $serviceVersions
 * @property \Illuminate\Database\Eloquent\Collection $environnements
 * @property \Illuminate\Database\Eloquent\Collection $applications
 * @property integer $application_id
 * @property integer $service_version_id
 * @property integer $environnement_id
 * @property string $url
 * @property boolean $statut
 */
class AppInstance extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'app_instance';
    
    protected $dates = ['deleted_at'];

    public $fillable = [
        'application_id',
        'service_version_id',
        'environnement_id',
        'url',
        'statut'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'application_id' => 'integer',
        'service_version_id' => 'integer',
        'environnement_id' => 'integer',
        'url' => 'string',
        'statut' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'application_id' => 'required|exists:application,id',
        'service_version_id' => 'required|exists:service_version,id',
        'environnement_id' => 'required|exists:environnement,id',
        'url' => 'url',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function serviceVersion()
    {
        return $this->hasOne(\App\Models\ServiceVersion::class, 'id', 'service_version_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function environnement()
    {
        return $this->hasOne(\App\Models\Environnement::class, 'id', 'environnement_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function application()
    {
        return $this->hasOne(\App\Models\Application::class, 'id', 'application_id');
    }
}
