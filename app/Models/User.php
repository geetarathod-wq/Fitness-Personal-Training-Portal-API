<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Plan;
use App\Models\DailyLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    const ROLE_TRAINER = 1;
    const ROLE_CLIENT = 2;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
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
        public function role()
    {
        return $this->belongsTo(\App\Models\Role::class);
    }
    public function trainerPlans()
    {
        return $this->hasMany(Plan::class, 'trainer_id');
    }

    public function clientPlans()
    {
        return $this->hasMany(Plan::class, 'client_id');
    }

    public function dailyLogs()
    {
        return $this->hasMany(DailyLog::class, 'client_id');
    }
    public function isTrainer()
    {
        return $this->role_id == self::ROLE_TRAINER;
    }
    public function isClient()
    {
        return $this->role_id == self::ROLE_CLIENT;
    }
}