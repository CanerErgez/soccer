<?php

namespace App\Http\Controllers;

use App\Fixture;
use App\League;
use App\Result;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('year')) $league = League::where('year',$request->year)->orderBy('id','DESC')->with('teams')->first();
        else $league = League::orderBy('id','DESC')->with('teams')->first();


        $week = ($request->week) ?? 0;
        $year = ($league->year) ?? null;

        $fixtures = Fixture::where('week',$week)->where('year',$year);

        foreach ($fixtures as $fixture)
        {
            $fixture_list[] = $fixture->id;
        }

        $results = (isset($fixture_list)) ? Result::whereIn('fixture_id',$fixture_list)->get() : null;


        return view('table',compact('league','fixtures','week','results'));
    }
}
