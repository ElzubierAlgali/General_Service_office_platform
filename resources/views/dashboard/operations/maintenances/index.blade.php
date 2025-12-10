@extends('layouts.master')
@section('title', 'إدارة صيانة المركبات')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">إدارة صيانة المركبات</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">صيانة المركبات</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        @permission('Create Maintenance')
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addUrgentModal">
            <i class="fas fa-exclamation-triangle"></i> صيانة طارئة
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPreventiveModal">
            <i class="fas fa-tools"></i> صيانة وقائية
        </button>
        @endpermission
    </div>
</div>

<!-- Filter Tabs -->
<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link {{ $type == 'all' ? 'active' : '' }}" href="{{ route('maintenances.index') }}">
            <i class="fas fa-list"></i> الكل
            <span class="badge bg-secondary">{{ $stats['total'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $type == 'urgent' ? 'active' : '' }}" href="{{ route('maintenances.index', ['type' => 'urgent']) }}">
            <i class="fas fa-exclamation-circle text-danger"></i> طارئ
            <span class="badge bg-danger">{{ $stats['urgent'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $type == 'preventive' ? 'active' : '' }}" href="{{ route('maintenances.index', ['type' => 'preventive']) }}">
            <i class="fas fa-calendar-check text-primary"></i> وقائي
        </a>
    </li>
</ul>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card bg-danger text-white">
            <div class="card-body text-center py-3">
                <h3 class="mb-0">{{ $stats['urgent'] }}</h3>
                <small>صيانة طارئة</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-warning text-white">
            <div class="card-body text-center py-3">
                <h3 class="mb-0">{{ $stats['overdue'] }}</h3>
                <small>متأخرة</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-info text-white">
            <div class="card-body text-center py-3">
                <h3 class="mb-0">{{ $stats['scheduled'] }}</h3>
                <small>مجدولة</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-primary text-white">
            <div class="card-body text-center py-3">
                <h3 class="mb-0">{{ $stats['in_progress'] }}</h3>
                <small>جاري العمل</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-success text-white">
            <div class="card-body text-center py-3">
                <h3 class="mb-0">{{ $stats['completed_this_month'] }}</h3>
                <small>مكتملة هذا الشهر</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-dark text-white">
            <div class="card-body text-center py-3">
                <h3 class="mb-0">{{ number_format($stats['total_cost_this_month'], 0) }}</h3>
                <small>التكلفة هذا الشهر</small>
            </div>
        </div>
    </div>
</div>

<!-- Maintenance Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">سجلات الصيانة</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="example1">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>النوع</th>
                        <th>المركبة</th>
                        <th>الفئة</th>
                        <th>العنوان</th>
                        <th>التاريخ</th>
                        <th>التكلفة</th>
                        <th>الحالة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($maintenances as $index => $maintenance)
                    <tr class="{{ $maintenance->isOverdue() ? 'table-warning' : '' }}">
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($maintenance->type == 'urgent')
                                <span class="badge bg-danger">
                                    <i class="fas fa-exclamation-triangle"></i> طارئ
                                </span>
                                @if($maintenance->priority == 'critical')
                                    <br><small class="text-danger">حرج</small>
                                @elseif($maintenance->priority == 'high')
                                    <br><small class="text-warning">عالي</small>
                                @endif
                            @else
                                <span class="badge bg-info">
                                    <i class="fas fa-calendar-check"></i> وقائي
                                </span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $maintenance->vehicle->plate_number }}</strong>
                            <br><small class="text-muted">{{ $maintenance->vehicle->brand }} {{ $maintenance->vehicle->model }}</small>
                        </td>
                        <td>{{ $maintenance->category_label }}</td>
                        <td>
                            {{ Str::limit($maintenance->title, 30) }}
                            @if($maintenance->isOverdue())
                                <br><span class="badge bg-warning text-dark">متأخرة</span>
                            @endif
                        </td>
                        <td>
                            @if($maintenance->scheduled_date)
                                {{ $maintenance->scheduled_date->format('Y-m-d') }}
                            @elseif($maintenance->start_date)
                                {{ $maintenance->start_date->format('Y-m-d') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($maintenance->total_cost > 0)
                                <strong>{{ number_format($maintenance->total_cost, 2) }}</strong> ر.س
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @switch($maintenance->status)
                                @case('scheduled')
                                    <span class="badge bg-info">مجدولة</span>
                                    @break
                                @case('in_progress')
                                    <span class="badge bg-primary">جاري العمل</span>
                                    @break
                                @case('completed')
                                    <span class="badge bg-success">مكتملة</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-secondary">ملغية</span>
                                    @break
                            @endswitch
                        </td>
                        <td>
                            @permission('Edit Maintenance')
                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#editMaintenance{{ $maintenance->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            @endpermission
                            @if($maintenance->status == 'in_progress')
                                @permission('Complete Maintenance')
                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#completeMaintenance{{ $maintenance->id }}">
                                    <i class="fas fa-check"></i>
                                </button>
                                @endpermission
                            @endif
                            @permission('Delete Maintenance')
                            <a href="{{ route('maintenances.destroy', $maintenance->id) }}" class="btn btn-sm btn-outline-danger" data-confirm-delete="true">
                                <i class="fas fa-trash"></i>
                            </a>
                            @endpermission
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    @permission('Edit Maintenance')
                    <div class="modal fade" id="editMaintenance{{ $maintenance->id }}" tabindex="-1">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">تعديل سجل الصيانة: {{ $maintenance->title }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('maintenances.update', $maintenance->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">المركبة *</label>
                                                <select class="form-select select2" name="vehicle_id" data-placeholder="-- اختر المركبة --" required>
                                                    @foreach($vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}" {{ $maintenance->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                                        {{ $vehicle->plate_number }} - {{ $vehicle->brand }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">نوع الصيانة *</label>
                                                <select class="form-select select2" name="type" data-placeholder="-- اختر النوع --" required>
                                                    <option value="urgent" {{ $maintenance->type == 'urgent' ? 'selected' : '' }}>صيانة طارئة</option>
                                                    <option value="preventive" {{ $maintenance->type == 'preventive' ? 'selected' : '' }}>صيانة وقائية</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">الفئة *</label>
                                                <select class="form-select select2" name="category" data-placeholder="-- اختر الفئة --" required>
                                                    @foreach($categories as $key => $label)
                                                    <option value="{{ $key }}" {{ $maintenance->category == $key ? 'selected' : '' }}>{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">الأولوية</label>
                                                <select class="form-select select2" name="priority" data-placeholder="-- اختر الأولوية --">
                                                    <option value="low" {{ $maintenance->priority == 'low' ? 'selected' : '' }}>منخفضة</option>
                                                    <option value="medium" {{ $maintenance->priority == 'medium' ? 'selected' : '' }}>متوسطة</option>
                                                    <option value="high" {{ $maintenance->priority == 'high' ? 'selected' : '' }}>عالية</option>
                                                    <option value="critical" {{ $maintenance->priority == 'critical' ? 'selected' : '' }}>حرجة</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">عنوان الصيانة *</label>
                                                <input type="text" class="form-control" name="title" value="{{ $maintenance->title }}" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">الحالة</label>
                                                <select class="form-select select2" name="status" data-placeholder="-- اختر الحالة --">
                                                    <option value="scheduled" {{ $maintenance->status == 'scheduled' ? 'selected' : '' }}>مجدولة</option>
                                                    <option value="in_progress" {{ $maintenance->status == 'in_progress' ? 'selected' : '' }}>جاري العمل</option>
                                                    <option value="completed" {{ $maintenance->status == 'completed' ? 'selected' : '' }}>مكتملة</option>
                                                    <option value="cancelled" {{ $maintenance->status == 'cancelled' ? 'selected' : '' }}>ملغية</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">عداد المسافة</label>
                                                <input type="number" step="0.01" class="form-control" name="mileage_at_service" value="{{ $maintenance->mileage_at_service }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">تاريخ الجدولة</label>
                                                <input type="date" class="form-control" name="scheduled_date" value="{{ $maintenance->scheduled_date?->format('Y-m-d') }}">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">تاريخ البدء</label>
                                                <input type="date" class="form-control" name="start_date" value="{{ $maintenance->start_date?->format('Y-m-d') }}">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">تاريخ الانتهاء</label>
                                                <input type="date" class="form-control" name="end_date" value="{{ $maintenance->end_date?->format('Y-m-d') }}">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">الصيانة القادمة</label>
                                                <input type="date" class="form-control" name="next_service_date" value="{{ $maintenance->next_service_date?->format('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">مقدم الخدمة</label>
                                                <input type="text" class="form-control" name="service_provider" value="{{ $maintenance->service_provider }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">جوال مقدم الخدمة</label>
                                                <input type="text" class="form-control" name="service_provider_phone" value="{{ $maintenance->service_provider_phone }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">اسم الفني</label>
                                                <input type="text" class="form-control" name="technician_name" value="{{ $maintenance->technician_name }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">تكلفة القطع</label>
                                                <input type="number" step="0.01" class="form-control" name="parts_cost" value="{{ $maintenance->parts_cost }}">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">تكلفة العمالة</label>
                                                <input type="number" step="0.01" class="form-control" name="labor_cost" value="{{ $maintenance->labor_cost }}">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">الحساب</label>
                                                <select class="form-select select2" name="account_id" data-placeholder="-- اختر الحساب --">
                                                    <option value="">-- اختر الحساب --</option>
                                                    @foreach($accounts as $account)
                                                    <option value="{{ $account->id }}" {{ $maintenance->account_id == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">طريقة الدفع</label>
                                                <select class="form-select select2" name="payment_method_id" data-placeholder="-- اختر طريقة الدفع --">
                                                    <option value="">-- اختر --</option>
                                                    @foreach($paymentMethods as $pm)
                                                    <option value="{{ $pm->id }}" {{ $maintenance->payment_method_id == $pm->id ? 'selected' : '' }}>{{ $pm->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">الوصف</label>
                                                <textarea class="form-control" name="description" rows="2">{{ $maintenance->description }}</textarea>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">الأعمال المنجزة</label>
                                                <textarea class="form-control" name="work_done" rows="2">{{ $maintenance->work_done }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إغلاق</button>
                                        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endpermission

                    <!-- Complete Modal -->
                    @if($maintenance->status == 'in_progress')
                    @permission('Complete Maintenance')
                    <div class="modal fade" id="completeMaintenance{{ $maintenance->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title">إكمال الصيانة</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('maintenances.complete', $maintenance->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <p>هل تريد تأكيد إكمال صيانة المركبة <strong>{{ $maintenance->vehicle->plate_number }}</strong>؟</p>
                                        <div class="mb-3">
                                            <label class="form-label">تاريخ الانتهاء</label>
                                            <input type="date" class="form-control" name="end_date" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ملخص الأعمال المنجزة</label>
                                            <textarea class="form-control" name="work_done" rows="3">{{ $maintenance->work_done }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إغلاق</button>
                                        <button type="submit" class="btn btn-success">تأكيد الإكمال</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endpermission
                    @endif

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Urgent Maintenance Modal -->
@permission('Create Maintenance')
<div class="modal fade" id="addUrgentModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> إضافة صيانة طارئة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('maintenances.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="urgent">
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> الصيانة الطارئة للأعطال المفاجئة التي تتطلب إصلاحاً فورياً
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">المركبة *</label>
                            <select class="form-select select2" name="vehicle_id" data-placeholder="-- اختر المركبة --" required>
                                <option value="">-- اختر المركبة --</option>
                                @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->plate_number }} - {{ $vehicle->brand }} {{ $vehicle->model }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">فئة الصيانة *</label>
                            <select class="form-select select2" name="category" data-placeholder="-- اختر الفئة --" required>
                                @foreach($categories as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">الأولوية *</label>
                            <select class="form-select select2" name="priority" data-placeholder="-- اختر الأولوية --" required>
                                <option value="high">عالية</option>
                                <option value="critical">حرجة</option>
                                <option value="medium">متوسطة</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">عنوان المشكلة *</label>
                            <input type="text" class="form-control" name="title" placeholder="مثال: عطل في المحرك - صوت غير طبيعي" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">الحالة *</label>
                            <select class="form-select select2" name="status" data-placeholder="-- اختر الحالة --" required>
                                <option value="in_progress">بدء العمل فوراً</option>
                                <option value="scheduled">انتظار الموافقة</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">وصف المشكلة</label>
                            <textarea class="form-control" name="description" rows="2" placeholder="وصف تفصيلي للمشكلة..."></textarea>
                        </div>
                    </div>
                    <hr>
                    <h6 class="text-primary">بيانات مقدم الخدمة</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">اسم الورشة</label>
                            <input type="text" class="form-control" name="service_provider">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">جوال الورشة</label>
                            <input type="text" class="form-control" name="service_provider_phone">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">تاريخ البدء</label>
                            <input type="date" class="form-control" name="start_date" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <hr>
                    <h6 class="text-primary">التكاليف (اختياري)</h6>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">تكلفة القطع</label>
                            <input type="number" step="0.01" class="form-control" name="parts_cost" value="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">تكلفة العمالة</label>
                            <input type="number" step="0.01" class="form-control" name="labor_cost" value="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">الحساب</label>
                            <select class="form-select select2" name="account_id" data-placeholder="-- اختر الحساب --">
                                <option value="">-- اختر الحساب --</option>
                                @foreach($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">طريقة الدفع</label>
                            <select class="form-select select2" name="payment_method_id" data-placeholder="-- اختر طريقة الدفع --">
                                <option value="">-- اختر --</option>
                                @foreach($paymentMethods as $pm)
                                <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-danger">تسجيل الصيانة الطارئة</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpermission

<!-- Add Preventive Maintenance Modal -->
@permission('Create Maintenance')
<div class="modal fade" id="addPreventiveModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-tools"></i> جدولة صيانة وقائية</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('maintenances.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="preventive">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> الصيانة الوقائية لجدولة الصيانة الدورية والفحوصات المنتظمة
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">المركبة *</label>
                            <select class="form-select select2" name="vehicle_id" data-placeholder="-- اختر المركبة --" required>
                                <option value="">-- اختر المركبة --</option>
                                @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->plate_number }} - {{ $vehicle->brand }} {{ $vehicle->model }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">فئة الصيانة *</label>
                            <select class="form-select select2" name="category" data-placeholder="-- اختر الفئة --" required>
                                @foreach($categories as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">تاريخ الجدولة *</label>
                            <input type="date" class="form-control" name="scheduled_date" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">عنوان الصيانة *</label>
                            <input type="text" class="form-control" name="title" placeholder="مثال: تغيير زيت المحرك - صيانة 10,000 كم" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">الحالة *</label>
                            <select class="form-select select2" name="status" data-placeholder="-- اختر الحالة --" required>
                                <option value="scheduled">مجدولة</option>
                                <option value="in_progress">بدء العمل</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">وصف الصيانة</label>
                            <textarea class="form-control" name="description" rows="2"></textarea>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">عداد المسافة الحالي</label>
                            <input type="number" step="0.01" class="form-control" name="mileage_at_service">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">الصيانة القادمة عند (كم)</label>
                            <input type="number" step="0.01" class="form-control" name="next_service_mileage">
                        </div>
                    </div>
                    <hr>
                    <h6 class="text-primary">بيانات مقدم الخدمة</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">اسم الورشة</label>
                            <input type="text" class="form-control" name="service_provider">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">جوال الورشة</label>
                            <input type="text" class="form-control" name="service_provider_phone">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">تاريخ الصيانة القادمة</label>
                            <input type="date" class="form-control" name="next_service_date">
                        </div>
                    </div>
                    <hr>
                    <h6 class="text-primary">التكاليف المتوقعة (اختياري)</h6>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">تكلفة القطع</label>
                            <input type="number" step="0.01" class="form-control" name="parts_cost" value="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">تكلفة العمالة</label>
                            <input type="number" step="0.01" class="form-control" name="labor_cost" value="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">الحساب</label>
                            <select class="form-select select2" name="account_id" data-placeholder="-- اختر الحساب --">
                                <option value="">-- اختر الحساب --</option>
                                @foreach($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">طريقة الدفع</label>
                            <select class="form-select select2" name="payment_method_id" data-placeholder="-- اختر طريقة الدفع --">
                                <option value="">-- اختر --</option>
                                @foreach($paymentMethods as $pm)
                                <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">جدولة الصيانة</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpermission
@endsection

