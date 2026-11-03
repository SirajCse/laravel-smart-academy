@props([
    'label' => null,
    'description' => null,
    'class' => '',
])

<div class="space-y-2 {{ $class }}">
    @isset($label)
        <x-label>{{ $label }}</x-label>
    @endisset
    {{ $slot }}
    @isset($description)
        <p class="text-xs text-muted-foreground">{{ $description }}</p>
    @endisset
</div>
