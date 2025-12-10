@extends('layouts.master')
@section('title', 'إضافة أذن')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">إضافة أذن جديد</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">الأذونات</a></li>
                <li class="breadcrumb-item active" aria-current="page">إضافة أذن</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right"></i> العودة للقائمة
        </a>
    </div>
</div>

<form action="{{ route('permissions.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">بيانات الأذن</h6>
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

                    <div class="mb-3">
                        <label class="form-label">الاسم البرمجي *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" required placeholder="مثال: create-users, edit-users, delete-users">
                        <small class="text-muted">اسم فريد يستخدم في الكود (بالإنجليزية، بدون مسافات، استخدم الشرطة بدلاً من المسافات)</small>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الاسم المعروض *</label>
                        <input type="text" name="display_name" class="form-control @error('display_name') is-invalid @enderror" 
                               value="{{ old('display_name') }}" required placeholder="مثال: إنشاء المستخدمين، تعديل المستخدمين">
                        <small class="text-muted">الاسم الذي سيظهر في الواجهة</small>
                        @error('display_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الوصف</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="3" placeholder="وصف مختصر عن الأذن...">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('permissions.index') }}" class="btn btn-light">إلغاء</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> إضافة الأذن
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

