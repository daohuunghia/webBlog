<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập hệ thống </title>
    <link rel="stylesheet" href="{{ asset('backend/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/login.css') }}">
    <link href="{{ asset('backend/dist/css/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    @if(session('toastr'))
        <script>
            var TYPE_MESSAGE = "{{session('toastr.type')}}";
            var MESSAGE      = "{{session('toastr.message')}}";
        </script>
    @endif
</head>
<body>
<div class="container clearfix">
    <div class="wp-form-login">
        <form action="" method="POST" class="form-login">
            @csrf
            <h4 class="title">{{ trans('backend.Login') }}</h4>
            @include('backend.includes.notification')
            <div class="group-input">
                <label for="email">{{ trans('backend.Email') }}</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required />
            </div>
            <div class="group-input">
                <label for="password">{{ trans('backend.Password') }}</label>
                <input type="password" name="password" id="password" value="" required>
            </div>
            <div class="group-input-check">
                <label for="remember_me">{{trans('backend.Remember me')}}
                    <input type="checkbox" name="remember_me" id="remember_me" value="remember_me">
                    <span><span></span></span>
                </label>
            </div>
            <div class="group-button clearfix">
                <input type="submit" name="sm-btn" value="Đăng nhập" class="sm-login">
                <a href="" class="forget-pass">Quên mật khẩu ?</a>
            </div>
            <div class="group-button">
                <button class="btn-social log-fb d-block w-100">
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                    <span>Log in with Facebook</span>
                </button>
                <a href="" class="btn-social log-gg d-block w-100">
                    <i class="fa fa-google" aria-hidden="true"></i>
                    <span>Log in with Google</span>
                </a>
                <a href="" class="link-regis">Đăng ký</a><span>nếu chưa có tài
                    khoản</span>
            </div>
        </form>
    </div>
    <!-- end wp-form-login -->
</div>
</body>
<script src="{{ asset('backend/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('backend/dist/js/toastr.min.js') }}"></script>
<script type="text/javascript">
    if (typeof TYPE_MESSAGE != "undefined")
    {
        switch (TYPE_MESSAGE) {
            case 'success':
                toastr.success(MESSAGE)
                break;
            case 'warning':
                toastr.warning(MESSAGE)
                break;
            case 'info':
                toastr.info(MESSAGE)
                break;
            case 'error':
                toastr.error(MESSAGE)
                break;
        }
    }
</script>
</html>
