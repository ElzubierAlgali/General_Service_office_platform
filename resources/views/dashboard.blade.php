@extends('layouts.master')
@section('title', 'لوحة التحكم')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">لوحة التحكم</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" aria-current="page">الرئيسية</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ $customers_count }}</h3>
                        <small>إجمالي العملاء</small>
                    </div>
                    <div class="avatar bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white bg-opacity-25">
                <a href="{{ route('customers.index') }}" class="text-white text-decoration-none">
                    عرض التفاصيل <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ $services_count }}</h3>
                        <small>الخدمات النشطة</small>
                    </div>
                    <div class="avatar bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-briefcase fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white bg-opacity-25">
                <a href="{{ route('services.index') }}" class="text-white text-decoration-none">
                    عرض التفاصيل <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ $users_count }}</h3>
                        <small>إجمالي المستخدمين</small>
                    </div>
                    <div class="avatar bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-user-friends fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white bg-opacity-25">
                <a href="{{ route('users.index') }}" class="text-white text-decoration-none">
                    عرض التفاصيل <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ $roles_count }}</h3>
                        <small>إجمالي الصلاحيات</small>
                    </div>
                    <div class="avatar bg-white bg-opacity-25 rounded-circle p-3">
                        <i class="fas fa-shield-alt fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white bg-opacity-25">
                <a href="{{ route('roles.index') }}" class="text-white text-decoration-none">
                    عرض التفاصيل <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">إجراءات سريعة</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('customers.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-user-plus me-2"></i> إضافة عميل جديد
                    </a>
                    <a href="{{ route('services.create') }}" class="btn btn-outline-success">
                        <i class="fas fa-briefcase me-2"></i> إضافة خدمة جديدة
                    </a>
                    <a href="{{ route('users.create') }}" class="btn btn-outline-info">
                        <i class="fas fa-user-plus me-2"></i> إضافة مستخدم جديد
                    </a>
                    <a href="{{ route('roles.create') }}" class="btn btn-outline-warning">
                        <i class="fas fa-shield-alt me-2"></i> إضافة صلاحية جديدة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">روابط مهمة</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="{{ route('customers.index') }}" class="text-decoration-none">
                            <i class="fas fa-users me-2 text-primary"></i> إدارة العملاء
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('services.index') }}" class="text-decoration-none">
                            <i class="fas fa-briefcase me-2 text-success"></i> إدارة الخدمات
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('users.index') }}" class="text-decoration-none">
                            <i class="fas fa-user-friends me-2 text-info"></i> إدارة المستخدمين
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('roles.index') }}" class="text-decoration-none">
                            <i class="fas fa-shield-alt me-2 text-warning"></i> إدارة الصلاحيات
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('permissions.index') }}" class="text-decoration-none">
                            <i class="fas fa-key me-2 text-secondary"></i> إدارة الأذونات
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
