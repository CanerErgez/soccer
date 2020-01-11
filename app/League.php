<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    protected $table="league";

    protected $fillable = ['league_id','name','strength','team_limit'];

    public function getLimitAttribute()
    {
        return $this->team_limit;
    }


    /*
     * Team OneToMany Relation
     */
    public function teams()
    {
        return $this->hasMany('App\Team');
    }
}
