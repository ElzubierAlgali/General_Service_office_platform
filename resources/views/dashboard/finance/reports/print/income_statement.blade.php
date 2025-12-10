@extends('layouts.print')
@section('title', 'قائمة الدخل')
@section('content')

<div class="report-title">
    <h2>قائمة الدخل</h2>
    <div class="date-range">للفترة من {{ $startDate }} إلى {{ $endDate }}</div>
</div>

<!-- Summary Cards -->
<div class="summary-cards">
    <div class="summary-card">
        <h4>{{ number_format($totalRevenue, 2) }}</h4>
        <p>إجمالي الإيرادات</p>
    </div>
    <div class="summary-card">
        <h4>{{ number_format($totalExpenses, 2) }}</h4>
        <p>إجمالي المصروفات</p>
    </div>
    <div class="summary-card dark">
        <h4>{{ number_format($grossProfit, 2) }}</h4>
        <p>مجمل الربح</p>
    </div>
    <div class="summary-card dark">
        <h4>{{ number_format($netIncome, 2) }}</h4>
        <p>صافي الدخل</p>
    </div>
</div>

<div class="row">
    <!-- Income Statement Table -->
    <div class="col-8">
        <div class="section-title">قائمة الدخل التفصيلية</div>
        <table>
            <tbody>
                <!-- REVENUES -->
                <tr class="section-header">
                    <th colspan="2">الإيرادات</th>
                </tr>
                @foreach($incomeBySource as $income)
                <tr>
                    <td class="indent-1">
                        @switch($income->source)
                            @case('deposit') إيداع مالي @break
                            @case('trip_payment') إيرادات الرحلات @break
                            @case('tip') إكراميات @break
                            @case('refund') مردودات @break
                            @default {{ $income->source ?? 'أخرى' }}
                        @endswitch
                    </td>
                    <td class="text-end">{{ number_format($income->total, 2) }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td>إجمالي الإيرادات</td>
                    <td class="text-end fw-bold">{{ number_format($totalRevenue, 2) }}</td>
                </tr>

                <!-- OPERATING EXPENSES -->
                <tr class="section-header">
                    <th colspan="2">مصروفات التشغيل</th>
                </tr>
                @foreach($operatingExpenses as $expense)
                <tr>
                    <td class="indent-1">{{ $expense->category->name ?? 'أخرى' }}</td>
                    <td class="text-end">({{ number_format($expense->total, 2) }})</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td>إجمالي مصروفات التشغيل</td>
                    <td class="text-end fw-bold">({{ number_format($totalOperatingExpenses, 2) }})</td>
                </tr>

                <!-- GROSS PROFIT -->
                <tr class="sub-section">
                    <td class="fw-bold">مجمل الربح</td>
                    <td class="text-end fw-bold">
                        {{ number_format($grossProfit, 2) }}
                    </td>
                </tr>

                <!-- ADMINISTRATIVE EXPENSES -->
                <tr class="section-header">
                    <th colspan="2">المصروفات الإدارية والعمومية</th>
                </tr>
                @foreach($adminExpenses as $expense)
                <tr>
                    <td class="indent-1">{{ $expense->category->name ?? 'أخرى' }}</td>
                    <td class="text-end">({{ number_format($expense->total, 2) }})</td>
                </tr>
                @endforeach
                @if($otherExpenses > 0)
                <tr>
                    <td class="indent-1">مصروفات أخرى</td>
                    <td class="text-end">({{ number_format($otherExpenses, 2) }})</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td>إجمالي المصروفات الإدارية</td>
                    <td class="text-end fw-bold">({{ number_format($totalAdminExpenses + $otherExpenses, 2) }})</td>
                </tr>

                <!-- NET INCOME BEFORE TAX -->
                <tr class="sub-section">
                    <td class="fw-bold">صافي الدخل قبل الضريبة</td>
                    <td class="text-end fw-bold">
                        {{ number_format($netIncome, 2) }}
                    </td>
                </tr>

                <!-- TAXES -->
                @if($totalTaxes > 0)
                <tr>
                    <td class="indent-1">الضرائب المدفوعة</td>
                    <td class="text-end">({{ number_format($totalTaxes, 2) }})</td>
                </tr>
                @endif

                <!-- NET INCOME AFTER TAX -->
                <tr class="grand-total">
                    <td>صافي الدخل</td>
                    <td class="text-end">
                        {{ number_format($netIncomeAfterTax, 2) }} ر.س
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Comparison -->
    <div class="col-4">
        <div class="section-title">مقارنة بالفترة السابقة</div>
        <table>
            <thead>
                <tr>
                    <th>البيان</th>
                    <th>الحالي</th>
                    <th>السابق</th>
                    <th>التغير</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>الإيرادات</td>
                    <td>{{ number_format($totalRevenue, 0) }}</td>
                    <td>{{ number_format($prevRevenue, 0) }}</td>
                    <td>
                        {{ $revenueChange >= 0 ? '+' : '' }}{{ number_format($revenueChange, 1) }}%
                    </td>
                </tr>
                <tr>
                    <td>المصروفات</td>
                    <td>{{ number_format($totalExpenses, 0) }}</td>
                    <td>{{ number_format($prevExpenses, 0) }}</td>
                    <td>
                        {{ $expenseChange >= 0 ? '+' : '' }}{{ number_format($expenseChange, 1) }}%
                    </td>
                </tr>
                <tr>
                    <td>صافي الدخل</td>
                    <td>{{ number_format($netIncome, 0) }}</td>
                    <td>{{ number_format($prevNetIncome, 0) }}</td>
                    <td>
                        {{ $netIncomeChange >= 0 ? '+' : '' }}{{ number_format($netIncomeChange, 1) }}%
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">توزيع المصروفات</div>
        <table>
            <thead>
                <tr>
                    <th>التصنيف</th>
                    <th>المبلغ</th>
                    <th>النسبة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expensesByCategory->take(5) as $cat)
                @php $percentage = $totalExpenses > 0 ? ($cat->total / $totalExpenses) * 100 : 0; @endphp
                <tr>
                    <td>{{ $cat->category->name ?? 'أخرى' }}</td>
                    <td>{{ number_format($cat->total, 0) }}</td>
                    <td>{{ number_format($percentage, 1) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
