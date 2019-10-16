<html dir="rtl">
    @section('title','Reset Password')

    @section('css')
      <link rel="stylesheet" href="{{url('admin/assets/pages/css/login.min.css')}}">
    @stop

    @include('admin._layouts._head')

    <body class="login">
        <div class="content">
            <form class="login-form" method="POST" action="{{ route('password.request') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <h3 class="form-title font-green">Reset Password</h3>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="control-label visible-ie8 visible-ie9">E-mail</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text"       autocomplete="off" value="{{ old('email') }}" placeholder="Your Email"
                    name="email"/>
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password"       autocomplete="off" value="{{ old('password') }}" placeholder="Your Password"
                    name="password"/>
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label class="control-label visible-ie8 visible-ie9">Confirm Password</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password"       autocomplete="off" value="{{ old('password_confirmation') }}" placeholder="Confirm Password"
                    name="password_confirmation"/>
                    @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn green uppercase">Reset Password</button>
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
