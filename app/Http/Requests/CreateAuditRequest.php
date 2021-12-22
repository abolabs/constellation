<?php

namespace App\Http\Requests;

use App\Models\Audit;
use Illuminate\Foundation\Http\FormRequest;

class CreateAuditRequest extends FormRequest
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
        return Audit::$rules;
    }
}
