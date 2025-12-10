<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $appName = \App\Models\Setting::get('app_name', 'صِـدقا');
        $appNameEn = \App\Models\Setting::get('app_name_en', 'SIDQA');
        $companyPhone = \App\Models\Setting::get('company_phone', '');
        $companyEmail = \App\Models\Setting::get('company_email', '');
        $companyAddress = \App\Models\Setting::get('company_address', '');
        $currencySymbol = \App\Models\Setting::get('currency_symbol', 'ر.س');
    @endphp
    <title>@yield('title') - {{ $appName }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Noto Kufi Arabic', sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #000;
            background: #fff;
            direction: rtl;
        }

        .print-container {
            max-width: 210mm;
            margin: 0 auto;
            padding: 10mm;
        }

        /* Header - Grayscale */
        .print-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }

        .print-header .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .print-header .logo img {
            height: 40px;
            filter: grayscale(100%);
        }

        .print-header .logo h1 {
            font-size: 22px;
            color: #000;
            margin: 0;
        }

        .print-header .company-info {
            text-align: left;
            font-size: 10px;
            color: #000;
        }

        /* Report Title - Grayscale */
        .report-title {
            text-align: center;
            margin-bottom: 15px;
            padding: 12px;
            background: #333;
            color: white;
            border: 1px solid #000;
        }

        .report-title h2 {
            font-size: 16px;
            margin-bottom: 3px;
        }

        .report-title .date-range {
            font-size: 11px;
        }

        /* Summary Cards - Grayscale */
        .summary-cards {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .summary-card {
            flex: 1;
            min-width: 80px;
            padding: 10px;
            text-align: center;
            border: 1px solid #000;
            background: #f5f5f5;
        }

        .summary-card.primary,
        .summary-card.success,
        .summary-card.danger,
        .summary-card.info,
        .summary-card.warning,
        .summary-card.dark {
            background: #e0e0e0;
        }

        .summary-card h4 {
            font-size: 14px;
            margin-bottom: 3px;
            color: #000;
        }

        .summary-card p {
            font-size: 9px;
            color: #000;
            margin: 0;
        }

        /* Tables - Grayscale */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10px;
        }

        table th,
        table td {
            padding: 6px 8px;
            border: 1px solid #000;
            text-align: right;
        }

        table th {
            background: #333;
            color: white;
            font-weight: 600;
        }

        table thead th {
            background: #333;
            color: white;
        }

        table tfoot td {
            background: #e0e0e0;
            color: #000;
            font-weight: bold;
        }

        table tbody tr:nth-child(even) {
            background: #f5f5f5;
        }

        .text-success { color: #000; font-weight: bold; }
        .text-danger { color: #000; }
        .text-primary { color: #000; }
        .text-end { text-align: left; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }

        /* Section Title - Grayscale */
        .section-title {
            background: #e0e0e0;
            color: #000;
            padding: 8px 12px;
            margin: 15px 0 10px;
            border-right: 3px solid #000;
            font-weight: bold;
            font-size: 12px;
        }

        /* Footer */
        .print-footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #000;
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            color: #000;
        }

        /* Revenue Breakdown Box */
        .breakdown-box {
            border: 1px solid #000;
            margin-bottom: 15px;
        }

        .breakdown-box .header {
            background: #333;
            color: white;
            padding: 8px 12px;
            font-weight: bold;
        }

        .breakdown-box .content {
            padding: 10px 12px;
            color: #000;
        }

        .breakdown-row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
            border-bottom: 1px dotted #ccc;
            color: #000;
        }

        .breakdown-row:last-child {
            border-bottom: none;
        }

        .breakdown-row.total {
            border-top: 2px solid #000;
            margin-top: 8px;
            padding-top: 8px;
            font-weight: bold;
            font-size: 12px;
        }

        /* Two Column Layout */
        .row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .col-6, .col-half { flex: 0 0 48%; }
        .col-8 { flex: 0 0 65%; }
        .col-4, .col-third { flex: 0 0 32%; }

        /* Balance Sheet Specific - Grayscale */
        .indent-1 { padding-right: 20px !important; color: #000; }
        .indent-2 { padding-right: 40px !important; font-size: 10px; color: #000; }

        .section-header {
            background: #333;
            color: white;
            font-weight: bold;
            font-size: 11px;
        }

        .section-header.assets,
        .section-header.liabilities,
        .section-header.equity {
            background: #333;
        }

        .sub-section {
            background: #e0e0e0;
            color: #000;
            font-weight: 600;
        }

        .total-row {
            background: #d0d0d0;
            color: #000;
            font-weight: bold;
        }

        .grand-total {
            background: #333;
            color: black;
            font-weight: bold;
            font-size: 11px;
        }

        .balance-check.balanced {
            background: #e0e0e0;
            color: #000;
            text-align: center;
        }

        .balance-check.unbalanced {
            background: #f0f0f0;
            color: #000;
            text-align: center;
        }

        /* Status Badge - Grayscale */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 9px;
            border: 1px solid #000;
            background: #f5f5f5;
            color: #000;
        }

        .badge.completed, .badge.bg-success {
            background: #333;
            color: white;
        }

        .badge.cancelled, .badge.bg-danger {
            background: #fff;
            color: #000;
        }

        /* Signatures */
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding-top: 15px;
        }

        .signature-box {
            text-align: center;
            min-width: 150px;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 5px;
            font-size: 10px;
            color: #000;
        }

        /* Print specific styles */
        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .print-container {
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            @page {
                size: A4;
                margin: 8mm;
            }

            table { page-break-inside: auto; }
            tr { page-break-inside: avoid; page-break-after: auto; }
            thead { display: table-header-group; }
        }

        /* Print Actions */
        .print-actions {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1000;
            display: flex;
            gap: 8px;
        }

        .btn-print, .btn-back {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-family: inherit;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-print {
            background: #333;
            color: white;
        }

        .btn-back {
            background: #666;
            color: white;
        }

        .btn-print:hover, .btn-back:hover {
            opacity: 0.9;
        }

        @yield('styles')
    </style>
</head>
<body>
    <!-- Print Actions -->
    <div class="print-actions no-print">
        <button class="btn-print" onclick="window.print()">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
            </svg>
            طباعة
        </button>
        <a href="javascript:history.back()" class="btn-back">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            رجوع
        </a>
    </div>

    <div class="print-container">
        <!-- Header -->
        <div class="print-header">
            <div class="logo">
                <img src="{{ asset('assets/images/favicon.png') }}" alt="Logo" onerror="this.style.display='none'">
                <h1>{{ $appName }}</h1>
            </div>
            <div class="company-info">
                <strong>{{ $appName }} - {{ $appNameEn }}</strong><br>
                @if($companyPhone){{ $companyPhone }}<br>@endif
                @if($companyEmail){{ $companyEmail }}<br>@endif
                @if($companyAddress){{ $companyAddress }}<br>@endif
                تاريخ الطباعة: {{ now()->format('Y-m-d H:i') }}
            </div>
        </div>

        @yield('content')

        <!-- Signatures -->
        @if(View::hasSection('signatures'))
            @yield('signatures')
        @else
        <div class="signatures">
            <div class="signature-box">
                <div class="signature-line">مُعد التقرير</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">المدير المالي</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">المدير العام</div>
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="print-footer">
            <div>{{ $appName }} - جميع الحقوق محفوظة © {{ date('Y') }}</div>
            <div>تم إنشاء هذا التقرير آلياً من نظام إدارة {{ $appName }}</div>
        </div>
    </div>
</body>
</html>
