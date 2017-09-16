@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $team->name }}</div>

                    <div class="panel-body">
                        <team-list team-id="{{ $team->id }}"></team-list>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
