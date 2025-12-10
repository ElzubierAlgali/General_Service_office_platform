@extends('layouts.master')
@section('title', 'إدارة الضرائب')
@section('content')

<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">إدارة الضرائب</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">الضرائب</li>
            </ol>
        </nav>
    </div>
    @permission('Create Tax')
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaxModal">
            <i class="fas fa-plus me-1"></i> إضافة ضريبة
        </button>
    </div>
    @endpermission
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body d-flex align-items-center">
                <div class="avatar bg-white bg-opacity-25 rounded-circle p-3 me-3">
                    <i class="fas fa-percentage fa-lg text-white"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $cats->count() }}</h3>
                    <small>إجمالي الضرائب</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body d-flex align-items-center">
                <div class="avatar bg-white bg-opacity-25 rounded-circle p-3 me-3">
                    <i class="fas fa-check-circle fa-lg text-white"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $cats->where('tax_rate', '>', 0)->count() }}</h3>
                    <small>ضرائب فعالة</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body d-flex align-items-center">
                <div class="avatar bg-white bg-opacity-25 rounded-circle p-3 me-3">
                    <i class="fas fa-calculator fa-lg text-white"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $cats->max('tax_rate') ?? 0 }}%</h3>
                    <small>أعلى نسبة ضريبة</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tax Cards Grid -->
<div class="row">
    @foreach ($cats as $cat)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 {{ $cat->tax_rate == 0 ? 'border-start border-success border-4' : 'border-start border-warning border-4' }}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar rounded-circle p-3 me-3" style="background: {{ $cat->tax_rate > 0 ? 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)' : 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)' }};">
                            <i class="fas {{ $cat->tax_rate > 0 ? 'fa-percentage' : 'fa-ban' }} text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ $cat->name }}</h5>
                            <code class="bg-light px-2 py-1 rounded small">{{ $cat->tax_code }}</code>
                        </div>
                    </div>
                </div>

                <div class="text-center py-3 bg-light rounded mb-3">
                    <h1 class="mb-0 {{ $cat->tax_rate > 0 ? 'text-danger' : 'text-success' }}">
                        {{ $cat->tax_rate }}%
                    </h1>
                    <small class="text-muted">نسبة الضريبة</small>
                </div>
                
                @if($cat->discription)
                <p class="text-muted small mb-3">{{ $cat->discription }}</p>
                @endif

                <div class="d-flex gap-2">
                    @permission('Edit Tax')
                    <button type="button" class="btn btn-sm btn-outline-primary flex-fill" data-bs-toggle="modal" data-bs-target="#editTax{{ $cat->id }}">
                        <i class="fas fa-edit me-1"></i> تعديل
                    </button>
                    @endpermission
                    @permission('Delete Tax')
                    <a href="{{ route('taxes.destroy', $cat->id) }}" class="btn btn-sm btn-outline-danger" data-confirm-delete="true">
                        <i class="fas fa-trash"></i>
                    </a>
                    @endpermission
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    @permission('Edit Tax')
    <div class="modal fade" id="editTax{{ $cat->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>تعديل الضريبة</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('taxes.update', $cat->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">اسم الضريبة <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ $cat->name }}" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">نسبة الضريبة % <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" class="form-control" name="tax_rate" value="{{ $cat->tax_rate }}" required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">رمز الضريبة <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="tax_code" value="{{ $cat->tax_code }}" placeholder="VAT, EXEMPT">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الوصف</label>
                            <textarea class="form-control" name="discription" rows="3">{{ $cat->discription }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endpermission
    @endforeach
</div>

<!-- Empty State -->
@if($cats->isEmpty())
<div class="card border-0 shadow-sm">
    <div class="card-body text-center py-5">
        <div class="avatar bg-light rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-percentage fa-2x text-muted"></i>
        </div>
        <h5>لا توجد ضرائب</h5>
        <p class="text-muted">قم بإضافة الضرائب المطبقة في النظام</p>
        @permission('Create Tax')
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaxModal">
            <i class="fas fa-plus me-1"></i> إضافة ضريبة
        </button>
        @endpermission
    </div>
</div>
@endif

<!-- Table View -->
@if($cats->isNotEmpty())
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-transparent">
        <h6 class="mb-0"><i class="fas fa-table me-2"></i>عرض الجدول</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="example1">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>الضريبة</th>
                        <th>الرمز</th>
                        <th>النسبة</th>
                        <th>الوصف</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cats as $index => $cat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm rounded-circle me-2" style="width: 32px; height: 32px; background: {{ $cat->tax_rate > 0 ? '#f5576c' : '#38ef7d' }}; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas {{ $cat->tax_rate > 0 ? 'fa-percentage' : 'fa-ban' }} text-white small"></i>
                                </div>
                                <strong>{{ $cat->name }}</strong>
                            </div>
                        </td>
                        <td><code>{{ $cat->tax_code }}</code></td>
                        <td>
                            <span class="badge {{ $cat->tax_rate > 0 ? 'bg-danger' : 'bg-success' }} fs-6">
                                {{ $cat->tax_rate }}%
                            </span>
                        </td>
                        <td><span class="text-muted small">{{ Str::limit($cat->discription, 40) }}</span></td>
                        <td>
                            @permission('Edit Tax')
                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#editTax{{ $cat->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            @endpermission
                            @permission('Delete Tax')
                            <a href="{{ route('taxes.destroy', $cat->id) }}" class="btn btn-sm btn-outline-danger" data-confirm-delete="true">
                                <i class="fas fa-trash"></i>
                            </a>
                            @endpermission
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<!-- Add Tax Modal -->
@permission('Create Tax')
<div class="modal fade" id="addTaxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>إضافة ضريبة جديدة</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('taxes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="avatar avatar-lg rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-percentage fa-lg text-white"></i>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">اسم الضريبة <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="مثال: ضريبة القيمة المضافة" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">نسبة الضريبة % <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control @error('tax_rate') is-invalid @enderror" name="tax_rate" placeholder="15" required>
                                <span class="input-group-text">%</span>
                            </div>
                            @error('tax_rate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رمز الضريبة</label>
                            <input type="text" class="form-control" name="tax_code" placeholder="VAT">
                            <small class="text-muted">رمز مختصر بالإنجليزية</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الوصف</label>
                        <textarea class="form-control" name="discription" rows="3" placeholder="وصف مختصر للضريبة..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus me-1"></i> إضافة</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpermission

@endsection
