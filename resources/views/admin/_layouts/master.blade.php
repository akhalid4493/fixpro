<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    @include('admin._layouts._head')

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white page-md">
        <div class="page-wrapper">

            @include('admin._layouts._header')

            <div class="clearfix"> </div>

            <div class="page-container">
                @include('admin._layouts._aside')

                @yield('content')
            </div>

            @include('admin._layouts._footer')
        </div>
        
        @include('admin._layouts._jquery')
    </body>
</html>