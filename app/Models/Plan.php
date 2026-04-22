<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'trainer_id',
        'client_id',
        'assigned_date'
    ];

    // 🏋️ Exercises
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'plan_exercises')
            ->withPivot('sets', 'reps_min', 'reps_max')
            ->withTimestamps();
    }

    // 👨‍🏫 Trainer
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    // 👤 Client
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    

    
}