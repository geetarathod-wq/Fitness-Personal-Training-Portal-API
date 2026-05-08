<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExerciseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'name' => 'required|string|max:255',
            'type' => [
                'required',
                'regex:/^[A-Za-z\s]+$/'
            ],
            'description' => 'nullable|string',
        ];
    }
    public function messages(): array
    {
        return [
            'type.required' => 'Exercise type is required.',
            'type.regex' => 'Only letters allowed in exercise type.',
        ];
    }
}