@extends('layouts.master')
@section('title', 'إدارة الحسابات المالية')
@section('content')

<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">إدارة الحسابات المالية</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">الحسابات المالية</li>
            </ol>
        </nav>
    </div>
    @permission('Create Financial Accounts')
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccountModal">
            <i class="fas fa-plus me-1"></i> إضافة حساب
        </button>
    </div>
    @endpermission
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body d-flex align-items-center">
                <div class="avatar bg-white bg-opacity-25 rounded-circle p-3 me-3">
                    <i class="fas fa-wallet fa-lg text-white"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ number_format($accounts->sum('balance'), 2) }}</h3>
                    <small>إجمالي الأرصدة</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body d-flex align-items-center">
                <div class="avatar bg-white bg-opacity-25 rounded-circle p-3 me-3">
                    <i class="fas fa-piggy-bank fa-lg text-white"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $accounts->count() }}</h3>
                    <small>عدد الحسابات</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body d-flex align-items-center">
                <div class="avatar bg-white bg-opacity-25 rounded-circle p-3 me-3">
                    <i class="fas fa-money-bill-wave fa-lg text-white"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ number_format($accounts->where('type', 'cash')->sum('balance'), 2) }}</h3>
                    <small>الرصيد النقدي</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-white">
            <div class="card-body d-flex align-items-center">
                <div class="avatar bg-white bg-opacity-25 rounded-circle p-3 me-3">
                    <i class="fas fa-university fa-lg text-white"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ number_format($accounts->where('type', 'bank')->sum('balance'), 2) }}</h3>
                    <small>الرصيد البنكي</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Accounts Grid -->
<div class="row">
    @foreach ($accounts as $account)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center">
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
                        <div class="avatar rounded-circle p-3 me-3" style="background: {{ $bgColor }};">
                            <i class="fas {{ $iconClass }} text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ $account->name }}</h5>
                            <small class="text-muted">
                                @switch($account->type)
                                    @case('cash') نقدي @break
                                    @case('bank') بنكي @break
                                    @case('wallet') محفظة @break
                                    @case('credit_card') بطاقة ائتمان @break
                                    @default {{ $account->type }}
                                @endswitch
                            </small>
                        </div>
                    </div>
                    <span class="badge bg-light text-dark">{{ $account->currency }}</span>
                </div>
                
                <div class="text-center py-3">
                    <h2 class="mb-0 {{ $account->balance >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ number_format($account->balance, 2) }}
                    </h2>
                    <small class="text-muted">الرصيد الحالي</small>
                </div>

                <div class="d-flex gap-2 mt-3">
                    @permission('Edit Financial Accounts')
                    <button type="button" class="btn btn-sm btn-outline-primary flex-fill" data-bs-toggle="modal" data-bs-target="#editAccount{{ $account->id }}">
                        <i class="fas fa-edit me-1"></i> تعديل
                    </button>
                    @endpermission
                    @permission('Delete Financial Accounts')
                    <a href="{{ route('accounts.destroy', $account->id) }}" class="btn btn-sm btn-outline-danger" data-confirm-delete="true">
                        <i class="fas fa-trash"></i>
                    </a>
                    @endpermission
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    @permission('Edit Financial Accounts')
    <div class="modal fade" id="editAccount{{ $account->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>تعديل الحساب</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('accounts.update', $account->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">اسم الحساب <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ $account->name }}" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">نوع الحساب <span class="text-danger">*</span></label>
                                <select class="form-select select2" name="type" data-placeholder="-- اختر النوع --" required>
                                    @foreach (accountsType() as $type)
                                    <option value="{{ $type }}" {{ $account->type == $type ? 'selected' : '' }}>
                                        @switch($type)
                                            @case('cash') نقدي @break
                                            @case('bank') بنكي @break
                                            @case('wallet') محفظة @break
                                            @case('credit_card') بطاقة ائتمان @break
                                            @default {{ $type }}
                                        @endswitch
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">العملة <span class="text-danger">*</span></label>
                                <select class="form-select select2" name="currency" data-placeholder="-- اختر العملة --" required>
                                    @foreach (currencies() as $currency)
                                    <option value="{{ $currency }}" {{ $account->currency == $currency ? 'selected' : '' }}>{{ $currency }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endpermission
    @endforeach
</div>

<!-- Add Account Modal -->
@permission('Create Financial Accounts')
<div class="modal fade" id="addAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>إضافة حساب جديد</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('accounts.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="avatar avatar-lg rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-piggy-bank fa-lg text-white"></i>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">اسم الحساب <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="مثال: الصندوق الرئيسي" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">نوع الحساب <span class="text-danger">*</span></label>
                            <select class="form-select select2 @error('type') is-invalid @enderror" name="type" data-placeholder="-- اختر النوع --" required>
                                <option value="">-- اختر النوع --</option>
                                @foreach (accountsType() as $type)
                                <option value="{{ $type }}">
                                    @switch($type)
                                        @case('cash') نقدي @break
                                        @case('bank') بنكي @break
                                        @case('wallet') محفظة @break
                                        @case('credit_card') بطاقة ائتمان @break
                                        @default {{ $type }}
                                    @endswitch
                                </option>
                                @endforeach
                            </select>
                            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">العملة <span class="text-danger">*</span></label>
                            <select class="form-select select2 @error('currency') is-invalid @enderror" name="currency" data-placeholder="-- اختر العملة --" required>
                                <option value="">-- اختر العملة --</option>
                                @foreach (currencies() as $currency)
                                <option value="{{ $currency }}">{{ $currency }}</option>
                                @endforeach
                            </select>
                            @error('currency')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus me-1"></i> إضافة</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpermission

@endsection
