@extends('layouts.master')
@section('title', 'إدارة بنود الصرف')
@section('content')

<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">إدارة بنود الصرف</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">بنود الصرف</li>
            </ol>
        </nav>
    </div>
    @permission('Create Expense Catigorties')
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="fas fa-plus me-1"></i> إضافة بند صرف
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
                    <i class="fas fa-tags fa-lg text-white"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $cats->count() }}</h3>
                    <small>إجمالي البنود</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body d-flex align-items-center">
                <div class="avatar bg-white bg-opacity-25 rounded-circle p-3 me-3">
                    <i class="fas fa-check-double fa-lg text-white"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $cats->whereNotNull('discription')->count() }}</h3>
                    <small>بنود موصوفة</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body d-flex align-items-center">
                <div class="avatar bg-white bg-opacity-25 rounded-circle p-3 me-3">
                    <i class="fas fa-clock fa-lg text-white"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $cats->sortByDesc('created_at')->first()?->created_at?->diffForHumans() ?? '-' }}</h3>
                    <small>آخر إضافة</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Categories Grid -->
<div class="row">
    @php
        $colors = [
            'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
            'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
            'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
            'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
            'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)',
            'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)',
            'linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)',
        ];
        $icons = ['fa-gas-pump', 'fa-tools', 'fa-user-tie', 'fa-car', 'fa-building', 'fa-file-invoice', 'fa-shopping-cart', 'fa-ellipsis-h'];
    @endphp
    
    @foreach ($cats as $index => $cat)
    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm h-100 hover-lift">
            <div class="card-body text-center">
                <div class="avatar rounded-circle mx-auto mb-3" style="width: 60px; height: 60px; background: {{ $colors[$index % count($colors)] }}; display: flex; align-items: center; justify-content: center;">
                    <i class="fas {{ $icons[$index % count($icons)] }} fa-lg text-white"></i>
                </div>
                
                <h6 class="mb-2">{{ $cat->name }}</h6>
                
                @if($cat->discription)
                <p class="text-muted small mb-3">{{ Str::limit($cat->discription, 50) }}</p>
                @else
                <p class="text-muted small mb-3 fst-italic">بدون وصف</p>
                @endif
                
                <small class="text-muted d-block mb-3">
                    <i class="fas fa-clock me-1"></i>{{ $cat->created_at->diffForHumans() }}
                </small>

                <div class="d-flex gap-1 justify-content-center">
                    @permission('Edit Expense Catigorties')
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCategory{{ $cat->id }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    @endpermission
                    @permission('Delete Expense Catigorties')
                    <a href="{{ route('expense_catigories.destroy', $cat->id) }}" class="btn btn-sm btn-outline-danger" data-confirm-delete="true">
                        <i class="fas fa-trash"></i>
                    </a>
                    @endpermission
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    @permission('Edit Expense Catigorties')
    <div class="modal fade" id="editCategory{{ $cat->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>تعديل بند الصرف</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('expense_catigories.update', $cat->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <div class="avatar rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; background: {{ $colors[$index % count($colors)] }}; display: flex; align-items: center; justify-content: center;">
                                <i class="fas {{ $icons[$index % count($icons)] }} fa-lg text-white"></i>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">اسم بند الصرف <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ $cat->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">الوصف</label>
                            <textarea class="form-control" name="discription" rows="3" placeholder="وصف بند الصرف...">{{ $cat->discription }}</textarea>
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
            <i class="fas fa-tags fa-2x text-muted"></i>
        </div>
        <h5>لا توجد بنود صرف</h5>
        <p class="text-muted">قم بإضافة بنود الصرف لتصنيف المصروفات</p>
        @permission('Create Expense Catigorties')
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="fas fa-plus me-1"></i> إضافة بند صرف
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
                        <th>بند الصرف</th>
                        <th>الوصف</th>
                        <th>تاريخ الإضافة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cats as $index => $cat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm rounded-circle me-2" style="width: 32px; height: 32px; background: {{ $colors[$index % count($colors)] }}; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas {{ $icons[$index % count($icons)] }} text-white small"></i>
                                </div>
                                <strong>{{ $cat->name }}</strong>
                            </div>
                        </td>
                        <td>
                            <span class="text-muted small">{{ Str::limit($cat->discription, 50) ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="text-muted small">{{ $cat->created_at->diffForHumans() }}</span>
                        </td>
                        <td>
                            @permission('Edit Expense Catigorties')
                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#editCategory{{ $cat->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            @endpermission
                            @permission('Delete Expense Catigorties')
                            <a href="{{ route('expense_catigories.destroy', $cat->id) }}" class="btn btn-sm btn-outline-danger" data-confirm-delete="true">
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

<!-- Add Category Modal -->
@permission('Create Expense Catigorties')
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>إضافة بند صرف جديد</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('expense_catigories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="avatar avatar-lg rounded-circle mx-auto mb-2" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-tags fa-lg text-white"></i>
                        </div>
                        <p class="text-muted small">أضف بند صرف جديد لتصنيف المصروفات</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">اسم بند الصرف <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="مثال: الوقود، الصيانة، الرواتب" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الوصف</label>
                        <textarea class="form-control" name="discription" rows="3" placeholder="وصف مختصر لبند الصرف..."></textarea>
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

<style>
.hover-lift {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}
</style>

@endsection
