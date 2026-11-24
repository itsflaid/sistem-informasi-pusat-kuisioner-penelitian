@props(['href' => null, 'variant' => 'primary', 'type' => 'button'])

@if ($href)
    <a {{ $attributes->merge(['class' => 'btn btn-'.$variant]) }} href="{{ $href }}">{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['class' => 'btn btn-'.$variant]) }} type="{{ $type }}">{{ $slot }}</button>
@endif
