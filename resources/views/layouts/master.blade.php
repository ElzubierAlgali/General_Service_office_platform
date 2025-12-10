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
  <title>@yield('title')</title>
  <!-- end::GXON Website Page Title -->

  <!-- begin::GXON Mobile Specific -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- end::GXON Mobile Specific -->

  <!-- begin::GXON Favicon Tags -->
  <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/apple-touch-icon.png') }}">
  <!-- end::GXON Favicon Tags -->

  <!-- begin::GXON Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap" rel="stylesheet">
  <!-- end::GXON Google Fonts -->

  <!-- begin::GXON Required Stylesheet -->
  <link rel="stylesheet" href="{{asset('assets/libs/flaticon/css/all/all.css')}}">
  <link rel="stylesheet" href="{{asset('assets/libs/lucide/lucide.css')}}">
  <link rel="stylesheet" href="{{asset('assets/libs/fontawesome/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/libs/simplebar/simplebar.css')}}">
  <link rel="stylesheet" href="{{asset('assets/libs/node-waves/waves.css')}}">
  <link rel="stylesheet" href="{{asset('assets/libs/bootstrap-select/css/bootstrap-select.min.css')}}">
  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" rel="stylesheet" />
  <!-- end::GXON Required Stylesheet -->

  <!-- begin::GXON CSS Stylesheet -->
  <link rel="stylesheet" href="{{asset('assets/libs/flatpickr/flatpickr.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/libs/datatables/datatables.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/styles-rtl.css')}}">
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
    /* Preloader Styles */
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

    #preloader.active {
      display: flex;
    }

    #preloader.loaded {
      opacity: 0;
      visibility: hidden;
    }

    .preloader-inner {
      text-align: center;
      animation: fadeInUp 0.5s ease;
    }

    .preloader-logo {
      margin-bottom: 25px;
      animation: pulse 2s ease-in-out infinite;
    }

    .preloader-logo img {
      max-width: 160px;
      height: auto;
    }

    .preloader-spinner {
      display: flex;
      justify-content: center;
      margin-bottom: 15px;
    }

    .spinner-ring {
      width: 45px;
      height: 45px;
      border: 3px solid #f0f0f0;
      border-top-color: #f39c12;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
    }

    .preloader-text {
      color: #666;
      font-family: 'Noto Kufi Arabic', sans-serif;
      font-size: 13px;
      animation: blink 1.5s ease-in-out infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.03); }
    }

    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes blink {
      0%, 100% { opacity: 0.6; }
      50% { opacity: 1; }
    }
  </style>

  <script>
    // Show preloader immediately when clicking links
    document.addEventListener('click', function(e) {
      var target = e.target.closest('a');
      if (target && target.href && !target.href.startsWith('javascript:') && 
          !target.href.startsWith('#') && !target.hasAttribute('target') &&
          !target.classList.contains('no-preloader') && 
          !e.ctrlKey && !e.metaKey && !e.shiftKey) {
        var preloader = document.getElementById('preloader');
        if (preloader) {
          preloader.classList.add('active');
          preloader.classList.remove('loaded');
        }
      }
    });

    // Also show on form submit
    document.addEventListener('submit', function(e) {
      var preloader = document.getElementById('preloader');
      if (preloader && !e.target.classList.contains('no-preloader')) {
        preloader.classList.add('active');
        preloader.classList.remove('loaded');
      }
    });
  </script>

  <div class="page-layout">

    <!-- begin::GXON Page Header -->
    @include('layouts.header')
    <!-- end::GXON Page Header -->


    <!-- begin::GXON Sidebar Menu -->
    @include('layouts.main-sidebar')
    <!-- end::GXON Sidebar Menu -->

    <!-- begin::GXON Sidebar right -->
    @include('layouts.sidebar')
    <!-- end::GXON Sidebar right -->

    <main class="app-wrapper">

      <div class="container">

        @yield('content')

      </div>

    </main>

    <!-- begin::GXON Footer -->
    <footer class="footer-wrapper bg-body">
      <div class="container">
        <div class="row g-2">
          <div class="col-lg-6 col-md-7 text-center text-md-start">
            <p class="mb-0">© <span class="currentYear">{{ date('yyyy') }}</span> شركة صِـدقا<a href="javascript:void(0);"> قسم تقنية المعلومات</a>.</p>
          </div>
          <div class="col-lg-6 col-md-5">
            <ul class="d-flex list-inline mb-0 gap-3 flex-wrap justify-content-center justify-content-md-end">
              <li>
                <a class="text-body" href="#">الدعم الفني 106</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
    <!-- end::GXON Footer -->

  </div>
@include('sweetalert::alert')
  <!-- begin::GXON Page Scripts -->
  <script src="{{asset('assets/libs/global/global.min.js')}}"></script>
  <script src="{{asset('assets/libs/sortable/Sortable.min.js')}}"></script>
  <script src="{{asset('assets/libs/chartjs/chart.js')}}"></script>
  <script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
  <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('assets/libs/datatables/datatables.min.js')}}"></script>
  <script src="{{asset('assets/js/dashboard.js')}}"></script>
  <script src="{{asset('assets/js/todolist.js')}}"></script>
  <script src="{{asset('assets/js/appSettings.js')}}"></script>
  <script src="{{asset('assets/js/main.js')}}"></script>
  <!-- Select2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    // Initialize Select2 for all searchable selects
    $(document).ready(function() {
        // Initialize Select2 on page load
        $('.select2').select2({
            theme: 'bootstrap-5',
            dir: 'rtl',
            language: {
                noResults: function() { return "لا توجد نتائج"; },
                searching: function() { return "جاري البحث..."; },
                inputTooShort: function() { return "أدخل حرفاً واحداً على الأقل"; }
            },
            allowClear: true,
            placeholder: function() {
                return $(this).data('placeholder') || '-- اختر --';
            }
        });

        // Re-initialize Select2 when modals are shown (for selects inside modals)
        $(document).on('shown.bs.modal', function(e) {
            $(e.target).find('.select2').each(function() {
                $(this).select2({
                    theme: 'bootstrap-5',
                    dir: 'rtl',
                    dropdownParent: $(e.target),
                    language: {
                        noResults: function() { return "لا توجد نتائج"; },
                        searching: function() { return "جاري البحث..."; },
                        inputTooShort: function() { return "أدخل حرفاً واحداً على الأقل"; }
                    },
                    allowClear: true,
                    placeholder: function() {
                        return $(this).data('placeholder') || '-- اختر --';
                    }
                });
            });
        });
    });
  </script>
  <!-- end::GXON Page Scripts -->
    <script>
	document.addEventListener("DOMContentLoaded", function () {
		setAppSettings({
			appColor: "orange"
		});
	});
    </script>
    @yield('scripts')

    <!-- Preloader Script -->
    <script>
      // Hide preloader on page load
      window.addEventListener('load', function() {
        const preloader = document.getElementById('preloader');
        if (preloader && preloader.classList.contains('active')) {
          setTimeout(function() {
            preloader.classList.add('loaded');
          }, 200);
        }
      });

      // Show preloader when navigating away
      window.addEventListener('beforeunload', function() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
          preloader.classList.add('active');
          preloader.classList.remove('loaded');
        }
      });

      // Handle browser back/forward
      window.addEventListener('pageshow', function(event) {
        const preloader = document.getElementById('preloader');
        if (preloader) {
          preloader.classList.add('loaded');
          setTimeout(function() {
            preloader.classList.remove('active');
          }, 300);
        }
      });

      // Fallback: Hide preloader after 8 seconds max
      setTimeout(function() {
        const preloader = document.getElementById('preloader');
        if (preloader && preloader.classList.contains('active') && !preloader.classList.contains('loaded')) {
          preloader.classList.add('loaded');
        }
      }, 8000);
    </script>
</body>

</html>
