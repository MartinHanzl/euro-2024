<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    use HasFactory;

    protected $table = 'tips';

    protected $fillable = [
        'user_id',
        'game_id',
        'home_goals',
        'away_goals',
        'booster',
        'points'
    ];

    protected $casts = [
        'booster' => 'boolean'
    ];
}
