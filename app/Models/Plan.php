<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\PlanExercise;

class Plan extends Model
{
    protected $fillable = [
        'trainer_id',
        'client_id',
        'name',
        'assigned_date'
    ];

    // Plan belongs to Trainer
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    // Plan belongs to Client
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Plan has many exercises
    public function planExercises()
    {
        return $this->hasMany(PlanExercise::class);
    }
}