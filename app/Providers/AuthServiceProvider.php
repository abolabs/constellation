<?php

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
use App\Policies\ApplicationPolicy;
use App\Policies\AuditPolicy;
use App\Policies\EnvironnementPolicy;
use App\Policies\HostingPolicy;
use App\Policies\HostingTypePolicy;
use App\Policies\ServicePolicy;
use App\Policies\ServiceInstancePolicy;
use App\Policies\ServiceInstanceDependenciesPolicy;
use App\Policies\ServiceVersionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::after(function ($user, $ability) {
            if($user->hasRole(config('permission.super-admin-role'))){
                return true;
            }
        });
    }
}
