<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\AppInstanceDependencies;
use App\Rules\AppInstancesDep\AppInstancesHasSameEnv;

class CreateAppInstanceDependenciesRequest extends FormRequest
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
