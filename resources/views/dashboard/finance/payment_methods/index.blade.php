@extends('layouts.master')
@section('title', 'إدارة طرق الدفع')
@section('content')

<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">إدارة طرق الدفع</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">طرق الدفع</li>
            </ol>
        </nav>
    </div>
    @permission('Create Payment Method')
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMethodModal">
            <i class="fas fa-plus me-1"></i> إضافة طريقة دفع
        </button>
    </div>
    @endpermission
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body d-flex align-items-center">
                <div class="avatar bg-white bg-opacity-25 rounded-circle p-3 me-3">
                    <i class="fas fa-credit-card fa-lg text-white"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $paymentMethods->count() }}</h3>
                    <small>إجمالي طرق الدفع</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body d-flex align-items-center">
                <div class="avatar bg-white bg-opacity-25 rounded-circle p-3 me-3">
                    <i class="fas fa-check-circle fa-lg text-white"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $paymentMethods->where('is_active', true)->count() }}</h3>
                    <small>طرق نشطة</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-secondary text-white">
            <div class="card-body d-flex align-items-center">
                <div class="avatar bg-white bg-opacity-25 rounded-circle p-3 me-3">
                    <i class="fas fa-pause-circle fa-lg text-white"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $paymentMethods->where('is_active', false)->count() }}</h3>
                    <small>طرق معطلة</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Methods Grid -->
<div class="row">
    @foreach ($paymentMethods as $method)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 {{ !$method->is_active ? 'opacity-75' : '' }}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar rounded-circle p-3 me-3" style="background: {{ $method->is_active ? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' : '#6c757d' }};">
                            @php
                                $icon = match($method->code) {
                                    'CASH' => 'fa-money-bill-wave',
                                    'BANK' => 'fa-university',
                                    'MADA' => 'fa-credit-card',
                                    'CREDIT' => 'fa-cc-visa',
                                    'APPLE' => 'fa-apple',
                                    'STC' => 'fa-mobile-alt',
                                    'CHECK' => 'fa-money-check',
                                    'TAMARA', 'TABBY' => 'fa-clock',
                                    default => 'fa-wallet'
                                };
                            @endphp
                            <i class="fas {{ $icon }} text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ $method->name }}</h5>
                            <small class="text-muted">
                                <code class="bg-light px-2 py-1 rounded">{{ $method->code ?? 'N/A' }}</code>
                            </small>
                        </div>
                    </div>
                    <span class="badge {{ $method->is_active ? 'bg-success' : 'bg-secondary' }} rounded-pill">
                        {{ $method->is_active ? 'نشط' : 'معطل' }}
                    </span>
                </div>
                
                @if($method->description)
                <p class="text-muted small mb-3">{{ $method->description }}</p>
                @else
                <p class="text-muted small mb-3 fst-italic">لا يوجد وصف</p>
                @endif

                <div class="d-flex gap-2">
                    @permission('Edit Payment Method')
                    <button type="button" class="btn btn-sm btn-outline-primary flex-fill" data-bs-toggle="modal" data-bs-target="#editMethod{{ $method->id }}">
                        <i class="fas fa-edit me-1"></i> تعديل
                    </button>
                    @endpermission
                    @permission('Delete Payment Method')
                    <a href="{{ route('payment_methods.destroy', $method->id) }}" class="btn btn-sm btn-outline-danger" data-confirm-delete="true">
                        <i class="fas fa-trash"></i>
                    </a>
                    @endpermission
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    @permission('Edit Payment Method')
    <div class="modal fade" id="editMethod{{ $method->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>تعديل طريقة الدفع
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('payment_methods.update', $method->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <div class="avatar avatar-lg rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fas {{ $icon }} fa-lg text-white"></i>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">اسم طريقة الدفع <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ $method->name }}" required>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">الرمز</label>
                                <input type="text" class="form-control" name="code" value="{{ $method->code }}" placeholder="CASH, BANK, etc.">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">الحالة</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="edit_is_active_{{ $method->id }}" {{ $method->is_active ? 'checked' : '' }} style="width: 50px; height: 25px;">
                                    <label class="form-check-label ms-2" for="edit_is_active_{{ $method->id }}">
                                        {{ $method->is_active ? 'نشط' : 'معطل' }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">الوصف</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="وصف طريقة الدفع...">{{ $method->description }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> حفظ التعديلات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endpermission
    @endforeach
</div>

<!-- Empty State -->
@if($paymentMethods->isEmpty())
<div class="card border-0 shadow-sm">
    <div class="card-body text-center py-5">
        <div class="avatar bg-light rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-credit-card fa-2x text-muted"></i>
        </div>
        <h5>لا توجد طرق دفع</h5>
        <p class="text-muted">قم بإضافة طرق الدفع المتاحة للنظام</p>
        @permission('Create Payment Method')
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMethodModal">
            <i class="fas fa-plus me-1"></i> إضافة طريقة دفع
        </button>
        @endpermission
    </div>
</div>
@endif

<!-- Table View (Alternative) -->
@if($paymentMethods->isNotEmpty())
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><i class="fas fa-table me-2"></i>عرض الجدول</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="example1">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>طريقة الدفع</th>
                        <th>الرمز</th>
                        <th>الوصف</th>
                        <th>الحالة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentMethods as $index => $method)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @php
                                    $icon = match($method->code) {
                                        'CASH' => 'fa-money-bill-wave',
                                        'BANK' => 'fa-university',
                                        'MADA' => 'fa-credit-card',
                                        'CREDIT' => 'fa-cc-visa',
                                        'APPLE' => 'fa-apple',
                                        'STC' => 'fa-mobile-alt',
                                        'CHECK' => 'fa-money-check',
                                        'TAMARA', 'TABBY' => 'fa-clock',
                                        default => 'fa-wallet'
                                    };
                                @endphp
                                <div class="avatar avatar-sm rounded-circle bg-primary text-white me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas {{ $icon }} small"></i>
                                </div>
                                <strong>{{ $method->name }}</strong>
                            </div>
                        </td>
                        <td><code>{{ $method->code ?? '-' }}</code></td>
                        <td>
                            <span class="text-muted small">{{ Str::limit($method->description, 40) ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $method->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $method->is_active ? 'نشط' : 'معطل' }}
                            </span>
                        </td>
                        <td>
                            @permission('Edit Payment Method')
                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#editMethod{{ $method->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            @endpermission
                            @permission('Delete Payment Method')
                            <a href="{{ route('payment_methods.destroy', $method->id) }}" class="btn btn-sm btn-outline-danger" data-confirm-delete="true">
                                <i class="fas fa-trash"></i>
                            </a>
                            @endpermission
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<!-- Add Method Modal -->
@permission('Create Payment Method')
<div class="modal fade" id="addMethodModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>إضافة طريقة دفع جديدة
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('payment_methods.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="avatar avatar-lg rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-credit-card fa-lg text-white"></i>
                        </div>
                        <p class="text-muted small">أضف طريقة دفع جديدة للنظام</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">اسم طريقة الدفع <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="مثال: نقدي، بطاقة ائتمانية" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">الرمز</label>
                            <input type="text" class="form-control" name="code" placeholder="CASH, BANK, etc.">
                            <small class="text-muted">رمز مختصر بالإنجليزية</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الحالة</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="add_is_active" checked style="width: 50px; height: 25px;">
                                <label class="form-check-label ms-2" for="add_is_active">نشط</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">الوصف</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="وصف مختصر لطريقة الدفع..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> إضافة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpermission

@endsection
