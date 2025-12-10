@extends('layouts.master')
@section('title', 'الملخص المالي')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">الملخص المالي</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="#">التقارير المالية</a></li>
                <li class="breadcrumb-item active" aria-current="page">الملخص المالي</li>
            </ol>
        </nav>
    </div>
    @permission('Print Financial Reports')
    <div>
        <a href="{{ route('reports.print.summary', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="btn btn-outline-primary">
            <i class="fas fa-print me-1"></i> طباعة
        </a>
    </div>
    @endpermission
</div>

<!-- Date Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.summary') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">من تاريخ</label>
                <input type="date" class="form-control" name="start_date" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">إلى تاريخ</label>
                <input type="date" class="form-control" name="end_date" value="{{ $endDate }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> عرض التقرير</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">إجمالي الأرصدة</h6>
                        <h3 class="mb-0">{{ number_format($totalBalance, 2) }} <small>ر.س</small></h3>
                    </div>
                    <div class="fs-1 opacity-50"><i class="fas fa-wallet"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">الإيرادات</h6>
                        <h3 class="mb-0">{{ number_format($totalIncome, 2) }} <small>ر.س</small></h3>
                    </div>
                    <div class="fs-1 opacity-50"><i class="fas fa-arrow-up"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">المصروفات</h6>
                        <h3 class="mb-0">{{ number_format($totalExpenses, 2) }} <small>ر.س</small></h3>
                    </div>
                    <div class="fs-1 opacity-50"><i class="fas fa-arrow-down"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="card {{ $netAmount >= 0 ? 'bg-info' : 'bg-warning' }} text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">صافي الربح/الخسارة</h6>
                        <h3 class="mb-0">{{ number_format($netAmount, 2) }} <small>ر.س</small></h3>
                    </div>
                    <div class="fs-1 opacity-50"><i class="fas fa-chart-line"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Account Balances -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-university me-2"></i>أرصدة الحسابات</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
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
                                <td><span class="badge bg-secondary">{{ $account->type }}</span></td>
                                <td class="{{ $account->balance >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                                    {{ number_format($account->balance, 2) }} {{ $account->currency }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-dark">
                                <td colspan="2"><strong>الإجمالي</strong></td>
                                <td><strong>{{ number_format($totalBalance, 2) }} ر.س</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Expense Categories -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-chart-pie me-2"></i>أعلى بنود الصرف</h5>
            </div>
            <div class="card-body">
                @if($topCategories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
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
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-danger" style="width: {{ $percent }}%">{{ number_format($percent, 1) }}%</div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center py-4">لا توجد مصروفات في هذه الفترة</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Monthly Trend -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0"><i class="fas fa-chart-bar me-2"></i>الاتجاه الشهري (آخر 6 أشهر)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>الشهر</th>
                        @foreach($monthlyTrend as $month)
                        <th>{{ $month['month'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-bold text-success">الإيرادات</td>
                        @foreach($monthlyTrend as $month)
                        <td class="text-success">{{ number_format($month['income'], 0) }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="fw-bold text-danger">المصروفات</td>
                        @foreach($monthlyTrend as $month)
                        <td class="text-danger">{{ number_format($month['expenses'], 0) }}</td>
                        @endforeach
                    </tr>
                    <tr class="table-light">
                        <td class="fw-bold">الصافي</td>
                        @foreach($monthlyTrend as $month)
                        <td class="{{ $month['net'] >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                            {{ number_format($month['net'], 0) }}
                        </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

