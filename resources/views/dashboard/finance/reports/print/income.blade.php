@extends('layouts.print')
@section('title', 'تقرير الإيرادات')
@section('content')

<div class="report-title">
    <h2>تقرير الإيرادات</h2>
    <div class="date-range">للفترة من {{ $startDate }} إلى {{ $endDate }}</div>
</div>

<!-- Summary Cards -->
<div class="summary-cards">
    <div class="summary-card success">
        <h4>{{ number_format($totalAmount, 2) }}</h4>
        <p>إجمالي الإيرادات (ر.س)</p>
    </div>
    <div class="summary-card primary">
        <h4>{{ $incomes->count() }}</h4>
        <p>عدد العمليات</p>
    </div>
    <div class="summary-card info">
        <h4>{{ $sourceTotals->count() }}</h4>
        <p>مصادر الإيراد</p>
    </div>
</div>

<div class="row">
    <!-- Summary by Source -->
    <div class="col-4">
        <div class="section-title">ملخص حسب المصدر</div>
        <table>
            <thead>
                <tr>
                    <th>المصدر</th>
                    <th>العدد</th>
                    <th>المبلغ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sourceTotals as $src)
                <tr>
                    <td>
                        @switch($src->source)
                            @case('cash_deposit') إيداع نقدي @break
                            @case('bank_transfer') تحويل بنكي @break
                            @case('client_payment') دفعة من عميل @break
                            @case('trip_payment') دفعة رحلة @break
                            @case('owner_capital') رأس مال المالك @break
                            @case('loan') قرض @break
                            @case('refund') استرداد @break
                            @default {{ $src->source ?? 'أخرى' }}
                        @endswitch
                    </td>
                    <td class="text-center">{{ $src->count }}</td>
                    <td class="text-success fw-bold">{{ number_format($src->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><strong>الإجمالي</strong></td>
                    <td><strong>{{ number_format($totalAmount, 2) }} ر.س</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Income List -->
    <div class="col-8">
        <div class="section-title">قائمة الإيرادات</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>التاريخ</th>
                    <th>المصدر</th>
                    <th>الحساب</th>
                    <th>رقم المرجع</th>
                    <th>المبلغ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incomes as $index => $income)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $income->transaction_date->format('Y-m-d') }}</td>
                    <td>
                        @switch($income->source)
                            @case('cash_deposit') إيداع نقدي @break
                            @case('bank_transfer') تحويل بنكي @break
                            @case('client_payment') دفعة عميل @break
                            @case('trip_payment') دفعة رحلة @break
                            @case('owner_capital') رأس مال @break
                            @default {{ $income->source ?? 'أخرى' }}
                        @endswitch
                    </td>
                    <td>{{ $income->account->name ?? '-' }}</td>
                    <td>{{ $income->reference_number ?? '-' }}</td>
                    <td class="text-success fw-bold">+{{ number_format($income->amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5"><strong>الإجمالي</strong></td>
                    <td><strong>{{ number_format($totalAmount, 2) }} ر.س</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection

