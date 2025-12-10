@extends('layouts.master')
@section('title', 'قائمة الدخل')
@section('content')

<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">قائمة الدخل</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('reports.summary') }}">التقارير المالية</a></li>
                <li class="breadcrumb-item active" aria-current="page">قائمة الدخل</li>
            </ol>
        </nav>
    </div>
    @permission('Print Financial Reports')
    <div>
        <a href="{{ route('reports.print.income_statement', ['period' => $periodType, 'start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="btn btn-outline-primary">
            <i class="fas fa-print me-1"></i> طباعة
        </a>
    </div>
    @endpermission
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label">الفترة</label>
                <select name="period" class="form-select select2" data-placeholder="-- اختر الفترة --" onchange="toggleDateInputs(this.value)">
                    <option value="custom" {{ $periodType == 'custom' ? 'selected' : '' }}>فترة مخصصة</option>
                    <option value="monthly" {{ $periodType == 'monthly' ? 'selected' : '' }}>الشهر الحالي</option>
                    <option value="quarterly" {{ $periodType == 'quarterly' ? 'selected' : '' }}>الربع الحالي</option>
                    <option value="yearly" {{ $periodType == 'yearly' ? 'selected' : '' }}>السنة الحالية</option>
                </select>
            </div>
            <div class="col-md-2" id="startDateDiv">
                <label class="form-label">من تاريخ</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-2" id="endDateDiv">
                <label class="form-label">إلى تاريخ</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> عرض التقرير
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="mb-1">إجمالي الإيرادات</h6>
                        <h3 class="mb-0">{{ number_format($totalRevenue, 2) }}</h3>
                    </div>
                    <div class="align-self-center">
                        @if($revenueChange >= 0)
                        <span class="badge bg-white text-success"><i class="fas fa-arrow-up"></i> {{ number_format(abs($revenueChange), 1) }}%</span>
                        @else
                        <span class="badge bg-white text-danger"><i class="fas fa-arrow-down"></i> {{ number_format(abs($revenueChange), 1) }}%</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="mb-1">إجمالي المصروفات</h6>
                        <h3 class="mb-0">{{ number_format($totalExpenses, 2) }}</h3>
                    </div>
                    <div class="align-self-center">
                        @if($expenseChange <= 0)
                        <span class="badge bg-white text-success"><i class="fas fa-arrow-down"></i> {{ number_format(abs($expenseChange), 1) }}%</span>
                        @else
                        <span class="badge bg-white text-danger"><i class="fas fa-arrow-up"></i> {{ number_format(abs($expenseChange), 1) }}%</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="mb-1">مجمل الربح</h6>
                        <h3 class="mb-0">{{ number_format($grossProfit, 2) }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chart-line fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm {{ $netIncome >= 0 ? 'bg-primary' : 'bg-warning' }} text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="mb-1">صافي الدخل</h6>
                        <h3 class="mb-0">{{ number_format($netIncome, 2) }}</h3>
                    </div>
                    <div class="align-self-center">
                        @if($netIncomeChange >= 0)
                        <span class="badge bg-white text-success"><i class="fas fa-arrow-up"></i> {{ number_format(abs($netIncomeChange), 1) }}%</span>
                        @else
                        <span class="badge bg-white text-danger"><i class="fas fa-arrow-down"></i> {{ number_format(abs($netIncomeChange), 1) }}%</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Income Statement Table -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-file-invoice-dollar me-2"></i>قائمة الدخل</h5>
                <small>للفترة من {{ $startDate }} إلى {{ $endDate }}</small>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <!-- REVENUES -->
                        <tr class="table-success">
                            <th colspan="2" class="fw-bold">الإيرادات</th>
                        </tr>
                        @foreach($incomeBySource as $income)
                        <tr>
                            <td class="ps-4">
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
                        <tr class="table-light fw-bold">
                            <td>إجمالي الإيرادات</td>
                            <td class="text-end text-success">{{ number_format($totalRevenue, 2) }}</td>
                        </tr>

                        <!-- OPERATING EXPENSES -->
                        <tr class="table-danger">
                            <th colspan="2" class="fw-bold">مصروفات التشغيل</th>
                        </tr>
                        @foreach($operatingExpenses as $expense)
                        <tr>
                            <td class="ps-4">{{ $expense->category->name ?? 'أخرى' }}</td>
                            <td class="text-end">({{ number_format($expense->total, 2) }})</td>
                        </tr>
                        @endforeach
                        <tr class="table-light fw-bold">
                            <td>إجمالي مصروفات التشغيل</td>
                            <td class="text-end text-danger">({{ number_format($totalOperatingExpenses, 2) }})</td>
                        </tr>

                        <!-- GROSS PROFIT -->
                        <tr class="table-info fw-bold">
                            <td>مجمل الربح</td>
                            <td class="text-end {{ $grossProfit >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($grossProfit, 2) }}
                            </td>
                        </tr>

                        <!-- ADMINISTRATIVE EXPENSES -->
                        <tr class="table-warning">
                            <th colspan="2" class="fw-bold">المصروفات الإدارية والعمومية</th>
                        </tr>
                        @foreach($adminExpenses as $expense)
                        <tr>
                            <td class="ps-4">{{ $expense->category->name ?? 'أخرى' }}</td>
                            <td class="text-end">({{ number_format($expense->total, 2) }})</td>
                        </tr>
                        @endforeach
                        @if($otherExpenses > 0)
                        <tr>
                            <td class="ps-4">مصروفات أخرى</td>
                            <td class="text-end">({{ number_format($otherExpenses, 2) }})</td>
                        </tr>
                        @endif
                        <tr class="table-light fw-bold">
                            <td>إجمالي المصروفات الإدارية</td>
                            <td class="text-end text-danger">({{ number_format($totalAdminExpenses + $otherExpenses, 2) }})</td>
                        </tr>

                        <!-- NET INCOME BEFORE TAX -->
                        <tr class="table-secondary fw-bold">
                            <td>صافي الدخل قبل الضريبة</td>
                            <td class="text-end {{ $netIncome >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($netIncome, 2) }}
                            </td>
                        </tr>

                        <!-- TAXES -->
                        @if($totalTaxes > 0)
                        <tr>
                            <td class="ps-4">الضرائب المدفوعة</td>
                            <td class="text-end">({{ number_format($totalTaxes, 2) }})</td>
                        </tr>
                        @endif

                        <!-- NET INCOME AFTER TAX -->
                        <tr class="table-primary fw-bold fs-5">
                            <td>صافي الدخل</td>
                            <td class="text-end {{ $netIncomeAfterTax >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($netIncomeAfterTax, 2) }} ر.س
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Charts & Comparisons -->
    <div class="col-lg-4">
        <!-- Period Comparison -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent">
                <h6 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>مقارنة بالفترة السابقة</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>الإيرادات</span>
                        <span class="{{ $revenueChange >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $revenueChange >= 0 ? '+' : '' }}{{ number_format($revenueChange, 1) }}%
                        </span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ min(abs($revenueChange), 100) }}%"></div>
                    </div>
                    <small class="text-muted">السابق: {{ number_format($prevRevenue, 2) }}</small>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>المصروفات</span>
                        <span class="{{ $expenseChange <= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $expenseChange >= 0 ? '+' : '' }}{{ number_format($expenseChange, 1) }}%
                        </span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-danger" style="width: {{ min(abs($expenseChange), 100) }}%"></div>
                    </div>
                    <small class="text-muted">السابق: {{ number_format($prevExpenses, 2) }}</small>
                </div>
                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>صافي الدخل</span>
                        <span class="{{ $netIncomeChange >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $netIncomeChange >= 0 ? '+' : '' }}{{ number_format($netIncomeChange, 1) }}%
                        </span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: {{ min(abs($netIncomeChange), 100) }}%"></div>
                    </div>
                    <small class="text-muted">السابق: {{ number_format($prevNetIncome, 2) }}</small>
                </div>
            </div>
        </div>

        <!-- Monthly Chart -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent">
                <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>الأداء الشهري</h6>
            </div>
            <div class="card-body">
                <canvas id="monthlyChart" height="200"></canvas>
            </div>
        </div>

        <!-- Expense Distribution -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent">
                <h6 class="mb-0"><i class="fas fa-chart-pie me-2"></i>توزيع المصروفات</h6>
            </div>
            <div class="card-body">
                @foreach($expensesByCategory->take(5) as $cat)
                @php $percentage = $totalExpenses > 0 ? ($cat->total / $totalExpenses) * 100 : 0; @endphp
                <div class="mb-2">
                    <div class="d-flex justify-content-between mb-1">
                        <small>{{ $cat->category->name ?? 'أخرى' }}</small>
                        <small>{{ number_format($percentage, 1) }}%</small>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Chart
    const monthlyData = @json($monthlyBreakdown);
    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: monthlyData.map(m => m.month_short),
            datasets: [{
                label: 'الإيرادات',
                data: monthlyData.map(m => m.income),
                backgroundColor: 'rgba(40, 167, 69, 0.7)',
            }, {
                label: 'المصروفات',
                data: monthlyData.map(m => m.expenses),
                backgroundColor: 'rgba(220, 53, 69, 0.7)',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    function toggleDateInputs(value) {
        const startDiv = document.getElementById('startDateDiv');
        const endDiv = document.getElementById('endDateDiv');
        if (value === 'custom') {
            startDiv.style.display = 'block';
            endDiv.style.display = 'block';
        } else {
            startDiv.style.display = 'none';
            endDiv.style.display = 'none';
        }
    }
</script>
@endsection

