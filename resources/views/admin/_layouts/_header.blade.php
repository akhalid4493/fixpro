<div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner ">
        <div class="page-logo">
            <a href="{{ url(route('admin')) }}">
                {{-- <img src="{{ url(settings('logo')) }}" alt="logo" class="logo-default"/> --}}
                <div class="caption" style="margin: 16px;">
                    <span class="caption-subject font-green bold uppercase">
                        {{ settings('app_name_ar') }}
                    </span>
                </div>
            </a>
            <div class="menu-toggler sidebar-toggler">
                <span></span>
            </div>
        </div>
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar"></li>
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" class="img-circle" src="{{ url(Auth::user()->image) }}" />
                        <span class="username username-hide-on-mobile">
                            {{ Auth::user()->name }}
                        </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="{{ url(route('users.show',Auth::id())) }}">
                            <i class="icon-user"></i> الملف الشخصي </a>
                        </li>
                        <li>
                            <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="icon-key"></i> تسجيل الخروج </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>