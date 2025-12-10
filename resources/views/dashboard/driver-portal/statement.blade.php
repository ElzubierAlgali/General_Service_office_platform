@extends('layouts.master')

@section('title', 'كشف حساب الرحلات')

@section('content')
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between mb-4">
    <div class="my-auto mb-2">
        <h5 class="page-title fw-semibold fs-18 mb-0">كشف حساب الرحلات</h5>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('driver-portal.index') }}">بوابة السائق</a></li>
                <li class="breadcrumb-item active">كشف الحساب</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('driver-portal.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right me-1"></i> رجوع
        </a>
        <a href="{{ route('driver-portal.print-statement', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
           target="_blank" class="btn btn-outline-primary">
            <i class="fas fa-print me-1"></i> طباعة
        </a>
    </div>
</div>

<!-- Driver Info Card -->
<div class="card border-0 shadow-sm mb-4 bg-gradient-primary text-white">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-lg bg-white text-primary rounded-circle me-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user-tie fa-xl"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">{{ $driver->name_ar ?? $driver->name_en }}</h4>
                        <p class="mb-0 opacity-75">
                            <i class="fas fa-id-card me-1"></i> {{ $driver->id_number ?? 'غير محدد' }}
                            @if($driver->phone)
                            | <i class="fas fa-phone me-1"></i> {{ $driver->phone }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <small class="opacity-75">الفترة</small>
                <h5 class="mb-0">{{ $startDate }} إلى {{ $endDate }}</h5>
            </div>
        </div>
    </div>
</div>

<!-- Date Filter -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('driver-portal.statement') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label">الفترة</label>
                <select name="period" class="form-select select2" onchange="toggleCustomDates(this)">
                    <option value="today" {{ $period == 'today' ? 'selected' : '' }}>اليوم</option>
                    <option value="week" {{ $period == 'week' ? 'selected' : '' }}>هذا الأسبوع</option>
                    <option value="month" {{ $period == 'month' ? 'selected' : '' }}>هذا الشهر</option>
                    <option value="last_month" {{ $period == 'last_month' ? 'selected' : '' }}>الشهر الماضي</option>
                    <option value="custom" {{ $period == 'custom' ? 'selected' : '' }}>تحديد مخصص</option>
                </select>
            </div>
            <div class="col-md-3" id="startDateField">
                <label class="form-label">من تاريخ</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-3" id="endDateField">
                <label class="form-label">إلى تاريخ</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i> عرض
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-6 col-lg-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">إجمالي الرحلات</p>
                        <h3 class="mb-0">{{ $stats['total_trips'] }}</h3>
                        <small class="text-success">{{ $stats['completed_trips'] }} مكتملة</small>
                        @if($stats['cancelled_trips'] > 0)
                        <small class="text-danger">| {{ $stats['cancelled_trips'] }} ملغاة</small>
                        @endif
                    </div>
                    <div class="avatar bg-primary bg-opacity-10 rounded p-2">
                        <i class="fas fa-route fa-lg text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 mb-3">
        <div class="card border-0 shadow-sm h-100 bg-success bg-opacity-10">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">إجمالي الإيرادات</p>
                        <h3 class="mb-0 text-success">{{ number_format($stats['total_earnings'], 2) }}</h3>
                        <small class="text-muted">ريال سعودي</small>
                    </div>
                    <div class="avatar bg-success bg-opacity-20 rounded p-2">
                        <i class="fas fa-coins fa-lg text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">إجمالي المسافة</p>
                        <h3 class="mb-0">{{ number_format($stats['total_distance'], 1) }}</h3>
                        <small class="text-muted">كيلومتر</small>
                    </div>
                    <div class="avatar bg-info bg-opacity-10 rounded p-2">
                        <i class="fas fa-road fa-lg text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">متوسط الرحلة</p>
                        <h3 class="mb-0">{{ number_format($stats['avg_trip_fare'], 2) }}</h3>
                        <small class="text-muted">ريال</small>
                    </div>
                    <div class="avatar bg-warning bg-opacity-10 rounded p-2">
                        <i class="fas fa-chart-line fa-lg text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Earnings Breakdown -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-calculator me-2"></i>تفصيل الإيرادات</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td><i class="fas fa-tag text-primary me-2"></i>الأجرة الأساسية</td>
                        <td class="text-start fw-bold">{{ number_format($stats['total_base_fare'], 2) }} ر.س</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-road text-info me-2"></i>أجرة المسافة</td>
                        <td class="text-start fw-bold">{{ number_format($stats['total_distance_fare'], 2) }} ر.س</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-clock text-warning me-2"></i>أجرة الانتظار</td>
                        <td class="text-start fw-bold">{{ number_format($stats['total_wait_fare'], 2) }} ر.س</td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-plus-circle text-success me-2"></i>إضافات</td>
                        <td class="text-start fw-bold">{{ number_format($stats['total_extras'], 2) }} ر.س</td>
                    </tr>
                    <tr class="text-danger">
                        <td><i class="fas fa-minus-circle me-2"></i>خصومات</td>
                        <td class="text-start fw-bold">- {{ number_format($stats['total_discount'], 2) }} ر.س</td>
                    </tr>
                    <tr class="border-top">
                        <td><i class="fas fa-percent text-secondary me-2"></i>الضريبة</td>
                        <td class="text-start fw-bold">{{ number_format($stats['total_tax'], 2) }} ر.س</td>
                    </tr>
                    <tr class="border-top bg-success bg-opacity-10">
                        <td class="fw-bold fs-5"><i class="fas fa-wallet text-success me-2"></i>الإجمالي</td>
                        <td class="text-start fw-bold fs-5 text-success">{{ number_format($stats['total_earnings'], 2) }} ر.س</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Trips Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-list me-2"></i>تفاصيل الرحلات</h6>
                <span class="badge bg-primary">{{ $trips->count() }} رحلة</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>التاريخ</th>
                                <th>رقم الرحلة</th>
                                <th>العميل</th>
                                <th>المسافة</th>
                                <th>طريقة الدفع</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trips as $trip)
                            <tr>
                                <td>
                                    <small>{{ $trip->requested_at->format('Y-m-d') }}</small>
                                    <br>
                                    <small class="text-muted">{{ $trip->requested_at->format('H:i') }}</small>
                                </td>
                                <td><span class="badge bg-dark">{{ $trip->trip_number }}</span></td>
                                <td>{{ Str::limit($trip->client_name, 15) }}</td>
                                <td>{{ $trip->distance_km ? number_format($trip->distance_km, 1) . ' كم' : '-' }}</td>
                                <td>
                                    @if($trip->paymentMethod)
                                    <span class="badge bg-light text-dark">{{ $trip->paymentMethod->name }}</span>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    @if($trip->status == 'completed')
                                    <span class="text-success fw-bold">{{ number_format($trip->total_fare, 2) }}</span>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $trip->status == 'completed' ? 'success' : ($trip->status == 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ $trip->status_label }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                                    لا توجد رحلات في هذه الفترة
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- By Payment Method -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-credit-card me-2"></i>حسب طريقة الدفع</h6>
            </div>
            <div class="card-body">
                @forelse($earningsByPayment as $payment)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <strong>{{ $payment['name'] }}</strong>
                        <br><small class="text-muted">{{ $payment['count'] }} رحلة</small>
                    </div>
                    <span class="badge bg-success px-3 py-2">{{ number_format($payment['total'], 2) }} ر.س</span>
                </div>
                @empty
                <p class="text-muted text-center mb-0">لا توجد بيانات</p>
                @endforelse
            </div>
        </div>

        <!-- Daily Breakdown -->
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-calendar-day me-2"></i>الإيرادات اليومية</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($dailyBreakdown->take(7) as $day)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ \Carbon\Carbon::parse($day['date'])->format('D d/m') }}</strong>
                            <br>
                            <small class="text-muted">{{ $day['count'] }} رحلة | {{ number_format($day['distance'], 1) }} كم</small>
                        </div>
                        <span class="badge bg-success px-3 py-2">{{ number_format($day['earnings'], 0) }} ر.س</span>
                    </div>
                    @empty
                    <div class="list-group-item text-center text-muted">
                        لا توجد بيانات
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function toggleCustomDates(select) {
    const isCustom = select.value === 'custom';
    document.getElementById('startDateField').style.display = isCustom ? 'block' : 'none';
    document.getElementById('endDateField').style.display = isCustom ? 'block' : 'none';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const periodSelect = document.querySelector('select[name="period"]');
    if (periodSelect) {
        toggleCustomDates(periodSelect);
    }
});
</script>
@endsection

