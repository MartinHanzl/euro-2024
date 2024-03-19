<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'home_goals' => (int)$this->home_goals,
            'away_goals' => (int)$this->away_goals,
            'type' => $this->type,
            'tips' => TipResource::collection($this->tips),
            'home_team' => TeamResource::make($this->homeTeam),
            'away_team' => TeamResource::make($this->awayTeam),
            'start_at' => $this->start_at
        ];
    }
}
