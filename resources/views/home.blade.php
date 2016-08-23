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
                    Click or touch a card below to get started.
                </div>
            </div>
        </div>
    </div>

    <div class="row selectable" onclick="window.location='/customer';">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="list-group">
                    <div class="list-group-item">
                        <div class="row-action-primary">
                            <i class="material-icons">supervisor_account</i>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">All Customers</h4>

                            <p class="list-group-item-text">View a list of all current customers</p>
                        </div>
                    </div>
                    <div class="list-group-separator"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row selectable" onclick="window.location='/vehicle_type';">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="list-group">
                    <div class="list-group-item">
                        <div class="row-action-primary">
                            <i class="material-icons">rv_hookup</i>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">Vehicle Types</h4>

                            <p class="list-group-item-text">Manage types of vehicles.</p>
                        </div>
                    </div>
                    <div class="list-group-separator"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row selectable" onclick="window.location='/vehicle_make';">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="list-group">
                    <div class="list-group-item">
                        <div class="row-action-primary">
                            <i class="material-icons">public</i>
                        </div>
                        <div class="row-content">
                            <h4 class="list-group-item-heading">Vehicle Makes</h4>

                            <p class="list-group-item-text">Manage makes of vehicles.</p>
                        </div>
                    </div>
                    <div class="list-group-separator"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
