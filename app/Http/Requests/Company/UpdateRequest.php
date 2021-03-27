<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() ? Auth::user()->is_admin : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $company_id = $this->company->id;

        return [
            'name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('companies', 'name')->ignore($company_id)
            ],
            'phone' => [
                'string',
                'max:20',
            ],
            'url' => [
                'string',
                'max:255'
            ],
            'email' => [
                'string',
                'email',
                'max:255'
            ]
        ];
    }
}
