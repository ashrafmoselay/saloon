@extends('layouts.app')
@section('title',trans('front.productdetails').'  '.$product->name)
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
           @lang('front.productdetails')
            <small>{{$product->name}}</small>
            <a class="btn print-window pull-right" href="javascript:void(0)" onclick="window.print()" role="button">
                <i class="fa fa-print" aria-hidden="true"></i>
            </a>
            {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>--}}
            <strong>ربح الصنف :</strong>{{$product->product_profit}}

            @php
                $check = true;
                try{
                    $datahtml = $settings['SiteName']."\n رقم الموبيل: "
                                .$settings['mobile']."\n اسم الصنف: ".$product->name;
                    $Qcode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                    ->encoding('UTF-8')
                    ->size(100)
                    ->generate($datahtml));
                }catch (\Exception $e){
                    $check = false;
                }
            @endphp
            @if($check)
                <div style="margin-bottom: 5px;" class="pull-right">
                    <img src="data:image/png;base64,  {!! $Qcode !!}">
                </div>
            @endif
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    @include('layouts.partial.printHeader',['showCompanyData'=>true])
                    <div class="box-header">
                        <h3 class="box-title">@lang('front.Stores Quantities')</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    @foreach($product->productStore as $store)
                                        <tr>
                                            <td>{{$store->name}}</td>
                                            <td>{{$store->pivot->qty-$store->pivot->sale_count}}</td>
                                            <td>{{\App\Unit::find($store->pivot->unit_id)?\App\Unit::find($store->pivot->unit_id)->name:''}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">الشحنات</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered dataTableTT">
                                    <thead>
                                    <tr>
                                        <th>#<span class="hide boxTiT">الشحنات</span></th>
                                        <th>التاريخ</th>
                                        <th>العميل</th>
                                        <th>العدد</th>
                                        <th>المرتجع</th>
                                        <th>السعر</th>
                                        <th>الشحن</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($product->shipments as $shipment)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{optional($shipment->shipment)->created_at}}</td>
                                                <td>{{$shipment->client_name}}</td>
                                                <td>{{$shipment->qty}}</td>
                                                <td>{{$shipment->returned_qty}}</td>
                                                <td>{{$shipment->price}}</td>
                                                <td>{{$shipment->shipping_cost}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">@lang('front.orders')</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered dataTableTT">
                                    <thead>
                                    <tr>
                                        <th>#<span class="hide boxTiT">@lang('front.orders')</span></th>
                                        <th>@lang('front.date')</th>
                                        <th>@lang('front.client')</th>
                                        <th>المخزن</th>
                                        <th>@lang('front.quantity')</th>
                                        <th>@lang('front.price')</th>
                                        <th>@lang('front.total')</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    @php $total = 0 @endphp
                                    @foreach($product->orders as $order)
                                        <tr>
                                            @php
                                                $unit = $order->qty*$order->price;
                                                $total += $unit;
                                            @endphp
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$order->invoice->invoice_date}}</td>
                                            <td>{{optional(optional($order->invoice)->client)->name}}</td>
                                            <td>{{$order->store_name}}</td>
                                            <td>{{$order->qty}}</td>
                                            <td>{{$order->price}}</td>
                                            <td>{{$unit}}</td>
                                            <td>
                                                <a data-toggle="modal" data-target="#addPersonModal" class="btn btn-warning" href="{{route('orders.show',$order->order_id)}}"><i class="fa fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tfoot>
                                    <tr class="danger">
                                        <td colspan="5"></td>
                                        <td>{{$product->orders()->sum('qty')}}</td>
                                        <td></td>
                                        <td>{{$total}}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

            <div class="col-md-12">
                <div class="box box-info collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">@lang('front.purchases')</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table style="width: 100%;" class="table table-bordered dataTableTT">
                                    <thead>
                                    <tr>
                                        <th>#<span class="hide boxTiT">@lang('front.purchases')</span></th>
                                        <th>@lang('front.date')</th>
                                        <th>@lang('front.supplier')</th>
                                        <th>المخزن</th>
                                        <th>@lang('front.quantity')</th>
                                        <th>@lang('front.price')</th>
                                        <th>@lang('front.total')</th>
                                    </tr>
                                    </thead>
                                    @php $total = 0 @endphp
                                    @foreach($product->purchases as $order)
                                        <tr>
                                            @php
                                                $unit = $order->qty*$order->price;
                                                $total += $unit;
                                            @endphp
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$order->invoice->invoice_date}}</td>
                                            <td>{{optional($order->invoice->client)->name}}</td>
                                            <td>{{$order->store_name}}</td>
                                            <td>{{$order->qty}}</td>
                                            <td>{{$order->price}}</td>
                                            <td>{{$unit}}</td>
                                        </tr>
                                    @endforeach
                                    <tfoot>
                                    <tr class="danger">
                                        <td colspan="3"></td>
                                        <td>{{$product->purchases()->sum('qty')}}</td>
                                        <td></td>
                                        <td>{{$total}}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

            <div class="col-md-12">
                <div class="box box-danger collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">@lang('front.ordersreturns')</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="display: none;">
                        <div class="row">
                            <div class="col-md-12">
                                <table style="width: 100%;" class="table table-bordered dataTableTT">
                                    <thead>
                                    <tr>
                                        <th>#<span class="hide boxTiT">@lang('front.ordersreturns')</span></th>
                                        <th>@lang('front.date')</th>
                                        <th>@lang('front.client')</th>
                                        <th>@lang('front.store')</th>
                                        <th>@lang('front.quantity')</th>
                                        <th>@lang('front.unit')</th>
                                        <th>@lang('front.price')</th>
                                        <th>@lang('front.total')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach($product->ordersreturn as $item)

                                        @php
                                            $subtotal = $item->qty*$item->price;
                                            $total += $subtotal;
                                        @endphp
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->returns->return_date}}</td>
                                            <td>{{optional($item->returns->client)->name}}</td>
                                            <td>{{$item->store_name}}</td>
                                            <td>{{$item->qty}}</td>
                                            <td>{{$item->unit_name}}</td>
                                            <td>{{$item->price}}</td>
                                            <td>{{$subtotal}}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot>
                                    <tr class="bg-danger">
                                        <td colspan="4">@lang('front.total')</td>
                                        <td colspan="4">{{$product->ordersreturn()->sum('qty')}}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="box box-warning collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">@lang('front.purchasereturns')</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" >
                        <div class="row">
                            <div class="col-md-12">
                                <table style="width: 100%;"  class="table table-bordered dataTableTT">
                                    <thead>
                                    <tr>
                                        <th>#<span class="hide boxTiT">@lang('front.purchasereturns')</span></th>
                                        <th>@lang('front.date')</th>
                                        <th>@lang('front.supplier')</th>
                                        <th>@lang('front.store')</th>
                                        <th>@lang('front.quantity')</th>
                                        <th>@lang('front.unit')</th>
                                        <th>@lang('front.price')</th>
                                        <th>@lang('front.total')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach($product->purchasesreturn as $item)

                                        @php
                                            $subtotal = $item->qty*$item->price;
                                            $total += $subtotal;
                                        @endphp
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->returns->return_date}}</td>
                                            <td>{{optional($item->returns->client)->name}}</td>
                                            <td>{{$item->store_name}}</td>
                                            <td>{{$item->qty}}</td>
                                            <td>{{$item->unit_name}}</td>
                                            <td>{{$item->price}}</td>
                                            <td>{{$subtotal}}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot>
                                    <tr class="bg-danger">
                                        <td colspan="4">@lang('front.total')</td>
                                        <td colspan="4">{{$product->purchasesreturn()->sum('qty')}}</td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @if($product->workorder)
                <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">أوامر التصنيع</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered dataTableTT">
                                    <thead>
                                    <tr>
                                        <th>#<span class="hide boxTiT">أوامر التصنيع</span></th>
                                        <th>التاريخ</th>
                                        <th>اسم الصنف</th>
                                        <th>الكمية</th>
                                        <th class="hide"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $workorders = $product->workorder;
                                        @endphp
                                        @foreach($workorders as $item)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$item->date}}</td>
                                                <td>{{$item->product_name}}</td>
                                                <td>{{$item->itemqty}}</td>
                                                <td class="hide"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                     <tfoot>
                                        <tr class="bg-danger">
                                            <td colspan="3">الإجمالى</td>
                                            <td>{{$workorders->sum('itemqty')}}</td>
                                            <td class="hide"></td>

                                        </tr>
                                     </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
                </div>
            </div>
    </section>
@stop

@push('css')
    <style>

        .progress-bar,.badge{
            width: 100%;
        }
        .badge {
            width: 100%;
            padding: 5px;
        }
        @media print {
            .btn,.dataTables_filter ,.dataTables_length,.dataTables_info {
                display: none;
            }
            table,.badge {
                font-size: 18px !important;
                color: #0c0c0c!important;
            }

            .printHeader{
                display: block!important;
            }

        }
    </style>
@endpush
