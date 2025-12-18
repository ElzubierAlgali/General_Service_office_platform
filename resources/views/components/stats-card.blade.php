@props([
    'variant' => 'primary',
    'icon' => 'fas fa-chart-line',
    'number' => '0',
    'label' => 'Label',
    'change' => null,
    'changeType' => 'positive'
])

@php
$variants = [
    'primary' => 'stats-card-primary',
    'success' => 'stats-card-success',
    'info' => 'stats-card-info',
    'warning' => 'stats-card-warning',
    'danger' => 'stats-card-danger',
    'dark' => 'stats-card-dark',
];
$variantClass = $variants[$variant] ?? $variants['primary'];
@endphp

<div {{ $attributes->merge(['class' => "stats-card {$variantClass}"]) }}>
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <div class="stats-number">{{ $number }}</div>
            <div class="stats-label">{{ $label }}</div>
        </div>
        <div class="stats-icon">
            <i class="{{ $icon }}"></i>
        </div>
    </div>
    @if($change)
    <div class="stats-change {{ $changeType }}">
        <i class="fas fa-{{ $changeType === 'positive' ? 'chart-line' : 'chart-line-down' }}"></i>
        <span>{{ $change }}</span>
    </div>
    @endif
    {{ $slot }}
</div>

