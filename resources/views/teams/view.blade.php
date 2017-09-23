@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $team->name }}</div>
                    <div class="panel-body">
                      <div>
                        Admins:
                        @can('admin', $team)
                          You're an admin
                        @endcan
                        <ul>
                          @foreach($admins as $adm)
                            <li>{{ $adm->name }}</li>
                          @endforeach
                        </ul>
                      </div>
                      @can('admin', $team)
                        <team-list team-id="{{ $team->id }}" :is-admin="true"></team-list>
                      @else()
                        <team-list team-id="{{ $team->id }}" :is-admin="false"></team-list>
                      @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
