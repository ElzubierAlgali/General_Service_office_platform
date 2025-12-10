@extends('layouts.master')

@section('title', 'بوابة السائق')

@section('content')
<style>
    .trip-card {
        transition: all 0.3s ease;
        border-radius: 15px;
    }
    .trip-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    .big-timer {
        font-size: 3.5rem;
        font-weight: bold;
        font-family: 'Courier New', monospace;
    }
    .action-btn {
        padding: 15px 30px;
        font-size: 1.2rem;
        border-radius: 50px;
    }
    .driver-status-badge {
        font-size: 1rem;
        padding: 10px 20px;
    }
</style>

<!-- Driver Header -->
<div class="card border-0 shadow-sm mb-4 bg-gradient-primary text-white">
    <div class="card-body py-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl bg-white text-primary rounded-circle me-3" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user-tie fa-2x"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">مرحباً، {{ $driver->name_ar ?? $driver->name_en }}</h4>
                        <p class="mb-0 opacity-75">
                            <i class="fas fa-car me-1"></i>
                            {{ $driver->assignedVehicle->plate_number ?? 'لا توجد مركبة معينة' }}
                            @if($driver->assignedVehicle)
                                - {{ $driver->assignedVehicle->brand }} {{ $driver->assignedVehicle->model }}
                            @endif
                        </p>
                        <a href="{{ route('driver-portal.statement') }}" class="btn btn-sm btn-light mt-2">
                            <i class="fas fa-file-invoice me-1"></i> كشف حساب الرحلات
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="dropdown">
                    <button class="btn btn-light driver-status-badge dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <span class="status-indicator bg-{{ $driver->status == 'active' ? 'success' : ($driver->status == 'on_duty' ? 'warning' : 'secondary') }} me-2"></span>
                        {{ $driver->status == 'active' ? 'متاح' : ($driver->status == 'on_duty' ? 'في مهمة' : ($driver->status == 'off_duty' ? 'خارج الخدمة' : 'إجازة')) }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ route('driver-portal.status') }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="active">
                                <button type="submit" class="dropdown-item {{ $driver->status == 'active' ? 'active' : '' }}">
                                    <span class="status-indicator bg-success me-2"></span> متاح
                                </button>
                            </form>
                        </li>
                        <li>
                            <form action="{{ route('driver-portal.status') }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="off_duty">
                                <button type="submit" class="dropdown-item {{ $driver->status == 'off_duty' ? 'active' : '' }}">
                                    <span class="status-indicator bg-secondary me-2"></span> خارج الخدمة
                                </button>
                            </form>
                        </li>
                        <li>
                            <form action="{{ route('driver-portal.status') }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="on_leave">
                                <button type="submit" class="dropdown-item {{ $driver->status == 'on_leave' ? 'active' : '' }}">
                                    <span class="status-indicator bg-info me-2"></span> إجازة
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Today's Stats -->
<div class="row mb-4">
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="avatar bg-success bg-opacity-10 rounded-circle mx-auto mb-2" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-check-circle text-success"></i>
                </div>
                <h3 class="mb-0">{{ $completedToday }}</h3>
                <small class="text-muted">رحلات اليوم</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="avatar bg-primary bg-opacity-10 rounded-circle mx-auto mb-2" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-coins text-primary"></i>
                </div>
                <h3 class="mb-0 text-success">{{ number_format($todayEarnings, 0) }}</h3>
                <small class="text-muted">إيرادات اليوم (ر.س)</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="avatar bg-warning bg-opacity-10 rounded-circle mx-auto mb-2" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-clock text-warning"></i>
                </div>
                <h3 class="mb-0">{{ $assignedTrips->count() }}</h3>
                <small class="text-muted">رحلات معلقة</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="avatar bg-info bg-opacity-10 rounded-circle mx-auto mb-2" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-star text-info"></i>
                </div>
                <h3 class="mb-0">5.0</h3>
                <small class="text-muted">التقييم</small>
            </div>
        </div>
    </div>
</div>

<!-- Active Trip (if any) -->
@if($activeTrip)
<div class="card border-0 shadow-lg mb-4 trip-card" style="border-right: 5px solid #28a745 !important;">
    <div class="card-header bg-success text-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-car-side me-2"></i>
                الرحلة الحالية
            </h5>
            <span class="badge bg-white text-success">{{ $activeTrip->status_label }}</span>
        </div>
    </div>
    <div class="card-body">
        <!-- Live Timer -->
        <div class="text-center mb-4">
            <div class="trip-timer" 
                 data-status="{{ $activeTrip->status }}"
                 data-accepted="{{ $activeTrip->accepted_at?->toISOString() }}"
                 data-enroute="{{ $activeTrip->en_route_at?->toISOString() }}"
                 data-arrived="{{ $activeTrip->arrived_at?->toISOString() }}"
                 data-started="{{ $activeTrip->started_at?->toISOString() }}">
                <div class="big-timer text-success timer-display">00:00:00</div>
                <p class="text-muted mb-0 timer-label"></p>
            </div>
        </div>

        <!-- Client Info -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar bg-light rounded-circle me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user text-primary"></i>
                    </div>
                    <div>
                        <small class="text-muted">العميل</small>
                        <h5 class="mb-0">{{ $activeTrip->client_name }}</h5>
                        @if($activeTrip->client_phone)
                        <a href="tel:{{ $activeTrip->client_phone }}" class="text-primary">
                            <i class="fas fa-phone me-1"></i>{{ $activeTrip->client_phone }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <small class="text-muted">رقم الرحلة</small>
                <h5 class="mb-0">{{ $activeTrip->trip_number }}</h5>
            </div>
        </div>

        <!-- Price & Payment Info -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card bg-success bg-opacity-10 border-0">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success text-white rounded-circle me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div>
                                <small class="text-muted">سعر الرحلة</small>
                                <h4 class="mb-0 text-success">
                                    @if($activeTrip->base_fare > 0)
                                        {{ number_format($activeTrip->base_fare, 2) }} ر.س
                                    @else
                                        <span class="text-muted">غير محدد</span>
                                    @endif
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-primary bg-opacity-10 border-0">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary text-white rounded-circle me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div>
                                <small class="text-muted">طريقة الدفع</small>
                                <h5 class="mb-0 text-primary">
                                    @if($activeTrip->paymentMethod)
                                        <i class="{{ $activeTrip->paymentMethod->icon ?? 'fas fa-wallet' }} me-1"></i>
                                        {{ $activeTrip->paymentMethod->name }}
                                    @else
                                        <span class="text-muted">غير محددة</span>
                                    @endif
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Route -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-start mb-3">
                    <div class="me-3">
                        <div class="bg-success rounded-circle" style="width: 15px; height: 15px;"></div>
                        <div class="bg-secondary mx-auto" style="width: 2px; height: 30px;"></div>
                        <div class="bg-danger rounded-circle" style="width: 15px; height: 15px;"></div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="mb-3">
                            <small class="text-muted">من</small>
                            <p class="mb-0 fw-bold">{{ $activeTrip->pickup_location }}</p>
                        </div>
                        <div>
                            <small class="text-muted">إلى</small>
                            <p class="mb-0 fw-bold">{{ $activeTrip->dropoff_location }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex flex-wrap gap-2 justify-content-center">
            @switch($activeTrip->status)
                @case('accepted')
                    <form action="{{ route('driver-portal.enroute', $activeTrip->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-info action-btn">
                            <i class="fas fa-car me-2"></i> بدء التحرك
                        </button>
                    </form>
                    @break
                @case('en_route')
                    <form action="{{ route('driver-portal.arrive', $activeTrip->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning action-btn">
                            <i class="fas fa-map-marker-alt me-2"></i> وصلت للعميل
                        </button>
                    </form>
                    @break
                @case('arrived')
                    <form action="{{ route('driver-portal.start', $activeTrip->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary action-btn">
                            <i class="fas fa-play me-2"></i> بدء الرحلة
                        </button>
                    </form>
                    @break
                @case('in_progress')
                    <button type="button" class="btn btn-success action-btn" data-bs-toggle="modal" data-bs-target="#completeTripModal">
                        <i class="fas fa-flag-checkered me-2"></i> إنهاء الرحلة
                    </button>
                    @break
            @endswitch
        </div>

        @if($activeTrip->notes)
        <div class="alert alert-info mt-3 mb-0">
            <i class="fas fa-info-circle me-2"></i>
            <strong>ملاحظات:</strong> {{ $activeTrip->notes }}
        </div>
        @endif
    </div>
</div>

<!-- Complete Trip Modal -->
<div class="modal fade" id="completeTripModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-flag-checkered me-2"></i>إنهاء الرحلة</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('driver-portal.complete', $activeTrip->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Trip Summary -->
                    <div class="alert alert-info mb-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>{{ $activeTrip->trip_number }}</strong>
                                <br><small>{{ $activeTrip->client_name }}</small>
                            </div>
                            <div class="text-end">
                                <strong>الأجرة الأساسية</strong>
                                <br><span class="text-success fs-5">{{ number_format($activeTrip->base_fare, 2) }} ر.س</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">المسافة المقطوعة (كم)</label>
                            <input type="number" step="0.1" name="distance_km" class="form-control" placeholder="مثال: 15.5" id="distanceKm">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">أجرة المسافة (ر.س)</label>
                            <input type="number" step="0.01" name="distance_fare" class="form-control fare-input" value="0" id="distanceFare">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">أجرة الانتظار (ر.س)</label>
                            <input type="number" step="0.01" name="wait_fare" class="form-control fare-input" value="0" id="waitFare">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">إضافات (ر.س)</label>
                            <input type="number" step="0.01" name="extras" class="form-control fare-input" value="0" id="extras">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">خصم (ر.س)</label>
                            <input type="number" step="0.01" name="discount" class="form-control fare-input" value="0" id="discount">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">طريقة الدفع</label>
                            <select name="payment_method_id" class="form-select">
                                @if($activeTrip->paymentMethod)
                                    <option value="{{ $activeTrip->payment_method_id }}" selected>{{ $activeTrip->paymentMethod->name }}</option>
                                @else
                                    <option value="">نقدي</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <!-- Fare Summary -->
                    <div class="card bg-light border-0 mt-3">
                        <div class="card-body">
                            <h6 class="mb-3"><i class="fas fa-receipt me-2"></i>ملخص الفاتورة</h6>
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td>الأجرة الأساسية</td>
                                    <td class="text-end" id="summaryBase">{{ number_format($activeTrip->base_fare, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>أجرة المسافة</td>
                                    <td class="text-end" id="summaryDistance">0.00</td>
                                </tr>
                                <tr>
                                    <td>أجرة الانتظار</td>
                                    <td class="text-end" id="summaryWait">0.00</td>
                                </tr>
                                <tr>
                                    <td>إضافات</td>
                                    <td class="text-end" id="summaryExtras">0.00</td>
                                </tr>
                                <tr class="text-danger">
                                    <td>خصم</td>
                                    <td class="text-end" id="summaryDiscount">- 0.00</td>
                                </tr>
                                <tr class="border-top">
                                    <td>الضريبة (15%)</td>
                                    <td class="text-end" id="summaryTax">0.00</td>
                                </tr>
                                <tr class="border-top fs-5 fw-bold text-success">
                                    <td>الإجمالي</td>
                                    <td class="text-end" id="summaryTotal">{{ number_format($activeTrip->base_fare * 1.15, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-check me-1"></i> تأكيد الإنهاء وتسجيل الدفعة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const baseFare = {{ $activeTrip->base_fare ?? 0 }};
    
    function calculateTotal() {
        const distanceFare = parseFloat(document.getElementById('distanceFare')?.value) || 0;
        const waitFare = parseFloat(document.getElementById('waitFare')?.value) || 0;
        const extras = parseFloat(document.getElementById('extras')?.value) || 0;
        const discount = parseFloat(document.getElementById('discount')?.value) || 0;
        
        const subtotal = baseFare + distanceFare + waitFare + extras - discount;
        const tax = subtotal * 0.15;
        const total = subtotal + tax;
        
        document.getElementById('summaryBase').textContent = baseFare.toFixed(2);
        document.getElementById('summaryDistance').textContent = distanceFare.toFixed(2);
        document.getElementById('summaryWait').textContent = waitFare.toFixed(2);
        document.getElementById('summaryExtras').textContent = extras.toFixed(2);
        document.getElementById('summaryDiscount').textContent = '- ' + discount.toFixed(2);
        document.getElementById('summaryTax').textContent = tax.toFixed(2);
        document.getElementById('summaryTotal').textContent = total.toFixed(2) + ' ر.س';
    }
    
    // Add event listeners to all fare inputs
    document.querySelectorAll('.fare-input').forEach(input => {
        input.addEventListener('input', calculateTotal);
    });
    
    // Initial calculation
    calculateTotal();
});
</script>
@endif

<!-- Pending Trips (Assigned to driver) -->
@if($assignedTrips->count() > 0)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">
            <i class="fas fa-bell me-2"></i>
            رحلات جديدة تحتاج قبولك
            <span class="badge bg-dark ms-2">{{ $assignedTrips->count() }}</span>
        </h5>
    </div>
    <div class="card-body">
        @foreach($assignedTrips as $trip)
        <div class="card mb-3 trip-card border">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-dark me-2">{{ $trip->trip_number }}</span>
                            <span class="badge bg-{{ $trip->trip_type == 'vip' ? 'warning' : 'secondary' }}">
                                {{ $trip->trip_type == 'vip' ? 'VIP' : 'عادية' }}
                            </span>
                        </div>
                        <h5 class="mb-2">{{ $trip->client_name }}</h5>
                        @if($trip->client_phone)
                        <p class="mb-2">
                            <a href="tel:{{ $trip->client_phone }}" class="text-primary">
                                <i class="fas fa-phone me-1"></i>{{ $trip->client_phone }}
                            </a>
                        </p>
                        @endif
                        <div class="small">
                            <div class="text-success mb-1">
                                <i class="fas fa-circle fa-xs me-1"></i>
                                {{ $trip->pickup_location }}
                            </div>
                            <div class="text-danger">
                                <i class="fas fa-circle fa-xs me-1"></i>
                                {{ $trip->dropoff_location }}
                            </div>
                        </div>
                        
                        <!-- Price & Payment Method -->
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <div class="d-flex align-items-center bg-success bg-opacity-10 rounded px-3 py-2">
                                <i class="fas fa-money-bill-wave text-success me-2"></i>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 10px;">السعر</small>
                                    <strong class="text-success">
                                        @if($trip->base_fare > 0)
                                            {{ number_format($trip->base_fare, 2) }} ر.س
                                        @else
                                            غير محدد
                                        @endif
                                    </strong>
                                </div>
                            </div>
                            <div class="d-flex align-items-center bg-primary bg-opacity-10 rounded px-3 py-2">
                                <i class="fas fa-credit-card text-primary me-2"></i>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 10px;">الدفع</small>
                                    <strong class="text-primary">
                                        @if($trip->paymentMethod)
                                            {{ $trip->paymentMethod->name }}
                                        @else
                                            غير محدد
                                        @endif
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="d-flex flex-column gap-2">
                            <form action="{{ route('driver-portal.accept', $trip->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100" {{ $activeTrip ? 'disabled' : '' }}>
                                    <i class="fas fa-check me-1"></i> قبول
                                </button>
                            </form>
                            <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectTrip{{ $trip->id }}">
                                <i class="fas fa-times me-1"></i> رفض
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div class="modal fade" id="rejectTrip{{ $trip->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">رفض الرحلة</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('driver-portal.reject', $trip->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">سبب الرفض (اختياري)</label>
                                <textarea name="reason" class="form-control" rows="3" placeholder="اذكر سبب رفض الرحلة..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                            <button type="submit" class="btn btn-danger">تأكيد الرفض</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- No Active Content Message -->
@if(!$activeTrip && $assignedTrips->count() == 0)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body text-center py-5">
        <div class="avatar bg-light rounded-circle mx-auto mb-4" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-car fa-3x text-muted"></i>
        </div>
        <h4 class="text-muted">لا توجد رحلات حالياً</h4>
        <p class="text-muted">ستظهر الرحلات الجديدة هنا فور تعيينها لك</p>
        @if($driver->status != 'active')
        <div class="alert alert-warning d-inline-block mt-3">
            <i class="fas fa-exclamation-triangle me-2"></i>
            حالتك الحالية: <strong>{{ $driver->status == 'off_duty' ? 'خارج الخدمة' : 'إجازة' }}</strong>
            <br>قم بتغيير حالتك إلى "متاح" لاستقبال رحلات جديدة
        </div>
        @endif
    </div>
</div>
@endif

<!-- Recent Trips History -->
@if($recentTrips->count() > 0)
<div class="card border-0 shadow-sm">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-history me-2"></i>آخر الرحلات</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>الرحلة</th>
                        <th>العميل</th>
                        <th>الحالة</th>
                        <th>المبلغ</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTrips as $trip)
                    <tr>
                        <td><span class="badge bg-dark">{{ $trip->trip_number }}</span></td>
                        <td>{{ $trip->client_name }}</td>
                        <td>
                            <span class="badge bg-{{ $trip->status == 'completed' ? 'success' : 'danger' }}">
                                {{ $trip->status == 'completed' ? 'مكتملة' : 'ملغاة' }}
                            </span>
                        </td>
                        <td>
                            @if($trip->total_fare > 0)
                            <span class="text-success fw-bold">{{ number_format($trip->total_fare, 0) }} ر.س</span>
                            @else
                            -
                            @endif
                        </td>
                        <td>{{ $trip->completed_at?->format('m/d H:i') ?? $trip->cancelled_at?->format('m/d H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
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

// Auto refresh every 30 seconds to check for new trips
setInterval(() => {
    location.reload();
}, 30000);
</script>
@endsection

