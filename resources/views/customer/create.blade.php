@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-body">
            <form class="form-horizontal">
              <fieldset>
                <legend>New Customer</legend>
                <div class="form-group">
                  <label for="inputFirstName" class="col-md-2 control-label">First Name</label>

                  <div class="col-md-10">
                    <input type="text" class="form-control" id="inputFirstName" placeholder="First Name">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputLastName" class="col-md-2 control-label">Last Name</label>

                  <div class="col-md-10">
                    <input type="text" class="form-control" id="inputLastName" placeholder="Last Name">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputCompany" class="col-md-2 control-label">Company</label>

                  <div class="col-md-10">
                    <input type="text" class="form-control" id="inputCompany" placeholder="Company">
                  </div>
                </div>
              </fieldset>
              <div class="modal-footer">
                <button type="submit" class="btn btn-default" data-dismiss="modal">Next</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection