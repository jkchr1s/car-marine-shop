@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-body">
            <h2>
              <i class="material-icons">{{ $vehicle->type->icon }}</i>
              {{ $vehicle->description }}
            </h2>
            <a class="btn btn-raised" href="{{ route('customer.show', $vehicle->customer->id) }}">
              <i class="material-icons">keyboard_arrow_left</i>
              Back to {{ $vehicle->customer->display_name }}
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-body">
            This area will someday allow you to add notes and parts for warranty and service information.
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
