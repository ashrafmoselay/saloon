@extends('layouts.app')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.currencies')
			<a data-toggle="modal" data-target="#myModal" class="btn btn-success pull-right" href="{{route('currencies.create')}}" ><i class="fa fa-plus"></i> @lang('front.Add')</a>
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
								<th>#</th>
								<th>@lang('front.name')</th>
								{{-- <th>@lang('front.code')</th> --}}
								<th>@lang('front.symbol')</th>
								<th>@lang('front.format')</th>
								<th>@lang('front.exchange rate')</th>
								<th>@lang('front.status')</th>
								<th class="no-sort"></th>
							</tr>
							</thead>
							<tbody>
							@foreach($currencies as $key=>$currency)
								<tr>
									<td>{{$loop->iteration}}</td>
									<td>{{$currency['name']}}</td>
									{{-- <td>{{$currency['code']}}</td> --}}
									<td>{{$currency['symbol']}}</td>
									<td>{{$currency['format']}}</td>
									<td>{{1/$currency['exchange_rate']}}</td>
									<td>{{$currency['active']==1?trans('front.active'):trans('front.notactive')}}</td>

									<td class="actions">
										<a data-toggle="modal" data-target="#myModal" href="{{route('currencies.edit',$currency['id'])}}" class="btn btn-primary btn-xs">
											<i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
											@lang('front.edit')
										</a>
                                        @if(!$loop->first)
										<a class="btn btn-xs btn-danger remove-record" data-url="{{ route('currencies.destroy',$currency['id'])  }}">
											<i class="fa fa-trash"></i>
											@lang('front.delete')
										</a>
                                        @endif
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

	<div id="myModal" class="modal fade" style="overflow:hidden;" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<p class="text-center"><div class="fa-3x text-center"><i class="fa fa-cog fa-spin"></i>                    @lang('front.Loading ....')                </div>                </p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">إغلاق</button>
				</div>
			</div>
		</div>
	</div>
@endsection
