@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $team->name }}</div>
                    <div class="panel-body">
                      @can('admin', $team)
                        <team-list team-id="{{ $team->id }}" :is-admin="true"></team-list>
                      @else()
                        <team-list team-id="{{ $team->id }}" :is-admin="false"></team-list>
                      @endcan
                      <div>
                        Invite people to this team <a href="#">[regenerate link]</a>
                        <input type="text" class="input form-control col-md-4" value="{{ $team->inviteLink() }}" disabled>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
