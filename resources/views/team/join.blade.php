@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Join {{ $team->name }}</div>
          <div class="panel-body">
            @guest
              Join <strong>{{ $team->name }}</strong> on TeamZen and make time zone tracking easy. <br/><br/>

              First, <a href="{{ url('/register') }}">create an account</a> and come back to this page!
            @else
              @can('view', $team)
                You are already a member of this team
              @else
                Ready to join this team?
                <form method="post" action="{{ action('TeamController@doJoin', $team->join_token) }}">
                  {{ csrf_field() }}
                  <button type="submit" class="btn btn-primary">Join {{ $team->name }}</button>
                </form>
              @endcan
            @endguest
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
