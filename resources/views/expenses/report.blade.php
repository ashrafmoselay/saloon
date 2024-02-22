@extends('layouts.app')
@section('title','المصروفات')
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.expenses')
			<a data-toggle="modal" data-target="#myModal" class="btn btn-success pull-right" href="{{route('expenses.create')}}" ><i class="fa fa-plus"></i> @lang('front.Add')</a>
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
                @include('layouts.partial.filter')
				{{-- <div class="box-header">
                     <h3 class="box-title">Data Table With Full Features</h3>
                 </div>--}}
				<!-- /.box-header -->
					<div class="box-body">

						<table id="dataList" class="table table-bordered table-striped">
							<thead>
							<tr>
								<th>#</th>
								<th>@lang('front.title')</th>
                                <th>المجموعه</th>
								<th>قبل الضريبة</th>
								<th>قيمة الضريبة</th>
								<th>بعد الضريبة</th>
								<th>نوع المصروف</th>
								<th>التاريخ</th>
								<th class="no-sort"></th>
							</tr>
							</thead>
							<tbody>
							@foreach($list as $exp)
								<tr>
									<td>{{$loop->iteration}}</td>
                                    <td>{{$exp->note}}</td>
                                    <td>{{optional($exp->type)->name}}</td>
									<td>{{currency($exp->value_before_tax,"EGP","EGP", $format = true)}}</td>
									<td>{{currency($exp->tax_value,"EGP","EGP", $format = true)}}</td>
									<td>{{currency($exp->value,"EGP","EGP", $format = true)}}</td>
									<td>{{$exp->partner_id?optional($exp->partner)->name:(($exp->employee_id)?optional($exp->employee)->name:'مصروف عام')}}</td>
									<td>{{$exp->created_at->format('Y-m-d')}}</td>
									<td class="actions">
										<a data-toggle="modal" data-target="#myModal" href="{{route('expenses.edit',$exp)}}" class="btn btn-primary btn-xs">
											<i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
											@lang('front.edit')
										</a>
										<a class="btn btn-xs btn-danger remove-record" data-toggle="modal" data-url="{{ route('expenses.destroy',$exp)  }}" data-id="{{$exp->id}}" data-target="#custom-width-modal">
											<i class="fa fa-trash"></i>
											@lang('front.delete')
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
