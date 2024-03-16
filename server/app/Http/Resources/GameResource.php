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
            'home_team' => TeamResource::collection($this->home_team_id),
            'away_team' => TeamResource::collection($this->away_team_id),
            'home_goals' => (int)$this->home_goals,
            'away_goals' => (int)$this->away_goals,
            'type' => $this->type,
            'group' => GroupResource::make($this->group),
            'start_at' => $this->start_at
        ];
    }
}
