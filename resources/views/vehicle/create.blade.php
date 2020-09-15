@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-body">
            <a href="{{ route('customer.show', $customer->id) }}">{{ $customer->display_name }}</a> > New Vehicle
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-body">
            <form id="create_vehicle_form" class="form-horizontal" method="POST" action="{{ route('vehicle.store') }}">
              <fieldset>
                <legend>New Vehicle</legend>
                {{ csrf_field() }}

                <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                @include('partials.horiz-input', [
                  'name' => 'year',
                  'label' => 'Year',
                  'pattern' => '[0-9]{4}',
                  'required' => true,
                  'value' => $data['year'] ?? ''
                ])

                @include('partials.horiz-select', [
                  'name' => 'vehicle_type_id',
                  'label' => 'Vehicle Type',
                  'options' => $types,
                  'optionValue' => 'id',
                  'option' => 'type',
                  'value' => $data['vehicle_type_id'] ?? null,
                ])

                @if(isset($data['vehicle_type_id']))
                @include('partials.horiz-select', [
                  'name' => 'vehicle_make_id',
                  'label' => 'Vehicle Make',
                  'options' => $makes,
                  'optionValue' => 'id',
                  'option' => 'make',
                  'value' => $data['vehicle_make_id'] ?? null,
                ])
                @endif

                @if(isset($data['vehicle_make_id']))
                @include('partials.horiz-select', [
                  'name' => 'vehicle_model_id',
                  'label' => 'Vehicle Model',
                  'options' => $models,
                  'optionValue' => 'id',
                  'option' => 'model',
                  'value' => $data['vehicle_model_id'] ?? null,
                ])
                @endif

              </fieldset>
              <div class="modal-footer">
                <button type="submit" class="btn btn-default" id="btn-create">Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ mix('js/vehicle-create.js') }}"></script>
@endsection
