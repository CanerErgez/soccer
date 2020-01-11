<?php
namespace App\Services;

use App\Fixture;
use App\Result;
use App\Team;

class PlayMatch
{
    public function playMatch(Fixture $fixture): bool
    {
        $homeTeam = Team::where('id',$fixture->home_team)->first();
        $awayTeam = Team::where('id',$fixture->away_team)->first();

        $homeGoal = $this->calculateRandomGoal($this->homeTeamAdventage($homeTeam->strength), $awayTeam->strength, 1);
        $awayGoal = $this->calculateRandomGoal($this->homeTeamAdventage($homeTeam->strength), $awayTeam->strength, 0);

        $this->saveResult($fixture, $homeGoal, $awayGoal);

        return true;
    }

    public function homeTeamAdventage(float $strength): float
    {
        return (float)$strength+0.1;
    }

    public function calculateRandomGoal(float $homeRate , float $awayRate , bool $isHome): int
    {
        $goalRand = rand(0,100) / 100;

        return floor($goalRand * floor(10 * $this->normalizeTeamPowers($homeRate, $awayRate, $isHome)));
    }

    public function normalizeTeamPowers(float $homeRate , float $awayRate , bool $isHome): float
    {
        if ($isHome) return $homeRate / ($homeRate + $awayRate);

        return $awayRate / ($homeRate + $awayRate);
    }

    public function saveResult(Fixture $fixture, int $homeGoal, int $awayGoal): bool
    {
        $result = new Result();
        $result->fixture_id = $fixture->id;
        $result->home_goal = $homeGoal;
        $result->away_goal = $awayGoal;
        $result->save();

        return true;
    }
}
