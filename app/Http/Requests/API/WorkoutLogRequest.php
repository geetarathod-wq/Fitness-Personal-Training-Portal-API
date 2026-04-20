<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class WorkoutLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'plan_id'     => 'required|exists:plans,id',
            'exercise_id' => 'required|exists:exercises,id',
            'sets'        => 'required|integer|min:1|max:50',
            'reps'        => 'required|integer|min:1|max:100',
            'weight'      => 'nullable|numeric|min:0|max:1000',
            'duration'    => 'nullable|integer|min:0|max:300',
            'notes'       => 'nullable|string|max:1000',
            'logged_at'   => 'nullable|date',
        ];
    }
}