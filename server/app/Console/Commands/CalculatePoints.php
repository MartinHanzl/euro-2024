<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Tip;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CalculatePoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tips:calculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate tips and set points.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->output->info('Probíhá přepočítání bodů.');
        $games = Game::with('tips')
            //->where('start_at', '<=', Carbon::now())
            ->get();

        $this->output->progressStart(count($games));

        foreach ($games as $game) {
            if (!$game->tips) {
                continue;
            }

            $gameHomeGoals = $game->home_goals;
            $gameAwayGoals = $game->away_goals;
            $gameSumGoals = (int)$gameHomeGoals + $gameAwayGoals;
            $gameGoalsDiff = $this->diffScore($gameHomeGoals, $gameAwayGoals);;

            foreach ($game->tips as $tip) {
                $totalPoints = 0;

                $tipBooster = (bool)$tip->booster;
                $tipHomeGoals = $tip->home_goals;
                $tipAwayGoals = $tip->away_goals;
                $tipSumGoals = (int)$tipHomeGoals + $tipAwayGoals;
                $tipGoalsDiff = $this->diffScore($tipHomeGoals, $tipAwayGoals);

                if ($tipHomeGoals == $gameHomeGoals && $tipAwayGoals == $gameAwayGoals) { // správný výsledek
                    $totalPoints += 6;
                } else {
                    if (
                        (($gameHomeGoals > $gameAwayGoals && $tipHomeGoals > $tipAwayGoals)) ||
                        (($gameAwayGoals > $gameHomeGoals && $tipAwayGoals > $tipHomeGoals))) { // správné určení výherního týmu
                        $totalPoints += 3;
                    }
                    if ($tipGoalsDiff == $gameGoalsDiff) { // správný gólový rozdíl
                        $totalPoints += 2;
                    }
                    if ($tipSumGoals == $gameSumGoals) { // správný počet gólů v zápase
                        $totalPoints += 2;
                    }
                    if (($tipHomeGoals == $gameHomeGoals) || ($tipAwayGoals == $gameAwayGoals)) { // správný počet gólů domácí
                        $totalPoints += 1;
                    }
                }

                if ($tipBooster) {
                    $totalPoints = $totalPoints * 2;
                }

                try {
                    Tip::query()
                        ->find($tip->id)
                        ->update(['points' => $totalPoints]);
                } catch (\Throwable $th) {
                    echo 'Nepovedlo se updatovat celkové body tipu ' . $tip->id . PHP_EOL;
                }
            }
            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }

    private function diffScore($home, $away): int
    {
        $diff = 0;

        if ($home > $away) {
            $diff = $home - $away;
        } else if ($away > $home) {
            $diff = $away - $home;
        } else if ($home == $away) {
            $diff = 0;
        }

        return $diff;
    }
}
