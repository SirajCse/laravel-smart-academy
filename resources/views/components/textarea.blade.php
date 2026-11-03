@props([
    'name' => null,
    'value' => null,
    'rows' => 3,
    'placeholder' => '',
    'required' => false,
    'class' => '',
])

@php
    $finalClass = 'flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 ' . $class;
@endphp

<textarea
    name="{{ $name }}"
    id="{{ $name }}"
    rows="{{ $rows }}"
    placeholder="{{ $placeholder }}"
    @if($required) required @endif
    {{ $attributes->merge(['class' => $finalClass]) }}
>{{ old($name, $value) }}</textarea>
