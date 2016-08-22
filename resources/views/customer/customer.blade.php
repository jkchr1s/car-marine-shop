@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-body">
            <h2>
              <i class="material-icons">{{ $customer_type->icon }}</i>
              {{ $customer_type->type == 'Business' ? $company : $first_name . ' ' . $last_name }}
            </h2>
            @if($customer_type == 'Business' && (strlen($first_name) > 0 || strlen($last_name) > 0))
              {{$first_name}} {{$last_name}}
            @elseif($customer_type == 'Personal' && strlen($company) > 0)
              {{$company}}
            @endif
            <hr>
            <h3>Contact Information</h3>
            <p>&nbsp;</p>
            <h4>Email</h4>
            @if(is_array($emails) && count($emails) > 0)
              <ul>
                @foreach($emails as $email)
                  <li><a href="mailto:{{$email->email}}">{{$email->email}}</a></li>
                @endforeach
              </ul>
            @else
              <p>This customer doesn't have any email addresses.</p>
            @endif
            <a href="javascript:void(0)" class="btn btn-default">Add New Email Address</a>

            <h4>Phone</h4>
            @if(is_array($phones) && count($phones) > 0)
              <ul>
                @foreach($phones as $phone)
                  <li><a href="tel:{{$phone->number}}">Call {{$phone->number}} ({{$phone->type}}</a></li>
                @endforeach
              </ul>
            @else
              <p>This customer doesn't have any phone numbers.</p>
            @endif
            <a href="javascript:void(0)" class="btn btn-default">Add New Phone Number</a>

            <h4>Locations</h4>
            @if(is_array($locations) && count($locations) > 0)
              @foreach($locations as $location)
                This is a location
              @endforeach
            @else
              <p>This customer doesn't have any locations.</p>
            @endif
            <a href="javascript:void(0)" class="btn btn-default">Add New Location</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-body">
            <h2>Vehicles</h2>
            @if(is_array($vehicles) && count($vehicles) > 0)
              @foreach($vehicles as $vehicle)
                This is a vehicle
              @endforeach
            @else
              <p>This customer doesn't have any vehicles.</p>
            @endif
            <a href="javascript:void(0)" class="btn btn-default">Add New Vehicle</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection