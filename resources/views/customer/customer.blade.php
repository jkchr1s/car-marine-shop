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
            <h4><i class="material-icons">email</i>Email</h4>
            <p>This customer doesn't have any email addresses.</p>
            <h4>Phone</h4>
            <p>This customer doesn't have any phone numbers.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection