<html>
    @section('title','Admin-Panel || Login Page')
    <link rel="stylesheet" href="{{ url('admin/assets/pages/css/login.min.css') }}">
    @include('admin._layouts._head')
    <body class="login">
        <div class="content">
            <form class="login-form" action="{{ route('login') }}" method="post">
                {{ csrf_field() }}
                
                <h3 class="form-title font-green">Sign In</h3>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="control-label visible-ie8 visible-ie9">E-mail</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" value="{{ old('email') }}" placeholder="Your Email" name="email"/>
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{$errors->has('password') ? ' has-error' : ''}}">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" name="password" placeholder="Your Password"/>
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn green uppercase">Login</button>
                </div>
            </form>
        </div>
        <div class="copyright">
            <a href="#" target="_blank">tocaan</a>.
            جميع الحقوق محفوظة © {{date('Y')}} :
        </div>
        @include('admin._layouts._jquery')
    </body>
</html>