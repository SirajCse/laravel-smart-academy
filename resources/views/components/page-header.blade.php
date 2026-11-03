@props([
    'title' => null,
    'description' => null,
    'actions' => null,    // slot for action buttons
    'class' => '',
])

<div class="mb-6 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
    <div>
        @isset($title)
            <h1 class="text-2xl font-semibold tracking-tight">{{ $title }}</h1>
        @endisset
        @isset($description)
            <p class="text-sm text-muted-foreground">{{ $description }}</p>
        @endisset
    </div>
    @isset($actions)
        <div class="flex items-center gap-2">
            {{ $actions }}
        </div>
    @endisset
</div>
