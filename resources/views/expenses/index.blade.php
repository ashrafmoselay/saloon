@extends('layouts.app')
@section('title',trans('front.expenses'))
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
						<table class="table table-bordered">
							<thead>
							<tr>
								<th>@lang('front.Expense Type')</th>
								<th>@lang('front.total')</th>
							</tr>
							</thead>
							<tbody>
							@php
								$grand = 0;
							@endphp
							@foreach($expenses as $exp)
								@php
									$grand += $exp->total;
								@endphp
							<tr>
								<td>{{$exp->name}}</td>
								<td><a href="{{route('expenses.index',['type'=>$exp->id])}}" class="">{{$exp->total}}</a></td>
							</tr>
							@endforeach
							</tbody>
							<tfoot>
							<tr>
								<td>@lang('front.Total Of Expenses')</td>
								<td><a href="{{route('expenses.index',['type'=>'all'])}}" class="btn btn-primary btn-block">{{$grand}}</a></td>
							</tr>
							</tfoot>
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
