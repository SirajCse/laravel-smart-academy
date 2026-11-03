@props([
    'variant' => 'default',  // default | secondary | destructive | outline | success | warning | info
    'class'   => '',
])

@php
    $variants = [
        'default'     => 'border-transparent bg-primary text-primary-foreground',
        'secondary'   => 'border-transparent bg-secondary text-secondary-foreground',
        'destructive' => 'border-transparent bg-destructive text-destructive-foreground',
        'outline'     => 'text-foreground',
        'success'     => 'border-transparent bg-success text-white',
        'warning'     => 'border-transparent bg-warning text-white',
        'info'        => 'border-transparent bg-info text-white',
    ];
    $finalClass = 'inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors ' . ($variants[$variant] ?? $variants['default']) . ' ' . $class;
@endphp

<span {{ $attributes->merge(['class' => $finalClass]) }}>
    {{ $slot }}
</span>
