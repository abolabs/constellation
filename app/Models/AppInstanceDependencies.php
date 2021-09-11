<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @SWG\Definition(
 *      definition="AppInstanceDependencies",
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
class AppInstanceDependencies extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'app_instance_dep';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'instance_id',
        'instance_dep_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'instance_id' => 'integer',
        'instance_dep_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'instance_id' => 'required|exists:instance,id',
        'instance_dep_id' => 'required|exists:instance,id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function appInstances()
    {
        return $this->hasMany(\App\Models\AppInstance::class, 'id', 'instance_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function appInstance1s()
    {
        return $this->hasMany(\App\Models\AppInstance::class, 'id', 'instance_dep_id');
    }
}
