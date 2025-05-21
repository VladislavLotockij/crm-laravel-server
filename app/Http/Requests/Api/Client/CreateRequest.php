<?php

namespace App\Http\Requests\Api\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('clients')->whereNull('deleted_at')
            ],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[\+\d\s\-\(\)]+$/'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'manager_id' => [
                'nullable',
                'exists:users,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'The "First Name" field is required.',
            'first_name.max' => 'First Name must not exceed 100 characters.',

            'last_name.required' => 'The "Last Name" field is required.',
            'last_name.max' => 'Last Name must not exceed 100 characters.',

            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email must not exceed 255 characters.',
            'email.unique' => 'A client with this email already exists.',

            'phone.regex' => 'Invalid phone number format. Only digits, +, -, spaces, and parentheses are allowed.',

            'manager_id.exists' => 'The selected manager does not exist or is inactive.',
        ];
    }
}
