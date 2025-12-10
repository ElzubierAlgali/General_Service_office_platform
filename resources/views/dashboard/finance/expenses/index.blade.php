@extends('layouts.master')
@section('title', 'إدارة المصروفات')
@section('content')

<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">إدارة المصروفات</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">المصروفات</li>
            </ol>
        </nav>
    </div>
    @permission('Create Expense')
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
            <i class="fas fa-plus me-1"></i> إضافة مصروف
        </button>
    </div>
    @endpermission
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body position-relative">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); opacity: 0.1;"></div>
                <div class="d-flex align-items-center position-relative">
                    <div class="avatar rounded-circle p-3 me-3" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">
                        <i class="fas fa-receipt fa-lg text-white"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 text-danger">{{ number_format($expenses->sum('total_amount'), 2) }}</h3>
                        <small class="text-muted">إجمالي المصروفات</small>
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
                        <i class="fas fa-file-invoice fa-lg text-white"></i>
                    </div>
                    <div>
                        <h3 class="mb-0 text-primary">{{ $expenses->count() }}</h3>
                        <small class="text-muted">عدد المصروفات</small>
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
                        <i class="fas fa-percentage fa-lg text-white"></i>
                    </div>
                    <div>
                        <h3 class="mb-0" style="color: #8e44ad;">{{ number_format($expenses->sum('tax_amount'), 2) }}</h3>
                        <small class="text-muted">إجمالي الضرائب</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-body position-relative">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%); opacity: 0.1;"></div>
                <div class="d-flex align-items-center position-relative">
                    <div class="avatar rounded-circle p-3 me-3" style="background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);">
                        <i class="fas fa-calendar-day fa-lg text-white"></i>
                    </div>
                    <div>
                        <h3 class="mb-0" style="color: #16a085;">{{ $expenses->where('expense_date', '>=', now()->startOfMonth())->count() }}</h3>
                        <small class="text-muted">مصروفات هذا الشهر</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Expenses Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0"><i class="fas fa-list-ul me-2 text-primary"></i>قائمة المصروفات</h5>
            <small class="text-muted">جميع المصروفات المسجلة</small>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="example1">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>التاريخ</th>
                        <th>التصنيف</th>
                        <th>المبلغ</th>
                        <th>الضريبة</th>
                        <th>الإجمالي</th>
                        <th>الحساب</th>
                        <th>التاجر</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($expenses as $index => $expense)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm rounded me-2" style="width: 36px; height: 36px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-calendar text-white small"></i>
                                </div>
                                <div>
                                    <span class="d-block">{{ $expense->expense_date->format('Y-m-d') }}</span>
                                    <small class="text-muted">{{ $expense->expense_date->diffForHumans() }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($expense->category)
                            <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                <i class="fas fa-tag me-1"></i>{{ $expense->category->name }}
                            </span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td><span class="fw-semibold">{{ number_format($expense->amount, 2) }}</span> <small class="text-muted">{{ $expense->currency }}</small></td>
                        <td>
                            @if($expense->tax_amount > 0)
                            <span class="text-danger">{{ number_format($expense->tax_amount, 2) }}</span>
                            @if($expense->is_tax_included)
                            <small class="badge bg-secondary">مشمولة</small>
                            @endif
                            @else
                            <span class="text-muted">0.00</span>
                            @endif
                        </td>
                        <td><span class="fw-bold text-danger">{{ number_format($expense->total_amount, 2) }}</span></td>
                        <td>
                            @if($expense->account)
                            <span class="badge bg-info-subtle text-info">{{ $expense->account->name }}</span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $expense->merchant ?? '-' }}</td>
                        <td>
                            @permission('Edit Expense')
                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#editExpense{{ $expense->id }}" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </button>
                            @endpermission
                            @permission('Delete Expense')
                            <a href="{{ route('expenses.destroy', $expense->id) }}" class="btn btn-sm btn-outline-danger" data-confirm-delete="true" title="حذف">
                                <i class="fas fa-trash"></i>
                            </a>
                            @endpermission
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    @permission('Edit Expense')
                    <div class="modal fade" id="editExpense{{ $expense->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>تعديل المصروف</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">المبلغ <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                                    <input type="number" step="0.01" class="form-control edit-amount" name="amount" id="edit_amount_{{ $expense->id }}" value="{{ $expense->amount }}" required onchange="calculateTax('edit_{{ $expense->id }}')">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">الضريبة</label>
                                                <select class="form-select select2" id="edit_tax_id_{{ $expense->id }}" data-placeholder="-- اختر الضريبة --" onchange="calculateTax('edit_{{ $expense->id }}')">
                                                    <option value="" data-rate="0">-- بدون ضريبة --</option>
                                                    @foreach ($taxes as $tax)
                                                    <option value="{{ $tax->id }}" data-rate="{{ $tax->tax_rate }}">{{ $tax->name }} ({{ $tax->tax_rate }}%)</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">مبلغ الضريبة</label>
                                                <input type="number" step="0.01" class="form-control" name="tax_amount" id="edit_tax_amount_{{ $expense->id }}" value="{{ $expense->tax_amount }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label d-block">&nbsp;</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="is_tax_included" id="is_tax_included_{{ $expense->id }}" {{ $expense->is_tax_included ? 'checked' : '' }} onchange="calculateTax('edit_{{ $expense->id }}')">
                                                    <label class="form-check-label" for="is_tax_included_{{ $expense->id }}">الضريبة مشمولة في المبلغ</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">العملة</label>
                                                <select class="form-select select2" name="currency" data-placeholder="-- اختر العملة --">
                                                    @foreach (currencies() as $currency)
                                                    <option value="{{ $currency }}" {{ $expense->currency == $currency ? 'selected' : '' }}>{{ $currency }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">التصنيف</label>
                                                <select class="form-select select2" name="category_id" data-placeholder="-- اختر التصنيف --">
                                                    <option value="">-- إختر التصنيف --</option>
                                                    @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $expense->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">الحساب</label>
                                                <select class="form-select select2" name="account_id" data-placeholder="-- اختر الحساب --">
                                                    <option value="">-- إختر الحساب --</option>
                                                    @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}" {{ $expense->account_id == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">طريقة الدفع</label>
                                                <select class="form-select select2" name="payment_method" data-placeholder="-- اختر طريقة الدفع --">
                                                    <option value="">-- إختر طريقة الدفع --</option>
                                                    @foreach ($paymentMethods as $method)
                                                    <option value="{{ $method->name }}" {{ $expense->payment_method == $method->name ? 'selected' : '' }}>{{ $method->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">تاريخ المصروف <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" name="expense_date" value="{{ $expense->expense_date->format('Y-m-d') }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">التاجر/المورد</label>
                                                <input type="text" class="form-control" name="merchant" value="{{ $expense->merchant }}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">الوصف</label>
                                                <textarea class="form-control" name="description" rows="2">{{ $expense->description }}</textarea>
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
    </div>
</div>

<!-- Add Expense Modal -->
@permission('Create Expense')
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>إضافة مصروف جديد</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('expenses.store') }}" method="POST" id="createExpenseForm">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Amount & Tax Section -->
                        <div class="col-12">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="text-primary mb-3"><i class="fas fa-calculator me-2"></i>المبلغ والضريبة</h6>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label">المبلغ <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-primary text-white"><i class="fas fa-coins"></i></span>
                                                <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" name="amount" id="create_amount" placeholder="0.00" required>
                                            </div>
                                            @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">الضريبة</label>
                                            <select class="form-select select2" id="create_tax_id" data-placeholder="-- اختر الضريبة --" onchange="calculateTax('create')">
                                                <option value="" data-rate="0">-- بدون ضريبة --</option>
                                                @foreach ($taxes as $tax)
                                                <option value="{{ $tax->id }}" data-rate="{{ $tax->tax_rate }}">{{ $tax->name }} ({{ $tax->tax_rate }}%)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">مبلغ الضريبة</label>
                                            <input type="number" step="0.01" class="form-control bg-light" name="tax_amount" id="create_tax_amount" value="0" readonly>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_tax_included" id="is_tax_included" checked onchange="calculateTax('create')">
                                                <label class="form-check-label" for="is_tax_included">الضريبة مشمولة في المبلغ</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Category & Account -->
                        <div class="col-md-6">
                            <label class="form-label">التصنيف</label>
                            <select class="form-select select2 @error('category_id') is-invalid @enderror" name="category_id" data-placeholder="-- اختر التصنيف --">
                                <option value="">-- إختر التصنيف --</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الحساب</label>
                            <select class="form-select select2 @error('account_id') is-invalid @enderror" name="account_id" data-placeholder="-- اختر الحساب --">
                                <option value="">-- إختر الحساب --</option>
                                @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }} ({{ $account->type }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Payment & Currency -->
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
                            <label class="form-label">العملة</label>
                            <select class="form-select select2 @error('currency') is-invalid @enderror" name="currency" data-placeholder="-- اختر العملة --">
                                @foreach (currencies() as $currency)
                                <option value="{{ $currency }}" {{ $currency == 'SAR' ? 'selected' : '' }}>{{ $currency }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Merchant & Date -->
                        <div class="col-md-6">
                            <label class="form-label">التاجر/المورد</label>
                            <input type="text" class="form-control @error('merchant') is-invalid @enderror" name="merchant" placeholder="اسم التاجر أو المورد">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تاريخ المصروف <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('expense_date') is-invalid @enderror" name="expense_date" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label">الوصف</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="2" placeholder="وصف المصروف..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-plus me-1"></i> إضافة المصروف</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpermission

@endsection

@section('scripts')
<script>
    function calculateTax(prefix) {
        let amountField, taxSelect, taxAmountField, isTaxIncludedField;

        if (prefix === 'create') {
            amountField = document.getElementById('create_amount');
            taxSelect = document.getElementById('create_tax_id');
            taxAmountField = document.getElementById('create_tax_amount');
            isTaxIncludedField = document.getElementById('is_tax_included');
        } else {
            const expenseId = prefix.replace('edit_', '');
            amountField = document.getElementById('edit_amount_' + expenseId);
            taxSelect = document.getElementById('edit_tax_id_' + expenseId);
            taxAmountField = document.getElementById('edit_tax_amount_' + expenseId);
            isTaxIncludedField = document.getElementById('is_tax_included_' + expenseId);
        }

        const amount = parseFloat(amountField.value) || 0;
        const selectedOption = taxSelect.options[taxSelect.selectedIndex];
        const taxRate = parseFloat(selectedOption.dataset.rate) || 0;
        const isTaxIncluded = isTaxIncludedField.checked;

        let taxAmount = 0;

        if (taxRate > 0) {
            if (isTaxIncluded) {
                taxAmount = amount - (amount / (1 + taxRate / 100));
            } else {
                taxAmount = amount * (taxRate / 100);
            }
        }

        taxAmountField.value = taxAmount.toFixed(2);
    }

    document.getElementById('create_amount')?.addEventListener('input', function() {
        calculateTax('create');
    });
</script>
@endsection
