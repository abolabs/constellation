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
