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

    public $table = 'app_instances';
    

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
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function serviceVersions()
    {
        return $this->hasMany(\App\Models\ServiceVersion::class, 'id', 'service_version_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function environnements()
    {
        return $this->hasMany(\App\Models\Environnement::class, 'id', 'environnement_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class, 'id', 'application_id');
    }
}
