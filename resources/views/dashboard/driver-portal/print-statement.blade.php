@extends('layouts.print')

@section('title', 'كشف حساب السائق')

@section('content')
<div class="report-title">
    <h2>كشف حساب رحلات السائق</h2>
    <div class="date-range">{{ $driver->name ?? $driver->name_en }} | للفترة من {{ $startDate }} إلى {{ $endDate }}</div>
</div>

<div class="report-meta" style="margin-bottom: 15px; display: flex; justify-content: space-between; border: 1px solid #000; padding: 10px;">
    <div>
        <strong>السائق:</strong> {{ $driver->name ?? $driver->name_en }}
    </div>
    <div>
        <strong>رقم الهوية:</strong> {{ $driver->id_number ?? '-' }}
    </div>
    <div>
        <strong>رقم الجوال:</strong> {{ $driver->phone ?? '-' }}
    </div>
</div>

<!-- Summary -->
<div class="summary-cards">
    <div class="summary-card dark">
        <h4>{{ $stats['total_trips'] }}</h4>
        <p>إجمالي الرحلات</p>
    </div>
    <div class="summary-card">
        <h4>{{ number_format($stats['total_distance'], 1) }} كم</h4>
        <p>المسافة المقطوعة</p>
    </div>
    <div class="summary-card">
        <h4>{{ \App\Models\Trip::formatDuration($stats['total_duration']) }}</h4>
        <p>إجمالي الوقت</p>
    </div>
    <div class="summary-card dark">
        <h4>{{ number_format($stats['total_earnings'], 2) }} ر.س</h4>
        <p>إجمالي الإيرادات</p>
    </div>
</div>

<!-- Trips Table -->
<div class="section-title">تفاصيل الرحلات المكتملة</div>

<table>
    <thead>
        <tr>
            <th style="width: 5%;">#</th>
            <th style="width: 12%;">التاريخ</th>
            <th style="width: 15%;">رقم الرحلة</th>
            <th style="width: 15%;">العميل</th>
            <th style="width: 18%;">المسار</th>
            <th style="width: 8%;">المسافة</th>
            <th style="width: 10%;">المدة</th>
            <th style="width: 10%;">الدفع</th>
            <th style="width: 12%;">المبلغ</th>
        </tr>
    </thead>
    <tbody>
        @php $totalAmount = 0; @endphp
        @forelse($trips as $index => $trip)
        @php $totalAmount += $trip->total_fare; @endphp
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>
                {{ $trip->requested_at->format('Y-m-d') }}
                <br>
                <small>{{ $trip->requested_at->format('H:i') }}</small>
            </td>
            <td>{{ $trip->trip_number }}</td>
            <td>{{ Str::limit($trip->client_name, 12) }}</td>
            <td style="font-size: 10px;">
                <div>من: {{ Str::limit($trip->pickup_location, 20) }}</div>
                <div>إلى: {{ Str::limit($trip->dropoff_location, 20) }}</div>
            </td>
            <td>{{ $trip->distance_km ? number_format($trip->distance_km, 1) : '-' }}</td>
            <td>{{ $trip->trip_duration ? \App\Models\Trip::formatDuration($trip->trip_duration) : '-' }}</td>
            <td>{{ $trip->paymentMethod->name ?? '-' }}</td>
            <td class="fw-bold">{{ number_format($trip->total_fare, 2) }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="9" style="text-align: center; padding: 30px;">
                لا توجد رحلات مكتملة في هذه الفترة
            </td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5"><strong>الإجمالي</strong></td>
            <td><strong>{{ number_format($trips->sum('distance_km'), 1) }} كم</strong></td>
            <td><strong>{{ \App\Models\Trip::formatDuration($trips->sum('trip_duration')) }}</strong></td>
            <td><strong>{{ $trips->count() }} رحلة</strong></td>
            <td class="fw-bold">{{ number_format($totalAmount, 2) }} ر.س</td>
        </tr>
    </tfoot>
</table>

<div style="margin-top: 20px; padding: 12px; background: #f5f5f5; border: 1px solid #000; font-size: 10px;">
    <strong>ملاحظات:</strong>
    <ul style="margin: 5px 0 0 0; padding-right: 20px;">
        <li>هذا الكشف يشمل الرحلات المكتملة فقط خلال الفترة المحددة</li>
        <li>المبالغ المذكورة شاملة جميع الرسوم والضرائب</li>
        <li>في حالة وجود أي استفسار يرجى التواصل مع قسم العمليات</li>
    </ul>
</div>
@endsection

@section('signatures')
<div class="signatures">
    <div class="signature-box">
        <div class="signature-line">توقيع السائق</div>
    </div>
    <div class="signature-box">
        <div class="signature-line">توقيع المسؤول</div>
    </div>
    <div class="signature-box">
        <div class="signature-line">ختم الشركة</div>
    </div>
</div>
@endsection
