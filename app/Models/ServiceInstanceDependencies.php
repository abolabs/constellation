<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @SWG\Definition(
 *      definition="ServiceInstanceDependencies",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="instance_id",
 *          description="instance_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="instance_dep_id",
 *          description="instance_dep_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="created_at",
 *          description="created_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @SWG\Property(
 *          property="updated_at",
 *          description="updated_at",
 *          type="string",
 *          format="date-time"
 *      )
 * )
 */
class ServiceInstanceDependencies extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use HasFactory;

    public $table = 'service_instance_dep';

    public static $levelsList = [1, 2, 3];

    protected $dates = ['deleted_at'];

    public $fillable = [
        'instance_id',
        'instance_dep_id',
        'level',
        'description',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'instance_id' => 'integer',
        'instance_dep_id' => 'integer',
        'level' => 'integer',
        'description' => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'instance_id' => [
            'required',
            'exists:service_instance,id',
        ],
        'instance_dep_id' => [
            'required',
            'exists:service_instance,id',
        ],
        'level' => 'integer|between:1,3',
        'description' => 'string|nullable|max:255',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function serviceInstance()
    {
        return $this->belongsTo(\App\Models\ServiceInstance::class, 'instance_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function serviceInstanceDep()
    {
        return $this->belongsTo(\App\Models\ServiceInstance::class, 'instance_dep_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function serviceInstanceDeps()
    {
        return $this->hasMany(\App\Models\ServiceInstance::class, 'id', 'instance_dep_id');
    }
}
