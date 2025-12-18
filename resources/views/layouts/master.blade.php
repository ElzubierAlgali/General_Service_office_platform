<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <base href="../">
    
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f39c12">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">
    <meta name="description" content="نظام إدارة الخدمات المتكامل - صِـدقا">
    
    <!-- Page Title -->
    <title>@yield('title', 'لوحة التحكم') | صِـدقا</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/apple-touch-icon.png') }}">
    
    <!-- Google Fonts - Modern Arabic Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Core Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flaticon/css/all/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/lucide/lucide.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/simplebar/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/node-waves/waves.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap-select/css/bootstrap-select.min.css') }}">
    
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" rel="stylesheet">
    
    <!-- DataTables & Flatpickr -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables.min.css') }}">
    
    <!-- Main Theme Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles-rtl.css') }}">
    
    <!-- Enhanced Custom Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/enhanced-ui.css') }}">
    
    @yield('css')
    
    <style>
        /* ============================================
           SIDQA Enhanced Design System
           ============================================ */
        
        :root {
            /* Brand Colors - Warm Golden Theme */
            --sidqa-primary: #f39c12;
            --sidqa-primary-dark: #d68910;
            --sidqa-primary-light: #f7b731;
            --sidqa-primary-rgb: 243, 156, 18;
            
            /* Secondary Colors */
            --sidqa-secondary: #2c3e50;
            --sidqa-accent: #1abc9c;
            --sidqa-success: #27ae60;
            --sidqa-warning: #f1c40f;
            --sidqa-danger: #e74c3c;
            --sidqa-info: #3498db;
            
            /* Neutral Colors */
            --sidqa-dark: #1a1a2e;
            --sidqa-gray-900: #212529;
            --sidqa-gray-800: #343a40;
            --sidqa-gray-700: #495057;
            --sidqa-gray-600: #6c757d;
            --sidqa-gray-500: #adb5bd;
            --sidqa-gray-400: #ced4da;
            --sidqa-gray-300: #dee2e6;
            --sidqa-gray-200: #e9ecef;
            --sidqa-gray-100: #f8f9fa;
            --sidqa-white: #ffffff;
            
            /* Gradients */
            --sidqa-gradient-primary: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            --sidqa-gradient-secondary: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            --sidqa-gradient-success: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            --sidqa-gradient-info: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            --sidqa-gradient-warning: linear-gradient(135deg, #f1c40f 0%, #f39c12 100%);
            --sidqa-gradient-danger: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            --sidqa-gradient-dark: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            --sidqa-gradient-glass: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            
            /* Shadows */
            --sidqa-shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            --sidqa-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            --sidqa-shadow-md: 0 8px 25px rgba(0, 0, 0, 0.1);
            --sidqa-shadow-lg: 0 15px 35px rgba(0, 0, 0, 0.12);
            --sidqa-shadow-xl: 0 25px 50px rgba(0, 0, 0, 0.15);
            --sidqa-shadow-primary: 0 8px 25px rgba(243, 156, 18, 0.25);
            --sidqa-shadow-success: 0 8px 25px rgba(39, 174, 96, 0.25);
            --sidqa-shadow-danger: 0 8px 25px rgba(231, 76, 60, 0.25);
            
            /* Border Radius */
            --sidqa-radius-sm: 0.375rem;
            --sidqa-radius: 0.75rem;
            --sidqa-radius-lg: 1rem;
            --sidqa-radius-xl: 1.5rem;
            --sidqa-radius-full: 9999px;
            
            /* Typography */
            --sidqa-font-family: 'Tajawal', 'Cairo', sans-serif;
            --sidqa-font-size-xs: 0.75rem;
            --sidqa-font-size-sm: 0.875rem;
            --sidqa-font-size-base: 1rem;
            --sidqa-font-size-lg: 1.125rem;
            --sidqa-font-size-xl: 1.25rem;
            --sidqa-font-size-2xl: 1.5rem;
            --sidqa-font-size-3xl: 1.875rem;
            --sidqa-font-size-4xl: 2.25rem;
            
            /* Transitions */
            --sidqa-transition-fast: 0.15s ease;
            --sidqa-transition: 0.3s ease;
            --sidqa-transition-slow: 0.5s ease;
        }
        
        /* Base Typography */
        body {
            font-family: var(--sidqa-font-family);
            font-size: var(--sidqa-font-size-base);
            line-height: 1.7;
            color: var(--sidqa-gray-800);
            background: linear-gradient(135deg, #f5f7fa 0%, #f0f2f5 100%);
            min-height: 100vh;
        }
        
        /* Enhanced Cards */
        .card {
            border: none;
            border-radius: var(--sidqa-radius-lg);
            box-shadow: var(--sidqa-shadow);
            transition: all var(--sidqa-transition);
            overflow: hidden;
            background: var(--sidqa-white);
        }
        
        .card:hover {
            box-shadow: var(--sidqa-shadow-md);
            transform: translateY(-2px);
        }
        
        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--sidqa-gray-200);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-footer {
            background: var(--sidqa-gray-100);
            border-top: 1px solid var(--sidqa-gray-200);
            padding: 1rem 1.5rem;
        }
        
        /* Gradient Cards */
        .card-gradient-primary {
            background: var(--sidqa-gradient-primary);
            color: white;
        }
        
        .card-gradient-secondary {
            background: var(--sidqa-gradient-secondary);
            color: white;
        }
        
        .card-gradient-success {
            background: var(--sidqa-gradient-success);
            color: white;
        }
        
        .card-gradient-info {
            background: var(--sidqa-gradient-info);
            color: white;
        }
        
        .card-gradient-dark {
            background: var(--sidqa-gradient-dark);
            color: white;
        }
        
        /* Stats Cards */
        .stats-card {
            position: relative;
            overflow: hidden;
            border-radius: var(--sidqa-radius-lg);
            padding: 1.5rem;
            transition: all var(--sidqa-transition);
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
            transform: rotate(45deg);
            transition: all 0.5s ease;
        }
        
        .stats-card:hover::before {
            right: 150%;
        }
        
        .stats-card .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: var(--sidqa-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }
        
        .stats-card .stats-number {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1.2;
        }
        
        .stats-card .stats-label {
            font-size: 0.875rem;
            opacity: 0.9;
            margin-top: 0.25rem;
        }
        
        /* Enhanced Buttons */
        .btn {
            border-radius: var(--sidqa-radius);
            font-weight: 500;
            padding: 0.625rem 1.25rem;
            transition: all var(--sidqa-transition);
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn-primary {
            background: var(--sidqa-gradient-primary);
            box-shadow: var(--sidqa-shadow-primary);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(243, 156, 18, 0.35);
        }
        
        .btn-success {
            background: var(--sidqa-gradient-success);
            box-shadow: var(--sidqa-shadow-success);
        }
        
        .btn-danger {
            background: var(--sidqa-gradient-danger);
            box-shadow: var(--sidqa-shadow-danger);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--sidqa-primary);
            color: var(--sidqa-primary);
            background: transparent;
        }
        
        .btn-outline-primary:hover {
            background: var(--sidqa-primary);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Enhanced Form Controls */
        .form-control, .form-select {
            border-radius: var(--sidqa-radius);
            border: 2px solid var(--sidqa-gray-300);
            padding: 0.75rem 1rem;
            font-size: var(--sidqa-font-size-base);
            transition: all var(--sidqa-transition);
            background: var(--sidqa-white);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--sidqa-primary);
            box-shadow: 0 0 0 4px rgba(var(--sidqa-primary-rgb), 0.15);
            outline: none;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--sidqa-gray-700);
            margin-bottom: 0.5rem;
            font-size: var(--sidqa-font-size-sm);
        }
        
        /* Floating Labels */
        .form-floating > .form-control,
        .form-floating > .form-select {
            height: calc(3.5rem + 4px);
            padding: 1rem;
        }
        
        .form-floating > label {
            padding: 1rem;
            color: var(--sidqa-gray-600);
        }
        
        /* Enhanced Tables */
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background: var(--sidqa-gradient-dark);
            color: white;
            font-weight: 600;
            padding: 1rem 1.25rem;
            border: none;
            font-size: var(--sidqa-font-size-sm);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table thead th:first-child {
            border-radius: var(--sidqa-radius) 0 0 0;
        }
        
        .table thead th:last-child {
            border-radius: 0 var(--sidqa-radius) 0 0;
        }
        
        .table tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--sidqa-gray-200);
            transition: background var(--sidqa-transition-fast);
        }
        
        .table tbody tr:hover td {
            background: rgba(var(--sidqa-primary-rgb), 0.05);
        }
        
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        
        /* Enhanced Badges */
        .badge {
            padding: 0.5rem 0.875rem;
            border-radius: var(--sidqa-radius-full);
            font-weight: 500;
            font-size: var(--sidqa-font-size-xs);
            letter-spacing: 0.3px;
        }
        
        .badge-soft-primary {
            background: rgba(var(--sidqa-primary-rgb), 0.15);
            color: var(--sidqa-primary-dark);
        }
        
        .badge-soft-success {
            background: rgba(39, 174, 96, 0.15);
            color: #1e8449;
        }
        
        .badge-soft-danger {
            background: rgba(231, 76, 60, 0.15);
            color: #c0392b;
        }
        
        .badge-soft-warning {
            background: rgba(241, 196, 15, 0.15);
            color: #b7950b;
        }
        
        .badge-soft-info {
            background: rgba(52, 152, 219, 0.15);
            color: #2471a3;
        }
        
        /* Enhanced Alerts */
        .alert {
            border: none;
            border-radius: var(--sidqa-radius);
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .alert-success {
            background: linear-gradient(135deg, rgba(39, 174, 96, 0.1) 0%, rgba(46, 204, 113, 0.1) 100%);
            border-right: 4px solid var(--sidqa-success);
            color: #1e8449;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, rgba(231, 76, 60, 0.1) 0%, rgba(192, 57, 43, 0.1) 100%);
            border-right: 4px solid var(--sidqa-danger);
            color: #c0392b;
        }
        
        .alert-warning {
            background: linear-gradient(135deg, rgba(241, 196, 15, 0.1) 0%, rgba(243, 156, 18, 0.1) 100%);
            border-right: 4px solid var(--sidqa-warning);
            color: #9a7d0a;
        }
        
        .alert-info {
            background: linear-gradient(135deg, rgba(52, 152, 219, 0.1) 0%, rgba(41, 128, 185, 0.1) 100%);
            border-right: 4px solid var(--sidqa-info);
            color: #1a5276;
        }
        
        /* Page Header */
        .app-page-head {
            margin-bottom: 2rem;
            animation: fadeInDown 0.5s ease;
        }
        
        .app-page-title {
            font-size: var(--sidqa-font-size-2xl);
            font-weight: 800;
            color: var(--sidqa-dark);
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .app-page-title::before {
            content: '';
            width: 5px;
            height: 30px;
            background: var(--sidqa-gradient-primary);
            border-radius: var(--sidqa-radius-full);
        }
        
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            content: "\f053";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            font-size: 0.625rem;
            color: var(--sidqa-gray-500);
        }
        
        .breadcrumb-item a {
            color: var(--sidqa-primary);
            text-decoration: none;
            transition: color var(--sidqa-transition-fast);
        }
        
        .breadcrumb-item a:hover {
            color: var(--sidqa-primary-dark);
        }
        
        .breadcrumb-item.active {
            color: var(--sidqa-gray-600);
        }
        
        /* Action Buttons Group */
        .action-btns {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
        
        .action-btns .btn {
            padding: 0.5rem 0.75rem;
            font-size: var(--sidqa-font-size-sm);
        }
        
        .action-btns .btn-icon {
            width: 36px;
            height: 36px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--sidqa-radius);
        }
        
        /* Avatar Styles */
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: var(--sidqa-radius-full);
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: var(--sidqa-font-size-sm);
        }
        
        .avatar-sm { width: 32px; height: 32px; font-size: 0.75rem; }
        .avatar-md { width: 48px; height: 48px; font-size: 1rem; }
        .avatar-lg { width: 64px; height: 64px; font-size: 1.25rem; }
        .avatar-xl { width: 80px; height: 80px; font-size: 1.5rem; }
        .avatar-xxl { width: 100px; height: 100px; font-size: 2rem; }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--sidqa-gray-600);
        }
        
        .empty-state-icon {
            font-size: 4rem;
            color: var(--sidqa-gray-400);
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        .empty-state-title {
            font-size: var(--sidqa-font-size-xl);
            font-weight: 700;
            color: var(--sidqa-gray-700);
            margin-bottom: 0.5rem;
        }
        
        .empty-state-text {
            color: var(--sidqa-gray-600);
            max-width: 400px;
            margin: 0 auto;
        }
        
        /* Search Box */
        .search-box {
            position: relative;
        }
        
        .search-box .form-control {
            padding-right: 3rem;
        }
        
        .search-box .search-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--sidqa-gray-500);
        }
        
        /* Filter Card */
        .filter-card {
            background: linear-gradient(135deg, rgba(var(--sidqa-primary-rgb), 0.05) 0%, rgba(var(--sidqa-primary-rgb), 0.02) 100%);
            border: 1px solid rgba(var(--sidqa-primary-rgb), 0.1);
        }
        
        /* Modal Enhancements */
        .modal-content {
            border: none;
            border-radius: var(--sidqa-radius-lg);
            box-shadow: var(--sidqa-shadow-xl);
        }
        
        .modal-header {
            background: var(--sidqa-gradient-dark);
            color: white;
            border-radius: var(--sidqa-radius-lg) var(--sidqa-radius-lg) 0 0;
            padding: 1.25rem 1.5rem;
        }
        
        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }
        
        .modal-body {
            padding: 1.5rem;
        }
        
        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--sidqa-gray-200);
        }
        
        /* Dropdown Enhancements */
        .dropdown-menu {
            border: none;
            border-radius: var(--sidqa-radius);
            box-shadow: var(--sidqa-shadow-lg);
            padding: 0.5rem;
        }
        
        .dropdown-item {
            border-radius: var(--sidqa-radius-sm);
            padding: 0.625rem 1rem;
            font-size: var(--sidqa-font-size-sm);
            transition: all var(--sidqa-transition-fast);
        }
        
        .dropdown-item:hover {
            background: rgba(var(--sidqa-primary-rgb), 0.1);
            color: var(--sidqa-primary);
        }
        
        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--sidqa-gray-200);
            border-radius: var(--sidqa-radius-full);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--sidqa-gray-400);
            border-radius: var(--sidqa-radius-full);
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--sidqa-gray-500);
        }
        
        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        /* Utility Classes */
        .animate-fadeInUp { animation: fadeInUp 0.5s ease; }
        .animate-fadeInDown { animation: fadeInDown 0.5s ease; }
        .animate-fadeIn { animation: fadeIn 0.5s ease; }
        .animate-slideInRight { animation: slideInRight 0.5s ease; }
        
        .hover-lift { transition: transform var(--sidqa-transition); }
        .hover-lift:hover { transform: translateY(-4px); }
        
        .hover-scale { transition: transform var(--sidqa-transition); }
        .hover-scale:hover { transform: scale(1.02); }
        
        .text-gradient-primary {
            background: var(--sidqa-gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .bg-glass {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .app-page-title {
                font-size: var(--sidqa-font-size-xl);
            }
            
            .stats-card .stats-number {
                font-size: 1.5rem;
            }
            
            .card-body {
                padding: 1rem;
            }
        }
        
        /* Preloader Styles */
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
            border-top-color: var(--sidqa-primary); 
            border-radius: 50%; 
            animation: spin 0.8s linear infinite; 
        }
        
        .preloader-text { 
            color: rgba(255, 255, 255, 0.8); 
            font-family: var(--sidqa-font-family); 
            font-size: var(--sidqa-font-size-sm);
            font-weight: 500;
            letter-spacing: 1px;
        }
        
        @keyframes spin { 
            0% { transform: rotate(0deg); } 
            100% { transform: rotate(360deg); } 
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
    
    <script>
        // Show preloader on navigation
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
        
        document.addEventListener('submit', function(e) {
            var preloader = document.getElementById('preloader');
            if (preloader && !e.target.classList.contains('no-preloader')) {
                preloader.classList.add('active');
                preloader.classList.remove('loaded');
            }
        });
    </script>
    
    <div class="page-layout">
        
        <!-- Header -->
        @include('layouts.header')
        
        <!-- Main Sidebar -->
        @include('layouts.main-sidebar')
        
        <!-- Right Sidebar -->
        @include('layouts.sidebar')
        
        <!-- Main Content -->
        <main class="app-wrapper">
            <div class="container">
                <!-- Flash Messages -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show animate-fadeInDown" role="alert">
                    <i class="fas fa-check-circle fa-lg"></i>
                    <div>
                        <strong>تمت العملية بنجاح!</strong>
                        <span class="d-block">{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                
                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show animate-fadeInDown" role="alert">
                    <i class="fas fa-exclamation-circle fa-lg"></i>
                    <div>
                        <strong>حدث خطأ!</strong>
                        <span class="d-block">{{ session('error') }}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                
                @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show animate-fadeInDown" role="alert">
                    <i class="fas fa-exclamation-triangle fa-lg"></i>
                    <div>
                        <strong>تنبيه!</strong>
                        <span class="d-block">{{ session('warning') }}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                
                @yield('content')
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="footer-wrapper bg-body">
            <div class="container">
                <div class="row g-2 align-items-center">
                    <div class="col-lg-6 col-md-7 text-center text-md-start">
                        <p class="mb-0 text-muted">
                            <i class="fas fa-code text-primary me-2"></i>
                            © <span class="currentYear">{{ date('Y') }}</span> 
                            <strong class="text-primary">شركة صِـدقا</strong> - 
                            <a href="javascript:void(0);" class="text-decoration-none">قسم تقنية المعلومات</a>
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <ul class="d-flex list-inline mb-0 gap-3 flex-wrap justify-content-center justify-content-md-end">
                            <li>
                                <a class="text-muted small" href="#">
                                    <i class="fas fa-headset me-1"></i>
                                    الدعم الفني 106
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    @include('sweetalert::alert')
    
    <!-- Core Scripts -->
    <script src="{{ asset('assets/libs/global/global.min.js') }}"></script>
    <script src="{{ asset('assets/libs/sortable/Sortable.min.js') }}"></script>
    <script src="{{ asset('assets/libs/chartjs/chart.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <script src="{{ asset('assets/js/appSettings.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        // Initialize Select2
        $(document).ready(function() {
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
            
            // Re-initialize Select2 when modals are shown
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
        
        // App Settings
        document.addEventListener("DOMContentLoaded", function() {
            setAppSettings({
                appColor: "orange"
            });
        });
    </script>
    
    @yield('scripts')
    
    <!-- Preloader Hide Script -->
    <script>
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            if (preloader && preloader.classList.contains('active')) {
                setTimeout(function() { preloader.classList.add('loaded'); }, 200);
            }
        });
        
        window.addEventListener('beforeunload', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) { 
                preloader.classList.add('active'); 
                preloader.classList.remove('loaded'); 
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
