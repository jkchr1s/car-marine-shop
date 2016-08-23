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
                        @if($emails->count() > 0)
                            @foreach($emails as $email)
                                <div class="btn-group">
                                    <a href="#" data-target="#" class="btn btn-raised dropdown-toggle" data-toggle="dropdown">
                                        <i class="material-icons">email</i>&nbsp;{{$email->email}}
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="mailto:{{$email->email}}">Send Email to {{$email->email}}</a></li>
                                        <li class="divider"></li>
                                        <li><a href="javascript:alert('todo')">Delete</a></li>
                                    </ul>
                                </div><br/>
                            @endforeach
                        @else
                            <p>This customer doesn't have any email addresses.</p>
                        @endif
                        <a href="javascript:showAddEmail()" class="btn btn-default">Add New Email Address</a>

                        <h4>Phone</h4>
                        @if($phones->count() > 0)
                            @foreach($phones as $phone)
                                <div class="btn-group">
                                    <a href="#" data-target="#" class="btn btn-raised dropdown-toggle" data-toggle="dropdown">
                                        <i class="material-icons">phone</i>&nbsp;{{$phone->number}} ({{$phone->phone_type->type}})
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="tel:{{$phone->number}}">Call {{$phone->number}} ({{$phone->phone_type->type}})</a></li>
                                        <li><a href="sms:{{$phone->number}}">Text {{$phone->number}} ({{$phone->phone_type->type}})</a></li>
                                        <li class="divider"></li>
                                        <li><a href="javascript:alert('todo')">Delete</a></li>
                                    </ul>
                                </div><br/>
                            @endforeach
                        @else
                            <p>This customer doesn't have any phone numbers.</p>
                        @endif
                        <a href="javascript:showAddPhone()" class="btn btn-default">Add New Phone Number</a>

                        <h4>Locations</h4>
                        @if(is_array($locations) && count($locations) > 0)
                            @foreach($locations as $location)
                                This is a location
                            @endforeach
                        @else
                            <p>This customer doesn't have any locations.</p>
                        @endif
                        <a href="javascript:alert('todo')" class="btn btn-default">Add New Location</a>
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

    <!-- email modal -->
    <div class="modal" id="add-email">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Add Email Address</h4>
                </div>
                <form method="POST" action="/email">{{ csrf_field() }}
                    <input type="hidden" name="customer_id" value="{{ $customer_id }}">
                    <div class="modal-body">
                        <fieldset>
                            <div class="form-group label-floating">
                                <label for="email" class="control-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required="required">
                                <span class="help-block">Enter the customer's email address.</span>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end email modal -->
    <!-- phone modal -->
    <div class="modal" id="add-phone">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Add Phone Number</h4>
                </div>
                <form method="POST" action="/phone">{{ csrf_field() }}
                    <input type="hidden" name="customer_id" value="{{ $customer_id }}">
                    <div class="modal-body">
                        <fieldset>
                            <div class="form-group">
                                <label for="phoneType">Phone Type</label>
                                <select id="phoneType" class="form-control" name="phone_type_id">
                                    @foreach($phone_types as $type)
                                        <option value="{{$type->id}}">{{$type->type}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group label-floating">
                                <label for="phone" class="control-label">Phone Number</label>
                                <input type="text" class="form-control" id="email" name="phone_number" required="required">
                                <span class="help-block">Enter the customer's phone number.</span>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end phone modal -->

    <script type="text/javascript">
        function showAddEmail() {
            $('#add-email').modal('toggle');
            $('#email').focus();
        }

        function showAddPhone() {
            $('#add-phone').modal('toggle');
            $('#phoneType').focus();
        }
    </script>

@endsection