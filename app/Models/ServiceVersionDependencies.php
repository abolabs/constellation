<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ServiceVersionDependencies
 * @package App\Models
 * @version September 4, 2021, 4:37 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $serviceVersions
 * @property \Illuminate\Database\Eloquent\Collection $serviceVersion1s
 * @property integer $service_version_id
 * @property integer $service_version_dependency_id
 */
class ServiceVersionDependencies extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'service_version_dependencies';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'service_version_id',
        'service_version_dependency_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'service_version_id' => 'integer',
        'service_version_dependency_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'service_version_id' => 'required|exists:service_version,id',
        'service_version_dependency_id' => 'required|exists:service_version,id',
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
    public function serviceVersion1s()
    {
        return $this->hasMany(\App\Models\ServiceVersion::class, 'id', 'service_version_dependency_id');
    }
}
