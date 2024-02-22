@extends('layouts.app')
@section('content')
<section class="content">

    <div class="error-page">
        <h2 class="headline text-red">440</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> ليس لك صلاحية لهذه العملية</h3>

            <div style="margin-top: 30px;" class="input-group">
                <div class="input-group-addon ">
                    <i class="fa fa-phone text-red"></i>
                    إتصل على
                </div>
                <input disabled class="form-control pull-right"  value="{{config('developer.mobile')}}"/>
            </div>
            <img style="width: 408px;" src="{{asset('front/dist/img')}}/forbidden.jpg">

        </div>
    </div>
    <!-- /.error-page -->

</section>
@stop
