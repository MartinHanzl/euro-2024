<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TipResource extends JsonResource
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
            'booster' => (bool)$this->booster,
            'points' => $this->points
        ];
    }
}
