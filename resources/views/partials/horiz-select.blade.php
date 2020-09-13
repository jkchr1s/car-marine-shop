<div class="form-group">
    <label for="{{ $name }}" class="col-md-2 control-label">{{ $label }}</label>
    <div class="col-md-10">
    <select id="{{ $name }}" class="form-control" name="{{ $name }}"{!! empty($onChange) ? '' : ' onchange=' . json_encode($onChange)  !!}>
        @foreach($options as $item)
        <option value="{{ $item->{$optionValue} }}"{{ isset($value) && !empty($value) && strval($value) === strval($item->{$optionValue}) ? ' selected' : '' }}>{{ $item->{$option} }}</option>
        @endforeach
    </select>
    </div>
</div>