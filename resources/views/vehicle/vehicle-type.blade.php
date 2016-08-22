@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        {{ count($types) }} vehicle type{{ count($types) === 1 ? '' : 's' }} found.
                    </div>
                </div>
            </div>
        </div>
        @foreach($types as $type)
        <div class="row selectable" onclick="modifyItem({{ $type->id }}, '{{ str_replace("'", "&#39;", $type->type) }}');">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="row-action-primary">
                                <i class="material-icons">{{ isset($type->icon) && !empty($type->icon) ? $type->icon : 'assignment' }}</i>
                            </div>
                            <div class="row-content">
                                <h4 class="list-group-item-heading">{{ $type->type }}</h4>

                                <p class="list-group-item-text">Vehicle Type</p>
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
                console.log('/vehicle_type/' + id);
                $.ajax({
                    url: '/vehicle_type/'+id,
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
                    url: '/vehicle_type/' + id,
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
            $('#inputType').focus();
        }
    </script>
    <!-- create modal -->
    <div class="modal" id="add-item">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Add Vehicle Type</h4>
                </div>
                <form method="POST" action="/vehicle_type">{{ csrf_field() }}
                    <div class="modal-body">
                        <fieldset>
                            <div class="form-group">
                                <label for="inputType" class="col-md-2 control-label">Type</label>

                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="inputType" placeholder="Vehicle Type" name="type">
                                </div>
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
                        <h4 class="modal-title">Modify Vehicle Type</h4>
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