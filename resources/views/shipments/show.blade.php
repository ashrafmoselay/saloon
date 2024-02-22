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
                        $totalReturnShipping = 0;
                        if(isset($settings['show_shipment_company']) && $settings['show_shipment_company']==1){
                            $totalReturnShipping = $shipment->total_fee;
                        }
                    @endphp
                    <span class="shipinfo">
                        <b>الإجمالى: {{$shipTotal}} {{currency()->getCurrency()['symbol']??'ج.م'}}</b>
                    </span>
                    <span class="shipinfo">
                        <b> إجمالى الشحن: {{$totalShipping}} {{currency()->getCurrency()['symbol']??'ج.م'}}</b>
                    </span>
                    <span class="shipinfo">
                        <b> الصافى: {{$shipTotal - $totalShipping - $totalReturnShipping}} {{currency()->getCurrency()['symbol']??'ج.م'}}</b>
                    </span>
                    <span class="shipinfo">
                    <b> الكميات: {{$shipment->all_qty.' ق'}}</b>
                    </span>
                    <span class="shipinfo">
                        <b>  مستلم: {{$shipment->total_qty.' ق'}}</b>
                    </span>
                    <span class="shipinfo">
                        <b>المرتجع: {{$shipment->total_returned.' ق'}}</b>
                    </span>
                    <span class="shipinfo">
                        <b> تدوير: {{$shipment->total_reshipping.' ق'}}</b>
                    </span>
                    <span class="shipinfo">
                        <b> تأجيل: {{$shipment->total_postponed.' ق'}}</b>
                    </span>
                </div>
            </div>
            <!-- /.row -->
            <div class="row" style="text-align: center!important;">
                <div class="col-md-12">
                    <table style="border: none!important;width: 100%;table-layout: fixed;min-width: 250mm;" class="table table-bordered table-responsive addscrollbar">
                            <thead>
                            <tr style=" background: #5d7e8e; color: #ffffff;">
                                <th>#</th>
                                <th>العميل</th>
                                <th>المحافظة</th>
                                <th>الموبيل</th>
                                <th>التفاصيل</th>
                                <th>الحالة</th>
                                <th>ملحوظة</th>
                                <th class="shipmentCompany">الشركة</th>
                                <th class="shipmentCompany">غرامة</th>
                            </tr>
                            </thead>
                            @php
                                $all = 0;
                                $list = [];
                            @endphp
                            <tbody id="invoiceTable">
                            @foreach($shipment->details->groupBy('client_mobile') as $details)
                                @php
                                    $i=$loop->iteration;
                                    $groupwithsum = [];
                                    $groups = $details->groupBy('product_id');
                                    $groupwithsum = $groups->map(function ($group) {

                                        return [
                                            'qty' => $group->sum('qty'),
                                            'returned_qty' => $group->sum('returned_qty'),
                                            'price' => $group->max('price'),
                                            'shipping_cost' => $group->max('shipping_cost'),
                                            'total' => $group->sum('total'),
                                        ];
                                    });
                                    $note = "";
                                    foreach($details as $k=>$prod){
                                            if($prod->note)
                                                $note = $prod->note;
                                            $list[$prod->client_mobile]['client'] = [
                                                'name'=>$prod->client_name,
                                                'mobile'=>$prod->client_mobile,
                                                'address'=>$prod->client_address,
                                                'note'=>$note,
                                                'sender'=>$prod->sender,
                                                'fee'=>$prod->fee,
                                            ];

                                        $kk = $prod->product_id;
                                        if(!isset($list[$prod->client_mobile]['details'][$kk])){
                                            $list[$prod->client_mobile]['details'][$kk]=[
                                                'product_id'=>$prod->product_id,
                                                'pname'=>optional($prod->product)->name,
                                                'qty'=>$groupwithsum[$prod->product_id]['qty'],
                                                'price'=>$groupwithsum[$prod->product_id]['price'],
                                                'returned_qty'=>$groupwithsum[$prod->product_id]['returned_qty'],
                                                'shipping_cost'=>$groupwithsum[$prod->product_id]['shipping_cost'],
                                                'total' => $groupwithsum[$prod->product_id]['total'],
                                            ];
                                        }
                                        $list[$prod->client_mobile]['status'][]=$prod->status;

                                    }
                                @endphp
                            @endforeach

                            @foreach($list as $row)
                                @php
                                    $count = count($row['details']);
                                @endphp
                                <tr>
                                    <td> {{$loop->iteration}}</td>
                                    <td>{{$row['client']['name']}}</td>
                                    <td>{{$row['client']['address']}}</td>
                                    <td>{{$row['client']['mobile']}}</td>
                                    <td>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td>الصنف</td>
                                                    <td>العدد</td>
                                                    <td>المرتجع</td>
                                                    <td>سعر القطعة</td>
                                                    <td>الشحن</td>
                                                    <td>الإجمالى</td>
                                                </tr>
                                            </thead>
                                            @foreach($row['details'] as $det)
                                                <tr>
                                                    <td>{{$det['pname']}}</td>
                                                    <td>{{$det['qty']}}</td>
                                                    <td>{{$det['returned_qty']}}</td>
                                                    <td>{{$det['price']}}</td>
                                                    <td>{{$det['shipping_cost']}}</td>
                                                    <td>{{$det['total']}}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                    <td>
                                        <table class="table table-bordered">
                                            @foreach($row['status'] as $status)
                                                <tr>
                                                    <td>{{$status}}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                    <td>{{$row['client']['note']}}</td>
                                    <td class="shipmentCompany">{{$row['client']['sender']}}</td>
                                    <td class="shipmentCompany">{{$row['client']['fee']}}</td>
                                </tr>
                            @endforeach
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
     .table tr>td,.table tr>th  {
            font-size: {{$settings['PrintSize']}}px!important;
        }
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
            margin: 5px;
        }
        .shipinfo{
            border: 1px solid #000;
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
                    font-size: {{$settings['PrintSize']}}px!important;
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

