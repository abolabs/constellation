<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ServiceVersion;

class UpdateServiceVersionRequest extends FormRequest
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
                ...ServiceVersion::$rules['service_id']
            ],
            'version' => [
                'unique:service_version,version,'.$this->route('serviceVersion')->id.',id,service_id,'.$this->service_id,
                ...ServiceVersion::$rules['version'],
            ]
        ] ;
    }
}
