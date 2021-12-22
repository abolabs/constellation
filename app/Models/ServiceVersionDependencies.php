<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class ServiceVersionDependencies.
 *
 * @version September 4, 2021, 4:37 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $serviceVersions
 * @property \Illuminate\Database\Eloquent\Collection $serviceVersion1s
 * @property int $service_version_id
 * @property int $service_version_dependency_id
 */
class ServiceVersionDependencies extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use HasFactory;

    public $table = 'service_version_dependencies';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'service_version_id',
        'service_version_dependency_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'service_version_id' => 'integer',
        'service_version_dependency_id' => 'integer',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'service_version_id' => 'required|exists:service_version,id',
        'service_version_dependency_id' => 'required|exists:service_version,id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function serviceVersion()
    {
        return $this->hasOne(\App\Models\ServiceVersion::class, 'id', 'service_version_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function serviceVersionDep()
    {
        return $this->hasOne(\App\Models\ServiceVersion::class, 'id', 'service_version_dependency_id');
    }

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
    public function serviceVersionDeps()
    {
        return $this->hasMany(\App\Models\ServiceVersion::class, 'id', 'service_version_dependency_id');
    }
}
