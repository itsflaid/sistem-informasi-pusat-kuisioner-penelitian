@props(['icon'])

<span {{ $attributes->merge(['class' => 'chip-icon']) }}><i class="bi bi-{{ $icon }}"></i></span>
