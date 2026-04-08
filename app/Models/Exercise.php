<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PlanExercise;

class Exercise extends Model
{
    protected $fillable = [
        'name',
        'type'
    ];

    public function planExercises()
    {
        return $this->hasMany(PlanExercise::class);
    }
}