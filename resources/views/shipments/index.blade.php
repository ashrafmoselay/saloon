@extends('layouts.app')
@section('title',trans('front.shipments'))
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.shipments')
			<a class="btn btn-success pull-right" href="{{route('shipments.create')}}" ><i class="fa fa-plus"></i> @lang('front.Add')</a>
            @if(auth()->user()->can('truncateShipments ShipmentsController'))
                <a class="btn btn-danger" href="{{route('shipments.truncateData')}}" ><i class="fa fa-trash"></i> مسح كل الشحنات</a>
            @endif
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
                    <div class="col-md-2">
                        <div class="form-group">
                            @php
                                $statusList = ['تأجيل','تم التسليم','لم يتم التسليم','معلقة'];
                            @endphp
                            <select id="shipping_status" name="shipping_status" class="form-control">
                                <option value="">--- الكل ---</option>
                                @foreach($statusList as $status)
                                    <option {{request('shipping_status')==$status?'selected':''}} value="{{$status}}">{{$status}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input value="{{request('id')}}" name="id" placeholder="كلمة البحث" type="text" autocomplete="off" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            @php
                                $prodStatusList = ['تأجيل','مرتجع','مستلم','تدوير','معلقة','تفاوض','مغلق','لا يرد'];
                            @endphp
                            <select multiple name="product_status[]" class="form-control select2">
                                <option {{is_array(request('product_status'))&&in_array('الكل',request('product_status'))?'selected':''}} value="الكل">الكل</option>
                                @foreach($prodStatusList as $status)
                                    <option {{is_array(request('product_status'))&&in_array($status,request('product_status'))?'selected':''}} value="{{$status}}">{{$status}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button  type="submit" class="btn btn-primary form-control"><i class="fa fa-search"></i> بحث</button>
                    </div>


                </form>
            </div>
        </div>
		<div class="row">
            <div class="col-xs-12">
				<div class="box">
					<div class="box-body">
                        <div class="col-md-12">
                            <div class="row">
                                @php
                                $cardClass = 'col-md-4 col-sm-6';
                                if(auth()->user()->can('profit HomeController')){
                                    $cardClass = 'col-md-3 col-sm-6';
                                }
                                @endphp
                                <div class="{{$cardClass}} col-xs-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-green"><i class="fa fa-cart-plus"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">المبيعات</span>
                                            <span style="width: 100%;margin-top: 5px;" class="info-box-number badge bg-green">
                            {{$result['totalSales']??0}} {{currency()->getCurrency()['symbol']??'ج.م'}}
                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <div class="{{$cardClass}} col-xs-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-yellow"><i class="fa fa-share-square-o"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">المرتجعات</span>
                                            <span style="width: 100%;margin-top: 5px;" class="info-box-number badge bg-yellow">
                            {{$result['totalReturn']??0}} قطعة
                        </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <div class="{{$cardClass}} col-xs-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-red"><i class="fa fa-truck"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">الشحن</span>
                                            <span style="width: 100%;margin-top: 5px;" class="info-box-number badge bg-red">
                                {{$result['totalShipping']??0}} {{currency()->getCurrency()['symbol']??'ج.م'}}
                            </span>
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <!-- fix for small devices only -->
                                <div class="clearfix visible-sm-block"></div>
                                @if(auth()->user()->can('profit HomeController'))
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text"></span>الأرباح
                                                <span style="width: 100%;margin-top: 5px;" class="info-box-number badge bg-aqua">
                                {{$result['totalProfit']??0}} {{currency()->getCurrency()['symbol']??'ج.م'}}
                            </span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                                    <!-- /.col -->
                                @endif
                            </div>
                        </div>
						<table class="table table-bordered table-striped">
							<thead>
							<tr>
								<td>#</td>
                                <th>المستخدم</th>
                                <th>رقم الشحنة</th>
                                <th>تاريخ الشحنة</th>
                                <th>مكتب الشحن</th>
                                <th>حالة الشحنة</th>
                                <th>إجمالى الشحنة</th>
                                <th>إجمالى الشحن</th>
								<th class="no-sort"></th>
							</tr>
							</thead>
							<tbody>
							@foreach($shipments as $shipment)
								<tr>
									<td>{{$loop->iteration}}</td>
                                    <td>{{optional($shipment->user)->name}}</td>
                                    <td>{{$shipment->id}}</td>
                                    <td>{{$shipment->date_ar}}</td>
                                    <td>{{$shipment->shipping_office}}</td>
                                    <td>{{$shipment->shipping_status}}</td>
                                    <td>{{$shipment->total}}</td>
                                    <td>{{$shipment->total_shipping}}</td>
									<td class="actions">
										<a href="{{route('shipments.edit',$shipment)}}" class="btn btn-primary btn-xs">
											<i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
											@lang('front.edit')
										</a>
                                        <a href="{{route('shipments.show',$shipment)}}" class="btn btn-warning btn-xs">
                                            <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
                                            التفاصيل
                                        </a>
                                        <a data-toggle="modal" data-target="#myModal" href="{{route('shipments.updateShipping',$shipment)}}" class="btn btn-success btn-xs">
                                            <i class="fa fa-truck" aria-hidden="true"></i>
                                            الشحن
                                        </a>
                                        <a href="{{route('shipments.invoices',$shipment)}}" class="btn btn-info btn-xs">
                                            <i class="fa fa-file fa-fw" aria-hidden="true"></i>
                                            الفواتير
                                        </a>
										<a class="btn btn-xs btn-danger remove-record"  data-url="{{ route('shipments.destroy',$shipment)  }}" data-id="{{$shipment->id}}">
											<i class="fa fa-trash"></i>
											@lang('front.delete')
										</a>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
                    <div class="box-footer text-center">
                        {{$shipments->render()}}
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
        .info-box {
            background: #ecf0f5;
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
