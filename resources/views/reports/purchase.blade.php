@extends('layouts.app')
@section('title','تقرير المشتريات')
@section('content')
	<!-- Content Header (Page header) -->

	<section class="content-header">
		<h1>
			تقرير المشتريات
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3 id="totalOrder">0</h3>
                        <p>إجمالى المشتريات</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-blue"><i class="fa fa-money"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">@lang('front.cash')</span>
                        <span class="info-box-number cashOrders">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-credit-card"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">@lang('front.visa')</span>
                        <span class="info-box-number visaOrders">0</span>
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
                    <span class="info-box-icon bg-green"><i class="fa fa-calendar-check-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">@lang('front.Postpaid')</span>
                        <span class="info-box-number postPaidOrders">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-external-link"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">@lang('front.link transfer')</span>
                        <span class="info-box-number linkTransferOrders">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
				 <div class="box-header">
                     @include('layouts.partial.filter_order_report')
                 </div>
				<!-- /.box-header -->
					<div class="box-body">
						<table class="dataTableList table table-bordered table-striped">
							<thead>
								<tr>
									<th>@lang('front.invoicenumber')</th>
									<th>@lang('front.date')</th>
                                    <th>@lang('front.client')</th>
                                    <th>@lang('front.sale')</th>
                                    <th>@lang('front.price')</th>
									<th>@lang('front.payment')</th>
                                    <th>@lang('front.discount')</th>
                                    <th>إجمالي ق الضريبة</th>
                                    <th>قيمة الضريبة</th>
									<th>إجمالي بعد الضريبة</th>
									<th>@lang('front.paid')</th>
									<th>@lang('front.due')</th>
                                    {{--<th>الربح</th>--}}
								</tr>
							</thead>
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

	<div rel="flipInX" id="myModal" class="modal  modal-fullscreen" style="overflow-x:hidden;overflow-y: scroll;" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" >
			<div class="modal-content">
				<div class="modal-body">
					<p class="text-center"><div class="fa-3x text-center"><i class="fa fa-cog fa-spin"></i>                    @lang('front.Loading ....')                </div>                </p>
				</div>
			</div>
		</div>
	</div>


@endsection
@push('dataTableJs')
<script>
    var pageUrl = "{{route('purchase.report')}}?fromdate={{request('fromdate')}}";
	var columns= [
	{data: "invoice_number", name: "invoice_number"},
	{data: "invoice_date", name: "invoice_date"},
    {data: "clientname", name: "client.name"},
    {data: "saleperson", name: "saleMan.name"},
    {data: "priceType", name: "priceType"},
	{data: "payment_type", name: "payment_type", orderable: false, searchable: false},
    {data: "dicount_value", name: "dicount_value"},
    {data: "totalbefore", name: "totalbefore"},
    {data: "tax_value", name: "tax_value"},
    {data: "total", name: "total"},
	{data: "paid", name: "paid"},
	{data: "due", name: "due"},
    //{data: "profit", name: "profit"},
	];
</script>
@endpush
