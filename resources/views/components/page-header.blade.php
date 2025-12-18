@props([
    'title' => '',
    'icon' => 'fas fa-home',
    'breadcrumbs' => []
])

<div {{ $attributes->merge(['class' => 'app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between animate-fadeInDown']) }}>
    <div class="clearfix">
        <h1 class="app-page-title">
            @if($icon)
            <i class="{{ $icon }} text-primary"></i>
            @endif
            {{ $title }}
        </h1>
        @if(count($breadcrumbs) > 0)
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                @foreach($breadcrumbs as $breadcrumb)
                    @if($loop->last)
                        <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['label'] }}</li>
                    @else
                        <li class="breadcrumb-item">
                            <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                        </li>
                    @endif
                @endforeach
            </ol>
        </nav>
        @endif
    </div>
    @if($slot->isNotEmpty())
    <div class="d-flex gap-2">
        {{ $slot }}
    </div>
    @endif
</div>

