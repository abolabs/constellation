<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @SWG\Definition(
 *      definition="ServiceVersion",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="service_id",
 *          description="service_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="version",
 *          description="version",
 *          type="string"
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
class ServiceVersion extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use HasFactory;

    public $table = 'service_version';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'service_id',
        'version',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'service_id' => 'integer',
        'version' => 'string',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'service_id' => ['required', 'exists:service,id'],
        'version' => ['required'],
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function service()
    {
        return $this->belongsTo(\App\Models\Service::class, 'service_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function instances()
    {
        return $this->hasMany(\App\Models\ServiceInstance::class, 'service_version_id');
    }

    public function newQuery()
    {
        $query = parent::newQuery()->with(['service']);

        return $query;
    }
}
