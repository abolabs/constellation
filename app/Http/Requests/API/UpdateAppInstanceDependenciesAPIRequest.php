<?php

namespace App\Http\Requests\API;

use App\Models\AppInstanceDependencies;
use App\Rules\AppInstancesDep\AppInstancesHasSameEnv;
use InfyOm\Generator\Request\APIRequest;

class UpdateAppInstanceDependenciesAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'instance_id' => [
                new AppInstancesHasSameEnv($this->all()),
                ...AppInstanceDependencies::$rules['instance_id']
            ],
            'instance_dep_id' => [
                ...AppInstanceDependencies::$rules['instance_dep_id']
            ]
        ];
    }
}
