@extends('layouts.app')
@section('title','تقرير الخدمات')
@section('content')
	<!-- Content Header (Page header) -->

	<section class="content-header">
		<h1>
			تقرير الخدمات
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
        <div class="row">
            <div class="col-lg-6 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 id="totalOrder">0</h3>
                        <p>إجمالي الحجوزات</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-6 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3 id="count">0</h3>
                        <p>عدد الحجوزات</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-cube"></i>
                    </div>
                </div>
            </div>
        </div>
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
				 <div class="box-header">
                    
                     @include('layouts.partial.filter_reservations_report')
                 </div>
				<!-- /.box-header -->
					<div class="box-body">
						<table class="dataTableList table table-bordered table-striped">
							<thead>
								<tr>
									<th>رقم الفاتورة</th>
									<th>تاريخ/وقت الحجز</th>
                                    <th>الموظف</th>
                                    <th>@lang('front.client')</th>
                                    <th>@lang('front.mobile')</th>
                                    <th>الخدمة</th>
                                    <th>السعر</th>
                                    <th>ملحوظة</th>
                                    <th>الحالة</th>
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


@endsection
@push('dataTableJs')
<script>
    var pageUrl = "{{route('reservations.report')}}";
	var columns= [
	{data: "invoice_number", name: "invoice_number"},
	{data: "date", name: "date"},
	{data: "empname", name: "empname"},
	{data: "clientname", name: "clientname"},
	{data: "clientmobile", name: "clientmobile"},
	{data: "servicename", name: "servicename"},
	{data: "price", name: "price"},
	{data: "comment", name: "comment"},
	{data: "status", name: "status"},
	];
    
</script>
@endpush
