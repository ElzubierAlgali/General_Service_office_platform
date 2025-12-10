@extends('layouts.master')
@section('title', 'إضافة خدمة')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">إضافة خدمة جديدة</h1>
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
            <i class="fas fa-arrow-right"></i> العودة للقائمة
        </a>
    </div>
</div>

<form action="{{ route('services.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">بيانات الخدمة</h6>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم الخدمة *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الكود *</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                                   value="{{ old('code') }}" required>
                            <small class="text-muted">رمز فريد للخدمة (مثال: business_license)</small>
                            @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الوصف</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">السعر</label>
                            <input type="number" name="price" class="form-control" 
                                   value="{{ old('price', 0) }}" step="0.01" min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">المدة المتوقعة (أيام)</label>
                            <input type="number" name="estimated_duration_days" class="form-control" 
                                   value="{{ old('estimated_duration_days') }}" min="0">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="active" id="active" checked>
                            <label class="form-check-label" for="active">خدمة نشطة</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('services.index') }}" class="btn btn-light">إلغاء</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> إضافة الخدمة
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

