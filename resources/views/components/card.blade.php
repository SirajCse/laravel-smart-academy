@props(['class' => '', 'as' => 'div'])
@php
    $classes = 'rounded-lg border bg-card text-card-foreground shadow-sm ' . $class;
@endphp
<{{ $as }} {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</{{ $as }}>
