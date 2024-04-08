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

namespace App\Rules\ServiceInstancesDep;

use App\Models\ServiceInstance;
use Illuminate\Contracts\Validation\Rule;

class ServiceInstancesHasSameEnv implements Rule
{
    private $data;

    /**
     * Constructor.
     */
    public function __construct(array $data)
    {
        $this->data = collect($data);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $sourceInstance = ServiceInstance::find($value, ['environment_id']);
            $depInstance = ServiceInstance::find($this->data->get('instance_dep_id'), ['environment_id']);

            return $sourceInstance->environment_id == $depInstance->environment_id;
        } catch (\Exception $exception) {
            \Log::warning($exception);

            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Source instance and dependency should be on the same environment.';
    }
}
