<?php

namespace App\Http\Requests;

use App\Models\ServiceInstanceDependencies;
use App\Rules\ServiceInstancesDep\ServiceInstancesHasSameEnv;
use Illuminate\Foundation\Http\FormRequest;

class CreateServiceInstanceDependenciesRequest extends FormRequest
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
                new ServiceInstancesHasSameEnv($this->all()),
                ...ServiceInstanceDependencies::$rules['instance_id'],
            ],
            'instance_dep_id' => [
                ...ServiceInstanceDependencies::$rules['instance_dep_id'],
            ],

        ];
    }
}
