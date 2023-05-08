<?php

// Copyright (C) 2022 Abolabs (https://gitlab.com/abolabs/)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @SWG\Definition(
 *      definition="ServiceInstanceDependencies",
 *      required={""},
 *
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
    use Searchable;

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

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'instance_id' => $this->instance_id,
            'instance_dep_id' => $this->instance_dep_id,
            'level' => $this->level,
            'description' => $this->description,
        ];
    }
}
