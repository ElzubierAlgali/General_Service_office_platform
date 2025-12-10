@extends('layouts.master')
@section('title', 'الإعدادات')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">إعدادات النظام</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">الإعدادات</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <!-- ZATCA Settings Card -->
    @permission('Manage ZATCA Settings')
    <div class="col-md-4 col-lg-3 mb-4">
        <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <div class="avatar avatar-xl bg-success-subtle rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-file-invoice-dollar fa-2x text-success"></i>
                    </div>
                </div>
                <h5 class="card-title mb-2">هيئة الزكاة والضريبة</h5>
                <p class="card-text text-muted small mb-3">إعدادات الربط مع منظومة الفوترة الإلكترونية (فاتورة)</p>
                <a href="{{ route('settings.zatca') }}" class="btn btn-success">
                    <i class="fas fa-cog me-1"></i> إدارة الإعدادات
                </a>
            </div>
            <div class="card-footer bg-transparent border-top-0 text-center py-2">
                @php
                    $zatcaEnabled = \App\Models\Setting::get('zatca_enabled', '0');
                @endphp
                @if($zatcaEnabled == '1')
                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> مفعّل</span>
                @else
                    <span class="badge bg-secondary"><i class="fas fa-times-circle me-1"></i> غير مفعّل</span>
                @endif
            </div>
        </div>
    </div>
    @endpermission

    <!-- General Settings Card -->
    @permission('Manage General Settings')
    <div class="col-md-4 col-lg-3 mb-4">
        <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <div class="avatar avatar-xl bg-primary-subtle rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-sliders-h fa-2x text-primary"></i>
                    </div>
                </div>
                <h5 class="card-title mb-2">الإعدادات العامة</h5>
                <p class="card-text text-muted small mb-3">إعدادات التطبيق الأساسية والعملة والتوقيت</p>
                <a href="{{ route('settings.general') }}" class="btn btn-primary">
                    <i class="fas fa-cog me-1"></i> إدارة الإعدادات
                </a>
            </div>
        </div>
    </div>
    @endpermission

    <!-- Notifications Settings Card -->
    <div class="col-md-4 col-lg-3 mb-4">
        <div class="card h-100 border-0 shadow-sm hover-shadow transition-all opacity-50">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <div class="avatar avatar-xl bg-info-subtle rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-bell fa-2x text-info"></i>
                    </div>
                </div>
                <h5 class="card-title mb-2">إعدادات الإشعارات</h5>
                <p class="card-text text-muted small mb-3">إعدادات البريد الإلكتروني والرسائل النصية</p>
                <button class="btn btn-secondary" disabled>
                    <i class="fas fa-clock me-1"></i> قريباً
                </button>
            </div>
        </div>
    </div>

    <!-- Backup Settings Card -->
    <div class="col-md-4 col-lg-3 mb-4">
        <div class="card h-100 border-0 shadow-sm hover-shadow transition-all opacity-50">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <div class="avatar avatar-xl bg-warning-subtle rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-database fa-2x text-warning"></i>
                    </div>
                </div>
                <h5 class="card-title mb-2">النسخ الاحتياطي</h5>
                <p class="card-text text-muted small mb-3">إدارة النسخ الاحتياطية واستعادة البيانات</p>
                <button class="btn btn-secondary" disabled>
                    <i class="fas fa-clock me-1"></i> قريباً
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow {
        transition: all 0.3s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
</style>
@endsection

