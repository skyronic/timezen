@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Add Team</div>

          <div class="panel-body">
            {!! form($addForm) !!}
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
