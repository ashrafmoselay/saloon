@extends('layouts.app')
@section('title',trans('front.services'))
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.services')
			<a data-toggle="modal" data-target="#myModal" class="btn btn-success pull-right" href="{{route('services.create')}}" ><i class="fa fa-plus"></i> @lang('front.Add')</a>
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
				{{-- <div class="box-header">
                     <h3 class="box-title">Data Table With Full Features</h3>
                 </div>--}}
				<!-- /.box-header -->
					<div class="box-body">
						<table id="dataList" class="table table-bordered table-striped">
							<thead>
							<tr>
								<td>#</td>
								<th>@lang('front.name')</th>
								<th>@lang('front.saleprice')</th>
								<th>@lang('front.parent')</th>
								<th>@lang('front.child')</th>
								<th>@lang('front.code')</th>
								<th>@lang('front.notes')</th>
								<th class="no-sort"></th>
							</tr>
							</thead>
							<tbody>
							@foreach($services as $service)
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$service->name}}</td>
									<td>{{$service->last_cost}}</td>
									<td>{{optional($service->category)->name}}</td>
									<td>{{optional($service->subcategory)->name}}</td>
									<td>{{$service->code}}</td>
									<td>{{$service->note}}</td>
									<td class="actions">
										<a data-toggle="modal" data-target="#myModal" href="{{route('services.edit',['clientId'=>request('clientId'),'service'=>$service])}}" class="btn btn-primary btn-xs">
											<i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
											تعديل
										</a>
										<a class="btn btn-xs btn-danger remove-record"  data-url="{{ route('services.destroy',['clientId'=>request('clientId'),'service'=>$service])  }}" data-id="{{$service->id}}">
											<i class="fa fa-trash"></i>
											حذف
										</a>

									</td>
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
	<!-- Delete Model -->
	<div id="myModal" class="modal fade" style="overflow:hidden;" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<p>جارى التحميل ....</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">إغلاق</button>
				</div>
			</div>
		</div>
	</div>
@endsection
