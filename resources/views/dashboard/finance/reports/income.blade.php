@extends('layouts.master')
@section('title', 'تقرير الإيرادات')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">تقرير الإيرادات</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="#">التقارير المالية</a></li>
                <li class="breadcrumb-item active" aria-current="page">تقرير الإيرادات</li>
            </ol>
        </nav>
    </div>
    @permission('Print Financial Reports')
    <div>
        <a href="{{ route('reports.print.income', ['start_date' => $startDate, 'end_date' => $endDate, 'account_id' => $accountId, 'source' => $source]) }}" target="_blank" class="btn btn-outline-primary">
            <i class="fas fa-print me-1"></i> طباعة
        </a>
    </div>
    @endpermission
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.income') }}" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label">من تاريخ</label>
                <input type="date" class="form-control" name="start_date" value="{{ $startDate }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">إلى تاريخ</label>
                <input type="date" class="form-control" name="end_date" value="{{ $endDate }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">الحساب</label>
                <select class="form-select select2" name="account_id" data-placeholder="-- الكل --">
                    <option value="">-- الكل --</option>
                    @foreach($accounts as $acc)
                    <option value="{{ $acc->id }}" {{ $accountId == $acc->id ? 'selected' : '' }}>{{ $acc->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">المصدر</label>
                <select class="form-select select2" name="source" data-placeholder="-- الكل --">
                    <option value="">-- الكل --</option>
                    <option value="cash_deposit" {{ $source == 'cash_deposit' ? 'selected' : '' }}>إيداع نقدي</option>
                    <option value="bank_transfer" {{ $source == 'bank_transfer' ? 'selected' : '' }}>تحويل بنكي</option>
                    <option value="client_payment" {{ $source == 'client_payment' ? 'selected' : '' }}>دفعة من عميل</option>
                    <option value="trip_payment" {{ $source == 'trip_payment' ? 'selected' : '' }}>دفعة رحلة</option>
                    <option value="owner_capital" {{ $source == 'owner_capital' ? 'selected' : '' }}>رأس مال المالك</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i> تصفية</button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <!-- Summary by Source -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">ملخص حسب المصدر</h5>
            </div>
            <div class="card-body">
                @if($sourceTotals->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($sourceTotals as $src)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
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
                            <small class="text-muted">({{ $src->count }})</small>
                        </span>
                        <span class="badge bg-success rounded-pill">{{ number_format($src->total, 2) }}</span>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted text-center py-3">لا توجد بيانات</p>
                @endif
            </div>
            <div class="card-footer bg-dark text-white">
                <div class="d-flex justify-content-between">
                    <strong>الإجمالي</strong>
                    <strong>{{ number_format($totalAmount, 2) }} ر.س</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Income List -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">قائمة الإيرادات <span class="badge bg-secondary">{{ $incomes->count() }}</span></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="example1">
                        <thead class="table-dark">
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
                                        @case('cash_deposit') <span class="badge bg-primary">إيداع نقدي</span> @break
                                        @case('bank_transfer') <span class="badge bg-info">تحويل بنكي</span> @break
                                        @case('client_payment') <span class="badge bg-success">دفعة من عميل</span> @break
                                        @case('trip_payment') <span class="badge bg-warning">دفعة رحلة</span> @break
                                        @case('owner_capital') <span class="badge bg-secondary">رأس مال المالك</span> @break
                                        @default <span class="badge bg-light text-dark">{{ $income->source ?? 'أخرى' }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $income->account->name ?? '-' }}</td>
                                <td><code>{{ $income->reference_number ?? '-' }}</code></td>
                                <td class="text-success fw-bold">+{{ number_format($income->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-dark">
                                <td colspan="5"><strong>الإجمالي</strong></td>
                                <td><strong>{{ number_format($totalAmount, 2) }} ر.س</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

