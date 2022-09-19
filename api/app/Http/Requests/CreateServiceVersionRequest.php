<?php

namespace App\Http\Requests;

use App\Models\ServiceVersion;
use Illuminate\Foundation\Http\FormRequest;

class CreateServiceVersionRequest extends FormRequest
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
                'unique:service_version,version,NULL,service_id,service_id,' . $this->service_id,
                ...ServiceVersion::$rules['version'],
            ],
        ];
    }
}
