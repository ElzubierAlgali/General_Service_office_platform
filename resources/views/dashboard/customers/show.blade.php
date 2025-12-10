@extends('layouts.master')
@section('title', 'عرض العميل: ' . $customer->name)
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">عرض العميل: {{ $customer->name }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">العملاء</a></li>
                <li class="breadcrumb-item active" aria-current="page">عرض العميل</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> تعديل
        </a>
        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right"></i> العودة للقائمة
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar avatar-xxl rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 120px; height: 120px;">
                    <span style="font-size: 3rem;">{{ strtoupper(substr($customer->name, 0, 2)) }}</span>
                </div>
                <h4 class="mb-1">{{ $customer->name }}</h4>
                @if($customer->email)
                    <p class="text-muted mb-3">{{ $customer->email }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">المعلومات الأساسية</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4"><strong class="text-muted">الاسم:</strong></div>
                    <div class="col-md-8">{{ $customer->name }}</div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4"><strong class="text-muted">البريد الإلكتروني:</strong></div>
                    <div class="col-md-8">{{ $customer->email ?? '-' }}</div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4"><strong class="text-muted">الهاتف:</strong></div>
                    <div class="col-md-8">{{ $customer->phone ?? '-' }}</div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4"><strong class="text-muted">رقم الهوية:</strong></div>
                    <div class="col-md-8">{{ $customer->national_id ?? '-' }}</div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4"><strong class="text-muted">العنوان:</strong></div>
                    <div class="col-md-8">{{ $customer->address ?? '-' }}</div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4"><strong class="text-muted">المدينة:</strong></div>
                    <div class="col-md-8">{{ $customer->city ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">المعاملات ({{ $customer->transactions->count() }})</h6>
            </div>
            <div class="card-body">
                @forelse($customer->transactions as $transaction)
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                        <div>
                            <strong>{{ $transaction->reference_number }}</strong><br>
                            <small class="text-muted">{{ $transaction->service->name ?? '-' }}</small>
                        </div>
                        <span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : 'warning' }}">
                            {{ $transaction->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-muted mb-0">لا توجد معاملات</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

