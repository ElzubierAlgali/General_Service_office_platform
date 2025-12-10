@extends('layouts.master')
@section('title', 'إدارة الخدمات')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">إدارة الخدمات</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item active" aria-current="page">قائمة الخدمات</li>
            </ol>
        </nav>
    </div>
    <div>
        @permission('create-services')
        <a href="{{ route('services.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة خدمة
        </a>
        @endpermission
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Search -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('services.index') }}">
            <div class="row">
                <div class="col-md-10">
                    <input type="text" name="search" class="form-control" 
                           value="{{ request('search') }}" 
                           placeholder="ابحث عن خدمة (الاسم، الكود)...">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> بحث
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Services Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">قائمة الخدمات</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="servicesTable">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>اسم الخدمة</th>
                        <th>الكود</th>
                        <th>السعر</th>
                        <th>المدة المتوقعة (يوم)</th>
                        <th>الحالة</th>
                        <th>عدد المعاملات</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $index => $service)
                    <tr>
                        <td>{{ $services->firstItem() + $index }}</td>
                        <td><strong>{{ $service->name }}</strong></td>
                        <td><code>{{ $service->code }}</code></td>
                        <td>{{ number_format($service->price, 2) }} ريال</td>
                        <td>{{ $service->estimated_duration_days ?? '-' }}</td>
                        <td>
                            @if($service->active)
                                <span class="badge bg-success">نشط</span>
                            @else
                                <span class="badge bg-secondary">غير نشط</span>
                            @endif
                        </td>
                        <td><span class="badge bg-info">{{ $service->transactions_count ?? $service->transactions()->count() }}</span></td>
                        <td>
                            <div class="d-flex gap-2">
                                @permission('view-services')
                                <a href="{{ route('services.show', $service->id) }}" class="btn btn-sm btn-outline-info" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endpermission
                                @permission('edit-services')
                                <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-outline-primary" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endpermission
                                @permission('delete-services')
                                <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الخدمة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endpermission
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            لا توجد خدمات
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($services->hasPages())
        <div class="card-footer">
            {{ $services->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#servicesTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json'
            },
            order: [[0, 'desc']],
            pageLength: 25,
            responsive: true,
            paging: false,
            info: false
        });
    });
</script>
@endsection

