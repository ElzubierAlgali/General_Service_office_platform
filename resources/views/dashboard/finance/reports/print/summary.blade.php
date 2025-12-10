@extends('layouts.print')
@section('title', 'الملخص المالي')
@section('content')

<div class="report-title">
    <h2>الملخص المالي</h2>
    <div class="date-range">للفترة من {{ $startDate }} إلى {{ $endDate }}</div>
</div>

<!-- Summary Cards -->
<div class="summary-cards">
    <div class="summary-card primary">
        <h4>{{ number_format($totalBalance, 2) }}</h4>
        <p>إجمالي الأرصدة (ر.س)</p>
    </div>
    <div class="summary-card success">
        <h4>{{ number_format($totalIncome, 2) }}</h4>
        <p>الإيرادات (ر.س)</p>
    </div>
    <div class="summary-card danger">
        <h4>{{ number_format($totalExpenses, 2) }}</h4>
        <p>المصروفات (ر.س)</p>
    </div>
    <div class="summary-card {{ $netAmount >= 0 ? 'info' : 'warning' }}">
        <h4>{{ number_format($netAmount, 2) }}</h4>
        <p>صافي الربح/الخسارة (ر.س)</p>
    </div>
</div>

<div class="row">
    <!-- Account Balances -->
    <div class="col-6">
        <div class="section-title">أرصدة الحسابات</div>
        <table>
            <thead>
                <tr>
                    <th>الحساب</th>
                    <th>النوع</th>
                    <th>الرصيد</th>
                </tr>
            </thead>
            <tbody>
                @foreach($accounts as $account)
                <tr>
                    <td>{{ $account->name }}</td>
                    <td>{{ $account->type }}</td>
                    <td class="{{ $account->balance >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                        {{ number_format($account->balance, 2) }} {{ $account->currency }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><strong>الإجمالي</strong></td>
                    <td><strong>{{ number_format($totalBalance, 2) }} ر.س</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Top Expense Categories -->
    <div class="col-6">
        <div class="section-title">أعلى بنود الصرف</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>البند</th>
                    <th>المبلغ</th>
                    <th>النسبة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topCategories as $index => $cat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $cat->category->name ?? 'غير مصنف' }}</td>
                    <td class="text-danger">{{ number_format($cat->total, 2) }} ر.س</td>
                    <td>
                        @php $percent = $totalExpenses > 0 ? ($cat->total / $totalExpenses) * 100 : 0; @endphp
                        {{ number_format($percent, 1) }}%
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Monthly Trend -->
<div class="section-title">الاتجاه الشهري (آخر 6 أشهر)</div>
<table>
    <thead>
        <tr>
            <th>البيان</th>
            @foreach($monthlyTrend as $month)
            <th class="text-center">{{ $month['month'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="fw-bold">الإيرادات</td>
            @foreach($monthlyTrend as $month)
            <td class="text-center text-success">{{ number_format($month['income'], 0) }}</td>
            @endforeach
        </tr>
        <tr>
            <td class="fw-bold">المصروفات</td>
            @foreach($monthlyTrend as $month)
            <td class="text-center text-danger">{{ number_format($month['expenses'], 0) }}</td>
            @endforeach
        </tr>
        <tr>
            <td class="fw-bold">الصافي</td>
            @foreach($monthlyTrend as $month)
            <td class="text-center {{ $month['net'] >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                {{ number_format($month['net'], 0) }}
            </td>
            @endforeach
        </tr>
    </tbody>
</table>

@endsection

