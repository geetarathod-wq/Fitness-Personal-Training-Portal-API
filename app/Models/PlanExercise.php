<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Plan;
use App\Models\Exercise;

class PlanExercise extends Model
{
    protected $fillable = [
        'plan_id',
        'exercise_id',
        'sets',
        'reps_min',
        'reps_max'
    ];

    // Each entry belongs to a plan
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    // Each entry belongs to an exercise
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}