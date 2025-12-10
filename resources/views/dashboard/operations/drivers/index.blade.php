@extends('layouts.master')
@section('title', 'إدارة السائقين')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">إدارة السائقين</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">إدارة السائقين</li>
            </ol>
        </nav>
    </div>
    @permission('Create Driver')
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDriverModal">
            <i class="fas fa-plus"></i> إضافة سائق
        </button>
    </div>
    @endpermission
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $drivers->where('status', 'active')->count() }}</h3>
                <small>نشط</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $drivers->where('status', 'on_duty')->count() }}</h3>
                <small>في مهمة</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $drivers->where('status', 'on_leave')->count() }}</h3>
                <small>إجازة</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-secondary text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $drivers->count() }}</h3>
                <small>إجمالي السائقين</small>
            </div>
        </div>
    </div>
</div>

<!-- Drivers Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">قائمة السائقين</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="example1">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>الجوال</th>
                        <th>رقم الهوية</th>
                        <th>رقم الرخصة</th>
                        <th>الحالة</th>
                        <th>المركبة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($drivers as $index => $driver)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $driver->name }}</strong>
                            @if($driver->name_en)
                            <br><small class="text-muted">{{ $driver->name_en }}</small>
                            @endif
                        </td>
                        <td>
                            <a href="tel:{{ $driver->phone }}">{{ $driver->phone }}</a>
                        </td>
                        <td>{{ $driver->id_number }}</td>
                        <td>
                            {{ $driver->license_number }}
                            @if($driver->license_expiry && $driver->license_expiry->isPast())
                            <br><span class="badge bg-danger">منتهية</span>
                            @endif
                        </td>
                        <td>
                            @switch($driver->status)
                                @case('active') <span class="badge bg-success">نشط</span> @break
                                @case('on_duty') <span class="badge bg-primary">في مهمة</span> @break
                                @case('off_duty') <span class="badge bg-secondary">خارج الدوام</span> @break
                                @case('on_leave') <span class="badge bg-warning">إجازة</span> @break
                                @case('inactive') <span class="badge bg-danger">غير نشط</span> @break
                            @endswitch
                        </td>
                        <td>{{ $driver->assignedVehicle->plate_number ?? '-' }}</td>
                        <td>
                            @permission('Edit Driver')
                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#editDriver{{ $driver->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            @endpermission
                            @permission('Delete Driver')
                            <a href="{{ route('drivers.destroy', $driver->id) }}" class="btn btn-sm btn-outline-danger" data-confirm-delete="true">
                                <i class="fas fa-trash"></i>
                            </a>
                            @endpermission
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    @permission('Edit Driver')
                    <div class="modal fade" id="editDriver{{ $driver->id }}" tabindex="-1">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">تعديل السائق: {{ $driver->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('drivers.update', $driver->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <h6 class="text-primary mb-3">البيانات الشخصية</h6>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">الاسم بالعربي *</label>
                                                <input type="text" class="form-control" name="name" value="{{ $driver->name }}" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">الاسم بالإنجليزي</label>
                                                <input type="text" class="form-control" name="name_en" value="{{ $driver->name_en }}">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">الجوال *</label>
                                                <input type="text" class="form-control" name="phone" value="{{ $driver->phone }}" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">جوال إضافي</label>
                                                <input type="text" class="form-control" name="phone2" value="{{ $driver->phone2 }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">البريد الإلكتروني</label>
                                                <input type="email" class="form-control" name="email" value="{{ $driver->email }}" placeholder="driver@sidqa.sa">
                                                <small class="text-muted">يستخدم لربط حساب السائق ببوابة السائق</small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">رقم الهوية *</label>
                                                <input type="text" class="form-control" name="id_number" value="{{ $driver->id_number }}" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">انتهاء الهوية</label>
                                                <input type="date" class="form-control" name="id_expiry" value="{{ $driver->id_expiry?->format('Y-m-d') }}">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">رقم الرخصة *</label>
                                                <input type="text" class="form-control" name="license_number" value="{{ $driver->license_number }}" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">انتهاء الرخصة</label>
                                                <input type="date" class="form-control" name="license_expiry" value="{{ $driver->license_expiry?->format('Y-m-d') }}">
                                            </div>
                                        </div>

                                        <h6 class="text-primary mb-3 mt-4">بيانات العمل</h6>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">الحالة</label>
                                                <select class="form-select select2" name="status" data-placeholder="-- اختر الحالة --">
                                                    <option value="active" {{ $driver->status == 'active' ? 'selected' : '' }}>نشط</option>
                                                    <option value="on_duty" {{ $driver->status == 'on_duty' ? 'selected' : '' }}>في مهمة</option>
                                                    <option value="off_duty" {{ $driver->status == 'off_duty' ? 'selected' : '' }}>خارج الدوام</option>
                                                    <option value="on_leave" {{ $driver->status == 'on_leave' ? 'selected' : '' }}>إجازة</option>
                                                    <option value="inactive" {{ $driver->status == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">المركبة المخصصة</label>
                                                <select class="form-select select2" name="assigned_vehicle_id" data-placeholder="-- اختر المركبة --">
                                                    <option value="">-- بدون مركبة --</option>
                                                    @foreach($vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}" {{ $driver->assigned_vehicle_id == $vehicle->id ? 'selected' : '' }}>{{ $vehicle->plate_number }} - {{ $vehicle->brand }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">الراتب الأساسي</label>
                                                <input type="number" step="0.01" class="form-control" name="basic_salary" value="{{ $driver->basic_salary }}">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">نسبة العمولة %</label>
                                                <input type="number" step="0.01" class="form-control" name="commission_rate" value="{{ $driver->commission_rate }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">البنك</label>
                                                <input type="text" class="form-control" name="bank_name" value="{{ $driver->bank_name }}">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">رقم الحساب</label>
                                                <input type="text" class="form-control" name="bank_account" value="{{ $driver->bank_account }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">IBAN</label>
                                                <input type="text" class="form-control" name="iban" value="{{ $driver->iban }}">
                                            </div>
                                        </div>

                                        <h6 class="text-primary mb-3 mt-4">جهة اتصال الطوارئ</h6>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">الاسم</label>
                                                <input type="text" class="form-control" name="emergency_contact_name" value="{{ $driver->emergency_contact_name }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">الجوال</label>
                                                <input type="text" class="form-control" name="emergency_contact_phone" value="{{ $driver->emergency_contact_phone }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">صلة القرابة</label>
                                                <input type="text" class="form-control" name="emergency_contact_relation" value="{{ $driver->emergency_contact_relation }}">
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Driver Modal -->
@permission('Create Driver')
<div class="modal fade" id="addDriverModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة سائق جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('drivers.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <h6 class="text-primary mb-3">البيانات الشخصية</h6>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">الاسم بالعربي *</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">الاسم بالإنجليزي</label>
                            <input type="text" class="form-control" name="name_en">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">الجوال *</label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">الجنسية</label>
                            <input type="text" class="form-control" name="nationality" value="سعودي">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">تاريخ الميلاد</label>
                            <input type="date" class="form-control" name="date_of_birth">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">العنوان</label>
                            <input type="text" class="form-control" name="address">
                        </div>
                    </div>

                    <h6 class="text-primary mb-3 mt-4">الوثائق الرسمية</h6>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">رقم الهوية / الإقامة *</label>
                            <input type="text" class="form-control" name="id_number" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">انتهاء الهوية</label>
                            <input type="date" class="form-control" name="id_expiry">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">رقم رخصة القيادة *</label>
                            <input type="text" class="form-control" name="license_number" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">انتهاء الرخصة</label>
                            <input type="date" class="form-control" name="license_expiry">
                        </div>
                    </div>

                    <h6 class="text-primary mb-3 mt-4">بيانات التوظيف</h6>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">تاريخ التعيين</label>
                            <input type="date" class="form-control" name="hire_date" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">نوع التوظيف</label>
                            <select class="form-select select2" name="employment_type" data-placeholder="-- اختر نوع التوظيف --">
                                <option value="full_time">دوام كامل</option>
                                <option value="part_time">دوام جزئي</option>
                                <option value="contract">عقد</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">الراتب الأساسي</label>
                            <input type="number" step="0.01" class="form-control" name="basic_salary">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">نسبة العمولة %</label>
                            <input type="number" step="0.01" class="form-control" name="commission_rate" value="0">
                        </div>
                    </div>

                    <h6 class="text-primary mb-3 mt-4">جهة اتصال الطوارئ</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">الاسم</label>
                            <input type="text" class="form-control" name="emergency_contact_name">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">الجوال</label>
                            <input type="text" class="form-control" name="emergency_contact_phone">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">صلة القرابة</label>
                            <input type="text" class="form-control" name="emergency_contact_relation">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">إضافة السائق</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpermission
@endsection

