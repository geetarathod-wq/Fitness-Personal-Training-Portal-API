<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DailyLog extends Model
{
    protected $fillable = [
        'user_id',
        'client_id',
        'date',
        'weight',
        'bodyfat',
        'calories',
        'notes'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}