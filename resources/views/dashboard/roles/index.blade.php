@extends('layouts.master')
@section('title', 'إدارة الصلاحيات')
@section('content')

{{-- Page Header --}}
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between animate-fadeInDown">
    <div class="clearfix">
        <h1 class="app-page-title">
            <i class="fas fa-shield-alt text-primary"></i>
            إدارة الصلاحيات والأدوار
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">الصلاحيات</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-key me-1"></i> إدارة الأذونات
        </a>
        <a href="{{ route('roles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> إضافة صلاحية
        </a>
    </div>
</div>

{{-- Stats Cards --}}
<div class="row mb-4">
    <div class="col-sm-6 col-lg-3 animate-fadeInUp stagger-1">
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
    <div class="col-sm-6 col-lg-3 animate-fadeInUp stagger-2">
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
    <div class="col-sm-6 col-lg-3 animate-fadeInUp stagger-3">
        <div class="stats-card stats-card-info">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stats-number">{{ $stats['total_users'] }}</div>
                    <div class="stats-label">إجمالي المستخدمين</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 animate-fadeInUp stagger-4">
        <div class="stats-card stats-card-warning">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stats-number">{{ $stats['users_without_role'] }}</div>
                    <div class="stats-label">بدون صلاحية</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-user-slash"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Roles Table --}}
<div class="card animate-fadeInUp">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2 text-primary"></i>
            قائمة الصلاحيات
        </h5>
        <span class="badge badge-soft-primary">{{ $stats['total_roles'] }} صلاحية</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="rolesTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">#</th>
                        <th>الصلاحية</th>
                        <th>الاسم البرمجي</th>
                        <th class="text-center">المستخدمين</th>
                        <th class="text-center">الأذونات</th>
                        <th>الوصف</th>
                        <th class="text-center" style="width: 180px;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $index => $role)
                    <tr class="animate-fadeIn" style="animation-delay: {{ ($index % 10) * 0.05 }}s">
                        <td class="text-center fw-semibold text-muted">{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3" 
                                     style="background: linear-gradient(135deg, #{{ substr(md5($role->name), 0, 6) }} 0%, #{{ substr(md5($role->name), 6, 6) }} 100%);">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $role->display_name }}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <code class="bg-light px-2 py-1 rounded">{{ $role->name }}</code>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-soft-info">
                                <i class="fas fa-users me-1"></i>
                                {{ $role->users_count }} مستخدم
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-soft-success">
                                <i class="fas fa-key me-1"></i>
                                {{ $role->permissions->count() }} أذن
                            </span>
                        </td>
                        <td>
                            <span class="text-muted small">{{ Str::limit($role->description, 50) ?? '-' }}</span>
                        </td>
                        <td>
                            <div class="action-btns justify-content-center">
                                <a href="{{ route('roles.show', $role->id) }}" 
                                   class="btn btn-soft-info btn-icon btn-sm"
                                   data-bs-toggle="tooltip" 
                                   title="عرض التفاصيل">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('roles.edit', $role->id) }}" 
                                   class="btn btn-soft-primary btn-icon btn-sm"
                                   data-bs-toggle="tooltip" 
                                   title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('roles.clone', $role->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-soft-secondary btn-icon btn-sm"
                                            data-bs-toggle="tooltip" 
                                            title="نسخ">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </form>
                                @if($role->users_count == 0)
                                <form action="{{ route('roles.destroy', $role->id) }}" 
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
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h5 class="empty-state-title">لا توجد صلاحيات</h5>
                                <p class="empty-state-text">لم يتم إضافة أي صلاحيات بعد.</p>
                                <a href="{{ route('roles.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i> إضافة صلاحية جديدة
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
        $('#rolesTable').DataTable({
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
                text: 'سيتم حذف هذه الصلاحية نهائياً!',
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
