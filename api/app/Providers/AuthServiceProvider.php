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

namespace App\Providers;

use App\Models\Application;
use App\Models\Audit;
use App\Models\Environnement;
use App\Models\Hosting;
use App\Models\HostingType;
use App\Models\Service;
use App\Models\ServiceInstance;
use App\Models\ServiceInstanceDependencies;
use App\Models\ServiceVersion;
use App\Models\Team;
use App\Policies\ApplicationPolicy;
use App\Policies\AuditPolicy;
use App\Policies\EnvironnementPolicy;
use App\Policies\HostingPolicy;
use App\Policies\HostingTypePolicy;
use App\Policies\ServiceInstanceDependenciesPolicy;
use App\Policies\ServiceInstancePolicy;
use App\Policies\ServicePolicy;
use App\Policies\ServiceVersionPolicy;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Application::class => ApplicationPolicy::class,
        Audit::class => AuditPolicy::class,
        Environnement::class => EnvironnementPolicy::class,
        Hosting::class => HostingPolicy::class,
        HostingType::class => HostingTypePolicy::class,
        Service::class => ServicePolicy::class,
        ServiceInstance::class => ServiceInstancePolicy::class,
        ServiceInstanceDependencies::class => ServiceInstanceDependenciesPolicy::class,
        ServiceVersion::class => ServiceVersionPolicy::class,
        Team::class => TeamPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }

        Passport::tokensCan([
            'name' => 'name',
            'email' => 'email',
        ]);

        Passport::setDefaultScope([
            'name' => 'name',
            'email' => 'email',
        ]);

        Gate::after(function ($user, $ability) {
            if ($user->hasRole(config('permission.super-admin-role'))) {
                return true;
            }
        });
    }
}
