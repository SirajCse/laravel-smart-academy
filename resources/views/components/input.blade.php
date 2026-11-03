@props([
    'type'  => 'text',
    'name'  => null,
    'value' => null,
    'placeholder' => '',
    'required' => false,
    'class' => '',
    'id'    => null,
])

@php
    $finalClass = 'flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 ' . $class;
    $id = $id ?: $name;
@endphp

<input
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $id }}"
    value="{{ old($name, $value) }}"
    placeholder="{{ $placeholder }}"
    @if($required) required @endif
    {{ $attributes->merge(['class' => $finalClass]) }}
/>
