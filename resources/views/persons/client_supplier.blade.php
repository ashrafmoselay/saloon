@extends('layouts.app')
@section('title',trans('front.clientandsupplier').' '.request()->name)
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @lang('front.clientandsupplier')
            <small>
                {{request()->name}}
            </small>
            <a onclick="window.print();" href="javascript:void(0)" class=" btn btn-lg print pull-right"><i class="fa fa-print" aria-hidden="true"></i></a>
            <button id="pdf-button" class="btn btn-success print-window pull-right"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> تحميل PDF</button>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('layouts.partial.printHeader',['showCompanyData'=>true])
        <div class="row hideprint">
            <div class="col-md-12">
                <form action="{{route('persons.getClientSupplier')}}" method="get">
                    <div class="input-group input-group-sm">
                        <select data-placeholder="@lang('front.select')" name="name" class="form-control select2 " style="width:100%;">
                            <option value=""></option>
                            @foreach($persons as $per)
                                <option {{request()->name==$per->name?'selected':''}} value="{{$per->name}}">{{$per->name}}</option>
                            @endforeach
                        </select>
                        <span class="input-group-btn">
                          <button style="margin-right: 20px;width: 386px;" type="submit" class="btn btn-info btn-flat">@lang('front.search')</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">@lang('front.balance')</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>@lang('front.clientbalance')</th>
                                <th>@lang('front.supplierbalance')</th>
                                <th>@lang('front.balance')</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if($client)
                                    <tr>
                                        @php
                                            $clientTrans = $client?$client->transactions()->sum('value'):0;
                                            $supplierTrans = $supplier?$supplier->transactions()->sum('value'):0;
                                            $diff = $clientTrans-$supplierTrans;
                                        @endphp
                                        <td>{{$clientTrans}}</td>
                                        <td>{{$supplierTrans}}</td>
                                        <td><div style="width: 100%" class="progress-bar progress-bar-{{$diff>0?'success':'danger'}}">{{$diff}}</div></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">@lang('front.clientpayment')</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if($client)
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('front.date')</th>
                                    <th>@lang('front.value')</th>
                                    <th>@lang('front.title')</th>
                                    <th class="no-sort"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($client->transactions as $trans)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$trans->created_at->format('Y-m-d h:i A')}}</td>
                                        <td>{{$trans->value}}</td>
                                        <td>{{$trans->note}}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">@lang('front.supplierpayment')</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if($supplier)
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('front.date')</th>
                                    <th>@lang('front.value')</th>
                                    <th>@lang('front.title')</th>
                                    <th class="no-sort"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($supplier->transactions as $trans)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$trans->created_at->format('Y-m-d h:i A')}}</td>
                                        <td>{{$trans->value}}</td>
                                        <td>{{$trans->note}}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">@lang('front.orders')</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('front.date')</th>
                                <th>@lang('front.invoicenumber')</th>
                                <th>@lang('front.total')</th>
                                <th>@lang('front.paid')</th>
                                <th>@lang('front.due')</th>
                            </tr>
                            </thead>
                            @if($client)
                            <tbody>
                            @foreach($client->orders as $order)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$order->invoice_date}}</td>
                                    <td>{{$order->invoice_number}}</td>
                                    <td>{{$order->total}}</td>
                                    <td>{{$order->paid}}</td>
                                    <td>{{$order->due}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">@lang('front.purchases')</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('front.date')</th>
                                <th>@lang('front.invoicenumber')</th>
                                <th>@lang('front.total')</th>
                                <th>@lang('front.paid')</th>
                                <th>@lang('front.due')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($supplier)
                                @foreach($supplier->orders as $order)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$order->invoice_date}}</td>
                                        <td>{{$order->invoice_number}}</td>
                                        <td>{{$order->total}}</td>
                                        <td>{{$order->paid}}</td>
                                        <td>{{$order->due}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">@lang('front.ordreturn')</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('front.date')</th>
                                <th>@lang('front.total')</th>
                                <th>@lang('front.payment')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($client)
                            @foreach($client->returns as $return)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$return->return_date}}</td>
                                    <td>{{$return->return_value}}</td>
                                    <td>{{$return->is_cash?trans('front.cash'):trans('front.from previous balance')}}</td>
                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">@lang('front.purchasereturns')</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('front.date')</th>
                                <th>@lang('front.total')</th>
                                <th>@lang('front.payment')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($supplier)
                            @foreach($supplier->returns as $return)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$return->return_date}}</td>
                                    <td>{{$return->return_value}}</td>
                                    <td>{{$return->is_cash?trans('front.cash'):trans('front.from previous balance')}}</td>
                                </tr>
                            @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop
@push('css')
    <style>
        @media print {
            @if($settings['printerType']=='A5')
                table {
                max-width: 19cm !important;
                width: 19cm !important;
            }
            @elseif($settings['printerType']=='A4')
                .row,.col-md-12, table {
                max-width: 27.5cm !important;
                width: 27.5cm !important;
            }
            @endif
            html, body {
                height:100vh;
                width: 100vh;
                margin: 0px !important;
                padding-right: 5px !important;
                /*overflow: hidden;*/
            }
            @page{
                size: auto;
                height:auto;
                margin-left: 0cm;
                margin-right: 0px;
                margin-top: 0cm;
                margin-bottom: 0px;
                padding: 0cm!important;
            }
        }
    </style>
@endpush
@push('js')
    <script>
        $(".select2").select2();
    </script>
@endpush
