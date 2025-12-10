@extends('layouts.master')
@section('title', 'الإعدادات العامة')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">الإعدادات العامة</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">الإعدادات</a></li>
                <li class="breadcrumb-item active" aria-current="page">الإعدادات العامة</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('settings.general.save') }}" method="POST">
            @csrf

            <!-- Application Settings -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cog me-2"></i>إعدادات التطبيق
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم التطبيق (عربي)</label>
                            <input type="text" class="form-control" name="app_name" 
                                value="{{ $settings['app_name'] ?? 'صِـدقا' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم التطبيق (إنجليزي)</label>
                            <input type="text" class="form-control" name="app_name_en" 
                                value="{{ $settings['app_name_en'] ?? 'SIDQA' }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Company Information -->
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-building me-2"></i>معلومات الشركة
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control" name="company_phone" 
                                value="{{ $settings['company_phone'] ?? '' }}"
                                placeholder="+966 XX XXX XXXX">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" name="company_email" 
                                value="{{ $settings['company_email'] ?? '' }}"
                                placeholder="info@company.com">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">العنوان</label>
                        <textarea class="form-control" name="company_address" rows="2"
                            placeholder="عنوان الشركة الكامل">{{ $settings['company_address'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Regional Settings -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-globe me-2"></i>الإعدادات الإقليمية
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">العملة</label>
                            <select class="form-select" name="currency">
                                <option value="SAR" {{ ($settings['currency'] ?? 'SAR') == 'SAR' ? 'selected' : '' }}>ريال سعودي (SAR)</option>
                                <option value="USD" {{ ($settings['currency'] ?? '') == 'USD' ? 'selected' : '' }}>دولار أمريكي (USD)</option>
                                <option value="AED" {{ ($settings['currency'] ?? '') == 'AED' ? 'selected' : '' }}>درهم إماراتي (AED)</option>
                                <option value="KWD" {{ ($settings['currency'] ?? '') == 'KWD' ? 'selected' : '' }}>دينار كويتي (KWD)</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">رمز العملة</label>
                            <input type="text" class="form-control" name="currency_symbol" 
                                value="{{ $settings['currency_symbol'] ?? 'ر.س' }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">المنطقة الزمنية</label>
                            <select class="form-select" name="timezone">
                                <option value="Asia/Riyadh" {{ ($settings['timezone'] ?? 'Asia/Riyadh') == 'Asia/Riyadh' ? 'selected' : '' }}>الرياض (GMT+3)</option>
                                <option value="Asia/Dubai" {{ ($settings['timezone'] ?? '') == 'Asia/Dubai' ? 'selected' : '' }}>دبي (GMT+4)</option>
                                <option value="Asia/Kuwait" {{ ($settings['timezone'] ?? '') == 'Asia/Kuwait' ? 'selected' : '' }}>الكويت (GMT+3)</option>
                                <option value="UTC" {{ ($settings['timezone'] ?? '') == 'UTC' ? 'selected' : '' }}>UTC</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">تنسيق التاريخ</label>
                            <select class="form-select" name="date_format">
                                <option value="Y-m-d" {{ ($settings['date_format'] ?? 'Y-m-d') == 'Y-m-d' ? 'selected' : '' }}>2025-01-31</option>
                                <option value="d/m/Y" {{ ($settings['date_format'] ?? '') == 'd/m/Y' ? 'selected' : '' }}>31/01/2025</option>
                                <option value="d-m-Y" {{ ($settings['date_format'] ?? '') == 'd-m-Y' ? 'selected' : '' }}>31-01-2025</option>
                                <option value="m/d/Y" {{ ($settings['date_format'] ?? '') == 'm/d/Y' ? 'selected' : '' }}>01/31/2025</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">تنسيق الوقت</label>
                            <select class="form-select" name="time_format">
                                <option value="H:i" {{ ($settings['time_format'] ?? 'H:i') == 'H:i' ? 'selected' : '' }}>24 ساعة (14:30)</option>
                                <option value="h:i A" {{ ($settings['time_format'] ?? '') == 'h:i A' ? 'selected' : '' }}>12 ساعة (02:30 PM)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save me-1"></i> حفظ الإعدادات
                </button>
            </div>
        </form>
    </div>

    <!-- Side Panel -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>معلومات النظام
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted">إصدار Laravel</td>
                        <td class="fw-bold">{{ app()->version() }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">إصدار PHP</td>
                        <td class="fw-bold">{{ PHP_VERSION }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">الخادم</td>
                        <td class="fw-bold">{{ $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">قاعدة البيانات</td>
                        <td class="fw-bold">{{ config('database.default') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">المنطقة الزمنية</td>
                        <td class="fw-bold">{{ config('app.timezone') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

