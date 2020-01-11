<?php

namespace App\Http\Controllers;

use App\Fixture;
use App\Result;
use Illuminate\Http\Request;
use App\Services\PlayMatch;

class MatchController extends Controller
{
    public function __construct(PLayMatch $playMatch)
    {
        $this->playMatch = $playMatch;
    }

    public function playWeek(Request $request)
    {
        $matches = Fixture::where('week',$request->week)->where('year',$request->year)->get();

        foreach ($matches as $match)
        {
            if( Result::where('fixture_id',$match->id)->count() ) continue;
            $this->playMatch->playMatch($match);
        }

        return redirect('/?week='.$request->week);
    }

    public function playAll(Request $request)
    {
        $matches = Fixture::where('year',$request->year)->get();

        foreach ($matches as $match)
        {
            if( Result::where('fixture_id',$match->id)->count() ) continue;
            $this->playMatch->playMatch($match);
        }

        return redirect('/?week=6');
    }
}
