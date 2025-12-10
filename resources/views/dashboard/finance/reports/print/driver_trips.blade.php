@extends('layouts.print')
@section('title', 'تقرير رحلات السائقين المالي')
@section('content')

<div class="report-title">
    <h2>تقرير رحلات السائقين المالي</h2>
    <div class="date-range">للفترة من {{ $startDate }} إلى {{ $endDate }}</div>
    @if($selectedDriver)
    <div class="date-range">السائق: {{ $selectedDriver->name }}</div>
    @endif
</div>

<!-- Summary Cards -->
<div class="summary-cards">
    <div class="summary-card dark">
        <h4>{{ $totalTrips }}</h4>
        <p>إجمالي الرحلات</p>
    </div>
    <div class="summary-card">
        <h4>{{ $completedTrips }}</h4>
        <p>رحلات مكتملة</p>
    </div>
    <div class="summary-card">
        <h4>{{ $cancelledTrips }}</h4>
        <p>رحلات ملغاة</p>
    </div>
    <div class="summary-card dark">
        <h4>{{ number_format($totalRevenue, 2) }}</h4>
        <p>إجمالي الإيرادات (ر.س)</p>
    </div>
    <div class="summary-card">
        <h4>{{ number_format($avgFare, 2) }}</h4>
        <p>متوسط قيمة الرحلة</p>
    </div>
    <div class="summary-card">
        <h4>{{ number_format($totalDistance, 1) }}</h4>
        <p>إجمالي المسافة (كم)</p>
    </div>
</div>

<!-- Revenue Breakdown & Payment Methods -->
<div class="row">
    <div class="col-half">
        <div class="breakdown-box">
            <div class="header">تفاصيل الإيرادات</div>
            <div class="content">
                <div class="breakdown-row">
                    <span>الأجرة الأساسية</span>
                    <span>{{ number_format($baseFareTotal, 2) }} ر.س</span>
                </div>
                <div class="breakdown-row">
                    <span>أجرة المسافة</span>
                    <span>{{ number_format($distanceFareTotal, 2) }} ر.س</span>
                </div>
                <div class="breakdown-row">
                    <span>أجرة الانتظار</span>
                    <span>{{ number_format($waitFareTotal, 2) }} ر.س</span>
                </div>
                <div class="breakdown-row">
                    <span>إضافات</span>
                    <span>{{ number_format($extrasTotal, 2) }} ر.س</span>
                </div>
                <div class="breakdown-row">
                    <span>الخصومات</span>
                    <span>-{{ number_format($discountTotal, 2) }} ر.س</span>
                </div>
                <div class="breakdown-row">
                    <span>الضريبة (15%)</span>
                    <span>{{ number_format($taxTotal, 2) }} ر.س</span>
                </div>
                <div class="breakdown-row total">
                    <span>صافي الإيرادات</span>
                    <span>{{ number_format($totalRevenue, 2) }} ر.س</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-half">
        <div class="breakdown-box">
            <div class="header">حسب طريقة الدفع</div>
            <div class="content">
                @forelse($paymentMethodSummary as $pm)
                <div class="breakdown-row">
                    <span>{{ $pm->paymentMethod->name ?? 'غير محدد' }} ({{ $pm->trip_count }})</span>
                    <span>{{ number_format($pm->total_amount, 2) }} ر.س</span>
                </div>
                @empty
                <div style="text-align: center; padding: 15px; color: #666;">لا توجد بيانات</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Driver Summary -->
@if($driverSummary->count() > 0)
<div class="section-title">ملخص أداء السائقين</div>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>السائق</th>
            <th class="text-center">الرحلات</th>
            <th class="text-center">المكتملة</th>
            <th class="text-center">الملغاة</th>
            <th class="text-center">نسبة الإنجاز</th>
            <th class="text-center">المسافة (كم)</th>
            <th class="text-end">الإيرادات</th>
        </tr>
    </thead>
    <tbody>
        @foreach($driverSummary as $index => $ds)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td class="fw-bold">{{ $ds->driver->name ?? 'غير معين' }}</td>
            <td class="text-center">{{ $ds->total_trips }}</td>
            <td class="text-center">{{ $ds->completed_trips }}</td>
            <td class="text-center">{{ $ds->cancelled_trips }}</td>
            <td class="text-center">
                @php $rate = $ds->total_trips > 0 ? ($ds->completed_trips / $ds->total_trips) * 100 : 0; @endphp
                {{ number_format($rate, 1) }}%
            </td>
            <td class="text-center">{{ number_format($ds->total_distance, 1) }}</td>
            <td class="text-end fw-bold">{{ number_format($ds->total_revenue, 2) }} ر.س</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"><strong>الإجمالي</strong></td>
            <td class="text-center">{{ $driverSummary->sum('total_trips') }}</td>
            <td class="text-center">{{ $driverSummary->sum('completed_trips') }}</td>
            <td class="text-center">{{ $driverSummary->sum('cancelled_trips') }}</td>
            <td class="text-center">-</td>
            <td class="text-center">{{ number_format($driverSummary->sum('total_distance'), 1) }}</td>
            <td class="text-end">{{ number_format($driverSummary->sum('total_revenue'), 2) }} ر.س</td>
        </tr>
    </tfoot>
</table>
@endif

<!-- Trips Details -->
<div class="section-title">تفاصيل الرحلات ({{ $trips->count() }} رحلة)</div>
@if($trips->count() > 0)
<table>
    <thead>
        <tr>
            <th>رقم الرحلة</th>
            <th>التاريخ</th>
            <th>العميل</th>
            <th>السائق</th>
            <th class="text-center">المسافة</th>
            <th>طريقة الدفع</th>
            <th class="text-center">الحالة</th>
            <th class="text-end">المبلغ</th>
        </tr>
    </thead>
    <tbody>
        @foreach($trips as $trip)
        <tr>
            <td><code>{{ $trip->trip_number }}</code></td>
            <td>{{ $trip->requested_at?->format('m-d H:i') }}</td>
            <td>{{ $trip->client_name }}</td>
            <td>{{ $trip->driver->name ?? '-' }}</td>
            <td class="text-center">{{ $trip->distance_km ? number_format($trip->distance_km, 1) : '-' }}</td>
            <td>{{ $trip->paymentMethod->name ?? '-' }}</td>
            <td class="text-center">
                <span class="badge {{ $trip->status == 'completed' ? 'completed' : 'cancelled' }}">
                    {{ $trip->status == 'completed' ? 'مكتملة' : ($trip->status == 'cancelled' ? 'ملغاة' : $trip->status_label) }}
                </span>
            </td>
            <td class="text-end fw-bold">
                {{ $trip->total_fare ? number_format($trip->total_fare, 2) : '-' }}
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4"><strong>الإجمالي</strong></td>
            <td class="text-center">{{ number_format($trips->where('status', 'completed')->sum('distance_km'), 1) }} كم</td>
            <td colspan="2"></td>
            <td class="text-end"><strong>{{ number_format($trips->where('status', 'completed')->sum('total_fare'), 2) }} ر.س</strong></td>
        </tr>
    </tfoot>
</table>
@else
<div style="text-align: center; padding: 30px; border: 1px solid #000; background: #f5f5f5;">
    لا توجد رحلات في الفترة المحددة
</div>
@endif

@endsection
