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

namespace App\Policies;

use App\Models\ServiceInstance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceInstancePolicy
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
        return $user->can('view serviceInstance');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceInstance  $serviceInstance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ServiceInstance $serviceInstance)
    {
        return $user->can('view serviceInstance');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create serviceInstance');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceInstance  $serviceInstance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ServiceInstance $serviceInstance)
    {
        return $user->can('edit serviceInstance');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceInstance  $serviceInstance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ServiceInstance $serviceInstance)
    {
        return $user->can('delete serviceInstance');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceInstance  $serviceInstance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ServiceInstance $serviceInstance)
    {
        return $user->can('edit serviceInstance');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ServiceInstance  $serviceInstance
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ServiceInstance $serviceInstance)
    {
        return $user->can('delete serviceInstance');
    }
}
