@extends('layouts.master')
@section('title', 'تعديل مستخدم')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">تعديل المستخدم: {{ $user->name }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">المستخدمين</a></li>
                <li class="breadcrumb-item active" aria-current="page">تعديل مستخدم</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right"></i> العودة للقائمة
        </a>
    </div>
</div>

<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">البيانات الأساسية</h6>
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

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الاسم الكامل *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $user->name) }}" required placeholder="أدخل الاسم الكامل">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">البريد الإلكتروني *</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}" required placeholder="example@company.com">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>
                    <p class="text-muted small mb-3">
                        <i class="fas fa-info-circle me-1"></i>
                        اترك حقول كلمة المرور فارغة إذا لم ترغب في تغييرها
                    </p>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">كلمة المرور الجديدة</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                   minlength="8" placeholder="اتركه فارغاً إذا لم ترغب في التغيير">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">تأكيد كلمة المرور</label>
                            <input type="password" name="password_confirmation" class="form-control" 
                                   placeholder="أعد إدخال كلمة المرور">
                        </div>
                    </div>

                    @if(!empty($organizations) && $organizations->count() > 0)
                    <div class="mb-3">
                        <label class="form-label">المنظمة</label>
                        <select name="organization_id" class="form-select select2 @error('organization_id') is-invalid @enderror" data-placeholder="-- اختر المنظمة --">
                            <option value="">-- لا توجد --</option>
                            @foreach($organizations as $org)
                            <option value="{{ $org->id }}" {{ old('organization_id', $user->organization_id) == $org->id ? 'selected' : '' }}>
                                {{ $org->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('organization_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Roles Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">الصلاحيات</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">الصلاحيات</label>
                        <select name="roles[]" class="form-select select2 @error('roles') is-invalid @enderror" multiple data-placeholder="-- اختر الصلاحيات --">
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" 
                                {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $role->display_name ?? $role->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('roles')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">يمكنك اختيار أكثر من صلاحية</small>
                    </div>
                </div>
            </div>

            <!-- User Info Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title mb-0">معلومات المستخدم</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">تاريخ الإنشاء:</small>
                        <div>{{ $user->created_at->format('Y-m-d H:i') }}</div>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted">آخر تحديث:</small>
                        <div>{{ $user->updated_at->format('Y-m-d H:i') }}</div>
                    </div>
                    <div>
                        <small class="text-muted">حالة البريد الإلكتروني:</small>
                        <div>
                            @if($user->email_verified_at)
                                <span class="badge bg-success">مفعّل</span>
                            @else
                                <span class="badge bg-warning">غير مفعّل</span>
                            @endif
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
                        <a href="{{ route('users.index') }}" class="btn btn-light">إلغاء</a>
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

