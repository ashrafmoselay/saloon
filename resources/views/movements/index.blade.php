@extends('layouts.app')
@section('title',trans('front.movements'))
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.movements')
			<a class="btn btn-success pull-right" href="{{route('movements.create')}}" ><i class="fa fa-plus"></i> @lang('front.Add')</a>
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
                                <th>المستخدم</th>
                                <th>@lang('front.title')</th>
                                <th>@lang('front.date')</th>
                                <th>@lang('front.number of items')</th>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($movements as $item )
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{optional($item->creator)->name}}</td>
                                            <td>{{$item->note}}</td>
                                            <td>{{$item->created_at->format('Y-m-d')}}</td>
                                            <td>{{$item->detailes()->count()}}</td>
                                            <td>
                                                <a href="{{route('movements.edit',$item)}}" class="btn btn-primary btn-xs">
                                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{route('movements.show',$item)}}" class="btn btn-warning btn-xs">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i>
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
