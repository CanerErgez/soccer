<?php
namespace App\Services;

use App\Fixture;
use App\League;
use App\Team;
use Illuminate\Support\Str;

class SetupService
{
    public function generateNewLeague()
    {
        $league = $this->createLeague();
        $teams = $this->generateTeams($league);
        return $this->generateFixtures($teams, $league);
    }

    public function createLeague(): League
    {
        $leagueCount = League::count();

        $league = new League();
        $league->name = $this->generateLeagueName($leagueCount);
        $league->year = $leagueCount+date('Y');
        $league->team_limit = 4;
        $league->save();

        return $league;
    }

    public function generateLeagueName($leagueCount): string
    {
        return ($leagueCount+date('Y')) . ' - ' . ($leagueCount+date('Y')+1) . ' League';
    }

    public function generateTeams(League $league): array
    {
        if ($league == null) return false;

        for ($i=0; $i < $league->team_limit; $i++)
        {
            $team[$i] = $this->generateTeam($league);
        }

        return $team;
    }

    public function generateTeam(League $league): Team
    {
        $team = new Team();
        $team->league_id = $league->id;
        $team->name = Str::random(10);
        $team->strength = rand(0,100);
        $team->save();

        return $team;
    }

    public function generateFixtures($teams, League $league): bool
    {
        if ($teams == null || !is_array($teams)) return false;

        for ($i = 0; $i < count($teams); $i++)
        {
            for ($j=$i+1; $j < count($teams); $j++)
            {
                $allMatchs[] = [
                    'homeTeam' => $teams[$i]->id,
                    'homeName' => $teams[$i]->name,
                    'awayTeam' => $teams[$j]->id,
                    'awayName' => $teams[$j]->name,
                ];

                $allMatchs[] = [
                    'homeTeam' => $teams[$j]->id,
                    'homeName' => $teams[$j]->name,
                    'awayTeam' => $teams[$i]->id,
                    'awayName' => $teams[$i]->name,
                ];
            }
        }

        $this->test($allMatchs, $league);

        return true;
    }

    public function test($allMatchs, League $league)
    {
        $week = 1;
        while($allMatchs)
        {
            $usedTeams = [$allMatchs[0]['homeTeam'],  $allMatchs[0]['awayTeam']];

            $homeTeam = $allMatchs[0]['homeTeam'];
            $awayTeam = $allMatchs[0]['awayTeam'];

            $fixture = new Fixture();
            $fixture->home_team = $homeTeam;
            $fixture->away_team = $awayTeam;
            $fixture->week = $week;
            $fixture->year = $league->year;
            $fixture->save();

            $fixture = new Fixture();
            $fixture->home_team = $awayTeam;
            $fixture->away_team = $homeTeam;
            $fixture->week = $week + $league->team_limit - 1;
            $fixture->year = $league->year;
            $fixture->save();

            $this->unsetData($allMatchs, $homeTeam, $awayTeam);
            $this->unsetData($allMatchs, $awayTeam, $homeTeam);

            $allMatchs = array_values($allMatchs);

            for ($j=0; $j<count($allMatchs); $j++)
            {
                if (in_array($allMatchs[$j]['homeTeam'],$usedTeams) || in_array($allMatchs[$j]['awayTeam'],$usedTeams)) continue;

                $homeTeam = $allMatchs[$j]['homeTeam'];
                $awayTeam = $allMatchs[$j]['awayTeam'];

                $fixture = new Fixture();
                $fixture->home_team = $homeTeam;
                $fixture->away_team = $awayTeam;
                $fixture->week = $week;
                $fixture->year = $league->year;
                $fixture->save();

                $fixture = new Fixture();
                $fixture->home_team = $awayTeam;
                $fixture->away_team = $homeTeam;
                $fixture->week = $week + $league->team_limit - 1;
                $fixture->year = $league->year;
                $fixture->save();

                $this->unsetData($allMatchs, $homeTeam, $awayTeam);
                $this->unsetData($allMatchs, $awayTeam, $homeTeam);
            }

            $week++;
        }
    }

    public function unsetData(&$allMatches, $homeTeam, $awayTeam)
    {
        for ($i=0; $i<count($allMatches); $i++)
        {
            if ($allMatches[$i]['homeTeam'] == $homeTeam && $allMatches[$i]['awayTeam'] == $awayTeam)
            {
                unset($allMatches[$i]);
                $allMatches = array_values($allMatches);
                break;
            }
        }
    }


}
