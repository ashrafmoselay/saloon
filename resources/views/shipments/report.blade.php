@extends('layouts.app')
@section('title','تقرير الشحنات')
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			تقرير الشحنات
            <a class="btn print-window pull-right" href="javascript:void(0)" onclick="window.print();" role="button">
                <i class="fa fa-print" aria-hidden="true"></i> طباعة
            </a>
            <button id="pdf-button" class="btn btn-success print-window pull-right"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> تحميل PDF</button>
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
        <div class="row hideprint" style="margin-top: 10px;">
            <div class="col-md-12">
                <form action="" method="get">
                    @php
                        $colclass = isset($settings['show_shipment_company']) && $settings['show_shipment_company']==1?'col-md-2':'col-md-3';
                    @endphp
                    <div class="form-group col-md-2 shipmentCompany">
                        <select name="sender" data-ajax--url="{{route('companies.index')}}" data-ajax--cache="true" data-placeholder="الشركة" id="companyList"  class="form-control select2">
                            <option data-mobile="" value="">الشركة</option>
                            @foreach(\App\Company::get() as $reg)
                                <option {{$reg->id == request('sender')?'selected':''}} value="{{$reg->id}}">{{$reg->sender_name}} - {{$reg->sender_mobile}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="{{$colclass}}">
                        <div class="form-group ">
                            <input id="fromdate" placeholder="@lang('front.datefrom')" autocomplete="off" style="direction: rtl;" name="fromdate" value="{{request()->fromdate}}" type="text" class="form-control datepicker">
                        </div>
                    </div>
                    <div class="{{$colclass}}">
                        <div class="form-group">
                            <input id="todate" placeholder="@lang('front.dateto')" autocomplete="off" style="direction: rtl;" name="todate" value="{{request()->todate}}" type="text" class="form-control datepicker">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            @php
                                $prodStatusList = ['تأجيل','مرتجع','مستلم','تدوير','معلقة','تفاوض','مغلق','لا يرد'];
                            @endphp
                            <select name="product_status" class="form-control">
                                <option value="">--- الكل ---</option>
                                @foreach($prodStatusList as $status)
                                    <option {{request('product_status')==$status?'selected':''}} value="{{$status}}">{{$status}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            @php
                                $statusList = [25,50,100,150,200,500];
                            @endphp
                            <select name="per_page" class="form-control">
                                <option value="">--- الكل ---</option>
                                @foreach($statusList as $status)
                                    <option {{request('per_page')==$status?'selected':''}} value="{{$status}}">{{$status}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input value="{{request('id')}}" name="id" placeholder="كلمة البحث" type="text" autocomplete="off" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <select name="region_id" class="form-control select2" style="width: 100%;">
                                <option value="">كل المحافظات</option>
                                @foreach(\App\Region::get() as $region)
                                    <option  {{$region->id == request('region_id')?'selected':''}} value="{{$region->id}}">{{$region->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button  type="submit" class="btn btn-primary form-control">@lang('front.search')</button>
                    </div>


                </form>
            </div>
        </div>
		<div class="row">
            <div class="col-xs-12">
				<div class="box">
					<div class="box-body">

                        <table class="table table-bordered table-responsive addscrollbar">
                            <thead>
                            <tr style=" background: #5d7e8e; color: #ffffff;">
                                <th class="fit">#</th>
                                <th class="fit">العميل</th>
                                <th class="fit">المحافظة</th>
                                <th class="fit">الموبيل</th>
                                <th class="fit">الصنف</th>
                                <th class="fit">رقم الشحنة</th>
                                <th class="fit">العدد</th>
                                <th class="fit">المرتجع</th>
                                <th class="fit">السعر</th>
                                <th class="fit">المجموع</th>
                                <th class="fit">الشحن</th>
                                <th class="fit">الحالة</th>
                                <th class="fit">تفاصيل</th>
                                <th class="fit">التاريخ</th>
                                <th class="shipmentCompany">الشركة</th>
                                <th class="shipmentCompany">غرامه</th>


                            </tr>
                            </thead>
                            @php
                                $all = 0;
                                $shipTot = 0;
                                $total_return_shipping = 0;
                            @endphp
                            <tbody id="invoiceTable">
                            @foreach($shipments->groupBy('client_mobile') as $details)
                                @php

                                    $i=$loop->iteration;
                                @endphp
                                @foreach($details as $k=>$prod)
                                    @php
                                        $maxShip = $details->max('shipping_cost');
                                        if(in_array($prod->status,['مستلم','مرتجع','تفاوض'])){
                                            $all += $prod->total_without_shipping;
                                            $shipTot += $prod->shipping_cost;
                                        }
                                        if(isset($settings['show_shipment_company']) && $settings['show_shipment_company']==1){
                                            if(in_array($prod->status,['مرتجع'])){
                                                $total_return_shipping += $prod->fee;
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        @if($loop->iteration==1)
                                            <td rowspan="{{count($details)}}">{{$i}}</td>
                                            <td rowspan="{{count($details)}}">{{$prod->client_name}}</td>
                                            <td rowspan="{{count($details)}}">
                                                {{$prod->client_address}} / {{ optional($prod->region)->name }}</td>
                                            <td rowspan="{{count($details)}}">{{$prod->client_mobile}}</td>
                                        @endif
                                        <td>{{optional($prod->product)->name}}</td>
                                        <td>
                                            <a target="_blank" class="btn btn-warning" href="{{route('shipments.show',$prod->shipment_id)}}">{{$prod->shipment_id}}</a>
                                        </td>
                                        <td>{{$prod->qty}}</td>
                                        <td>{{$prod->returned_qty}}</td>
                                        <td>{{$prod->price}}</td>
                                        @php
                                            $sw = $prod->total_without_shipping;
                                            $shippng = $prod->shipping_cost;
                                            $gt = $sw + $shippng;
                                        @endphp
                                        <td>{{$sw}}</td>
                                        @if($loop->iteration==1)
                                        <td rowspan="{{count($details)}}">{{$maxShip}}</td>
                                        @endif
                                        <td>{{$prod->status}}</td>
                                        <td>{{$prod->note}}</td>
                                        <td>{{optional($prod->shipment)->date_ar}}</td>
                                        <td class="shipmentCompany">{{$prod->sender}}</td>
                                        <td class="shipmentCompany">{{$prod->fee}}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="9">إجمالى المستلم</td>
                                <td>{{$all - $total_return_shipping}}</td>
                                <td>{{$shipTot}}</td>
                                <td colspan="{{isset($settings['show_shipment_company']) && $settings['show_shipment_company']==1?'6':'5'}}"></td>
                                <td class="shipmentCompany"></td>
                            </tr>
                            </tfoot>
                        </table>
					</div>
                    <div class="box-footer text-center">
                        {{$shipments->appends($_GET)->links()}}
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
@push('js')
    <script>
        $('.datepicker').datepicker({
            autoclose: true,
            rtl: true,
            format: 'yyyy-mm-dd',
            language: "{{\Session::get('locale')}}",
        });
        $(".select2").select2({allowClear: true});
    </script>
@endpush
