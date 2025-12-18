@extends('layouts.master')
@section('title', 'إدارة الخدمات')
@section('content')

{{-- Page Header --}}
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between animate-fadeInDown">
    <div class="clearfix">
        <h1 class="app-page-title">
            <i class="fas fa-concierge-bell text-primary"></i>
            إدارة الخدمات
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">قائمة الخدمات</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        @permission('create-services')
        <a href="{{ route('services.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> إضافة خدمة
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
                    <div class="stats-number">{{ $services->total() }}</div>
                    <div class="stats-label">إجمالي الخدمات</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-concierge-bell"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 animate-fadeInUp stagger-2">
        <div class="stats-card stats-card-success">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stats-number">{{ $services->where('active', true)->count() }}</div>
                    <div class="stats-label">خدمات نشطة</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 animate-fadeInUp stagger-3">
        <div class="stats-card stats-card-warning">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stats-number">{{ $services->where('active', false)->count() }}</div>
                    <div class="stats-label">خدمات غير نشطة</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-pause-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 animate-fadeInUp stagger-4">
        <div class="stats-card stats-card-info">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stats-number">{{ number_format($services->avg('price'), 0) }}</div>
                    <div class="stats-label">متوسط السعر (ريال)</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-coins"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Search & Filter Card --}}
<div class="card mb-4 animate-fadeInUp">
    <div class="card-body">
        <form method="GET" action="{{ route('services.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-search me-1 text-primary"></i>
                        البحث عن خدمة
                    </label>
                    <div class="search-input-wrapper">
                        <input type="text" name="search" class="form-control form-control-lg" 
                               value="{{ request('search') }}" 
                               placeholder="ابحث بالاسم أو الكود...">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">الحالة</label>
                    <select name="status" class="form-select form-select-lg">
                        <option value="">الكل</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-search me-1"></i> بحث
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('services.index') }}" class="btn btn-outline-secondary btn-lg w-100">
                        <i class="fas fa-redo me-1"></i> إعادة تعيين
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Services Grid --}}
<div class="row mb-4">
    @forelse($services as $index => $service)
    <div class="col-md-6 col-lg-4 mb-4 animate-fadeInUp" style="animation-delay: {{ ($index % 9) * 0.05 }}s">
        <div class="card h-100 hover-lift {{ !$service->active ? 'opacity-75' : '' }}">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar avatar-sm" 
                         style="background: linear-gradient(135deg, #{{ substr(md5($service->code), 0, 6) }} 0%, #{{ substr(md5($service->code), 6, 6) }} 100%);">
                        <i class="fas fa-cog"></i>
                    </div>
                    <code class="bg-light px-2 py-1 rounded">{{ $service->code }}</code>
                </div>
                @if($service->active)
                    <span class="badge badge-soft-success status-badge active">
                        <i class="fas fa-check-circle me-1"></i> نشط
                    </span>
                @else
                    <span class="badge badge-soft-secondary status-badge inactive">
                        <i class="fas fa-pause-circle me-1"></i> غير نشط
                    </span>
                @endif
            </div>
            <div class="card-body">
                <h5 class="card-title fw-bold mb-2">{{ $service->name }}</h5>
                @if($service->description)
                    <p class="card-text text-muted small mb-3">
                        {{ Str::limit($service->description, 80) }}
                    </p>
                @endif
                
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <div class="bg-light rounded-3 px-3 py-2 text-center flex-grow-1">
                        <div class="fw-bold text-primary fs-5">{{ number_format($service->price, 2) }}</div>
                        <small class="text-muted">ريال</small>
                    </div>
                    @if($service->estimated_duration_days)
                    <div class="bg-light rounded-3 px-3 py-2 text-center flex-grow-1">
                        <div class="fw-bold text-info fs-5">{{ $service->estimated_duration_days }}</div>
                        <small class="text-muted">يوم</small>
                    </div>
                    @endif
                    <div class="bg-light rounded-3 px-3 py-2 text-center flex-grow-1">
                        <div class="fw-bold text-success fs-5">{{ $service->transactions_count ?? $service->transactions()->count() }}</div>
                        <small class="text-muted">معاملة</small>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="action-btns justify-content-center">
                    @permission('view-services')
                    <a href="{{ route('services.show', $service->id) }}" 
                       class="btn btn-soft-info btn-sm"
                       data-bs-toggle="tooltip" 
                       title="عرض التفاصيل">
                        <i class="fas fa-eye me-1"></i> عرض
                    </a>
                    @endpermission
                    @permission('edit-services')
                    <a href="{{ route('services.edit', $service->id) }}" 
                       class="btn btn-soft-primary btn-sm"
                       data-bs-toggle="tooltip" 
                       title="تعديل">
                        <i class="fas fa-edit me-1"></i> تعديل
                    </a>
                    @endpermission
                    @permission('delete-services')
                    <form action="{{ route('services.destroy', $service->id) }}" 
                          method="POST" 
                          class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-soft-danger btn-sm"
                                data-bs-toggle="tooltip" 
                                title="حذف">
                            <i class="fas fa-trash me-1"></i> حذف
                        </button>
                    </form>
                    @endpermission
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                    <h5 class="empty-state-title">لا توجد خدمات</h5>
                    <p class="empty-state-text">لم يتم إضافة أي خدمات بعد. ابدأ بإضافة أول خدمة.</p>
                    @permission('create-services')
                    <a href="{{ route('services.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> إضافة خدمة جديدة
                    </a>
                    @endpermission
                </div>
            </div>
        </div>
    </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($services->hasPages())
<div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
    <div class="text-muted small">
        عرض {{ $services->firstItem() }} - {{ $services->lastItem() }} من {{ $services->total() }} خدمة
    </div>
    {{ $services->withQueryString()->links() }}
</div>
@endif

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
                text: 'سيتم حذف هذه الخدمة نهائياً!',
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
