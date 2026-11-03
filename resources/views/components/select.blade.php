@props([
    'name' => null,
    'value' => null,
    'options' => [],       // ['value' => 'Label'] OR [['value' => .., 'label' => ..], ...]
    'placeholder' => 'Select...',
    'required' => false,
    'class' => '',
])

@php
    $finalClass = 'flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 ' . $class;
    $currentValue = old($name, $value);
@endphp

<select
    name="{{ $name }}"
    id="{{ $name }}"
    @if($required) required @endif
    {{ $attributes->merge(['class' => $finalClass]) }}
>
    @if ($placeholder)
        <option value="">{{ __($placeholder) }}</option>
    @endif
    @foreach ($options as $key => $opt)
        @php
            if (is_array($opt)) {
                $optValue = $opt['value'] ?? null;
                $optLabel = $opt['label'] ?? '';
            } else {
                $optValue = $key;
                $optLabel = $opt;
            }
        @endphp
        <option value="{{ $optValue }}" @if((string) $currentValue === (string) $optValue) selected @endif>
            {{ $optLabel }}
        </option>
    @endforeach
</select>
