@extends('layouts.app')
@section('title',trans('front.damages'))
@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@lang('front.damages')
			<a class="btn btn-success pull-right" href="{{route('damages.create')}}" ><i class="fa fa-plus"></i> @lang('front.Add')</a>
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

                        <table id="dataList" class="table table-responsive table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('front.date')</th>
                                <th>المسئول</th>
                                <th>السبب</th>
                                <th>ملحوظة</th>
                                <th>@lang('front.product')</th>
                                <th>@lang('front.store')</th>
                                <th>@lang('front.quantity')</th>
                                <th>@lang('front.unit')</th>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($damages as $item )
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$item->created_at->format('Y-m-d')}}</td>
                                            <td>{{optional($item->creator)->name}}</td>
                                            <td>{{optional($item->damageoption)->name}}</td>
                                            <td>{{ $item->note }}</td>
                                            <td>{{optional($item->product)->name}}</td>
                                            <td>{{optional($item->store)->name}}</td>
                                            <td>{{$item->qty}}</td>
                                            <td>{{optional($item->unit)->name}}</td>
                                            <td>
                                                <a href="{{route('damages.edit',$item)}}" class="btn btn-primary btn-xs">
                                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i>
                                                </a>
                                                <a class="btn btn-xs btn-danger remove-record" data-url="{{ route('damages.destroy',$item)  }}" data-id="{{$item->id}}">
                                                    <i class="fa fa-trash"></i>
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
