<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class DailyLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'weight'   => 'required|numeric|min:0|max:500',
            'calories' => 'nullable|numeric|min:0|max:10000',
            'date'     => 'required|date',
        ];
    }
}