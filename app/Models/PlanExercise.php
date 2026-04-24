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
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}