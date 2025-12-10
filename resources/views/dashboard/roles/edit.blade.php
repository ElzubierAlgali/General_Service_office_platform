@extends('layouts.master')
@section('title', 'تعديل صلاحية')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">تعديل الصلاحية: {{ $role->display_name }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">الصلاحيات</a></li>
                <li class="breadcrumb-item active" aria-current="page">تعديل صلاحية</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right"></i> العودة للقائمة
        </a>
    </div>
</div>

<form action="{{ route('roles.update', $role->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">بيانات الصلاحية</h6>
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
                               value="{{ old('name', $role->name) }}" required placeholder="مثال: admin, manager, editor">
                        <small class="text-muted">اسم فريد يستخدم في الكود (بالإنجليزية، بدون مسافات)</small>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الاسم المعروض *</label>
                        <input type="text" name="display_name" class="form-control @error('display_name') is-invalid @enderror" 
                               value="{{ old('display_name', $role->display_name) }}" required placeholder="مثال: مدير النظام، محرر المحتوى">
                        <small class="text-muted">الاسم الذي سيظهر في الواجهة</small>
                        @error('display_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الوصف</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="3" placeholder="وصف مختصر عن الصلاحية...">{{ old('description', $role->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Permissions Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">الأذونات</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">اختر الأذونات</label>
                        <select name="permissions[]" class="form-select select2 @error('permissions') is-invalid @enderror" multiple data-placeholder="-- اختر الأذونات --">
                            @foreach($permissions as $permission)
                            <option value="{{ $permission->id }}" 
                                {{ in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $permission->display_name ?? $permission->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('permissions')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">يمكنك اختيار أكثر من أذن</small>
                    </div>
                </div>
            </div>

            <!-- Role Info Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">معلومات الصلاحية</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">تاريخ الإنشاء:</small>
                        <div>{{ $role->created_at->format('Y-m-d H:i') }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">آخر تحديث:</small>
                        <div>{{ $role->updated_at->format('Y-m-d H:i') }}</div>
                    </div>
                    <div>
                        <small class="text-muted">عدد المستخدمين:</small>
                        <div>
                            <span class="badge bg-info">{{ $role->users()->count() }} مستخدم</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> حفظ التعديلات
                        </button>
                        <a href="{{ route('roles.index') }}" class="btn btn-light">إلغاء</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            dir: 'rtl'
        });
    });
</script>
@endsection

