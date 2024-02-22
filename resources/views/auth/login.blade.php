<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@lang('front.login')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{asset('front')}}/bootstrap4.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('front')}}/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('front/dist')}}/css/AdminLTE.min.css">
    @if(\App::getLocale('locale') == 'ar')
        <link rel="stylesheet" href="{{asset('front/dist')}}/css/AdminLTE-rtl.min.css">
    @endif

    <link rel="stylesheet" href="{{asset('front')}}/login.css">
</head>
<body>
    <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-3 mx-auto">
        <div class="card card0 border-0">
            <div class="row d-flex">
                <div class="col-lg-6">
                    <div class="card2 card border-0 px-4 py-5">
                        <div class="row mb-4">
                            <h1 class="mb-0 mt-2">
                                <b>{{config('developer.appname_'.App::getLocale())}}</b>
                            </h1>
                            <small style=" position: absolute; left: 0; " class="font-weight-bold">
                                <a href="{{route('changeLang',App::getLocale()=='ar'?'en':'ar')}}">
                                    {{App::getLocale()=='ar'?'EN':'العربية'}}
                                </a>
                            </small>
                        </div>
                        <div class="row px-3 mb-4">
                            <div class="line"></div>
                            <small class="or text-center">@lang('front.login')</small>
                            <div class="line"></div>
                        </div>

                        <form action="{{ route('login') }}" method="post">
                            {{ csrf_field() }}
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm">@lang('front.username')</h6>
                                </label>
                                <input required="" value="{{optional(\App\User::orderBy('id','DESC')->first())->email}}" class="mb-4" type="text" name="email" placeholder="@lang('front.username')">
                            </div>
                            <div class="row px-3"> <label class="mb-1">
                                <h6 class="mb-0 text-sm">@lang('front.password')</h6>
                            </label> <input required="" type="password" name="password" placeholder="@lang('front.password')"> </div>
                            <div class="row px-3 mb-4">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input id="chk1" type="checkbox" name="remember" class="custom-control-input form-control">
                                    <label for="chk1" class="custom-control-label text-sm">@lang('front.Remember me')</label>
                                </div>
                            </div>
                            <div class="row mb-3 px-3">
                                <button type="submit" class="btn btn-blue text-center">@lang('front.login')</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card1 pb-5">
                        @if(config('developer.logo'))
                        <div class="row">
                            <img style="{{ config('developer.logoStyle') }}" src="{{config('developer.logo')}}" class="logo">
                         </div>
                         @endif
                        <div class="row px-3 justify-content-center mb-5 border-line">
                            <img style="{{ config('developer.mainImgStyle') }}" src="{{asset('front')}}/{{ config('developer.mainImg') }} " class="image">
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-blue py-4">
                <div class="row px-3">
                    <small class="ml-4 ml-sm-5 mb-2 mr-4">
                    @lang('front.copyright') &copy; 2023 @lang('front.Designed and Developed By') {{config('developer.developer_'.App::getLocale())}}
                    </small>
                </div>
            </div>
        </div>
    </div>

       <!-- jQuery 2.2.3 -->
    <script src="{{asset('front/plugins')}}/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="{{asset('front/bootstrap')}}/js/bootstrap.min.js"></script>
</body>
</html>
