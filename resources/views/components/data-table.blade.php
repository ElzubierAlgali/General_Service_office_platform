@props([
    'title' => '',
    'icon' => 'fas fa-list',
    'badge' => null,
    'tableId' => 'dataTable'
])

<div {{ $attributes->merge(['class' => 'card animate-fadeInUp']) }}>
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <h5 class="card-title mb-0">
            @if($icon)
            <i class="{{ $icon }} me-2 text-primary"></i>
            @endif
            {{ $title }}
        </h5>
        <div class="d-flex align-items-center gap-2">
            @if($badge)
            <span class="badge badge-soft-primary">{{ $badge }}</span>
            @endif
            @isset($headerActions)
            {{ $headerActions }}
            @endisset
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="{{ $tableId }}">
                {{ $slot }}
            </table>
        </div>
    </div>
    @isset($footer)
    <div class="card-footer bg-transparent">
        {{ $footer }}
    </div>
    @endisset
</div>

