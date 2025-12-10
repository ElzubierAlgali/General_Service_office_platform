@extends('layouts.master')

@section('title', 'إدارة الرحلات')

@section('content')
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between mb-4">
    <div class="my-auto mb-2">
        <h5 class="page-title fw-semibold fs-18 mb-0">إدارة الرحلات</h5>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">العمليات</a></li>
                <li class="breadcrumb-item active" aria-current="page">إدارة الرحلات</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex my-xl-auto gap-2">
        <a href="{{ route('trips.monitor') }}" class="btn btn-info">
            <i class="fas fa-tv me-1"></i> المراقبة الحية
        </a>
        @permission('Create Trip')
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTripModal">
            <i class="fas fa-plus me-1"></i> رحلة جديدة
        </button>
        @endpermission
    </div>
</div>

<!-- Today's Stats -->
<div class="row mb-4">
    <div class="col-12 col-md-6 col-xl mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">رحلات اليوم</p>
                        <h3 class="mb-0">{{ $todayStats['total'] }}</h3>
                    </div>
                    <div class="avatar bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-route fa-lg text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">الرحلات النشطة</p>
                        <h3 class="mb-0 text-info">{{ $todayStats['active'] }}</h3>
                    </div>
                    <div class="avatar bg-info bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-car fa-lg text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">المكتملة</p>
                        <h3 class="mb-0 text-success">{{ $todayStats['completed'] }}</h3>
                    </div>
                    <div class="avatar bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-check-circle fa-lg text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">الملغاة</p>
                        <h3 class="mb-0 text-danger">{{ $todayStats['cancelled'] }}</h3>
                    </div>
                    <div class="avatar bg-danger bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-times-circle fa-lg text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">إيرادات اليوم</p>
                        <h3 class="mb-0 text-success">{{ number_format($todayStats['revenue'], 2) }}</h3>
                        <small class="text-muted">ريال</small>
                    </div>
                    <div class="avatar bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="fas fa-coins fa-lg text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Active Trips with Live Counter -->
@if($activeTrips->count() > 0)
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
        <h6 class="card-title mb-0">
            <i class="fas fa-satellite-dish me-2"></i>
            الرحلات النشطة - المراقبة الحية
            <span class="badge bg-white text-primary ms-2">{{ $activeTrips->count() }}</span>
        </h6>
        <button class="btn btn-sm btn-light" onclick="refreshActiveTrips()">
            <i class="fas fa-sync-alt"></i>
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>رقم الرحلة</th>
                        <th>العميل</th>
                        <th>السائق</th>
                        <th>الحالة</th>
                        <th>الوقت المنقضي</th>
                        <th>من / إلى</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="activeTripsBody">
                    @foreach($activeTrips as $trip)
                    <tr class="trip-row" data-trip-id="{{ $trip->id }}">
                        <td>
                            <span class="badge bg-dark">{{ $trip->trip_number }}</span>
                        </td>
                        <td>
                            <strong>{{ $trip->client_name }}</strong>
                            @if($trip->client_phone)
                            <br><small class="text-muted">{{ $trip->client_phone }}</small>
                            @endif
                        </td>
                        <td>
                            @if($trip->driver)
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm bg-primary text-white rounded-circle me-2">
                                    {{ mb_substr($trip->driver->name_ar ?? $trip->driver->name_en, 0, 1) }}
                                </div>
                                <div>
                                    <span>{{ $trip->driver->name_ar ?? $trip->driver->name_en }}</span>
                                    @if($trip->vehicle)
                                    <br><small class="text-muted">{{ $trip->vehicle->plate_number }}</small>
                                    @endif
                                </div>
                            </div>
                            @else
                            <span class="text-muted">غير معين</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $trip->status_color }} px-3 py-2">
                                {{ $trip->status_label }}
                            </span>
                        </td>
                        <td>
                            <div class="trip-timer" 
                                 data-status="{{ $trip->status }}"
                                 data-accepted="{{ $trip->accepted_at?->toISOString() }}"
                                 data-enroute="{{ $trip->en_route_at?->toISOString() }}"
                                 data-arrived="{{ $trip->arrived_at?->toISOString() }}"
                                 data-started="{{ $trip->started_at?->toISOString() }}">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-stopwatch text-primary me-2"></i>
                                    <span class="timer-display fs-5 fw-bold text-primary">00:00:00</span>
                                </div>
                                <small class="text-muted timer-label"></small>
                            </div>
                        </td>
                        <td>
                            <div class="small">
                                <div class="text-success"><i class="fas fa-map-marker-alt me-1"></i> {{ Str::limit($trip->pickup_location, 25) }}</div>
                                <div class="text-danger"><i class="fas fa-flag-checkered me-1"></i> {{ Str::limit($trip->dropoff_location, 25) }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @switch($trip->status)
                                    @case('assigned')
                                        <form action="{{ route('trips.accept', $trip->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success" title="قبول">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        @break
                                    @case('accepted')
                                        <form action="{{ route('trips.enroute', $trip->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-info" title="في الطريق">
                                                <i class="fas fa-car"></i>
                                            </button>
                                        </form>
                                        @break
                                    @case('en_route')
                                        <form action="{{ route('trips.arrive', $trip->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-warning" title="وصلت">
                                                <i class="fas fa-map-pin"></i>
                                            </button>
                                        </form>
                                        @break
                                    @case('arrived')
                                        <form action="{{ route('trips.start', $trip->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-primary" title="بدء الرحلة">
                                                <i class="fas fa-play"></i>
                                            </button>
                                        </form>
                                        @break
                                    @case('in_progress')
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#completeTrip{{ $trip->id }}" title="إنهاء الرحلة">
                                            <i class="fas fa-flag-checkered"></i>
                                        </button>
                                        @break
                                @endswitch
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelTrip{{ $trip->id }}" title="إلغاء">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Complete Trip Modals -->
@foreach($activeTrips->where('status', 'in_progress') as $trip)
<div class="modal fade" id="completeTrip{{ $trip->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-flag-checkered me-2"></i>إنهاء الرحلة</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('trips.complete', $trip->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>رقم الرحلة:</strong> {{ $trip->trip_number }}<br>
                        <strong>العميل:</strong> {{ $trip->client_name }}
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">المسافة (كم)</label>
                            <input type="number" step="0.01" name="distance_km" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">أجرة المسافة</label>
                            <input type="number" step="0.01" name="distance_fare" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">أجرة الانتظار</label>
                            <input type="number" step="0.01" name="wait_fare" class="form-control" value="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">إضافات</label>
                            <input type="number" step="0.01" name="extras" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">خصم</label>
                            <input type="number" step="0.01" name="discount" class="form-control" value="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">طريقة الدفع</label>
                            <select name="payment_method_id" class="form-select select2" data-placeholder="-- اختر --">
                                <option value="">-- اختر --</option>
                                @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}" {{ $trip->payment_method_id == $method->id ? 'selected' : '' }}>{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الحساب المستلم</label>
                        <select name="account_id" class="form-select select2" data-placeholder="-- اختر الحساب --">
                            <option value="">-- اختر الحساب --</option>
                            @foreach(\App\Models\Finance\Account::all() as $account)
                            <option value="{{ $account->id }}">{{ $account->name }} ({{ number_format($account->balance, 2) }} ر.س)</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i> إنهاء الرحلة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Cancel Trip Modals -->
@foreach($activeTrips as $trip)
<div class="modal fade" id="cancelTrip{{ $trip->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-times-circle me-2"></i>إلغاء الرحلة</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('trips.cancel', $trip->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <strong>تحذير:</strong> أنت على وشك إلغاء الرحلة رقم {{ $trip->trip_number }}
                    </div>
                    <div class="mb-3">
                        <label class="form-label">سبب الإلغاء *</label>
                        <textarea name="cancellation_reason" class="form-control" rows="3" required placeholder="اذكر سبب الإلغاء..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i> تأكيد الإلغاء
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endif

<!-- Filters -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('trips.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label">الحالة</label>
                <select name="status" class="form-select select2" data-placeholder="-- الكل --">
                    <option value="all" {{ $status == 'all' ? 'selected' : '' }}>الكل</option>
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>انتظار التعيين</option>
                    <option value="assigned" {{ $status == 'assigned' ? 'selected' : '' }}>تم التعيين</option>
                    <option value="accepted" {{ $status == 'accepted' ? 'selected' : '' }}>تم القبول</option>
                    <option value="en_route" {{ $status == 'en_route' ? 'selected' : '' }}>في الطريق</option>
                    <option value="arrived" {{ $status == 'arrived' ? 'selected' : '' }}>وصل للعميل</option>
                    <option value="in_progress" {{ $status == 'in_progress' ? 'selected' : '' }}>جارية</option>
                    <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>مكتملة</option>
                    <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>ملغاة</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">السائق</label>
                <select name="driver_id" class="form-select select2" data-placeholder="-- الكل --">
                    <option value="">-- الكل --</option>
                    @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}" {{ request('driver_id') == $driver->id ? 'selected' : '' }}>{{ $driver->name_ar ?? $driver->name_en }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">من تاريخ</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">إلى تاريخ</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">بحث</label>
                <input type="text" name="search" class="form-control" placeholder="رقم الرحلة، اسم العميل..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search me-1"></i> بحث
                </button>
            </div>
        </form>
    </div>
</div>

<!-- All Trips Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header">
        <h6 class="card-title mb-0">سجل الرحلات</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>رقم الرحلة</th>
                        <th>العميل</th>
                        <th>السائق / المركبة</th>
                        <th>المسار</th>
                        <th>الحالة</th>
                        <th>المدة</th>
                        <th>المبلغ</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trips as $index => $trip)
                    <tr>
                        <td>{{ $trips->firstItem() + $index }}</td>
                        <td>
                            <span class="badge bg-dark">{{ $trip->trip_number }}</span>
                            @if($trip->trip_type != 'standard')
                            <br>
                            <span class="badge bg-{{ $trip->trip_type == 'vip' ? 'warning' : ($trip->trip_type == 'airport' ? 'info' : 'secondary') }} mt-1">
                                {{ $trip->trip_type == 'vip' ? 'VIP' : ($trip->trip_type == 'airport' ? 'مطار' : 'بالساعة') }}
                            </span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $trip->client_name }}</strong>
                            @if($trip->client_phone)
                            <br><small class="text-muted">{{ $trip->client_phone }}</small>
                            @endif
                        </td>
                        <td>
                            @if($trip->driver)
                            <span>{{ $trip->driver->name_ar ?? $trip->driver->name_en }}</span>
                            @if($trip->vehicle)
                            <br><small class="text-muted">{{ $trip->vehicle->plate_number }}</small>
                            @endif
                            @else
                            <span class="text-muted">غير معين</span>
                            @endif
                        </td>
                        <td>
                            <div class="small">
                                <div class="text-success"><i class="fas fa-circle fa-xs me-1"></i>{{ Str::limit($trip->pickup_location, 20) }}</div>
                                <div class="text-danger"><i class="fas fa-circle fa-xs me-1"></i>{{ Str::limit($trip->dropoff_location, 20) }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-{{ $trip->status_color }}">{{ $trip->status_label }}</span>
                        </td>
                        <td>
                            @if($trip->total_duration)
                            {{ \App\Models\Trip::formatDuration($trip->total_duration) }}
                            @else
                            --
                            @endif
                        </td>
                        <td>
                            @if($trip->total_fare > 0)
                            <span class="fw-bold text-success">{{ number_format($trip->total_fare, 2) }}</span>
                            <br><small class="text-muted">ر.س</small>
                            @else
                            --
                            @endif
                        </td>
                        <td>
                            {{ $trip->requested_at?->format('Y-m-d') }}
                            <br><small class="text-muted">{{ $trip->requested_at?->format('H:i') }}</small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('trips.show', $trip->id) }}" class="btn btn-outline-info" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @permission('Edit Trip')
                                @if(!in_array($trip->status, ['completed', 'cancelled']))
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTrip{{ $trip->id }}" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @endif
                                @endpermission
                                @permission('Delete Trip')
                                @if(!in_array($trip->status, ['in_progress', 'completed']))
                                <a href="{{ route('trips.destroy', $trip->id) }}" class="btn btn-outline-danger" data-confirm-delete="true" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </a>
                                @endif
                                @endpermission
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-route fa-3x mb-3 opacity-50"></i>
                                <p>لا توجد رحلات</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($trips->hasPages())
    <div class="card-footer">
        {{ $trips->withQueryString()->links() }}
    </div>
    @endif
</div>

<!-- Add Trip Modal -->
@permission('Create Trip')
<div class="modal fade" id="addTripModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>رحلة جديدة</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('trips.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم العميل *</label>
                            <input type="text" name="client_name" class="form-control" required placeholder="أدخل اسم العميل">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">رقم الجوال</label>
                            <input type="text" name="client_phone" class="form-control" placeholder="05xxxxxxxx">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">موقع الالتقاط *</label>
                            <input type="text" name="pickup_location" class="form-control" required placeholder="أدخل عنوان الالتقاط">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">موقع الوصول *</label>
                            <input type="text" name="dropoff_location" class="form-control" required placeholder="أدخل عنوان الوصول">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">السائق</label>
                            <select name="driver_id" class="form-select select2" data-placeholder="-- اختر السائق --">
                                <option value="">-- اختر السائق --</option>
                                @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->name_ar ?? $driver->name_en }} ({{ $driver->status == 'active' ? 'متاح' : 'مشغول' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">المركبة</label>
                            <select name="vehicle_id" class="form-select select2" data-placeholder="-- اختر المركبة --">
                                <option value="">-- اختر المركبة --</option>
                                @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->plate_number }} - {{ $vehicle->brand }} {{ $vehicle->model }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">نوع الرحلة</label>
                            <select name="trip_type" class="form-select select2" data-placeholder="-- اختر النوع --">
                                <option value="standard">عادية</option>
                                <option value="vip">VIP</option>
                                <option value="airport">مطار</option>
                                <option value="hourly">بالساعة</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">الأجرة الأساسية</label>
                            <input type="number" step="0.01" name="base_fare" class="form-control" value="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">طريقة الدفع</label>
                            <select name="payment_method_id" class="form-select select2" data-placeholder="-- اختر --">
                                <option value="">-- اختر --</option>
                                @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_scheduled" id="isScheduled" class="form-check-input" value="1">
                                <label for="isScheduled" class="form-check-label">رحلة مجدولة</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3" id="scheduledAtField" style="display: none;">
                            <label class="form-label">موعد الرحلة</label>
                            <input type="datetime-local" name="scheduled_at" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="أي ملاحظات إضافية..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> إنشاء الرحلة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpermission

<!-- Edit Trip Modals -->
@foreach($trips as $trip)
@if(!in_array($trip->status, ['completed', 'cancelled']))
<div class="modal fade" id="editTrip{{ $trip->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>تعديل الرحلة</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('trips.update', $trip->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم العميل *</label>
                            <input type="text" name="client_name" class="form-control" value="{{ $trip->client_name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">رقم الجوال</label>
                            <input type="text" name="client_phone" class="form-control" value="{{ $trip->client_phone }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">موقع الالتقاط *</label>
                            <input type="text" name="pickup_location" class="form-control" value="{{ $trip->pickup_location }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">موقع الوصول *</label>
                            <input type="text" name="dropoff_location" class="form-control" value="{{ $trip->dropoff_location }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">السائق</label>
                            <select name="driver_id" class="form-select select2" data-placeholder="-- اختر السائق --">
                                <option value="">-- اختر السائق --</option>
                                @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}" {{ $trip->driver_id == $driver->id ? 'selected' : '' }}>{{ $driver->name_ar ?? $driver->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">المركبة</label>
                            <select name="vehicle_id" class="form-select select2" data-placeholder="-- اختر المركبة --">
                                <option value="">-- اختر المركبة --</option>
                                @foreach(\App\Models\Vehicle::all() as $vehicle)
                                <option value="{{ $vehicle->id }}" {{ $trip->vehicle_id == $vehicle->id ? 'selected' : '' }}>{{ $vehicle->plate_number }} - {{ $vehicle->brand }} {{ $vehicle->model }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الأجرة الأساسية</label>
                            <input type="number" step="0.01" name="base_fare" class="form-control" value="{{ $trip->base_fare }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">طريقة الدفع</label>
                            <select name="payment_method_id" class="form-select select2" data-placeholder="-- اختر --">
                                <option value="">-- اختر --</option>
                                @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}" {{ $trip->payment_method_id == $method->id ? 'selected' : '' }}>{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="2">{{ $trip->notes }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-save me-1"></i> حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection

@section('scripts')
<script>
// Trip Timer Logic
class TripTimer {
    constructor() {
        this.timers = document.querySelectorAll('.trip-timer');
        this.init();
    }

    init() {
        this.timers.forEach(timer => this.setupTimer(timer));
        setInterval(() => this.updateAll(), 1000);
    }

    setupTimer(timerEl) {
        const status = timerEl.dataset.status;
        const labelEl = timerEl.querySelector('.timer-label');
        
        let label = '';
        switch(status) {
            case 'accepted': label = 'منذ القبول'; break;
            case 'en_route': label = 'في الطريق'; break;
            case 'arrived': label = 'في الانتظار'; break;
            case 'in_progress': label = 'مدة الرحلة'; break;
        }
        labelEl.textContent = label;
    }

    updateAll() {
        this.timers.forEach(timer => {
            const status = timer.dataset.status;
            let startTime = null;

            switch(status) {
                case 'accepted': startTime = timer.dataset.accepted; break;
                case 'en_route': startTime = timer.dataset.enroute; break;
                case 'arrived': startTime = timer.dataset.arrived; break;
                case 'in_progress': startTime = timer.dataset.started; break;
            }

            if (startTime) {
                const start = new Date(startTime);
                const now = new Date();
                const diff = Math.floor((now - start) / 1000);
                
                const hours = Math.floor(diff / 3600);
                const minutes = Math.floor((diff % 3600) / 60);
                const seconds = diff % 60;
                
                const display = timer.querySelector('.timer-display');
                display.textContent = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                
                // Color coding based on time
                if (status === 'arrived' && diff > 300) { // More than 5 minutes waiting
                    display.classList.remove('text-primary', 'text-success');
                    display.classList.add('text-warning');
                } else if (diff > 3600) { // More than 1 hour
                    display.classList.remove('text-primary', 'text-success');
                    display.classList.add('text-danger');
                }
            }
        });
    }
}

// Initialize timer
document.addEventListener('DOMContentLoaded', function() {
    new TripTimer();
    
    // Toggle scheduled date field
    document.getElementById('isScheduled')?.addEventListener('change', function() {
        document.getElementById('scheduledAtField').style.display = this.checked ? 'block' : 'none';
    });
});

// Refresh active trips
function refreshActiveTrips() {
    location.reload();
}
</script>
@endsection

