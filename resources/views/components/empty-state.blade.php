@props(['title' => 'Belum ada data.', 'message' => null])

<div {{ $attributes->merge(['class' => 'empty-state']) }}>
    <x-chip-icon icon="inbox" class="mb-3" />
    <h2 class="h4">{{ $title }}</h2>
    @if ($message)
        <p class="text-muted mb-3">{{ $message }}</p>
    @endif
    {{ $slot }}
</div>
