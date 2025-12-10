@extends('layouts.master')
@section('title', 'التحويل بين الحسابات')
@section('content')

<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">التحويل بين الحسابات</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">التحويل بين الحسابات</li>
            </ol>
        </nav>
    </div>
    @permission('Transfer Between Accounts')
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransferModal">
            <i class="fas fa-exchange-alt me-1"></i> تحويل جديد
        </button>
    </div>
    @endpermission
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body position-relative">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); opacity: 0.1;"></div>
                <div class="d-flex align-items-center position-relative">
                    <div class="avatar rounded-circle p-3 me-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-exchange-alt fa-lg text-white"></i>
                    </div>
                    <div>
                        <h3 class="mb-0" style="color: #667eea;">{{ number_format($transfers->sum('amount'), 2) }}</h3>
                        <small class="text-muted">إجمالي التحويلات</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body position-relative">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); opacity: 0.1;"></div>
                <div class="d-flex align-items-center position-relative">
                    <div class="avatar rounded-circle p-3 me-3" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                        <i class="fas fa-sync-alt fa-lg text-white"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 text-primary">{{ $transfers->count() }}</h3>
                        <small class="text-muted">عدد عمليات التحويل</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body position-relative">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%); opacity: 0.1;"></div>
                <div class="d-flex align-items-center position-relative">
                    <div class="avatar rounded-circle p-3 me-3" style="background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);">
                        <i class="fas fa-calendar-alt fa-lg text-white"></i>
                    </div>
                    <div>
                        <h3 class="mb-0" style="color: #16a085;">{{ $transfers->where('transaction_date', '>=', now()->startOfMonth())->count() }}</h3>
                        <small class="text-muted">تحويلات هذا الشهر</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Account Balances -->
<div class="row mb-4">
    @foreach($accounts as $account)
    <div class="col-lg-3 col-md-6 mb-3">
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
                        $bgColor = match($account->type) {
                            'cash' => 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)',
                            'bank' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                            'wallet' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                            'credit_card' => 'linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%)',
                            default => 'linear-gradient(135deg, #868f96 0%, #596164 100%)'
                        };
                    @endphp
                    <div class="avatar rounded-circle p-2" style="background: {{ $bgColor }};">
                        <i class="fas {{ $iconClass }} text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Transfers Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0"><i class="fas fa-history me-2 text-primary"></i>سجل التحويلات</h5>
            <small class="text-muted">جميع عمليات التحويل بين الحسابات</small>
        </div>
    </div>
    <div class="card-body">
        @if($transfers->isEmpty())
        <div class="text-center py-5">
            <div class="avatar rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-exchange-alt fa-2x text-white"></i>
            </div>
            <h5>لا توجد تحويلات</h5>
            <p class="text-muted">لم تقم بأي عمليات تحويل بين الحسابات بعد</p>
            @permission('Transfer Between Accounts')
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransferModal">
                <i class="fas fa-plus me-1"></i> إنشاء تحويل جديد
            </button>
            @endpermission
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover" id="example1">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>التاريخ</th>
                        <th>من حساب</th>
                        <th>إلى حساب</th>
                        <th>المبلغ</th>
                        <th>رقم المرجع</th>
                        <th>الملاحظات</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($transfers as $index => $transfer)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm rounded me-2" style="width: 36px; height: 36px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-exchange-alt text-white small"></i>
                                </div>
                                <div>
                                    <span class="d-block">{{ $transfer->transaction_date->format('Y-m-d') }}</span>
                                    <small class="text-muted">{{ $transfer->transaction_date->diffForHumans() }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs rounded-circle bg-danger bg-opacity-10 me-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                    <i class="fas fa-arrow-up text-danger" style="font-size: 10px;"></i>
                                </div>
                                <span class="text-danger fw-medium">{{ $transfer->account->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs rounded-circle bg-success bg-opacity-10 me-2 d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                    <i class="fas fa-arrow-down text-success" style="font-size: 10px;"></i>
                                </div>
                                <span class="text-success fw-medium">{{ $transfer->toAccount->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold fs-6" style="color: #667eea;">{{ number_format($transfer->amount, 2) }}</span>
                            <small class="text-muted">{{ $transfer->currency }}</small>
                        </td>
                        <td>
                            @if($transfer->reference_number)
                            <code class="bg-light px-2 py-1 rounded small">{{ $transfer->reference_number }}</code>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-muted small">{{ Str::limit($transfer->description, 30) ?? '-' }}</span>
                        </td>
                        <td>
                            @permission('Transfer Between Accounts')
                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#editTransfer{{ $transfer->id }}" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="{{ route('accounts.transfer.destroy', $transfer->id) }}" class="btn btn-sm btn-outline-danger" data-confirm-delete="true" title="حذف">
                                <i class="fas fa-trash"></i>
                            </a>
                            @endpermission
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    @permission('Transfer Between Accounts')
                    <div class="modal fade" id="editTransfer{{ $transfer->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>تعديل التحويل</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('accounts.transfer.update', $transfer->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">من حساب <span class="text-danger">*</span></label>
                                                <select class="form-select select2" name="from_account_id" data-placeholder="-- اختر الحساب المصدر --" required>
                                                    @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}" {{ $transfer->account_id == $account->id ? 'selected' : '' }}>
                                                        {{ $account->name }} ({{ $account->type }})
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">إلى حساب <span class="text-danger">*</span></label>
                                                <select class="form-select select2" name="to_account_id" data-placeholder="-- اختر الحساب المستلم --" required>
                                                    @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}" {{ $transfer->to_account_id == $account->id ? 'selected' : '' }}>
                                                        {{ $account->name }} ({{ $account->type }})
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">المبلغ <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;"><i class="fas fa-coins"></i></span>
                                                    <input type="number" step="0.01" class="form-control" name="amount" value="{{ $transfer->amount }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">تاريخ التحويل <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" name="transaction_date" value="{{ $transfer->transaction_date->format('Y-m-d') }}" required>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">ملاحظات</label>
                                                <textarea class="form-control" name="description" rows="2">{{ $transfer->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> حفظ التعديلات</button>
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
        @endif
    </div>
</div>

<!-- Add Transfer Modal -->
@permission('Transfer Between Accounts')
<div class="modal fade" id="addTransferModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h5 class="modal-title"><i class="fas fa-exchange-alt me-2"></i>تحويل جديد بين الحسابات</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('accounts.transfer.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Transfer Preview -->
                    <div class="card border-0 mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <div class="card-body text-white text-center py-4">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="avatar rounded-circle bg-white bg-opacity-25 mx-auto mb-2" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-wallet fa-lg text-white"></i>
                                    </div>
                                    <small id="fromAccountName">الحساب المصدر</small>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-arrow-left fa-2x text-white-50"></i>
                                </div>
                                <div class="col">
                                    <div class="avatar rounded-circle bg-white bg-opacity-25 mx-auto mb-2" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-wallet fa-lg text-white"></i>
                                    </div>
                                    <small id="toAccountName">الحساب المستلم</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">من حساب <span class="text-danger">*</span></label>
                            <select class="form-select select2 @error('from_account_id') is-invalid @enderror" name="from_account_id" id="from_account_id" data-placeholder="-- اختر الحساب المصدر --" required>
                                <option value="">-- إختر الحساب المصدر --</option>
                                @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" data-balance="{{ $account->balance }}" data-currency="{{ $account->currency }}" data-name="{{ $account->name }}">
                                    {{ $account->name }} ({{ $account->type }}) - {{ number_format($account->balance, 2) }} {{ $account->currency }}
                                </option>
                                @endforeach
                            </select>
                            @error('from_account_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">إلى حساب <span class="text-danger">*</span></label>
                            <select class="form-select select2 @error('to_account_id') is-invalid @enderror" name="to_account_id" id="to_account_id" data-placeholder="-- اختر الحساب المستلم --" required>
                                <option value="">-- إختر الحساب المستلم --</option>
                                @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" data-name="{{ $account->name }}">
                                    {{ $account->name }} ({{ $account->type }}) - {{ number_format($account->balance, 2) }} {{ $account->currency }}
                                </option>
                                @endforeach
                            </select>
                            @error('to_account_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">المبلغ <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;"><i class="fas fa-coins"></i></span>
                                <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" name="amount" id="transfer_amount" placeholder="0.00" required>
                            </div>
                            <small class="text-muted" id="balance_hint"></small>
                            @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تاريخ التحويل <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" name="transaction_date" value="{{ date('Y-m-d') }}" required>
                            @error('transaction_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">ملاحظات</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="2" placeholder="سبب التحويل أو ملاحظات إضافية..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-exchange-alt me-1"></i> تنفيذ التحويل</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpermission

@endsection

@section('scripts')
<script>
    // Update account names in preview
    document.getElementById('from_account_id')?.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const balance = selectedOption.dataset.balance || 0;
        const currency = selectedOption.dataset.currency || 'SAR';
        const name = selectedOption.dataset.name || 'الحساب المصدر';
        const hint = document.getElementById('balance_hint');
        
        document.getElementById('fromAccountName').textContent = name;
        
        if (balance > 0) {
            hint.innerHTML = `<i class="fas fa-info-circle me-1"></i>الرصيد المتاح: <strong class="text-success">${parseFloat(balance).toLocaleString('en-US', {minimumFractionDigits: 2})} ${currency}</strong>`;
            hint.classList.remove('text-danger');
            hint.classList.add('text-muted');
        } else if (this.value) {
            hint.innerHTML = `<i class="fas fa-exclamation-triangle me-1"></i><span class="text-danger">لا يوجد رصيد متاح في هذا الحساب</span>`;
        } else {
            hint.innerHTML = '';
        }
    });

    document.getElementById('to_account_id')?.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const name = selectedOption.dataset.name || 'الحساب المستلم';
        document.getElementById('toAccountName').textContent = name;
    });

    // Validate amount doesn't exceed balance
    document.getElementById('transfer_amount')?.addEventListener('input', function() {
        const fromSelect = document.getElementById('from_account_id');
        const selectedOption = fromSelect.options[fromSelect.selectedIndex];
        const balance = parseFloat(selectedOption.dataset.balance) || 0;
        const amount = parseFloat(this.value) || 0;
        const hint = document.getElementById('balance_hint');
        const currency = selectedOption.dataset.currency || 'SAR';
        
        if (amount > balance && balance > 0) {
            hint.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i><span class="text-danger">المبلغ (${amount.toLocaleString('en-US', {minimumFractionDigits: 2})}) أكبر من الرصيد المتاح (${balance.toLocaleString('en-US', {minimumFractionDigits: 2})} ${currency})</span>`;
        } else if (fromSelect.value && balance > 0) {
            hint.innerHTML = `<i class="fas fa-info-circle me-1"></i>الرصيد المتاح: <strong class="text-success">${balance.toLocaleString('en-US', {minimumFractionDigits: 2})} ${currency}</strong>`;
        }
    });
</script>
@endsection
