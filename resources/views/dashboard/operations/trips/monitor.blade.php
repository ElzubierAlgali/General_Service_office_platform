@extends('layouts.master')

@section('title', 'مراقبة الرحلات الحية')

@section('content')
<style>
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
        70% { box-shadow: 0 0 0 15px rgba(40, 167, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
    }
    .trip-card {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    .trip-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .trip-card.status-accepted { border-left-color: #0d6efd; }
    .trip-card.status-en_route { border-left-color: #6f42c1; }
    .trip-card.status-arrived { border-left-color: #fd7e14; }
    .trip-card.status-in_progress { border-left-color: #198754; }
    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-left: 8px;
    }
    .status-dot.active {
        animation: blink 1s infinite;
    }
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }
    .timeline-item {
        position: relative;
        padding-right: 30px;
        padding-bottom: 15px;
        border-right: 2px solid #e9ecef;
    }
    .timeline-item:last-child {
        border-right: none;
        padding-bottom: 0;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        right: -7px;
        top: 3px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #e9ecef;
    }
    .timeline-item.completed::before {
        background: #198754;
    }
    .timeline-item.current::before {
        background: #0d6efd;
        animation: pulse 2s infinite;
    }
    .big-timer {
        font-size: 3rem;
        font-weight: bold;
        font-family: 'Courier New', monospace;
    }
</style>

<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between mb-4">
    <div class="my-auto mb-2">
        <h5 class="page-title fw-semibold fs-18 mb-0">
            <span class="status-dot bg-success active"></span>
            مراقبة الرحلات الحية
        </h5>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('trips.index') }}">إدارة الرحلات</a></li>
                <li class="breadcrumb-item active">المراقبة الحية</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto gap-2">
        <span class="badge bg-dark fs-6 px-3 py-2" id="currentTime">{{ now()->format('H:i:s') }}</span>
        <a href="{{ route('trips.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-list me-1"></i> عرض الكل
        </a>
        <button class="btn btn-success" onclick="location.reload()">
            <i class="fas fa-sync-alt me-1"></i> تحديث
        </button>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mb-4">
    <div class="col-md-2 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100 bg-gradient-primary text-white">
            <div class="card-body text-center py-3">
                <h2 class="mb-0">{{ $todayStats['total'] }}</h2>
                <small>رحلات اليوم</small>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100 bg-gradient-info text-white">
            <div class="card-body text-center py-3">
                <h2 class="mb-0">{{ $todayStats['active'] }}</h2>
                <small>نشطة الآن</small>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100 bg-gradient-warning text-white">
            <div class="card-body text-center py-3">
                <h2 class="mb-0">{{ $todayStats['pending'] }}</h2>
                <small>انتظار التعيين</small>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100 bg-gradient-success text-white">
            <div class="card-body text-center py-3">
                <h2 class="mb-0">{{ $todayStats['completed'] }}</h2>
                <small>مكتملة</small>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100 bg-gradient-danger text-white">
            <div class="card-body text-center py-3">
                <h2 class="mb-0">{{ $todayStats['cancelled'] }}</h2>
                <small>ملغاة</small>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center py-3">
                <h2 class="mb-0 text-success">{{ $drivers->where('status', 'active')->count() }}</h2>
                <small class="text-muted">سائقين متاحين</small>
            </div>
        </div>
    </div>
</div>

<!-- Active Trips Grid -->
@if($activeTrips->count() > 0)
<div class="row" id="activeTripsGrid">
    @foreach($activeTrips as $trip)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card trip-card border-0 shadow-sm h-100 status-{{ $trip->status }}">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-dark">{{ $trip->trip_number }}</span>
                    <span class="badge bg-{{ $trip->status_color }} ms-1">{{ $trip->status_label }}</span>
                </div>
                <span class="status-dot bg-{{ $trip->status_color }} active"></span>
            </div>
            <div class="card-body">
                <!-- Timer -->
                <div class="text-center mb-4">
                    <div class="trip-timer" 
                         data-status="{{ $trip->status }}"
                         data-accepted="{{ $trip->accepted_at?->toISOString() }}"
                         data-enroute="{{ $trip->en_route_at?->toISOString() }}"
                         data-arrived="{{ $trip->arrived_at?->toISOString() }}"
                         data-started="{{ $trip->started_at?->toISOString() }}">
                        <div class="big-timer text-{{ $trip->status_color }} timer-display">00:00:00</div>
                        <small class="text-muted timer-label"></small>
                    </div>
                </div>

                <!-- Client Info -->
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar avatar-md bg-light rounded-circle me-3">
                        <i class="fas fa-user text-primary"></i>
                    </div>
                    <div>
                        <strong>{{ $trip->client_name }}</strong>
                        @if($trip->client_phone)
                        <br><small class="text-muted">{{ $trip->client_phone }}</small>
                        @endif
                    </div>
                </div>

                <!-- Driver Info -->
                @if($trip->driver)
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar avatar-md bg-primary text-white rounded-circle me-3">
                        {{ mb_substr($trip->driver->name_ar ?? $trip->driver->name_en, 0, 1) }}
                    </div>
                    <div>
                        <strong>{{ $trip->driver->name_ar ?? $trip->driver->name_en }}</strong>
                        @if($trip->vehicle)
                        <br><small class="text-muted">{{ $trip->vehicle->plate_number }} - {{ $trip->vehicle->brand }}</small>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Route -->
                <div class="mb-3">
                    <div class="d-flex align-items-start mb-2">
                        <i class="fas fa-circle text-success me-2 mt-1" style="font-size: 8px;"></i>
                        <small>{{ $trip->pickup_location }}</small>
                    </div>
                    <div class="d-flex align-items-start">
                        <i class="fas fa-circle text-danger me-2 mt-1" style="font-size: 8px;"></i>
                        <small>{{ $trip->dropoff_location }}</small>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="mb-3">
                    <div class="timeline-item {{ $trip->accepted_at ? 'completed' : '' }} {{ $trip->status == 'accepted' ? 'current' : '' }}">
                        <small class="text-muted">تم القبول</small>
                        @if($trip->accepted_at)
                        <br><small class="fw-bold">{{ $trip->accepted_at->format('H:i:s') }}</small>
                        @endif
                    </div>
                    <div class="timeline-item {{ $trip->en_route_at ? 'completed' : '' }} {{ $trip->status == 'en_route' ? 'current' : '' }}">
                        <small class="text-muted">في الطريق</small>
                        @if($trip->en_route_at)
                        <br><small class="fw-bold">{{ $trip->en_route_at->format('H:i:s') }}</small>
                        @endif
                    </div>
                    <div class="timeline-item {{ $trip->arrived_at ? 'completed' : '' }} {{ $trip->status == 'arrived' ? 'current' : '' }}">
                        <small class="text-muted">وصل للعميل</small>
                        @if($trip->arrived_at)
                        <br><small class="fw-bold">{{ $trip->arrived_at->format('H:i:s') }}</small>
                        @endif
                    </div>
                    <div class="timeline-item {{ $trip->started_at ? 'completed' : '' }} {{ $trip->status == 'in_progress' ? 'current' : '' }}">
                        <small class="text-muted">بدء الرحلة</small>
                        @if($trip->started_at)
                        <br><small class="fw-bold">{{ $trip->started_at->format('H:i:s') }}</small>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="d-flex gap-2">
                    @switch($trip->status)
                        @case('assigned')
                            <form action="{{ route('trips.accept', $trip->id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    <i class="fas fa-check me-1"></i> قبول
                                </button>
                            </form>
                            @break
                        @case('accepted')
                            <form action="{{ route('trips.enroute', $trip->id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <button type="submit" class="btn btn-info btn-sm w-100">
                                    <i class="fas fa-car me-1"></i> في الطريق
                                </button>
                            </form>
                            @break
                        @case('en_route')
                            <form action="{{ route('trips.arrive', $trip->id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm w-100">
                                    <i class="fas fa-map-pin me-1"></i> وصلت
                                </button>
                            </form>
                            @break
                        @case('arrived')
                            <form action="{{ route('trips.start', $trip->id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-play me-1"></i> بدء الرحلة
                                </button>
                            </form>
                            @break
                        @case('in_progress')
                            <a href="{{ route('trips.index') }}?status=in_progress" class="btn btn-success btn-sm flex-grow-1">
                                <i class="fas fa-flag-checkered me-1"></i> إنهاء
                            </a>
                            @break
                    @endswitch
                    <a href="{{ route('trips.show', $trip->id) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="card border-0 shadow-sm">
    <div class="card-body text-center py-5">
        <div class="avatar avatar-xxl bg-light rounded-circle mx-auto mb-4">
            <i class="fas fa-car fa-3x text-muted"></i>
        </div>
        <h4 class="text-muted">لا توجد رحلات نشطة حالياً</h4>
        <p class="text-muted mb-4">جميع الرحلات مكتملة أو لم تبدأ بعد</p>
        <a href="{{ route('trips.index') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> إنشاء رحلة جديدة
        </a>
    </div>
</div>
@endif

<!-- Available Drivers -->
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header">
        <h6 class="card-title mb-0">
            <i class="fas fa-user-check me-2 text-success"></i>
            السائقين المتاحين
            <span class="badge bg-success ms-2">{{ $drivers->where('status', 'active')->count() }}</span>
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            @forelse($drivers->where('status', 'active') as $driver)
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="d-flex align-items-center p-3 bg-light rounded">
                    <div class="avatar avatar-sm bg-success text-white rounded-circle me-3">
                        {{ mb_substr($driver->name_ar ?? $driver->name_en, 0, 1) }}
                    </div>
                    <div>
                        <strong>{{ $driver->name_ar ?? $driver->name_en }}</strong>
                        <br><small class="text-success">متاح</small>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-3">
                <i class="fas fa-user-slash fa-2x mb-2 opacity-50"></i>
                <p class="mb-0">جميع السائقين مشغولين حالياً</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Update current time
setInterval(() => {
    const now = new Date();
    document.getElementById('currentTime').textContent = now.toLocaleTimeString('ar-SA');
}, 1000);

// Trip Timer Logic
class TripTimer {
    constructor() {
        this.timers = document.querySelectorAll('.trip-timer');
        this.init();
    }

    init() {
        this.timers.forEach(timer => this.setupTimer(timer));
        setInterval(() => this.updateAll(), 1000);
    }

    setupTimer(timerEl) {
        const status = timerEl.dataset.status;
        const labelEl = timerEl.querySelector('.timer-label');
        
        let label = '';
        switch(status) {
            case 'accepted': label = 'منذ القبول'; break;
            case 'en_route': label = 'في الطريق'; break;
            case 'arrived': label = 'في الانتظار'; break;
            case 'in_progress': label = 'مدة الرحلة'; break;
        }
        labelEl.textContent = label;
    }

    updateAll() {
        this.timers.forEach(timer => {
            const status = timer.dataset.status;
            let startTime = null;

            switch(status) {
                case 'accepted': startTime = timer.dataset.accepted; break;
                case 'en_route': startTime = timer.dataset.enroute; break;
                case 'arrived': startTime = timer.dataset.arrived; break;
                case 'in_progress': startTime = timer.dataset.started; break;
            }

            if (startTime) {
                const start = new Date(startTime);
                const now = new Date();
                const diff = Math.floor((now - start) / 1000);
                
                const hours = Math.floor(diff / 3600);
                const minutes = Math.floor((diff % 3600) / 60);
                const seconds = diff % 60;
                
                const display = timer.querySelector('.timer-display');
                display.textContent = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            }
        });
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    new TripTimer();
});

// Auto refresh every 30 seconds
setInterval(() => {
    location.reload();
}, 30000);
</script>
@endsection

