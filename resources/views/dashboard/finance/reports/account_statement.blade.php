@extends('layouts.master')
@section('title', 'كشف حساب')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">كشف حساب</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="#">التقارير المالية</a></li>
                <li class="breadcrumb-item active" aria-current="page">كشف حساب</li>
            </ol>
        </nav>
    </div>
    @if($selectedAccount)
    @permission('Print Financial Reports')
    <div>
        <a href="{{ route('reports.print.account_statement', ['account_id' => $accountId, 'start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="btn btn-outline-primary">
            <i class="fas fa-print me-1"></i> طباعة
        </a>
    </div>
    @endpermission
    @endif
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.account_statement') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">الحساب <span class="text-danger">*</span></label>
                <select class="form-select select2" name="account_id" data-placeholder="-- إختر الحساب --" required>
                    <option value="">-- إختر الحساب --</option>
                    @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}" {{ $accountId == $acc->id ? 'selected' : '' }}>{{ $acc->name }} ({{ $acc->type }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">من تاريخ</label>
                <input type="date" class="form-control" name="start_date" value="{{ $startDate }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">إلى تاريخ</label>
                <input type="date" class="form-control" name="end_date" value="{{ $endDate }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> عرض</button>
            </div>
        </form>
    </div>
</div>

@if($selectedAccount)
<!-- Account Info -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h6 class="text-white-50">الحساب</h6>
                <h4 class="mb-0">{{ $selectedAccount->name }}</h4>
                <small>{{ $selectedAccount->type }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h6 class="text-white-50">الرصيد الافتتاحي</h6>
                <h4 class="mb-0">{{ number_format($openingBalance, 2) }} {{ $selectedAccount->currency }}</h4>
                <small>بداية الفترة</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card {{ $closingBalance >= 0 ? 'bg-success' : 'bg-danger' }} text-white">
            <div class="card-body text-center">
                <h6 class="text-white-50">الرصيد الختامي</h6>
                <h4 class="mb-0">{{ number_format($closingBalance, 2) }} {{ $selectedAccount->currency }}</h4>
                <small>نهاية الفترة</small>
            </div>
        </div>
    </div>
</div>

<!-- Statement Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            كشف حساب: {{ $selectedAccount->name }}
            <small class="text-muted">({{ $startDate }} - {{ $endDate }})</small>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>التاريخ</th>
                        <th>الوصف</th>
                        <th>النوع</th>
                        <th>مدين (خصم)</th>
                        <th>دائن (إضافة)</th>
                        <th>الرصيد</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-secondary">
                        <td colspan="6"><strong>الرصيد الافتتاحي</strong></td>
                        <td><strong>{{ number_format($openingBalance, 2) }}</strong></td>
                    </tr>
                    @php $runningBalance = $openingBalance; @endphp
                    @foreach($transactions as $index => $t)
                    @php $runningBalance += $t->flow_amount; @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $t->transaction_date->format('Y-m-d') }}</td>
                        <td>
                            @if($t->type == 'transfer')
                                @if($t->flow == 'out')
                                    تحويل إلى: {{ $t->toAccount->name ?? '-' }}
                                @else
                                    تحويل من: {{ $t->account->name ?? '-' }}
                                @endif
                            @else
                                {{ $t->description ?? ($t->payee ?? ($t->source ?? '-')) }}
                            @endif
                        </td>
                        <td>
                            @switch($t->type)
                                @case('income') <span class="badge bg-success">إيداع</span> @break
                                @case('expense') <span class="badge bg-danger">مصروف</span> @break
                                @case('transfer') <span class="badge bg-info">تحويل</span> @break
                            @endswitch
                        </td>
                        <td class="text-danger">
                            @if($t->flow == 'out')
                                {{ number_format(abs($t->flow_amount), 2) }}
                            @endif
                        </td>
                        <td class="text-success">
                            @if($t->flow == 'in')
                                {{ number_format($t->flow_amount, 2) }}
                            @endif
                        </td>
                        <td class="{{ $runningBalance >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                            {{ number_format($runningBalance, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-dark">
                        <td colspan="6"><strong>الرصيد الختامي</strong></td>
                        <td><strong>{{ number_format($closingBalance, 2) }} {{ $selectedAccount->currency }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-body text-center py-5">
        <i class="fas fa-file-invoice fa-4x text-muted mb-3"></i>
        <h4 class="text-muted">اختر حساباً لعرض كشف الحساب</h4>
    </div>
</div>
@endif
@endsection

