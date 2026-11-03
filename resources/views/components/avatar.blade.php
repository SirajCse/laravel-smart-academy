@props([
    'src' => null,
    'alt' => 'User',
    'size' => 'default',  // sm | default | lg | xl
    'fallback' => null,    // initials
    'class' => '',
])

@php
    $sizes = [
        'sm' => 'h-8 w-8 text-xs',
        'default' => 'h-10 w-10 text-sm',
        'lg' => 'h-12 w-12 text-base',
        'xl' => 'h-16 w-16 text-lg',
    ];
    $finalClass = 'relative flex shrink-0 overflow-hidden rounded-full bg-muted items-center justify-center font-medium text-muted-foreground ' . ($sizes[$size] ?? $sizes['default']) . ' ' . $class;
@endphp

<span class="{{ $finalClass }}">
    @if ($src)
        <img src="{{ $src }}" alt="{{ $alt }}" class="aspect-square h-full w-full object-cover" />
    @elseif($fallback)
        <span>{{ $fallback }}</span>
    @else
        <i class="fa fa-user"></i>
    @endif
</span>
