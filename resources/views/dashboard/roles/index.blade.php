@extends('layouts.master')
@section('title', 'إدارة الصلاحيات')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">إدارة الصلاحيات والأدوار</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">الصلاحيات</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('roles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة صلاحية
        </a>
        <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-key"></i> إدارة الأذونات
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white border-0">
            <div class="card-body text-center py-3">
                <i class="fas fa-shield-alt fa-2x mb-2"></i>
                <h3 class="mb-0">{{ $stats['total_roles'] }}</h3>
                <small>إجمالي الصلاحيات</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white border-0">
            <div class="card-body text-center py-3">
                <i class="fas fa-key fa-2x mb-2"></i>
                <h3 class="mb-0">{{ $stats['total_permissions'] }}</h3>
                <small>إجمالي الأذونات</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white border-0">
            <div class="card-body text-center py-3">
                <i class="fas fa-users fa-2x mb-2"></i>
                <h3 class="mb-0">{{ $stats['total_users'] }}</h3>
                <small>إجمالي المستخدمين</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white border-0">
            <div class="card-body text-center py-3">
                <i class="fas fa-user-slash fa-2x mb-2"></i>
                <h3 class="mb-0">{{ $stats['users_without_role'] }}</h3>
                <small>بدون صلاحية</small>
            </div>
        </div>
    </div>
</div>

<!-- Roles Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">قائمة الصلاحيات</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="rolesTable">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>الاسم المعروض</th>
                        <th>الاسم البرمجي</th>
                        <th>المستخدمين</th>
                        <th>الأذونات</th>
                        <th>الوصف</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $index => $role)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded-circle bg-primary text-white me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <strong>{{ $role->display_name }}</strong>
                            </div>
                        </td>
                        <td><code>{{ $role->name }}</code></td>
                        <td>
                            <span class="badge bg-info">{{ $role->users_count }} مستخدم</span>
                        </td>
                        <td>
                            <span class="badge bg-success">{{ $role->permissions->count() }} أذن</span>
                        </td>
                        <td>{{ $role->description ?? '-' }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('roles.show', $role->id) }}" class="btn btn-sm btn-outline-info" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-outline-primary" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('roles.clone', $role->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="نسخ">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </form>
                                @if($role->users_count == 0)
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الصلاحية؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            لا توجد صلاحيات
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
        $('#rolesTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json'
            },
            order: [[0, 'desc']],
            pageLength: 25,
            responsive: true
        });
    });
</script>
@endsection

