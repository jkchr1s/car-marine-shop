@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>{{ $models->count() }} vehicle model{{ $models->count() === 1 ? '' : 's' }} found.</p>

                        <div class="btn-group">
                            <a href="#" data-target="#" class="btn btn-raised dropdown-toggle" data-toggle="dropdown">
                                {{ isset($filters['vehicle_type_id']) ? 'Only show ' . $types->find($filters['vehicle_type_id'])->type : 'Show All Types' }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach($types as $type)
                                    <li><a href="{{ route('vehicle_model.index') }}?vehicle_type_id={{$type->id}}">Only show {{$type->type}}</a></li>
                                @endforeach
                                <li><a href="{{ route('vehicle_model.index') }}">Show All</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" style="margin-left: 20px;">
                            <a href="#" data-target="#" class="btn btn-raised dropdown-toggle" data-toggle="dropdown">
                                {{ isset($filters['vehicle_make_id']) ? 'Only show ' . $makes->find($filters['vehicle_make_id'])->make : 'Show All Makes' }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach($makes as $make)
                                    <li><a href="{{ route('vehicle_model.index') }}?vehicle_make_id={{ $make->id }}&vehicle_type_id={{ $filters['vehicle_type_id'] ?? '' }}">Only show {{ $make->make }}</a></li>
                                @endforeach
                                <li><a href="{{ route('vehicle_model.index') }}?vehicle_type_id={{ $filters['vehicle_type_id'] ?? '' }}">Show All</a></li>
                            </ul>
                        </div>

                        @if(!isset($filters['vehicle_type_id']) || !isset($filters['vehicle_make_id']))
                        <p><br><strong>To add a new model, you must select a make and model.</strong></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @foreach($models as $model)
        <div class="row selectable"
             data-open-modal="modify-vehicle-model"
             data-context="<?= htmlspecialchars(json_encode($model->only('id', 'model'))) ?>"
             data-method="PUT"
             data-action="{{ route('vehicle_model.update', ['vehicle_model' => $model->id]) }}"
             data-delete="{{ route('vehicle_model.destroy', ['vehicle_model' => $model->id]) }}">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="row-action-primary">
                                <i class="material-icons">{{ $model->type->icon }}</i>
                            </div>
                            <div class="row-content">
                                <h4 class="list-group-item-heading">{{ $model->model }}</h4>

                                <p class="list-group-item-text">{{ $model->make->make }} {{ $model->type->type }}</p>
                            </div>
                        </div>
                        <div class="list-group-separator"></div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @if(isset($filters['vehicle_type_id']) && isset($filters['vehicle_make_id']))
    <!-- create modal -->
    @include('partials.quick-action-modal', [
        'title' => 'Add Vehicle Model',
        'id' => 'add-vehicle-model',
        'method' => 'POST',
        'action' => route('vehicle_model.store'),
        'primaryButtonLabel' => 'Create',
        'fields' => [
            [
                'type' => 'hidden',
                'name' => 'vehicle_type_id',
                'value' => $filters['vehicle_type_id']
            ],
            [
                'type' => 'hidden',
                'name' => 'vehicle_make_id',
                'value' => $filters['vehicle_make_id']
            ],
            [
                'type' => 'block',
                'label' => 'Vehicle Type',
                'body' => $types->find($filters['vehicle_type_id'])->type
            ],
            [
                'type' => 'block',
                'label' => 'Vehicle Make',
                'body' => $makes->find($filters['vehicle_make_id'])->make
            ],
            [
                'type' => 'text',
                'label' => 'Model',
                'name' => 'model',
                'id' => 'new_vehicle_make',
                'required' => true,
                'placeholder' => ''
            ]
        ]
    ])
    @endif

    @if($models->count())
    @include('partials.quick-action-modal', [
        'title' => 'Modify',
        'id' => 'modify-vehicle-model',
        'method' => 'PUT',
        'showDelete' => true,
        'fields' => [
            [
                'type' => 'text',
                'label' => 'Model',
                'name' => 'model',
                'id' => 'new_vehicle_make',
                'required' => true,
                'placeholder' => ''
            ]  
        ]
    ])
    @endif
@endsection