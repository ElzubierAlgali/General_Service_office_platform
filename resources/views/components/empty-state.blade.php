@props([
    'icon' => 'fas fa-inbox',
    'title' => 'لا توجد بيانات',
    'description' => 'لا توجد بيانات لعرضها حالياً.',
    'actionUrl' => null,
    'actionLabel' => null,
    'actionIcon' => 'fas fa-plus'
])

<div {{ $attributes->merge(['class' => 'empty-state']) }}>
    <div class="empty-state-icon">
        <i class="{{ $icon }}"></i>
    </div>
    <h5 class="empty-state-title">{{ $title }}</h5>
    <p class="empty-state-text">{{ $description }}</p>
    @if($actionUrl && $actionLabel)
    <a href="{{ $actionUrl }}" class="btn btn-primary">
        <i class="{{ $actionIcon }} me-1"></i> {{ $actionLabel }}
    </a>
    @endif
    {{ $slot }}
</div>

