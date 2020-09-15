@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-body">
            {{ $customers->count() }} customer{{ $customers->count() === 1 ? '' : 's' }} found.
          </div>
        </div>
      </div>
    </div>
    @foreach($customers as $customer)
      <div class="row selectable" onclick="window.location='{{ route('customer.show', $customer->id) }}';">
        <div class="col-md-10 col-md-offset-1">
          <div class="panel panel-default">
            <div class="list-group">
              <div class="list-group-item">
                <div class="row-action-primary">
                  @if(strlen($customer->first_name) > 0 || strlen($customer->last_name) > 0)
                    <i class="material-icons">person</i>
                  @else
                    <i class="material-icons">business</i>
                  @endif
                </div>
                <div class="row-content">
                  <h4 class="list-group-item-heading">
                    @if(strlen($customer->first_name) > 0 || strlen($customer->last_name) > 0)
                      {{ $customer->last_name }}, {{ $customer->first_name }}
                    @else
                      {{ $customer->company }}
                    @endif
                  </h4>

                  <p class="list-group-item-text">Customer since {{ $customer->created_at }}</p>
                </div>
              </div>
              <div class="list-group-separator"></div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <!-- js functions -->
  <script type="text/javascript">
    function modifyItem(id, value) {
      $('#modifyType').val(value);
      $('#modify-item').modal('toggle');
      $('#modifyType').focus();

      $('#modify-delete').unbind('click');
      $('#modify-delete').on('click', function(e) {
        e.preventDefault();
        console.log('/vehicle_make/' + id);
        $.ajax({
          url: '/vehicle_make/'+id,
          type: 'DELETE',
          success: function(result) {
            location.reload();
          },
          error: function(err) {
            alert(JSON.stringify(err));
          }
        });
      });

      $('#modify-form').unbind('submit');
      $('#modify-form').on('submit', function(e) {
        e.preventDefault();
        $('#modify-save').attr('disabled', 'disabled');
        $('#modify-save').html('Saving');
        $.ajax({
          url: '/vehicle_make/' + id,
          type: 'PUT',
          data: $('#modify-form').serialize(),
          success: function(result) {
            if (result.modified) {
              location.reload();
            } else {
              alert('There was a problem saving your changes.');
            }
          },
          error: function(err) {
            alert(JSON.stringify(err));
          }
        });
      });
    }
    function addItem() {
      $('#add-item').modal('toggle');
      $('#inputMake').focus();
    }
  </script>
  <!-- create modal -->
  <div class="modal" id="add-item">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Add New Customer</h4>
        </div>
        <form method="POST" action="{{ route('customer.store') }}">{{ csrf_field() }}
          <div class="modal-body">
            <fieldset>
              <div class="form-group">
                <label for="customerType">Customer Type</label>
                <select id="customerType" class="form-control" name="customer_type_id">
                  @foreach($types as $type)
                    <option value="{{$type->id}}">{{$type->type}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group label-floating">
                <label for="firstName" class="control-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="first_name" required>
                <span class="help-block">Enter the customer's first name.</span>
              </div>
              <div class="form-group label-floating">
                <label for="lastName" class="control-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="last_name" required>
                <span class="help-block">Enter the customer's last name.</span>
              </div>
              <div class="form-group label-floating">
                <label for="company" class="control-label">Company Name</label>
                <input type="text" class="form-control" id="company" name="company">
                <span class="help-block">Enter the customer's company name.</span>
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
  <!-- modify modal -->
  <div class="modal" id="modify-item">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="modify-form">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Modify Vehicle Make</h4>
          </div>
          <div class="modal-body">
            <fieldset>
              <div class="form-group">
                <label for="inputType" class="col-md-2 control-label">Type</label>

                <div class="col-md-10">
                  <input type="text" class="form-control" id="modifyType" placeholder="Vehicle Type" name="type">
                </div>
              </div>
            </fieldset>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" id="modify-delete">Delete</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="modify-save">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="floating-action-button">
    <span onclick="addItem();" class="btn btn-warning btn-fab"><i class="material-icons">add</i></span>
  </div>
@endsection
