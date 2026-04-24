<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Exercise;

class Plan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'trainer_id',
        'user_id',
        'client_id',
        'assigned_date'
    ];

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'plan_exercises')
            ->withPivot('sets', 'reps_min', 'reps_max')
            ->withTimestamps();
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->user_id && $model->client_id) {
                $model->user_id = $model->client_id;
            }
            if (!$model->client_id && $model->user_id) {
                $model->client_id = $model->user_id;
            }
        });
    }
}