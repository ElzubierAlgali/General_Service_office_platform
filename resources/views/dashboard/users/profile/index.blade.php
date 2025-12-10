@extends('layouts.master')
@section('title', 'الملف الشخصي')
@section('content')

<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">الملف الشخصي</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">الملف الشخصي</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <!-- Profile Header Card -->
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex flex-wrap gap-4 align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="position-relative">
                            <div class="avatar avatar-xxl rounded-circle" style="width: 100px; height: 100px;">
                                @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; font-size: 2.5rem;">
                                    {{ $user->initials }}
                                </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-primary btn-sm rounded-circle position-absolute" style="bottom: 0; right: 0;" data-bs-toggle="modal" data-bs-target="#changePhotoModal">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <div class="ms-4">
                            <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                            <p class="text-muted mb-2">{{ $user->position ?? 'لم يتم تحديد المنصب' }}</p>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($user->roles as $role)
                                <span class="badge bg-primary px-3 py-2">
                                    <i class="{{ $role->icon ?? 'fas fa-user-tag' }} me-1"></i>
                                    {{ $role->display_name }}
                                </span>
                                @endforeach
                                <span class="badge bg-{{ $user->status === 'active' ? 'success' : ($user->status === 'inactive' ? 'warning' : 'danger') }} px-3 py-2">
                                    {{ $user->status === 'active' ? 'نشط' : ($user->status === 'inactive' ? 'غير نشط' : 'معلق') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 ms-md-auto">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="fas fa-edit me-1"></i> تعديل البيانات
                        </button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="fas fa-key me-1"></i> تغيير كلمة المرور
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Left Column -->
    <div class="col-lg-4">
        <!-- Basic Information Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-user text-primary me-2"></i>المعلومات الأساسية</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">الاسم الكامل</small>
                    <p class="fw-semibold mb-0">{{ $user->name }}</p>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">البريد الإلكتروني</small>
                    <p class="fw-semibold mb-0">
                        <a href="mailto:{{ $user->email }}" class="text-primary">{{ $user->email }}</a>
                    </p>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">رقم الهاتف</small>
                    <p class="fw-semibold mb-0">
                        <a href="tel:{{ $user->phone }}" class="text-primary" dir="ltr">{{ $user->phone }}</a>
                    </p>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">تاريخ الميلاد</small>
                    <p class="fw-semibold mb-0">
                        {{ $user->Bdate ? \Carbon\Carbon::parse($user->Bdate)->format('d M Y') : 'غير محدد' }}
                    </p>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">العنوان</small>
                    <p class="fw-semibold mb-0">{{ $user->location ?? 'غير محدد' }}</p>
                </div>
                <div>
                    <small class="text-muted d-block">تاريخ الانضمام</small>
                    <p class="fw-semibold mb-0">{{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Account Stats Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent">
                <h5 class="mb-0"><i class="fas fa-chart-pie text-primary me-2"></i>إحصائيات الحساب</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <span class="text-muted">أيام منذ الانضمام</span>
                    <span class="badge bg-primary px-3 py-2">{{ $stats['days_since_joined'] }} يوم</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                    <span class="text-muted">الصلاحيات الممنوحة</span>
                    <span class="badge bg-success px-3 py-2">{{ $user->roles->sum(fn($r) => $r->permissions->count()) }} صلاحية</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">آخر تحديث</span>
                    <span class="text-dark fw-semibold">{{ $user->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <!-- Permissions Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent">
                <h5 class="mb-0"><i class="fas fa-key text-primary me-2"></i>الصلاحيات</h5>
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                @foreach($user->roles as $role)
                    @php
                        $permissionsByGroup = $role->permissions->groupBy('group');
                    @endphp
                    @foreach($permissionsByGroup as $group => $permissions)
                    <div class="mb-3">
                        <h6 class="text-primary mb-2">{{ $group }}</h6>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($permissions as $permission)
                            <span class="badge bg-light text-dark border">{{ $permission->display_name }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-8">
        <!-- Bio Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent">
                <h5 class="mb-0"><i class="fas fa-info-circle text-primary me-2"></i>نبذة عني</h5>
            </div>
            <div class="card-body">
                @if($user->bio)
                <p class="mb-0">{{ $user->bio }}</p>
                @else
                <p class="text-muted mb-0">لم تقم بإضافة نبذة عنك بعد. 
                    <a href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal">أضف نبذة الآن</a>
                </p>
                @endif
            </div>
        </div>

        <!-- Account Settings Form -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent">
                <h5 class="mb-0"><i class="fas fa-cog text-primary me-2"></i>إعدادات الحساب</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">الاسم الكامل *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">البريد الإلكتروني *</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">رقم الهاتف *</label>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" required dir="ltr">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">المسمى الوظيفي</label>
                            <input type="text" name="position" class="form-control" value="{{ old('position', $user->position) }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">العنوان</label>
                            <input type="text" name="location" class="form-control" value="{{ old('location', $user->location) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تاريخ الميلاد</label>
                            <input type="date" name="Bdate" class="form-control" value="{{ old('Bdate', $user->Bdate) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">نبذة عني</label>
                        <textarea name="bio" class="form-control" rows="4" placeholder="اكتب نبذة مختصرة عنك...">{{ old('bio', $user->bio) }}</textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Section -->
        <div class="card border-0 shadow-sm border-start border-warning border-4">
            <div class="card-header bg-transparent">
                <h5 class="mb-0"><i class="fas fa-shield-alt text-warning me-2"></i>الأمان</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h6 class="fw-bold">تغيير كلمة المرور</h6>
                        <p class="text-muted small mb-2">قم بتحديث كلمة المرور الخاصة بك بانتظام للحفاظ على أمان حسابك.</p>
                        <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="fas fa-key me-1"></i> تغيير كلمة المرور
                        </button>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">تحديث الصورة الشخصية</h6>
                        <p class="text-muted small mb-2">قم برفع صورة شخصية واضحة لحسابك.</p>
                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#changePhotoModal">
                            <i class="fas fa-camera me-1"></i> تغيير الصورة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Photo Modal -->
<div class="modal fade" id="changePhotoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-camera text-primary me-2"></i>تغيير الصورة الشخصية</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.update-photo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="avatar mx-auto mb-3" style="width: 150px; height: 150px;">
                            @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;" id="photoPreview">
                            @else
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 150px; height: 150px; font-size: 4rem;" id="photoPreviewInitials">
                                {{ $user->initials }}
                            </div>
                            <img src="" alt="" class="rounded-circle d-none" style="width: 150px; height: 150px; object-fit: cover;" id="photoPreview">
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">اختر صورة جديدة</label>
                        <input type="file" name="photo" class="form-control" accept="image/*" id="photoInput" required>
                        <small class="text-muted">الحد الأقصى: 2 ميجابايت | الصيغ المدعومة: JPG, PNG, GIF, WEBP</small>
                    </div>
                </div>
                <div class="modal-footer">
                    @if($user->photo)
                    <a href="{{ route('profile.delete-photo') }}" class="btn btn-outline-danger me-auto" onclick="return confirm('هل أنت متأكد من حذف الصورة؟')">
                        <i class="fas fa-trash"></i> حذف الصورة
                    </a>
                    @endif
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ الصورة</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-key text-warning me-2"></i>تغيير كلمة المرور</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.update-password') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">كلمة المرور الحالية *</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">كلمة المرور الجديدة *</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                        <small class="text-muted">6 أحرف على الأقل</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">تأكيد كلمة المرور الجديدة *</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-warning">تغيير كلمة المرور</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit text-primary me-2"></i>تعديل البيانات الشخصية</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">الاسم الكامل *</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">البريد الإلكتروني *</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">رقم الهاتف *</label>
                            <input type="tel" name="phone" class="form-control" value="{{ $user->phone }}" required dir="ltr">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">المسمى الوظيفي</label>
                            <input type="text" name="position" class="form-control" value="{{ $user->position }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">العنوان</label>
                            <input type="text" name="location" class="form-control" value="{{ $user->location }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تاريخ الميلاد</label>
                            <input type="date" name="Bdate" class="form-control" value="{{ $user->Bdate }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">نبذة عني</label>
                        <textarea name="bio" class="form-control" rows="4">{{ $user->bio }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Photo preview
    document.getElementById('photoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('photoPreview');
                const initials = document.getElementById('photoPreviewInitials');
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                if (initials) {
                    initials.classList.add('d-none');
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection

