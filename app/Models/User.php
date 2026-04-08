<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\DailyLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Trainer → creates plans
    public function trainerPlans()
    {
        return $this->hasMany(Plan::class, 'trainer_id');
    }

    // Client → receives plans
    public function clientPlans()
    {
        return $this->hasMany(Plan::class, 'client_id');
    }

    // Client → daily logs
    public function dailyLogs()
    {
        return $this->hasMany(DailyLog::class, 'client_id');
    }
}