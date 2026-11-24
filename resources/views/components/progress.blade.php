@props(['value' => 0, 'label' => null])

<div {{ $attributes }}>
    @if ($label)
        <div class="d-flex justify-content-between small mb-2"><span>{{ $label }}</span><span>{{ $value }}%</span></div>
    @endif
    <div class="progress" role="progressbar" aria-valuenow="{{ $value }}" aria-valuemin="0" aria-valuemax="100">
        <div class="progress-bar" style="width: {{ $value }}%"></div>
    </div>
</div>
