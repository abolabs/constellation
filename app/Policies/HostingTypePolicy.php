<?php

namespace App\Policies;

use App\Models\HostingType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HostingTypePolicy
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
        return $user->can('view hostingType');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HostingType  $hostingType
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, HostingType $hostingType)
    {
        return $user->can('view hostingType');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create hostingType');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HostingType  $hostingType
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, HostingType $hostingType)
    {
        return $user->can('edit hostingType');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HostingType  $hostingType
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, HostingType $hostingType)
    {
        return $user->can('delete hostingType');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HostingType  $hostingType
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, HostingType $hostingType)
    {
        return $user->can('edit hostingType');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\HostingType  $hostingType
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, HostingType $hostingType)
    {
        return $user->can('delete hostingType');
    }
}
