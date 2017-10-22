@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-2">
        <div class="panel panel-default">
          <div class="panel-heading">Teams</div>

          <div class="panel-body">
            <ul>
              @foreach($teams as $team)
                <li>
                  <a href="{{ route('team_view', $team) }}">{{ $team->name }}</a>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">The Time</div>

                <div class="panel-body">
                    <starred-list></starred-list>

                  <div>
                    <a href="{{ route('add_custom') }}" class="btn">Add Custom</a>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
