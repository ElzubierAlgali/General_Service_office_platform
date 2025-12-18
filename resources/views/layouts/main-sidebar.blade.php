<aside class="app-menubar" id="appMenubar">
    {{-- Sidebar Header / Brand --}}
    <div class="app-navbar-brand">
        <a class="navbar-brand-logo d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
            <img class="visible-light" src="{{ asset('assets/images/brand/logo.png') }}" alt="صِـدقا" style="max-width: 160px; height: auto;">
            <img class="visible-dark" src="{{ asset('assets/images/brand/logo.png') }}" alt="صِـدقا" style="max-width: 160px; height: auto;">
        </a>
    </div>
    
    {{-- User Profile Mini Card --}}
    <div class="sidebar-user-card px-3 py-3 mb-2">
        <div class="d-flex align-items-center gap-3">
            <div class="sidebar-user-avatar">
                @if(auth()->user()->photo)
                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="{{ auth()->user()->name }}" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover;">
                @else
                    <div class="avatar-initials rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 45px; height: 45px; background: linear-gradient(135deg, var(--sidqa-primary) 0%, var(--sidqa-primary-dark) 100%); color: white; font-weight: 700; font-size: 0.9rem;">
                        {{ mb_substr(auth()->user()->name, 0, 2) }}
                    </div>
                @endif
            </div>
            <div class="sidebar-user-info flex-grow-1 overflow-hidden">
                <h6 class="mb-0 text-truncate fw-bold" style="font-size: 0.9rem;">{{ auth()->user()->name }}</h6>
                <small class="text-muted d-block text-truncate" style="font-size: 0.75rem;">
                    {{ auth()->user()->roles->first()->display_name ?? 'مستخدم' }}
                </small>
            </div>
        </div>
    </div>
    
    {{-- Navigation Menu --}}
    <nav class="app-navbar" data-simplebar>
        <ul class="menubar">
            
            {{-- Menu Section: الرئيسية --}}
            <li class="menu-section">
                <span class="menu-section-title">الرئيسية</span>
            </li>
            
            {{-- Driver Portal Link (for drivers only) --}}
            @if(auth()->user()->hasRole('Driver'))
            <li class="menu-item">
                <a class="menu-link {{ request()->routeIs('driver-portal.*') ? 'active' : '' }}" href="{{ route('driver-portal.index') }}">
                    <span class="menu-icon">
                        <i class="fas fa-id-badge"></i>
                    </span>
                    <span class="menu-label">بوابة السائق</span>
                    <span class="menu-badge badge-primary">جديد</span>
                </a>
            </li>
            @endif

            {{-- Dashboard --}}
            <li class="menu-item">
                <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <span class="menu-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </span>
                    <span class="menu-label">لوحة التحكم</span>
                </a>
            </li>
            
            <li class="menu-item">
                <a class="menu-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                    <span class="menu-icon">
                        <i class="fas fa-home"></i>
                    </span>
                    <span class="menu-label">الرئيسية</span>
                </a>
            </li>

            {{-- Menu Section: إدارة الأعمال --}}
            @permission('View Customers|View Services')
            <li class="menu-section">
                <span class="menu-section-title">إدارة الأعمال</span>
            </li>
            
            {{-- Customers --}}
            @permission('View Customers')
            <li class="menu-item menu-arrow {{ request()->routeIs('customers.*') ? 'open' : '' }}">
                <a class="menu-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="javascript:void(0);" role="button">
                    <span class="menu-icon">
                        <i class="fas fa-users"></i>
                    </span>
                    <span class="menu-label">العملاء</span>
                </a>
                <ul class="menu-inner">
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('customers.index') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">قائمة العملاء</span>
                        </a>
                    </li>
                    @permission('Create Customers')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('customers.create') ? 'active' : '' }}" href="{{ route('customers.create') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">إضافة عميل</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission
            
            {{-- Services --}}
            @permission('View Services')
            <li class="menu-item menu-arrow {{ request()->routeIs('services.*') ? 'open' : '' }}">
                <a class="menu-link {{ request()->routeIs('services.*') ? 'active' : '' }}" href="javascript:void(0);" role="button">
                    <span class="menu-icon">
                        <i class="fas fa-concierge-bell"></i>
                    </span>
                    <span class="menu-label">الخدمات</span>
                </a>
                <ul class="menu-inner">
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('services.index') ? 'active' : '' }}" href="{{ route('services.index') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">قائمة الخدمات</span>
                        </a>
                    </li>
                    @permission('Create Services')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('services.create') ? 'active' : '' }}" href="{{ route('services.create') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">إضافة خدمة</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission
            @endpermission

            {{-- Menu Section: الإدارة المالية --}}
            @permission('Manage Financial Settings|Financial Oprations|View Financial Reports')
            <li class="menu-section">
                <span class="menu-section-title">الإدارة المالية</span>
            </li>
            
            {{-- Financial Settings --}}
            @permission('Manage Financial Settings')
            <li class="menu-item menu-arrow {{ request()->routeIs('expense_catigories.*') || request()->routeIs('taxes.*') || request()->routeIs('accounts.*') || request()->routeIs('payment_methods.*') ? 'open' : '' }}">
                <a class="menu-link" href="javascript:void(0);" role="button">
                    <span class="menu-icon">
                        <i class="fas fa-cog"></i>
                    </span>
                    <span class="menu-label">الإعدادات المالية</span>
                </a>
                <ul class="menu-inner">
                    @permission('View Expense Catigorties')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('expense_catigories.*') ? 'active' : '' }}" href="{{ route('expense_catigories.index') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">بنود الصرف</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('Manage Tax')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('taxes.*') ? 'active' : '' }}" href="{{ route('taxes.index') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">الضرائب</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('Manage Financial Accounts')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('accounts.index') ? 'active' : '' }}" href="{{ route('accounts.index') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">الحسابات</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('Manage Payment Methods')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('payment_methods.*') ? 'active' : '' }}" href="{{ route('payment_methods.index') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">طرق الدفع</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission

            {{-- Financial Operations --}}
            @permission('Financial Oprations')
            <li class="menu-item menu-arrow {{ request()->routeIs('expenses.*') || request()->routeIs('accounts.charge') || request()->routeIs('accounts.transfer') || request()->routeIs('transactions.*') ? 'open' : '' }}">
                <a class="menu-link" href="javascript:void(0);" role="button">
                    <span class="menu-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </span>
                    <span class="menu-label">العمليات المالية</span>
                </a>
                <ul class="menu-inner">
                    @permission('View Expense')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}" href="{{ route('expenses.index') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">المصروفات</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('Charging accounts')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('accounts.charge') ? 'active' : '' }}" href="{{ route('accounts.charge') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">إيداع مالي</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('Transfer Between Accounts')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('accounts.transfer') ? 'active' : '' }}" href="{{ route('accounts.transfer') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">التحويل بين الحسابات</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('View Transactions')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">مراقب المعاملات</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission

            {{-- Financial Reports --}}
            @permission('View Financial Reports')
            <li class="menu-item menu-arrow {{ request()->routeIs('reports.*') ? 'open' : '' }}">
                <a class="menu-link" href="javascript:void(0);" role="button">
                    <span class="menu-icon">
                        <i class="fas fa-chart-pie"></i>
                    </span>
                    <span class="menu-label">التقارير</span>
                </a>
                <ul class="menu-inner">
                    @permission('View Financial Summary')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('reports.summary') ? 'active' : '' }}" href="{{ route('reports.summary') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">الملخص المالي</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('View Expense Report')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('reports.expenses') ? 'active' : '' }}" href="{{ route('reports.expenses') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">تقرير المصروفات</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('View Income Report')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('reports.income') ? 'active' : '' }}" href="{{ route('reports.income') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">تقرير الإيرادات</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('View Account Statement')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('reports.account_statement') ? 'active' : '' }}" href="{{ route('reports.account_statement') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">كشف حساب</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('View Income Statement')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('reports.income_statement') ? 'active' : '' }}" href="{{ route('reports.income_statement') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">قائمة الدخل</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('View Balance Sheet')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('reports.balance_sheet') ? 'active' : '' }}" href="{{ route('reports.balance_sheet') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">الميزانية العمومية</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('View Driver Trips Report')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('reports.driver_trips') ? 'active' : '' }}" href="{{ route('reports.driver_trips') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">تقرير الرحلات</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission
            @endpermission

            {{-- Menu Section: إدارة العمليات --}}
            @permission('Manage Operations')
            <li class="menu-section">
                <span class="menu-section-title">إدارة العمليات</span>
            </li>
            
            <li class="menu-item menu-arrow {{ request()->routeIs('vehicles.*') || request()->routeIs('drivers.*') || request()->routeIs('maintenances.*') || request()->routeIs('trips.*') ? 'open' : '' }}">
                <a class="menu-link" href="javascript:void(0);" role="button">
                    <span class="menu-icon">
                        <i class="fas fa-truck"></i>
                    </span>
                    <span class="menu-label">الأسطول</span>
                </a>
                <ul class="menu-inner">
                    @permission('View Vehicle')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}" href="{{ route('vehicles.index') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">المركبات</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('View Driver')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('drivers.*') ? 'active' : '' }}" href="{{ route('drivers.index') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">السائقين</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('View Maintenance')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('maintenances.*') ? 'active' : '' }}" href="{{ route('maintenances.index') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">الصيانة</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            
            @permission('View Trips|View Trip Monitor')
            <li class="menu-item menu-arrow {{ request()->routeIs('trips.*') ? 'open' : '' }}">
                <a class="menu-link" href="javascript:void(0);" role="button">
                    <span class="menu-icon">
                        <i class="fas fa-route"></i>
                    </span>
                    <span class="menu-label">الرحلات</span>
                </a>
                <ul class="menu-inner">
                    @permission('View Trips')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('trips.index') ? 'active' : '' }}" href="{{ route('trips.index') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">إدارة الرحلات</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('View Trip Monitor')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('trips.monitor') ? 'active' : '' }}" href="{{ route('trips.monitor') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">المراقبة الحية</span>
                            <span class="menu-badge badge-success pulse">مباشر</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission
            @endpermission

            {{-- Menu Section: إدارة النظام --}}
            @permission('Manage Users|Manage Settings')
            <li class="menu-section">
                <span class="menu-section-title">إدارة النظام</span>
            </li>

            {{-- Users Management --}}
            @permission('Manage Users')
            <li class="menu-item menu-arrow {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'open' : '' }}">
                <a class="menu-link" href="javascript:void(0);" role="button">
                    <span class="menu-icon">
                        <i class="fas fa-users-cog"></i>
                    </span>
                    <span class="menu-label">المستخدمين</span>
                </a>
                <ul class="menu-inner">
                    @permission('View Users')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">قائمة المستخدمين</span>
                        </a>
                    </li>
                    @permission('Create Users')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('users.create') ? 'active' : '' }}" href="{{ route('users.create') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">إضافة مستخدم</span>
                        </a>
                    </li>
                    @endpermission
                    @endpermission
                    @permission('View Roles')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">الصلاحيات</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('View Permissions')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}" href="{{ route('permissions.index') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">الأذونات</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission

            {{-- Settings --}}
            @permission('Manage Settings')
            <li class="menu-item menu-arrow {{ request()->routeIs('settings.*') ? 'open' : '' }}">
                <a class="menu-link" href="javascript:void(0);" role="button">
                    <span class="menu-icon">
                        <i class="fas fa-sliders-h"></i>
                    </span>
                    <span class="menu-label">الإعدادات</span>
                </a>
                <ul class="menu-inner">
                    @permission('Manage General Settings')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('settings.general') ? 'active' : '' }}" href="{{ route('settings.general') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">إعدادات عامة</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('Manage ZATCA Settings')
                    <li class="menu-item">
                        <a class="menu-link {{ request()->routeIs('settings.zatca') ? 'active' : '' }}" href="{{ route('settings.zatca') }}">
                            <span class="menu-dot"></span>
                            <span class="menu-label">الزكاة والضريبة</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission
            @endpermission
        </ul>
    </nav>
    
    {{-- Sidebar Footer --}}
    <div class="app-footer">
        <div class="sidebar-footer-wrapper px-3 py-3">
            {{-- Quick Actions --}}
            <div class="quick-actions d-flex gap-2 mb-3">
                <a href="{{ route('profile.index') }}" class="btn btn-sm btn-soft-primary flex-fill" data-bs-toggle="tooltip" title="الملف الشخصي">
                    <i class="fas fa-user"></i>
                </a>
                <a href="{{ route('profile.index') }}#security" class="btn btn-sm btn-soft-info flex-fill" data-bs-toggle="tooltip" title="الإعدادات">
                    <i class="fas fa-cog"></i>
                </a>
                <a href="#" class="btn btn-sm btn-soft-warning flex-fill" data-bs-toggle="tooltip" title="المساعدة">
                    <i class="fas fa-question-circle"></i>
                </a>
            </div>
            
            {{-- Logout Button --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-logout w-100" type="submit">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    <span>تسجيل الخروج</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<style>
    /* Sidebar User Card */
    .sidebar-user-card {
        background: rgba(var(--sidqa-primary-rgb), 0.08);
        border-radius: var(--sidqa-radius);
        margin: 0 0.75rem;
    }
    
    /* Menu Section Title */
    .menu-section {
        padding: 1rem 1.25rem 0.5rem;
    }
    
    .menu-section-title {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--sidqa-gray-500);
        opacity: 0.8;
    }
    
    /* Menu Icon Wrapper */
    .menu-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--sidqa-radius-sm);
        background: rgba(var(--sidqa-primary-rgb), 0.1);
        color: var(--sidqa-primary);
        margin-left: 0.75rem;
        transition: all var(--sidqa-transition);
    }
    
    .menu-link:hover .menu-icon,
    .menu-link.active .menu-icon {
        background: var(--sidqa-primary);
        color: white;
    }
    
    /* Menu Dot for Submenu Items */
    .menu-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--sidqa-gray-400);
        margin-left: 0.75rem;
        transition: all var(--sidqa-transition);
    }
    
    .menu-link:hover .menu-dot,
    .menu-link.active .menu-dot {
        background: var(--sidqa-primary);
        box-shadow: 0 0 0 3px rgba(var(--sidqa-primary-rgb), 0.2);
    }
    
    /* Menu Badge */
    .menu-badge {
        font-size: 0.65rem;
        padding: 0.2rem 0.5rem;
        border-radius: var(--sidqa-radius-full);
        font-weight: 600;
        margin-right: auto;
    }
    
    .menu-badge.badge-primary {
        background: rgba(var(--sidqa-primary-rgb), 0.15);
        color: var(--sidqa-primary);
    }
    
    .menu-badge.badge-success {
        background: rgba(0, 184, 148, 0.15);
        color: #00b894;
    }
    
    .menu-badge.pulse {
        animation: badge-pulse 2s ease-in-out infinite;
    }
    
    @keyframes badge-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    /* Sidebar Footer */
    .sidebar-footer-wrapper {
        border-top: 1px solid var(--sidqa-gray-200);
    }
    
    .btn-soft-primary {
        background: rgba(var(--sidqa-primary-rgb), 0.1);
        color: var(--sidqa-primary);
        border: none;
    }
    
    .btn-soft-primary:hover {
        background: var(--sidqa-primary);
        color: white;
    }
    
    .btn-soft-info {
        background: rgba(116, 185, 255, 0.1);
        color: #74b9ff;
        border: none;
    }
    
    .btn-soft-info:hover {
        background: #74b9ff;
        color: white;
    }
    
    .btn-soft-warning {
        background: rgba(253, 203, 110, 0.1);
        color: #fdcb6e;
        border: none;
    }
    
    .btn-soft-warning:hover {
        background: #fdcb6e;
        color: var(--sidqa-dark);
    }
    
    .btn-logout {
        background: linear-gradient(135deg, rgba(255, 118, 117, 0.1) 0%, rgba(214, 48, 49, 0.1) 100%);
        color: #d63031;
        border: 1px solid rgba(214, 48, 49, 0.2);
        border-radius: var(--sidqa-radius);
        padding: 0.625rem 1rem;
        font-weight: 600;
        transition: all var(--sidqa-transition);
    }
    
    .btn-logout:hover {
        background: linear-gradient(135deg, #ff7675 0%, #d63031 100%);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(214, 48, 49, 0.3);
    }
    
    /* Active Menu Item Highlight */
    .menu-item > .menu-link.active {
        background: rgba(var(--sidqa-primary-rgb), 0.08);
        color: var(--sidqa-primary);
        border-radius: var(--sidqa-radius-sm);
    }
    
    /* Dark Mode Adjustments */
    [data-bs-theme="dark"] .sidebar-user-card {
        background: rgba(255, 255, 255, 0.05);
    }
    
    [data-bs-theme="dark"] .sidebar-footer-wrapper {
        border-top-color: rgba(255, 255, 255, 0.1);
    }
    
    [data-bs-theme="dark"] .menu-section-title {
        color: var(--sidqa-gray-400);
    }
</style>
