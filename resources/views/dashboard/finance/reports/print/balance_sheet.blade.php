@extends('layouts.print')
@section('title', 'الميزانية العمومية')
@section('content')

<div class="report-title">
    <h2>الميزانية العمومية</h2>
    <div class="date-range">كما في {{ $asOfDate }}</div>
</div>

<!-- Summary Cards -->
<div class="summary-cards">
    <div class="summary-card dark">
        <h4>{{ number_format($totalCurrentAssets, 2) }}</h4>
        <p>إجمالي الأصول (ر.س)</p>
    </div>
    <div class="summary-card">
        <h4>{{ number_format($totalCurrentLiabilities, 2) }}</h4>
        <p>إجمالي الالتزامات (ر.س)</p>
    </div>
    <div class="summary-card dark">
        <h4>{{ number_format($totalEquity, 2) }}</h4>
        <p>حقوق الملكية (ر.س)</p>
    </div>
</div>

<div class="row">
    <!-- Balance Sheet Table -->
    <div class="col-8">
        <table>
            <tbody>
                <!-- ASSETS SECTION -->
                <tr class="section-header">
                    <th colspan="2">الأصول</th>
                </tr>
                
                <!-- Current Assets -->
                <tr class="sub-section">
                    <td colspan="2">الأصول المتداولة</td>
                </tr>
                
                <!-- Cash -->
                <tr>
                    <td class="indent-1">النقدية</td>
                    <td class="text-end">{{ number_format($totalCash, 2) }}</td>
                </tr>
                @foreach($cashAccounts as $account)
                <tr>
                    <td class="indent-2">- {{ $account->name }}</td>
                    <td class="text-end">{{ number_format($account->balance, 2) }}</td>
                </tr>
                @endforeach
                
                <!-- Bank Accounts -->
                <tr>
                    <td class="indent-1">الحسابات البنكية</td>
                    <td class="text-end">{{ number_format($totalBank, 2) }}</td>
                </tr>
                @foreach($bankAccounts as $account)
                <tr>
                    <td class="indent-2">- {{ $account->name }}</td>
                    <td class="text-end">{{ number_format($account->balance, 2) }}</td>
                </tr>
                @endforeach
                
                <!-- Wallets -->
                @if($totalWallet > 0)
                <tr>
                    <td class="indent-1">المحافظ الإلكترونية</td>
                    <td class="text-end">{{ number_format($totalWallet, 2) }}</td>
                </tr>
                @foreach($walletAccounts as $account)
                <tr>
                    <td class="indent-2">- {{ $account->name }}</td>
                    <td class="text-end">{{ number_format($account->balance, 2) }}</td>
                </tr>
                @endforeach
                @endif
                
                <!-- Receivables -->
                @if($pendingIncome > 0)
                <tr>
                    <td class="indent-1">ذمم مدينة</td>
                    <td class="text-end">{{ number_format($pendingIncome, 2) }}</td>
                </tr>
                @endif
                
                <!-- Total Current Assets -->
                <tr class="total-row">
                    <td class="fw-bold">إجمالي الأصول المتداولة</td>
                    <td class="text-end fw-bold">{{ number_format($totalCurrentAssets, 2) }}</td>
                </tr>
                
                <!-- TOTAL ASSETS -->
                <tr class="grand-total">
                    <td>إجمالي الأصول</td>
                    <td class="text-end">{{ number_format($totalCurrentAssets, 2) }} ر.س</td>
                </tr>
                
                <!-- Separator -->
                <tr><td colspan="2" style="padding: 10px;"></td></tr>
                
                <!-- LIABILITIES SECTION -->
                <tr class="section-header">
                    <th colspan="2">الالتزامات</th>
                </tr>
                
                <!-- Current Liabilities -->
                <tr class="sub-section">
                    <td colspan="2">الالتزامات المتداولة</td>
                </tr>
                
                @if($pendingExpenses > 0)
                <tr>
                    <td class="indent-1">ذمم دائنة (مصروفات مستحقة)</td>
                    <td class="text-end">{{ number_format($pendingExpenses, 2) }}</td>
                </tr>
                @endif
                
                <!-- Total Current Liabilities -->
                <tr class="total-row">
                    <td class="fw-bold">إجمالي الالتزامات المتداولة</td>
                    <td class="text-end fw-bold">{{ number_format($totalCurrentLiabilities, 2) }}</td>
                </tr>
                
                <!-- TOTAL LIABILITIES -->
                <tr class="grand-total">
                    <td>إجمالي الالتزامات</td>
                    <td class="text-end">{{ number_format($totalCurrentLiabilities, 2) }} ر.س</td>
                </tr>
                
                <!-- Separator -->
                <tr><td colspan="2" style="padding: 10px;"></td></tr>
                
                <!-- EQUITY SECTION -->
                <tr class="section-header">
                    <th colspan="2">حقوق الملكية</th>
                </tr>
                
                <tr>
                    <td class="indent-1">الأرباح المحتجزة</td>
                    <td class="text-end">
                        {{ number_format($retainedEarnings, 2) }}
                    </td>
                </tr>
                
                <tr>
                    <td class="indent-2">- صافي دخل الفترة الحالية</td>
                    <td class="text-end">
                        {{ number_format($currentPeriodNetIncome, 2) }}
                    </td>
                </tr>
                
                <!-- TOTAL EQUITY -->
                <tr class="total-row">
                    <td class="fw-bold">إجمالي حقوق الملكية</td>
                    <td class="text-end fw-bold">{{ number_format($totalEquity, 2) }}</td>
                </tr>
                
                <!-- TOTAL LIABILITIES + EQUITY -->
                <tr class="grand-total">
                    <td>إجمالي الالتزامات وحقوق الملكية</td>
                    <td class="text-end">{{ number_format($totalLiabilitiesAndEquity, 2) }} ر.س</td>
                </tr>
                
                <!-- Balance Check -->
                @php $difference = $totalCurrentAssets - $totalLiabilitiesAndEquity; @endphp
                @if(abs($difference) > 0.01)
                <tr class="balance-check unbalanced">
                    <td colspan="2">
                        ⚠️ فرق الميزانية: {{ number_format($difference, 2) }} ر.س
                    </td>
                </tr>
                @else
                <tr class="balance-check balanced">
                    <td colspan="2">
                        ✓ الميزانية متوازنة
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    
    <!-- Side Panel -->
    <div class="col-4">
        <div class="section-title">ملخص الحسابات</div>
        <table>
            <thead>
                <tr>
                    <th>الحساب</th>
                    <th>النوع</th>
                    <th>الرصيد</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allAccounts as $account)
                <tr>
                    <td>{{ $account->name }}</td>
                    <td>
                        @switch($account->type)
                            @case('cash') نقدي @break
                            @case('bank') بنكي @break
                            @case('wallet') محفظة @break
                            @default {{ $account->type }}
                        @endswitch
                    </td>
                    <td class="fw-bold">
                        {{ number_format($account->balance, 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"><strong>الإجمالي</strong></td>
                    <td><strong>{{ number_format($totalAccountsBalance, 2) }} ر.س</strong></td>
                </tr>
            </tfoot>
        </table>
        
        <div class="section-title">المؤشرات المالية</div>
        <table>
            @php
                $currentRatio = $totalCurrentLiabilities > 0 ? $totalCurrentAssets / $totalCurrentLiabilities : 0;
                $debtToEquity = $totalEquity != 0 ? $totalCurrentLiabilities / abs($totalEquity) : 0;
                $workingCapital = $totalCurrentAssets - $totalCurrentLiabilities;
            @endphp
            <tr>
                <td>نسبة التداول</td>
                <td class="fw-bold">
                    {{ number_format($currentRatio, 2) }}
                </td>
            </tr>
            <tr>
                <td>نسبة الدين / حقوق الملكية</td>
                <td class="fw-bold">
                    {{ number_format($debtToEquity, 2) }}
                </td>
            </tr>
            <tr>
                <td>صافي رأس المال العامل</td>
                <td class="fw-bold">
                    {{ number_format($workingCapital, 2) }}
                </td>
            </tr>
        </table>
    </div>
</div>

@endsection
