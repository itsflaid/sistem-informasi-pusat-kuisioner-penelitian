@props(['label', 'value', 'icon' => 'bar-chart'])

<div {{ $attributes->merge(['class' => 'card border-0 bg-mist h-100']) }}>
    <div class="card-body p-4">
        <x-chip-icon :icon="$icon" class="mb-4" />
        <div class="display-6 fw-bold text-forest">{{ $value }}</div>
        <div class="text-muted">{{ $label }}</div>
    </div>
</div>
