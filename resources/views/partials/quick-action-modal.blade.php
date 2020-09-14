{{-- This is a re-usable add modal. You can disable the floating action button by specifying 'hideFab' => true --}}
<div class="modal" id="{{ $id ?? 'add-modal' }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">{{ $title ?? 'Add Item' }}</h4>
            </div>
            <form method="{{ $method ?? 'POST' }}" action="{{ $action ?? '' }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <fieldset>
                        @foreach($fields as $field)
                            @if($field['type'] === 'dropdown')
                                <div class="form-group">
                                    <label for="{{ $field['id'] ?? $field['name'] }}">{{ $field['label'] }}</label>
                                    <select id="{{ $field['id'] ?? $field['name'] }}" class="form-control" name="{{ $field['name'] }}">
                                    @foreach($field['options'] as $item)
                                    <option value="{{ $item->{$field['optionValue']} }}"{{ isset($field['value']) && !empty($field['value']) && strval($field['value']) === strval($item->{$field['optionValue']}) ? ' selected="selected"' : '' }}>{{ $item->{$field['option']} }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            @elseif($field['type'] === 'text')
                                <div class="form-group label-floating">
                                    <label for="{{ $field['id'] ?? $field['name'] }}" class="control-label">{{ $field['label'] }}</label>
                                    <input type="{{ $field['type'] ?? 'text' }}"
                                           class="form-control"
                                           id="{{ $field['id'] ?? $field['name'] }}"
                                           name="{{ $field['name'] }}"
                                           @if(isset($field['required']) && $field['required'])
                                           required 
                                           @endif
                                           @if(isset($field['pattern']) && !empty($field['pattern']))
                                           pattern="{{ $field['pattern'] }}"
                                           @endif
                                           @if(isset($field['value']) && !empty($field['value']))
                                           value="{{ $field['value'] }}"
                                           @endif
                                           placeholder="{{ $field['placeholder'] ?? $field['label'] }}">
                                    @if(isset($field['helpText']))
                                    <span class="help-block">{{ $field['helpText'] }}</span>
                                    @endif
                                </div>
                            @elseif($field['type'] === 'block')
                                <div class="form-group">
                                    @if(isset($field['label']))
                                    <label>{{ $field['label'] }}</label>
                                    @endif
                                    <div>{{ $field['body'] }}</div>
                                </div>
                            @elseif($field['type'] === 'hidden')
                                <input type="hidden" name="{{ $field['name'] }}" value="{{ $field['value'] }}">
                            @endif
                        @endforeach
                    </fieldset>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    @if(isset($showDelete) && $showDelete)
                    <button type="button" class="btn btn-default" data-delete="true">Delete</button>
                    @endif
                    <button type="submit" class="btn btn-primary">{{ $primaryButtonLabel ?? 'Save' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@if((!isset($hideFab) || !$hideFab) && $method === 'POST')
<div class="floating-action-button">
    <span data-open-modal="{{ $id ?? 'add-modal' }}" class="btn btn-warning btn-fab"><i class="material-icons">add</i></span>
</div>
@endif