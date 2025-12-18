@extends('layouts.master')
@section('title', 'إدارة العملاء')
@section('content')

{{-- Page Header --}}
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between animate-fadeInDown">
    <div class="clearfix">
        <h1 class="app-page-title">
            <i class="fas fa-users text-primary"></i>
            إدارة العملاء
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">قائمة العملاء</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        @permission('create-customers')
        <a href="{{ route('customers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> إضافة عميل
        </a>
        @endpermission
    </div>
</div>

{{-- Stats Cards --}}
<div class="row mb-4">
    <div class="col-sm-6 col-lg-3 animate-fadeInUp stagger-1">
        <div class="stats-card stats-card-primary">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stats-number">{{ $customers->total() }}</div>
                    <div class="stats-label">إجمالي العملاء</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 animate-fadeInUp stagger-2">
        <div class="stats-card stats-card-success">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stats-number">{{ $customers->where('created_at', '>=', now()->subMonth())->count() }}</div>
                    <div class="stats-label">عملاء جدد هذا الشهر</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 animate-fadeInUp stagger-3">
        <div class="stats-card stats-card-info">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stats-number">{{ $customers->whereNotNull('email')->count() }}</div>
                    <div class="stats-label">لديهم بريد إلكتروني</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 animate-fadeInUp stagger-4">
        <div class="stats-card stats-card-warning">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stats-number">{{ $customers->whereNotNull('phone')->count() }}</div>
                    <div class="stats-label">لديهم رقم هاتف</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-phone"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Search & Filter Card --}}
<div class="card mb-4 animate-fadeInUp">
    <div class="card-body">
        <form method="GET" action="{{ route('customers.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-search me-1 text-primary"></i>
                        البحث عن عميل
                    </label>
                    <div class="search-input-wrapper">
                        <input type="text" name="search" class="form-control form-control-lg" 
                               value="{{ request('search') }}" 
                               placeholder="ابحث بالاسم، البريد الإلكتروني، الهاتف، أو رقم الهوية...">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-search me-1"></i> بحث
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary btn-lg w-100">
                        <i class="fas fa-redo me-1"></i> إعادة تعيين
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Customers Table --}}
<div class="card animate-fadeInUp">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2 text-primary"></i>
            قائمة العملاء
        </h5>
        <span class="badge bg-primary badge-soft-primary">
            {{ $customers->total() }} عميل
        </span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="customersTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">#</th>
                        <th>العميل</th>
                        <th>معلومات الاتصال</th>
                        <th>رقم الهوية</th>
                        <th>الموقع</th>
                        <th class="text-center">المعاملات</th>
                        <th class="text-center" style="width: 150px;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $index => $customer)
                    <tr class="animate-fadeIn" style="animation-delay: {{ ($index % 10) * 0.05 }}s">
                        <td class="text-center fw-semibold text-muted">
                            {{ $customers->firstItem() + $index }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md me-3" 
                                     style="background: linear-gradient(135deg, #{{ substr(md5($customer->name), 0, 6) }} 0%, #{{ substr(md5($customer->name), 6, 6) }} 100%);">
                                    {{ mb_substr($customer->name, 0, 2) }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $customer->name }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        انضم {{ $customer->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                @if($customer->email)
                                    <a href="mailto:{{ $customer->email }}" class="text-decoration-none small">
                                        <i class="fas fa-envelope me-1 text-primary"></i>
                                        {{ $customer->email }}
                                    </a>
                                @endif
                                @if($customer->phone)
                                    <a href="tel:{{ $customer->phone }}" class="text-decoration-none small">
                                        <i class="fas fa-phone me-1 text-success"></i>
                                        {{ $customer->phone }}
                                    </a>
                                @endif
                                @if(!$customer->email && !$customer->phone)
                                    <span class="text-muted small">
                                        <i class="fas fa-minus-circle me-1"></i>
                                        لا توجد معلومات اتصال
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($customer->national_id)
                                <span class="badge badge-soft-primary">
                                    <i class="fas fa-id-card me-1"></i>
                                    {{ $customer->national_id }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($customer->city)
                                <span class="small">
                                    <i class="fas fa-map-marker-alt me-1 text-danger"></i>
                                    {{ $customer->city }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge badge-soft-info">
                                <i class="fas fa-file-alt me-1"></i>
                                {{ $customer->transactions_count ?? $customer->transactions()->count() }}
                            </span>
                        </td>
                        <td>
                            <div class="action-btns justify-content-center">
                                @permission('view-customers')
                                <a href="{{ route('customers.show', $customer->id) }}" 
                                   class="btn btn-soft-info btn-icon btn-sm" 
                                   data-bs-toggle="tooltip" 
                                   title="عرض التفاصيل">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endpermission
                                @permission('edit-customers')
                                <a href="{{ route('customers.edit', $customer->id) }}" 
                                   class="btn btn-soft-primary btn-icon btn-sm" 
                                   data-bs-toggle="tooltip" 
                                   title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endpermission
                                @permission('delete-customers')
                                <form action="{{ route('customers.destroy', $customer->id) }}" 
                                      method="POST" 
                                      class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-soft-danger btn-icon btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endpermission
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h5 class="empty-state-title">لا يوجد عملاء</h5>
                                <p class="empty-state-text">لم يتم إضافة أي عملاء بعد. ابدأ بإضافة أول عميل.</p>
                                @permission('create-customers')
                                <a href="{{ route('customers.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i> إضافة عميل جديد
                                </a>
                                @endpermission
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($customers->hasPages())
    <div class="card-footer bg-transparent">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="text-muted small">
                عرض {{ $customers->firstItem() }} - {{ $customers->lastItem() }} من {{ $customers->total() }} عميل
            </div>
            {{ $customers->withQueryString()->links() }}
        </div>
    </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Delete confirmation with SweetAlert
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'سيتم حذف هذا العميل نهائياً ولن تتمكن من استرجاعه!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-1"></i> نعم، احذف',
                cancelButtonText: '<i class="fas fa-times me-1"></i> إلغاء',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
