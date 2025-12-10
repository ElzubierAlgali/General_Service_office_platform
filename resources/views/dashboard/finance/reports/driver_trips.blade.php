@extends('layouts.master')
@section('title', 'تقرير رحلات السائقين المالي')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">تقرير رحلات السائقين المالي</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="#">التقارير المالية</a></li>
                <li class="breadcrumb-item active" aria-current="page">تقرير رحلات السائقين</li>
            </ol>
        </nav>
    </div>
    @permission('Print Financial Reports')
    <div>
        <a href="{{ route('reports.print.driver_trips', request()->query()) }}" target="_blank" class="btn btn-dark">
            <i class="fas fa-print"></i> طباعة التقرير
        </a>
    </div>
    @endpermission
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.driver_trips') }}" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label">من تاريخ</label>
                <input type="date" class="form-control" name="start_date" value="{{ $startDate }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">إلى تاريخ</label>
                <input type="date" class="form-control" name="end_date" value="{{ $endDate }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">السائق</label>
                <select class="form-select select2" name="driver_id">
                    <option value="">جميع السائقين</option>
                    @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}" {{ $driverId == $driver->id ? 'selected' : '' }}>
                        {{ $driver->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">الحالة</label>
                <select class="form-select" name="status">
                    <option value="all" {{ $status == 'all' ? 'selected' : '' }}>جميع الرحلات</option>
                    <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>مكتملة</option>
                    <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>ملغاة</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> عرض التقرير
                </button>
                <a href="{{ route('reports.driver_trips') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-redo"></i> إعادة تعيين
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Summary Stats -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card bg-primary text-white h-100">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $totalTrips }}</h3>
                <small>إجمالي الرحلات</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-success text-white h-100">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $completedTrips }}</h3>
                <small>رحلات مكتملة</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-danger text-white h-100">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $cancelledTrips }}</h3>
                <small>رحلات ملغاة</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-info text-white h-100">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ number_format($totalRevenue, 2) }}</h3>
                <small>إجمالي الإيرادات (ر.س)</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-warning text-dark h-100">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ number_format($avgFare, 2) }}</h3>
                <small>متوسط قيمة الرحلة</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-secondary text-white h-100">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ number_format($totalDistance, 1) }}</h3>
                <small>إجمالي المسافة (كم)</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Revenue Breakdown -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-dark text-white">
                <h6 class="mb-0"><i class="fas fa-chart-pie me-2"></i>تفاصيل الإيرادات</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td>الأجرة الأساسية</td>
                        <td class="text-start fw-bold">{{ number_format($baseFareTotal, 2) }} ر.س</td>
                    </tr>
                    <tr>
                        <td>أجرة المسافة</td>
                        <td class="text-start fw-bold">{{ number_format($distanceFareTotal, 2) }} ر.س</td>
                    </tr>
                    <tr>
                        <td>أجرة الانتظار</td>
                        <td class="text-start fw-bold">{{ number_format($waitFareTotal, 2) }} ر.س</td>
                    </tr>
                    <tr>
                        <td>إضافات</td>
                        <td class="text-start fw-bold">{{ number_format($extrasTotal, 2) }} ر.س</td>
                    </tr>
                    <tr class="text-danger">
                        <td>الخصومات</td>
                        <td class="text-start fw-bold">-{{ number_format($discountTotal, 2) }} ر.س</td>
                    </tr>
                    <tr>
                        <td>الضريبة (15%)</td>
                        <td class="text-start fw-bold">{{ number_format($taxTotal, 2) }} ر.س</td>
                    </tr>
                    <tr class="border-top">
                        <td class="fw-bold text-primary">الإجمالي</td>
                        <td class="text-start fw-bold text-primary fs-5">{{ number_format($totalRevenue, 2) }} ر.س</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- By Payment Method -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-dark text-white">
                <h6 class="mb-0"><i class="fas fa-credit-card me-2"></i>حسب طريقة الدفع</h6>
            </div>
            <div class="card-body">
                @if($paymentMethodSummary->count() > 0)
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>طريقة الدفع</th>
                            <th class="text-center">العدد</th>
                            <th class="text-start">المبلغ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paymentMethodSummary as $pm)
                        <tr>
                            <td>{{ $pm->paymentMethod->name ?? 'غير محدد' }}</td>
                            <td class="text-center">{{ $pm->trip_count }}</td>
                            <td class="text-start fw-bold">{{ number_format($pm->total_amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>لا توجد بيانات</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Daily Breakdown Chart -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-dark text-white">
                <h6 class="mb-0"><i class="fas fa-chart-line me-2"></i>الإيرادات اليومية</h6>
            </div>
            <div class="card-body">
                @if($dailyBreakdown->count() > 0)
                <div style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-sm">
                        <thead class="sticky-top bg-light">
                            <tr>
                                <th>التاريخ</th>
                                <th class="text-center">الرحلات</th>
                                <th class="text-start">الإيراد</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dailyBreakdown as $day)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($day->date)->format('Y-m-d') }}</td>
                                <td class="text-center">{{ $day->trips }}</td>
                                <td class="text-start fw-bold">{{ number_format($day->revenue, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-muted py-4">
                    <i class="fas fa-chart-bar fa-3x mb-3"></i>
                    <p>لا توجد بيانات</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Driver Summary -->
<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <h6 class="mb-0"><i class="fas fa-users me-2"></i>ملخص أداء السائقين</h6>
    </div>
    <div class="card-body">
        @if($driverSummary->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>السائق</th>
                        <th class="text-center">إجمالي الرحلات</th>
                        <th class="text-center">المكتملة</th>
                        <th class="text-center">الملغاة</th>
                        <th class="text-center">نسبة الإنجاز</th>
                        <th class="text-center">المسافة (كم)</th>
                        <th class="text-start">الإيرادات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($driverSummary as $index => $ds)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $ds->driver->name ?? 'غير معين' }}</strong>
                        </td>
                        <td class="text-center">{{ $ds->total_trips }}</td>
                        <td class="text-center text-success fw-bold">{{ $ds->completed_trips }}</td>
                        <td class="text-center text-danger">{{ $ds->cancelled_trips }}</td>
                        <td class="text-center">
                            @php $rate = $ds->total_trips > 0 ? ($ds->completed_trips / $ds->total_trips) * 100 : 0; @endphp
                            <span class="badge {{ $rate >= 80 ? 'bg-success' : ($rate >= 50 ? 'bg-warning' : 'bg-danger') }}">
                                {{ number_format($rate, 1) }}%
                            </span>
                        </td>
                        <td class="text-center">{{ number_format($ds->total_distance, 1) }}</td>
                        <td class="text-start fw-bold text-primary">{{ number_format($ds->total_revenue, 2) }} ر.س</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-dark">
                    <tr>
                        <td colspan="2"><strong>الإجمالي</strong></td>
                        <td class="text-center">{{ $driverSummary->sum('total_trips') }}</td>
                        <td class="text-center">{{ $driverSummary->sum('completed_trips') }}</td>
                        <td class="text-center">{{ $driverSummary->sum('cancelled_trips') }}</td>
                        <td class="text-center">-</td>
                        <td class="text-center">{{ number_format($driverSummary->sum('total_distance'), 1) }}</td>
                        <td class="text-start">{{ number_format($driverSummary->sum('total_revenue'), 2) }} ر.س</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <div class="text-center text-muted py-5">
            <i class="fas fa-user-slash fa-4x mb-3"></i>
            <p>لا توجد بيانات سائقين في هذه الفترة</p>
        </div>
        @endif
    </div>
</div>

<!-- Trips Detail Table -->
<div class="card">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="fas fa-list me-2"></i>تفاصيل الرحلات</h6>
        <span class="badge bg-light text-dark">{{ $trips->count() }} رحلة</span>
    </div>
    <div class="card-body">
        @if($trips->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover" id="example1">
                <thead class="table-light">
                    <tr>
                        <th>رقم الرحلة</th>
                        <th>التاريخ</th>
                        <th>العميل</th>
                        <th>السائق</th>
                        <th>المركبة</th>
                        <th class="text-center">المسافة</th>
                        <th>طريقة الدفع</th>
                        <th>الحالة</th>
                        <th class="text-start">المبلغ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trips as $trip)
                    <tr>
                        <td><code>{{ $trip->trip_number }}</code></td>
                        <td>{{ $trip->requested_at?->format('Y-m-d H:i') }}</td>
                        <td>
                            <strong>{{ $trip->client_name }}</strong>
                            @if($trip->client_phone)
                            <br><small class="text-muted">{{ $trip->client_phone }}</small>
                            @endif
                        </td>
                        <td>{{ $trip->driver->name ?? '-' }}</td>
                        <td>{{ $trip->vehicle->plate_number ?? '-' }}</td>
                        <td class="text-center">{{ $trip->distance_km ? number_format($trip->distance_km, 1) . ' كم' : '-' }}</td>
                        <td>{{ $trip->paymentMethod->name ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $trip->status_color }}">{{ $trip->status_label }}</span>
                        </td>
                        <td class="text-start fw-bold {{ $trip->status == 'completed' ? 'text-success' : 'text-muted' }}">
                            {{ $trip->total_fare ? number_format($trip->total_fare, 2) . ' ر.س' : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center text-muted py-5">
            <i class="fas fa-route fa-4x mb-3"></i>
            <p>لا توجد رحلات في الفترة المحددة</p>
        </div>
        @endif
    </div>
</div>
@endsection

