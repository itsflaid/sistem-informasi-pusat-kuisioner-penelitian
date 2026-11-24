@props(['title', 'description' => null])

<div {{ $attributes->merge(['class' => 'd-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4']) }}>
    <div>
        <h1 class="h2 mb-1">{{ $title }}</h1>
        @if ($description)
            <p class="text-muted mb-0">{{ $description }}</p>
        @endif
    </div>
    @isset($actions)
        <div>{{ $actions }}</div>
    @endisset
</div>
