<?php

namespace App\Http\Requests\API;

use App\Models\ServiceVersion;
use InfyOm\Generator\Request\APIRequest;

class UpdateServiceVersionAPIRequest extends APIRequest
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
            'service_id' => [
                ...ServiceVersion::$rules['service_id'],
            ],
            'version' => [
                'unique:service_version,version,' . $this->route('serviceVersion') . ',id,service_id,' . $this->service_id,
                ...ServiceVersion::$rules['version'],
            ],
        ];
    }
}
