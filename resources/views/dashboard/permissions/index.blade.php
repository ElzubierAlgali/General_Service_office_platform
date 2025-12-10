@extends('layouts.master')
@section('title', 'إدارة الأذونات')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">إدارة الأذونات</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">الأذونات</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('permissions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة أذن
        </a>
        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-shield-alt"></i> إدارة الصلاحيات
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
    <div class="col-md-6">
        <div class="card bg-primary text-white border-0">
            <div class="card-body text-center py-3">
                <i class="fas fa-key fa-2x mb-2"></i>
                <h3 class="mb-0">{{ $stats['total_permissions'] }}</h3>
                <small>إجمالي الأذونات</small>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-info text-white border-0">
            <div class="card-body text-center py-3">
                <i class="fas fa-shield-alt fa-2x mb-2"></i>
                <h3 class="mb-0">{{ $stats['total_roles'] }}</h3>
                <small>إجمالي الصلاحيات</small>
            </div>
        </div>
    </div>
</div>

<!-- Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('permissions.index') }}">
            <div class="row">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control" 
                           value="{{ request('search') }}" 
                           placeholder="ابحث عن أذن (الاسم، الاسم المعروض، الوصف)...">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> بحث
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Permissions Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">قائمة الأذونات</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="permissionsTable">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>الاسم المعروض</th>
                        <th>الاسم البرمجي</th>
                        <th>الصلاحيات المرتبطة</th>
                        <th>الوصف</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $index => $permission)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar rounded-circle bg-success text-white me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                    <i class="fas fa-key"></i>
                                </div>
                                <strong>{{ $permission->display_name }}</strong>
                            </div>
                        </td>
                        <td><code>{{ $permission->name }}</code></td>
                        <td>
                            <span class="badge bg-info">{{ $permission->roles_count }} صلاحية</span>
                        </td>
                        <td>{{ $permission->description ?? '-' }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('permissions.show', $permission->id) }}" class="btn btn-sm btn-outline-info" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-sm btn-outline-primary" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($permission->roles_count == 0)
                                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الأذن؟');">
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
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            لا توجد أذونات
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
        $('#permissionsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json'
            },
            order: [[0, 'asc']],
            pageLength: 25,
            responsive: true
        });
    });
</script>
@endsection

