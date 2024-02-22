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
    @php
        $list = $shipment->details->groupBy('client_mobile');
    @endphp
    @foreach($list as $n=>$details)
        <div class="box" style="border: none;">
            <div class="box-body" style="max-width: 290mm!important;">
                @include('shipments._header')
                <div style="margin-top: 30px;margin-bottom: 15px;" class="row">
                    <div class="col-md-12">
                    <span>
                        <b>رقم الشحنة: {{$shipment->id}} / {{$loop->iteration}} </b>
                    </span>
                        <span class="shipinfo">
                        <b>الإسم: {{$details->first()->client_name}} </b>
                    </span>
                    <span class="shipinfo">
                        <b> الموبيل: {{$details->first()->client_mobile}} </b>
                    </span>
                        <span class="shipinfo">
                    <b> العنوان: {{$details->first()->client_address}}</b>
                    </span>
                        <span class="shipinfo">
                    <b> المتابعة: {{$shipment->follow_up_mobile}}</b>
                    </span>
                </div>
                </div>
                <div class="row">
            <div class="col-md-12">
                <div id="printInvoice" class="box" style="border: none;">
                    <div class="box-body" style="max-width: 290mm!important;">
                        <div  class="text-center">
                            <table class="table table-bordered table-responsive">
                                <thead>
                                <tr style=" background: #5d7e8e; color: #ffffff;">
                                    <th>الصنف</th>
                                    <td>اللون</td>
                                    <th>العدد</th>
                                    <th>السعر</th>
                                    <th>الشحن</th>
                                    <th>ملحوظة</th>
                                    <th>الإجمالى</th>
                                </tr>
                                </thead>
                                <tbody id="invoiceTable">
                                @php
                                    $tt=0;
                                @endphp
                                @foreach($details as $k=>$prod)
                                    @php
                                        $tt += $prod->total;
                                    @endphp
                                    <tr>
                                    <td>{{optional($prod->product)->name}}</td>
                                    <td>{{$prod->color}}</td>
                                    <td>{{$prod->qty-$prod->returned_qty}}</td>
                                    <td>{{$prod->price}}</td>
                                    @if($k==0)
                                        <td style="vertical-align: middle;font-weight: bold;" rowspan="{{count($details)}}">{{$prod->shipping_cost}}</td>
                                    @endif
                                    <td>{{$prod->note}}</td>
                                    <td>{{$prod->total-$prod->shipping_cost}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tr>
                                    <td style="text-align: right;" colspan="6"></td>
                                    <td style="font-weight: bold;">
                                        الإجمالى: {{$tt}} {{currency()->getCurrency()['symbol']??'ج.م'}}
                                        <br/>
                                        <b>شامل تكلفة الشحن</b>
                                    </td>
                                </tr>
                            </table>
                            <div class="clearfix"></div>
                            <div style="direction: rtl;margin-top: 5px;" class="col-md-12">
                                {!! $settings['InvoiceNotes'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>
        <hr/>
        @if($loop->iteration%2==0)
            <div class="breakNow"></div>
        @endif
    @endforeach
    <!-- /.row -->
</section>
@stop
@push('css')
    <style>

        .table thead tr>td,.table tbody tr>td  {
            font-size: {{$settings['PrintSize']}}px!important;
            font-weight: bold!important;
        }
        div.breakNow { page-break-inside:avoid; page-break-after:always; }
        span b{
            border-bottom: 1px dashed #000;
        }
        .shipinfo{
            margin-right: 30px;
        }
        #printInvoice .table tr>td,tr>th{
            text-align: center;
            border:1px solid #000!important;
        }
        #printInvoice .table thead tr>td,.table thead tr>th{
            font-weight: bold;
        }
        @media print {

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

                .table thead tr>td,.table tbody tr>td  {
                    font-size: {{$settings['PrintSize']}}px!important;
                    font-weight: bold!important;
                }
                @page { margin: .1cm; }
                body { margin: .1cm;}
                .panel-default{
                    border: none;
                }
                .hideprint{
                    visibility:hidden;
                    margin:0;
                    display: none !important;
                }
            }

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

