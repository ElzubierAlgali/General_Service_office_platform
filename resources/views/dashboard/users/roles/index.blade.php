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
    @permission('Create Roles')
    <div>
        <a href="{{ route('roles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة صلاحية
        </a>
    </div>
    @endpermission
</div>

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

<!-- Roles Grid -->
<div class="row">
    @foreach($roles as $role)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 border-0 shadow-sm {{ $role->id == 1 ? 'border-start border-primary border-4' : '' }}">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="avatar rounded-circle {{ $role->id == 1 ? 'bg-primary' : 'bg-secondary' }} text-white me-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="{{ $role->icon ?? 'fas fa-user-tag' }}"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">{{ $role->display_name }}</h6>
                        <small class="text-muted">{{ $role->name }}</small>
                    </div>
                </div>
                @if($role->id == 1)
                <span class="badge bg-primary">مدير النظام</span>
                @endif
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <div class="text-center">
                        <h4 class="mb-0 text-primary">{{ $role->users_count }}</h4>
                        <small class="text-muted">مستخدم</small>
                    </div>
                    <div class="text-center">
                        <h4 class="mb-0 text-success">{{ $role->permissions->count() }}</h4>
                        <small class="text-muted">صلاحية</small>
                    </div>
                </div>
                
                <!-- Permissions Preview -->
                <div class="mb-3">
                    <small class="text-muted d-block mb-2">الصلاحيات:</small>
                    <div style="max-height: 100px; overflow-y: auto;">
                        @foreach($role->permissions->take(6) as $permission)
                        <span class="badge bg-light text-dark border mb-1 me-1">
                            {{ $permission->display_name }}
                        </span>
                        @endforeach
                        @if($role->permissions->count() > 6)
                        <span class="badge bg-secondary mb-1">
                            +{{ $role->permissions->count() - 6 }} أخرى
                        </span>
                        @endif
                    </div>
                </div>

                @if($role->description)
                <p class="text-muted small mb-0">{{ Str::limit($role->description, 80) }}</p>
                @endif
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <div class="d-flex gap-2">
                    @permission('Edit Roles')
                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-outline-primary flex-fill">
                        <i class="fas fa-edit"></i> تعديل
                    </a>
                    @endpermission
                    
                    @permission('Create Roles')
                    <a href="{{ route('roles.clone', $role->id) }}" class="btn btn-sm btn-outline-secondary" title="نسخ">
                        <i class="fas fa-copy"></i>
                    </a>
                    @endpermission

                    @permission('Delete Roles')
                    @if($role->id != 1 && $role->users_count == 0)
                    <a href="{{ route('roles.destroy', $role->id) }}" class="btn btn-sm btn-outline-danger" data-confirm-delete="true" title="حذف">
                        <i class="fas fa-trash"></i>
                    </a>
                    @endif
                    @endpermission
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Roles Table (Alternative View) -->
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-transparent">
        <h6 class="mb-0"><i class="fas fa-table me-2"></i>جدول الصلاحيات</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="example1">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>الصلاحية</th>
                        <th>الاسم البرمجي</th>
                        <th>المستخدمين</th>
                        <th>الأذونات</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $index => $role)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="{{ $role->icon ?? 'fas fa-user-tag' }} text-primary me-2"></i>
                                <div>
                                    <strong>{{ $role->display_name }}</strong>
                                    @if($role->id == 1)
                                    <span class="badge bg-primary ms-1">رئيسي</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td><code>{{ $role->name }}</code></td>
                        <td>
                            <span class="badge bg-info">{{ $role->users_count }} مستخدم</span>
                        </td>
                        <td>
                            <span class="badge bg-success">{{ $role->permissions->count() }} صلاحية</span>
                        </td>
                        <td>
                            @permission('Edit Roles')
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endpermission
                            @permission('Delete Roles')
                            @if($role->id != 1 && $role->users_count == 0)
                            <a href="{{ route('roles.destroy', $role->id) }}" class="btn btn-sm btn-outline-danger" data-confirm-delete="true">
                                <i class="fas fa-trash"></i>
                            </a>
                            @endif
                            @endpermission
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
