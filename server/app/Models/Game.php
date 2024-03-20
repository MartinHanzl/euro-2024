<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'home_goals',
        'away_goals',
        'type',
        'group_id',
        'start_at'
    ];

    public function tip()
    {
        return $this->hasMany(Tip::class, 'game_id', 'id');
    }

    public function homeTeam()
    {
        return $this->hasOne(Team::class, 'id', 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->hasOne(Team::class, 'id', 'away_team_id');
    }
}
