@extends('layouts.master')

@section('title', 'تفاصيل الرحلة')

@section('content')
<style>
    .timeline-vertical {
        position: relative;
        padding-right: 40px;
    }
    .timeline-vertical::before {
        content: '';
        position: absolute;
        right: 15px;
        top: 0;
        bottom: 0;
        width: 3px;
        background: #e9ecef;
    }
    .timeline-step {
        position: relative;
        padding-bottom: 25px;
    }
    .timeline-step:last-child {
        padding-bottom: 0;
    }
    .timeline-step::before {
        content: '';
        position: absolute;
        right: -33px;
        top: 5px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #e9ecef;
        border: 3px solid #fff;
        box-shadow: 0 0 0 3px #e9ecef;
    }
    .timeline-step.completed::before {
        background: #198754;
        box-shadow: 0 0 0 3px #198754;
    }
    .timeline-step.current::before {
        background: #0d6efd;
        box-shadow: 0 0 0 3px #0d6efd;
        animation: pulse 2s infinite;
    }
    .timeline-step.cancelled::before {
        background: #dc3545;
        box-shadow: 0 0 0 3px #dc3545;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
</style>

<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between mb-4">
    <div class="my-auto mb-2">
        <h5 class="page-title fw-semibold fs-18 mb-0">تفاصيل الرحلة</h5>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('trips.index') }}">إدارة الرحلات</a></li>
                <li class="breadcrumb-item active">{{ $trip->trip_number }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto gap-2">
        <a href="{{ route('trips.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right me-1"></i> رجوع
        </a>
        @if($trip->status == 'in_progress')
        <a href="{{ route('trips.monitor') }}" class="btn btn-info">
            <i class="fas fa-tv me-1"></i> المراقبة الحية
        </a>
        @endif
    </div>
</div>

<div class="row">
    <!-- Main Info -->
    <div class="col-lg-8">
        <!-- Trip Status Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-{{ $trip->status_color }} text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-route me-2"></i>
                        {{ $trip->trip_number }}
                    </h5>
                    <span class="badge bg-white text-{{ $trip->status_color }} fs-6">{{ $trip->status_label }}</span>
                </div>
            </div>
            <div class="card-body">
                <!-- Live Timer for active trips -->
                @if(in_array($trip->status, ['accepted', 'en_route', 'arrived', 'in_progress']))
                <div class="text-center mb-4 p-4 bg-light rounded">
                    <div class="trip-timer" 
                         data-status="{{ $trip->status }}"
                         data-accepted="{{ $trip->accepted_at?->toISOString() }}"
                         data-enroute="{{ $trip->en_route_at?->toISOString() }}"
                         data-arrived="{{ $trip->arrived_at?->toISOString() }}"
                         data-started="{{ $trip->started_at?->toISOString() }}">
                        <div class="display-4 fw-bold text-{{ $trip->status_color }} timer-display">00:00:00</div>
                        <p class="text-muted mb-0 timer-label"></p>
                    </div>
                </div>
                @endif

                <!-- Route Info -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start p-3 bg-success bg-opacity-10 rounded">
                            <div class="avatar bg-success text-white rounded-circle me-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <small class="text-muted">نقطة الالتقاط</small>
                                <p class="mb-0 fw-bold">{{ $trip->pickup_location }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start p-3 bg-danger bg-opacity-10 rounded">
                            <div class="avatar bg-danger text-white rounded-circle me-3">
                                <i class="fas fa-flag-checkered"></i>
                            </div>
                            <div>
                                <small class="text-muted">نقطة الوصول</small>
                                <p class="mb-0 fw-bold">{{ $trip->dropoff_location }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Client & Driver Info -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-user me-2"></i>بيانات العميل</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>الاسم:</strong> {{ $trip->client_name }}</p>
                                <p><strong>الجوال:</strong> {{ $trip->client_phone ?? 'غير محدد' }}</p>
                                @if($trip->feedback)
                                <p><strong>التقييم:</strong> 
                                    @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $trip->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </p>
                                <p><strong>الملاحظة:</strong> {{ $trip->feedback }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-id-card me-2"></i>بيانات السائق والمركبة</h6>
                            </div>
                            <div class="card-body">
                                @if($trip->driver)
                                <p><strong>السائق:</strong> {{ $trip->driver->name_ar ?? $trip->driver->name_en }}</p>
                                <p><strong>الجوال:</strong> {{ $trip->driver->phone ?? '-' }}</p>
                                @else
                                <p class="text-muted">لم يتم تعيين سائق</p>
                                @endif
                                @if($trip->vehicle)
                                <p><strong>المركبة:</strong> {{ $trip->vehicle->brand }} {{ $trip->vehicle->model }}</p>
                                <p><strong>رقم اللوحة:</strong> {{ $trip->vehicle->plate_number }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Card -->
        @if($trip->status == 'completed')
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-receipt me-2"></i>تفاصيل الأجرة</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td>الأجرة الأساسية</td>
                            <td class="text-start">{{ number_format($trip->base_fare, 2) }} ر.س</td>
                        </tr>
                        <tr>
                            <td>أجرة المسافة ({{ $trip->distance_km ?? 0 }} كم)</td>
                            <td class="text-start">{{ number_format($trip->distance_fare, 2) }} ر.س</td>
                        </tr>
                        <tr>
                            <td>أجرة الانتظار</td>
                            <td class="text-start">{{ number_format($trip->wait_fare, 2) }} ر.س</td>
                        </tr>
                        <tr>
                            <td>إضافات</td>
                            <td class="text-start">{{ number_format($trip->extras, 2) }} ر.س</td>
                        </tr>
                        <tr class="text-danger">
                            <td>خصم</td>
                            <td class="text-start">- {{ number_format($trip->discount, 2) }} ر.س</td>
                        </tr>
                        <tr class="border-top">
                            <td>الضريبة (15%)</td>
                            <td class="text-start">{{ number_format($trip->tax_amount, 2) }} ر.س</td>
                        </tr>
                        <tr class="border-top fw-bold fs-5">
                            <td class="text-success">الإجمالي</td>
                            <td class="text-start text-success">{{ number_format($trip->total_fare, 2) }} ر.س</td>
                        </tr>
                    </table>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p><strong>طريقة الدفع:</strong> {{ $trip->paymentMethod->name ?? 'غير محدد' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>حالة الدفع:</strong> 
                            <span class="badge bg-{{ $trip->payment_status == 'paid' ? 'success' : ($trip->payment_status == 'refunded' ? 'warning' : 'danger') }}">
                                {{ $trip->payment_status == 'paid' ? 'مدفوع' : ($trip->payment_status == 'refunded' ? 'مسترد' : 'غير مدفوع') }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Notes -->
        @if($trip->notes || $trip->cancellation_reason)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-sticky-note me-2"></i>ملاحظات</h6>
            </div>
            <div class="card-body">
                @if($trip->notes)
                <p>{{ $trip->notes }}</p>
                @endif
                @if($trip->cancellation_reason)
                <div class="alert alert-danger">
                    <strong>سبب الإلغاء:</strong> {{ $trip->cancellation_reason }}
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar - Timeline -->
    <div class="col-lg-4">
        <!-- Trip Timeline -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-history me-2"></i>مسار الرحلة</h6>
            </div>
            <div class="card-body">
                <div class="timeline-vertical">
                    <!-- Requested -->
                    <div class="timeline-step {{ $trip->requested_at ? 'completed' : '' }}">
                        <h6 class="mb-1">طلب الرحلة</h6>
                        @if($trip->requested_at)
                        <small class="text-muted">{{ $trip->requested_at->format('Y-m-d H:i:s') }}</small>
                        @endif
                    </div>

                    <!-- Assigned -->
                    <div class="timeline-step {{ $trip->assigned_at ? 'completed' : '' }} {{ $trip->status == 'assigned' ? 'current' : '' }}">
                        <h6 class="mb-1">تم التعيين</h6>
                        @if($trip->assigned_at)
                        <small class="text-muted">{{ $trip->assigned_at->format('Y-m-d H:i:s') }}</small>
                        @endif
                    </div>

                    <!-- Accepted -->
                    <div class="timeline-step {{ $trip->accepted_at ? 'completed' : '' }} {{ $trip->status == 'accepted' ? 'current' : '' }}">
                        <h6 class="mb-1">تم القبول</h6>
                        @if($trip->accepted_at)
                        <small class="text-muted">{{ $trip->accepted_at->format('Y-m-d H:i:s') }}</small>
                        @endif
                    </div>

                    <!-- En Route -->
                    <div class="timeline-step {{ $trip->en_route_at ? 'completed' : '' }} {{ $trip->status == 'en_route' ? 'current' : '' }}">
                        <h6 class="mb-1">في الطريق</h6>
                        @if($trip->en_route_at)
                        <small class="text-muted">{{ $trip->en_route_at->format('Y-m-d H:i:s') }}</small>
                        @endif
                    </div>

                    <!-- Arrived -->
                    <div class="timeline-step {{ $trip->arrived_at ? 'completed' : '' }} {{ $trip->status == 'arrived' ? 'current' : '' }}">
                        <h6 class="mb-1">وصل للعميل</h6>
                        @if($trip->arrived_at)
                        <small class="text-muted">{{ $trip->arrived_at->format('Y-m-d H:i:s') }}</small>
                        @if($trip->wait_time)
                        <br><span class="badge bg-warning">انتظر {{ \App\Models\Trip::formatDuration($trip->wait_time) }}</span>
                        @endif
                        @endif
                    </div>

                    <!-- Started -->
                    <div class="timeline-step {{ $trip->started_at ? 'completed' : '' }} {{ $trip->status == 'in_progress' ? 'current' : '' }}">
                        <h6 class="mb-1">بدء الرحلة</h6>
                        @if($trip->started_at)
                        <small class="text-muted">{{ $trip->started_at->format('Y-m-d H:i:s') }}</small>
                        @endif
                    </div>

                    <!-- Completed/Cancelled -->
                    @if($trip->status == 'completed')
                    <div class="timeline-step completed">
                        <h6 class="mb-1 text-success">اكتملت الرحلة</h6>
                        @if($trip->completed_at)
                        <small class="text-muted">{{ $trip->completed_at->format('Y-m-d H:i:s') }}</small>
                        @if($trip->trip_duration)
                        <br><span class="badge bg-success">مدة الرحلة: {{ \App\Models\Trip::formatDuration($trip->trip_duration) }}</span>
                        @endif
                        @endif
                    </div>
                    @elseif($trip->status == 'cancelled')
                    <div class="timeline-step cancelled">
                        <h6 class="mb-1 text-danger">تم الإلغاء</h6>
                        @if($trip->cancelled_at)
                        <small class="text-muted">{{ $trip->cancelled_at->format('Y-m-d H:i:s') }}</small>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Trip Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>معلومات إضافية</h6>
            </div>
            <div class="card-body">
                <p><strong>نوع الرحلة:</strong> 
                    <span class="badge bg-{{ $trip->trip_type == 'vip' ? 'warning' : ($trip->trip_type == 'airport' ? 'info' : 'secondary') }}">
                        {{ $trip->trip_type == 'standard' ? 'عادية' : ($trip->trip_type == 'vip' ? 'VIP' : ($trip->trip_type == 'airport' ? 'مطار' : 'بالساعة')) }}
                    </span>
                </p>
                @if($trip->distance_km)
                <p><strong>المسافة:</strong> {{ $trip->distance_km }} كم</p>
                @endif
                @if($trip->total_duration)
                <p><strong>المدة الإجمالية:</strong> {{ \App\Models\Trip::formatDuration($trip->total_duration) }}</p>
                @endif
                @if($trip->is_scheduled)
                <p><strong>موعد مجدول:</strong> {{ $trip->scheduled_at?->format('Y-m-d H:i') }}</p>
                @endif
                <p><strong>أنشئت بواسطة:</strong> {{ $trip->createdBy->name ?? 'النظام' }}</p>
                <p><strong>تاريخ الإنشاء:</strong> {{ $trip->created_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>

        <!-- Transaction Link -->
        @if($trip->transaction)
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>المعاملة المالية</h6>
            </div>
            <div class="card-body">
                <p><strong>رقم المرجع:</strong> {{ $trip->transaction->reference_number }}</p>
                <p><strong>المبلغ:</strong> {{ number_format($trip->transaction->net_amount, 2) }} ر.س</p>
                <a href="{{ route('transactions.show', $trip->transaction->id) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-eye me-1"></i> عرض المعاملة
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
@if(in_array($trip->status, ['accepted', 'en_route', 'arrived', 'in_progress']))
<script>
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

document.addEventListener('DOMContentLoaded', function() {
    new TripTimer();
});
</script>
@endif
@endsection

