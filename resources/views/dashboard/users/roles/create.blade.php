@extends('layouts.master')
@section('title', 'إضافة صلاحية')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">إضافة صلاحية جديدة</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">الصلاحيات</a></li>
                <li class="breadcrumb-item active" aria-current="page">إضافة صلاحية</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right"></i> العودة للقائمة
        </a>
    </div>
</div>

<form action="{{ route('roles.store') }}" method="POST" id="roleForm">
    @csrf
    <div class="row">
        <!-- Role Info Card -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>معلومات الصلاحية</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">اسم العرض *</label>
                        <input type="text" name="display_name" class="form-control @error('display_name') is-invalid @enderror" 
                               value="{{ old('display_name') }}" required placeholder="مثال: مدير المالية">
                        @error('display_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">الاسم الذي سيظهر للمستخدمين</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الاسم البرمجي *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" required placeholder="finance_manager" pattern="[a-zA-Z_]+" title="حروف إنجليزية و _ فقط">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">بالإنجليزية بدون مسافات</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الأيقونة</label>
                        <input type="text" name="icon" class="form-control" value="{{ old('icon', 'fas fa-user-tag') }}" 
                               placeholder="fas fa-user-tag">
                        <small class="text-muted">FontAwesome icon class</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الوصف</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="وصف مختصر للصلاحية...">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">الأذونات المحددة:</span>
                        <span class="badge bg-primary" id="selectedCount">0</span>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>إضافة الصلاحية
                    </button>
                </div>
            </div>
        </div>

        <!-- Permissions Card -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-key me-2"></i>الأذونات</h6>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-success" onclick="selectAll()">
                            <i class="fas fa-check-double"></i> تحديد الكل
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll()">
                            <i class="fas fa-times"></i> إلغاء الكل
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @error('permission')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    
                    <div class="row">
                        @foreach($permissions as $group => $groupPermissions)
                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="card h-100 border">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                                    <strong class="text-primary">{{ $group }}</strong>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-link p-0 text-success" onclick="selectGroup('{{ Str::slug($group) }}')" title="تحديد الكل">
                                            <i class="fas fa-check-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-link p-0 text-danger ms-1" onclick="deselectGroup('{{ Str::slug($group) }}')" title="إلغاء الكل">
                                            <i class="fas fa-square"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body py-2">
                                    @foreach($groupPermissions as $permission)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input permission-checkbox group-{{ Str::slug($group) }}" 
                                               type="checkbox" 
                                               name="permission[]" 
                                               value="{{ $permission->name }}" 
                                               id="perm_{{ $permission->id }}"
                                               {{ in_array($permission->name, old('permission', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ $permission->display_name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
    // Update selected count
    function updateCount() {
        const count = document.querySelectorAll('.permission-checkbox:checked').length;
        document.getElementById('selectedCount').textContent = count;
    }

    // Select all permissions
    function selectAll() {
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = true);
        updateCount();
    }

    // Deselect all permissions
    function deselectAll() {
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
        updateCount();
    }

    // Select all in a group
    function selectGroup(group) {
        document.querySelectorAll('.group-' + group).forEach(cb => cb.checked = true);
        updateCount();
    }

    // Deselect all in a group
    function deselectGroup(group) {
        document.querySelectorAll('.group-' + group).forEach(cb => cb.checked = false);
        updateCount();
    }

    // Add event listeners
    document.querySelectorAll('.permission-checkbox').forEach(cb => {
        cb.addEventListener('change', updateCount);
    });

    // Initial count
    updateCount();
</script>
@endsection
