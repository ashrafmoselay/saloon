@extends('layouts.app')

@section('content')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @lang('front.Movements of the day')
                <small></small>
                <a data-toggle="modal" data-target="#addPersonModal"  href="{{route('closeShift')}}" class="btn btn-success pull-right">@lang('front.CloseShift')</a>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->
            <div class="row">

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-cart-plus"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">@lang('front.Sales today')</span>
                            <span style="width: 100%;margin-top: 5px;" class="info-box-number badge bg-green">
                                {{round($todayOrders,2)}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-share-square-o"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">@lang('front.Purchases today')</span>
                            <span style="width: 100%;margin-top: 5px;" class="info-box-number badge bg-yellow">{{round($totdayPurchases,2)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-reply-all"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('front.Sales Returns')</span>
                            <span style="width: 100%;margin-top: 5px;" class="info-box-number badge bg-red">
                                {{round($orderReturn,2)}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">@lang('front.expensestoday')</span>
                            <span style="width: 100%;margin-top: 5px;" class="info-box-number badge bg-aqua">{{round($expenses,2)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body text-center" >
                            @if($settings['logo'])
                                <img style="width: 50%;"  src="{{\Illuminate\Support\Facades\Storage::url($settings['logo'])}}">
                                @else
                                <div style="background-color: #5b9ac5;">
                                    <img style="height: 100%;" src="{{asset('bg.jpg')}}">
                                </div>
                            @endif
                        </div>
                        <!-- ./box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>

        </section>
        <!-- /.content -->
@endsection
