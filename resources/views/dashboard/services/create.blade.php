@extends('layouts.master')
@section('title', 'إضافة خدمة')
@section('content')

{{-- Page Header --}}
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between animate-fadeInDown">
    <div class="clearfix">
        <h1 class="app-page-title">
            <i class="fas fa-plus-circle text-primary"></i>
            إضافة خدمة جديدة
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('services.index') }}">الخدمات</a></li>
                <li class="breadcrumb-item active" aria-current="page">إضافة خدمة</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right me-1"></i> العودة للقائمة
        </a>
    </div>
</div>

<form action="{{ route('services.store') }}" method="POST" id="serviceForm">
    @csrf
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            
            {{-- Error Alert --}}
            @if($errors->any())
            <div class="alert alert-danger animate-fadeInDown mb-4">
                <div class="d-flex align-items-start">
                    <div class="alert-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-2 fw-bold">يرجى تصحيح الأخطاء التالية:</h6>
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            {{-- Service Basic Info Card --}}
            <div class="card mb-4 animate-fadeInUp">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        المعلومات الأساسية
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                اسم الخدمة <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-concierge-bell text-primary"></i>
                                </span>
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" 
                                       placeholder="أدخل اسم الخدمة"
                                       required>
                            </div>
                            @error('name')
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                كود الخدمة <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-hashtag text-primary"></i>
                                </span>
                                <input type="text" 
                                       name="code" 
                                       class="form-control @error('code') is-invalid @enderror" 
                                       value="{{ old('code') }}"
                                       placeholder="مثال: BUSINESS_LICENSE"
                                       required>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                رمز فريد للخدمة (يُستخدم في النظام)
                            </small>
                            @error('code')
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">وصف الخدمة</label>
                            <textarea name="description" 
                                      class="form-control" 
                                      rows="3"
                                      placeholder="أدخل وصفاً تفصيلياً للخدمة...">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pricing & Duration Card --}}
            <div class="card mb-4 animate-fadeInUp stagger-1">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-coins me-2 text-warning"></i>
                        التسعير والمدة
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">سعر الخدمة</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-money-bill-wave text-success"></i>
                                </span>
                                <input type="number" 
                                       name="price" 
                                       class="form-control" 
                                       value="{{ old('price', 0) }}" 
                                       step="0.01" 
                                       min="0"
                                       placeholder="0.00">
                                <span class="input-group-text bg-light">ريال</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">المدة المتوقعة للإنجاز</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-clock text-info"></i>
                                </span>
                                <input type="number" 
                                       name="estimated_duration_days" 
                                       class="form-control" 
                                       value="{{ old('estimated_duration_days') }}" 
                                       min="0"
                                       placeholder="عدد الأيام">
                                <span class="input-group-text bg-light">يوم</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status Card --}}
            <div class="card mb-4 animate-fadeInUp stagger-2">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-toggle-on me-2 text-success"></i>
                        حالة الخدمة
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                        <div>
                            <h6 class="mb-1 fw-bold">تفعيل الخدمة</h6>
                            <p class="mb-0 text-muted small">
                                عند تفعيل الخدمة ستظهر في قائمة الخدمات المتاحة للعملاء
                            </p>
                        </div>
                        <div class="form-check form-switch form-switch-lg">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="active" 
                                   id="active" 
                                   style="width: 3em; height: 1.5em;"
                                   checked>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit Buttons --}}
            <div class="d-flex justify-content-between align-items-center gap-3 animate-fadeInUp stagger-3">
                <a href="{{ route('services.index') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-times me-1"></i> إلغاء
                </a>
                <div class="d-flex gap-2">
                    <button type="submit" name="action" value="save" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-1"></i> حفظ الخدمة
                    </button>
                    <button type="submit" name="action" value="save_new" class="btn btn-success btn-lg">
                        <i class="fas fa-plus me-1"></i> حفظ وإضافة جديد
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Auto generate code from name
        $('input[name="name"]').on('input', function() {
            var name = $(this).val();
            var code = name.toUpperCase()
                          .replace(/[أإآا]/g, 'A')
                          .replace(/[ب]/g, 'B')
                          .replace(/[ت]/g, 'T')
                          .replace(/[ث]/g, 'TH')
                          .replace(/[ج]/g, 'J')
                          .replace(/[ح]/g, 'H')
                          .replace(/[خ]/g, 'KH')
                          .replace(/[د]/g, 'D')
                          .replace(/[ذ]/g, 'DH')
                          .replace(/[ر]/g, 'R')
                          .replace(/[ز]/g, 'Z')
                          .replace(/[س]/g, 'S')
                          .replace(/[ش]/g, 'SH')
                          .replace(/[ص]/g, 'S')
                          .replace(/[ض]/g, 'D')
                          .replace(/[ط]/g, 'T')
                          .replace(/[ظ]/g, 'Z')
                          .replace(/[ع]/g, 'A')
                          .replace(/[غ]/g, 'GH')
                          .replace(/[ف]/g, 'F')
                          .replace(/[ق]/g, 'Q')
                          .replace(/[ك]/g, 'K')
                          .replace(/[ل]/g, 'L')
                          .replace(/[م]/g, 'M')
                          .replace(/[ن]/g, 'N')
                          .replace(/[ه]/g, 'H')
                          .replace(/[و]/g, 'W')
                          .replace(/[ي]/g, 'Y')
                          .replace(/[ة]/g, 'H')
                          .replace(/[ء]/g, '')
                          .replace(/[ى]/g, 'A')
                          .replace(/\s+/g, '_')
                          .replace(/[^A-Z0-9_]/g, '');
            
            if (!$('input[name="code"]').data('manual')) {
                $('input[name="code"]').val(code);
            }
        });
        
        // Mark code as manually edited
        $('input[name="code"]').on('input', function() {
            $(this).data('manual', true);
        });
        
        // Form submission animation
        $('#serviceForm').on('submit', function() {
            var btn = $(this).find('button[type="submit"]:focus');
            btn.html('<i class="fas fa-spinner fa-spin me-1"></i> جاري الحفظ...');
            btn.prop('disabled', true);
        });
    });
</script>
@endsection
