@extends('layouts.master')
@section('title', 'إعدادات هيئة الزكاة والضريبة')
@section('content')
<div class="app-page-head d-flex flex-wrap gap-3 align-items-center justify-content-between">
    <div class="clearfix">
        <h1 class="app-page-title">إعدادات هيئة الزكاة والضريبة</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">الإعدادات</a></li>
                <li class="breadcrumb-item active" aria-current="page">هيئة الزكاة والضريبة</li>
            </ol>
        </nav>
    </div>
    <div>
        <button type="button" class="btn btn-outline-primary" onclick="testConnection()">
            <i class="fas fa-plug me-1"></i> اختبار الاتصال
        </button>
    </div>
</div>

<!-- Status Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card {{ ($settings['zatca_enabled'] ?? '0') == '1' ? 'bg-success' : 'bg-secondary' }} text-white">
            <div class="card-body text-center py-3">
                <i class="fas {{ ($settings['zatca_enabled'] ?? '0') == '1' ? 'fa-check-circle' : 'fa-times-circle' }} fa-2x mb-2"></i>
                <h6 class="mb-0">{{ ($settings['zatca_enabled'] ?? '0') == '1' ? 'مفعّل' : 'غير مفعّل' }}</h6>
                <small>حالة التكامل</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card {{ !empty($settings['zatca_vat_number']) ? 'bg-success' : 'bg-warning' }} text-white">
            <div class="card-body text-center py-3">
                <i class="fas {{ !empty($settings['zatca_vat_number']) ? 'fa-check' : 'fa-exclamation-triangle' }} fa-2x mb-2"></i>
                <h6 class="mb-0">بيانات المنشأة</h6>
                <small>{{ !empty($settings['zatca_vat_number']) ? 'مكتمل' : 'غير مكتمل' }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card {{ !empty($settings['zatca_csr']) ? 'bg-success' : 'bg-warning' }} text-white">
            <div class="card-body text-center py-3">
                <i class="fas {{ !empty($settings['zatca_csr']) ? 'fa-check' : 'fa-exclamation-triangle' }} fa-2x mb-2"></i>
                <h6 class="mb-0">CSR</h6>
                <small>{{ !empty($settings['zatca_csr']) ? 'تم الإنشاء' : 'لم يتم الإنشاء' }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card {{ !empty($settings['zatca_certificate']) ? 'bg-success' : 'bg-warning' }} text-white">
            <div class="card-body text-center py-3">
                <i class="fas {{ !empty($settings['zatca_certificate']) ? 'fa-check' : 'fa-exclamation-triangle' }} fa-2x mb-2"></i>
                <h6 class="mb-0">التسجيل</h6>
                <small>{{ !empty($settings['zatca_certificate']) ? 'مسجّل' : 'غير مسجّل' }}</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Main Settings Column -->
    <div class="col-lg-8">
        <!-- Business Information -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-building me-2"></i>بيانات المنشأة
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('settings.zatca.save') }}" method="POST">
                    @csrf
                    
                    <!-- Environment & Status -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label">البيئة <span class="text-danger">*</span></label>
                            <select class="form-select" name="zatca_environment" required>
                                <option value="sandbox" {{ ($settings['zatca_environment'] ?? '') == 'sandbox' ? 'selected' : '' }}>
                                    بيئة التطوير (Sandbox)
                                </option>
                                <option value="simulation" {{ ($settings['zatca_environment'] ?? '') == 'simulation' ? 'selected' : '' }}>
                                    بيئة المحاكاة (Simulation)
                                </option>
                                <option value="production" {{ ($settings['zatca_environment'] ?? '') == 'production' ? 'selected' : '' }}>
                                    بيئة الإنتاج (Production)
                                </option>
                            </select>
                            <small class="text-muted">اختر بيئة التطوير للاختبار أولاً</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">تفعيل التكامل</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="zatca_enabled" id="zatca_enabled" 
                                    {{ ($settings['zatca_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="zatca_enabled">تفعيل إرسال الفواتير تلقائياً</label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Business Details -->
                    <h6 class="text-primary mb-3"><i class="fas fa-info-circle me-1"></i> المعلومات الأساسية</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الرقم الضريبي <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="zatca_vat_number" 
                                value="{{ $settings['zatca_vat_number'] ?? '' }}"
                                placeholder="310000000000003" maxlength="15" required
                                pattern="[0-9]{15}" title="الرقم الضريبي يجب أن يكون 15 رقم">
                            <small class="text-muted">15 رقم - يبدأ بـ 3 وينتهي بـ 3</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">رقم السجل التجاري <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="zatca_cr_number" 
                                value="{{ $settings['zatca_cr_number'] ?? '' }}"
                                placeholder="1010000000" maxlength="20" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم المنشأة (عربي) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="zatca_business_name" 
                                value="{{ $settings['zatca_business_name'] ?? '' }}"
                                placeholder="شركة صِدقا للنقل الخاص" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم المنشأة (إنجليزي) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="zatca_business_name_en" 
                                value="{{ $settings['zatca_business_name_en'] ?? '' }}"
                                placeholder="SIDQA Private Transportation Co." required>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Address -->
                    <h6 class="text-primary mb-3"><i class="fas fa-map-marker-alt me-1"></i> عنوان المنشأة</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الشارع <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="zatca_street" 
                                value="{{ $settings['zatca_street'] ?? '' }}"
                                placeholder="شارع الملك فهد" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">رقم المبنى <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="zatca_building_number" 
                                value="{{ $settings['zatca_building_number'] ?? '' }}"
                                placeholder="1234" maxlength="10" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">الرمز البريدي <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="zatca_postal_code" 
                                value="{{ $settings['zatca_postal_code'] ?? '' }}"
                                placeholder="12345" maxlength="10" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">المدينة <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="zatca_city" 
                                value="{{ $settings['zatca_city'] ?? '' }}"
                                placeholder="الرياض" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">الحي <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="zatca_district" 
                                value="{{ $settings['zatca_district'] ?? '' }}"
                                placeholder="العليا" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">الدولة</label>
                            <input type="text" class="form-control" name="zatca_country" 
                                value="{{ $settings['zatca_country'] ?? 'SA' }}"
                                readonly>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-1"></i> حفظ بيانات المنشأة
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Side Panel -->
    <div class="col-lg-4">
        <!-- OTP & Registration -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-key me-2"></i>التسجيل في فاتورة
                </h5>
            </div>
            <div class="card-body">
                <!-- Step 1: Generate CSR -->
                <div class="mb-4">
                    <h6 class="fw-bold">1. إنشاء CSR</h6>
                    <p class="text-muted small">إنشاء طلب توقيع الشهادة</p>
                    <form action="{{ route('settings.zatca.generate-csr') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-success w-100" 
                            {{ empty($settings['zatca_vat_number']) ? 'disabled' : '' }}>
                            <i class="fas fa-certificate me-1"></i> 
                            {{ !empty($settings['zatca_csr']) ? 'إعادة إنشاء CSR' : 'إنشاء CSR' }}
                        </button>
                    </form>
                    @if(!empty($settings['zatca_csr']))
                        <small class="text-success d-block mt-2"><i class="fas fa-check"></i> تم إنشاء CSR</small>
                    @endif
                </div>

                <!-- Step 2: Enter OTP -->
                <div class="mb-4">
                    <h6 class="fw-bold">2. إدخال رمز OTP</h6>
                    <p class="text-muted small">احصل على الرمز من بوابة فاتورة</p>
                    <form action="{{ route('settings.zatca.save-otp') }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control text-center" name="zatca_otp" 
                                placeholder="000000" maxlength="6" pattern="[0-9]{6}"
                                {{ empty($settings['zatca_csr']) ? 'disabled' : '' }}>
                            <button type="submit" class="btn btn-success" {{ empty($settings['zatca_csr']) ? 'disabled' : '' }}>
                                <i class="fas fa-save"></i>
                            </button>
                        </div>
                    </form>
                    @if(!empty($settings['zatca_otp']))
                        <small class="text-success d-block mt-2"><i class="fas fa-check"></i> تم حفظ OTP</small>
                    @endif
                </div>

                <!-- Step 3: Register -->
                <div class="mb-3">
                    <h6 class="fw-bold">3. التسجيل</h6>
                    <p class="text-muted small">إرسال طلب التسجيل لـ ZATCA</p>
                    <form action="{{ route('settings.zatca.register') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100"
                            {{ empty($settings['zatca_otp']) ? 'disabled' : '' }}>
                            <i class="fas fa-paper-plane me-1"></i> تسجيل في فاتورة
                        </button>
                    </form>
                    @if(!empty($settings['zatca_certificate']))
                        <small class="text-success d-block mt-2"><i class="fas fa-check"></i> تم التسجيل بنجاح</small>
                    @endif
                </div>
            </div>
        </div>

        <!-- Help & Resources -->
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-question-circle me-2"></i>مساعدة
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="https://zatca.gov.sa/ar/E-Invoicing/Pages/default.aspx" target="_blank" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-external-link-alt me-1"></i> موقع هيئة الزكاة
                    </a>
                    <a href="https://sandbox.zatca.gov.sa/" target="_blank" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-external-link-alt me-1"></i> بوابة فاتورة (Sandbox)
                    </a>
                    <a href="https://fatoora.zatca.gov.sa/" target="_blank" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-external-link-alt me-1"></i> بوابة فاتورة (Production)
                    </a>
                </div>
                
                <hr>
                
                <h6 class="fw-bold mb-2">خطوات التسجيل:</h6>
                <ol class="small text-muted mb-0">
                    <li>أكمل بيانات المنشأة واحفظها</li>
                    <li>اضغط على "إنشاء CSR"</li>
                    <li>سجّل دخول في بوابة فاتورة</li>
                    <li>أضف جهاز جديد وانسخ رمز OTP</li>
                    <li>أدخل رمز OTP واضغط حفظ</li>
                    <li>اضغط على "تسجيل في فاتورة"</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Connection Test Modal -->
<div class="modal fade" id="connectionTestModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">اختبار الاتصال بـ ZATCA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div id="testLoading">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">جاري الاختبار...</span>
                    </div>
                    <p>جاري اختبار الاتصال...</p>
                </div>
                <div id="testResult" style="display: none;">
                    <i id="testIcon" class="fas fa-5x mb-3"></i>
                    <h5 id="testMessage"></h5>
                    <p id="testDetails" class="text-muted"></p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function testConnection() {
    const modal = new bootstrap.Modal(document.getElementById('connectionTestModal'));
    modal.show();
    
    document.getElementById('testLoading').style.display = 'block';
    document.getElementById('testResult').style.display = 'none';
    
    fetch('{{ route("settings.zatca.test") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('testLoading').style.display = 'none';
        document.getElementById('testResult').style.display = 'block';
        
        const icon = document.getElementById('testIcon');
        const message = document.getElementById('testMessage');
        const details = document.getElementById('testDetails');
        
        if (data.success) {
            icon.className = 'fas fa-check-circle fa-5x mb-3 text-success';
            message.textContent = data.message;
            details.textContent = 'البيئة: ' + (data.environment || 'غير محدد');
        } else {
            icon.className = 'fas fa-times-circle fa-5x mb-3 text-danger';
            message.textContent = data.message;
            details.textContent = '';
        }
    })
    .catch(error => {
        document.getElementById('testLoading').style.display = 'none';
        document.getElementById('testResult').style.display = 'block';
        
        document.getElementById('testIcon').className = 'fas fa-exclamation-triangle fa-5x mb-3 text-warning';
        document.getElementById('testMessage').textContent = 'خطأ في الاتصال';
        document.getElementById('testDetails').textContent = error.message;
    });
}
</script>
@endsection

