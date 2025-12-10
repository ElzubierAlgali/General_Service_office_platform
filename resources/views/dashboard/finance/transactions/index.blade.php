@extends('layouts.master')
@section('title', 'مراقب المعاملات')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">مراقب المعاملات</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">مراقب المعاملات</li>
            </ol>
        </nav>
    </div>
    <div>
        <span class="badge bg-secondary fs-6">
            <i class="fas fa-calendar"></i> 
            {{ $dateFrom ? \Carbon\Carbon::parse($dateFrom)->format('Y/m/d') : now()->startOfMonth()->format('Y/m/d') }}
            - 
            {{ $dateTo ? \Carbon\Carbon::parse($dateTo)->format('Y/m/d') : now()->format('Y/m/d') }}
        </span>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-6 col-md-4 col-xl-2 mb-3">
        <div class="card border-0 shadow-sm h-100 bg-success bg-opacity-10">
            <div class="card-body text-center">
                <i class="fas fa-arrow-down fa-2x text-success mb-2"></i>
                <h4 class="mb-0 text-success">{{ number_format($stats['period_income'], 0) }}</h4>
                <small class="text-muted">الإيرادات</small>
                <div class="mt-1">
                    <span class="badge bg-success">{{ $stats['income_count'] }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2 mb-3">
        <div class="card border-0 shadow-sm h-100 bg-danger bg-opacity-10">
            <div class="card-body text-center">
                <i class="fas fa-arrow-up fa-2x text-danger mb-2"></i>
                <h4 class="mb-0 text-danger">{{ number_format($stats['period_expenses'], 0) }}</h4>
                <small class="text-muted">المصروفات</small>
                <div class="mt-1">
                    <span class="badge bg-danger">{{ $stats['expense_count'] }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2 mb-3">
        <div class="card border-0 shadow-sm h-100 bg-info bg-opacity-10">
            <div class="card-body text-center">
                <i class="fas fa-exchange-alt fa-2x text-info mb-2"></i>
                <h4 class="mb-0 text-info">{{ number_format($stats['period_transfers'], 0) }}</h4>
                <small class="text-muted">التحويلات</small>
                <div class="mt-1">
                    <span class="badge bg-info">{{ $stats['transfer_count'] }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2 mb-3">
        <div class="card border-0 shadow-sm h-100 {{ $stats['period_net'] >= 0 ? 'bg-success' : 'bg-danger' }} bg-opacity-10">
            <div class="card-body text-center">
                <i class="fas fa-balance-scale fa-2x {{ $stats['period_net'] >= 0 ? 'text-success' : 'text-danger' }} mb-2"></i>
                <h4 class="mb-0 {{ $stats['period_net'] >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format($stats['period_net'], 0) }}</h4>
                <small class="text-muted">صافي الفترة</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2 mb-3">
        <div class="card border-0 shadow-sm h-100 bg-primary bg-opacity-10">
            <div class="card-body text-center">
                <i class="fas fa-sun fa-2x text-primary mb-2"></i>
                <h4 class="mb-0 text-primary">{{ number_format($stats['today_income'], 0) }}</h4>
                <small class="text-muted">إيرادات اليوم</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2 mb-3">
        <div class="card border-0 shadow-sm h-100 bg-warning bg-opacity-10">
            <div class="card-body text-center">
                <i class="fas fa-receipt fa-2x text-warning mb-2"></i>
                <h4 class="mb-0 text-warning">{{ number_format($stats['today_expenses'], 0) }}</h4>
                <small class="text-muted">مصروفات اليوم</small>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-transparent">
        <h6 class="mb-0"><i class="fas fa-filter text-primary me-2"></i>الفلاتر والبحث</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('transactions.index') }}">
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">نوع المعاملة</label>
                    <select name="type" class="form-select select2" data-placeholder="-- نوع المعاملة --">
                        <option value="all" {{ $type == 'all' ? 'selected' : '' }}>الكل</option>
                        <option value="income" {{ $type == 'income' ? 'selected' : '' }}>إيراد</option>
                        <option value="expense" {{ $type == 'expense' ? 'selected' : '' }}>مصروف</option>
                        <option value="transfer" {{ $type == 'transfer' ? 'selected' : '' }}>تحويل</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">الحساب</label>
                    <select name="account_id" class="form-select select2" data-placeholder="-- اختر الحساب --">
                        <option value="">جميع الحسابات</option>
                        @foreach($accounts as $account)
                        <option value="{{ $account->id }}" {{ $accountId == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">المصدر</label>
                    <select name="source" class="form-select select2" data-placeholder="-- اختر المصدر --">
                        <option value="">جميع المصادر</option>
                        @foreach($sources as $src)
                        <option value="{{ $src }}" {{ $source == $src ? 'selected' : '' }}>
                            {{ \App\Http\Controllers\dashboard\Finance\TransactionController::getSourceLabel($src) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">من تاريخ</label>
                    <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">إلى تاريخ</label>
                    <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">بحث</label>
                    <input type="text" name="search" class="form-control" placeholder="رقم مرجع، وصف..." value="{{ $search }}">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> بحث
                    </button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-redo"></i> إعادة تعيين
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <!-- Transactions Table -->
    <div class="col-12 col-xl-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    <i class="fas fa-list text-primary me-2"></i>
                    سجل المعاملات
                    <span class="badge bg-secondary ms-2">{{ $transactions->total() }}</span>
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>النوع</th>
                                <th>الحساب</th>
                                <th>الوصف</th>
                                <th>المبلغ</th>
                                <th>الرصيد بعد</th>
                                <th>التاريخ</th>
                                <th style="width: 80px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $index => $transaction)
                            <tr>
                                <td>
                                    <small class="text-muted">{{ $transactions->firstItem() + $index }}</small>
                                </td>
                                <td>
                                    @switch($transaction->type)
                                        @case('income')
                                            <span class="badge bg-success">
                                                <i class="fas fa-arrow-down me-1"></i>إيراد
                                            </span>
                                            @break
                                        @case('expense')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-arrow-up me-1"></i>مصروف
                                            </span>
                                            @break
                                        @case('transfer')
                                            <span class="badge bg-info">
                                                <i class="fas fa-exchange-alt me-1"></i>تحويل
                                            </span>
                                            @break
                                    @endswitch
                                    @if($transaction->source)
                                    <br>
                                    <small class="text-muted">
                                        {{ \App\Http\Controllers\dashboard\Finance\TransactionController::getSourceLabel($transaction->source) }}
                                    </small>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $transaction->account->name ?? '-' }}</strong>
                                    @if($transaction->type == 'transfer' && $transaction->toAccount)
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-arrow-left"></i> {{ $transaction->toAccount->name }}
                                    </small>
                                    @endif
                                </td>
                                <td>
                                    <div style="max-width: 200px;">
                                        {{ Str::limit($transaction->description, 40) }}
                                        @if($transaction->payee)
                                        <br><small class="text-muted">{{ $transaction->payee }}</small>
                                        @endif
                                        @if($transaction->vehicle)
                                        <br><small class="text-info"><i class="fas fa-car"></i> {{ $transaction->vehicle->plate_number }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <strong class="{{ $transaction->type == 'income' ? 'text-success' : ($transaction->type == 'expense' ? 'text-danger' : 'text-info') }}">
                                        {{ $transaction->type == 'income' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }}
                                    </strong>
                                    <br><small class="text-muted">{{ $transaction->currency }}</small>
                                </td>
                                <td>
                                    @if($transaction->balance_after !== null)
                                    <span class="{{ $transaction->balance_after >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($transaction->balance_after, 2) }}
                                    </span>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $transaction->transaction_date?->format('Y/m/d') }}
                                    <br>
                                    <small class="text-muted">{{ $transaction->created_at?->format('H:i') }}</small>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#transactionModal{{ $transaction->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Transaction Detail Modal -->
                            <div class="modal fade" id="transactionModal{{ $transaction->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header {{ $transaction->type == 'income' ? 'bg-success' : ($transaction->type == 'expense' ? 'bg-danger' : 'bg-info') }} text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-receipt me-2"></i>
                                                تفاصيل المعاملة #{{ $transaction->reference_number }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6 class="text-primary mb-3">معلومات المعاملة</h6>
                                                    <table class="table table-sm">
                                                        <tr>
                                                            <td class="text-muted">رقم المرجع:</td>
                                                            <td><strong>{{ $transaction->reference_number }}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">النوع:</td>
                                                            <td>
                                                                @switch($transaction->type)
                                                                    @case('income') إيراد @break
                                                                    @case('expense') مصروف @break
                                                                    @case('transfer') تحويل @break
                                                                @endswitch
                                                            </td>
                                                        </tr>
                                                        @if($transaction->source)
                                                        <tr>
                                                            <td class="text-muted">المصدر:</td>
                                                            <td>{{ \App\Http\Controllers\dashboard\Finance\TransactionController::getSourceLabel($transaction->source) }}</td>
                                                        </tr>
                                                        @endif
                                                        <tr>
                                                            <td class="text-muted">الحالة:</td>
                                                            <td>
                                                                @if($transaction->status == 'completed')
                                                                <span class="badge bg-success">مكتمل</span>
                                                                @elseif($transaction->status == 'pending')
                                                                <span class="badge bg-warning">معلق</span>
                                                                @else
                                                                <span class="badge bg-secondary">{{ $transaction->status }}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">التاريخ:</td>
                                                            <td>{{ $transaction->transaction_date?->format('Y/m/d') }}</td>
                                                        </tr>
                                                        @if($transaction->external_reference)
                                                        <tr>
                                                            <td class="text-muted">مرجع خارجي:</td>
                                                            <td>{{ $transaction->external_reference }}</td>
                                                        </tr>
                                                        @endif
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="text-primary mb-3">التفاصيل المالية</h6>
                                                    <table class="table table-sm">
                                                        <tr>
                                                            <td class="text-muted">الحساب:</td>
                                                            <td><strong>{{ $transaction->account->name ?? '-' }}</strong></td>
                                                        </tr>
                                                        @if($transaction->toAccount)
                                                        <tr>
                                                            <td class="text-muted">إلى حساب:</td>
                                                            <td><strong>{{ $transaction->toAccount->name }}</strong></td>
                                                        </tr>
                                                        @endif
                                                        <tr>
                                                            <td class="text-muted">المبلغ:</td>
                                                            <td>
                                                                <strong class="{{ $transaction->type == 'income' ? 'text-success' : 'text-danger' }}">
                                                                    {{ number_format($transaction->amount, 2) }} {{ $transaction->currency }}
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                        @if($transaction->fee > 0)
                                                        <tr>
                                                            <td class="text-muted">الرسوم:</td>
                                                            <td>{{ number_format($transaction->fee, 2) }}</td>
                                                        </tr>
                                                        @endif
                                                        @if($transaction->tax_amount)
                                                        <tr>
                                                            <td class="text-muted">الضريبة:</td>
                                                            <td>{{ number_format($transaction->tax_amount, 2) }}</td>
                                                        </tr>
                                                        @endif
                                                        <tr>
                                                            <td class="text-muted">الرصيد قبل:</td>
                                                            <td>{{ number_format($transaction->balance_before, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">الرصيد بعد:</td>
                                                            <td><strong>{{ number_format($transaction->balance_after, 2) }}</strong></td>
                                                        </tr>
                                                        @if($transaction->payment_method)
                                                        <tr>
                                                            <td class="text-muted">طريقة الدفع:</td>
                                                            <td>{{ $transaction->payment_method }}</td>
                                                        </tr>
                                                        @endif
                                                    </table>
                                                </div>
                                            </div>

                                            @if($transaction->description || $transaction->notes || $transaction->payee)
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="text-primary mb-3">معلومات إضافية</h6>
                                                    @if($transaction->payee)
                                                    <p><strong>المستفيد:</strong> {{ $transaction->payee }}</p>
                                                    @endif
                                                    @if($transaction->description)
                                                    <p><strong>الوصف:</strong> {{ $transaction->description }}</p>
                                                    @endif
                                                    @if($transaction->notes)
                                                    <p><strong>ملاحظات:</strong> {{ $transaction->notes }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif

                                            @if($transaction->vehicle || $transaction->driver || $transaction->maintenance)
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="text-primary mb-3">الربط بالعمليات</h6>
                                                    <div class="d-flex gap-3 flex-wrap">
                                                        @if($transaction->vehicle)
                                                        <span class="badge bg-primary fs-6">
                                                            <i class="fas fa-car me-1"></i>
                                                            {{ $transaction->vehicle->plate_number }} - {{ $transaction->vehicle->brand }}
                                                        </span>
                                                        @endif
                                                        @if($transaction->driver)
                                                        <span class="badge bg-info fs-6">
                                                            <i class="fas fa-user me-1"></i>
                                                            {{ $transaction->driver->name }}
                                                        </span>
                                                        @endif
                                                        @if($transaction->maintenance)
                                                        <span class="badge bg-warning fs-6">
                                                            <i class="fas fa-tools me-1"></i>
                                                            صيانة: {{ $transaction->maintenance->title }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <small class="text-muted">
                                                        <i class="fas fa-user me-1"></i> بواسطة: {{ $transaction->createdBy->name ?? '-' }}
                                                        | <i class="fas fa-clock me-1"></i> {{ $transaction->created_at?->format('Y/m/d H:i') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    لا توجد معاملات مطابقة للبحث
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($transactions->hasPages())
            <div class="card-footer bg-transparent">
                {{ $transactions->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Side Panel - Quick Stats -->
    <div class="col-12 col-xl-4 mb-4">
        <!-- Top Expense Sources -->
        @if($stats['by_source']->count() > 0)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent">
                <h6 class="mb-0"><i class="fas fa-chart-pie text-danger me-2"></i>أعلى مصادر المصروفات</h6>
            </div>
            <div class="card-body">
                @foreach($stats['by_source'] as $sourceItem)
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>{{ \App\Http\Controllers\dashboard\Finance\TransactionController::getSourceLabel($sourceItem->source) }}</span>
                        <span>
                            <strong>{{ number_format($sourceItem->total, 0) }}</strong>
                            <small class="text-muted">({{ $sourceItem->count }})</small>
                        </span>
                    </div>
                    @php
                        $maxSource = $stats['by_source']->max('total') ?: 1;
                        $sourcePercent = ($sourceItem->total / $maxSource) * 100;
                    @endphp
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-danger" style="width: {{ $sourcePercent }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Accounts Balance -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent">
                <h6 class="mb-0"><i class="fas fa-university text-primary me-2"></i>أرصدة الحسابات</h6>
            </div>
            <div class="card-body">
                @foreach($accounts as $account)
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <div>
                        <strong>{{ $account->name }}</strong>
                        <br><small class="text-muted">{{ $account->type }}</small>
                    </div>
                    <div class="text-end">
                        <span class="{{ $account->balance >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                            {{ number_format($account->balance, 2) }}
                        </span>
                        <br><small class="text-muted">{{ $account->currency }}</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Links -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent">
                <h6 class="mb-0"><i class="fas fa-bolt text-warning me-2"></i>إجراءات سريعة</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @permission('Create Expense')
                    <a href="{{ route('expenses.index') }}" class="btn btn-outline-danger">
                        <i class="fas fa-receipt me-2"></i>إضافة مصروف
                    </a>
                    @endpermission
                    @permission('Charging accounts')
                    <a href="{{ route('accounts.charge') }}" class="btn btn-outline-success">
                        <i class="fas fa-plus-circle me-2"></i>إيداع مالي
                    </a>
                    @endpermission
                    @permission('Transfer Between Accounts')
                    <a href="{{ route('accounts.transfer') }}" class="btn btn-outline-info">
                        <i class="fas fa-exchange-alt me-2"></i>تحويل بين الحسابات
                    </a>
                    @endpermission
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

