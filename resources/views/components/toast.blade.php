@props(['message', 'type' => 'success'])

<div {{ $attributes->merge(['class' => 'alert alert-'.$type.' d-flex align-items-center gap-2']) }} role="alert">
    <i class="bi bi-check-circle"></i>
    <span>{{ $message }}</span>
</div>
