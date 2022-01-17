<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'name' => [
                'required', 'max:191'
            ],
            'email' => [
                'email' => 'email','unique:App\User,email,',
            ],
            'password' => [
                'required', 'string', 'confirmed'
            ],
            'role' => [
                'nullable','numeric'
            ],
            'addresses.*.address' => [
                'required'
            ],
            'addresses.*.postcode' => [
                'required','numeric'
            ],
            'addresses.*.state' => [
                'required'
            ],
            'addresses.*.country' => [
                'required'
            ],
        ];

        if (strtolower($this->method()) === "put") {
            $rules['password'] = [
                'nullable', 'string'
            ];
            $rules['email'] = [
                'email','unique:App\User,email,'.$this->user->id,
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'addresses.*.address.required' => 'The field is required.',
            'addresses.*.postcode.required' => 'The field is required.',
            'addresses.*.postcode.numeric' => 'The field must be numeric.',
        ];
    }
}



