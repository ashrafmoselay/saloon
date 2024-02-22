@extends('layouts.app')
@section('title','تقرير المناطق')
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
            تقرير المناطق
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
		@include('layouts.partial.filter')
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
				{{-- <div class="box-header">
                     <h3 class="box-title">Data Table With Full Features</h3>
                 </div>--}}
				<!-- /.box-header -->
					<div class="box-body">
						<table id="dataList" class="table table-bordered">
							<thead>
							<tr>
								<th>#</th>
								<th>اسم الصنف</th>
								<th>المنطقة</th>
								<th>عدد المبيعات</th>
								<th class="no-sort"></th>
							</tr>
							</thead>
							<tbody>
							@foreach($data as $item)
								<tr>
									<td>{{$loop->iteration}}</td>
                                    <td>{{$item->product_name}}</td>
                                    <td>{{$item->name}}</td>
									<td>{{$item->totalSales}}</td>
									<td></td>
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
