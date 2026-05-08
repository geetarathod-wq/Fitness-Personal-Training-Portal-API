<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],

            'password' => 'required|min:8|confirmed',

        ];
    }

    public function messages(): array
    {
        return [

            'name.required' => 'Name is required.',

            'email.required' => 'Email is required.',
            'email.email' => 'Enter valid email.',
            'email.unique' => 'Email already exists.',

            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',

        ];
    }
}