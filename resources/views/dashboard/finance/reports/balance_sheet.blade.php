@extends('layouts.master')
@section('title', 'الميزانية العمومية')
@section('content')

<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">الميزانية العمومية</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('reports.summary') }}">التقارير المالية</a></li>
                <li class="breadcrumb-item active" aria-current="page">الميزانية العمومية</li>
            </ol>
        </nav>
    </div>
    @permission('Print Financial Reports')
    <div>
        <a href="{{ route('reports.print.balance_sheet', ['as_of_date' => $asOfDate]) }}" target="_blank" class="btn btn-outline-primary">
            <i class="fas fa-print me-1"></i> طباعة
        </a>
    </div>
    @endpermission
</div>

<!-- Date Filter -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">كما في تاريخ</label>
                <input type="date" name="as_of_date" class="form-control" value="{{ $asOfDate }}">
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
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-coins fa-2x mb-2"></i>
                <h6>إجمالي الأصول</h6>
                <h2 class="mb-0">{{ number_format($totalCurrentAssets, 2) }}</h2>
                <small>ريال سعودي</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-danger text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-file-invoice fa-2x mb-2"></i>
                <h6>إجمالي الالتزامات</h6>
                <h2 class="mb-0">{{ number_format($totalCurrentLiabilities, 2) }}</h2>
                <small>ريال سعودي</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white h-100">
            <div class="card-body text-center">
                <i class="fas fa-landmark fa-2x mb-2"></i>
                <h6>حقوق الملكية</h6>
                <h2 class="mb-0">{{ number_format($totalEquity, 2) }}</h2>
                <small>ريال سعودي</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Balance Sheet Table -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-balance-scale me-2"></i>الميزانية العمومية</h5>
                <small>كما في {{ $asOfDate }}</small>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <tbody>
                        <!-- ASSETS SECTION -->
                        <tr class="table-success">
                            <th colspan="2" class="fw-bold fs-5">
                                <i class="fas fa-coins me-2"></i>الأصول
                            </th>
                        </tr>
                        
                        <!-- Current Assets -->
                        <tr class="table-light">
                            <th colspan="2" class="ps-3">الأصول المتداولة</th>
                        </tr>
                        
                        <!-- Cash -->
                        <tr>
                            <td class="ps-4">
                                <i class="fas fa-money-bill-wave text-success me-2"></i>النقدية
                            </td>
                            <td class="text-end">{{ number_format($totalCash, 2) }}</td>
                        </tr>
                        @foreach($cashAccounts as $account)
                        <tr class="text-muted small">
                            <td class="ps-5">- {{ $account->name }}</td>
                            <td class="text-end">{{ number_format($account->balance, 2) }}</td>
                        </tr>
                        @endforeach
                        
                        <!-- Bank Accounts -->
                        <tr>
                            <td class="ps-4">
                                <i class="fas fa-university text-primary me-2"></i>الحسابات البنكية
                            </td>
                            <td class="text-end">{{ number_format($totalBank, 2) }}</td>
                        </tr>
                        @foreach($bankAccounts as $account)
                        <tr class="text-muted small">
                            <td class="ps-5">- {{ $account->name }}</td>
                            <td class="text-end">{{ number_format($account->balance, 2) }}</td>
                        </tr>
                        @endforeach
                        
                        <!-- Wallets -->
                        @if($totalWallet > 0)
                        <tr>
                            <td class="ps-4">
                                <i class="fas fa-wallet text-info me-2"></i>المحافظ الإلكترونية
                            </td>
                            <td class="text-end">{{ number_format($totalWallet, 2) }}</td>
                        </tr>
                        @foreach($walletAccounts as $account)
                        <tr class="text-muted small">
                            <td class="ps-5">- {{ $account->name }}</td>
                            <td class="text-end">{{ number_format($account->balance, 2) }}</td>
                        </tr>
                        @endforeach
                        @endif
                        
                        <!-- Receivables -->
                        @if($pendingIncome > 0)
                        <tr>
                            <td class="ps-4">
                                <i class="fas fa-hand-holding-usd text-warning me-2"></i>ذمم مدينة (إيرادات معلقة)
                            </td>
                            <td class="text-end">{{ number_format($pendingIncome, 2) }}</td>
                        </tr>
                        @endif
                        
                        <!-- Total Current Assets -->
                        <tr class="table-success fw-bold">
                            <td>إجمالي الأصول المتداولة</td>
                            <td class="text-end">{{ number_format($totalCurrentAssets, 2) }}</td>
                        </tr>
                        
                        <!-- TOTAL ASSETS -->
                        <tr class="table-dark text-white fw-bold fs-5">
                            <td>إجمالي الأصول</td>
                            <td class="text-end">{{ number_format($totalCurrentAssets, 2) }} ر.س</td>
                        </tr>
                        
                        <!-- Separator -->
                        <tr><td colspan="2" class="bg-white py-3"></td></tr>
                        
                        <!-- LIABILITIES SECTION -->
                        <tr class="table-danger">
                            <th colspan="2" class="fw-bold fs-5">
                                <i class="fas fa-file-invoice me-2"></i>الالتزامات
                            </th>
                        </tr>
                        
                        <!-- Current Liabilities -->
                        <tr class="table-light">
                            <th colspan="2" class="ps-3">الالتزامات المتداولة</th>
                        </tr>
                        
                        @if($pendingExpenses > 0)
                        <tr>
                            <td class="ps-4">
                                <i class="fas fa-file-invoice-dollar text-danger me-2"></i>ذمم دائنة (مصروفات مستحقة)
                            </td>
                            <td class="text-end">{{ number_format($pendingExpenses, 2) }}</td>
                        </tr>
                        @endif
                        
                        <!-- Total Current Liabilities -->
                        <tr class="table-danger fw-bold">
                            <td>إجمالي الالتزامات المتداولة</td>
                            <td class="text-end">{{ number_format($totalCurrentLiabilities, 2) }}</td>
                        </tr>
                        
                        <!-- TOTAL LIABILITIES -->
                        <tr class="table-dark text-white fw-bold fs-5">
                            <td>إجمالي الالتزامات</td>
                            <td class="text-end">{{ number_format($totalCurrentLiabilities, 2) }} ر.س</td>
                        </tr>
                        
                        <!-- Separator -->
                        <tr><td colspan="2" class="bg-white py-3"></td></tr>
                        
                        <!-- EQUITY SECTION -->
                        <tr class="table-primary">
                            <th colspan="2" class="fw-bold fs-5">
                                <i class="fas fa-landmark me-2"></i>حقوق الملكية
                            </th>
                        </tr>
                        
                        <tr>
                            <td class="ps-4">
                                <i class="fas fa-chart-line text-success me-2"></i>الأرباح المحتجزة
                            </td>
                            <td class="text-end {{ $retainedEarnings >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($retainedEarnings, 2) }}
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="ps-5 text-muted small">
                                - صافي دخل الفترة الحالية
                            </td>
                            <td class="text-end text-muted small {{ $currentPeriodNetIncome >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($currentPeriodNetIncome, 2) }}
                            </td>
                        </tr>
                        
                        <!-- TOTAL EQUITY -->
                        <tr class="table-primary fw-bold">
                            <td>إجمالي حقوق الملكية</td>
                            <td class="text-end">{{ number_format($totalEquity, 2) }}</td>
                        </tr>
                        
                        <!-- TOTAL LIABILITIES + EQUITY -->
                        <tr class="table-dark text-white fw-bold fs-5">
                            <td>إجمالي الالتزامات وحقوق الملكية</td>
                            <td class="text-end">{{ number_format($totalLiabilitiesAndEquity, 2) }} ر.س</td>
                        </tr>
                        
                        <!-- Balance Check -->
                        @php $difference = $totalCurrentAssets - $totalLiabilitiesAndEquity; @endphp
                        @if(abs($difference) > 0.01)
                        <tr class="table-warning">
                            <td colspan="2" class="text-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                فرق الميزانية: {{ number_format($difference, 2) }} ر.س
                            </td>
                        </tr>
                        @else
                        <tr class="table-success">
                            <td colspan="2" class="text-center text-success">
                                <i class="fas fa-check-circle me-2"></i>
                                الميزانية متوازنة ✓
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Side Panel -->
    <div class="col-lg-4">
        <!-- Assets Distribution -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent">
                <h6 class="mb-0"><i class="fas fa-chart-pie me-2"></i>توزيع الأصول</h6>
            </div>
            <div class="card-body">
                <canvas id="assetsChart" height="200"></canvas>
            </div>
        </div>
        
        <!-- Accounts Summary -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent">
                <h6 class="mb-0"><i class="fas fa-wallet me-2"></i>ملخص الحسابات</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($allAccounts as $account)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-{{ $account->type == 'cash' ? 'money-bill' : ($account->type == 'bank' ? 'university' : 'wallet') }} me-2 text-primary"></i>
                            {{ $account->name }}
                            <br>
                            <small class="text-muted">
                                @switch($account->type)
                                    @case('cash') نقدي @break
                                    @case('bank') بنكي @break
                                    @case('wallet') محفظة @break
                                    @default {{ $account->type }}
                                @endswitch
                            </small>
                        </div>
                        <span class="badge bg-{{ $account->balance >= 0 ? 'success' : 'danger' }} rounded-pill">
                            {{ number_format($account->balance, 2) }}
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between fw-bold">
                    <span>الإجمالي</span>
                    <span class="text-primary">{{ number_format($totalAccountsBalance, 2) }} ر.س</span>
                </div>
            </div>
        </div>
        
        <!-- Financial Ratios -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent">
                <h6 class="mb-0"><i class="fas fa-calculator me-2"></i>مؤشرات مالية</h6>
            </div>
            <div class="card-body">
                @php
                    $currentRatio = $totalCurrentLiabilities > 0 ? $totalCurrentAssets / $totalCurrentLiabilities : 0;
                    $debtToEquity = $totalEquity != 0 ? $totalCurrentLiabilities / abs($totalEquity) : 0;
                @endphp
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>نسبة التداول</span>
                        <span class="fw-bold {{ $currentRatio >= 1 ? 'text-success' : 'text-danger' }}">
                            {{ number_format($currentRatio, 2) }}
                        </span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar {{ $currentRatio >= 1 ? 'bg-success' : 'bg-danger' }}" 
                             style="width: {{ min($currentRatio * 50, 100) }}%"></div>
                    </div>
                    <small class="text-muted">الأصول المتداولة / الالتزامات المتداولة</small>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>نسبة الدين إلى حقوق الملكية</span>
                        <span class="fw-bold {{ $debtToEquity <= 1 ? 'text-success' : 'text-warning' }}">
                            {{ number_format($debtToEquity, 2) }}
                        </span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar {{ $debtToEquity <= 1 ? 'bg-success' : 'bg-warning' }}" 
                             style="width: {{ min($debtToEquity * 50, 100) }}%"></div>
                    </div>
                    <small class="text-muted">الالتزامات / حقوق الملكية</small>
                </div>
                
                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>صافي رأس المال العامل</span>
                        <span class="fw-bold {{ ($totalCurrentAssets - $totalCurrentLiabilities) >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ number_format($totalCurrentAssets - $totalCurrentLiabilities, 2) }}
                        </span>
                    </div>
                    <small class="text-muted">الأصول المتداولة - الالتزامات المتداولة</small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Assets Distribution Chart
    const assetsByType = @json($assetsByType);
    const labels = assetsByType.map(a => {
        switch(a.type) {
            case 'cash': return 'نقدي';
            case 'bank': return 'بنكي';
            case 'wallet': return 'محفظة';
            default: return a.type;
        }
    });
    const data = assetsByType.map(a => a.total);
    
    new Chart(document.getElementById('assetsChart'), {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(0, 123, 255, 0.8)',
                    'rgba(23, 162, 184, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection

