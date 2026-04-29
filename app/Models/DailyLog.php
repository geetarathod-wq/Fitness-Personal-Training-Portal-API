<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyLog extends Model
{   use SoftDeletes;
    protected $table = 'daily_logs';

    protected $fillable = [
        'user_id',
        'client_id',
        'date',
        'weight',
        'bodyfat',   
        'calories',
        'notes'
    ];
    protected $dates = ['deleted_at'];
    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
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