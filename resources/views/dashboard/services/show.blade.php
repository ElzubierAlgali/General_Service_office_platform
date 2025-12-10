@extends('layouts.master')
@section('title', 'عرض الخدمة: ' . $service->name)
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">عرض الخدمة: {{ $service->name }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('services.index') }}">الخدمات</a></li>
                <li class="breadcrumb-item active" aria-current="page">عرض الخدمة</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('services.edit', $service->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> تعديل
        </a>
        <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right"></i> العودة للقائمة
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">معلومات الخدمة</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4"><strong class="text-muted">اسم الخدمة:</strong></div>
                    <div class="col-md-8">{{ $service->name }}</div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4"><strong class="text-muted">الكود:</strong></div>
                    <div class="col-md-8"><code>{{ $service->code }}</code></div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4"><strong class="text-muted">الوصف:</strong></div>
                    <div class="col-md-8">{{ $service->description ?? '-' }}</div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4"><strong class="text-muted">السعر:</strong></div>
                    <div class="col-md-8">{{ number_format($service->price, 2) }} ريال</div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4"><strong class="text-muted">المدة المتوقعة:</strong></div>
                    <div class="col-md-8">{{ $service->estimated_duration_days ?? '-' }} يوم</div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4"><strong class="text-muted">الحالة:</strong></div>
                    <div class="col-md-8">
                        @if($service->active)
                            <span class="badge bg-success">نشط</span>
                        @else
                            <span class="badge bg-secondary">غير نشط</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

