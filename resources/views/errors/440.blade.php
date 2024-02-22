@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           غير مسموح لك
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
            <li class="active">خطأ</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="error-page">
            <h2 class="headline text-red">440</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-red"></i> إنتهت صلاحية النسخة التجريبية</h3>

                <div style="margin-top: 30px;" class="input-group">
                    <div class="input-group-addon ">
                        <i class="fa fa-phone text-red"></i>
                        إتصل على
                    </div>
                    <input class="form-control pull-right"  value="00201061048481"/>
                </div>
                <img style="width: 408px;" src="{{asset('front/dist/img')}}/forbidden.jpg">

            </div>
        </div>
        <!-- /.error-page -->

    </section>
    <!-- /.content -->
@endsection