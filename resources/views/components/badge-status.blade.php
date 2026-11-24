@props(['status'])

@php
    $labels = [
        'draft' => 'Draf',
        'pending' => 'Menunggu verifikasi',
        'active' => 'Aktif',
        'rejected' => 'Ditolak',
        'closed' => 'Ditutup',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'status-badge status-badge--'.$status]) }}>{{ $labels[$status] ?? $status }}</span>
