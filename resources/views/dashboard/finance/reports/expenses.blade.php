@extends('layouts.master')
@section('title', 'تقرير المصروفات')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">تقرير المصروفات</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="#">التقارير المالية</a></li>
                <li class="breadcrumb-item active" aria-current="page">تقرير المصروفات</li>
            </ol>
        </nav>
    </div>
    @permission('Print Financial Reports')
    <div>
        <a href="{{ route('reports.print.expenses', ['start_date' => $startDate, 'end_date' => $endDate, 'category_id' => $categoryId, 'account_id' => $accountId]) }}" target="_blank" class="btn btn-outline-primary">
            <i class="fas fa-print me-1"></i> طباعة
        </a>
    </div>
    @endpermission
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.expenses') }}" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label">من تاريخ</label>
                <input type="date" class="form-control" name="start_date" value="{{ $startDate }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">إلى تاريخ</label>
                <input type="date" class="form-control" name="end_date" value="{{ $endDate }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">التصنيف</label>
                <select class="form-select select2" name="category_id" data-placeholder="-- الكل --">
                    <option value="">-- الكل --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
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
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i> تصفية</button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <!-- Summary by Category -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-danger text-white">
                <h5 class="card-title mb-0">ملخص حسب التصنيف</h5>
            </div>
            <div class="card-body">
                @if($categoryTotals->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($categoryTotals as $cat)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            {{ $cat->category->name ?? 'غير مصنف' }}
                            <small class="text-muted">({{ $cat->count }})</small>
                        </span>
                        <span class="badge bg-danger rounded-pill">{{ number_format($cat->total, 2) }}</span>
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

    <!-- Expenses List -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">قائمة المصروفات <span class="badge bg-secondary">{{ $expenses->count() }}</span></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="example1">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>التاريخ</th>
                                <th>التصنيف</th>
                                <th>التاجر</th>
                                <th>الحساب</th>
                                <th>المبلغ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses as $index => $expense)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $expense->expense_date->format('Y-m-d') }}</td>
                                <td>{{ $expense->category->name ?? '-' }}</td>
                                <td>{{ $expense->merchant ?? '-' }}</td>
                                <td>{{ $expense->account->name ?? '-' }}</td>
                                <td class="text-danger fw-bold">{{ number_format($expense->total_amount, 2) }}</td>
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

