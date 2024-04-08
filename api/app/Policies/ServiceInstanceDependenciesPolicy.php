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

class ServiceInstanceDependenciesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view service_instance_dependencies');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ServiceInstanceDependencies $serviceInstanceDependencies): bool
    {
        return $user->can('view service_instance_dependencies');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create service_instance_dependencies');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ServiceInstanceDependencies $serviceInstanceDependencies): bool
    {
        return $user->can('edit service_instance_dependencies');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ServiceInstanceDependencies $serviceInstanceDependencies): bool
    {
        return $user->can('delete service_instance_dependencies');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ServiceInstanceDependencies $serviceInstanceDependencies): bool
    {
        return $user->can('edit service_instance_dependencies');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ServiceInstanceDependencies $serviceInstanceDependencies): bool
    {
        return $user->can('delete service_instance_dependencies');
    }
}
