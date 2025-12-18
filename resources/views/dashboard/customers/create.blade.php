@extends('layouts.master')
@section('title', 'إضافة عميل')
@section('content')

{{-- Page Header --}}
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between animate-fadeInDown">
    <div class="clearfix">
        <h1 class="app-page-title">
            <i class="fas fa-user-plus text-primary"></i>
            إضافة عميل جديد
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">العملاء</a></li>
                <li class="breadcrumb-item active" aria-current="page">إضافة عميل</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right me-1"></i> العودة للقائمة
        </a>
    </div>
</div>

<form action="{{ route('customers.store') }}" method="POST" id="customerForm">
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

            {{-- Personal Information Card --}}
            <div class="card mb-4 animate-fadeInUp">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2 text-primary"></i>
                        المعلومات الشخصية
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                الاسم الكامل <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-user text-primary"></i>
                                </span>
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" 
                                       placeholder="أدخل اسم العميل الكامل"
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
                                رقم الهوية الوطنية
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-id-card text-primary"></i>
                                </span>
                                <input type="text" 
                                       name="national_id" 
                                       class="form-control @error('national_id') is-invalid @enderror" 
                                       value="{{ old('national_id') }}"
                                       placeholder="أدخل رقم الهوية الوطنية">
                            </div>
                            @error('national_id')
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Information Card --}}
            <div class="card mb-4 animate-fadeInUp stagger-1">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-phone-alt me-2 text-success"></i>
                        معلومات الاتصال
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                البريد الإلكتروني
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-envelope text-success"></i>
                                </span>
                                <input type="email" 
                                       name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}"
                                       placeholder="example@domain.com">
                            </div>
                            @error('email')
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                رقم الهاتف
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-phone text-success"></i>
                                </span>
                                <input type="text" 
                                       name="phone" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone') }}"
                                       placeholder="05xxxxxxxx">
                            </div>
                            @error('phone')
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Address Information Card --}}
            <div class="card mb-4 animate-fadeInUp stagger-2">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                        معلومات العنوان
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                العنوان التفصيلي
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-home text-danger"></i>
                                </span>
                                <textarea name="address" 
                                          class="form-control @error('address') is-invalid @enderror" 
                                          rows="2"
                                          placeholder="أدخل العنوان التفصيلي...">{{ old('address') }}</textarea>
                            </div>
                            @error('address')
                            <div class="text-danger small mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">المدينة</label>
                            <input type="text" 
                                   name="city" 
                                   class="form-control" 
                                   value="{{ old('city') }}"
                                   placeholder="اسم المدينة">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">المنطقة</label>
                            <input type="text" 
                                   name="state" 
                                   class="form-control" 
                                   value="{{ old('state') }}"
                                   placeholder="اسم المنطقة">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">الرمز البريدي</label>
                            <input type="text" 
                                   name="postal_code" 
                                   class="form-control" 
                                   value="{{ old('postal_code') }}"
                                   placeholder="الرمز البريدي">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">الدولة</label>
                            <select name="country" class="form-select">
                                <option value="المملكة العربية السعودية" {{ old('country', 'المملكة العربية السعودية') == 'المملكة العربية السعودية' ? 'selected' : '' }}>
                                    المملكة العربية السعودية
                                </option>
                                <option value="الإمارات العربية المتحدة" {{ old('country') == 'الإمارات العربية المتحدة' ? 'selected' : '' }}>
                                    الإمارات العربية المتحدة
                                </option>
                                <option value="الكويت" {{ old('country') == 'الكويت' ? 'selected' : '' }}>
                                    الكويت
                                </option>
                                <option value="البحرين" {{ old('country') == 'البحرين' ? 'selected' : '' }}>
                                    البحرين
                                </option>
                                <option value="قطر" {{ old('country') == 'قطر' ? 'selected' : '' }}>
                                    قطر
                                </option>
                                <option value="عمان" {{ old('country') == 'عمان' ? 'selected' : '' }}>
                                    عمان
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submit Buttons --}}
            <div class="d-flex justify-content-between align-items-center gap-3 animate-fadeInUp stagger-3">
                <a href="{{ route('customers.index') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-times me-1"></i> إلغاء
                </a>
                <div class="d-flex gap-2">
                    <button type="submit" name="action" value="save" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-1"></i> حفظ العميل
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
        // Form validation animation
        $('#customerForm').on('submit', function() {
            var btn = $(this).find('button[type="submit"]:focus');
            btn.html('<i class="fas fa-spinner fa-spin me-1"></i> جاري الحفظ...');
            btn.prop('disabled', true);
        });
        
        // Phone number formatting
        $('input[name="phone"]').on('input', function() {
            var value = $(this).val().replace(/\D/g, '');
            if (value.length > 10) value = value.substring(0, 10);
            $(this).val(value);
        });
    });
</script>
@endsection
