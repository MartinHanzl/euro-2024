<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $table = 'teams';

    protected $fillable = ['name'];

    public function homeGames()
    {
        return $this->hasMany(Game::class, 'home_team_id', 'id');
    }

    public function awayGames()
    {
        return $this->hasMany(Game::class, 'away_team_id', 'id');
    }
}
