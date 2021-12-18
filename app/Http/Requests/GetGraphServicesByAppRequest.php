<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetGraphServicesByAppRequest extends FormRequest
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
            'environnement_id' => 'exists:environnement,id',
            'tag' => 'nullable|string',
            'application_id.*' => 'nullable|exists:application,id',
            'hosting_id.*' => 'nullable|exists:hosting,id',
        ];
    }
}
