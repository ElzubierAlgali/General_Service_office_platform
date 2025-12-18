@extends('layouts.master')
@section('title', 'إدارة الأذونات')
@section('content')

{{-- Page Header --}}
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between animate-fadeInDown">
    <div class="clearfix">
        <h1 class="app-page-title">
            <i class="fas fa-key text-primary"></i>
            إدارة الأذونات
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">الأذونات</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-shield-alt me-1"></i> إدارة الصلاحيات
        </a>
        <a href="{{ route('permissions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> إضافة أذن
        </a>
    </div>
</div>

{{-- Stats Cards --}}
<div class="row mb-4">
    <div class="col-sm-6 animate-fadeInUp stagger-1">
        <div class="stats-card stats-card-success">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stats-number">{{ $stats['total_permissions'] }}</div>
                    <div class="stats-label">إجمالي الأذونات</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-key"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 animate-fadeInUp stagger-2">
        <div class="stats-card stats-card-primary">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stats-number">{{ $stats['total_roles'] }}</div>
                    <div class="stats-label">إجمالي الصلاحيات</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Search Card --}}
<div class="card mb-4 animate-fadeInUp">
    <div class="card-body">
        <form method="GET" action="{{ route('permissions.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-search me-1 text-primary"></i>
                        البحث عن أذن
                    </label>
                    <div class="search-input-wrapper">
                        <input type="text" name="search" class="form-control form-control-lg" 
                               value="{{ request('search') }}" 
                               placeholder="ابحث بالاسم أو الوصف...">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-search me-1"></i> بحث
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary btn-lg w-100">
                        <i class="fas fa-redo me-1"></i> إعادة تعيين
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Permissions Table --}}
<div class="card animate-fadeInUp">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2 text-primary"></i>
            قائمة الأذونات
        </h5>
        <span class="badge badge-soft-success">{{ $stats['total_permissions'] }} أذن</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="permissionsTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">#</th>
                        <th>الأذن</th>
                        <th>الاسم البرمجي</th>
                        <th class="text-center">الصلاحيات المرتبطة</th>
                        <th>الوصف</th>
                        <th class="text-center" style="width: 150px;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $index => $permission)
                    <tr class="animate-fadeIn" style="animation-delay: {{ ($index % 10) * 0.05 }}s">
                        <td class="text-center fw-semibold text-muted">{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3" 
                                     style="background: linear-gradient(135deg, #00b894 0%, #55efc4 100%);">
                                    <i class="fas fa-key"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $permission->display_name }}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <code class="bg-light px-2 py-1 rounded">{{ $permission->name }}</code>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-soft-primary">
                                <i class="fas fa-shield-alt me-1"></i>
                                {{ $permission->roles_count }} صلاحية
                            </span>
                        </td>
                        <td>
                            <span class="text-muted small">{{ Str::limit($permission->description, 50) ?? '-' }}</span>
                        </td>
                        <td>
                            <div class="action-btns justify-content-center">
                                <a href="{{ route('permissions.show', $permission->id) }}" 
                                   class="btn btn-soft-info btn-icon btn-sm"
                                   data-bs-toggle="tooltip" 
                                   title="عرض التفاصيل">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('permissions.edit', $permission->id) }}" 
                                   class="btn btn-soft-primary btn-icon btn-sm"
                                   data-bs-toggle="tooltip" 
                                   title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($permission->roles_count == 0)
                                <form action="{{ route('permissions.destroy', $permission->id) }}" 
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
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-key"></i>
                                </div>
                                <h5 class="empty-state-title">لا توجد أذونات</h5>
                                <p class="empty-state-text">لم يتم إضافة أي أذونات بعد.</p>
                                <a href="{{ route('permissions.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i> إضافة أذن جديد
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#permissionsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json'
            },
            order: [[0, 'asc']],
            pageLength: 25,
            responsive: true
        });
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Delete confirmation
        $('.delete-form').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'سيتم حذف هذا الأذن نهائياً!',
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
