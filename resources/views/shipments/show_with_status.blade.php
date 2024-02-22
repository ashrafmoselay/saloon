@extends('layouts.app')
@section('content')
<section class="content-header hideprint">
    <h1>
       تفاصيل الشحنة
        <small>
            {{$shipment->id}}
        </small>
        <a class="btn print-window pull-right" href="javascript:void(0)" onclick="window.print();" role="button">
            <i class="fa fa-print" aria-hidden="true"></i> طباعة
        </a>
        <button id="pdf-button" class="btn btn-success print-window pull-right"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> تحميل PDF</button>
    </h1>
</section>
<!-- Main content -->
<section class="invoice content">
    <div class="box" style="border: none;">
        <div class="box-body" style="max-width: 290mm!important;">
            <!-- title row -->
            @include('shipments._header')
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-md-5 invoice-col">
                    <b> رقم الشحنة: {{$shipment->id}}</b>
                </div>
                <div class="col-md-3 invoice-col">
                    <b>شركة الشحن: {{$shipment->shipping_office}}</b>
                </div>
                <div class="col-md-4 invoice-col pull-right">
                    <b>رقم المتابعة: {{$shipment->follow_up_mobile}}</b>
                </div>
                <!-- /.col -->
            </div>

            <div style="margin-top: 30px;margin-bottom: 15px;" class="row">
                <div class="col-md-12">
                    @php
                        $shipTotal = $shipment->total;
                        $totalShipping = $shipment->total_shipping;
                    @endphp
                    <span>
                        <b>الإجمالى: {{$shipTotal}} {{currency()->getCurrency()['symbol']??'ج.م'}}</b>
                    </span>
                    <span class="shipinfo">
                        <b> إجمالى الشحن: {{$totalShipping}} {{currency()->getCurrency()['symbol']??'ج.م'}}</b>
                    </span>
                    <span class="shipinfo">
                        <b> الصافى: {{$shipTotal - $totalShipping}} {{currency()->getCurrency()['symbol']??'ج.م'}}</b>
                    </span>
                    <span class="shipinfo">
                    <b> الكميات: {{$shipment->all_qty.' قطعة'}}</b>
                    </span>
                    <span class="shipinfo">
                        <b>  مستلم: {{$shipment->total_qty.' قطعة'}}</b>
                    </span>
                    <span class="shipinfo">
                        <b>المرتجع: {{$shipment->total_returned.' قطعة'}}</b>
                    </span>
                    <span class="shipinfo">
                        <b> تدوير: {{$shipment->total_reshipping.' قطعة'}}</b>
                    </span>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
            <div class="col-md-12">
                <div  class="text-center">
                            <table class="table table-bordered table-responsive addscrollbar">
                                <thead>
                                <tr style=" background: #5d7e8e; color: #ffffff;">
                                    <th>#</th>
                                    <th>العميل</th>
                                    <th>المحافظة</th>
                                    <th>الموبيل</th>
                                    <th>الصنف</th>
                                    <th>العدد</th>
                                    <th>المرتجع</th>
                                    <th>السعر</th>
                                    <th>الشحن</th>
                                    <th>الإجمالى</th>
                                    <th>الحالة</th>
                                    @if(isset($settings['use_two_shipping_cost'])&&$settings['use_two_shipping_cost']==0)
                                    <th>المندوب</th>
                                    <th>رقم المندوب</th>
                                    @endif
                                    <th>تفاصيل</th>
                                    <th class="shipmentCompany">الشركة</th>
                                </tr>
                                </thead>
                                @php
                                    $all = 0;
                                @endphp
                                <tbody id="invoiceTable">
                                    @foreach($shipment->details->groupBy('client_mobile') as $details)
                                        @php
                                            $i=$loop->iteration;
                                        @endphp
                                        @foreach($details as $k=>$prod)
                                            @php
                                                if(in_array($prod->status,["مستلم",'تفاوض'])){
                                                    $all += $prod->total;
                                                }
                                            @endphp
                                            <tr>
                                                @if($loop->iteration==1)
                                                    <td rowspan="{{count($details)}}">{{$i}}</td>
                                                    <td rowspan="{{count($details)}}">{{$prod->client_name}}</td>
                                                    <td rowspan="{{count($details)}}">{{$prod->client_address}}</td>
                                                    <td rowspan="{{count($details)}}">{{$prod->client_mobile}}</td>
                                                @endif
                                                <td>{{optional($prod->product)->name}}</td>
                                                <td>{{$prod->qty}}</td>
                                                <td>{{$prod->returned_qty}}</td>
                                                <td>{{$prod->price}}</td>
                                                <td>{{$prod->shipping_cost}}</td>
                                                <td>{{$prod->total}}</td>
                                                <td>{{$prod->status}}</td>
                                                @if(isset($settings['use_two_shipping_cost']) && $settings['use_two_shipping_cost']==0)
                                                    @if($loop->iteration==1)
                                                        <td rowspan="{{count($details)}}"></td>
                                                        <td rowspan="{{count($details)}}"></td>
                                                    @endif
                                                @endif
                                                <td>{{$prod->note}}</td>
                                                <td class="shipmentCompany">{{$prod->sender}}</td>
                                            </tr>
                                        @endforeach
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="9">إجمالى المستلم</td>
                                        <td>{{$all}}</td>
                                        <td colspan="{{isset($settings['show_shipment_company']) && $settings['show_shipment_company']==1?'5':'4'}}"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
            </div>
        </div>
        </div>
    </div>
</section>
@stop
@push('css')
    <style>
        .addscrollbar{
            display: block;
            overflow-x: auto;
            white-space: normal;
            word-wrap: break-word;
        }
        tr td{
            vertical-align: middle!important;
        }
        b{
            border-bottom: 1px dashed #000;
        }
        .shipinfo{
            margin-right: 10px;
        }
        .table tr>td,.table tr>th{
            text-align: center;
            border:1px solid #000!important;
            font-weight: bold;
        }
        #printInvoice .table thead tr>td,.table thead tr>th{
            font-weight: bold;
        }
        @media print {

            .addscrollbar{
                overflow-x: hidden;
                white-space: normal;
            }
            .printHeader{
                display: block!important;
            }
            a[href]:after {
                content: none !important;display: none !important;
            }
            .main-footer,.dt-buttons,.dataTables_filter{
                display: none ;display: none !important;
            }

            #footer{visibility: visible;display: none !important;}
            a{
                visibility:hidden;display: none !important;
            }
            .table {
                border: 1px solid black !important;
                font-weight: bold;
            }
            .table td,.table thead tr th {
                border: 1px solid black !important;
            }
            @media print {
                .printHeader{
                    display: block!important;
                }
                table  {
                    font-size: 13px !important;
                }
                @page
                {
                    size: auto;   /* auto is the initial value */

                    /* this affects the margin in the printer settings */
                    margin: 7mm 3mm 7mm 3mm;
                }
                body
                {
                    margin: 5mm;
                }
                .panel-default{
                    border: none;
                }
                .hideprint{
                    visibility:hidden;
                    margin:0;
                    display: none !important;
                }
            }

            /*html, body {
                height:100vh;
                width: 100vh;
                margin: 0px !important;
                padding-right: 5px !important;
                !*overflow: hidden;*!
            }
            @page{
                size: auto;
                height:auto;
                margin-left: 0cm;
                margin-right: 0px;
                margin-top: 0cm;
                margin-bottom: 0px;
                padding: 0cm!important;
            }*/
        }
</style>
@endpush

