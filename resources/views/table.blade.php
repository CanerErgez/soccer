@extends('layout')

@section('table')
    <table class="table table-bordered">
        <tr>
            <th colspan="9">@if($league) {{ $league->name }} @endif Table - Week #{{ $week }}</th>
        </tr>
        <tr>
            <th>Teams</th>
            <th>PTS</th>
            <th>P</th>
            <th>W</th>
            <th>D</th>
            <th>L</th>
            <th>G</th>
            <th>RG</th>
            <th>GD</th>
        </tr>
        @if($league)
        @foreach($league->teams->sortByDesc('point') as $team)
        <tr>
            <td>{{ $team->name }}</td>
            <td>{{ $team->point }}</td>
            <td>{{ $team->total_match }}</td>
            <td>{{ $team->win }}</td>
            <td>{{ $team->draw }}</td>
            <td>{{ $team->lose }}</td>
            <td>{{ $team->goal }}</td>
            <td>{{ $team->re_goal }}</td>
            <td>{{ $team->goal_avg }}</td>
        </tr>
        @endforeach
        @endif
        <tr>
            <td colspan="9">
                @if($league)
                    @if($week < (count($league->teams )-1) * 2)
                        <a href="/play-all?year={{ $league->year }}" class="btn btn-primary pull-left">Play All</a>
                    @endif
                @endif
                @if($league)
                    @if($week < (count($league->teams )-1) * 2)
                        <a href="/play-week?week={{ $week+1 }}&year={{ $league->year }}" class="btn btn-primary pull-right" style="float:right;">Next Week</a>
                    @endif
                @endif
            </td>
        </tr>
    </table>
@endsection
