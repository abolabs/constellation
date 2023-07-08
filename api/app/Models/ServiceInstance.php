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

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class ServiceInstance.
 *
 * @version September 4, 2021, 4:52 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $serviceVersions
 * @property \Illuminate\Database\Eloquent\Collection $environments
 * @property \Illuminate\Database\Eloquent\Collection $applications
 * @property int $application_id
 * @property int $service_version_id
 * @property int $environment_id
 * @property string $url
 * @property bool $statut
 */
class ServiceInstance extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    use HasFactory;
    use Searchable;
    use CascadeSoftDeletes;

    public $table = 'service_instance';

    protected $cascadeDeletes = ['serviceInstanceSourceDeps', 'serviceInstanceTargetDeps'];

    protected $dates = ['deleted_at'];

    public $fillable = [
        'application_id',
        'service_version_id',
        'environment_id',
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
        'environment_id' => 'integer',
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
        'environment_id' => 'required|exists:environment,id',
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
    public function environment()
    {
        return $this->belongsTo(\App\Models\Environment::class, 'environment_id');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function serviceInstanceSourceDeps()
    {
        return $this->hasMany(ServiceInstanceDependencies::class, 'instance_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function serviceInstanceTargetDeps()
    {
        return $this->hasMany(ServiceInstanceDependencies::class, 'instance_dep_id', 'id');
    }

    /**
     * Get the value used to index the model.
     *
     * @return mixed
     */
    public function getScoutKey()
    {
        return $this->id;
    }

    /**
     * Get the key name used to index the model.
     *
     * @return mixed
     */
    public function getScoutKeyName()
    {
        return 'id';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    #[SearchUsingPrefix(['id', 'service_version'])]
    #[SearchUsingFullText(['application_name', 'service_name', 'hosting_name'])]
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'application_id' => $this->application_id,
            'application_name' => $this->application->name,
            'service_version_id' => $this->service_version_id,
            'service_version' => $this->serviceVersion->version,
            'service_name' => $this->serviceVersion->service->name,
            'environment_id' => $this->environment_id,
            'environment_name' => $this->environment->name,
            'hosting_id' => $this->hosting_id,
            'hosting_name' => $this->hosting->name,
            'role' => $this->role,
            'statut' => $this->statut,
        ];
    }

    /**
     * Get the most used environment.
     */
    public static function getMainEnvironment(): array
    {
        try {
            $env = self::select('environment_id', DB::raw('count(*) as total'))
                ->with('environment')
                ->orderBy('total', 'desc')
                ->groupBy('environment_id')
                ->first()
                ->toArray();
        } catch (\Throwable $e) {
            \Log::error(' getMainEnvironment ' . $e);
        }

        if (empty($env)) {
            $tmpEnv = Environment::first();
            $env = [
                'environment' => [
                    'id' => $tmpEnv->id,
                    'name' => $tmpEnv->name,
                ],
            ];
        }

        return $env;
    }
}
