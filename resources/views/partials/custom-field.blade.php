@php
    $value = $value ?? null;
    $required = $field->is_required ? 'required' : '';
@endphp

<div class="form-group custom-field-{{ $field->type }}">
    <label>{{ __($field->label) }} @if($field->is_required)<span class="text-red">*</span>@endif</label>

    @switch($field->type)
        @case('text')
            <input type="text" name="custom_field[{{ $field->id }}]" class="form-control" value="{{ old("custom_field.{$field->id}", $value) }}" {{ $required }}>
            @break

        @case('textarea')
            <textarea name="custom_field[{{ $field->id }}]" class="form-control" rows="3" {{ $required }}>{{ old("custom_field.{$field->id}", $value) }}</textarea>
            @break

        @case('number')
            <input type="number" name="custom_field[{{ $field->id }}]" class="form-control" value="{{ old("custom_field.{$field->id}", $value) }}" {{ $required }}>
            @break

        @case('date')
            <input type="text" name="custom_field[{{ $field->id }}]" class="form-control datepicker" value="{{ old("custom_field.{$field->id}", $value) }}" {{ $required }}>
            @break

        @case('email')
            <input type="email" name="custom_field[{{ $field->id }}]" class="form-control" value="{{ old("custom_field.{$field->id}", $value) }}" {{ $required }}>
            @break

        @case('select')
            <select name="custom_field[{{ $field->id }}]" class="form-control select2" {{ $required }}>
                <option value="">{{ __('Select') }}</option>
                @foreach(json_decode($field->options ?? '[]', true) as $option)
                    <option value="{{ $option }}" @if(old("custom_field.{$field->id}", $value) === $option) selected @endif>{{ $option }}</option>
                @endforeach
            </select>
            @break

        @case('checkbox')
            @foreach(json_decode($field->options ?? '[]', true) as $option)
                <label class="checkbox-inline">
                    <input type="checkbox" name="custom_field[{{ $field->id }}][]" value="{{ $option }}" @if(in_array($option, (array) ($value ?? []))) checked @endif> {{ $option }}
                </label>
            @endforeach
            @break

        @case('radio')
            @foreach(json_decode($field->options ?? '[]', true) as $option)
                <label class="radio-inline">
                    <input type="radio" name="custom_field[{{ $field->id }}]" value="{{ $option }}" @if(old("custom_field.{$field->id}", $value) === $option) checked @endif> {{ $option }}
                </label>
            @endforeach
            @break

        @case('file')
            <input type="file" name="custom_field[{{ $field->id }}]" class="form-control" {{ $required }}>
            @if($value)
                <a href="{{ fileUrl($value) }}" target="_blank" class="btn btn-xs btn-info" style="margin-top: 5px;">View File</a>
            @endif
            @break

        @default
            <input type="text" name="custom_field[{{ $field->id }}]" class="form-control" value="{{ old("custom_field.{$field->id}", $value) }}" {{ $required }}>
    @endswitch

    @error("custom_field.{$field->id}")
        <span class="help-block text-red">{{ $message }}</span>
    @enderror
</div>
