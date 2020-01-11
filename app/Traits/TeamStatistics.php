<?php
namespace App\Traits;

use App\Fixture;
use App\Result;

trait TeamStatistics
{
    public function getTotalMatch(): int
    {
        return $this->getWin() + $this->getDraw() + $this->getLose();
    }

    public function getPoint(): int
    {
        return $this->getWin() * 3 + $this->getDraw() * 1;
    }

    public function getWin(): int
    {
        $homeMatches = $this->getMatches('home_team');
        $awayMatches = $this->getMatches('away_team');

        $count = 0;

        foreach ($homeMatches as $match)
        {
            if ($match->home_goal > $match->away_goal) $count++;
        }

        foreach ($awayMatches as $match)
        {
            if ($match->away_goal > $match->home_goal) $count++;
        }

        return $count;
    }

    public function getDraw(): int
    {
        $homeMatches = $this->getMatches('home_team');
        $awayMatches = $this->getMatches('away_team');

        $count = 0;

        foreach ($homeMatches as $match)
        {
            if ($match->home_goal == $match->away_goal) $count++;
        }

        foreach ($awayMatches as $match)
        {
            if ($match->away_goal == $match->home_goal) $count++;
        }

        return $count;
    }

    public function getLose(): int
    {
        $homeMatches = $this->getMatches('home_team');
        $awayMatches = $this->getMatches('away_team');

        $count = 0;

        foreach ($homeMatches as $match)
        {
            if ($match->home_goal < $match->away_goal) $count++;
        }

        foreach ($awayMatches as $match)
        {
            if ($match->away_goal < $match->home_goal) $count++;
        }

        return $count;
    }

    public function getGoal(): int
    {
        $homeMatches = $this->getMatches('home_team');
        $awayMatches = $this->getMatches('away_team');

        $count = 0;

        foreach ($homeMatches as $match)
        {
            $count += $match->home_goal;
        }

        foreach ($awayMatches as $match)
        {
            $count += $match->away_goal;
        }

        return $count;
    }

    public function getReGoal(): int
    {
        $homeMatches = $this->getMatches('home_team');
        $awayMatches = $this->getMatches('away_team');

        $count = 0;

        foreach ($homeMatches as $match)
        {
            $count += $match->away_goal;
        }

        foreach ($awayMatches as $match)
        {
            $count += $match->home_goal;
        }

        return $count;
    }

    public function getGoalAvg(): int
    {
        return $this->getGoal() - $this->getReGoal();
    }

    public function getMatches(string $type)
    {
        $matches = Fixture::where($type,$this->id)->get();

        $matchArray = [];
        foreach ($matches as $match)
        {
            $matchArray[] = $match->id;
        }

        return Result::whereIn('fixture_id', $matchArray)->get();
    }
}
