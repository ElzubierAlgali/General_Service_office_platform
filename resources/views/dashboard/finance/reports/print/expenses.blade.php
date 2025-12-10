@extends('layouts.print')
@section('title', 'تقرير المصروفات')
@section('content')

<div class="report-title">
    <h2>تقرير المصروفات</h2>
    <div class="date-range">للفترة من {{ $startDate }} إلى {{ $endDate }}</div>
</div>

<!-- Summary Cards -->
<div class="summary-cards">
    <div class="summary-card danger">
        <h4>{{ number_format($totalAmount, 2) }}</h4>
        <p>إجمالي المصروفات (ر.س)</p>
    </div>
    <div class="summary-card primary">
        <h4>{{ $expenses->count() }}</h4>
        <p>عدد المصروفات</p>
    </div>
    <div class="summary-card info">
        <h4>{{ $categoryTotals->count() }}</h4>
        <p>عدد التصنيفات</p>
    </div>
</div>

<div class="row">
    <!-- Summary by Category -->
    <div class="col-4">
        <div class="section-title">ملخص حسب التصنيف</div>
        <table>
            <thead>
                <tr>
                    <th>التصنيف</th>
                    <th>العدد</th>
                    <th>المبلغ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categoryTotals as $cat)
                <tr>
                    <td>{{ $cat->category->name ?? 'غير مصنف' }}</td>
                    <td class="text-center">{{ $cat->count }}</td>
                    <td class="text-danger fw-bold">{{ number_format($cat->total, 2) }}</td>
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

    <!-- Expenses List -->
    <div class="col-8">
        <div class="section-title">قائمة المصروفات</div>
        <table>
            <thead>
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
                <tr>
                    <td colspan="5"><strong>الإجمالي</strong></td>
                    <td><strong>{{ number_format($totalAmount, 2) }} ر.س</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection

