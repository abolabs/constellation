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
