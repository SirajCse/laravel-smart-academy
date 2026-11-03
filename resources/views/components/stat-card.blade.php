@props([
    'title' => null,
    'value' => null,
    'icon' => null,
    'color' => 'primary',   // primary | success | info | warning | destructive
    'trend' => null,        // ['value' => '12%', 'direction' => 'up|down']
    'href' => null,
])

@php
    $colors = [
        'primary'    => 'bg-primary/10 text-primary',
        'success'    => 'bg-success/10 text-success',
        'info'       => 'bg-info/10 text-info',
        'warning'    => 'bg-warning/10 text-warning',
        'destructive'=> 'bg-destructive/10 text-destructive',
    ];
@endphp

<x-card :class="'overflow-hidden ' . ($attributes->get('class') ?? '')">
    <div class="p-6">
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-sm font-medium text-muted-foreground">{{ $title }}</p>
                <p class="text-2xl font-semibold">{{ $value }}</p>
            </div>
            @isset($icon)
                <div class="flex h-12 w-12 items-center justify-center rounded-lg {{ $colors[$color] ?? $colors['primary'] }}">
                    <i class="fa {{ $icon }} text-xl"></i>
                </div>
            @endisset
        </div>
        @isset($trend)
            <div class="mt-3 flex items-center gap-1 text-xs">
                @if(($trend['direction'] ?? 'up') === 'up')
                    <i class="fa fa-arrow-up text-success"></i>
                    <span class="font-medium text-success">{{ $trend['value'] ?? '' }}</span>
                @else
                    <i class="fa fa-arrow-down text-destructive"></i>
                    <span class="font-medium text-destructive">{{ $trend['value'] ?? '' }}</span>
                @endif
                <span class="text-muted-foreground">{{ $trend['label'] ?? 'vs last month' }}</span>
            </div>
        @endisset
    </div>
</x-card>
