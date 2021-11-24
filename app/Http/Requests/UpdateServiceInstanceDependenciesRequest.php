<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ServiceInstanceDependencies;
use App\Rules\ServiceInstancesDep\ServiceInstancesHasSameEnv;

class UpdateServiceInstanceDependenciesRequest extends FormRequest
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
                ...ServiceInstanceDependencies::$rules['instance_id']
            ],
            'instance_dep_id' => [
                ...ServiceInstanceDependencies::$rules['instance_dep_id']
            ]
        ];
    }
}
