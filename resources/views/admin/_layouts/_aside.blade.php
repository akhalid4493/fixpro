<div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <li class="nav-item start active">
                <a href="{{ url(route('admin')) }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">لوحة التحكم</span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="heading">
                <h3 class="uppercase">الاعضاء و الصلاحيات</h3>
            </li>
            @permission('show_roles')
            <li class="nav-item">
                <a href="{{ url(route('roles.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-lock"></i>
                    <span class="title">عرض الصلاحيات</span>
                </a>
            </li>
            @endpermission

            @permission('show_users')
            <li class="nav-item">
                <a href="{{ url(route('users.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">عرض الاعضاء</span>
                </a>
            </li>
            @endpermission

            @permission('show_technicals')
            <li class="nav-item">
                <a href="{{ url(route('technicals.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">مواعيد الموظفين</span>
                </a>
            </li>
            @endpermission
            <li class="heading">
                <h3 class="uppercase">التحكم</h3>
            </li>
            @permission('show_governorates')
            <li class="nav-item">
                <a href="{{ url(route('governorates.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-layers"></i>
                    <span class="title">عرض المحافظات</span>
                </a>
            </li>
            @endpermission
            @permission('show_provinces')
            <li class="nav-item">
                <a href="{{ url(route('provinces.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-layers"></i>
                    <span class="title">عرض المناطق</span>
                </a>
            </li>
            @endpermission

            @permission('show_pages')
            <li class="nav-item">
                <a href="{{ url(route('pages.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-layers"></i>
                    <span class="title">عرض الصفحات</span>
                </a>
            </li>
            @endpermission
            <li class="heading">
                <h3 class="uppercase">المعاينة</h3>
            </li>
            @permission('show_services')
            <li class="nav-item">
                <a href="{{ url(route('services.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-bar-chart"></i>
                    <span class="title">الخدمات</span>
                </a>
            </li>
            @endpermission

            @permission('show_previews')
            <li class="nav-item">
                <a href="{{ url(route('previews.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-bar-chart"></i>
                    <span class="title">طلبات المعاينة</span>
                    @if ($newPreviews > 0)
                    <span class="badge badge-danger">قيد الانتظار {{$newPreviews}}</span>
                    @endif
                </a>
            </li>
            @endpermission

            @permission('show_previews')
            <li class="nav-item">
                <a href="{{ url(route('previews.cancelled')) }}" class="nav-link nav-toggle">
                    <i class="icon-bar-chart"></i>
                    <span class="title">طلبات المعاينة الملغية</span>
                </a>
            </li>
            @endpermission

            @permission('show_previews')
            <li class="nav-item">
                <a href="{{ url(route('previews.done')) }}" class="nav-link nav-toggle">
                    <i class="icon-bar-chart"></i>
                    <span class="title">طلبات المعاينة المكتملة</span>
                </a>
            </li>
            @endpermission

            <li class="heading">
                <h3 class="uppercase">الطلبات</h3>
            </li>

            @permission('show_categories')
            <li class="nav-item">
                <a href="{{ url(route('categories.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-bar-chart"></i>
                    <span class="title">الاقسام</span>
                </a>
            </li>
            @endpermission

            @permission('show_products')
            <li class="nav-item">
                <a href="{{ url(route('products.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-bar-chart"></i>
                    <span class="title">قطع الغيار</span>
                </a>
            </li>
            @endpermission

            @permission('show_installations')
            <li class="nav-item">
                <a href="{{ url(route('installations.index'))}}" class="nav-link nav-toggle">
                    <i class="icon-bar-chart"></i>
                    <span class="title">قيمة التصليح</span>
                </a>
            </li>
            @endpermission
            @permission('show_orders')
            <li class="nav-item">
                <a href="{{ url(route('orders.index')) }}" class="nav-link nav-toggle">
                    <i class="fa fa-usd"></i>
                    <span class="title">الطلبات</span>
                </a>
            </li>
            @endpermission
            <li class="heading">
                <h3 class="uppercase">الاشتراكات</h3>
            </li>
            @permission('show_packages')
            <li class="nav-item">
                <a href="{{ url(route('packages.index')) }}" class="nav-link nav-toggle">
                    <i class="fa fa-usd"></i>
                    <span class="title">باقات الشركة</span>
                </a>
            </li>
            @endpermission

            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-puzzle"></i>
                    <span class="title">اشتراكات و فواتير</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    @permission('show_subscriptions')
                    <li class="nav-item  ">
                        <a href="{{ url(route('subscriptions.index')) }}" class="nav-link nav-toggle">
                            <i class="fa fa-usd"></i>
                            <span class="title">اشتراكات الاعضاء</span>
                        </a>
                    </li>
                    @endpermission

                    @permission('show_invoices')
                    <li class="nav-item  ">
                        <a href="{{ url(route('invoices.index')) }}" class="nav-link nav-toggle">
                            <i class="fa fa-usd"></i>
                            <span class="title">الفواتير الشهرية</span>
                        </a>
                    </li>
                    @endpermission
                </ul>
            </li>

            <li class="heading">
                <h3 class="uppercase">اعدادات</h3>
            </li>

            @permission('show_notifications')
            <li class="nav-item">
                <a href="{{ url(route('notification.index')) }}" class="nav-link nav-toggle">
                    <i class="fa fa-bell"></i>
                    <span class="title">اشعارات عامة</span>
                </a>
            </li>
            @endpermission

            @permission('show_service_notifications')
              <li class="nav-item">
                  <a href="{{ url(route('service_notifications.index')) }}" class="nav-link nav-toggle">
                      <i class="fa fa-bell"></i>
                      <span class="title">اشعار اعلى الخدمات</span>
                  </a>
              </li>
            @endpermission

            @permission('show_settings')
            <li class="nav-item">
                <a href="{{ url(route('settings.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-settings"></i>
                    <span class="title">الآعدادات</span>
                </a>
            </li>
            @endpermission
        </ul>
    </div>
</div>
