@extends('layouts.master')
@section('title', 'عرض الأذن: ' . $permission->display_name)
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">عرض الأذن: {{ $permission->display_name }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">الأذونات</a></li>
                <li class="breadcrumb-item active" aria-current="page">عرض الأذن</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> تعديل
        </a>
        <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right"></i> العودة للقائمة
        </a>
    </div>
</div>

<div class="row">
    <!-- Permission Info Card -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar avatar-xxl rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 120px; height: 120px;">
                    <i class="fas fa-key fa-3x"></i>
                </div>
                <h4 class="mb-1">{{ $permission->display_name }}</h4>
                <p class="text-muted mb-3"><code>{{ $permission->name }}</code></p>
                <span class="badge bg-info mb-3">{{ $permission->roles->count() }} صلاحية</span>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">إجراءات سريعة</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit me-1"></i> تعديل الأذن
                    </a>
                    @if($permission->roles->count() == 0)
                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الأذن؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-1"></i> حذف الأذن
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Permission Details -->
    <div class="col-lg-8">
        <!-- Basic Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">المعلومات الأساسية</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong class="text-muted">الاسم المعروض:</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $permission->display_name }}
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong class="text-muted">الاسم البرمجي:</strong>
                    </div>
                    <div class="col-md-8">
                        <code>{{ $permission->name }}</code>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong class="text-muted">الوصف:</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $permission->description ?? 'لا يوجد وصف' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Roles -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">الصلاحيات المرتبطة ({{ $permission->roles->count() }})</h6>
            </div>
            <div class="card-body">
                @forelse($permission->roles as $role)
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar rounded-circle bg-primary text-white me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div>
                            <strong>{{ $role->display_name ?? $role->name }}</strong>
                            <br>
                            <small class="text-muted"><code>{{ $role->name }}</code></small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">لا توجد صلاحيات مرتبطة بهذا الأذن</p>
                @endforelse
            </div>
        </div>

        <!-- Account Information -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">معلومات الحساب</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong class="text-muted">تاريخ الإنشاء:</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $permission->created_at->format('Y-m-d H:i:s') }}
                        <small class="text-muted">({{ $permission->created_at->diffForHumans() }})</small>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong class="text-muted">آخر تحديث:</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $permission->updated_at->format('Y-m-d H:i:s') }}
                        <small class="text-muted">({{ $permission->updated_at->diffForHumans() }})</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

