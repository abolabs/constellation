<?php

namespace App\Policies;

use App\Models\ServiceVersion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceVersionPolicy
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
        return $user->can('view serviceVersion');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceVersion  $serviceVersion
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ServiceVersion $serviceVersion)
    {
        return $user->can('view serviceVersion');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create serviceVersion');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceVersion  $serviceVersion
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ServiceVersion $serviceVersion)
    {
        return $user->can('edit serviceVersion');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceVersion  $serviceVersion
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ServiceVersion $serviceVersion)
    {
        return $user->can('delete serviceVersion');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceVersion  $serviceVersion
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ServiceVersion $serviceVersion)
    {
        return $user->can('edit serviceVersion');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceVersion  $serviceVersion
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ServiceVersion $serviceVersion)
    {
        return $user->can('delete serviceVersion');
    }
}
