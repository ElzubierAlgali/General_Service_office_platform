@extends('layouts.master')
@section('title', 'عرض المستخدم: ' . $user->name)
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">عرض المستخدم: {{ $user->name }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">المستخدمين</a></li>
                <li class="breadcrumb-item active" aria-current="page">عرض المستخدم</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> تعديل
        </a>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right"></i> العودة للقائمة
        </a>
    </div>
</div>

<div class="row">
    <!-- User Profile Card -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar avatar-xxl rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 120px; height: 120px;">
                    <span style="font-size: 3rem;">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                </div>
                <h4 class="mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                
                @if($user->email_verified_at)
                    <span class="badge bg-success mb-3">البريد الإلكتروني مفعّل</span>
                @else
                    <span class="badge bg-warning mb-3">البريد الإلكتروني غير مفعّل</span>
                @endif

                @if($user->id === auth()->id())
                    <span class="badge bg-info">حسابك الشخصي</span>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="card-title mb-0">إجراءات سريعة</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit me-1"></i> تعديل المستخدم
                    </a>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-1"></i> حذف المستخدم
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- User Details -->
    <div class="col-lg-8">
        <!-- Basic Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">المعلومات الأساسية</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong class="text-muted">الاسم الكامل:</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $user->name }}
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong class="text-muted">البريد الإلكتروني:</strong>
                    </div>
                    <div class="col-md-8">
                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                        @if($user->email_verified_at)
                            <i class="fas fa-check-circle text-success" title="مفعّل"></i>
                        @else
                            <i class="fas fa-times-circle text-warning" title="غير مفعّل"></i>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong class="text-muted">المنظمة:</strong>
                    </div>
                    <div class="col-md-8">
                        @if($user->organization)
                            <span class="badge bg-secondary">{{ $user->organization->name }}</span>
                        @else
                            <span class="text-muted">غير مرتبط بمنظمة</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Roles -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">الصلاحيات</h6>
            </div>
            <div class="card-body">
                @forelse($user->roles as $role)
                    <span class="badge bg-primary me-2 mb-2" style="font-size: 0.9rem;">
                        <i class="fas fa-shield-alt me-1"></i>
                        {{ $role->display_name ?? $role->name }}
                    </span>
                    @if($role->description)
                        <small class="text-muted d-block">{{ $role->description }}</small>
                    @endif
                @empty
                    <p class="text-muted mb-0">لا توجد صلاحيات م assigned لهذا المستخدم</p>
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
                        {{ $user->created_at->format('Y-m-d H:i:s') }}
                        <small class="text-muted">({{ $user->created_at->diffForHumans() }})</small>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong class="text-muted">آخر تحديث:</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $user->updated_at->format('Y-m-d H:i:s') }}
                        <small class="text-muted">({{ $user->updated_at->diffForHumans() }})</small>
                    </div>
                </div>
                @if($user->email_verified_at)
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong class="text-muted">تاريخ تفعيل البريد:</strong>
                    </div>
                    <div class="col-md-8">
                        {{ $user->email_verified_at->format('Y-m-d H:i:s') }}
                        <small class="text-muted">({{ $user->email_verified_at->diffForHumans() }})</small>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

