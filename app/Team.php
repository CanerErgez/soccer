<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TeamStatistics;

class Team extends Model
{
    use TeamStatistics;

    protected $table="team";

    protected $appends = [
        'point',
        'win',
        'draw',
        'lose',
        'goal',
        're_goal',
        'goal_avg',
        'total_match',
    ];

    /*
     * League ManyToOne Relation
     */
    public function league()
    {
        return $this->belongsTo('App\League');
    }

    public function getTotalMatchAttribute()
    {
        return $this->getTotalMatch();
    }

    public function getPointAttribute()
    {
        return $this->getPoint();
    }

    public function getWinAttribute ()
    {
        return $this->getWin();
    }

    public function getDrawAttribute ()
    {
        return $this->getDraw();
    }

    public function getLoseAttribute ()
    {
        return $this->getLose();
    }

    public function getGoalAttribute ()
    {
        return $this->getGoal();
    }

    public function getReGoalAttribute ()
    {
        return $this->getReGoal();
    }

    public function getGoalAvgAttribute ()
    {
        return $this->getGoalAvg();
    }
}
