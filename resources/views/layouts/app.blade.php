<!DOCTYPE html>
<html dir="{{App::getLocale()=='ar'?'rtl':'ltr'}}">
@include('layouts.partial.head')
<body class="hold-transition skin-blue sidebar-mini">
    {{-- <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> معاد تجديد السيرفر !</h4>
        برجاء تحويل تكلفة تجديد السيرفر والدومين 1000 ج على رقم 01061048481 فودافون كاش قبل انتهاء فترة السماح
        <br/>
        <span>
        موعد التجديد القادم 01-01-2023
        </span>
    </div> --}}
    <div class="wrapper">

        @include('layouts.partial.header')

        @include('layouts.partial.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div  class="content-wrapper">
        	<div style=" overflow: auto; width: 100%;">
            @yield('content')
            </div>
        </div>
        <!-- /.content-wrapper -->

        @include('layouts.partial.footer')

    </div>
    @include('layouts.partial.script')

    <iframe style="display: none;height: 2480px;" name="theFrame"></iframe>
    {{--<div id="footer">
        <b>{!!$settings['Address']!!}</b>
        <br><br><span>{{$settings['mobile']}}</span>
    </div>--}}
</body>
</html>
