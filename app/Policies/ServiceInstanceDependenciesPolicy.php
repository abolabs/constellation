<?php

namespace App\Policies;

use App\Models\ServiceInstanceDependencies;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceInstanceDependenciesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view serviceInstanceDep');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceInstanceDependencies  $serviceInstanceDependencies
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ServiceInstanceDependencies $serviceInstanceDependencies)
    {
        return $user->can('view serviceInstanceDep');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create serviceInstanceDep');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceInstanceDependencies  $serviceInstanceDependencies
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ServiceInstanceDependencies $serviceInstanceDependencies)
    {
        return $user->can('edit serviceInstanceDep');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceInstanceDependencies  $serviceInstanceDependencies
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ServiceInstanceDependencies $serviceInstanceDependencies)
    {
        return $user->can('delete serviceInstanceDep');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceInstanceDependencies  $serviceInstanceDependencies
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ServiceInstanceDependencies $serviceInstanceDependencies)
    {
        return $user->can('edit serviceInstanceDep');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceInstanceDependencies  $serviceInstanceDependencies
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ServiceInstanceDependencies $serviceInstanceDependencies)
    {
        return $user->can('delete serviceInstanceDep');
    }
}
