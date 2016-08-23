@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">My Dashboard</h3>
                </div>
                <div class="panel-body">
                    My Available Actions
                </div>

                <div class="list-group">
                    <div class="list-group-item" onclick="window.href='/customer';">
                        <div class="row-action-primary">
                            <i class="material-icons">face</i>
                        </div>
                        <div class="row-content">
                            <div class="least-content">{{ $customerCount }} customer{{ $customerCount !== 1 ? 's' : '' }}</div>
                            <h4 class="list-group-item-heading">Customers</h4>

                            <p class="list-group-item-text">Manage customers</p>
                        </div>
                    </div>
                    <div class="list-group-separator"></div>
                    <div class="list-group-item">
                        <div class="row-action-primary">
                            <i class="material-icons">directions_car</i>
                        </div>
                        <div class="row-content">
<!--                            <div class="least-content">10m</div>-->
                            <h4 class="list-group-item-heading">Vehicles</h4>

                            <p class="list-group-item-text">Manage vehicles</p>
                        </div>
                    </div>
                    <div class="list-group-separator"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
