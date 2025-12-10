@extends('layouts.master')
@section('title', 'إدارة المركبات')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">إدارة المركبات</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">إدارة المركبات</li>
            </ol>
        </nav>
    </div>
    @permission('Create Vehicle')
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVehicleModal">
            <i class="fas fa-plus"></i> إضافة مركبة
        </button>
    </div>
    @endpermission
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $vehicles->where('status', 'available')->count() }}</h3>
                <small>متاحة</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $vehicles->where('status', 'in_use')->count() }}</h3>
                <small>قيد الاستخدام</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $vehicles->where('status', 'maintenance')->count() }}</h3>
                <small>صيانة</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-secondary text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $vehicles->count() }}</h3>
                <small>إجمالي المركبات</small>
            </div>
        </div>
    </div>
</div>

<!-- Vehicles Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">قائمة المركبات</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="example1">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>رقم اللوحة</th>
                        <th>المركبة</th>
                        <th>الفئة</th>
                        <th>الحالة</th>
                        <th>السائق الحالي</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $index => $vehicle)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $vehicle->plate_number }}</strong></td>
                        <td>
                            {{ $vehicle->brand }} {{ $vehicle->model }}
                            <br><small class="text-muted">{{ $vehicle->year }} - {{ $vehicle->color }}</small>
                        </td>
                        <td>
                            @switch($vehicle->class)
                                @case('vip') <span class="badge bg-warning">VIP</span> @break
                                @case('royal') <span class="badge bg-danger">Royal</span> @break
                                @case('business') <span class="badge bg-primary">Business</span> @break
                                @default <span class="badge bg-secondary">Standard</span>
                            @endswitch
                        </td>
                        <td>
                            @switch($vehicle->status)
                                @case('available') <span class="badge bg-success">متاحة</span> @break
                                @case('in_use') <span class="badge bg-primary">قيد الاستخدام</span> @break
                                @case('maintenance') <span class="badge bg-warning">صيانة</span> @break
                                @case('inactive') <span class="badge bg-danger">غير نشطة</span> @break
                            @endswitch
                        </td>
                        <td>{{ $vehicle->currentDriver->name ?? '-' }}</td>
                        <td>
                            @permission('Edit Vehicle')
                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#editVehicle{{ $vehicle->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            @endpermission
                            @permission('Delete Vehicle')
                            <a href="{{ route('vehicles.destroy', $vehicle->id) }}" class="btn btn-sm btn-outline-danger" data-confirm-delete="true">
                                <i class="fas fa-trash"></i>
                            </a>
                            @endpermission
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    @permission('Edit Vehicle')
                    <div class="modal fade" id="editVehicle{{ $vehicle->id }}" tabindex="-1">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">تعديل المركبة: {{ $vehicle->plate_number }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">رقم اللوحة *</label>
                                                <input type="text" class="form-control" name="plate_number" value="{{ $vehicle->plate_number }}" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">الماركة *</label>
                                                <input type="text" class="form-control" name="brand" value="{{ $vehicle->brand }}" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">الموديل *</label>
                                                <input type="text" class="form-control" name="model" value="{{ $vehicle->model }}" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">السنة *</label>
                                                <input type="number" class="form-control" name="year" value="{{ $vehicle->year }}" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">اللون *</label>
                                                <input type="text" class="form-control" name="color" value="{{ $vehicle->color }}" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">النوع</label>
                                                <select class="form-select select2" name="type" data-placeholder="-- اختر النوع --">
                                                    <option value="sedan" {{ $vehicle->type == 'sedan' ? 'selected' : '' }}>سيدان</option>
                                                    <option value="suv" {{ $vehicle->type == 'suv' ? 'selected' : '' }}>SUV</option>
                                                    <option value="van" {{ $vehicle->type == 'van' ? 'selected' : '' }}>فان</option>
                                                    <option value="luxury" {{ $vehicle->type == 'luxury' ? 'selected' : '' }}>فاخرة</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">الفئة</label>
                                                <select class="form-select select2" name="class" data-placeholder="-- اختر الفئة --">
                                                    <option value="standard" {{ $vehicle->class == 'standard' ? 'selected' : '' }}>Standard</option>
                                                    <option value="business" {{ $vehicle->class == 'business' ? 'selected' : '' }}>Business</option>
                                                    <option value="vip" {{ $vehicle->class == 'vip' ? 'selected' : '' }}>VIP</option>
                                                    <option value="royal" {{ $vehicle->class == 'royal' ? 'selected' : '' }}>Royal</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">عدد المقاعد</label>
                                                <input type="number" class="form-control" name="seats" value="{{ $vehicle->seats }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">الحالة</label>
                                                <select class="form-select select2" name="status" data-placeholder="-- اختر الحالة --">
                                                    <option value="available" {{ $vehicle->status == 'available' ? 'selected' : '' }}>متاحة</option>
                                                    <option value="in_use" {{ $vehicle->status == 'in_use' ? 'selected' : '' }}>قيد الاستخدام</option>
                                                    <option value="maintenance" {{ $vehicle->status == 'maintenance' ? 'selected' : '' }}>صيانة</option>
                                                    <option value="inactive" {{ $vehicle->status == 'inactive' ? 'selected' : '' }}>غير نشطة</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">السائق الحالي</label>
                                                <select class="form-select select2" name="current_driver_id" data-placeholder="-- اختر السائق --">
                                                    <option value="">-- بدون سائق --</option>
                                                    @foreach($drivers as $driver)
                                                    <option value="{{ $driver->id }}" {{ $vehicle->current_driver_id == $driver->id ? 'selected' : '' }}>{{ $driver->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">انتهاء التأمين</label>
                                                <input type="date" class="form-control" name="insurance_expiry" value="{{ $vehicle->insurance_expiry?->format('Y-m-d') }}">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">انتهاء الفحص</label>
                                                <input type="date" class="form-control" name="inspection_expiry" value="{{ $vehicle->inspection_expiry?->format('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">السعر اليومي</label>
                                                <input type="number" step="0.01" class="form-control" name="daily_rate" value="{{ $vehicle->daily_rate }}">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">عداد المسافة</label>
                                                <input type="number" step="0.01" class="form-control" name="current_mileage" value="{{ $vehicle->current_mileage }}">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">ملاحظات</label>
                                                <input type="text" class="form-control" name="notes" value="{{ $vehicle->notes }}">
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

<!-- Add Vehicle Modal -->
@permission('Create Vehicle')
<div class="modal fade" id="addVehicleModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة مركبة جديدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('vehicles.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">رقم اللوحة *</label>
                            <input type="text" class="form-control" name="plate_number" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">الماركة *</label>
                            <input type="text" class="form-control" name="brand" placeholder="Mercedes, BMW, Toyota" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">الموديل *</label>
                            <input type="text" class="form-control" name="model" placeholder="S-Class, 7 Series" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">السنة *</label>
                            <input type="number" class="form-control" name="year" value="{{ date('Y') }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">اللون *</label>
                            <input type="text" class="form-control" name="color" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">النوع *</label>
                            <select class="form-select select2" name="type" data-placeholder="-- اختر النوع --" required>
                                <option value="sedan">سيدان</option>
                                <option value="suv">SUV</option>
                                <option value="van">فان</option>
                                <option value="luxury">فاخرة</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">الفئة *</label>
                            <select class="form-select select2" name="class" data-placeholder="-- اختر الفئة --" required>
                                <option value="standard">Standard</option>
                                <option value="business">Business</option>
                                <option value="vip">VIP</option>
                                <option value="royal">Royal</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">عدد المقاعد *</label>
                            <input type="number" class="form-control" name="seats" value="4" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">رقم الهيكل</label>
                            <input type="text" class="form-control" name="vin">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">انتهاء الاستمارة</label>
                            <input type="date" class="form-control" name="registration_expiry">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">انتهاء التأمين</label>
                            <input type="date" class="form-control" name="insurance_expiry">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">انتهاء الفحص</label>
                            <input type="date" class="form-control" name="inspection_expiry">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">السعر اليومي</label>
                            <input type="number" step="0.01" class="form-control" name="daily_rate">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">السعر بالساعة</label>
                            <input type="number" step="0.01" class="form-control" name="hourly_rate">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ملاحظات</label>
                            <input type="text" class="form-control" name="notes">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">إضافة المركبة</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpermission
@endsection

