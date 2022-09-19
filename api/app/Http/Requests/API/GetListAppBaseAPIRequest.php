<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetListAppBaseAPIRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'perPage' => ['nullable', Rule::in([5, 10, 25, 100, 1000])],
            'page'    => 'nullable|numeric',
            'sort'    => 'nullable|string',
            'filter'  => 'nullable|array',
            'q'       => 'nullable|string',
        ];
    }
}
