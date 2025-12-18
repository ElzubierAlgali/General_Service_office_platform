@extends('layouts.master')
@section('title', 'إدارة المستخدمين')
@section('content')

{{-- Page Header --}}
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between animate-fadeInDown">
    <div class="clearfix">
        <h1 class="app-page-title">
            <i class="fas fa-users-cog text-primary"></i>
            إدارة المستخدمين
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">قائمة المستخدمين</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        @permission('create-users')
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-1"></i> إضافة مستخدم
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
                    <div class="stats-number">{{ $users->count() }}</div>
                    <div class="stats-label">إجمالي المستخدمين</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stats-change positive">
                <i class="fas fa-chart-line"></i>
                <span>+{{ $users->where('created_at', '>=', now()->subMonth())->count() }} هذا الشهر</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 animate-fadeInUp stagger-2">
        <div class="stats-card stats-card-success">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stats-number">{{ $users->whereNotNull('email_verified_at')->count() }}</div>
                    <div class="stats-label">حسابات مفعّلة</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 animate-fadeInUp stagger-3">
        <div class="stats-card stats-card-warning">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stats-number">{{ $users->whereNull('email_verified_at')->count() }}</div>
                    <div class="stats-label">في انتظار التفعيل</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-user-clock"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3 animate-fadeInUp stagger-4">
        <div class="stats-card stats-card-info">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stats-number">{{ $users->whereNotNull('organization_id')->count() }}</div>
                    <div class="stats-label">مرتبطون بمنظمة</div>
                </div>
                <div class="stats-icon">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Users Table Card --}}
<div class="card animate-fadeInUp">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2 text-primary"></i>
            قائمة المستخدمين
        </h5>
        <div class="d-flex gap-2">
            <div class="search-input-wrapper" style="min-width: 250px;">
                <input type="text" id="searchInput" class="form-control" placeholder="بحث سريع...">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="usersTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">#</th>
                        <th>المستخدم</th>
                        <th>البريد الإلكتروني</th>
                        <th>المنظمة</th>
                        <th>الصلاحيات</th>
                        <th class="text-center">الحالة</th>
                        <th class="text-center">تاريخ الانضمام</th>
                        <th class="text-center" style="width: 150px;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr class="animate-fadeIn" style="animation-delay: {{ ($index % 10) * 0.05 }}s">
                        <td class="text-center fw-semibold text-muted">
                            {{ $index + 1 }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md me-3" 
                                     style="background: linear-gradient(135deg, #{{ substr(md5($user->email), 0, 6) }} 0%, #{{ substr(md5($user->email), 6, 6) }} 100%);">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">
                                        {{ $user->name }}
                                        @if($user->id === auth()->id())
                                            <span class="badge badge-soft-primary ms-1">
                                                <i class="fas fa-user me-1"></i>أنت
                                            </span>
                                        @endif
                                    </h6>
                                    <small class="text-muted">
                                        @if($user->position)
                                            <i class="fas fa-briefcase me-1"></i>{{ $user->position }}
                                        @else
                                            <i class="fas fa-clock me-1"></i>
                                            انضم {{ $user->created_at->diffForHumans() }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                                    {{ $user->email }}
                                </a>
                                @if($user->email_verified_at)
                                    <span class="text-success" data-bs-toggle="tooltip" title="بريد مُفعّل">
                                        <i class="fas fa-check-circle"></i>
                                    </span>
                                @else
                                    <span class="text-warning" data-bs-toggle="tooltip" title="بريد غير مُفعّل">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($user->organization)
                                <span class="badge badge-soft-secondary">
                                    <i class="fas fa-building me-1"></i>
                                    {{ $user->organization->name }}
                                </span>
                            @else
                                <span class="text-muted small">
                                    <i class="fas fa-minus-circle me-1"></i>غير مرتبط
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                @forelse($user->roles as $role)
                                    <span class="badge badge-soft-primary">
                                        <i class="fas fa-shield-alt me-1"></i>
                                        {{ $role->display_name ?? $role->name }}
                                    </span>
                                @empty
                                    <span class="text-muted small">
                                        <i class="fas fa-minus-circle me-1"></i>لا توجد
                                    </span>
                                @endforelse
                            </div>
                        </td>
                        <td class="text-center">
                            @if($user->email_verified_at)
                                <span class="badge badge-soft-success status-badge active">
                                    <i class="fas fa-check me-1"></i>مفعّل
                                </span>
                            @else
                                <span class="badge badge-soft-warning status-badge pending">
                                    <i class="fas fa-clock me-1"></i>غير مفعّل
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="small text-muted" data-bs-toggle="tooltip" title="{{ $user->created_at->format('Y-m-d H:i') }}">
                                {{ $user->created_at->format('Y-m-d') }}
                            </span>
                        </td>
                        <td>
                            <div class="action-btns justify-content-center">
                                @permission('view-users')
                                <a href="{{ route('users.show', $user->id) }}" 
                                   class="btn btn-soft-info btn-icon btn-sm"
                                   data-bs-toggle="tooltip" 
                                   title="عرض التفاصيل">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endpermission
                                @permission('edit-users')
                                <a href="{{ route('users.edit', $user->id) }}" 
                                   class="btn btn-soft-primary btn-icon btn-sm"
                                   data-bs-toggle="tooltip" 
                                   title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endpermission
                                @permission('delete-users')
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user->id) }}" 
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
                                @endpermission
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h5 class="empty-state-title">لا يوجد مستخدمين</h5>
                                <p class="empty-state-text">لم يتم إضافة أي مستخدمين بعد.</p>
                                @permission('create-users')
                                <a href="{{ route('users.create') }}" class="btn btn-primary">
                                    <i class="fas fa-user-plus me-1"></i> إضافة مستخدم جديد
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
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#usersTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json'
            },
            order: [[0, 'asc']],
            pageLength: 25,
            responsive: true,
            dom: '<"top">rt<"bottom"lip><"clear">',
            initComplete: function() {
                // Custom search functionality
                $('#searchInput').on('keyup', function() {
                    table.search(this.value).draw();
                });
            }
        });
        
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
                text: 'سيتم حذف هذا المستخدم نهائياً!',
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
