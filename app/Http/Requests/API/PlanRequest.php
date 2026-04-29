<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',

            'client_id' => [
                'required',
                'integer',
                \Illuminate\Validation\Rule::exists('users', 'id')
                    ->where(function ($query) {
                        $query->where('role_id', \App\Models\User::ROLE_CLIENT);
                    }),
            ],

            'assigned_date' => 'required|date|after_or_equal:today',

            'exercises' => 'nullable|array',
        ];
    }
}