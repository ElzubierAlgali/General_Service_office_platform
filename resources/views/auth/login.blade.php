<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <base href="../">
    
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f39c12">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="نظام إدارة الخدمات المتكامل - صِـدقا">
    
    <!-- Page Title -->
    <title>تسجيل الدخول | صِـدقا</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/apple-touch-icon.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Core Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flaticon/css/all/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/lucide/lucide.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/simplebar/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/node-waves/waves.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles-rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/enhanced-ui.css') }}">
    
    <style>
        :root {
            --login-gradient: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        }
        
        body {
            font-family: 'Tajawal', 'Cairo', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: var(--login-gradient);
            overflow-x: hidden;
        }
        
        .login-wrapper {
            min-height: 100vh;
            display: flex;
        }
        
        /* Left Side - Info Panel */
        .login-info-panel {
            flex: 1;
            display: none;
            background: var(--login-gradient);
            position: relative;
            overflow: hidden;
        }
        
        @media (min-width: 992px) {
            .login-info-panel {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }
        
        .login-info-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(243, 156, 18, 0.1) 0%, transparent 50%);
            animation: rotate-bg 30s linear infinite;
        }
        
        @keyframes rotate-bg {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .info-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 3rem;
            max-width: 500px;
        }
        
        .info-content h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        
        .info-content p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 2rem;
        }
        
        .features-list {
            text-align: right;
            padding: 0;
            margin: 0;
            list-style: none;
        }
        
        .features-list li {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: rgba(255, 255, 255, 0.9);
            padding: 0.75rem 0;
            font-size: 1rem;
        }
        
        .features-list li i {
            width: 32px;
            height: 32px;
            background: rgba(243, 156, 18, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f39c12;
        }
        
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            overflow: hidden;
        }
        
        .shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(243, 156, 18, 0.1) 0%, rgba(243, 156, 18, 0.05) 100%);
        }
        
        .shape-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            right: -100px;
            animation: float 8s ease-in-out infinite;
        }
        
        .shape-2 {
            width: 200px;
            height: 200px;
            bottom: 10%;
            right: 20%;
            animation: float 10s ease-in-out infinite reverse;
        }
        
        .shape-3 {
            width: 150px;
            height: 150px;
            top: 30%;
            left: 10%;
            animation: float 12s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(10px, -20px) rotate(5deg); }
            50% { transform: translate(-5px, 10px) rotate(-3deg); }
            75% { transform: translate(15px, 5px) rotate(3deg); }
        }
        
        /* Right Side - Login Form */
        .login-form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            position: relative;
        }
        
        @media (min-width: 992px) {
            .login-form-panel {
                max-width: 550px;
                border-radius: 40px 0 0 40px;
            }
        }
        
        .login-form-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }
        
        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-logo img {
            max-width: 180px;
            height: auto;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h2 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #1a1a2e;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        .login-form .form-group {
            margin-bottom: 1.5rem;
        }
        
        .login-form .form-label {
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .login-form .form-control {
            height: 52px;
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .login-form .form-control:focus {
            border-color: #f39c12;
            box-shadow: 0 0 0 4px rgba(243, 156, 18, 0.1);
        }
        
        .login-form .input-group-text {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-left: none;
            border-radius: 0 12px 12px 0;
            color: #6c757d;
        }
        
        .login-form .input-group .form-control {
            border-radius: 12px 0 0 12px;
            border-left: 2px solid #e9ecef;
        }
        
        .login-form .input-group:focus-within .input-group-text {
            border-color: #f39c12;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .remember-forgot a {
            color: #f39c12;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .remember-forgot a:hover {
            color: #e67e22;
        }
        
        .btn-login {
            width: 100%;
            height: 52px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(243, 156, 18, 0.4);
            color: white;
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .alert {
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border: none;
            padding: 1rem;
        }
        
        .alert-danger {
            background: rgba(255, 118, 117, 0.1);
            color: #d63031;
        }
        
        .invalid-feedback {
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }
        
        .is-invalid {
            border-color: #ff7675 !important;
        }
        
        .copyright {
            text-align: center;
            margin-top: 2rem;
            color: #adb5bd;
            font-size: 0.85rem;
        }
        
        .copyright a {
            color: #f39c12;
            text-decoration: none;
        }
        
        /* Preloader */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            z-index: 99999;
            display: none;
            align-items: center;
            justify-content: center;
            transition: opacity 0.4s ease, visibility 0.4s ease;
        }
        
        #preloader.active { display: flex; }
        #preloader.loaded { opacity: 0; visibility: hidden; }
        
        .preloader-inner { text-align: center; animation: fadeIn 0.5s ease; }
        
        .preloader-logo { 
            margin-bottom: 2rem; 
            animation: pulse 2s ease-in-out infinite; 
        }
        
        .preloader-logo img { 
            max-width: 180px; 
            height: auto;
            filter: drop-shadow(0 4px 20px rgba(243, 156, 18, 0.4));
        }
        
        .preloader-spinner { 
            display: flex; 
            justify-content: center; 
            margin-bottom: 1.5rem; 
        }
        
        .spinner-ring { 
            width: 50px; 
            height: 50px; 
            border: 4px solid rgba(255, 255, 255, 0.1); 
            border-top-color: #f39c12; 
            border-radius: 50%; 
            animation: spin 0.8s linear infinite; 
        }
        
        .preloader-text { 
            color: rgba(255, 255, 255, 0.8); 
            font-size: 0.9rem;
            font-weight: 500;
            letter-spacing: 1px;
        }
        
        @keyframes spin { 
            0% { transform: rotate(0deg); } 
            100% { transform: rotate(360deg); } 
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.03); }
        }
    </style>
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="preloader-inner">
            <div class="preloader-logo">
                <img src="{{ asset('assets/images/brand/logo.png') }}" alt="صِـدقا" onerror="this.src='{{ asset('assets/images/favicon.png') }}'">
            </div>
            <div class="preloader-spinner">
                <div class="spinner-ring"></div>
            </div>
            <div class="preloader-text">جاري التحميل...</div>
        </div>
    </div>
    
    <div class="login-wrapper">
        <!-- Info Panel -->
        <div class="login-info-panel">
            <div class="floating-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
            </div>
            <div class="info-content">
                <h1>مرحباً بعودتك!</h1>
                <p>نظام إدارة الخدمات المتكامل - منصة متكاملة لإدارة أعمالك بكفاءة عالية وسهولة تامة.</p>
                <ul class="features-list">
                    <li>
                        <i class="fas fa-shield-alt"></i>
                        <span>أمان عالي وحماية متقدمة للبيانات</span>
                    </li>
                    <li>
                        <i class="fas fa-chart-line"></i>
                        <span>تقارير مفصلة وتحليلات ذكية</span>
                    </li>
                    <li>
                        <i class="fas fa-users"></i>
                        <span>إدارة شاملة للعملاء والخدمات</span>
                    </li>
                    <li>
                        <i class="fas fa-mobile-alt"></i>
                        <span>واجهة سهلة الاستخدام ومتجاوبة</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Login Form Panel -->
        <div class="login-form-panel">
            <div class="login-form-container">
                <div class="login-logo">
                    <img src="{{ asset('assets/images/brand/logo.png') }}" alt="صِـدقا">
                </div>
                
                <div class="login-header">
                    <h2>تسجيل الدخول</h2>
                    <p>أدخل بياناتك للوصول إلى حسابك</p>
                </div>
                
                @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                
                @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label" for="email">البريد الإلكتروني</label>
                        <div class="input-group">
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" 
                                   placeholder="info@example.com"
                                   required 
                                   autofocus>
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                        </div>
                        @error('email')
                        <div class="invalid-feedback d-block">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="password">كلمة المرور</label>
                        <div class="input-group">
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="••••••••"
                                   required>
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>
                        @error('password')
                        <div class="invalid-feedback d-block">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <div class="remember-forgot">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="remember" 
                                   id="remember" 
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                تذكرني
                            </label>
                        </div>
                        @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            نسيت كلمة المرور؟
                        </a>
                        @endif
                    </div>
                    
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>تسجيل الدخول</span>
                    </button>
                </form>
                
                <div class="copyright">
                    <p>© {{ date('Y') }} <a href="#">شركة صِـدقا</a> - جميع الحقوق محفوظة</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('assets/libs/global/global.min.js') }}"></script>
    <script src="{{ asset('assets/js/appSettings.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setAppSettings({
                appColor: "orange"
            });
        });
        
        // Preloader handling
        document.addEventListener('submit', function(e) {
            var preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.classList.add('active');
                preloader.classList.remove('loaded');
            }
        });
        
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            if (preloader && preloader.classList.contains('active')) {
                setTimeout(function() { preloader.classList.add('loaded'); }, 200);
            }
        });
        
        window.addEventListener('pageshow', function(event) {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.classList.add('loaded');
                setTimeout(function() { preloader.classList.remove('active'); }, 300);
            }
        });
        
        // Fallback timeout
        setTimeout(function() {
            const preloader = document.getElementById('preloader');
            if (preloader && preloader.classList.contains('active') && !preloader.classList.contains('loaded')) {
                preloader.classList.add('loaded');
            }
        }, 8000);
    </script>
</body>

</html>
