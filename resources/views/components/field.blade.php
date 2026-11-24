@props(['label', 'for', 'error' => null])

<div {{ $attributes }}>
    <label class="form-label fw-semibold" for="{{ $for }}">{{ $label }}</label>
    {{ $slot }}
    @if ($error)
        <div class="invalid-feedback d-block">{{ $error }}</div>
    @endif
</div>
