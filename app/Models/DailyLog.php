<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DailyLog extends Model
{
    protected $table = 'daily_logs';

    protected $fillable = [
        'user_id',
        'client_id',
        'date',
        'weight',
        'bodyfat',   // ✅ FIXED
        'calories',
        'notes'
    ];

    // Relationship (client = user)
    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Auto sync user_id and client_id (keeps your existing logic safe)
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