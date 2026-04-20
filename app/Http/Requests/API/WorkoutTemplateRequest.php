<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class WorkoutTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'goal'        => 'nullable|string|max:255',
            'level'       => 'required|in:beginner,intermediate,advanced',
            'duration'    => 'nullable|integer|min:1',
            'is_active'   => 'boolean',
        ];
    }
}