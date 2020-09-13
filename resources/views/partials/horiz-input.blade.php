<div class="form-group">
    <label for="{{ $name }}" class="col-md-2 control-label">{{ $label }}</label>
    <div class="col-md-10">
        <input type="{{ $type ?? 'text' }}"
               class="form-control"
               id="{{ $name }}"
               name="{{ $name }}"
               @if($required)
               required 
               @endif
               @if($pattern && !empty($pattern))
               pattern="{{ $pattern }}"
               @endif
               @if($value)
               value="{{ $value }}"
               @endif
               placeholder="{{ $placeholder ?? $label }}">
    </div>
</div>