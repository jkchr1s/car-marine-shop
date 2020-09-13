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
                                        <li><a href="javascript:showDeleteConfirmation('email', {{$email->id}}, '{{str_replace("'", '&#39;', $email->email)}}')">Delete</a></li>
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
                                        <li><a href="javascript:showDeleteConfirmation('phone', {{$phone->id}}, '{{str_replace("'", '&#39;', $phone->number)}}')">Delete</a></li>
                                    </ul>
                                </div><br/>
                            @endforeach
                        @else
                            <p>This customer doesn't have any phone numbers.</p>
                        @endif
                        <a href="javascript:showAddPhone()" class="btn btn-default">Add New Phone Number</a>

                        <h4>Locations</h4>
                        @if($locations->count() > 0)
                            @foreach($locations as $location)
                                <div class="panel">
                                    <div class="panel-body">
                                        <h4>{{$location->location_type->type}}</h4>
                                        <p>
                                            @if(!empty($location->address1))
                                                {{$location->address1}}<br/>
                                            @endif
                                            @if(!empty($location->address2))
                                                {{$location->address2}}<br/>
                                            @endif
                                            @if(!empty($location->city))
                                                {{$location->city}},
                                            @endif
                                            @if(!empty($location->state))
                                                {{$location->state}}
                                            @endif
                                            @if(!empty($location->zip))
                                                {{$location->zip}}
                                            @endif
                                        </p>
                                        <p>
                                            <a href="https://www.google.com/maps/place/{{urlencode(!empty($location->address1) ? $location->address1.',' : '')}}{{urlencode(!empty($location->address2) ? $location->address2.',' : '')}}{{urlencode(!empty($location->city) ? $location->city.',' : '')}}{{urlencode(!empty($location->state) ? $location->state.',' : '')}}{{urlencode(!empty($location->zip) ? $location->zip.',' : '')}}">Show in Maps</a>
                                            | <a href="#">Modify</a>
                                            | <a href="javascript:showDeleteConfirmation('location', {{$location->id}}, '{{str_replace("'", '&#39;', $location->address1)}}')">Delete</a>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>This customer doesn't have any locations.</p>
                        @endif
                        <a href="javascript:showAddLocation()" class="btn btn-default">Add New Location</a>
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
                        <a href="{{ route('vehicle.create') }}?customer_id={{ $customer_id }}" class="btn btn-default">Add New Vehicle</a>
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
    <!-- location modal -->
    <div class="modal" id="add-location">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Add Location</h4>
                </div>
                <form method="POST" action="/location">{{ csrf_field() }}
                    <input type="hidden" name="customer_id" value="{{ $customer_id }}">
                    <div class="modal-body">
                        <fieldset>
                            <p>What type of location is this?</p>
                            <div class="form-group">
                                <label for="locationType">Location Type</label>
                                <select id="locationType" class="form-control" name="location_type_id">
                                    @foreach($location_types as $type)
                                        <option value="{{$type->id}}">{{$type->type}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <p><br/>What is the address?</p>

                            <div class="form-group label-floating">
                                <label for="address1" class="control-label">Address Line 1</label>
                                <input type="text" class="form-control" id="address1" name="address_1" required="required">
                                <span class="help-block">Enter the first line of the customer's address.</span>
                            </div>

                            <div class="form-group label-floating">
                                <label for="address2" class="control-label">Address Line 2</label>
                                <input type="text" class="form-control" id="address2" name="address_2">
                                <span class="help-block">Enter the second line of the customer's address.</span>
                            </div>

                            <div class="form-group label-floating">
                                <label for="city" class="control-label">City</label>
                                <input type="text" class="form-control" id="city" name="city">
                                <span class="help-block">Enter the city of the customer's address.</span>
                            </div>

                            <div class="form-group label-floating">
                                <label for="state" class="control-label">State</label>
                                <input type="text" class="form-control" id="state" name="state">
                                <span class="help-block">Enter the state of the customer's address.</span>
                            </div>

                            <div class="form-group label-floating">
                                <label for="zip" class="control-label">Zip Code</label>
                                <input type="text" class="form-control" id="zip" name="zip">
                                <span class="help-block">Enter the zip code of the customer's address.</span>
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
    <!-- end location modal -->
    <!-- confirmation modal -->
    <div class="modal" id="delete-confirmation">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Delete Item</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this <span id="delete-type"></span>?</p>
                    <p id="delete-text"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="delete-confirm">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end confirmation modal -->

    <script type="text/javascript">
        function showAddEmail() {
            $('#add-email').modal('toggle');
            $('#email').focus();
        }

        function showAddPhone() {
            $('#add-phone').modal('toggle');
            $('#phoneType').focus();
        }

        function showAddLocation() {
            $('#add-location').modal('toggle');
            $('#locationType').focus();
        }

        function showDeleteConfirmation(type, id, text) {
            $('#delete-text').html(text);
            $('#delete-type').html(type);
            $('#delete-confim').unbind();
            $('#delete-confirm').on('click', function(e) {
                $('#delete-confirmation').modal('toggle');
                $.ajax({
                    url: '/' + encodeURIComponent(type) + '/' + encodeURIComponent(id),
                    type: 'DELETE',
                    success: function(result) {
                        location.reload();
                    },
                    error: function(err) {
                        alert('There was an error deleting this item.');
                    }
                });
            });
            $('#delete-confirmation').modal('toggle');
        }
    </script>

@endsection