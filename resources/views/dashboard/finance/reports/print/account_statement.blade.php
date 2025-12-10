@extends('layouts.print')
@section('title', 'كشف حساب')
@section('content')

<div class="report-title">
    <h2>كشف حساب: {{ $selectedAccount->name }}</h2>
    <div class="date-range">للفترة من {{ $startDate }} إلى {{ $endDate }}</div>
</div>

<!-- Account Info -->
<div class="summary-cards">
    <div class="summary-card primary">
        <h4>{{ $selectedAccount->name }}</h4>
        <p>الحساب ({{ $selectedAccount->type }})</p>
    </div>
    <div class="summary-card info">
        <h4>{{ number_format($openingBalance, 2) }}</h4>
        <p>الرصيد الافتتاحي ({{ $selectedAccount->currency }})</p>
    </div>
    <div class="summary-card {{ $closingBalance >= 0 ? 'success' : 'danger' }}">
        <h4>{{ number_format($closingBalance, 2) }}</h4>
        <p>الرصيد الختامي ({{ $selectedAccount->currency }})</p>
    </div>
</div>

<!-- Statement Table -->
<div class="section-title">كشف الحساب التفصيلي</div>
<table>
    <thead>
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
        <tr style="background: #e9ecef;">
            <td colspan="6"><strong>الرصيد الافتتاحي</strong></td>
            <td class="fw-bold">{{ number_format($openingBalance, 2) }}</td>
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
                    @case('income') إيداع @break
                    @case('expense') مصروف @break
                    @case('transfer') تحويل @break
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
        <tr>
            <td colspan="6"><strong>الرصيد الختامي</strong></td>
            <td><strong>{{ number_format($closingBalance, 2) }} {{ $selectedAccount->currency }}</strong></td>
        </tr>
    </tfoot>
</table>

@endsection

