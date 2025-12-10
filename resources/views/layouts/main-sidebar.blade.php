 <aside class="app-menubar" id="appMenubar">
      <div class="app-navbar-brand">
        <a class="navbar-brand-logo" href="{{ route('dashboard') }}">
        </a>
        <a class="navbar-brand-mini visible-light" href="{{ route('dashboard') }}">
          <img width="150" src="{{ asset('assets/images/brand/logo.png') }}" alt="SIDQA Logo">
        </a>
        <a class="navbar-brand-mini visible-dark" href="{{ route('dashboard') }}">
          <img width="150" src="{{ asset('assets/images/brand/logo.png') }}" alt="SIDQA Logo">
        </a>
      </div>
      <nav class="app-navbar" data-simplebar>
        <ul class="menubar">
          <!-- Driver Portal Link (for drivers only) -->
          @if(auth()->user()->hasRole('Driver'))
          <li class="menu-item">
            <a class="menu-link" href="{{ route('driver-portal.index') }}">
              <i class="fas fa-id-card"></i>
              <span class="menu-label">بوابة السائق</span>
            </a>
          </li>
          @endif

          <li class="menu-item menu-arrow">
            <a class="menu-link" href="javascript:void(0);" role="button">
              <i class="fi fi-rr-apps"></i>
              <span class="menu-label">لوحة التحكم</span>
            </a>
            <ul class="menu-inner">
              <li class="menu-item">
                <a class="menu-link" href="{{ route('dashboard') }}">
                  <span class="menu-label">لوحة التحكم الرئيسية</span>
                </a>
              </li>
              <li class="menu-item">
                <a class="menu-link" href="{{ route('home') }}">
                  <span class="menu-label">الرئيسية</span>
                </a>
              </li>
            </ul>
          </li>
          @permission('Manage Financial Settings')
          <li class="menu-item menu-arrow">
            <a class="menu-link" href="javascript:void(0);" role="button">
              <i class="fas fa-tasks"></i>
              <span class="menu-label">الاعدادات المالية</span>
            </a>
            <ul class="menu-inner">
            @permission('View Expense Catigorties')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('expense_catigories.index') }}">
                  <span class="menu-label">إدارة بنود الصرف</span>
                </a>
              </li>
            @endpermission
            @permission('Manage Tax')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('taxes.index') }}">
                  <span class="menu-label">إدارة الضرائب</span>
                </a>
              </li>
            @endpermission
            @permission('Manage Financial Accounts')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('accounts.index') }}">
                  <span class="menu-label">إدارة الحسابات</span>
                </a>
              </li>
            @endpermission
            @permission('Manage Payment Methods')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('payment_methods.index') }}">
                  <span class="menu-label">إدارة طرق الدفع</span>
                </a>
              </li>
            @endpermission
            </ul>
          </li>
          @endpermission
          @permission('Financial Oprations')
          <li class="menu-item menu-arrow">
            <a class="menu-link" href="javascript:void(0);" role="button">
              <i class="fas fa-hand-holding-usd"></i>
              <span class="menu-label">العمليات المالية</span>
            </a>
            <ul class="menu-inner">
            @permission('View Expense')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('expenses.index') }}">
                  <span class="menu-label">المصروفات</span>
                </a>
              </li>
            @endpermission
            @permission('Charging accounts')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('accounts.charge') }}">
                  <span class="menu-label">إيداع مالي</span>
                </a>
              </li>
            @endpermission
            @permission('Transfer Between Accounts')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('accounts.transfer') }}">
                  <span class="menu-label">التحويل بين الحسابات</span>
                </a>
              </li>
            @endpermission
            @permission('View Transactions')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('transactions.index') }}">
                  <span class="menu-label">مراقب المعاملات</span>
                </a>
              </li>
            @endpermission
            </ul>
          </li>
          @endpermission
          @permission('View Financial Reports')
          <li class="menu-item menu-arrow">
            <a class="menu-link" href="javascript:void(0);" role="button">
              <i class="fas fa-chart-bar"></i>
              <span class="menu-label">التقارير المالية</span>
            </a>
            <ul class="menu-inner">
            @permission('View Financial Summary')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('reports.summary') }}">
                  <span class="menu-label">الملخص المالي</span>
                </a>
              </li>
            @endpermission
            @permission('View Expense Report')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('reports.expenses') }}">
                  <span class="menu-label">تقرير المصروفات</span>
                </a>
              </li>
            @endpermission
            @permission('View Income Report')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('reports.income') }}">
                  <span class="menu-label">تقرير الإيرادات</span>
                </a>
              </li>
            @endpermission
            @permission('View Account Statement')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('reports.account_statement') }}">
                  <span class="menu-label">كشف حساب</span>
                </a>
              </li>
            @endpermission
            @permission('View Income Statement')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('reports.income_statement') }}">
                  <span class="menu-label">قائمة الدخل</span>
                </a>
              </li>
            @endpermission
            @permission('View Balance Sheet')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('reports.balance_sheet') }}">
                  <span class="menu-label">الميزانية العمومية</span>
                </a>
              </li>
            @endpermission
            @permission('View Driver Trips Report')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('reports.driver_trips') }}">
                  <span class="menu-label">تقرير رحلات السائقين</span>
                </a>
              </li>
            @endpermission
            </ul>
          </li>
          @endpermission
          @permission('Manage Operations')
          <li class="menu-item menu-arrow">
            <a class="menu-link" href="javascript:void(0);" role="button">
              <i class="fas fa-car"></i>
              <span class="menu-label">إدارة العمليات</span>
            </a>
            <ul class="menu-inner">
            @permission('View Vehicle')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('vehicles.index') }}">
                  <span class="menu-label">إدارة المركبات</span>
                </a>
              </li>
            @endpermission
            @permission('View Driver')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('drivers.index') }}">
                  <span class="menu-label">إدارة السائقين</span>
                </a>
              </li>
            @endpermission
            @permission('View Maintenance')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('maintenances.index') }}">
                  <span class="menu-label">صيانة المركبات</span>
                </a>
              </li>
            @endpermission
            @permission('View Trips')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('trips.index') }}">
                  <span class="menu-label">إدارة الرحلات</span>
                </a>
              </li>
            @endpermission
            @permission('View Trip Monitor')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('trips.monitor') }}">
                  <span class="menu-label">مراقبة الرحلات الحية</span>
                </a>
              </li>
            @endpermission
            </ul>
          </li>
          @endpermission
          <!-- Core Business Management -->
          @permission('View Customers|View Services')
          <li class="menu-item menu-arrow">
            <a class="menu-link" href="javascript:void(0);" role="button">
              <i class="fas fa-building"></i>
              <span class="menu-label">إدارة الأعمال الأساسية</span>
            </a>
            <ul class="menu-inner">
              @permission('View Customers')
              <li class="menu-item menu-arrow">
                <a class="menu-link" href="javascript:void(0);">
                  <span class="menu-label">إدارة العملاء</span>
                </a>
                <ul class="menu-inner">
                  <li class="menu-item">
                    <a class="menu-link" href="{{ route('customers.index') }}">
                      <span class="menu-label">قائمة العملاء</span>
                    </a>
                  </li>
                  @permission('Create Customers')
                  <li class="menu-item">
                    <a class="menu-link" href="{{ route('customers.create') }}">
                      <span class="menu-label">إضافة عميل</span>
                    </a>
                  </li>
                  @endpermission
                </ul>
              </li>
              @endpermission
              @permission('View Services')
              <li class="menu-item menu-arrow">
                <a class="menu-link" href="javascript:void(0);">
                  <span class="menu-label">إدارة الخدمات</span>
                </a>
                <ul class="menu-inner">
                  <li class="menu-item">
                    <a class="menu-link" href="{{ route('services.index') }}">
                      <span class="menu-label">قائمة الخدمات</span>
                    </a>
                  </li>
                  @permission('Create Services')
                  <li class="menu-item">
                    <a class="menu-link" href="{{ route('services.create') }}">
                      <span class="menu-label">إضافة خدمة</span>
                    </a>
                  </li>
                  @endpermission
                </ul>
              </li>
              @endpermission
            </ul>
          </li>
          @endpermission
          @permission('Manage Users')
          <li class="menu-item menu-arrow">
            <a class="menu-link" href="javascript:void(0);" role="button">
              <i class="fi fi-rr-user-key"></i>
              <span class="menu-label">المستخدمين</span>
            </a>
            <ul class="menu-inner">
              @permission('View Users')
              <li class="menu-item menu-arrow">
                <a class="menu-link" href="javascript:void(0);">
                  <span class="menu-label">إدارة المستخدمين</span>
                </a>
                <ul class="menu-inner">
                    @permission('Create Users')
                  <li class="menu-item">
                    <a class="menu-link" href="{{ route('users.create') }}">
                      <span class="menu-label">إضافة مستخدم</span>
                    </a>
                  </li>
                  @endpermission
                  <li class="menu-item">
                    <a class="menu-link" href="{{ route('users.index') }}">
                      <span class="menu-label">قائمة المستخدمين</span>
                    </a>
                  </li>
                </ul>
              </li>
              @endpermission
              @permission('View Roles')
              <li class="menu-item menu-arrow">
                <a class="menu-link" href="javascript:void(0);">
                  <span class="menu-label">إدارة الصلاحيات</span>
                </a>
                <ul class="menu-inner">
                    @permission('Create Roles')
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('roles.create') }}">
                        <span class="menu-label">إضافة صلاحية</span>
                        </a>
                    </li>
                    @endpermission
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('roles.index') }}">
                        <span class="menu-label">قائمة الصلاحيات</span>
                        </a>
                    </li>
                </ul>
              </li>
              @endpermission
              @permission('View Permissions')
              <li class="menu-item menu-arrow">
                <a class="menu-link" href="javascript:void(0);">
                  <span class="menu-label">إدارة الأذونات</span>
                </a>
                <ul class="menu-inner">
                    @permission('Create Permissions')
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('permissions.create') }}">
                        <span class="menu-label">إضافة أذن</span>
                        </a>
                    </li>
                    @endpermission
                    <li class="menu-item">
                        <a class="menu-link" href="{{ route('permissions.index') }}">
                        <span class="menu-label">قائمة الأذونات</span>
                        </a>
                    </li>
                </ul>
              </li>
              @endpermission
            </ul>
          </li>
          @endpermission
          @permission('Manage Settings')
          <li class="menu-item menu-arrow">
            <a class="menu-link" href="javascript:void(0);" role="button">
              <i class="fas fa-cogs"></i>
              <span class="menu-label">الإعدادات</span>
            </a>
            <ul class="menu-inner">
              @permission('Manage General Settings')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('settings.general') }}">
                  <span class="menu-label">الإعدادات العامة</span>
                </a>
              </li>
              @endpermission
              @permission('Manage ZATCA Settings')
              <li class="menu-item">
                <a class="menu-link" href="{{ route('settings.zatca') }}">
                  <span class="menu-label">هيئة الزكاة والضريبة</span>
                </a>
              </li>
              @endpermission
            </ul>
          </li>
          @endpermission
        </ul>
      </nav>
      <div class="app-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-light waves-effect btn-shadow btn-app-nav w-100 text-danger" type="submit">
                <i class="fi fi-sr-exit scale-1x"></i>
                 <span class="nav-text">تسجيل الخروج</span>
            </button>
        </form>
      </div>
    </aside>
