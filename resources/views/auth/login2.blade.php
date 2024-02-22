<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@lang('front.login')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{asset('front/bootstrap')}}/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('front/dist')}}/css/AdminLTE.min.css">
    @if(\App::getLocale('locale') == 'ar')
        <link rel="stylesheet" href="{{asset('front/bootstrap')}}/css/bootstrap-rtl.min.css">
        <link rel="stylesheet" href="{{asset('front/dist')}}/css/AdminLTE-rtl.min.css">
    @endif
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('front/plugins')}}/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>{{config('developer.appname_'.App::getLocale())}}</b></a>
    </div>
    <!-- /.login-logo -->
    
    <div class="login-box-body">
        <p class="login-box-msg">@lang('front.login')</p>

        <form action="{{ route('login') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <input value="{{optional(\App\User::orderBy('id','DESC')->first())->email}}" name="email" type="text" class="form-control" placeholder="@lang('front.username')">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input name="password" type="password" class="form-control" placeholder="@lang('front.password')">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <div class="checkbox icheck">
                        <label>
                            <input name="remember" {{ old('remember') ? 'checked' : ''}} type="checkbox"> @lang('front.Remember me')
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-6">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">@lang('front.login')</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="{{asset('front/plugins')}}/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{asset('front/bootstrap')}}/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="{{asset('front/plugins')}}/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
