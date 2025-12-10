<!DOCTYPE html>
<html lang="ar" dir ="rtl">

<head>

  <base href="../">

  <!-- begin::GXON Meta Basic -->
  <meta charset="utf-8">
  <meta name="theme-color" content="#316AFF">
  <meta name="robots" content="index, follow">
  <meta name="author" content="LayoutDrop">
  <meta name="format-detection" content="telephone=no">
  <meta name="keywords" content="Private transportation services with high standards of safety and comfort, including airport pick-up and drop-off, and transportation within the city with professionalism and care.">
  <meta name="description" content="Private transportation services with high standards of safety and comfort, including airport pick-up and drop-off, and transportation within the city with professionalism and care.">
  <!-- end::GXON Meta Basic -->

  <!-- begin::GXON Meta Social -->
  <meta property="og:url" content="https://gxon.layoutdrop.com/demo/">
  <meta property="og:site_name" content="Login | GXON HR Management Admin Dashboard Template + RTL">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="ar_SA">
  <meta property="og:title" content="Login | SIDQA Private Transportation Company">
  <meta property="og:description" content="GXON is a professional and modern HR Management Admin Dashboard Template built with Bootstrap. It includes light and dark modes, and is ideal for managing employees, attendance, payroll, recruitment, and more — perfect for HR software and admin panels.">
  <meta property="og:image" content="https://sidqa.sa/">
  <!-- end::GXON Meta Social -->

  <!-- begin::GXON Meta Twitter -->
  <meta name="twitter:card" content="summary">
  <meta name="twitter:url" content="https://sidqa.sa/">
  <meta name="twitter:creator" content="@layoutdrop">
  <meta name="twitter:title" content="Login | SIDQA Co.">
  <meta name="twitter:description" content="Private transportation services with high standards of safety and comfort, including airport pick-up and drop-off, and transportation within the city with professionalism and care.">
  <!-- end::GXON Meta Twitter -->

  <!-- begin::GXON Website Page Title -->
  <title>Login | SIDQA Co.</title>
  <!-- end::GXON Website Page Title -->

  <!-- begin::GXON Mobile Specific -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- end::GXON Mobile Specific -->

  <!-- begin::GXON Favicon Tags -->
  <link rel="icon" type="image/png" href="assets/images/favicon.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
  <!-- end::GXON Favicon Tags -->

  <!-- begin::GXON Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap" rel="stylesheet">
  <!-- end::GXON Google Fonts -->

  <!-- begin::GXON Required Stylesheet -->
  <link rel="stylesheet" href="assets/libs/flaticon/css/all/all.css">
  <link rel="stylesheet" href="assets/libs/lucide/lucide.css">
  <link rel="stylesheet" href="assets/libs/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="assets/libs/simplebar/simplebar.css">
  <link rel="stylesheet" href="assets/libs/node-waves/waves.css">
  <link rel="stylesheet" href="assets/libs/bootstrap-select/css/bootstrap-select.min.css">
  <!-- end::GXON Required Stylesheet -->

  <!-- begin::GXON CSS Stylesheet -->
  <link rel="stylesheet" href="assets/css/styles-rtl.css">
  <!-- end::GXON CSS Stylesheet -->



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

  <style>
    #preloader {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: #ffffff;
      z-index: 99999;
      display: none;
      align-items: center;
      justify-content: center;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    #preloader.active { display: flex; }
    #preloader.loaded { opacity: 0; visibility: hidden; }
    .preloader-inner { text-align: center; animation: fadeInUp 0.5s ease; }
    .preloader-logo { margin-bottom: 25px; animation: pulse 2s ease-in-out infinite; }
    .preloader-logo img { max-width: 160px; height: auto; }
    .preloader-spinner { display: flex; justify-content: center; margin-bottom: 15px; }
    .spinner-ring { width: 45px; height: 45px; border: 3px solid #f0f0f0; border-top-color: #f39c12; border-radius: 50%; animation: spin 0.8s linear infinite; }
    .preloader-text { color: #666; font-family: 'Noto Kufi Arabic', sans-serif; font-size: 13px; animation: blink 1.5s ease-in-out infinite; }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.03); } }
    @keyframes fadeInUp { 0% { opacity: 0; transform: translateY(20px); } 100% { opacity: 1; transform: translateY(0); } }
    @keyframes blink { 0%, 100% { opacity: 0.6; } 50% { opacity: 1; } }
  </style>

  <script>
    document.addEventListener('click', function(e) {
      var target = e.target.closest('a');
      if (target && target.href && !target.href.startsWith('javascript:') && !target.href.startsWith('#') && !target.hasAttribute('target') && !e.ctrlKey && !e.metaKey) {
        var preloader = document.getElementById('preloader');
        if (preloader) { preloader.classList.add('active'); preloader.classList.remove('loaded'); }
      }
    });
    document.addEventListener('submit', function(e) {
      var preloader = document.getElementById('preloader');
      if (preloader) { preloader.classList.add('active'); preloader.classList.remove('loaded'); }
    });
  </script>

  <div class="page-layout">

    <div class="auth-cover-wrapper">
      <div class="row g-0">
        <div class="col-lg-6">
          <div class="auth-cover" style="background-image: url(assets/images/auth/auth-cover-bg.png);">
            <div class="clearfix">
              <img src="assets/images/auth/auth.png" alt="" class="img-fluid cover-img ms-5">
              <div class="auth-content">
                <h1 class="display-6 fw-bold">مرحباً بعودتك!</h1>
                <p>خدمات نقل خاصة بمعايير عالية من الأمان والراحة، تشمل الاستقبال والتوصيل من وإلى المطار، والتنقلات داخل المدينة بكل احترافية واهتمام.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 align-self-center">
          <div class="p-3 p-sm-5 maxw-450px m-auto">
            <div class="mb-4 text-center">
              <a href="index.html" aria-label="GXON logo">
                <img width="250" class="visible-light" src="assets/images/brand/logo.png" alt="GXON logo">
                <img class="visible-dark" src="assets/images/brand/logo.png" alt="GXON logo">
              </a>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
              <div class="mb-4">
                <label class="form-label" for="loginEmail">البريد الالكتروني</label>
                <input name ="email" type="email" class="form-control" id="loginEmail" placeholder="info@example.com">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="mb-4">
                <label class="form-label" for="loginPassword">كلمة المرور</label>
                <input name ="password" type="password" class="form-control" id="loginPassword" placeholder="********">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="mb-4">
                <div class="d-flex justify-content-between">
                  <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label" for="rememberMe"> تذكرني </label>
                  </div>
                  <a href="authentication/forgot-password-cover.html">إستعادة كلمة المرور؟</a>
                </div>
              </div>
              <div class="mb-3">
                <button type="submit" value="Submit" class="btn btn-primary waves-effect waves-light w-100">تسجيل دخول</button>
              </div>


              <div class="d-flex gap-2 justify-content-center mt-5">
                <a href="javascript:void(0);" class="btn btn-icon btn-subtle-facebook rounded-circle waves-effect waves-light">
                  <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="javascript:void(0);" class="btn btn-icon btn-subtle-twitter rounded-circle waves-effect waves-light">
                  <i class="fa-brands fa-x-twitter"></i>
                </a>
                <a href="javascript:void(0);" class="btn btn-icon btn-subtle-github rounded-circle waves-effect waves-light">
                  <i class="fa-brands fa-github"></i>
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- begin::GXON Page Scripts -->
  <script src="assets/libs/global/global.min.js"></script>
  <script src="assets/js/appSettings.js"></script>
  <script src="assets/js/main.js"></script>
  <!-- end::GXON Page Scripts -->

    <script>
	document.addEventListener("DOMContentLoaded", function () {
		setAppSettings({
			appColor: "orange"
		});
	});
    </script>

    <!-- Preloader Script -->
    <script>
      window.addEventListener('load', function() {
        const preloader = document.getElementById('preloader');
        if (preloader && preloader.classList.contains('active')) {
          setTimeout(function() { preloader.classList.add('loaded'); }, 200);
        }
      });
      window.addEventListener('beforeunload', function() {
        const preloader = document.getElementById('preloader');
        if (preloader) { preloader.classList.add('active'); preloader.classList.remove('loaded'); }
      });
      window.addEventListener('pageshow', function(event) {
        const preloader = document.getElementById('preloader');
        if (preloader) { preloader.classList.add('loaded'); setTimeout(function() { preloader.classList.remove('active'); }, 300); }
      });
      setTimeout(function() {
        const preloader = document.getElementById('preloader');
        if (preloader && preloader.classList.contains('active') && !preloader.classList.contains('loaded')) { preloader.classList.add('loaded'); }
      }, 8000);
    </script>
</body>

</html>
