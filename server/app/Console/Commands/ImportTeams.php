<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Revolution\Google\Sheets\Facades\Sheets;

class ImportTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teams:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import or update teams.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $values = Sheets::spreadsheet('1L0qUT0wQXrwKys5WkQHyGaFftquqodNqPcX1esZLcJQ')->sheet('Základní skupina')->get();
        dd($values);

        $this->importTeams();
        $this->importGroups();
        $this->importMatches();
    }

    private function importTeams()
    {
    }

    private function importGroups()
    {

    }

    private function importMatches()
    {

    }
}
