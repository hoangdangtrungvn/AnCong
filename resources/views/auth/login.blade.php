@extends('adminlte::master')

@section('adminlte_css')
<link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}" />
@yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">
            {!! config('adminlte.logo', '
            <b>Admin</b>LTE') !!}
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Đăng nhập để bắt đầu phiên làm việc</p>
        @if (session('alert'))
        <div class="alert {{ session('alert')['class'] }} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon {{ session('alert')['icon'] }}"></i> {{ session('alert')['message'] }}
        </div>
        @endif
        <form action="{{ route('login') }}" method="post">
            {!! csrf_field() !!}

            <div class="form-group has-feedback {{ $errors->has('type') ? 'has-error' : '' }}">
                <select name="type" class="form-control">
                    <option value="0">--- Chọn loại bác sĩ ---</option>
                    <option value="1" {{ old('type', 1) == 1 ? 'selected' : '' }}>Điều phối viên</option>
                    <option value="2" {{ old('type') == 2 ? 'selected' : '' }}>Bác sĩ dinh dưỡng</option>
                    <option value="3" {{ old('type') == 3 ? 'selected' : '' }}>Bác sĩ chuyên khoa</option>
                    <option value="4" {{ old('type') == 4 ? 'selected' : '' }}>Bác sĩ đa khoa</option>
                </select>
                @if ($errors->has('type'))
                <span class="help-block">
                    <strong>{{ $errors->first('type') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                <input type="email" name="email" class="form-control" value="{{ old('email', 'trung@gmail.com') }}" placeholder="Địa chỉ e-mail" />
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                <input type="password" name="password" class="form-control" value="12345678" placeholder="Mật khẩu" />
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember" /> Ghi nhớ tài khoản
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <div class="auth-links">
            @if (config('adminlte.password_reset_url', 'password/reset'))
            <a href="{{ url(config('adminlte.password_reset_url', 'password/reset')) }}" class="text-center">
                {{ trans('adminlte::adminlte.i_forgot_my_password') }}
            </a>
            <br />
            @endif
            @if (config('adminlte.register_url', 'register'))
            <a href="{{ url(config('adminlte.register_url', 'register')) }}" class="text-center">
                {{ trans('adminlte::adminlte.register_a_new_membership') }}
            </a>
            @endif
        </div>
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
@stop

@section('adminlte_js')
<script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
<script>
    $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
</script>
@yield('js')
@stop