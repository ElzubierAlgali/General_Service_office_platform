@extends('layouts.master')
@section('title', 'تعديل عميل')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">تعديل العميل: {{ $customer->name }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">العملاء</a></li>
                <li class="breadcrumb-item active" aria-current="page">تعديل عميل</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right"></i> العودة للقائمة
        </a>
    </div>
</div>

<form action="{{ route('customers.update', $customer->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">بيانات العميل</h6>
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
                            <label class="form-label">الاسم الكامل *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $customer->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">رقم الهوية الوطنية</label>
                            <input type="text" name="national_id" class="form-control @error('national_id') is-invalid @enderror" 
                                   value="{{ old('national_id', $customer->national_id) }}">
                            @error('national_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $customer->email) }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $customer->phone) }}">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">العنوان</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2">{{ old('address', $customer->address) }}</textarea>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">المدينة</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city', $customer->city) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">المنطقة</label>
                            <input type="text" name="state" class="form-control" value="{{ old('state', $customer->state) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">الرمز البريدي</label>
                            <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $customer->postal_code) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الدولة</label>
                        <input type="text" name="country" class="form-control" value="{{ old('country', $customer->country) }}">
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('customers.index') }}" class="btn btn-light">إلغاء</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> حفظ التعديلات
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

