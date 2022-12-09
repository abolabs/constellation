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
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class ServiceInstance.
 *
 * @version September 4, 2021, 4:52 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $serviceVersions
 * @property \Illuminate\Database\Eloquent\Collection $environnements
 * @property \Illuminate\Database\Eloquent\Collection $applications
 * @property int $application_id
 * @property int $service_version_id
 * @property int $environnement_id
 * @property string $url
 * @property bool $statut
 */
class ServiceInstance extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use SoftDeletes;

    use HasFactory;

    public $table = 'service_instance';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'application_id',
        'service_version_id',
        'environnement_id',
        'hosting_id',
        'url',
        'role',
        'statut',
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
        'hosting_id' => 'integer',
        'url' => 'string',
        'role' => 'string',
        'statut' => 'boolean',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = [
        'application_id' => 'required|exists:application,id',
        'service_version_id' => 'required|exists:service_version,id',
        'environnement_id' => 'required|exists:environnement,id',
        'hosting_id' => 'required|exists:hosting,id',
        'url' => 'nullable|url|max:255',
        'role' => 'nullable|string|max:255',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function serviceVersion()
    {
        return $this->belongsTo(\App\Models\ServiceVersion::class, 'service_version_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function environnement()
    {
        return $this->belongsTo(\App\Models\Environnement::class, 'environnement_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function application()
    {
        return $this->belongsTo(\App\Models\Application::class, 'application_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function hosting()
    {
        return $this->belongsTo(\App\Models\Hosting::class, 'hosting_id');
    }

    /**
     * Get the most used environnement.
     *
     * @return array
     */
    public static function getMainEnvironnement(): array
    {
        try {
            $env = self::select('environnement_id', DB::raw('count(*) as total'))->with('environnement')->orderBy('total', 'desc')->groupBy('environnement_id')->first()->toArray();
        } catch (\Throwable $e) {
            \Log::debug(" getMainEnvironnement " . $e);
        }


        if (empty($env)) {
            $tmpEnv = Environnement::first();
            $env = [
                'environnement' => [
                    'id' => $tmpEnv->id,
                    'name' => $tmpEnv->name,
                ],
            ];
        }

        return $env;
    }
}
