<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\DailyLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    const ROLE_TRAINER = 1;
    const ROLE_CLIENT = 2;

    use HasFactory, Notifiable;
    use SoftDeletes;

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

    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class);
    }

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

    // ================= ROLE CHECK METHODS (ADDED) =================
    public function isAdmin()
    {
        return $this->role_id == self::ROLE_TRAINER;
    }

    public function isClient()
    {
        return $this->role_id == self::ROLE_CLIENT;
    }
}