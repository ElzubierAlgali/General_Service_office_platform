@extends('layouts.master')
@section('title', 'عرض الصلاحية: ' . $role->display_name)
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">عرض الصلاحية: {{ $role->display_name }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">الصلاحيات</a></li>
                <li class="breadcrumb-item active" aria-current="page">عرض الصلاحية</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> تعديل
        </a>
        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right"></i> العودة للقائمة
        </a>
    </div>
</div>

<div class="row">
    <!-- Role Info Card -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar avatar-xxl rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 120px; height: 120px;">
                    <i class="fas fa-shield-alt fa-3x"></i>
                </div>
                <h4 class="mb-1">{{ $role->display_name }}</h4>
                <p class="text-muted mb-3"><code>{{ $role->name }}</code></p>
                <span class="badge bg-info mb-3">{{ $role->users->count() }} مستخدم</span>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">إجراءات سريعة</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit me-1"></i> تعديل الصلاحية
                    </a>
                    <form action="{{ route('roles.clone', $role->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-copy me-1"></i> نسخ الصلاحية
                        </button>
                    </form>
                    @if($role->users->count() == 0)
                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذه الصلاحية؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-1"></i> حذف الصلاحية
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Role Details -->
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
                        {{ $role->display_name }}
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong class="text-muted">الاسم البرمجي:</strong>
                    </div>
                    <div class="col-md-8">
                        <code>{{ $role->name }}</code>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong class="text-muted">الوصف:</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $role->description ?? 'لا يوجد وصف' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Permissions -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">الأذونات المرتبطة ({{ $role->permissions->count() }})</h6>
            </div>
            <div class="card-body">
                @forelse($role->permissions as $permission)
                    <span class="badge bg-primary me-2 mb-2" style="font-size: 0.9rem;">
                        <i class="fas fa-key me-1"></i>
                        {{ $permission->display_name ?? $permission->name }}
                    </span>
                @empty
                    <p class="text-muted mb-0">لا توجد أذونات مرتبطة بهذه الصلاحية</p>
                @endforelse
            </div>
        </div>

        <!-- Users -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">المستخدمون الذين لديهم هذه الصلاحية ({{ $role->users->count() }})</h6>
            </div>
            <div class="card-body">
                @forelse($role->users as $user)
                    <div class="d-flex align-items-center mb-2">
                        <div class="avatar rounded-circle bg-secondary text-white me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div>
                            <strong>{{ $user->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $user->email }}</small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">لا يوجد مستخدمون بهذه الصلاحية</p>
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
                        {{ $role->created_at->format('Y-m-d H:i:s') }}
                        <small class="text-muted">({{ $role->created_at->diffForHumans() }})</small>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong class="text-muted">آخر تحديث:</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $role->updated_at->format('Y-m-d H:i:s') }}
                        <small class="text-muted">({{ $role->updated_at->diffForHumans() }})</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

