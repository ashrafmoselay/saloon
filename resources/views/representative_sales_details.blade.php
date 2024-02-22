@extends('layouts.app')
@section('title','إجمالى مبيعات المندوب  '.$emp)
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            إجمالى مبيعات المندوب {{$emp}}
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table class="table table-bordered  dataTableTT">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>العميل</th>
                                <th>@lang('front.date')</th>
                                <th>@lang('front.invoicenumber')</th>
                                <th>@lang('front.payment')</th>
                                <th>@lang('front.total')</th>
                                <th>الخصم</th>
                                <th>@lang('front.paid')</th>
                                <th>@lang('front.due')</th>
                                <th>@lang('front.status')</th>
                                <th class="no-sort"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $order)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{optional($order->client)->name}}</td>
                                    <td>{{$order->invoice_date}}</td>
                                    <td>{{$order->invoice_number}}</td>
                                    <td>{{!in_array($order->payment_type,['cash','delayed'])?$order->payment_type:trans('app.'.$order->payment_type)}}</td>
                                    <td>{{currency($order->getOriginal('total'),$order->currency,$order->currency, $format = true)}}</td>
                                    <td>{{$order->discount_value}}</td>
                                    <td>{{currency($order->getOriginal('paid'),$order->currency,$order->currency, $format = true)}}</td>
                                    <td>{{currency($order->getOriginal('due'),$order->currency,$order->currency, $format = true)}}</td>
                                    <td>
                                        @if($order->status)
                                            <button href="#" type="button" class="btn btn-sm btn-success"><i class="fa  fa-check"></i></button>
                                        @else
                                            <a href="#" type="button" class="btn btn-sm btn-success"><i class="fa fa-times"></i></a>
                                        @endif
                                    </td>
                                    <td class="actions">
                                        <a data-toggle="modal" data-target="#myModal" href="{{route('orders.show',$order)}}" class="btn btn-warning btn-xs">
                                            <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                                            @lang('front.show')
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
