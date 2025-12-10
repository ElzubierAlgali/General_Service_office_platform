@extends('layouts.master')
@section('title', 'إيداع مالي')
@section('content')

<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">إيداع مالي</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">إيداع مالي</li>
            </ol>
        </nav>
    </div>
    @permission('Charging accounts')
    <div>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDepositModal">
            <i class="fas fa-plus me-1"></i> إيداع جديد
        </button>
    </div>
    @endpermission
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body position-relative">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%); opacity: 0.1;"></div>
                <div class="d-flex align-items-center position-relative">
                    <div class="avatar rounded-circle p-3 me-3" style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);">
                        <i class="fas fa-arrow-down fa-lg text-white"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 text-success">{{ number_format($charges->sum('amount'), 2) }}</h3>
                        <small class="text-muted">إجمالي الإيداعات</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body position-relative">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); opacity: 0.1;"></div>
                <div class="d-flex align-items-center position-relative">
                    <div class="avatar rounded-circle p-3 me-3" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                        <i class="fas fa-hashtag fa-lg text-white"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 text-primary">{{ $charges->count() }}</h3>
                        <small class="text-muted">عدد العمليات</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body position-relative">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); opacity: 0.1;"></div>
                <div class="d-flex align-items-center position-relative">
                    <div class="avatar rounded-circle p-3 me-3" style="background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);">
                        <i class="fas fa-wallet fa-lg text-white"></i>
                    </div>
                    <div>
                        <h3 class="mb-0" style="color: #8e44ad;">{{ number_format($accounts->sum('balance'), 2) }}</h3>
                        <small class="text-muted">إجمالي الأرصدة</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body position-relative">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); opacity: 0.1;"></div>
                <div class="d-flex align-items-center position-relative">
                    <div class="avatar rounded-circle p-3 me-3" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);">
                        <i class="fas fa-calendar-check fa-lg text-white"></i>
                    </div>
                    <div>
                        <h3 class="mb-0" style="color: #e67e22;">{{ $charges->where('transaction_date', '>=', now()->startOfMonth())->count() }}</h3>
                        <small class="text-muted">إيداعات هذا الشهر</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Account Balances -->
<div class="row mb-4">
    @foreach($accounts->take(4) as $account)
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1 small">{{ $account->name }}</p>
                        <h4 class="mb-0 {{ $account->balance >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ number_format($account->balance, 2) }}
                        </h4>
                        <small class="text-muted">{{ $account->currency }}</small>
                    </div>
                    @php
                        $iconClass = match($account->type) {
                            'cash' => 'fa-money-bill-wave',
                            'bank' => 'fa-university',
                            'wallet' => 'fa-wallet',
                            'credit_card' => 'fa-credit-card',
                            default => 'fa-piggy-bank'
                        };
                    @endphp
                    <div class="avatar rounded-circle bg-light p-2">
                        <i class="fas {{ $iconClass }} text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Deposits Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0"><i class="fas fa-history me-2 text-success"></i>سجل الإيداعات</h5>
            <small class="text-muted">جميع عمليات الإيداع المالي</small>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="example1">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>التاريخ</th>
                        <th>الحساب</th>
                        <th>المبلغ</th>
                        <th>المصدر</th>
                        <th>الجهة المودعة</th>
                        <th>رقم المرجع</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($charges as $index => $charge)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm rounded me-2" style="width: 36px; height: 36px; background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-arrow-down text-white small"></i>
                                </div>
                                <div>
                                    <span class="d-block">{{ $charge->transaction_date->format('Y-m-d') }}</span>
                                    <small class="text-muted">{{ $charge->transaction_date->diffForHumans() }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($charge->account)
                            <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                <i class="fas fa-wallet me-1"></i>{{ $charge->account->name }}
                            </span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="fw-bold text-success fs-6">
                                <i class="fas fa-plus-circle me-1"></i>{{ number_format($charge->amount, 2) }}
                            </span>
                            <small class="text-muted">{{ $charge->currency }}</small>
                        </td>
                        <td>
                            @php
                                $sourceInfo = match($charge->source) {
                                    'cash_deposit' => ['label' => 'إيداع نقدي', 'bg' => 'success', 'icon' => 'fa-money-bill'],
                                    'bank_transfer' => ['label' => 'تحويل بنكي', 'bg' => 'info', 'icon' => 'fa-university'],
                                    'client_payment' => ['label' => 'دفعة عميل', 'bg' => 'primary', 'icon' => 'fa-user'],
                                    'trip_payment' => ['label' => 'دفعة رحلة', 'bg' => 'warning', 'icon' => 'fa-car'],
                                    'owner_capital' => ['label' => 'رأس مال', 'bg' => 'secondary', 'icon' => 'fa-landmark'],
                                    'loan' => ['label' => 'قرض', 'bg' => 'dark', 'icon' => 'fa-hand-holding-usd'],
                                    'refund' => ['label' => 'استرداد', 'bg' => 'danger', 'icon' => 'fa-undo'],
                                    default => ['label' => 'أخرى', 'bg' => 'light text-dark', 'icon' => 'fa-ellipsis-h']
                                };
                            @endphp
                            <span class="badge bg-{{ $sourceInfo['bg'] }}">
                                <i class="fas {{ $sourceInfo['icon'] }} me-1"></i>{{ $sourceInfo['label'] }}
                            </span>
                        </td>
                        <td>{{ $charge->payee ?? '-' }}</td>
                        <td>
                            @if($charge->reference_number)
                            <code class="bg-light px-2 py-1 rounded">{{ $charge->reference_number }}</code>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @permission('Charging accounts')
                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#editDeposit{{ $charge->id }}" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="{{ route('accounts.charge.destroy', $charge->id) }}" class="btn btn-sm btn-outline-danger" data-confirm-delete="true" title="حذف">
                                <i class="fas fa-trash"></i>
                            </a>
                            @endpermission
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    @permission('Charging accounts')
                    <div class="modal fade" id="editDeposit{{ $charge->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header text-white" style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);">
                                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>تعديل الإيداع</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('accounts.charge.update', $charge->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">الحساب <span class="text-danger">*</span></label>
                                                <select class="form-select select2" name="account_id" data-placeholder="-- اختر الحساب --" required>
                                                    @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}" {{ $charge->account_id == $account->id ? 'selected' : '' }}>{{ $account->name }} ({{ $account->type }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">المبلغ <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-success text-white"><i class="fas fa-coins"></i></span>
                                                    <input type="number" step="0.01" class="form-control" name="amount" value="{{ $charge->amount }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">مصدر الإيداع <span class="text-danger">*</span></label>
                                                <select class="form-select select2" name="source" data-placeholder="-- اختر المصدر --" required>
                                                    <option value="cash_deposit" {{ $charge->source == 'cash_deposit' ? 'selected' : '' }}>إيداع نقدي</option>
                                                    <option value="bank_transfer" {{ $charge->source == 'bank_transfer' ? 'selected' : '' }}>تحويل بنكي</option>
                                                    <option value="client_payment" {{ $charge->source == 'client_payment' ? 'selected' : '' }}>دفعة من عميل</option>
                                                    <option value="trip_payment" {{ $charge->source == 'trip_payment' ? 'selected' : '' }}>دفعة رحلة</option>
                                                    <option value="owner_capital" {{ $charge->source == 'owner_capital' ? 'selected' : '' }}>رأس مال المالك</option>
                                                    <option value="loan" {{ $charge->source == 'loan' ? 'selected' : '' }}>قرض</option>
                                                    <option value="refund" {{ $charge->source == 'refund' ? 'selected' : '' }}>استرداد</option>
                                                    <option value="other" {{ $charge->source == 'other' ? 'selected' : '' }}>أخرى</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">طريقة الدفع</label>
                                                <select class="form-select select2" name="payment_method" data-placeholder="-- اختر طريقة الدفع --">
                                                    <option value="">-- إختر طريقة الدفع --</option>
                                                    @foreach ($paymentMethods as $method)
                                                    <option value="{{ $method->name }}" {{ $charge->payment_method == $method->name ? 'selected' : '' }}>{{ $method->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">الجهة المودعة</label>
                                                <input type="text" class="form-control" name="payee" value="{{ $charge->payee }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">تاريخ العملية <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" name="transaction_date" value="{{ $charge->transaction_date->format('Y-m-d') }}" required>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">ملاحظات</label>
                                                <textarea class="form-control" name="description" rows="2">{{ $charge->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                                        <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> حفظ التعديلات</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endpermission
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Deposit Modal -->
@permission('Charging accounts')
<div class="modal fade" id="addDepositModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>إيداع مالي جديد</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('accounts.charge.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Deposit Preview -->
                    <div class="card border-success bg-success bg-opacity-10 mb-4">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-arrow-circle-down fa-3x text-success mb-3"></i>
                            <h5 class="text-success mb-0">إضافة رصيد للحساب</h5>
                            <p class="text-muted small mb-0">سيتم تسجيل هذا الإيداع في سجل المعاملات</p>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">الحساب <span class="text-danger">*</span></label>
                            <select class="form-select select2 @error('account_id') is-invalid @enderror" name="account_id" data-placeholder="-- اختر الحساب --" required>
                                <option value="">-- إختر الحساب --</option>
                                @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }} ({{ $account->type }}) - {{ number_format($account->balance, 2) }} {{ $account->currency }}</option>
                                @endforeach
                            </select>
                            @error('account_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">المبلغ <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-success text-white"><i class="fas fa-coins"></i></span>
                                <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" name="amount" placeholder="0.00" required>
                            </div>
                            @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">مصدر الإيداع <span class="text-danger">*</span></label>
                            <select class="form-select select2 @error('source') is-invalid @enderror" name="source" data-placeholder="-- اختر المصدر --" required>
                                <option value="">-- إختر المصدر --</option>
                                <option value="cash_deposit">💵 إيداع نقدي</option>
                                <option value="bank_transfer">🏦 تحويل بنكي</option>
                                <option value="client_payment">👤 دفعة من عميل</option>
                                <option value="trip_payment">🚗 دفعة رحلة</option>
                                <option value="owner_capital">🏛️ رأس مال المالك</option>
                                <option value="loan">💳 قرض</option>
                                <option value="refund">↩️ استرداد</option>
                                <option value="other">📋 أخرى</option>
                            </select>
                            @error('source')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">طريقة الدفع</label>
                            <select class="form-select select2 @error('payment_method') is-invalid @enderror" name="payment_method" data-placeholder="-- اختر طريقة الدفع --">
                                <option value="">-- إختر طريقة الدفع --</option>
                                @foreach ($paymentMethods as $method)
                                <option value="{{ $method->name }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الجهة المودعة</label>
                            <input type="text" class="form-control @error('payee') is-invalid @enderror" name="payee" placeholder="اسم الجهة أو الشخص">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رقم المرجع</label>
                            <input type="text" class="form-control @error('reference_number') is-invalid @enderror" name="reference_number" placeholder="رقم الإيصال (اختياري)">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تاريخ العملية <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" name="transaction_date" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <!-- Empty for alignment -->
                        </div>
                        <div class="col-12">
                            <label class="form-label">ملاحظات</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="2" placeholder="ملاحظات إضافية..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-plus me-1"></i> إضافة الإيداع</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpermission

@endsection
